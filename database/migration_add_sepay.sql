-- ========================================================
-- Migration: Bổ sung Cổng Thanh Toán SePay & Bảng Log Thanh Toán
-- ========================================================

-- 1. Cập nhật bảng payments hỗ trợ phương thức SePay
ALTER TABLE `payments` MODIFY COLUMN `method` VARCHAR(50) DEFAULT 'cod';
ALTER TABLE `payments` MODIFY COLUMN `status` VARCHAR(50) DEFAULT 'pending';

-- 2. Tạo bảng lưu Log giao dịch thanh toán SePay
CREATE TABLE IF NOT EXISTS `payment_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `gateway` varchar(50) DEFAULT 'SePay',
  `transaction_date` varchar(50) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `sub_account` varchar(50) DEFAULT NULL,
  `transfer_type` varchar(20) DEFAULT 'in',
  `transfer_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `accumulated` decimal(15,2) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `reference_code` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'success',
  `raw_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `reference_code` (`reference_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 3. Tạo bảng lưu cấu hình SePay
CREATE TABLE IF NOT EXISTS `sepay_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 4. Chèn dữ liệu cấu hình SePay ban đầu (Mặc định)
INSERT IGNORE INTO `sepay_settings` (`setting_key`, `setting_value`) VALUES
('sepay_bank', 'MBBank'),
('sepay_account_no', '0827930928'),
('sepay_account_name', 'NGUYEN HOANG KHANH'),
('sepay_api_key', ''),
('sepay_prefix', 'DH'),
('sepay_qr_template', 'compact'),
('sepay_is_active', '1');
