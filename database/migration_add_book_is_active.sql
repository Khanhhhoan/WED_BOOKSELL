-- Chạy một lần trên CSDL đang dùng (phpMyAdmin / MySQL client)
USE bookstore;

ALTER TABLE `books`
  ADD COLUMN `is_active` TINYINT(1) NOT NULL DEFAULT 1 AFTER `stock`;
