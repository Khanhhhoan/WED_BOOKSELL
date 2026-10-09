<?php
/**
 * Cấu hình Cổng thanh toán SePay (Chuyển khoản ngân hàng tự động / VietQR)
 * Tương thích PHP 5.2
 */

define('SEPAY_DEFAULT_BANK', 'MBBank');
define('SEPAY_DEFAULT_ACCOUNT_NO', '0827930928');
define('SEPAY_DEFAULT_ACCOUNT_NAME', 'NGUYEN HOANG KHANH');
define('SEPAY_DEFAULT_API_KEY', '');
define('SEPAY_DEFAULT_PREFIX', 'DH');
define('SEPAY_DEFAULT_QR_TEMPLATE', 'compact');

/**
 * Lấy danh sách hoặc giá trị cấu hình SePay (Ưu tiên đọc từ DB sepay_settings)
 */
function get_sepay_config($key = null) {
    static $cachedSettings = null;

    if ($cachedSettings === null) {
        $cachedSettings = array(
            'sepay_bank' => SEPAY_DEFAULT_BANK,
            'sepay_account_no' => SEPAY_DEFAULT_ACCOUNT_NO,
            'sepay_account_name' => SEPAY_DEFAULT_ACCOUNT_NAME,
            'sepay_api_key' => SEPAY_DEFAULT_API_KEY,
            'sepay_prefix' => SEPAY_DEFAULT_PREFIX,
            'sepay_qr_template' => SEPAY_DEFAULT_QR_TEMPLATE,
            'sepay_is_active' => '1'
        );

        // Đọc từ Database nếu kết nối đã sẵn sàng
        try {
            if (class_exists('Database')) {
                $db = new Database();
                $db->query("SELECT setting_key, setting_value FROM sepay_settings");
                $rows = $db->resultSet();
                if ($rows && is_array($rows)) {
                    foreach ($rows as $row) {
                        $k = $row['setting_key'];
                        $v = $row['setting_value'];
                        $cachedSettings[$k] = $v;
                    }
                }
            }
        } catch (Exception $e) {
            // Sử dụng mặc định nếu DB chưa load hoặc lỗi
        }
    }

    if ($key !== null) {
        return isset($cachedSettings[$key]) ? $cachedSettings[$key] : '';
    }
    return $cachedSettings;
}

/**
 * Lấy URL Webhook tuyệt đối của hệ thống
 */
function get_sepay_webhook_url() {
    $protocol = 'http';
    if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
        $protocol = 'https';
    }
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:88';
    $baseUrl = defined('BASE_URL') ? BASE_URL : '/WedSach/bookstore/public/';
    return $protocol . '://' . $host . rtrim($baseUrl, '/') . '/sepay/webhook';
}

/**
 * Sinh link ảnh mã VietQR SePay
 */
function generate_sepay_qr_url($bank, $acc, $amount, $des, $template = 'compact') {
    $bankClean = trim((string)$bank);
    $accClean = trim((string)$acc);
    $amountClean = (int)$amount;
    $desClean = trim((string)$des);
    $tplClean = trim((string)$template);
    if ($tplClean === '') {
        $tplClean = 'compact';
    }

    return 'https://qr.sepay.vn/img?acc=' . rawurlencode($accClean) 
        . '&bank=' . rawurlencode($bankClean) 
        . '&amount=' . $amountClean 
        . '&des=' . rawurlencode($desClean) 
        . '&template=' . rawurlencode($tplClean);
}
