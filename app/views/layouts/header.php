<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'Nhà Sách Trực Tuyến' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo  BASE_URL ?>assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo  BASE_URL ?>">
                <i class="fas fa-book-open me-2"></i>BookStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo  BASE_URL ?>">Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo  BASE_URL ?>book">Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo  BASE_URL ?>post">Tin Tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo  BASE_URL ?>home/contact">Liên Hệ</a>
                    </li>
                </ul>

                <form class="d-flex mx-auto" action="<?php echo  BASE_URL ?>book" method="GET">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm kiếm sách..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="<?php echo  BASE_URL ?>cart">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo  isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
                            </span>
                        </a>
                    </li>
                    <?php if (Session::isLoggedIn()) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> <?php echo  $_SESSION['user_name'] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo  BASE_URL ?>order/history">Đơn hàng của tôi</a></li>
                                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                                    <li><a class="dropdown-item text-primary" href="<?php echo  BASE_URL ?>admin">Quản trị viên</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo  BASE_URL ?>auth/logout">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo  BASE_URL ?>auth/login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="<?php echo  BASE_URL ?>auth/register">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="min-vh-100">
        <div class="container mt-4">
            <?php Session::flash('msg'); ?>
            <?php Session::flash('error', '', 'alert alert-danger'); ?>
