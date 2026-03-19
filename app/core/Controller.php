<?php

class Controller {
    // Tải model
    public function model($modelName) {
        require_once '../app/models/' . $modelName . '.php';
        return new $modelName();
    }

    // Tải view
    public function view($viewPath, $data = array()) {
        // Kiểm tra xem file view có tồn tại không
        if (file_exists('../app/views/' . $viewPath . '.php')) {
            // Biến data để có thể truyền mảng data vô view sử dụng
            require_once '../app/views/' . $viewPath . '.php';
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }

    // Hàm tiện ích để chuyển hướng
    public function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
}

