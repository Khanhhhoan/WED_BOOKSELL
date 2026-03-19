<?php
class PostController extends Controller {
    
    public function index() {
        $postModel = $this->model('PostModel');
        $posts = $postModel->getAllPosts();

        $data = array(
            'title' => 'Tin Tức - Bài Viết - BookStore',
            'posts' => $posts
        );

        $this->view('layouts/header', $data);
        $this->view('post/index', $data);
        $this->view('layouts/footer');
    }

    public function detail($id = null) {
        if (!$id) {
            $this->redirect('post');
        }

        $postModel = $this->model('PostModel');
        $post = $postModel->getPostById($id);

        if (!$post) {
            $this->redirect('post');
        }

        $data = array(
            'title' => $post['title'] . ' - BookStore',
            'post' => $post
        );

        $this->view('layouts/header', $data);
        $this->view('post/detail', $data);
        $this->view('layouts/footer');
    }
}

