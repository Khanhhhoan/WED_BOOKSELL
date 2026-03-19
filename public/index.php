<?php
// Yêu cầu thư viện session đầu tiên
require_once '../app/core/Session.php';

// Yêu cầu file cấu hình
require_once '../config/database.php';

// Yêu cầu các core class
require_once '../app/core/Router.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';
require_once '../app/core/Model.php';

// Khởi tạo core ứng dụng
$init = new Router();
