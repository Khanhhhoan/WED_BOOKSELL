<?php
class AdminModel extends Model {
    
    public function getDashboardStats() {
        $stats = array();
        
        // Tổng số đơn hàng
        $this->db->query("SELECT COUNT(*) as total FROM orders");
        $res1 = $this->db->single();
        $stats['total_orders'] = $res1['total'];

        // Tổng doanh thu (Chỉ tính đơn hàng đã hoàn thành)
        $this->db->query("SELECT SUM(total_amount) as revenue FROM orders WHERE status = 'completed'");
        $res2 = $this->db->single();
        $revenue = $res2['revenue'];
        $stats['total_revenue'] = $revenue ? $revenue : 0;

        // Tổng sách đang bán
        $this->db->query("SELECT COUNT(*) as total FROM books");
        $res3 = $this->db->single();
        $stats['total_books'] = $res3['total'];

        // Tổng người dùng
        $this->db->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'");
        $res4 = $this->db->single();
        $stats['total_users'] = $res4['total'];

        return $stats;
    }

    public function getRecentOrders($limit = 5) {
        $this->db->query("SELECT o.*, u.full_name as user_name FROM orders o
                          JOIN users u ON o.user_id = u.id
                          ORDER BY o.created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}

