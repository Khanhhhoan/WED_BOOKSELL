<?php
class HomeController extends Controller {
    public function index() {
        // Tải model
        $bookModel = $this->model('BookModel');
        
        // Lấy dữ liệu sách
        $newBooks = $bookModel->getNewBooks(8);
        $featuredBooks = $bookModel->getFeaturedBooks(4);
        
        // Truyền data sang view
        $data = array(
            'title' => 'Trang Chủ - BookStore',
            'newBooks' => $newBooks,
            'featuredBooks' => $featuredBooks
        );
        
        // Render view
        $this->view('layouts/header', $data);
        $this->view('home/index', $data);
        $this->view('layouts/footer');
    }

    public function contact() {
        $data = array(
            'title' => 'Liên Hệ - BookStore'
        );
        
        $this->view('layouts/header', $data);
        $this->view('home/contact', $data);
        $this->view('layouts/footer');
    }
}

