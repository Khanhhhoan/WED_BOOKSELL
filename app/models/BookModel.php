<?php
class BookModel extends Model {
    
    // Lấy danh sách sách mới nhất
    public function getNewBooks($limit = 8) {
        $this->db->query("SELECT b.*, c.name as category_name, a.name as author_name 
                          FROM books b 
                          LEFT JOIN categories c ON b.category_id = c.id
                          LEFT JOIN authors a ON b.author_id = a.id
                          ORDER BY b.created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // Lấy sách nổi bật (ví dụ lấy theo giá cao nhất hoặc random)
    public function getFeaturedBooks($limit = 4) {
        $this->db->query("SELECT b.*, c.name as category_name, a.name as author_name 
                          FROM books b 
                          LEFT JOIN categories c ON b.category_id = c.id
                          LEFT JOIN authors a ON b.author_id = a.id
                          ORDER BY RAND() LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // Lấy toàn bộ sách (có tìm kiếm)
    public function getAllBooks($keyword = '') {
        $sql = "SELECT b.*, c.name as category_name, a.name as author_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN authors a ON b.author_id = a.id";
        
        if (!empty($keyword)) {
            $sql .= " WHERE b.title LIKE :keyword OR a.name LIKE :keyword";
        }
        $sql .= " ORDER BY b.created_at DESC";

        $this->db->query($sql);

        if (!empty($keyword)) {
            $this->db->bind(':keyword', "%$keyword%");
        }

        return $this->db->resultSet();
    }

    // Lấy chi tiết 1 cuốn sách
    public function getBookById($id) {
        $this->db->query("SELECT b.*, c.name as category_name, a.name as author_name 
                          FROM books b 
                          LEFT JOIN categories c ON b.category_id = c.id
                          LEFT JOIN authors a ON b.author_id = a.id
                          WHERE b.id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    // [ADMIN] Thêm sách mới
    public function addBook($data) {
        $this->db->query("INSERT INTO books (title, category_id, author_id, price, description, image, stock) 
                          VALUES (:title, :category_id, :author_id, :price, :description, :image, :stock)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':stock', $data['stock']);
        return $this->db->execute();
    }

    // [ADMIN] Sửa sách
    public function updateBook($data) {
        $this->db->query("UPDATE books SET title = :title, category_id = :category_id, author_id = :author_id, 
                          price = :price, description = :description, image = :image, stock = :stock WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':stock', $data['stock']);
        return $this->db->execute();
    }

    // [ADMIN] Xóa sách
    public function deleteBook($id) {
        $this->db->query("DELETE FROM books WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}

