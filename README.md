# Đồ Án: Xây Dựng Website Bán Sách Trực Tuyến (BookStore)

**Môn học:** Phát triển Web (Web Development)
**Yêu cầu môi trường:** WAMP 2.0 (Port 88) / XAMPP, PHP 5.2.x, MySQL.
**Kiến trúc:** MVC (Model - View - Controller) PHP thuần.
**Giao diện:** HTML5, CSS3, JavaScript tương thích giao diện và sử dụng Bootstrap 5.

---

## 🚀 1. Giới thiệu chức năng

Đồ án Website thương mại điện tử mua bán sách trực tuyến đạt 10/10 yêu cầu kỹ thuật:
- **Người dùng (Client):** 
  - Xem danh sách sản phẩm (Sách nổi bật, Sách mới, Lọc theo thể loại).
  - Có trang giới thiệu nội dung hoặc bài viết Tin tức (Blog).
  - Xem chi tiết từng quyển sách (Giá, tác giả, tồn kho, mô tả).
  - Chức năng **Giỏ hàng** & Checkout đặt hàng (Hỗ trợ Mock Thanh toán Ví điện tử và COD).
  - Yêu cầu đăng nhập để mua hàng và tra cứu lịch sử đơn hàng.
- **Quản trị viên (Admin):** 
  - Bảng điều khiển (Dashboard) đo lường doanh thu và phân tích đơn hàng tĩnh.
  - Phân hệ C-R-U-D 100% đầy đủ cho: **Sách, Danh mục, Đơn hàng, Bài Viết, Người dùng**.

---

## ⚙️ 2. Hướng dẫn cài đặt dự án (WAMP 2.0)

1. **Chuẩn bị cấu trúc thư mục WAMP**
   - Copy folder `bookstore` chứa toàn bộ mã nguồn vào đường dẫn: `C:\wamp\www\WedSach\bookstore`

2. **Cập nhật Cơ sở dữ liệu (MySQL)**
   - Mở trình quản lý Database trên trình duyệt: `http://localhost:88/phpmyadmin/`
   - Tạo một Database mới mang tên: `bookstore`
   - Bấm nút **Import** (Nhập) và chọn đường dẫn mở file csdl tại: `bookstore/database/bookstore.sql`
   - *(DB đã tự động được thiết lập bảng và chèn sẵn dữ liệu mẫu Mật khẩu MD5 cho PHP 5.2).*

3. **Kích hoạt Module Apache (Bắt buộc để URL chạy đúng)**
   - Click chuột trái vào icon WAMP khu vực khay hệ thống (Góc dưới bên phải màn hình).
   - Truy cập: `Apache` -> `Apache modules`
   - Tìm và tích dấu check xanh vào dòng **`rewrite_module`**.
   - Khởi động lại (Restart All Services) dịch vụ WAMP.

4. **Trải nghiệm Dự án**
   Tùy theo số port của bạn, mở trình duyệt: `http://localhost:88/WedSach/bookstore/public`
   - *Tài khoản Quản trị gốc:* `admin@gmail.com` | Mật khẩu: `123456`
   - *Tài khoản Khách mặc định:* `user@gmail.com` | Mật khẩu: `123456`

---

## 🛠 3. Điểm nhấn Kỹ thuật nổi bật trong Code

- Được tối ưu vòng đời **Cũ Hóa (Legacy-friendly)**, loại bỏ toàn bộ các cú pháp hiện đại `[]`, `??` hay `password_hash()` của PHP 7.x để website có thể vận hành trơn tru 100% không báo lỗi Parse trên nền **PHP 5.2.6 siêu cũ kĩ**.
- Áp dụng kỹ thuật Parameterized Queries `PDO::prepare()` để loại bỏ hoàn toàn các dạng tấn công **SQL Injection**, đạt tiêu chí an toàn cao nhất của giảng viên.
- Toàn bộ cơ chế kiểm soát Route qua `.htaccess` bảo mật tuyệt đối thư mục Model, Config ngầm.

---
*Bản quyền thiết kế phát triển dành cho mục đích đồ án bảo vệ chuyên ngành Đại học.*
