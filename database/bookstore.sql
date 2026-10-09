-- MySQL dump 10.11
--
-- Host: localhost    Database: bookstore
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `authors` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `bio` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'Nguyễn Nhật Ánh','Nhà văn nổi tiếng của Việt Nam với nhiều tác phẩm tuổi thơ xuất sắc.'),(2,'Paulo Coelho','Nhà văn Brazil nổi tiếng thế giới với kiệt tác Nhà Giả Kim.'),(3,'Robert T. Kiyosaki','Doanh nhân, nhà đầu tư, tác giả bộ sách Dạy Con Làm Giàu.');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `books` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) default NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text collate utf8_unicode_ci,
  `image` varchar(255) collate utf8_unicode_ci default NULL,
  `stock` int(11) default '0',
  `is_active` tinyint(1) NOT NULL default '1',
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `books_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Cho Tôi Xin Một Vé Đi Tuổi Thơ',1,1,'65000.00','Truyện dài kinh điển của nhà văn Nguyễn Nhật Ánh, đưa người đọc trở về những năm tháng ấu thơ tươi đẹp và trong trẻo nhất.','book_20260322_235855_6239.jpg',46,1,'2026-03-19 14:35:38'),(2,'Nhà Giả Kim',1,2,'79000.00','Cuốn sách bán chạy nhất mọi thời đại của Paulo Coelho về hành trình theo đuổi ước mơ và lắng nghe tiếng gọi trái tim.','book_20260322_234711_1602.jpg',99,1,'2026-03-19 14:35:38'),(3,'Ngàn Mặt Trời Rực Rỡ',1,3,'110000.00','Kiệt tác văn học cảm động lay động hàng triệu trái tim về số phận con người và tình mẫu tử bất diệt.','book_20260322_233357_6460.jpg',25,1,'2026-03-19 14:35:38'),(4,'AI: Chuyện Chưa Kể',4,NULL,'150000.00','Khám phá bức tranh toàn cảnh về cuộc cách mạng trí tuệ nhân tạo (AI) và cách công nghệ đang tái định hình tương lai nhân loại.','book_20260323_001911_9481.jpg',19,1,'2026-03-19 14:35:38'),(5,'Công Thức Và Hàm Excel',5,NULL,'44545.00','Cẩm nang tra cứu và ứng dụng toàn diện các công thức, hàm xử lý dữ liệu từ cơ bản đến nâng cao cho người đi làm.','book_20260323_002240_8488.jpg',79,1,'2026-03-20 03:45:01'),(6,'Hiểu Về Tình Yêu',6,NULL,'15000.00','Những suy ngẫm sâu sắc và tinh tế về tình cảm lứa đôi, sự thấu cảm và nghệ thuật gìn giữ hạnh phúc bền lâu.','book_20260323_003842_3462.jpg',50,1,'2026-03-22 17:38:42');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Tiểu thuyết','Những câu chuyện tiểu thuyết và văn học đặc sắc'),(2,'Kinh tế & Đầu tư','Sách về kinh tế, quản trị kinh doanh và tài chính'),(3,'Kỹ năng sống','Phát triển bản thân, tư duy tích cực và kỹ năng mềm'),(4,'Công nghệ & AI','Sách công nghệ thông tin, trí tuệ nhân tạo và kỹ thuật số'),(5,'Thiếu nhi','Sách truyện nuôi dưỡng tâm hồn trẻ thơ'),(6,'Tâm lý & Tình cảm','Thấu hiểu cảm xúc, tình yêu và cuộc sống');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,1,'65000.00'),(2,2,5,1,'44545.00'),(3,3,2,1,'79000.00'),(4,4,3,3,'110000.00'),(5,5,3,2,'110000.00'),(8,8,1,1,'65000.00'),(9,9,5,1,'44545.00'),(10,9,4,1,'150000.00');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipping','completed','cancelled') collate utf8_unicode_ci default 'pending',
  `shipping_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `shipping_phone` varchar(20) collate utf8_unicode_ci NOT NULL,
  `shipping_address` text collate utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,'65000.00','completed','KhÃ¡nh Nguyá»…n','087930928','hcm','2026-03-19 14:36:42'),(2,3,'44545.00','completed','KhÃ¡nh Nguyá»…n','0827930928','hcm','2026-03-20 03:47:38'),(3,1,'79000.00','completed','Administrator','0123456789','hcn','2026-03-22 15:37:12'),(4,4,'330000.00','confirmed','Thanh Binh','123456789','hcm','2026-03-22 17:31:08'),(5,3,'220000.00','pending','KhÃ¡nh Nguyá»…n','0123456789','sdsd','2026-03-22 17:36:22'),(8,1,'65000.00','completed','Administrator','0123456789','hcm','2026-10-09 10:03:11'),(9,5,'194545.00','cancelled','Khánh Khánh','0123456987','hcm','2026-10-09 18:26:24');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_logs`
--

DROP TABLE IF EXISTS `payment_logs`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payment_logs` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) default NULL,
  `gateway` varchar(50) default 'SePay',
  `transaction_date` varchar(50) default NULL,
  `account_number` varchar(50) default NULL,
  `sub_account` varchar(50) default NULL,
  `transfer_type` varchar(20) default 'in',
  `transfer_amount` decimal(12,2) NOT NULL default '0.00',
  `accumulated` decimal(15,2) default NULL,
  `code` varchar(100) default NULL,
  `content` text,
  `reference_code` varchar(100) default NULL,
  `description` text,
  `status` varchar(50) NOT NULL default 'success',
  `raw_data` text,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  KEY `reference_code` (`reference_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `payment_logs`
--

LOCK TABLES `payment_logs` WRITE;
/*!40000 ALTER TABLE `payment_logs` DISABLE KEYS */;
INSERT INTO `payment_logs` VALUES (1,8,'MBBank','2026-10-09 17:03:00','0827930928','','in','65000.00','0.00','','150837658124-DH8-CHUYEN TIEN-OQCH000M2LgR-MOMO150837658124MOMO','FT26282781063297','Thanh toÃ¡n thÃ nh cÃ´ng Ä‘Æ¡n hÃ ng #ORD8 qua MBBank','success','{\"gateway\":\"MBBank\",\"transactionDate\":\"2026-10-09 17:03:00\",\"accountNumber\":\"0827930928\",\"subAccount\":null,\"code\":null,\"content\":\"150837658124-DH8-CHUYEN TIEN-OQCH000M2LgR-MOMO150837658124MOMO\",\"transferType\":\"in\",\"description\":\"BankAPINotify 150837658124-DH8-CHUYEN TIEN-OQCH000M2LgR-MOMO150837658124MOMO\",\"transferAmount\":65000,\"referenceCode\":\"FT26282781063297\",\"accumulated\":0,\"id\":88391383}','2026-10-09 10:03:39');
/*!40000 ALTER TABLE `payment_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `method` varchar(50) collate utf8_unicode_ci default 'cod',
  `status` varchar(50) collate utf8_unicode_ci default 'pending',
  `transaction_id` varchar(255) collate utf8_unicode_ci default NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'cod','pending',NULL,'2026-03-19 14:36:42'),(2,2,'online','success',NULL,'2026-03-20 03:47:38'),(3,3,'cod','pending',NULL,'2026-03-22 15:37:12'),(4,4,'online','pending',NULL,'2026-03-22 17:31:08'),(5,5,'cod','pending',NULL,'2026-03-22 17:36:22'),(8,8,'sepay','success','FT26282781063297','2026-10-09 10:03:11'),(9,9,'sepay','pending',NULL,'2026-10-09 18:26:24');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `excerpt` text collate utf8_unicode_ci,
  `content` longtext collate utf8_unicode_ci,
  `image` varchar(255) collate utf8_unicode_ci default NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'10 Cuốn Sách Kinh Điển Giúp Thay Đổi Tư Duy Bạn Nên Đọc Một Lần Trong Đời','Những trang sách không chỉ chứa đựng tri thức nhân loại mà còn là tấm gương soi chiếu nội tâm và chiếc chìa khóa mở lối tương lai. Khám phá 10 tác phẩm kinh điển vượt thời gian có sức mạnh tái định hình nhận thức, giúp bạn xây dựng tư duy phản biện sắc bén và lối sống vững vàng giữa biến động.','Trong cuộc đời mỗi con người, có những cuốn sách xuất hiện đúng thời điểm có thể làm thay đổi hoàn toàn cách chúng ta nhìn nhận bản thân, công việc và thế giới xung quanh. Không phải ngẫu nhiên mà các bậc vĩ nhân, doanh nhân kiệt xuất và các nhà tư tưởng hàng đầu đều coi việc đọc sách là nền tảng cốt lõi cho mọi sự bứt phá.\n\nDưới đây là 10 cuốn sách kinh điển mang giá trị vượt thời gian, xứng đáng trở thành hành trang gối đầu giường của bất kỳ ai đang khao khát phát triển bản thân:\n\n1. Đắc Nhân Tâm (Dale Carnegie)\nĐược xem là cuốn sách gối đầu giường về nghệ thuật ứng xử và kết nối con người. Tác phẩm không dạy bạn những chiêu trò thao túng, mà khơi dậy sự chân thành, lòng lắng nghe và sự thấu cảm sâu sắc giữa người với người.\n\n2. Nhà Giả Kim (Paulo Coelho)\nCâu chuyện ngụ ngôn về chàng chăn cừu Santiago trên hành trình tìm kiếm kho báu kim tự tháp là lời nhắc nhở dịu dàng: \'Khi bạn thực sự khao khát một điều gì đó, cả vũ trụ sẽ hợp lực giúp bạn đạt được nó\'. Cuốn sách thắp lên ngọn lửa kiên định theo đuổi ước mơ.\n\n3. Sapiens - Lược Sử Loài Người (Yuval Noah Harari)\nMột công trình đồ sộ mang lại góc nhìn toàn cảnh về hành trình tiến hóa của nhân loại. Từ một loài linh trưởng bình thường, tổ tiên chúng ta đã vươn lên thống trị hành tinh nhờ khả năng tưởng tượng và xây dựng những câu chuyện tập thể.\n\n4. Tư Duy Nhanh Và Chậm (Daniel Kahneman)\nTác phẩm kinh điển đoạt giải Nobel kinh tế giải mã hai hệ thống tư duy vận hành trong não bộ. Đọc cuốn sách này sẽ giúp bạn nhận diện những điểm mù nhận thức, sự thiên lệch cảm xúc và đưa ra quyết định sáng suốt hơn trong cuộc sống.\n\n5. Đi Tìm Lẽ Sống (Viktor E. Frankl)\nĐược viết bởi một bác sĩ tâm thần sống sót qua trại tập trung diệt chủng Auschwitz, tác phẩm khẳng định: Con người có thể bị tước đoạt mọi thứ, trừ một quyền tự do duy nhất – quyền lựa chọn thái độ sống trước mọi nghịch cảnh.\n\n6. 7 Thói Quen Của Người Thành Đạt (Stephen R. Covey)\nKhông chỉ là phương pháp quản lý thời gian hay gia tăng năng suất, cuốn sách là triết lý sống toàn diện giúp bạn kiến tạo sự tự chủ nội tại, tinh thần hợp tác đôi bên cùng có lợi và phát triển nhân cách bền vững.\n\n7. Nghệ Thuật Tinh Tế Của Việc \'Kệ Mẹ\' Đời (Mark Manson)\nMột làn gió mới lạ đối với dòng sách self-help truyền thống. Cuốn sách không ru ngủ bạn bằng những lời tích cực sáo rỗng, mà thẳng thắn chỉ ra rằng cuộc sống vốn đầy rẫy khó khăn và hạnh phúc đến từ việc giải quyết vấn đề mà bạn thực sự quan tâm.\n\n8. Khuyến Học (Fukuzawa Yukichi)\nTác phẩm gối đầu giường đã thức tỉnh toàn bộ tinh thần dân tộc Nhật Bản thời Minh Trị. Tinh thần độc lập, coi trọng thực học và trách nhiệm cá nhân đối với xã hội trong sách vẫn còn nguyên giá trị thời đại cho độc giả Việt Nam hôm nay.\n\n9. Tâm Lý Học Về Tiền (Morgan Housel)\nQuản lý tài chính cá nhân không thuần túy là phép tính số học, mà phụ thuộc phần lớn vào cảm xúc và hành vi con người. Cuốn sách chia sẻ những góc nhìn sâu sắc giúp bạn xây dựng mối quan hệ lành mạnh với tiền bạc và đạt được sự tự do đích thực.\n\n10. Atomic Habits - Thay Đổi Tí Hon, Hiệu Quả Bất Ngờ (James Clear)\nNếu bạn từng chật vật từ bỏ thói quen xấu hoặc muốn xây dựng thói quen tốt bền vững, đây là cẩm nang khoa học và thực tế nhất. Tiến bộ 1% mỗi ngày sẽ tạo nên bước nhảy vọt thần kỳ sau một năm.\n\nLời kết:\nĐọc sách không phải là đích đến, mà là điểm khởi đầu cho hành trình tự soi rọi và hành động. Hãy chọn cho mình một cuốn sách tâm đắc ngay hôm nay, đọc chậm rãi và áp dụng từng bài học nhỏ vào thực tế cuộc sống.','post_1_sach_kinh_dien.jpg','2026-03-19 14:35:38'),(2,'Lợi Ích Kỳ Diệu Của Thói Quen Đọc Sách Mỗi Ngày Và Phương Pháp Đọc Hiệu Quả','Dành ra 20-30 phút đọc sách mỗi ngày không đơn thuần là thói quen giải trí lành mạnh, mà là một khoản đầu tư dài hạn mang lại lợi nhuận vô giá cho trí tuệ và tinh thần. Khám phá cơ chế khoa học đằng sau việc đọc và những phương pháp tiếp thu kiến thức tối ưu.','Trong kỷ nguyên bùng nổ công nghệ số với hàng loạt kích thích ngắn hạn từ mạng xã hội, thói quen đọc sách dường như đang trở thành một \'kỹ năng xa xỉ\'. Tuy nhiên, các nhà khoa học thần kinh và các chuyên gia giáo dục trên toàn thế giới đều khẳng định: Không có hoạt động nào kích thích tư duy toàn diện và làm dịu tinh thần sâu sắc như việc đọc sách.\n\nVì sao những người thành công nhất thế giới như Warren Buffett hay Bill Gates đều dành tới 80% thời gian làm việc để đọc sách? Dưới đây là những lợi ích kỳ diệu mà thói quen này mang lại:\n\n1. Kích hoạt mạng lưới liên kết tế bào thần kinh\nĐọc sách đối với bộ não giống như tập thể dục đối với cơ bắp. Quá trình giải mã con chữ, hình dung bối cảnh và kết nối dữ liệu buộc não bộ phải liên tục xây dựng các synapse mới, giúp cải thiện trí nhớ và phòng ngừa chứng suy giảm nhận thức khi về già.\n\n2. Phương pháp giải tỏa căng thẳng hiệu quả bậc nhất\nNghiên cứu của Đại học Sussex (Anh) chỉ ra rằng chỉ cần 6 phút đọc sách trong không gian yên tĩnh có thể giảm tới 68% mức độ căng thẳng (stress) – hiệu quả hơn rất nhiều so với việc nghe nhạc, uống trà hay đi bộ. Khi bạn đắm chìm vào một cuốn sách hay, cơ thể sẽ tự động hạ nhịp tim và thả lỏng các nhóm cơ căng cứng.\n\n3. Mở rộng vốn từ vựng và trau chuốt khả năng diễn đạt\nNgôn từ là phương tiện của tư duy. Người đọc nhiều tự nhiên sẽ sở hữu vốn từ phong phú, cấu trúc câu mạch lạc và khả năng trình bày ý tưởng sắc bén, tự tin trong giao tiếp cũng như văn bản công việc.\n\n4. Bồi đắp trí tuệ cảm xúc (EQ) và khả năng thấu cảm\nKhi theo dõi tâm lý nhân vật qua từng chương sách, bạn học cách nhìn nhận thế giới từ nhiều lăng kính khác nhau. Điều này giúp bạn phát triển lòng bao dung, sự tinh tế trong việc thấu hiểu cảm xúc của những người xung quanh.\n\n5. Tái tạo khả năng tập trung sâu (Deep Work)\nTrong thời đại mà sự chú ý của chúng ta bị phân mảnh bởi vô số thông báo trên điện thoại, việc duy trì sự tập trung liền mạch vào 30 trang sách là bài tập tuyệt vời để lấy lại khả năng tập trung cao độ.\n\nBÍ QUYẾT ĐỌC SÁCH HIỆU QUẢ DÀNH CHO NGƯỜI BẬN RỘN:\n\n- Quy tắc 20 trang sách mỗi sáng: Thay vì đặt mục tiêu quá lớn, hãy bắt đầu ngày mới bằng việc đọc 20 trang sách trước khi mở điện thoại. Với tốc độ này, bạn sẽ hoàn thành khoảng 25-30 cuốn sách mỗi năm một cách nhẹ nhàng.\n- Kỹ thuật ghi chép chủ động (Active Reading): Hãy chuẩn bị bút dạ quang hoặc sổ ghi chép nhỏ. Đánh dấu những đoạn văn tâm đắc, viết cảm nhận ngắn bên lề trang sách để biến kiến thức của tác giả thành tài sản của riêng bạn.\n- Phương pháp đọc SQ3R (Survey - Question - Read - Recite - Review): Khảo sát nhanh mục lục và lời giới thiệu, đặt câu hỏi cho bản thân, đọc tập trung, tự diễn đạt lại nội dung và ôn lại sau 24 giờ.\n\nLời kết:\nMỗi trang sách mở ra là một cánh cửa bước vào thế giới tri thức vô tận. Hãy trân trọng khoảng thời gian yên bình bên trang sách mỗi ngày – đó là món quà quý giá nhất bạn dành tặng cho tâm hồn mình.','post_2_loi_ich_doc_sach.jpg','2026-03-19 14:35:38'),(3,'Văn Hóa Đọc Thời Đại Công Nghệ Số: Sách Giấy Liệu Có Bị Lãng Quên?','Giữa làn sóng bùng nổ của eBook, Audiobook và sự thống trị của mạng xã hội, liệu những trang sách giấy thoảng hương mực in có còn giữ được vị thế của mình? Cùng chiêm nghiệm sự giao thoa giữa truyền thống và hiện đại trong hành trình lan tỏa tri thức.','Vào đầu thập niên 2010, khi máy đọc sách điện tử Kindle và các nền tảng sách số bắt đầu phủ sóng toàn cầu, nhiều chuyên gia từng bi quan dự đoán về sự lụi tàn tất yếu của sách in truyền thống. Thế nhưng hơn một thập kỷ trôi qua, thị trường sách giấy không những không biến mất mà còn có sự hồi sinh mạnh mẽ, khẳng định vị thế độc tôn của mình trong lòng những người yêu tri thức.\n\nTại sao giữa một thế giới ngập tràn màn hình phát sáng, con người vẫn tìm về với những trang giấy thoảng hương mực in?\n\n1. Trải nghiệm xúc giác và cảm xúc không thể thay thế\nMột cuốn sách in mang lại trải nghiệm đa giác quan: tiếng lật giòn tan của trang giấy, độ nhám tinh tế của bề mặt, sức nặng của tri thức trên đôi bàn tay và hương thơm đặc trưng của mực in. Đó là sự hiện diện hữu hình, mang tính nghi thức mà không một tập tin kỹ thuật số nào có thể sao chép trọn vẹn.\n\n2. Nơi trú ẩn an toàn trước cơn bão thông báo trực tuyến\nĐọc sách trên điện thoại hay máy tính bảng thường đi kèm với cám dỗ từ thông báo tin nhắn, mạng xã hội và email. Ngược lại, cầm trên tay một cuốn sách giấy đồng nghĩa với việc bạn tự cho phép mình bước vào trạng thái tĩnh tại, ngắt kết nối với thế giới ảo để kết nối sâu sắc với chính mình.\n\n3. Khả năng ghi nhớ và tiếp thu không gian (Spatial Memory)\nCác nghiên cứu khoa học từ Na Uy và Pháp đã chỉ ra rằng não bộ con người tiếp thu và ghi nhớ cấu trúc thông tin trên văn bản in tốt hơn đáng kể so với việc cuộn trang trên màn hình số. Vị trí vật lý của đoạn văn trên trang sách tạo nên các mốc ghi nhớ trực quan giúp độc giả nắm bắt mạch tư tưởng mạch lạc hơn.\n\n4. Sự cộng hưởng hài hòa giữa sách giấy và công nghệ số\nĐộc giả thông minh ngày nay không còn đặt sách giấy và công nghệ ở thế đối đầu. Thay vào đó, họ kết hợp linh hoạt: sử dụng sách nói (Audiobook) khi lái xe hay tập thể thao, đọc sách điện tử (eBook) khi đi du lịch công tác, và trân trọng nâng niu những cuốn sách giấy bìa cứng có chữ ký tác giả trên kệ sách gia đình.\n\n5. Xu hướng không gian văn hóa đọc của giới trẻ\nTại Việt Nam, sự nở rộ của các hội sách, cà phê sách nghệ thuật và các câu lạc bộ sách của thế hệ trẻ đã chứng minh văn hóa đọc đang chuyển mình đầy sức sống. Sách không chỉ là công cụ học tập mà còn là biểu tượng của phong cách sống thanh lịch, có chiều sâu văn hóa.\n\nLời kết:\nDù công nghệ có tiến xa đến đâu, sách giấy vẫn sẽ luôn là ngọn hải đăng bền bỉ soi sáng tâm hồn nhân loại. Những giá trị chân thực và vĩnh cửu của con chữ in trên giấy sẽ mãi trường tồn cùng thời gian.','post_3_van_hoa_doc_thoi_so.jpg','2026-03-19 15:44:11'),(4,'Nghệ Thuật Lựa Chọn Sách: Làm Sao Để Không Lãng Phí Thời Gian Vào Sách Sai Lầm?','Hàng triệu cuốn sách được xuất bản mỗi năm, nhưng quỹ thời gian của mỗi chúng ta là hữu hạn. Học cách chọn lọc những cuốn sách chất lượng, phù hợp với giai đoạn phát triển bản thân là chìa khóa để việc đọc trở nên thực sự ý nghĩa.','Nhà văn người Pháp Voltaire từng có câu nói nổi tiếng: \'Những cuốn sách hay cũng như những người bạn tốt, càng ít càng chọn lọc thì càng đáng quý\'. Trong thời đại bùng nổ thông tin hiện nay, cái bẫy lớn nhất của người đọc không phải là thiếu sách, mà là choáng ngợp trước biển sách và lãng phí thời gian quý báu vào những tác phẩm nông cạn, giật gân hoặc không phù hợp.\r\n\r\nLàm thế nào để chọn đúng những cuốn sách giúp bạn nâng tầm tư duy mà không bị cảm giác chán nản bỏ dở?\r\n\r\n1. Xác định rõ mục tiêu và giai đoạn phát triển hiện tại\r\nĐừng mua sách chỉ vì thấy nó nằm trên bảng xếp hạng \'bán chạy nhất\' (bestseller). Hãy tự hỏi: Bạn đang cần giải quyết vấn đề gì trong công việc? Bạn đang tìm kiếm giải pháp cải thiện sức khỏe tinh thần, hay muốn mở rộng hiểu biết về lịch sử, nghệ thuật? Khi có mục tiêu rõ ràng, cuốn sách được chọn sẽ phát huy tối đa công năng.\r\n\r\n2. Quy tắc 50 trang đầu tiên\r\nCuộc đời quá ngắn để đọc những cuốn sách làm bạn ngán ngẩm. Tác giả Nancy Pearl đã đề xuất một quy tắc rất thực tế: Nếu sau 50 trang đầu tiên, một cuốn sách vẫn không khơi gợi được sự tò mò hay cung cấp bất kỳ giá trị nào cho bạn, hãy dũng cảm khép nó lại. Đừng cảm thấy tội lỗi khi bỏ dở một cuốn sách không thuộc về bạn.\r\n\r\n3. Áp dụng hiệu ứng Lindy (Lindy Effect)\r\nHiệu ứng Lindy chỉ ra rằng: Đối với sách vở và tri thức, tuổi thọ kỳ vọng trong tương lai tỷ lệ thuận với tuổi thọ trong quá khứ của nó. Một cuốn sách đã được độc giả khắp thế giới đón nhận và tái bản suốt 50 năm qua (như Đắc Nhân Tâm, Hoàng Tử Bé, Bắt Trẻ Đồng Xanh...) có xác suất giá trị cao hơn gấp nhiều lần một cuốn sách vừa mới ra mắt tháng trước với những chiến dịch quảng cáo rầm rộ.\r\n\r\n4. Đọc kỹ mục lục, lời tựa và tài liệu tham khảo\r\nTrước khi quyết định mua một cuốn sách, hãy dành vài phút đọc phần mục lục. Một tác giả có tư duy mạch lạc sẽ sắp xếp bố cục chương hồi logic và rõ ràng. Hãy đọc lướt lời nói đầu để nắm bắt linh hồn của cuốn sách và đối chiếu với kỳ vọng của bạn.\r\n\r\n5. Tham khảo ý kiến từ cộng đồng độc giả thực thụ\r\nHãy tham khảo nhận xét trên các diễn đàn sách uy tín, tìm đọc những bài điểm sách (book review) phân tích cả ưu điểm lẫn hạn chế thay vì tin hoàn toàn vào những câu trích dẫn hoa mỹ in ở bìa sau cuốn sách.\r\n\r\nLời kết:\r\nLựa chọn sách là một nghệ thuật rèn luyện óc thẩm mỹ và sự khôn ngoan. Khi bạn trân trọng thời gian của mình, bạn sẽ học được cách chỉ chào đón những cuốn sách xuất sắc bước vào tâm trí.','post_20261010_020526_3734.jpg','2026-10-09 14:22:10'),(5,'Góc Truyền Cảm Hứng: Thiết Kế Không Gian Đọc Sách Yên Bình Ngay Tại Nhà','Một góc nhỏ ngập tràn ánh sáng tự nhiên, thoang thoảng hương cà phê cùng chiếc ghế tựa êm ái sẽ đánh thức niềm đam mê đọc sách trong bạn mỗi ngày. Khám phá những gợi ý bài trí không gian đọc sách tối giản, ấm cúng và đầy tính thẩm mỹ.','Môi trường xung quanh có ảnh hưởng trực tiếp đến trạng thái tâm lý và khả năng tập trung của con người. Một góc đọc sách được bài trí tinh tế, ấm cúng không chỉ là điểm nhấn thẩm mỹ cho ngôi nhà mà còn là chốn ẩn mình bình yên giúp bạn tái tạo năng lượng sau những xô bồ của cuộc sống hiện đại.\n\nBạn không nhất thiết phải sở hữu một căn phòng đọc sách rộng lớn kiểu thư viện quý tộc. Chỉ cần một góc nhỏ 2-3 mét vuông được chăm chút đúng cách, bạn đã có thể tạo nên một thiên đường tri thức cho riêng mình:\n\n1. Đặt ưu tiên hàng đầu cho ánh sáng\nÁnh sáng tự nhiên là nguồn năng lượng tuyệt vời nhất cho đôi mắt và tinh thần. Nếu có thể, hãy bố trí góc đọc cạnh cửa sổ, ban công hoặc giếng trời. Để tránh ánh nắng gắt vào ban trưa, hãy trang bị một lớp rèm vải lanh (linen) mỏng nhẹ khuếch tán ánh sáng dịu mắt. Đối với buổi tối, hãy đầu tư một chiếc đèn đọc sách chuyên dụng có nhiệt độ màu ấm (khoảng 3000K - 4000K) với chỉ số hoàn màu cao (CRI > 90) để bảo vệ thị lực.\n\n2. Chiếc ghế tựa công thái học – Trái tim của góc đọc\nBạn sẽ khó có thể đắm chìm vào một cuốn tiểu thuyết hàng giờ liền nếu phải ngồi trên một chiếc ghế cứng ngắc đau lưng. Hãy lựa chọn một chiếc ghế bành bọc vải nhung hoặc nỉ êm ái, có phần tựa đầu và tay vịn nâng đỡ. Một chiếc đôn gác chân nhỏ (ottoman) và vài chiếc gối tựa lưng sẽ hoàn thiện trải nghiệm thư giãn tuyệt đối.\n\n3. Kệ sách gọn gàng và nghệ thuật bài trí\nHãy chọn những mẫu kệ sách gỗ tự nhiên với tông màu mộc mạc, thiết kế mở để dễ dàng chiêm ngưỡng những cuốn sách yêu thích. Bạn có thể sắp xếp sách theo màu sắc gáy sách, theo chủ đề hoặc xen kẽ giữa các tập sách là những món đồ lưu niệm, khung ảnh gia đình để không gian thêm sinh động.\n\n4. Đưa hơi thở thiên nhiên vào không gian\nMột chậu cây nhỏ như kim ngân, trầu bà lá xẻ hay sen đá đặt trên bậu cửa sổ không chỉ thanh lọc không khí mà còn giúp mắt được thư giãn mỗi khi ngước lên nghỉ ngơi giữa các chương sách.\n\n5. Khơi gợi đa giác quan với âm thanh và mùi hương\nHãy thắp một ngọn nến thơm chiết xuất từ tinh dầu tự nhiên với hương gỗ tuyết tùng, hổ phách hoặc vỏ quế. Kết hợp với một tách trà hoa cúc nóng và giai điệu nhạc không lời du dương, góc đọc sách của bạn sẽ biến thành một spa chữa lành tâm hồn đúng nghĩa.\n\nLời kết:\nHãy dành thời gian chăm chút cho góc đọc sách của mình. Đó không chỉ là sự đầu tư cho một góc nội thất, mà là lời cam kết trân quý bản thân và nuôi dưỡng tình yêu vĩnh cửu với tri thức.','post_5_khong_gian_doc_sach.jpg','2026-10-09 14:22:10'),(6,'Review Sách: \'Cho Tôi Xin Một Vé Đi Tuổi Thơ\' – Chuyến Tàu Đưa Người Lớn Trở Về Miền Ký Ức','Tác phẩm kinh điển của nhà văn Nguyễn Nhật Ánh không chỉ dành riêng cho thiếu nhi, mà là tấm vé quý giá dành cho bất kỳ ai từng là một đứa trẻ và đang cảm thấy mệt nhoài trong thế giới của những người lớn.','Trong văn học Việt Nam đương đại, hiếm có ngòi bút nào sở hữu khả năng kỳ diệu như Nguyễn Nhật Ánh – người luôn có thể chạm đến những góc sâu kín và trong trẻo nhất trong tâm hồn của nhiều thế hệ độc giả. Xuất bản lần đầu năm 2008 và nhanh chóng trở thành hiện tượng văn học, \'Cho Tôi Xin Một Vé Đi Tuổi Thơ\' không đơn thuần là một tác phẩm viết về trẻ con, mà là cuốn sách viết về trẻ con dành cho những ai từng là trẻ con.\n\n1. Bốn đứa trẻ và thế giới tí hon đầy màu sắc\nDưới lời kể hóm hỉnh của nhân vật Cu Mùi khi đã trở thành một người đàn ông trung niên nhớ về năm tám tuổi, độc giả được làm quen với một \'bộ tứ quyền lực\': Cu Mùi thông thái, thằng Hải Cò nghịch ngợm, con Tủn điệu đà và con Tí Sún mơ mộng. Ở cái tuổi lên tám, thế giới của chúng vừa chật hẹp trong xóm nhỏ, lại vừa bao la vô tận trong trí tưởng tượng không biên giới.\n\n2. Những cuộc nổi loạn đáng yêu chống lại trật tự người lớn\nAi trong chúng ta khi còn bé lại không từng cảm thấy người lớn thật khó hiểu và áp đặt? Bốn đứa trẻ trong truyện đã khởi xướng hàng loạt \'cuộc cách mạng\' ngây ngô nhưng đầy tính triết lý: từ việc đặt lại tên cho thế giới (gọi cái nón là cuốn sách, gọi con gà là cái bàn ủi), trò chơi đóng giả làm bố mẹ để phán xử lại người lớn, cho đến kế hoạch bỏ nhà đi bụi đầy kịch tính. Những tình huống dở khóc dở cười khiến độc giả bật cười sảng khoái, rồi bỗng thấy sống mũi cay cay khi nhận ra hình bóng của chính mình những năm tháng ấu thơ.\n\n3. Lăng kính phản chiếu sâu sắc về tâm lý giáo dục\nĐằng sau giọng văn nhẹ tênh và hài hước, Nguyễn Nhật Ánh đã gửi gắm những trăn trở sâu sắc về khoảng cách thế hệ và sự áp đặt vô hình của các bậc phụ huynh. Người lớn thường bận rộn với các quy chuẩn xã hội, cơm áo gạo tiền mà vô tình đánh mất khả năng lắng nghe và đồng cảm với thế giới tâm hồn non nớt của con trẻ. Cuốn sách là lời nhắn nhủ dịu dàng rằng: Đôi khi, để nuôi dạy một đứa trẻ hạnh phúc, người lớn cần học cách \'lớn chậm lại\' và nhìn cuộc đời bằng đôi mắt ngây thơ của trẻ nhỏ.\n\n4. Nghệ thuật ngôn từ dung dị mà đầy ám ảnh\nNgòi bút của Nguyễn Nhật Ánh cuốn hút độc giả bởi sự mộc mạc, gần gũi nhưng thấm đẫm chất thơ. Từng câu chữ trôi êm ả như dòng sông tuổi thơ, khơi gợi lại những ký ức ngủ quên về những buổi trưa trốn ngủ đi hái trộm ổi, những chiều tắm mưa thỏa thuê và những giấc mơ không toan tính.\n\nLời kết:\n\'Cho Tôi Xin Một Vé Đi Tuổi Thơ\' là một chuyến tàu kỳ diệu đưa bạn rời xa những âu lo bộn bề của cuộc sống trưởng thành để tìm về với bản nguyên trong sáng nhất của tâm hồn. Dù bạn đang ở độ tuổi nào, hãy một lần cầm tấm vé đặc biệt này trên tay để mỉm cười và cảm ơn những ngày tháng ấu thơ tươi đẹp đã từng đi qua.','post_6_review_tuoi_tho.jpg','2026-10-09 14:22:10');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepay_settings`
--

DROP TABLE IF EXISTS `sepay_settings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sepay_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  PRIMARY KEY  (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sepay_settings`
--

LOCK TABLES `sepay_settings` WRITE;
/*!40000 ALTER TABLE `sepay_settings` DISABLE KEYS */;
INSERT INTO `sepay_settings` VALUES ('sepay_account_name','NGUYEN HOANG KHANH'),('sepay_account_no','0827930928'),('sepay_api_key',''),('sepay_bank','MBBank'),('sepay_is_active','1'),('sepay_prefix','DH'),('sepay_qr_template','compact');
/*!40000 ALTER TABLE `sepay_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `full_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `email` varchar(100) collate utf8_unicode_ci NOT NULL,
  `password` varchar(255) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(20) collate utf8_unicode_ci default NULL,
  `address` text collate utf8_unicode_ci,
  `role` enum('admin','user') collate utf8_unicode_ci default 'user',
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@gmail.com','e10adc3949ba59abbe56e057f20f883e','0123456789',NULL,'admin','2026-03-19 14:35:38'),(2,'Nguyá»…n VÄƒn KhÃ¡ch','user@gmail.com','e10adc3949ba59abbe56e057f20f883e','0987654321',NULL,'user','2026-03-19 14:35:38'),(3,'KhÃ¡nh Nguyá»…n','khanhhoan121209@gmail.com','9581cb1defff1417409d1632fd20a2ac','',NULL,'user','2026-03-19 14:35:45'),(4,'Thanh Binh','Binh@gmail.com','e10adc3949ba59abbe56e057f20f883e','123456789',NULL,'user','2026-03-22 17:30:28'),(5,'Khánh Khánh','khanhkhanh@gmail.com','e10adc3949ba59abbe56e057f20f883e','0123456987',NULL,'user','2026-10-09 18:23:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-09 19:01:47
