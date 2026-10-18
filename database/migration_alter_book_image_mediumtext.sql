-- Chạy trên phpMyAdmin hoặc Cloud MySQL client (Aiven) nếu muốn cập nhật ngay lập tức thủ công:
USE bookstore;

ALTER TABLE `books` MODIFY COLUMN `image` MEDIUMTEXT NULL;
ALTER TABLE `posts` MODIFY COLUMN `image` MEDIUMTEXT NULL;
