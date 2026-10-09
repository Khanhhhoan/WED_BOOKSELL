<?php
// Bật output buffering để ngăn chặn lỗi "Cannot modify header information"
if (ob_get_level() == 0) {
    ob_start();
}

// Bỏ qua cảnh báo Deprecated / Notice trên production (PHP 8.1+)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

// dirname(__FILE__) tương thích PHP 5.2; __DIR__ chỉ có từ PHP 5.3.
$publicRoot = dirname(__FILE__);
chdir($publicRoot);

if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

require_once $publicRoot . '/../app/core/Session.php';
require_once $publicRoot . '/../config/database.php';
require_once $publicRoot . '/../app/core/Router.php';
require_once $publicRoot . '/../app/core/Controller.php';
require_once $publicRoot . '/../app/core/Database.php';
require_once $publicRoot . '/../app/core/Model.php';
require_once $publicRoot . '/../config/sepay.php';

$init = new Router();
