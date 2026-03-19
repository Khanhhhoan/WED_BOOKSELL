<?php

class Router {
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = array();

    public function __construct() {
        $url = $this->getUrl();

        // 1. Kiểm tra URL có controller không
        if (isset($url[0])) {
            // Định dạng tên controller (ví dụ: chuỗi url "book" -> "BookController")
            $controllerName = ucwords($url[0]) . 'Controller';
            
            // Tìm file controller trong thư mục app/controllers
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                // Nếu tồn tại, thay đổi controller hiện tại
                $this->currentController = $controllerName;
                unset($url[0]);
            }
        }

        // 2. Require file controller và khởi tạo
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // 3. Kiểm tra xem method có được truyền vào URL không
        if (isset($url[1])) {
            // Kiểm tra method có tồn tại trong controller đang khởi tạo không
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // 4. Các tham số (nếu có)
        // Nếu $url có các phần tử còn lại, thì đó là tham số
        $this->params = $url ? array_values($url) : array();

        // 5. Gọi function callback từ controller, truyền params
        call_user_func_array(array($this->currentController, $this->currentMethod), $this->params);
    }

    // Hàm bóc tách URL dựa vào $_GET['url'] (được RewriteRule trong .htaccess truyền vào)
    public function getUrl() {
        if(isset($_GET['url'])) {
            // Loại bỏ khoảng trắng & dấu / ở cuối
            $url = rtrim($_GET['url'], '/');
            // Lọc loại bỏ ký tự không an toàn trong url
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Cắt url thành mảng
            $url = explode('/', $url);
            return $url;
        }
        return array();
    }
}

