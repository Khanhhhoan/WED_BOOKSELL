<?php
class PostModel extends Model {
    
    // Lấy danh sách bài viết
    public function getAllPosts() {
        $this->db->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    // Lấy chi tiết bài viết
    public function getPostById($id) {
        $this->db->query("SELECT * FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // [ADMIN] Thêm bài viết
    public function addPost($data) {
        // Trong đồ án bỏ qua xử lý hình ảnh phức tạp, giả định lưu tên file hoặc null
        $this->db->query("INSERT INTO posts (title, excerpt, content, image) VALUES (:title, :excerpt, :content, :image)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':excerpt', $data['excerpt']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
        return $this->db->execute();
    }

    // [ADMIN] Sửa bài viết
    public function updatePost($data) {
        $this->db->query("UPDATE posts SET title = :title, excerpt = :excerpt, content = :content, image = :image WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':excerpt', $data['excerpt']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
        return $this->db->execute();
    }

    // [ADMIN] Xóa bài viết
    public function deletePost($id) {
        $this->db->query("DELETE FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}

