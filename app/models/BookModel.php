<?php
class BookModel extends Model {

    // Lấy danh sách sách mới nhất
    public function getNewBooks($limit = 8) {
        $this->db->query("SELECT b.*, c.name as category_name, a.name as author_name 
                          FROM books b 
                          LEFT JOIN categories c ON b.category_id = c.id
                          LEFT JOIN authors a ON b.author_id = a.id
                          WHERE b.is_active = 1
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
                          WHERE b.is_active = 1
                          ORDER BY RAND() LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Bộ lọc sản phẩm nâng cao (đa tiêu chí: từ khóa, danh mục, tác giả, khoảng giá, tồn kho, sắp xếp)
     * Tương thích PHP 5.2
     */
    public function getFilteredBooks($filters = array(), $onlyActive = true) {
        $sql = "SELECT b.*, c.name as category_name, a.name as author_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN authors a ON b.author_id = a.id";

        $where = array();
        $binds = array();

        if ($onlyActive) {
            $where[] = 'b.is_active = 1';
        }

        // 1. Lọc theo từ khóa (Tiêu đề sách hoặc tên tác giả)
        if (!empty($filters['keyword'])) {
            $where[] = '(b.title LIKE :keyword OR a.name LIKE :keyword)';
            $binds[':keyword'] = '%' . trim($filters['keyword']) . '%';
        }

        // 2. Lọc theo danh mục
        if (!empty($filters['category_id']) && (int) $filters['category_id'] > 0) {
            $where[] = 'b.category_id = :category_id';
            $binds[':category_id'] = (int) $filters['category_id'];
        }

        // 3. Lọc theo tác giả
        if (!empty($filters['author_id']) && (int) $filters['author_id'] > 0) {
            $where[] = 'b.author_id = :author_id';
            $binds[':author_id'] = (int) $filters['author_id'];
        }

        // 4. Lọc chỉ sách còn hàng trong kho
        if (!empty($filters['in_stock']) && (int) $filters['in_stock'] === 1) {
            $where[] = 'b.stock > 0';
        }

        // 5. Lọc theo khoảng giá định sẵn
        if (!empty($filters['price_range'])) {
            switch ($filters['price_range']) {
                case 'under_50':
                    $where[] = 'b.price < 50000';
                    break;
                case '50_100':
                    $where[] = 'b.price >= 50000 AND b.price <= 100000';
                    break;
                case '100_200':
                    $where[] = 'b.price >= 100000 AND b.price <= 200000';
                    break;
                case 'above_200':
                    $where[] = 'b.price > 200000';
                    break;
            }
        }

        // 6. Lọc theo khoảng giá tùy chỉnh (min - max)
        if (isset($filters['min_price']) && is_numeric($filters['min_price']) && (float) $filters['min_price'] > 0) {
            $where[] = 'b.price >= :min_price';
            $binds[':min_price'] = (float) $filters['min_price'];
        }
        if (isset($filters['max_price']) && is_numeric($filters['max_price']) && (float) $filters['max_price'] > 0) {
            $where[] = 'b.price <= :max_price';
            $binds[':max_price'] = (float) $filters['max_price'];
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        // 7. Sắp xếp kết quả
        $sort = isset($filters['sort']) ? $filters['sort'] : 'newest';
        switch ($sort) {
            case 'price_asc':
                $sql .= ' ORDER BY b.price ASC, b.id DESC';
                break;
            case 'price_desc':
                $sql .= ' ORDER BY b.price DESC, b.id DESC';
                break;
            case 'name_asc':
                $sql .= ' ORDER BY b.title ASC';
                break;
            case 'name_desc':
                $sql .= ' ORDER BY b.title DESC';
                break;
            case 'oldest':
                $sql .= ' ORDER BY b.created_at ASC, b.id ASC';
                break;
            case 'newest':
            default:
                $sql .= ' ORDER BY b.created_at DESC, b.id DESC';
                break;
        }

        $this->db->query($sql);
        foreach ($binds as $param => $val) {
            if (is_int($val)) {
                $this->db->bind($param, $val, PDO::PARAM_INT);
            } else {
                $this->db->bind($param, $val);
            }
        }

        return $this->db->resultSet();
    }

    /**
     * Lấy danh sách tất cả tác giả để hiển thị trong bộ lọc
     */
    public function getAllAuthors() {
        $this->db->query("SELECT a.*, COUNT(b.id) as book_count 
                          FROM authors a 
                          LEFT JOIN books b ON b.author_id = a.id AND b.is_active = 1 
                          GROUP BY a.id 
                          ORDER BY a.name ASC");
        return $this->db->resultSet();
    }

    /**
     * Lấy danh sách danh mục kèm số lượng sách đang bán
     */
    public function getCategoriesWithCount($onlyActive = true) {
        $activeCond = $onlyActive ? 'AND b.is_active = 1' : '';
        $sql = "SELECT c.*, COUNT(b.id) as book_count 
                FROM categories c 
                LEFT JOIN books b ON b.category_id = c.id $activeCond 
                GROUP BY c.id 
                ORDER BY c.name ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    /**
     * Lấy giá nhỏ nhất và lớn nhất của sách
     */
    public function getPriceBounds($onlyActive = true) {
        $sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM books " . ($onlyActive ? "WHERE is_active = 1" : "");
        $this->db->query($sql);
        return $this->db->single();
    }

    /**
     * @param string $keyword
     * @param bool $onlyActive true: chỉ sách đang bán (cửa hàng); false: admin xem tất cả
     * @param int|null $categoryId lọc theo danh mục (null/0 = tất cả)
     */
    public function getAllBooks($keyword = '', $onlyActive = false, $categoryId = null) {
        $sql = "SELECT b.*, c.name as category_name, a.name as author_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN authors a ON b.author_id = a.id";

        $where = array();
        if ($onlyActive) {
            $where[] = 'b.is_active = 1';
        }
        if (!empty($keyword)) {
            $where[] = '(b.title LIKE :keyword OR a.name LIKE :keyword)';
        }
        if ($categoryId !== null && (int) $categoryId > 0) {
            $where[] = 'b.category_id = :category_id';
        }
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= " ORDER BY b.created_at DESC";

        $this->db->query($sql);
        if (!empty($keyword)) {
            $this->db->bind(':keyword', "%$keyword%");
        }
        if ($categoryId !== null && (int) $categoryId > 0) {
            $this->db->bind(':category_id', (int) $categoryId, PDO::PARAM_INT);
        }

        return $this->db->resultSet();
    }

    /**
     * @param int $id
     * @param bool $onlyActive true: chỉ khi sách đang bán
     */
    public function getBookById($id, $onlyActive = false) {
        $sql = "SELECT b.*, c.name as category_name, a.name as author_name 
                FROM books b 
                LEFT JOIN categories c ON b.category_id = c.id
                LEFT JOIN authors a ON b.author_id = a.id
                WHERE b.id = :id";
        if ($onlyActive) {
            $sql .= ' AND b.is_active = 1';
        }
        $this->db->query($sql);
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    // [ADMIN] Thêm sách mới
    public function addBook($data) {
        $active = isset($data['is_active']) ? (int) (bool) $data['is_active'] : 1;
        $this->db->query("INSERT INTO books (title, category_id, author_id, price, description, image, stock, is_active) 
                          VALUES (:title, :category_id, :author_id, :price, :description, :image, :stock, :is_active)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', isset($data['image']) ? trim(basename((string) $data['image'])) : '');
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':is_active', $active, PDO::PARAM_INT);
        return $this->db->execute();
    }

    // [ADMIN] Sửa sách
    public function updateBook($data) {
        $active = isset($data['is_active']) ? (int) (bool) $data['is_active'] : 1;
        $this->db->query("UPDATE books SET title = :title, category_id = :category_id, author_id = :author_id, 
                          price = :price, description = :description, image = :image, stock = :stock, is_active = :is_active WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', isset($data['image']) ? trim(basename((string) $data['image'])) : '');
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':is_active', $active, PDO::PARAM_INT);
        return $this->db->execute();
    }

    /** Ẩn khỏi cửa hàng (không xóa bản ghi — giữ lịch sử đơn hàng). */
    public function hideBook($id) {
        $this->db->query("UPDATE books SET is_active = 0 WHERE id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function showBook($id) {
        $this->db->query("UPDATE books SET is_active = 1 WHERE id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }
}
