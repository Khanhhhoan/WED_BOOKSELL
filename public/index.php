<?php
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
