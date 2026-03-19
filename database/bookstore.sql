CREATE DATABASE IF NOT EXISTS bookstore CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE bookstore;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipping','completed','cancelled') DEFAULT 'pending',
  `shipping_name` varchar(100) NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `method` enum('cod','online') DEFAULT 'cod',
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dá»¯ liá»‡u máº«u (Seed Data)
-- Máº­t kháº©u cho cáº£ admin vÃ  user: "password" (Ä‘Ã£ hash báº±ng password_hash máº·c Ä‘á»‹nh)
INSERT INTO `users` (`full_name`, `email`, `password`, `phone`, `role`) VALUES
('Administrator', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0123456789', 'admin'),
('Nguyá»…n VÄƒn KhÃ¡ch', 'user@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0987654321', 'user');

INSERT INTO `categories` (`name`, `description`) VALUES 
('Tiá»ƒu thuyáº¿t', 'Nhá»¯ng cÃ¢u chuyá»‡n tiá»ƒu thuyáº¿t Ä‘áº·c sáº¯c'),
('Kinh táº¿', 'SÃ¡ch vá» kinh táº¿, quáº£n trá»‹ kinh doanh, Ä‘áº§u tÆ°'),
('Ká»¹ nÄƒng sá»‘ng', 'PhÃ¡t triá»ƒn báº£n thÃ¢n, ká»¹ nÄƒng má»m'),
('CÃ´ng nghá»‡', 'SÃ¡ch CNTT, láº­p trÃ¬nh, khoa há»c mÃ¡y tÃ­nh'),
('Thiáº¿u nhi', 'SÃ¡ch truyá»‡n dÃ nh cho tráº» em');

INSERT INTO `authors` (`name`, `bio`) VALUES
('Nguyá»…n Nháº­t Ãnh', 'NhÃ  vÄƒn ná»•i tiáº¿ng cá»§a Viá»‡t Nam vá»›i nhiá»u tÃ¡c pháº©m tuá»•i thÆ¡'),
('Paulo Coelho', 'NhÃ  vÄƒn Brazil ná»•i tiáº¿ng tháº¿ giá»›i vá»›i tÃ¡c pháº©m NhÃ  Giáº£ Kim'),
('Robert T. Kiyosaki', 'Doanh nhÃ¢n, nhÃ  Ä‘áº§u tÆ°, tÃ¡c giáº£ ngÆ°á»i Má»¹');

INSERT INTO `books` (`title`, `category_id`, `author_id`, `price`, `description`, `image`, `stock`) VALUES
('Cho TÃ´i Xin Má»™t VÃ© Äi Tuá»•i ThÆ¡', 1, 1, 65000, 'Truyá»‡n dÃ i cá»§a Nguyá»…n Nháº­t Ãnh, Ä‘Æ°a ngÆ°á»i Ä‘á»c vá» tuá»•i thÆ¡ tÆ°Æ¡i Ä‘áº¹p', 'cho-toi-xin-1-ve.jpg', 50),
('NhÃ  Giáº£ Kim', 1, 2, 79000, 'Cuá»‘n sÃ¡ch bÃ¡n cháº¡y nháº¥t má»i thá»i Ä‘áº¡i vá» hÃ nh trÃ¬nh theo Ä‘uá»•i Æ°á»›c mÆ¡', 'nha-gia-kim.jpg', 100),
('Cha GiÃ u Cha NghÃ¨o', 2, 3, 110000, 'Cuá»‘n sÃ¡ch dáº¡y con lÃ m giÃ u ná»•i tiáº¿ng', 'cha-giau-cha-ngheo.jpg', 30),
('Nháº­p MÃ´n Láº­p TrÃ¬nh Web PHP', 4, NULL, 150000, 'GiÃ¡o trÃ¬nh PHP cÆ¡ báº£n dÃ nh cho sinh viÃªn IT', 'php-basic.jpg', 20);

INSERT INTO `posts` (`title`, `excerpt`, `content`) VALUES
('10 Cuá»‘n SÃ¡ch NÃªn Äá»c Trong Äá»i', 'Danh sÃ¡ch cÃ¡c cuá»‘n sÃ¡ch gá»‘i Ä‘áº§u giÆ°á»ng báº¡n khÃ´ng nÃªn bá» lá»¡', 'Ná»™i dung chi tiáº¿t cá»§a bÃ i viáº¿t sáº½ Ä‘Æ°á»£c mÃ´ táº£ á»Ÿ Ä‘Ã¢y...'),
('Lá»£i Ãch Cá»§a Viá»‡c Äá»c SÃ¡ch Má»—i NgÃ y', 'Táº¡i sao báº¡n nÃªn Ä‘á»c sÃ¡ch Ã­t nháº¥t 30 phÃºt má»—i ngÃ y?', 'Äá»c sÃ¡ch giÃºp phÃ¡t triá»ƒn báº£n thÃ¢n, tÄƒng cÆ°á»ng trÃ­ nhá»›, cáº£i thiá»‡n ká»¹ nÄƒng giao tiáº¿p...');
