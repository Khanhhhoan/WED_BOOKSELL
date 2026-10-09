<?php
class OrderModel extends Model {
    
    // Tạo đơn hàng mới
    public function createOrder($data) {
        // 1. Lưu vào bảng orders
        $this->db->query("INSERT INTO orders (user_id, total_amount, shipping_name, shipping_phone, shipping_address, status) 
                          VALUES (:user_id, :total_amount, :shipping_name, :shipping_phone, :shipping_address, 'pending')");
        
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':shipping_name', $data['shipping_name']);
        $this->db->bind(':shipping_phone', $data['shipping_phone']);
        $this->db->bind(':shipping_address', $data['shipping_address']);
        
        if ($this->db->execute()) {
            $orderId = $this->db->lastInsertId();

            // 2. Lưu vào bảng order_items
            foreach ($data['cart'] as $bookId => $item) {
                $this->db->query("INSERT INTO order_items (order_id, book_id, quantity, price) 
                                  VALUES (:order_id, :book_id, :quantity, :price)");
                $this->db->bind(':order_id', $orderId);
                $this->db->bind(':book_id', $bookId);
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':price', $item['price']);
                $this->db->execute();

                // Trừ stock sách (Tùy chọn)
                $this->db->query("UPDATE books SET stock = stock - :qty WHERE id = :id AND stock >= :qty");
                $this->db->bind(':qty', $item['quantity']);
                $this->db->bind(':id', $bookId);
                $this->db->execute();
            }

            // 3. Lưu thông tin thanh toán (COD hoặc SePay)
            $method = (isset($data['payment_method']) && ($data['payment_method'] === 'sepay' || $data['payment_method'] === 'online')) ? 'sepay' : 'cod';
            // SePay thật: trạng thái ban đầu luôn là 'pending', chỉ chuyển thành 'success' khi nhận Webhook hoặc xác nhận chuyển khoản
            $paymentStatus = 'pending';

            $this->db->query("INSERT INTO payments (order_id, method, status) VALUES (:order_id, :method, :payment_status)");
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':method', $method);
            $this->db->bind(':payment_status', $paymentStatus);
            $this->db->execute();

            return $orderId;
        }

        return false;
    }

    // Lấy thông tin thanh toán theo mã đơn hàng
    public function getPaymentByOrderId($orderId) {
        $this->db->query("SELECT * FROM payments WHERE order_id = :order_id LIMIT 1");
        $this->db->bind(':order_id', $orderId);
        return $this->db->single();
    }

    // Cập nhật trạng thái thanh toán và mã giao dịch
    public function updatePaymentStatus($orderId, $status, $transactionId = null) {
        if ($transactionId !== null) {
            $this->db->query("UPDATE payments SET status = :status, transaction_id = :transaction_id WHERE order_id = :order_id");
            $this->db->bind(':transaction_id', $transactionId);
        } else {
            $this->db->query("UPDATE payments SET status = :status WHERE order_id = :order_id");
        }
        $this->db->bind(':status', $status);
        $this->db->bind(':order_id', $orderId);
        return $this->db->execute();
    }

    // Xác nhận đơn hàng đã thanh toán thành công (qua SePay hoặc duyệt admin)
    public function confirmOrderPayment($orderId, $transactionId = null) {
        $this->updatePaymentStatus($orderId, 'success', $transactionId);
        // Tự động nâng trạng thái đơn từ pending lên confirmed
        $this->db->query("UPDATE orders SET status = 'confirmed' WHERE id = :id AND status = 'pending'");
        $this->db->bind(':id', $orderId);
        return $this->db->execute();
    }

    // Lấy danh sách lịch sử đơn hàng của 1 user (Kèm thông tin thanh toán)
    public function getOrdersByUser($userId) {
        $this->db->query("SELECT o.*, p.method as payment_method, p.status as payment_status, p.transaction_id as payment_transaction_id 
                          FROM orders o 
                          LEFT JOIN payments p ON p.order_id = o.id 
                          WHERE o.user_id = :user_id 
                          ORDER BY o.created_at DESC");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetails($orderId, $userId) {
        $this->db->query("SELECT oi.*, b.title, b.image FROM order_items oi 
                          JOIN books b ON oi.book_id = b.id 
                          JOIN orders o ON o.id = oi.order_id
                          WHERE oi.order_id = :order_id AND o.user_id = :user_id");
        $this->db->bind(':order_id', $orderId);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // [ADMIN] Lấy tất cả đơn hàng (Kèm thông tin thanh toán)
    public function getAllOrders() {
        $this->db->query("SELECT o.*, u.full_name as user_name, p.method as payment_method, p.status as payment_status, p.transaction_id as payment_transaction_id 
                          FROM orders o
                          JOIN users u ON o.user_id = u.id
                          LEFT JOIN payments p ON p.order_id = o.id
                          ORDER BY o.created_at DESC");
        return $this->db->resultSet();
    }

    // [ADMIN] Lấy chi tiết đơn hàng (Không cần user_id)
    public function getOrderDetailsAdmin($orderId) {
        $this->db->query("SELECT oi.*, b.title, b.image FROM order_items oi 
                          JOIN books b ON oi.book_id = b.id 
                          WHERE oi.order_id = :order_id");
        $this->db->bind(':order_id', $orderId);
        return $this->db->resultSet();
    }

    // [ADMIN] Lấy thông tin chung của đơn hàng (Kèm thông tin thanh toán chi tiết)
    public function getOrderByIdAdmin($orderId) {
        $this->db->query("SELECT o.*, u.full_name as user_name, u.email as user_email, 
                                 p.id as payment_id, p.method as payment_method, p.status as payment_status, 
                                 p.transaction_id as payment_transaction_id, p.created_at as payment_created_at
                          FROM orders o
                          JOIN users u ON o.user_id = u.id
                          LEFT JOIN payments p ON p.order_id = o.id
                          WHERE o.id = :id");
        $this->db->bind(':id', $orderId);
        return $this->db->single();
    }

    // [ADMIN] Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $status) {
        $this->db->query("UPDATE orders SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $orderId);
        return $this->db->execute();
    }

    // ==========================================
    // MODULE: THỐNG KÊ ĐƠN HÀNG (THÁNG, QUÝ, NĂM)
    // Tương thích PHP 5.2.6 & MySQL 5.0
    // ==========================================

    /**
     * Lấy điều kiện SQL theo trạng thái đơn hàng
     */
    private function buildStatusCondition($statusFilter) {
        if ($statusFilter === 'completed') {
            return "o.status = 'completed'";
        } elseif ($statusFilter === 'all') {
            return "1=1";
        } else {
            // Mặc định 'valid': đơn hàng hợp lệ (loại trừ đã hủy)
            return "o.status != 'cancelled'";
        }
    }

    /**
     * Lấy danh sách các năm có phát sinh đơn hàng
     */
    public function getAvailableOrderYears() {
        $this->db->query("SELECT DISTINCT YEAR(created_at) as order_year FROM orders ORDER BY order_year DESC");
        $rows = $this->db->resultSet();
        $years = array();
        if (!empty($rows)) {
            foreach ($rows as $r) {
                if (!empty($r['order_year'])) {
                    $years[] = (int)$r['order_year'];
                }
            }
        }
        $currentYear = (int)date('Y');
        if (!in_array($currentYear, $years)) {
            array_unshift($years, $currentYear);
        }
        return $years;
    }

    /**
     * Thống kê đơn hàng theo 12 Tháng của một năm cụ thể
     * - Số đơn hàng
     * - Số lượng sản phẩm bán ra
     * - Thành tiền (tổng doanh thu)
     */
    public function getMonthlyStatistics($year, $statusFilter = 'valid') {
        $statusCond = $this->buildStatusCondition($statusFilter);
        $year = (int)$year;

        $sql = "SELECT 
                    MONTH(o.created_at) as month_num,
                    COUNT(o.id) as total_orders,
                    COALESCE(SUM(oi_summary.total_qty), 0) as total_products,
                    COALESCE(SUM(o.total_amount), 0) as total_amount
                FROM orders o
                LEFT JOIN (
                    SELECT order_id, SUM(quantity) as total_qty 
                    FROM order_items 
                    GROUP BY order_id
                ) oi_summary ON o.id = oi_summary.order_id
                WHERE YEAR(o.created_at) = :year AND $statusCond
                GROUP BY MONTH(o.created_at)
                ORDER BY month_num ASC";

        $this->db->query($sql);
        $this->db->bind(':year', $year);
        $rows = $this->db->resultSet();

        $map = array();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $map[(int)$row['month_num']] = $row;
            }
        }

        $result = array();
        for ($m = 1; $m <= 12; $m++) {
            if (isset($map[$m])) {
                $orders = (int)$map[$m]['total_orders'];
                $products = (int)$map[$m]['total_products'];
                $amount = (float)$map[$m]['total_amount'];
            } else {
                $orders = 0;
                $products = 0;
                $amount = 0.0;
            }

            $avgOrderVal = ($orders > 0) ? ($amount / $orders) : 0.0;
            $avgItemsPerOrder = ($orders > 0) ? round($products / $orders, 1) : 0.0;

            $result[] = array(
                'month' => $m,
                'year' => $year,
                'month_label' => 'Tháng ' . $m,
                'total_orders' => $orders,
                'total_products' => $products,
                'total_amount' => $amount,
                'avg_order_value' => $avgOrderVal,
                'avg_items_per_order' => $avgItemsPerOrder
            );
        }

        return $result;
    }

    /**
     * Thống kê đơn hàng theo 4 Quý của một năm cụ thể
     * - Số đơn hàng
     * - Số lượng sản phẩm bán ra
     * - Thành tiền (tổng doanh thu)
     */
    public function getQuarterlyStatistics($year, $statusFilter = 'valid') {
        $statusCond = $this->buildStatusCondition($statusFilter);
        $year = (int)$year;

        $sql = "SELECT 
                    QUARTER(o.created_at) as quarter_num,
                    COUNT(o.id) as total_orders,
                    COALESCE(SUM(oi_summary.total_qty), 0) as total_products,
                    COALESCE(SUM(o.total_amount), 0) as total_amount
                FROM orders o
                LEFT JOIN (
                    SELECT order_id, SUM(quantity) as total_qty 
                    FROM order_items 
                    GROUP BY order_id
                ) oi_summary ON o.id = oi_summary.order_id
                WHERE YEAR(o.created_at) = :year AND $statusCond
                GROUP BY QUARTER(o.created_at)
                ORDER BY quarter_num ASC";

        $this->db->query($sql);
        $this->db->bind(':year', $year);
        $rows = $this->db->resultSet();

        $map = array();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $map[(int)$row['quarter_num']] = $row;
            }
        }

        $quarterMonths = array(
            1 => 'Tháng 1 - Tháng 3',
            2 => 'Tháng 4 - Tháng 6',
            3 => 'Tháng 7 - Tháng 9',
            4 => 'Tháng 10 - Tháng 12'
        );

        $result = array();
        for ($q = 1; $q <= 4; $q++) {
            if (isset($map[$q])) {
                $orders = (int)$map[$q]['total_orders'];
                $products = (int)$map[$q]['total_products'];
                $amount = (float)$map[$q]['total_amount'];
            } else {
                $orders = 0;
                $products = 0;
                $amount = 0.0;
            }

            $avgOrderVal = ($orders > 0) ? ($amount / $orders) : 0.0;
            $avgItemsPerOrder = ($orders > 0) ? round($products / $orders, 1) : 0.0;

            $result[] = array(
                'quarter' => $q,
                'year' => $year,
                'quarter_label' => 'Quý ' . $q,
                'months_label' => $quarterMonths[$q],
                'total_orders' => $orders,
                'total_products' => $products,
                'total_amount' => $amount,
                'avg_order_value' => $avgOrderVal,
                'avg_items_per_order' => $avgItemsPerOrder
            );
        }

        return $result;
    }

    /**
     * Thống kê đơn hàng theo từng Năm
     * - Số đơn hàng
     * - Số lượng sản phẩm bán ra
     * - Thành tiền (tổng doanh thu)
     * - Tăng trưởng doanh thu so với năm trước (%)
     */
    public function getYearlyStatistics($statusFilter = 'valid') {
        $statusCond = $this->buildStatusCondition($statusFilter);

        $sql = "SELECT 
                    YEAR(o.created_at) as year_num,
                    COUNT(o.id) as total_orders,
                    COALESCE(SUM(oi_summary.total_qty), 0) as total_products,
                    COALESCE(SUM(o.total_amount), 0) as total_amount
                FROM orders o
                LEFT JOIN (
                    SELECT order_id, SUM(quantity) as total_qty 
                    FROM order_items 
                    GROUP BY order_id
                ) oi_summary ON o.id = oi_summary.order_id
                WHERE $statusCond
                GROUP BY YEAR(o.created_at)
                ORDER BY year_num ASC";

        $this->db->query($sql);
        $rows = $this->db->resultSet();

        $result = array();
        $prevAmount = null;

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $y = (int)$row['year_num'];
                $orders = (int)$row['total_orders'];
                $products = (int)$row['total_products'];
                $amount = (float)$row['total_amount'];

                $avgOrderVal = ($orders > 0) ? ($amount / $orders) : 0.0;
                $avgItemsPerOrder = ($orders > 0) ? round($products / $orders, 1) : 0.0;

                $growth = null;
                if ($prevAmount !== null && $prevAmount > 0) {
                    $growth = round((($amount - $prevAmount) / $prevAmount) * 100, 1);
                }

                $result[] = array(
                    'year' => $y,
                    'year_label' => 'Năm ' . $y,
                    'total_orders' => $orders,
                    'total_products' => $products,
                    'total_amount' => $amount,
                    'avg_order_value' => $avgOrderVal,
                    'avg_items_per_order' => $avgItemsPerOrder,
                    'growth_rate' => $growth
                );

                $prevAmount = $amount;
            }
        }

        if (empty($result)) {
            $curYear = (int)date('Y');
            $result[] = array(
                'year' => $curYear,
                'year_label' => 'Năm ' . $curYear,
                'total_orders' => 0,
                'total_products' => 0,
                'total_amount' => 0.0,
                'avg_order_value' => 0.0,
                'avg_items_per_order' => 0.0,
                'growth_rate' => null
            );
        }

        return $result;
    }

    /**
     * Top sản phẩm bán chạy nhất theo chu kỳ được chọn
     */
    public function getTopSellingProductsByPeriod($tab, $year, $statusFilter = 'valid', $limit = 5) {
        $statusCond = $this->buildStatusCondition($statusFilter);
        $year = (int)$year;

        $where = array($statusCond);
        if ($tab === 'month' || $tab === 'quarter') {
            $where[] = "YEAR(o.created_at) = " . $year;
        }

        $whereClause = implode(' AND ', $where);

        $sql = "SELECT 
                    b.id, b.title, b.image, b.price,
                    c.name as category_name,
                    COALESCE(SUM(oi.quantity), 0) as total_sold,
                    COALESCE(SUM(oi.quantity * oi.price), 0) as total_revenue
                FROM order_items oi
                JOIN orders o ON oi.order_id = o.id
                JOIN books b ON oi.book_id = b.id
                LEFT JOIN categories c ON b.category_id = c.id
                WHERE $whereClause
                GROUP BY b.id
                ORDER BY total_sold DESC, total_revenue DESC
                LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Thống kê phương thức thanh toán trong kỳ
     */
    public function getPaymentMethodStatsByPeriod($tab, $year, $statusFilter = 'valid') {
        $statusCond = $this->buildStatusCondition($statusFilter);
        $year = (int)$year;

        $where = array($statusCond);
        if ($tab === 'month' || $tab === 'quarter') {
            $where[] = "YEAR(o.created_at) = " . $year;
        }
        $whereClause = implode(' AND ', $where);

        $sql = "SELECT 
                    COALESCE(p.method, 'cod') as payment_method,
                    COUNT(o.id) as total_orders,
                    COALESCE(SUM(o.total_amount), 0) as total_amount
                FROM orders o
                LEFT JOIN payments p ON p.order_id = o.id
                WHERE $whereClause
                GROUP BY COALESCE(p.method, 'cod')";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
}

