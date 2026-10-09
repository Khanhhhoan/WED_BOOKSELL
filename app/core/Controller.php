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

    // Hàm tiện ích để chuyển hướng an toàn
    public function redirect($url) {
        $target = (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) 
            ? $url 
            : rtrim(BASE_URL, '/') . '/' . ltrim($url, '/');

        if (!headers_sent()) {
            header('Location: ' . $target);
        } else {
            echo '<script type="text/javascript">window.location.href=' . json_encode($target) . ';</script>';
            echo '<noscript><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . '"></noscript>';
        }
        exit;
    }
}

