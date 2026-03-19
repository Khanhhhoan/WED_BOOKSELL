<?php
class AdminController extends Controller {
    
    public function __construct() {
        // B?o v? route: Ch? Admin m?i du?c v�o
        if (!Session::isLoggedIn() || $_SESSION['user_role'] !== 'admin') {
            Session::flash('error', 'B?n kh�ng c� quy?n truy c?p trang qu?n tr?!');
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
            'title' => 'Dashboard - Qu?n Tr? H? Th?ng',
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
            'title' => 'Qu?n L� Danh M?c',
            'categories' => $categories
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/categories/index', $data);
        $this->view('layouts/admin_footer');
    }

    public function category_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = array(
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
            );

            if (!empty($data['name'])) {
                $categoryModel = $this->model('CategoryModel');
                if ($categoryModel->addCategory($data)) {
                    Session::flash('msg', 'Th�m danh m?c th�nh c�ng!');
                    $this->redirect('admin/categories');
                } else {
                    die('L?i h? th?ng khi th�m danh m?c');
                }
            } else {
                Session::flash('error', 'T�n danh m?c kh�ng du?c d? tr?ng!');
                $this->redirect('admin/categories');
            }
        }
    }

    public function category_edit($id) {
        $categoryModel = $this->model('CategoryModel');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = array(
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
            );

            if (!empty($data['name'])) {
                if ($categoryModel->updateCategory($data)) {
                    Session::flash('msg', 'C?p nh?t danh m?c th�nh c�ng!');
                    $this->redirect('admin/categories');
                } else {
                    die('L?i c?p nh?t');
                }
            } else {
                Session::flash('error', 'T�n danh m?c kh�ng du?c r?ng.');
                $this->redirect('admin/categories');
            }
        } else {
            // L?y th�ng tin form
            $category = $categoryModel->getCategoryById($id);
            if (!$category) {
                $this->redirect('admin/categories');
            }
            
            $data = array(
                'title' => 'S?a Danh M?c',
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
            
            // Note: �� set CASCADE trong DB n�n khi xo� Danh m?c -> S�ch thu?c danh m?c cung s? xo� (Ho?c set null t�y logic). Schema hi?n t?i l� CASCADE.
            if ($categoryModel->deleteCategory($id)) {
                Session::flash('msg', '�� x�a danh m?c th�nh c�ng!');
            } else {
                Session::flash('error', 'L?i x�a danh m?c!');
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
            'title' => 'Qu?n L� �on H�ng',
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

        $data = array(
            'title' => 'Chi Ti?t �on H�ng #ORD' . $id,
            'order' => $order,
            'items' => $items
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
                Session::flash('msg', 'C?p nh?t tr?ng th�i don h�ng th�nh c�ng!');
            } else {
                Session::flash('error', 'C?p nh?t tr?ng th�i th?t b?i.');
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
            'title' => 'Qu?n L� B�i Vi?t',
            'posts' => $posts
        );

        $this->view('layouts/admin_header', $data);
        $this->view('admin/posts/index', $data);
        $this->view('layouts/admin_footer');
    }

    // Note: Add/Edit Post Form tuong t? Category, t�i s? skip code HTML chi ti?t form d? ng?n g?n trong project
    public function post_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = array(
                'title' => trim((string)$_POST['title']),
                'excerpt' => isset($_POST['excerpt']) ? trim((string)$_POST['excerpt']) : '',
                'content' => isset($_POST['content']) ? trim((string)$_POST['content']) : '',
                'image' => isset($_POST['image']) ? trim((string)$_POST['image']) : ''
            );
            $postModel = $this->model('PostModel');
            if ($postModel->addPost($data)) {
                Session::flash('msg', 'Thêm bài viết mới thành công!');
                $this->redirect('admin/posts');
            } else {
                die('Có lỗi xảy ra khi lưu bài viết.');
            }
        } else {
            $data = array('title' => 'Thêm Bài Viết');
            $this->view('layouts/admin_header', $data);
            $this->view('admin/posts/add', $data);
            $this->view('layouts/admin_footer');
        }
    }

    public function post_edit($id) {
        $postModel = $this->model('PostModel');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = array(
                'id' => $id,
                'title' => trim((string)$_POST['title']),
                'excerpt' => isset($_POST['excerpt']) ? trim((string)$_POST['excerpt']) : '',
                'content' => isset($_POST['content']) ? trim((string)$_POST['content']) : '',
                'image' => isset($_POST['image']) ? trim((string)$_POST['image']) : ''
            );
            if ($postModel->updatePost($data)) {
                Session::flash('msg', 'Cập nhật bài viết thành công!');
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
                Session::flash('msg', '�� x�a b�i vi?t kh?i h? th?ng.');
            }
            $this->redirect('admin/posts');
        }
    }

    // ==========================================
    // MODULE: BOOKS (S�CH)
    // ==========================================
    public function books() {
        $bookModel = $this->model('BookModel');
        $books = $bookModel->getAllBooks(); // L?y t?t c? s�ch
        
        $categoryModel = $this->model('CategoryModel');
        $categories = $categoryModel->getAllCategories(); // L?y danh m?c cho form Add/Edit

        $data = array(
            'title' => 'Qu?n L� S�ch',
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = array(
                'title' => trim((string)$_POST['title']),
                'category_id' => trim((string)$_POST['category_id']),
                'author_id' => !empty($_POST['author_id']) ? trim((string)$_POST['author_id']) : null,
                'price' => trim((string)$_POST['price']),
                'stock' => trim((string)$_POST['stock']),
                'description' => isset($_POST['description']) ? trim((string)$_POST['description']) : '',
                'image' => isset($_POST['image']) ? trim((string)$_POST['image']) : ''
            );
            $bookModel = $this->model('BookModel');
            if ($bookModel->addBook($data)) {
                Session::flash('msg', 'Thêm sách thành công!');
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = array(
                'id' => $id,
                'title' => trim((string)$_POST['title']),
                'category_id' => trim((string)$_POST['category_id']),
                'author_id' => !empty($_POST['author_id']) ? trim((string)$_POST['author_id']) : null,
                'price' => trim((string)$_POST['price']),
                'stock' => trim((string)$_POST['stock']),
                'description' => isset($_POST['description']) ? trim((string)$_POST['description']) : '',
                'image' => isset($_POST['image']) ? trim((string)$_POST['image']) : ''
            );
            if ($bookModel->updateBook($data)) {
                Session::flash('msg', 'Cập nhật sách thành công!');
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
            if ($bookModel->deleteBook($id)) {
                Session::flash('msg', '�� x�a S�ch th�nh c�ng.');
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
            'title' => 'Qu?n L� Ngu?i D�ng',
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
                Session::flash('msg', '�� x�a ngu?i d�ng th�nh c�ng.');
            } else {
                Session::flash('error', 'Kh�ng th? x�a Admin ho?c l?i h? th?ng.');
            }
            $this->redirect('admin/users');
        }
    }
}

