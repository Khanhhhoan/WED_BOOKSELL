<?php
/**
 * Model quản lý Log Thanh Toán SePay
 * Tương thích PHP 5.2
 */
class PaymentLogModel extends Model {

    /**
     * Ghi nhận một log giao dịch mới từ Webhook / API
     */
    public function logTransaction($data) {
        $this->db->query("INSERT INTO payment_logs 
            (order_id, gateway, transaction_date, account_number, sub_account, transfer_type, transfer_amount, accumulated, code, content, reference_code, description, status, raw_data)
            VALUES 
            (:order_id, :gateway, :transaction_date, :account_number, :sub_account, :transfer_type, :transfer_amount, :accumulated, :code, :content, :reference_code, :description, :status, :raw_data)");
        
        $orderId = (isset($data['order_id']) && $data['order_id']) ? $data['order_id'] : null;
        $gateway = isset($data['gateway']) ? $data['gateway'] : 'SePay';
        $transactionDate = isset($data['transaction_date']) ? $data['transaction_date'] : date('Y-m-d H:i:s');
        $accountNumber = isset($data['account_number']) ? $data['account_number'] : '';
        $subAccount = isset($data['sub_account']) ? $data['sub_account'] : '';
        $transferType = isset($data['transfer_type']) ? $data['transfer_type'] : 'in';
        $transferAmount = isset($data['transfer_amount']) ? $data['transfer_amount'] : 0;
        $accumulated = isset($data['accumulated']) ? $data['accumulated'] : 0;
        $code = isset($data['code']) ? $data['code'] : '';
        $content = isset($data['content']) ? $data['content'] : '';
        $referenceCode = isset($data['reference_code']) ? $data['reference_code'] : '';
        $description = isset($data['description']) ? $data['description'] : '';
        $status = isset($data['status']) ? $data['status'] : 'success';
        $rawData = isset($data['raw_data']) ? $data['raw_data'] : '';

        $this->db->bind(':order_id', $orderId);
        $this->db->bind(':gateway', $gateway);
        $this->db->bind(':transaction_date', $transactionDate);
        $this->db->bind(':account_number', $accountNumber);
        $this->db->bind(':sub_account', $subAccount);
        $this->db->bind(':transfer_type', $transferType);
        $this->db->bind(':transfer_amount', $transferAmount);
        $this->db->bind(':accumulated', $accumulated);
        $this->db->bind(':code', $code);
        $this->db->bind(':content', $content);
        $this->db->bind(':reference_code', $referenceCode);
        $this->db->bind(':description', $description);
        $this->db->bind(':status', $status);
        $this->db->bind(':raw_data', $rawData);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Lấy danh sách log thanh toán (phân trang + lọc trạng thái / từ khóa)
     */
    public function getLogs($page = 1, $limit = 20, $status = '', $keyword = '') {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT pl.*, o.shipping_name, o.shipping_phone, o.total_amount as order_amount, u.full_name as user_name
                FROM payment_logs pl
                LEFT JOIN orders o ON pl.order_id = o.id
                LEFT JOIN users u ON o.user_id = u.id
                WHERE 1=1";
        
        if (!empty($status)) {
            $sql .= " AND pl.status = :status";
        }
        if (!empty($keyword)) {
            $sql .= " AND (pl.reference_code LIKE :kw OR pl.content LIKE :kw OR pl.account_number LIKE :kw OR pl.order_id LIKE :kw)";
        }

        $sql .= " ORDER BY pl.id DESC LIMIT :limit OFFSET :offset";

        $this->db->query($sql);
        if (!empty($status)) {
            $this->db->bind(':status', $status);
        }
        if (!empty($keyword)) {
            $this->db->bind(':kw', '%' . $keyword . '%');
        }
        $this->db->bind(':limit', (int)$limit);
        $this->db->bind(':offset', (int)$offset);

        return $this->db->resultSet();
    }

    /**
     * Đếm tổng số logs theo bộ lọc
     */
    public function countLogs($status = '', $keyword = '') {
        $sql = "SELECT COUNT(*) as total FROM payment_logs pl WHERE 1=1";
        if (!empty($status)) {
            $sql .= " AND pl.status = :status";
        }
        if (!empty($keyword)) {
            $sql .= " AND (pl.reference_code LIKE :kw OR pl.content LIKE :kw OR pl.account_number LIKE :kw OR pl.order_id LIKE :kw)";
        }

        $this->db->query($sql);
        if (!empty($status)) {
            $this->db->bind(':status', $status);
        }
        if (!empty($keyword)) {
            $this->db->bind(':kw', '%' . $keyword . '%');
        }
        $row = $this->db->single();
        return $row ? (int)$row['total'] : 0;
    }

    /**
     * Lấy chi tiết 1 log thanh toán theo ID
     */
    public function getLogById($id) {
        $this->db->query("SELECT pl.*, o.shipping_name, o.shipping_phone, o.total_amount as order_amount, o.status as order_status, u.full_name as user_name, u.email as user_email
                          FROM payment_logs pl
                          LEFT JOIN orders o ON pl.order_id = o.id
                          LEFT JOIN users u ON o.user_id = u.id
                          WHERE pl.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Lấy các logs theo mã đơn hàng
     */
    public function getLogsByOrderId($orderId) {
        $this->db->query("SELECT * FROM payment_logs WHERE order_id = :order_id ORDER BY id DESC");
        $this->db->bind(':order_id', $orderId);
        return $this->db->resultSet();
    }

    /**
     * Kiểm tra giao dịch đã được xử lý thành công chưa (chống lặp Webhook)
     */
    public function isTransactionProcessed($referenceCode) {
        if (empty($referenceCode)) {
            return false;
        }
        $this->db->query("SELECT id FROM payment_logs WHERE reference_code = :ref AND status = 'success' LIMIT 1");
        $this->db->bind(':ref', $referenceCode);
        $row = $this->db->single();
        return !empty($row);
    }

    /**
     * Thống kê tổng hợp tình hình giao dịch SePay
     */
    public function getStats() {
        $this->db->query("SELECT 
            COUNT(*) as total_count,
            SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as success_count,
            SUM(CASE WHEN status = 'success' THEN transfer_amount ELSE 0 END) as total_amount_success,
            SUM(CASE WHEN status = 'unmatched' THEN 1 ELSE 0 END) as unmatched_count,
            SUM(CASE WHEN status = 'amount_mismatch' THEN 1 ELSE 0 END) as mismatch_count
            FROM payment_logs");
        $stats = $this->db->single();
        if (!$stats) {
            return array(
                'total_count' => 0,
                'success_count' => 0,
                'total_amount_success' => 0,
                'unmatched_count' => 0,
                'mismatch_count' => 0
            );
        }
        return $stats;
    }

    /**
     * Lấy toàn bộ settings SePay
     */
    public function getSepaySettings() {
        $this->db->query("SELECT setting_key, setting_value FROM sepay_settings");
        $rows = $this->db->resultSet();
        $settings = array();
        if ($rows && is_array($rows)) {
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        return $settings;
    }

    /**
     * Lưu / Cập nhật cấu hình SePay
     */
    public function saveSepaySettings($data) {
        foreach ($data as $key => $val) {
            $this->db->query("INSERT INTO sepay_settings (setting_key, setting_value) 
                              VALUES (:k, :v) 
                              ON DUPLICATE KEY UPDATE setting_value = :v_update");
            $this->db->bind(':k', $key);
            $this->db->bind(':v', $val);
            $this->db->bind(':v_update', $val);
            $this->db->execute();
        }
        return true;
    }

    /**
     * Gán thủ công một log 'unmatched' vào đơn hàng và đánh dấu thành công
     */
    public function linkLogToOrder($logId, $orderId) {
        $this->db->query("UPDATE payment_logs SET order_id = :order_id, status = 'success', description = CONCAT(IFNULL(description,''), ' [Admin gán thủ công]') WHERE id = :id");
        $this->db->bind(':order_id', $orderId);
        $this->db->bind(':id', $logId);
        return $this->db->execute();
    }
}
