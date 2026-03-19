# Äá»“ Ãn: XÃ¢y Dá»±ng Website BÃ¡n SÃ¡ch Trá»±c Tuyáº¿n (BookStore)

Äá»“ Ã¡n MÃ´n há»c PhÃ¡t triá»ƒn á»¨ng dá»¥ng Web.
CÃ´ng nghá»‡: PHP thuáº§n tÄ©nh (khÃ´ng dÃ¹ng Framework), MySQL, WAMP 2.0, HTML/CSS/JS/Bootstrap 5.
Kiáº¿n trÃºc: MVC (Model - View - Controller).

## I. Chá»©c NÄƒng ChÃ­nh
### DÃ nh Cho KhÃ¡ch HÃ ng (User/Guest)
1. **Trang chá»§ & Sáº£n pháº©m**: Hiá»ƒn thá»‹ sÃ¡ch ná»•i báº­t, sÃ¡ch má»›i, lá»c theo danh má»¥c, tÃ¬m kiáº¿m sÃ¡ch.
2. **Chi tiáº¿t sÃ¡ch**: Xem thÃ´ng tin tÃ¡c giáº£, giÃ¡, giá»›i thiá»‡u, tá»“n kho.
3. **Giá» hÃ ng (Cart)**: ThÃªm/Sá»­a/XÃ³a Ä‘Æ¡n, tÃ­nh tiá»n tá»•ng cá»™ng. LÆ°u giá» hÃ ng báº±ng PHP Session.
4. **Thanh toÃ¡n (Checkout)**: Form thanh toÃ¡n COD (Tiá»n máº·t) vÃ  giáº£ láº­p Thanh toÃ¡n Online. Ghi nháº­n thÃ´ng tin giao nháº­n vÃ o Database.
5. **ThÃ nh viÃªn (Auth)**: ÄÄƒng kÃ½ (bÄƒm máº­t kháº©u báº£o máº­t), ÄÄƒng nháº­p, ÄÄƒng xuáº¥t, xem Trang lá»‹ch sá»­ Ä‘Æ¡n hÃ ng.
6. **Blog / Tin tá»©c**: Hiá»ƒn thá»‹ danh sÃ¡ch cÃ¡c bÃ i viáº¿t vá» sá»± kiá»‡n vÄƒn hÃ³a Ä‘á»c sÃ¡ch.

### DÃ nh Cho Quáº£n Trá»‹ ViÃªn (Admin)
1. **Dashboard**: Thá»‘ng kÃª sá»‘ lÆ°á»£ng (ÄÆ¡n hÃ ng, Doanh thu, User, Äáº§u sÃ¡ch bÃ¡n).
2. **Quáº£n lÃ½ Danh má»¥c (Categories)**: ThÃªm, sá»­a, xÃ³a danh má»¥c (CRUD).
3. **Quáº£n lÃ½ SÃ¡ch (Books)**: CRUD sÃ¡ch, upload hÃ¬nh áº£nh (demo).
4. **Quáº£n lÃ½ ÄÆ¡n hÃ ng (Orders)**: Liá»‡t kÃª cÃ¡c Ä‘Æ¡n, xem chi tiáº¿t, Cáº­p nháº­t tráº¡ng thÃ¡i Ä‘Æ¡n (pending -> confirmed -> shipping -> completed).
5. **Quáº£n lÃ½ Tin Tá»©c (Posts)**: CRUD cÃ¡c bÃ i táº¡p chÃ­, sá»± kiá»‡n.
6. **Quáº£n lÃ½ NgÆ°á»i DÃ¹ng (Users)**: Xem danh sÃ¡ch, quyá»n háº¡n, XÃ³a tÃ i khoáº£n khÃ¡ch.

## II. HÆ°á»›ng Dáº«n CÃ i Äáº·t (Localhost WAMP)
Dá»± Ã¡n Ä‘Æ°á»£c thiáº¿t káº¿ chuáº©n Ä‘á»ƒ cháº¡y trÃªn mÃ´i trÆ°á»ng **WAMP**. 

1. **Copy mÃ£ nguá»“n**: Äáº·t foler `bookstore` vÃ o thÆ° má»¥c `C:\wamp\www\WedSach\` (náº¿u báº¡n cÃ i WAMP á»Ÿ á»• C).
   *ÄÆ°á»ng dáº«n máº·c Ä‘á»‹nh sáº½ lÃ *: `C:\wamp\www\WedSach\bookstore\`

2. **Cáº¥u hÃ¬nh Database**:
   - Khá»Ÿi Ä‘á»™ng WAMP (Start WampServer).
   - Truy cáº­p `http://localhost/phpmyadmin`
   - Táº¡o má»™t CSDL má»›i tÃªn lÃ : `bookstore` (Collation: `utf8mb4_unicode_ci` hoáº·c `utf8_general_ci`).
   - Import file file SQL Ä‘Æ°á»£c cung cáº¥p sáºµn: Tá»‡p script náº±m á»Ÿ `database/bookstore.sql`
   - TÃ i khoáº£n Ä‘Äƒng nháº­p phpMyAdmin máº·c Ä‘á»‹nh trÃªn WAMP thÆ°á»ng lÃ : `root`, pass rá»—ng.

3. **Cáº¥u hÃ¬nh Káº¿t ná»‘i CSDL**:
   - Má»Ÿ file `config/database.php`
   - Äáº£m báº£o thÃ´ng tin sau khá»›p vá»›i WAMP cá»§a báº¡n:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'bookstore');
     
     // ThÆ° má»¥c gá»‘c khi cháº¡y trÃªn Localhost:
     define('BASE_URL', 'http://localhost/WedSach/bookstore/public/'); 
     ```

4. **KÃ­ch hoáº¡t module Rewrite cá»§a Apache (Ráº¤T QUAN TRá»ŒNG)**:
   MÃ´ hÃ¬nh MVC cá»§a Ä‘á»“ Ã¡n sá»­ dá»¥ng `.htaccess` Ä‘á»ƒ Rewrite URL. Báº¡n PHáº¢I báº­t module nÃ y:
   - Click chuá»™t trÃ¡i (Left-click) vÃ o biá»ƒu tÆ°á»£ng WAMP á»Ÿ gÃ³c pháº£i mÃ n hÃ¬nh > Apache > Apache Modules
   - TÃ¬m vÃ  Ä‘Ã¡nh dáº¥u tÃ­ch vÃ o `rewrite_module`.
   - WAMP sáº½ tá»± reset láº¡i dá»‹ch vá»¥.

5. **Cháº¡y website**:
   - Giao diá»‡n Client: Má»Ÿ trÃ¬nh duyá»‡t truy cáº­p `http://localhost/WedSach/bookstore/`
   - Há»‡ thá»‘ng sáº½ tá»± Ä‘Æ°a báº¡n vá» thÆ° má»¥c `/public` báº±ng quy táº¯c cá»§a .htaccess.

## III. TÃ i Khoáº£n Demo
CÃ¡c tÃ i khoáº£n máº·c Ä‘á»‹nh Ä‘Ã£ Ä‘Æ°á»£c táº¡o sáºµn trong file SQL:
- **TÃ i khoáº£n Admin (Quáº£n trá»‹)**
  - Email: `admin@bookstore.com`
  - Pass: `123456`
- **TÃ i khoáº£n KhÃ¡ch mua hÃ ng**
  - Email: `user@gmail.com`
  - Pass: `123456`

## IV. Bá»‘ Cá»¥c ThÆ° Má»¥c (MVC)
- `app/core`: LÃµi khung MVC (Database, Model, Controller, Router, Session).
- `app/controllers`: CÃ¡c lá»›p Controller Ä‘iá»u phá»‘i dá»¯ liá»‡u (Home, Auth, Cart, Order, Admin...).
- `app/models`: CÃ¡c lá»›p Model CRUD tÆ°Æ¡ng tÃ¡c vá»›i MySQL (UserModel, OrderModel...).
- `app/views`: CÃ¡c file giao diá»‡n HTML Ä‘Æ°á»£c nhÃºng mÃ£ PHP chia theo thÆ° má»¥c (layout, home, admin...).
- `config`: LÆ°u cÃ¡c cáº¥u hÃ¬nh há»‡ thá»‘ng (DB info, Base URL).
- `public`: ThÆ° má»¥c gá»‘c chá»©a `index.php` khá»Ÿi cháº¡y Web, cÃ¹ng vá»›i file tÃ­nh (CSS, JS, Images).

> **LÆ°u Ã½**: Code Ä‘Æ°á»£c viáº¿t hoÃ n toÃ n chay (Pure PHP), dÃ¹ng PDO Parameters vÃ  `md5()` Ä‘á»ƒ chá»‘ng SQL Injection & báº£o máº­t thÃ´ng tin chuáº©n má»±c cho má»™t bÃ i Ä‘á»“ Ã¡n sinh viÃªn.
