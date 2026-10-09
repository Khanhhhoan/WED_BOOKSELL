<?php
class BookController extends Controller {
    public function index() {
        $bookModel = $this->model('BookModel');

        // Bóc tách toàn bộ tham số lọc từ GET
        $filters = array(
            'keyword' => isset($_GET['keyword']) ? trim((string) $_GET['keyword']) : '',
            'category_id' => isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0,
            'author_id' => isset($_GET['author_id']) ? (int) $_GET['author_id'] : 0,
            'price_range' => isset($_GET['price_range']) ? trim((string) $_GET['price_range']) : '',
            'min_price' => (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) ? (float) $_GET['min_price'] : '',
            'max_price' => (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) ? (float) $_GET['max_price'] : '',
            'in_stock' => isset($_GET['in_stock']) ? (int) $_GET['in_stock'] : 0,
            'sort' => isset($_GET['sort']) ? trim((string) $_GET['sort']) : 'newest',
        );

        // Lấy danh sách sách sau khi lọc (chỉ sách đang bán is_active = 1)
        $books = $bookModel->getFilteredBooks($filters, true);

        // Dữ liệu phục vụ bộ lọc
        $categories = $bookModel->getCategoriesWithCount(true);
        $authors = $bookModel->getAllAuthors();
        $priceBounds = $bookModel->getPriceBounds(true);

        $data = array(
            'title' => 'Cửa Hàng Sách - Bộ Lọc & Tìm Kiếm',
            'books' => $books,
            'totalBooks' => count($books),
            'filters' => $filters,
            'categories' => $categories,
            'authors' => $authors,
            'priceBounds' => $priceBounds,
            'keyword' => $filters['keyword'],
            'category_id' => $filters['category_id'],
        );
        
        $this->view('layouts/header', $data);
        $this->view('book/index', $data);
        $this->view('layouts/footer');
    }

    public function detail($id = null) {
        if (!$id) {
            $this->redirect('book');
        }

        $bookModel = $this->model('BookModel');
        $book = $bookModel->getBookById($id, true);

        if (!$book) {
            $this->redirect('book');
        }

        // Có thể lấy thêm sách liên quan cùng danh mục
        // $relatedBooks = $bookModel->get...

        $data = array(
            'title' => $book['title'] . ' - BookStore',
            'book' => $book
        );
        
        $this->view('layouts/header', $data);
        $this->view('book/detail', $data);
        $this->view('layouts/footer');
    }
}

