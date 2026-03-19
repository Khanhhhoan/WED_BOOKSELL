<?php
class BookController extends Controller {
    public function index() {
        $bookModel = $this->model('BookModel');
        
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $books = $bookModel->getAllBooks($keyword);
        
        $data = array(
            'title' => 'Danh sách Sản phẩm - BookStore',
            'books' => $books,
            'keyword' => $keyword
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
        $book = $bookModel->getBookById($id);

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

