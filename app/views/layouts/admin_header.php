<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'Quản Trị Hệ Thống - BookStore' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* Cùng màu chủ đề với storefront (public/assets/css/style.css :root) */
        :root {
            --bs-primary: #1a5f4a;
            --bs-primary-rgb: 26, 95, 74;
            --bs-link-color: #1a5f4a;
            --bs-link-hover-color: #134436;
        }
        /* Một bộ sans-serif cho toàn admin (tránh chỗ serif ở ô nhập / bảng) */
        html, body {
            font-family: system-ui, -apple-system, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f3f5;
            color: #212529;
        }
        .main-content,
        .main-content .table,
        .main-content .table td,
        .main-content .table th,
        .main-content .form-control,
        .main-content .form-select,
        .main-content textarea,
        .main-content .input-group-text,
        .main-content .btn {
            font-family: system-ui, -apple-system, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }
        .main-content .form-control::placeholder,
        .main-content textarea::placeholder {
            font-family: inherit;
            opacity: 0.75;
        }
        .sidebar { min-height: 100vh; background-color: #343a40; color: #fff; width: 250px; position: fixed; top: 0; left: 0; padding-top: 60px; z-index: 10; transition: 0.3s; }
        .sidebar .sidebar-section-title {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.7rem;
            letter-spacing: 0.07em;
        }
        .sidebar a { color: #dee2e6; text-decoration: none; display: block; padding: 10px 20px; font-weight: 500; border-radius: 6px; margin: 0 8px; }
        .sidebar a:hover { color: #fff; background-color: rgba(255,255,255,0.08); }
        .sidebar a.active { color: #fff; background-color: #495057; }
        .main-content { margin-left: 250px; padding: 20px; padding-top: 70px; }
        .top-navbar { position: fixed; top: 0; left: 250px; right: 0; height: 60px; z-index: 11; background: #fff; border-bottom: 1px solid #dee2e6; box-shadow: none; }
        .admin-stat-card { border: 1px solid #dee2e6; border-radius: 6px; background: #fff; }
        .admin-stat-label { font-size: 0.72rem; letter-spacing: 0.05em; color: #6c757d; text-transform: uppercase; }
        .admin-badge-pill { font-weight: 500; font-size: 0.8rem; padding: 0.35em 0.65em; border: 1px solid #dee2e6; background: #f8f9fa; color: #212529; }
        .admin-badge-pill.text-danger { background: #fff; border-color: #f1aeb5; color: #b02a37; }
    </style>
</head>
<body>
    
    <!-- Top Navbar -->
    <header class="top-navbar d-flex align-items-center justify-content-between px-4">
        <h5 class="mb-0 text-dark fw-bold">Admin Panel</h5>
        <div class="dropdown">
            <a href="#" class="text-dark text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin' ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="<?php echo  BASE_URL ?>">Xem Website</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?php echo  BASE_URL ?>auth/logout">Đăng xuất</a></li>
            </ul>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <nav class="sidebar shadow">
        <div class="text-center mb-4">
            <h4 class="text-white fw-bold">BookStore</h4>
        </div>
        
        <p class="sidebar-section-title px-3 small fw-bold mb-1 text-uppercase">Hệ thống</p>
        <a href="<?php echo  BASE_URL ?>admin" class="<?php echo  (!isset($_GET['url']) || $_GET['url'] == 'admin') ? 'active' : '' ?> mb-1">Dashboard</a>
        
        <p class="sidebar-section-title px-3 small fw-bold mb-1 mt-3 text-uppercase">Quản lý</p>
        <a href="<?php echo  BASE_URL ?>admin/categories" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/categor') !== false) ? 'active' : '' ?> mb-1">Danh mục</a>
        <a href="<?php echo  BASE_URL ?>admin/books" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/book') !== false) ? 'active' : '' ?> mb-1">Sách</a>
        <a href="<?php echo  BASE_URL ?>admin/orders" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/order') !== false) ? 'active' : '' ?> mb-1">Đơn hàng</a>
        <a href="<?php echo  BASE_URL ?>admin/posts" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/post') !== false) ? 'active' : '' ?> mb-1">Bài viết</a>
        <a href="<?php echo  BASE_URL ?>admin/users" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/user') !== false) ? 'active' : '' ?> mb-1">Người dùng</a>

        <p class="sidebar-section-title px-3 small fw-bold mb-1 mt-3 text-uppercase">Báo cáo & Thống kê</p>
        <a href="<?php echo  BASE_URL ?>admin/statistics" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/statistic') !== false) ? 'active' : '' ?> mb-1">Thống kê đơn hàng</a>

        <p class="sidebar-section-title px-3 small fw-bold mb-1 mt-3 text-uppercase">Cổng thanh toán</p>
        <a href="<?php echo  BASE_URL ?>admin/payments" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/payment') !== false) ? 'active' : '' ?> mb-1">Lịch sử thanh toán</a>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="main-content">
        <div class="container-fluid">
            <?php Session::flash('msg'); ?>
            <?php Session::flash('error', '', 'alert alert-danger shadow-sm'); ?>
