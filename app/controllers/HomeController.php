<?php
class HomeController extends Controller {
    public function index() {
        // Tải model
        $bookModel = $this->model('BookModel');
        
        // Lấy dữ liệu sách
        $newBooks = $bookModel->getNewBooks(8);
        $featuredBooks = $bookModel->getFeaturedBooks(4);
        
        $postModel = $this->model('PostModel');
        $allPosts = $postModel->getAllPosts();
        $latestPosts = !empty($allPosts) ? array_slice($allPosts, 0, 3) : array();
        
        // Truyền data sang view
        $data = array(
            'title' => 'Trang Chủ - BookStore',
            'newBooks' => $newBooks,
            'featuredBooks' => $featuredBooks,
            'latestPosts' => $latestPosts
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

    public function about() {
        $data = array(
            'title' => 'Giới Thiệu - BookStore'
        );

        $this->view('layouts/header', $data);
        $this->view('home/about', $data);
        $this->view('layouts/footer');
    }
}

