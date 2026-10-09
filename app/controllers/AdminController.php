<?php
class AdminController extends Controller {
    
    public function __construct() {
        if (!Session::isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
            Session::flash('error', 'Bạn không có quyền truy cập trang quản trị!');
            $this->redirect('home');
        }
    }

    // ==========================================
    // MODULE: DASHBOARD
    // ==========================================
    public function index() {
        $adminModel = $this->model('AdminModel');
        $stats = $adminModel->getDashboardStats();
        $recentOrders = $adminModel->getRecentOrders(5);

        $data = array(
            'title' => 'Dashboard - Quản trị hệ thống',
            'stats' => $stats,
            'recentOrders' => $recentOrders
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/admin_footer');
    }

    // ==========================================
    // MODULE: CATEGORY (DANH M?C)
    // ==========================================
    public function categories() {
        $categoryModel = $this->model('CategoryModel');
        $categories = $categoryModel->getAllCategories();

        $data = array(
            'title' => 'Quản lý danh mục',
            'categories' => $categories
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function category_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'name' => isset($_POST['name']) ? trim((string)$_POST['name']) : '',
                'description' => isset($_POST['description']) ? trim((string)$_POST['description']) : '',
            );

            if (!empty($data['name'])) {
                $categoryModel = $this->model('CategoryModel');
                if ($categoryModel->addCategory($data)) {
                    Session::flash('msg', 'Thêm danh mục thành công!');
                    $this->redirect('admin/categories');
                } else {
                    die('Lỗi hệ thống khi thêm danh mục');
                }
            } else {
                Session::flash('error', 'Tên danh mục không được để trống!');
                $this->redirect('admin/categories');
            }
        }
    }

    public function category_edit($id) {
        $categoryModel = $this->model('CategoryModel');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'id' => $id,
                'name' => isset($_POST['name']) ? trim((string)$_POST['name']) : '',
                'description' => isset($_POST['description']) ? trim((string)$_POST['description']) : '',
            );

            if (!empty($data['name'])) {
                if ($categoryModel->updateCategory($data)) {
                    Session::flash('msg', 'Cập nhật danh mục thành công!');
                    $this->redirect('admin/categories');
                } else {
                    die('Lỗi cập nhật');
                }
            } else {
                Session::flash('error', 'Tên danh mục không được rỗng.');
                $this->redirect('admin/categories');
            }
        } else {
            // L?y th�ng tin form
            $category = $categoryModel->getCategoryById($id);
            if (!$category) {
                $this->redirect('admin/categories');
            }
            
            $data = array(
                'title' => 'Sửa danh mục',
                'category' => $category
            );

            $this->view('layouts/admin_header', $data);
            $this->view('admin/categories/edit', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function category_delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $categoryModel = $this->model('CategoryModel');
            
            if ($categoryModel->deleteCategory($id)) {
                Session::flash('msg', 'Đã xóa danh mục thành công!');
            } else {
                Session::flash('error', 'Lỗi xóa danh mục!');
            }
            $this->redirect('admin/categories');
        }
    }

    // ==========================================
    // MODULE: ORDERS (�ON H�NG)
    // ==========================================
    public function orders() {
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getAllOrders();

        $data = array(
            'title' => 'Quản lý đơn hàng',
            'orders' => $orders
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function order_detail($id) {
        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderByIdAdmin($id);
        if (!$order) $this->redirect('admin/orders');

        $items = $orderModel->getOrderDetailsAdmin($id);
        $logModel = $this->model('PaymentLogModel');
        $logs = $logModel->getLogsByOrderId($id);

        $data = array(
            'title' => 'Chi tiết đơn hàng #ORD' . $id,
            'order' => $order,
            'items' => $items,
            'logs' => $logs
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/orders/detail', $data);
        $this->view('layouts/admin_footer');
    }

    public function order_update_status() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];

            $orderModel = $this->model('OrderModel');
            if ($orderModel->updateOrderStatus($orderId, $status)) {
                Session::flash('msg', 'Cập nhật trạng thái đơn hàng thành công!');
            } else {
                Session::flash('error', 'Cập nhật trạng thái thất bại.');
            }
            $this->redirect('admin/order_detail/' . $orderId);
        }
    }

    // ==========================================
    // MODULE: POSTS (B�I VI?T)
    // ==========================================
    public function posts() {
        $postModel = $this->model('PostModel');
        $posts = $postModel->getAllPosts();

        $data = array(
            'title' => 'Quản lý bài viết',
            'posts' => $posts
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/posts/index', $data);
        $this->view('layouts/admin_footer');
    }

    // Note: Add/Edit Post Form tuong t? Category, t�i s? skip code HTML chi ti?t form d? ng?n g?n trong project
    public function post_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadResult = $this->uploadPostCoverImage();
            if ($uploadResult === false) {
                Session::flash('error', $this->postImageUploadErrorMessage());
                $this->redirect('admin/post_add');
            }
            if ($uploadResult !== null && $uploadResult !== '') {
                $imageName = $uploadResult;
            } else {
                $imageName = isset($_POST['image']) ? trim((string)$_POST['image']) : '';
            }

            $data = array(
                'title' => isset($_POST['title']) ? trim((string)$_POST['title']) : '',
                'excerpt' => isset($_POST['excerpt']) ? trim((string)$_POST['excerpt']) : '',
                'content' => isset($_POST['content']) ? trim((string)$_POST['content']) : '',
                'image' => $imageName
            );
            $postModel = $this->model('PostModel');
            if ($postModel->addPost($data)) {
                $msg = 'Thêm bài viết mới thành công!';
                if ($uploadResult !== null && $uploadResult !== '') {
                    $msg .= ' Ảnh bìa: ' . $uploadResult;
                }
                Session::flash('msg', $msg);
                $this->redirect('admin/posts');
            } else {
                die('Có lỗi xảy ra khi lưu bài viết.');
            }
        } else {
            $data = array('title' => 'Thêm Bài Viết Mới');
            $this->view('layouts/admin_header', $data);
            $this->view('admin/posts/add', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function post_edit($id) {
        $postModel = $this->model('PostModel');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadResult = $this->uploadPostCoverImage();
            $currentImage = isset($_POST['current_image']) ? trim((string)$_POST['current_image']) : '';
            if ($uploadResult === false) {
                Session::flash('error', $this->postImageUploadErrorMessage() . ' Đã giữ lại ảnh bìa hiện tại.');
                $uploadResult = null;
            }
            if ($uploadResult !== null && $uploadResult !== '') {
                $imageName = $uploadResult;
            } else {
                $imageInput = isset($_POST['image']) ? trim((string)$_POST['image']) : '';
                $imageName = ($imageInput !== '') ? $imageInput : $currentImage;
            }

            $data = array(
                'id' => $id,
                'title' => isset($_POST['title']) ? trim((string)$_POST['title']) : '',
                'excerpt' => isset($_POST['excerpt']) ? trim((string)$_POST['excerpt']) : '',
                'content' => isset($_POST['content']) ? trim((string)$_POST['content']) : '',
                'image' => $imageName
            );
            if ($postModel->updatePost($data)) {
                $msg = 'Cập nhật bài viết thành công!';
                if ($uploadResult !== null && $uploadResult !== '') {
                    $msg .= ' Đã tải lên ảnh mới: ' . $uploadResult;
                }
                Session::flash('msg', $msg);
                $this->redirect('admin/posts');
            } else {
                die('Có lỗi xảy ra khi cập nhật.');
            }
        } else {
            $post = $postModel->getPostById($id);
            if (!$post) {
                $this->redirect('admin/posts');
            }
            $data = array(
                'title' => 'Sửa Bài Viết',
                'post' => $post
            );
            $this->view('layouts/admin_header', $data);
            $this->view('admin/posts/edit', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function post_delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postModel = $this->model('PostModel');
            if ($postModel->deletePost($id)) {
                Session::flash('msg', 'Đã xóa bài viết khỏi hệ thống.');
            }
            $this->redirect('admin/posts');
        }
    }

    // ==========================================
    // MODULE: BOOKS (S�CH)
    // ==========================================
    public function books() {
        $bookModel = $this->model('BookModel');
        $books = $bookModel->getAllBooks('', false);
        
        $categoryModel = $this->model('CategoryModel');
        $categories = $categoryModel->getAllCategories(); // L?y danh m?c cho form Add/Edit

        $data = array(
            'title' => 'Quản lý sách',
            'books' => $books,
            'categories' => $categories
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/books/index', $data);
        $this->view('layouts/admin_footer');
    }

    // Note: Form Th�m S?a s�ch cung tuong t? nhu form Category, skip code HTML d�i
    public function book_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadResult = $this->uploadBookCoverImage();
            if ($uploadResult === false) {
                Session::flash('error', $this->bookImageUploadErrorMessage());
                $this->redirect('admin/book_add');
            }
            $imageName = ($uploadResult !== null && $uploadResult !== '') ? $uploadResult : '';

            $data = array(
                'title' => isset($_POST['title']) ? trim((string)$_POST['title']) : '',
                'category_id' => isset($_POST['category_id']) ? trim((string)$_POST['category_id']) : '',
                'author_id' => !empty($_POST['author_id']) ? trim((string)$_POST['author_id']) : null,
                'price' => isset($_POST['price']) ? trim((string)$_POST['price']) : '',
                'stock' => isset($_POST['stock']) ? trim((string)$_POST['stock']) : '',
                'description' => isset($_POST['description']) ? trim((string)$_POST['description']) : '',
                'image' => $imageName,
                'is_active' => !empty($_POST['is_active']) ? 1 : 0,
            );
            $bookModel = $this->model('BookModel');
            if ($bookModel->addBook($data)) {
                $msg = 'Thêm sách thành công!';
                if ($uploadResult !== null && $uploadResult !== '') {
                    $msg .= ' Ảnh đã lưu: ' . $uploadResult . ' (trùng tên trong CSDL mới hiện được).';
                }
                Session::flash('msg', $msg);
                $this->redirect('admin/books');
            } else {
                die('Có lỗi xảy ra khi lưu sách.');
            }
        } else {
            $categoryModel = $this->model('CategoryModel');
            $data = array(
                'title' => 'Thêm Sách Mới',
                'categories' => $categoryModel->getAllCategories()
            );
            $this->view('layouts/admin_header', $data);
            $this->view('admin/books/add', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function book_edit($id) {
        $bookModel = $this->model('BookModel');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadResult = $this->uploadBookCoverImage();
            $currentImage = isset($_POST['current_image']) ? trim((string)$_POST['current_image']) : '';
            if ($uploadResult === false) {
                Session::flash('error', $this->bookImageUploadErrorMessage() . ' Thông tin sách vẫn được lưu; ảnh bìa giữ nguyên.');
                $uploadResult = null;
            }
            if ($uploadResult !== null && $uploadResult !== '') {
                $imageName = $uploadResult;
            } else {
                $imageName = $currentImage;
            }

            $data = array(
                'id' => $id,
                'title' => isset($_POST['title']) ? trim((string)$_POST['title']) : '',
                'category_id' => isset($_POST['category_id']) ? trim((string)$_POST['category_id']) : '',
                'author_id' => !empty($_POST['author_id']) ? trim((string)$_POST['author_id']) : null,
                'price' => isset($_POST['price']) ? trim((string)$_POST['price']) : '',
                'stock' => isset($_POST['stock']) ? trim((string)$_POST['stock']) : '',
                'description' => isset($_POST['description']) ? trim((string)$_POST['description']) : '',
                'image' => $imageName,
                'is_active' => !empty($_POST['is_active']) ? 1 : 0,
            );
            if ($bookModel->updateBook($data)) {
                $msg = 'Cập nhật sách thành công!';
                if ($uploadResult !== null && $uploadResult !== '') {
                    $msg .= ' Ảnh mới: ' . $uploadResult . ' — nếu vẫn không thấy, F5 hoặc xem cột image trong phpMyAdmin.';
                }
                Session::flash('msg', $msg);
                $this->redirect('admin/books');
            } else {
                die('Có lỗi xảy ra khi cập nhật.');
            }
        } else {
            $book = $bookModel->getBookById($id);
            if (!$book) $this->redirect('admin/books');
            $categoryModel = $this->model('CategoryModel');
            $data = array(
                'title' => 'Sửa Sách',
                'book' => $book,
                'categories' => $categoryModel->getAllCategories()
            );
            $this->view('layouts/admin_header', $data);
            $this->view('admin/books/edit', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function book_delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bookModel = $this->model('BookModel');
            if ($bookModel->hideBook($id)) {
                Session::flash('msg', 'Đã ẩn sách khỏi cửa hàng. Sách vẫn được giữ trong hệ thống và lịch sử đơn hàng.');
            } else {
                Session::flash('error', 'Không thể ẩn sách. Vui lòng thử lại.');
            }
            $this->redirect('admin/books');
        }
    }

    public function book_show($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bookModel = $this->model('BookModel');
            if ($bookModel->showBook($id)) {
                Session::flash('msg', 'Đã hiện lại sách trên cửa hàng.');
            } else {
                Session::flash('error', 'Không thể cập nhật trạng thái sách.');
            }
            $this->redirect('admin/books');
        }
    }

    // ==========================================
    // MODULE: USERS (NGU?I D�NG)
    // ==========================================
    public function users() {
        $userModel = $this->model('UserModel');
        $users = $userModel->getAllUsers();

        $data = array(
            'title' => 'Quản lý người dùng',
            'users' => $users
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/users/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function user_delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            if ($userModel->deleteUser($id)) {
                Session::flash('msg', 'Đã xóa người dùng thành công.');
            } else {
                Session::flash('error', 'Không thể xóa Admin hoặc lỗi hệ thống.');
            }
            $this->redirect('admin/users');
        }
    }

    /**
     * Lưu file upload bìa sách vào public/assets/images/.
     *
     * @return string|null Tên file mới; null nếu không gửi file; false nếu lỗi hoặc không phải ảnh hợp lệ
     */
    private function uploadBookCoverImage() {
        if (!isset($_FILES['book_image'])) {
            return null;
        }
        $f = $_FILES['book_image'];
        if ($f['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($f['error'] !== UPLOAD_ERR_OK || empty($f['tmp_name']) || !is_uploaded_file($f['tmp_name'])) {
            return false;
        }
        $info = @getimagesize($f['tmp_name']);
        if ($info === false) {
            return false;
        }
        $ext = null;
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $ext = 'png';
                break;
            case IMAGETYPE_GIF:
                $ext = 'gif';
                break;
            default:
                if (defined('IMAGETYPE_WEBP') && $info[2] === IMAGETYPE_WEBP) {
                    $ext = 'webp';
                }
                break;
        }
        if ($ext === null) {
            return false;
        }
        if (!function_exists('book_image_disk_dir')) {
            return false;
        }
        $base = book_image_disk_dir();
        if (!is_dir($base)) {
            if (!@mkdir($base, 0755, true)) {
                return false;
            }
        }
        $resolved = realpath($base);
        if ($resolved !== false) {
            $base = $resolved;
        }
        if (!is_dir($base) || !is_writable($base)) {
            return false;
        }
        $filename = 'book_' . date('Ymd_His') . '_' . mt_rand(1000, 9999) . '.' . $ext;
        $dest = $base . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($f['tmp_name'], $dest)) {
            return false;
        }
        if (!is_file($dest) || (int) filesize($dest) === 0) {
            return false;
        }
        @chmod($dest, 0644);
        return $filename;
    }

    private function bookImageUploadErrorMessage() {
        $err = isset($_FILES['book_image']['error']) ? (int) $_FILES['book_image']['error'] : UPLOAD_ERR_OK;
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            return 'File ảnh quá lớn. Tăng upload_max_filesize và post_max_size trong php.ini (WAMP → PHP → php.ini).';
        }
        if ($err === UPLOAD_ERR_PARTIAL) {
            return 'Upload ảnh bị gián đoạn. Thử lại với file nhỏ hơn.';
        }
        return 'Không thể tải ảnh. Dùng JPG, PNG, GIF hoặc WebP; kiểm tra quyền ghi thư mục public/assets/images.';
    }

    /**
     * Lưu file upload ảnh bài viết vào public/assets/images/posts/.
     *
     * @return string|null Tên file mới; null nếu không gửi file; false nếu lỗi hoặc không phải ảnh hợp lệ
     */
    private function uploadPostCoverImage() {
        if (!isset($_FILES['post_image'])) {
            return null;
        }
        $f = $_FILES['post_image'];
        if ($f['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($f['error'] !== UPLOAD_ERR_OK || empty($f['tmp_name']) || !is_uploaded_file($f['tmp_name'])) {
            return false;
        }
        $info = @getimagesize($f['tmp_name']);
        if ($info === false) {
            return false;
        }
        $ext = null;
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $ext = 'png';
                break;
            case IMAGETYPE_GIF:
                $ext = 'gif';
                break;
            default:
                if (defined('IMAGETYPE_WEBP') && $info[2] === IMAGETYPE_WEBP) {
                    $ext = 'webp';
                }
                break;
        }
        if ($ext === null) {
            return false;
        }
        if (!function_exists('post_image_disk_dir')) {
            return false;
        }
        $base = post_image_disk_dir();
        if (!is_dir($base)) {
            if (!@mkdir($base, 0755, true)) {
                return false;
            }
        }
        $resolved = realpath($base);
        if ($resolved !== false) {
            $base = $resolved;
        }
        if (!is_dir($base) || !is_writable($base)) {
            return false;
        }
        $filename = 'post_' . date('Ymd_His') . '_' . mt_rand(1000, 9999) . '.' . $ext;
        $dest = $base . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($f['tmp_name'], $dest)) {
            return false;
        }
        if (!is_file($dest) || (int) filesize($dest) === 0) {
            return false;
        }
        @chmod($dest, 0644);
        return $filename;
    }

    private function postImageUploadErrorMessage() {
        $err = isset($_FILES['post_image']['error']) ? (int) $_FILES['post_image']['error'] : UPLOAD_ERR_OK;
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            return 'File ảnh bài viết quá lớn. Vui lòng chọn ảnh nhỏ hơn 5MB.';
        }
        if ($err === UPLOAD_ERR_PARTIAL) {
            return 'Upload ảnh bài viết bị gián đoạn. Thử lại với file nhỏ hơn.';
        }
        return 'Không thể tải ảnh bài viết. Dùng JPG, PNG, GIF hoặc WebP; kiểm tra quyền ghi thư mục public/assets/images/posts.';
    }

    // ==========================================
    // MODULE: LOG THANH TOÁN (SEPAY PAYMENTS)
    // ==========================================
    public function payments() {
        $logModel = $this->model('PaymentLogModel');
        $status = isset($_GET['status']) ? trim((string)$_GET['status']) : '';
        $keyword = isset($_GET['keyword']) ? trim((string)$_GET['keyword']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 15;

        $logs = $logModel->getLogs($page, $limit, $status, $keyword);
        $totalLogs = $logModel->countLogs($status, $keyword);
        $totalPages = ($totalLogs > 0) ? (int)ceil($totalLogs / $limit) : 1;
        $stats = $logModel->getStats();

        // Lấy danh sách đơn hàng đang chờ để dùng trong form giả lập Webhook
        $orderModel = $this->model('OrderModel');
        $allOrders = $orderModel->getAllOrders();

        $data = array(
            'title' => 'Lịch Sử Thanh Toán',
            'logs' => $logs,
            'totalLogs' => $totalLogs,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'status' => $status,
            'keyword' => $keyword,
            'stats' => $stats,
            'allOrders' => $allOrders
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/payments/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function payment_detail($id) {
        $logModel = $this->model('PaymentLogModel');
        $log = $logModel->getLogById((int)$id);
        if (!$log) {
            Session::flash('error', 'Log giao dịch không tồn tại.');
            $this->redirect('admin/payments');
        }

        $data = array(
            'title' => 'Chi Tiết Giao Dịch #' . $id,
            'log' => $log
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/payments/detail', $data);
        $this->view('layouts/admin_footer');
    }

    public function sepay_settings() {
        $logModel = $this->model('PaymentLogModel');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $settings = array(
                'sepay_bank' => isset($_POST['sepay_bank']) ? trim((string)$_POST['sepay_bank']) : 'MBBank',
                'sepay_account_no' => isset($_POST['sepay_account_no']) ? trim((string)$_POST['sepay_account_no']) : '',
                'sepay_account_name' => isset($_POST['sepay_account_name']) ? trim((string)$_POST['sepay_account_name']) : '',
                'sepay_api_key' => isset($_POST['sepay_api_key']) ? trim((string)$_POST['sepay_api_key']) : '',
                'sepay_prefix' => isset($_POST['sepay_prefix']) ? trim((string)$_POST['sepay_prefix']) : 'DH',
                'sepay_qr_template' => isset($_POST['sepay_qr_template']) ? trim((string)$_POST['sepay_qr_template']) : 'compact',
                'sepay_is_active' => isset($_POST['sepay_is_active']) ? '1' : '0'
            );

            $logModel->saveSepaySettings($settings);
            Session::flash('msg', 'Cập nhật cấu hình SePay thành công!');
            $this->redirect('admin/sepay_settings');
        } else {
            $settings = $logModel->getSepaySettings();
            $webhookUrl = get_sepay_webhook_url();

            $data = array(
                'title' => 'Cấu Hình Cổng Thanh Toán SePay',
                'settings' => $settings,
                'webhookUrl' => $webhookUrl
            );

            $this->view('layouts/admin_header', $data);
            $this->view('admin/payments/settings', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function sepay_test_webhook() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
            $gateway = isset($_POST['gateway']) ? trim((string)$_POST['gateway']) : 'MBBank';
            $transferAmount = isset($_POST['transfer_amount']) ? floatval($_POST['transfer_amount']) : 0;
            $content = isset($_POST['content']) ? trim((string)$_POST['content']) : '';
            $refCode = 'SIM_' . date('YmdHis') . '_' . mt_rand(100, 999);

            $logModel = $this->model('PaymentLogModel');
            $orderModel = $this->model('OrderModel');

            $order = null;
            if ($orderId > 0) {
                $order = $orderModel->getOrderByIdAdmin($orderId);
            }

            $rawPayload = array(
                'id' => mt_rand(100000, 999999),
                'gateway' => $gateway,
                'transactionDate' => date('Y-m-d H:i:s'),
                'accountNumber' => get_sepay_config('sepay_account_no'),
                'subAccount' => '',
                'code' => $refCode,
                'content' => $content,
                'transferType' => 'in',
                'description' => '[Giả lập Admin] Thử nghiệm Webhook SePay',
                'transferAmount' => $transferAmount,
                'accumulated' => 10000000,
                'referenceCode' => $refCode
            );

            $rawJson = json_encode($rawPayload);

            if ($order && $transferAmount >= floatval($order['total_amount'])) {
                // Xác nhận thanh toán thành công
                $orderModel->confirmOrderPayment($orderId, $refCode);

                $logData = array(
                    'order_id' => $orderId,
                    'gateway' => $gateway,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'account_number' => get_sepay_config('sepay_account_no'),
                    'sub_account' => '',
                    'transfer_type' => 'in',
                    'transfer_amount' => $transferAmount,
                    'accumulated' => 10000000,
                    'code' => $refCode,
                    'content' => $content,
                    'reference_code' => $refCode,
                    'description' => '[Giả lập Webhook] Xác nhận thanh toán thành công đơn hàng #ORD' . $orderId,
                    'status' => 'success',
                    'raw_data' => $rawJson
                );
                $logModel->logTransaction($logData);
                Session::flash('msg', 'Giả lập thành công! Đơn hàng #ORD' . $orderId . ' đã tự động chuyển sang "Đã xác nhận" & thanh toán thành công.');
            } elseif ($order && $transferAmount < floatval($order['total_amount'])) {
                $logData = array(
                    'order_id' => $orderId,
                    'gateway' => $gateway,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'account_number' => get_sepay_config('sepay_account_no'),
                    'sub_account' => '',
                    'transfer_type' => 'in',
                    'transfer_amount' => $transferAmount,
                    'accumulated' => 10000000,
                    'code' => $refCode,
                    'content' => $content,
                    'reference_code' => $refCode,
                    'description' => '[Giả lập Webhook] Số tiền chuyển (' . number_format($transferAmount) . ' đ) nhỏ hơn tổng đơn (' . number_format($order['total_amount']) . ' đ)',
                    'status' => 'amount_mismatch',
                    'raw_data' => $rawJson
                );
                $logModel->logTransaction($logData);
                Session::flash('error', 'Giả lập hoàn tất: Đã ghi nhận log "Sai lệch số tiền" do chuyển thiếu tiền.');
            } else {
                $logData = array(
                    'order_id' => null,
                    'gateway' => $gateway,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'account_number' => get_sepay_config('sepay_account_no'),
                    'sub_account' => '',
                    'transfer_type' => 'in',
                    'transfer_amount' => $transferAmount,
                    'accumulated' => 10000000,
                    'code' => $refCode,
                    'content' => $content,
                    'reference_code' => $refCode,
                    'description' => '[Giả lập Webhook] Không tìm thấy mã đơn hàng phù hợp',
                    'status' => 'unmatched',
                    'raw_data' => $rawJson
                );
                $logModel->logTransaction($logData);
                Session::flash('msg', 'Giả lập ghi nhận log: Không tìm thấy đơn hàng tương ứng (Đã lưu vào danh sách chờ rà soát).');
            }

            $this->redirect('admin/payments');
        }
    }

    public function payment_link_order() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $logId = isset($_POST['log_id']) ? (int)$_POST['log_id'] : 0;
            $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

            if ($logId > 0 && $orderId > 0) {
                $logModel = $this->model('PaymentLogModel');
                $orderModel = $this->model('OrderModel');

                $order = $orderModel->getOrderByIdAdmin($orderId);
                $log = $logModel->getLogById($logId);

                if ($order && $log) {
                    $logModel->linkLogToOrder($logId, $orderId);
                    $orderModel->confirmOrderPayment($orderId, $log['reference_code']);
                    Session::flash('msg', 'Đã gán giao dịch #' . $logId . ' vào đơn hàng #ORD' . $orderId . ' thành công!');
                } else {
                    Session::flash('error', 'Đơn hàng hoặc log giao dịch không tồn tại.');
                }
            }
            $this->redirect('admin/payments');
        }
    }

    // ==========================================
    // MODULE: BÁO CÁO & THỐNG KÊ ĐƠN HÀNG
    // (Số lượng sản phẩm, Thành tiền theo Tháng, Quý, Năm)
    // Tương thích PHP 5.2.6
    // ==========================================
    public function statistics() {
        $orderModel = $this->model('OrderModel');

        $tab = isset($_GET['tab']) ? trim((string)$_GET['tab']) : 'month';
        if (!in_array($tab, array('month', 'quarter', 'year'))) {
            $tab = 'month';
        }

        $availableYears = $orderModel->getAvailableOrderYears();
        $currentYear = (int)date('Y');
        $defaultYear = !empty($availableYears) ? $availableYears[0] : $currentYear;

        $year = isset($_GET['year']) ? (int)$_GET['year'] : $defaultYear;
        if ($year <= 2000 || $year > 2100) {
            $year = $defaultYear;
        }

        $statusFilter = isset($_GET['status']) ? trim((string)$_GET['status']) : 'valid';
        if (!in_array($statusFilter, array('valid', 'completed', 'all'))) {
            $statusFilter = 'valid';
        }

        // Lấy dữ liệu thống kê theo chu kỳ được chọn
        $statisticsData = array();
        if ($tab === 'month') {
            $statisticsData = $orderModel->getMonthlyStatistics($year, $statusFilter);
        } elseif ($tab === 'quarter') {
            $statisticsData = $orderModel->getQuarterlyStatistics($year, $statusFilter);
        } else { // 'year'
            $statisticsData = $orderModel->getYearlyStatistics($statusFilter);
        }

        // Tính tổng hợp KPI
        $totalOrdersSum = 0;
        $totalProductsSum = 0;
        $totalAmountSum = 0.0;
        $peakPeriod = null;
        $peakAmount = 0.0;

        foreach ($statisticsData as $row) {
            $totalOrdersSum += (int)$row['total_orders'];
            $totalProductsSum += (int)$row['total_products'];
            $totalAmountSum += (float)$row['total_amount'];

            if ((float)$row['total_amount'] > $peakAmount) {
                $peakAmount = (float)$row['total_amount'];
                if ($tab === 'month') {
                    $peakPeriod = $row['month_label'];
                } elseif ($tab === 'quarter') {
                    $peakPeriod = $row['quarter_label'];
                } else {
                    $peakPeriod = $row['year_label'];
                }
            }
        }

        $overallAOV = ($totalOrdersSum > 0) ? ($totalAmountSum / $totalOrdersSum) : 0.0;

        // Top 5 sản phẩm bán chạy nhất trong kỳ
        $topProducts = $orderModel->getTopSellingProductsByPeriod($tab, $year, $statusFilter, 5);

        // Phân bổ phương thức thanh toán trong kỳ
        $paymentStats = $orderModel->getPaymentMethodStatsByPeriod($tab, $year, $statusFilter);

        $data = array(
            'title' => 'Báo Cáo & Thống Kê Đơn Hàng',
            'tab' => $tab,
            'year' => $year,
            'availableYears' => $availableYears,
            'statusFilter' => $statusFilter,
            'statisticsData' => $statisticsData,
            'summary' => array(
                'total_orders' => $totalOrdersSum,
                'total_products' => $totalProductsSum,
                'total_amount' => $totalAmountSum,
                'avg_order_value' => $overallAOV,
                'peak_period' => $peakPeriod,
                'peak_amount' => $peakAmount
            ),
            'topProducts' => $topProducts,
            'paymentStats' => $paymentStats
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/statistics/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function export_statistics() {
        $orderModel = $this->model('OrderModel');

        $tab = isset($_GET['tab']) ? trim((string)$_GET['tab']) : 'month';
        if (!in_array($tab, array('month', 'quarter', 'year'))) {
            $tab = 'month';
        }

        $availableYears = $orderModel->getAvailableOrderYears();
        $currentYear = (int)date('Y');
        $defaultYear = !empty($availableYears) ? $availableYears[0] : $currentYear;
        $year = isset($_GET['year']) ? (int)$_GET['year'] : $defaultYear;

        $statusFilter = isset($_GET['status']) ? trim((string)$_GET['status']) : 'valid';
        if (!in_array($statusFilter, array('valid', 'completed', 'all'))) {
            $statusFilter = 'valid';
        }

        if ($tab === 'month') {
            $data = $orderModel->getMonthlyStatistics($year, $statusFilter);
            $filename = 'thong_ke_don_hang_thang_' . $year . '.csv';
        } elseif ($tab === 'quarter') {
            $data = $orderModel->getQuarterlyStatistics($year, $statusFilter);
            $filename = 'thong_ke_don_hang_quy_' . $year . '.csv';
        } else {
            $data = $orderModel->getYearlyStatistics($statusFilter);
            $filename = 'thong_ke_don_hang_theo_nam.csv';
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Xuất UTF-8 BOM để Excel hiển thị dấu tiếng Việt chuẩn
        echo "\xEF\xBB\xBF";

        $output = fopen('php://output', 'w');

        // Thông tin tiêu đề
        fputcsv($output, array('BÁO CÁO THỐNG KÊ ĐƠN HÀNG - BOOKSTORE'));
        fputcsv($output, array('Chu kỳ:', ($tab === 'month' ? 'Theo Tháng' : ($tab === 'quarter' ? 'Theo Quý' : 'Theo Năm'))));
        if ($tab !== 'year') {
            fputcsv($output, array('Năm áp dụng:', $year));
        }
        fputcsv($output, array('Trạng thái đơn:', ($statusFilter === 'completed' ? 'Đã hoàn thành' : ($statusFilter === 'all' ? 'Tất cả đơn' : 'Đơn hợp lệ (trừ hủy)'))));
        fputcsv($output, array('Thời điểm xuất:', date('d/m/Y H:i:s')));
        fputcsv($output, array(''));

        // Cột
        $headers = array('STT', 'Thời gian', 'Số đơn hàng', 'Số lượng sản phẩm', 'Tổng thành tiền (VNĐ)', 'Giá trị đơn TB (VNĐ)');
        if ($tab === 'year') {
            $headers[] = 'Tăng trưởng doanh thu (%)';
        }
        fputcsv($output, $headers);

        $stt = 1;
        $totalOrders = 0;
        $totalProducts = 0;
        $totalAmount = 0.0;

        foreach ($data as $row) {
            $timeLabel = '';
            if ($tab === 'month') {
                $timeLabel = $row['month_label'];
            } elseif ($tab === 'quarter') {
                $timeLabel = $row['quarter_label'] . ' (' . $row['months_label'] . ')';
            } else {
                $timeLabel = $row['year_label'];
            }

            $line = array(
                $stt++,
                $timeLabel,
                $row['total_orders'],
                $row['total_products'],
                number_format($row['total_amount'], 0, ',', '.'),
                number_format($row['avg_order_value'], 0, ',', '.')
            );

            if ($tab === 'year') {
                $line[] = ($row['growth_rate'] !== null) ? ($row['growth_rate'] . '%') : '-';
            }

            fputcsv($output, $line);

            $totalOrders += (int)$row['total_orders'];
            $totalProducts += (int)$row['total_products'];
            $totalAmount += (float)$row['total_amount'];
        }

        $avgAll = ($totalOrders > 0) ? ($totalAmount / $totalOrders) : 0;
        $totalLine = array('TỔNG CỘNG', '', $totalOrders, $totalProducts, number_format($totalAmount, 0, ',', '.'), number_format($avgAll, 0, ',', '.'));
        if ($tab === 'year') {
            $totalLine[] = '';
        }
        fputcsv($output, $totalLine);

        fclose($output);
        exit;
    }
}

