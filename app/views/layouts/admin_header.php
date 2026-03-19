<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'Quản Trị Hệ Thống - BookStore' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; width: 250px; position: fixed; top: 0; left: 0; padding-top: 60px; z-index: 10; transition: 0.3s; }
        .sidebar a { color: #c2c7d0; text-decoration: none; display: block; padding: 10px 20px; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { color: white; background-color: #007bff; border-radius: 5px; margin: 0 10px; padding-left: 15px; }
        .main-content { margin-left: 250px; padding: 20px; padding-top: 70px; }
        .top-navbar { position: fixed; top: 0; left: 250px; right: 0; height: 60px; z-index: 11; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    
    <!-- Top Navbar -->
    <header class="top-navbar d-flex align-items-center justify-content-between px-4">
        <h5 class="mb-0 text-dark fw-bold">Admin Panel</h5>
        <div class="dropdown">
            <a href="#" class="text-dark text-decoration-none dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                <i class="fas fa-user-shield me-1 text-primary"></i> <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin' ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="<?php echo  BASE_URL ?>"><i class="fas fa-external-link-alt me-2"></i>Xem Website</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?php echo  BASE_URL ?>auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
            </ul>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <nav class="sidebar shadow">
        <div class="text-center mb-4">
            <h4 class="text-white fw-bold"><i class="fas fa-book-open text-primary me-2"></i>BookStore</h4>
        </div>
        
        <p class="text-uppercase text-muted px-3 small fw-bold mb-1">Hệ Thống</p>
        <a href="<?php echo  BASE_URL ?>admin" class="<?php echo  (!isset($_GET['url']) || $_GET['url'] == 'admin') ? 'active' : '' ?> mb-1"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        
        <p class="text-uppercase text-muted px-3 small fw-bold mb-1 mt-3">Quản Lý</p>
        <a href="<?php echo  BASE_URL ?>admin/categories" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/categor') !== false) ? 'active' : '' ?> mb-1"><i class="fas fa-tags me-2"></i> Danh mục</a>
        <a href="<?php echo  BASE_URL ?>admin/books" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/book') !== false) ? 'active' : '' ?> mb-1"><i class="fas fa-book me-2"></i> Sách</a>
        <a href="<?php echo  BASE_URL ?>admin/orders" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/order') !== false) ? 'active' : '' ?> mb-1"><i class="fas fa-shopping-cart me-2"></i> Đơn hàng</a>
        <a href="<?php echo  BASE_URL ?>admin/posts" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/post') !== false) ? 'active' : '' ?> mb-1"><i class="fas fa-newspaper me-2"></i> Bài viết</a>
        <a href="<?php echo  BASE_URL ?>admin/users" class="<?php echo  (isset($_GET['url']) && strpos($_GET['url'], 'admin/user') !== false) ? 'active' : '' ?> mb-1"><i class="fas fa-users me-2"></i> Người dùng</a>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="main-content">
        <div class="container-fluid">
            <?php Session::flash('msg'); ?>
            <?php Session::flash('error', '', 'alert alert-danger shadow-sm'); ?>
