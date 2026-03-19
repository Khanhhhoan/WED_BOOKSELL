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

            // 3. Lưu Mock Payment
            $this->db->query("INSERT INTO payments (order_id, method, status) VALUES (:order_id, :method, :payment_status)");
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':method', $data['payment_method']); // cod hoặc online
            
            // Giả lập online thành công luôn
            $status = ($data['payment_method'] == 'online') ? 'success' : 'pending';
            $this->db->bind(':payment_status', $status);
            $this->db->execute();

            return $orderId;
        }

        return false;
    }

    // Lấy danh sách lịch sử đơn hàng của 1 user
    public function getOrdersByUser($userId) {
        $this->db->query("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
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

    // [ADMIN] Lấy tất cả đơn hàng
    public function getAllOrders() {
        $this->db->query("SELECT o.*, u.full_name as user_name FROM orders o
                          JOIN users u ON o.user_id = u.id
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

    // [ADMIN] Lấy thông tin chung của đơn hàng
    public function getOrderByIdAdmin($orderId) {
        $this->db->query("SELECT o.*, u.full_name as user_name, u.email as user_email FROM orders o
                          JOIN users u ON o.user_id = u.id
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
}

