<?php
class CategoryModel extends Model {
    
    // Lấy tất cả danh mục
    public function getAllCategories() {
        $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        return $this->db->resultSet();
    }

    // Lấy chi tiết danh mục theo ID
    public function getCategoryById($id) {
        $this->db->query("SELECT * FROM categories WHERE id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    // Thêm danh mục
    public function addCategory($data) {
        $this->db->query("INSERT INTO categories (name, description) VALUES (:name, :description)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    // Cập nhật danh mục
    public function updateCategory($data) {
        $this->db->query("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        $this->db->query("DELETE FROM categories WHERE id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}

