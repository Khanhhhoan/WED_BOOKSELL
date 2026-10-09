<?php
/**
 * Kết nối MySQL — tên database phải trùng database trong phpMyAdmin (mặc định: bookstore).
 * Tự động đọc biến môi trường nếu chạy trên Render / Cloud Server.
 */
$envHost = getenv('DB_HOST');
$envUser = getenv('DB_USER');
$envPass = getenv('DB_PASS');
$envName = getenv('DB_NAME');
$envPort = getenv('DB_PORT');
$envBaseUrl = getenv('BASE_URL');

define('DB_HOST', ($envHost !== false && $envHost !== '') ? $envHost : 'localhost');
define('DB_USER', ($envUser !== false && $envUser !== '') ? $envUser : 'root');
define('DB_PASS', ($envPass !== false) ? $envPass : '');
define('DB_NAME', ($envName !== false && $envName !== '') ? $envName : 'bookstore');
define('DB_PORT', ($envPort !== false && $envPort !== '') ? $envPort : '3306');

define('BASE_URL', ($envBaseUrl !== false && $envBaseUrl !== '') ? $envBaseUrl : '/WedSach/bookstore/public/');

/**
 * Thư mục ảnh bìa trên đĩa: {gốc dự án}/public/assets/images.
 * Tính từ vị trí file này (config/database.php) — không phụ thuộc CWD hay hằng PUBLIC_ROOT.
 */
function book_image_disk_dir() {
    // dirname(__FILE__) thay vì __DIR__ — tương thích PHP 5.2
    $projectRoot = dirname(dirname(__FILE__));
    $indexInPublic = $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.php';
    if (!is_file($indexInPublic)) {
        if (is_file($projectRoot . DIRECTORY_SEPARATOR . 'index.php')) {
            $projectRoot = dirname($projectRoot);
        }
    }
    return $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images';
}

/**
 * URL hiển thị ảnh — trong DB chỉ lưu tên file; tên này do upload tự gán (book_*.jpg).
 */
function book_image_url($filename) {
    if (!defined('BASE_URL')) {
        return 'https://placehold.co/400x600?text=Book+Cover';
    }
    $fn = isset($filename) ? trim((string) $filename) : '';
    if ($fn === '') {
        return 'https://placehold.co/400x600?text=Book+Cover';
    }
    $fn = basename(str_replace('\\', '/', $fn));
    $uploadDir = book_image_disk_dir();
    $dir = realpath($uploadDir);
    if ($dir === false) {
        $dir = $uploadDir;
    }
    $resolvedName = $fn;
    $full = $dir . DIRECTORY_SEPARATOR . $fn;
    if (!is_file($full) && is_dir($dir)) {
        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            if (strcasecmp($entry, $fn) === 0) {
                $resolvedName = $entry;
                $full = $dir . DIRECTORY_SEPARATOR . $entry;
                break;
            }
        }
    }
    $path = rtrim(BASE_URL, '/') . '/assets/images/' . rawurlencode($resolvedName);
    if (is_file($full) && is_readable($full)) {
        return $path . '?v=' . (int) filemtime($full);
    }
    return $path . '?v=' . substr(md5($resolvedName), 0, 10);
}

/**
 * Thư mục vật lý lưu ảnh bài viết: public/assets/images/posts
 */
function post_image_disk_dir() {
    $projectRoot = dirname(dirname(__FILE__));
    return $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'posts';
}

/**
 * URL hiển thị ảnh bài viết — an toàn, tương thích mọi môi trường
 */
function post_image_url($filename) {
    if (!defined('BASE_URL')) {
        return 'https://placehold.co/800x500/1a5f4a/ffffff?text=BookStore+News';
    }
    $fn = isset($filename) ? trim((string) $filename) : '';
    if ($fn === '') {
        return 'https://placehold.co/800x500/1a5f4a/ffffff?text=BookStore+News';
    }
    if (strpos($fn, 'http://') === 0 || strpos($fn, 'https://') === 0) {
        return $fn;
    }
    $fn = basename(str_replace('\\', '/', $fn));
    $uploadDir = post_image_disk_dir();
    $full = $uploadDir . DIRECTORY_SEPARATOR . $fn;
    if (is_file($full) && is_readable($full)) {
        return rtrim(BASE_URL, '/') . '/assets/images/posts/' . rawurlencode($fn) . '?v=' . (int) filemtime($full);
    }
    return 'https://placehold.co/800x500/1a5f4a/ffffff?text=BookStore+News';
}

