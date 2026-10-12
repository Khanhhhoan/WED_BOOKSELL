        </div> <!-- End container từ file header.php -->
    </main>
    
    <!-- Footer Nhẹ Nhàng & Đồng Bộ Tone Pastel (#c3cfe2) -->
    <footer class="site-footer mt-5 text-dark" style="background: linear-gradient(180deg, #eef3f8 0%, #c9d6e5 100%); border-top: 1px solid rgba(0,0,0,0.08);">
        <!-- Khối nội dung Footer chính -->
        <div class="container py-5">
            <div class="row g-4 justify-content-between">
                <!-- Cột 1: Thông tin thương hiệu & Giới thiệu -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="footer-brand mb-3">
                        <a href="<?php echo BASE_URL ?>" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                            <span class="brand-badge rounded-3 p-2 d-inline-flex align-items-center justify-content-center bg-white shadow-sm" style="width: 40px; height: 40px; border: 1px solid rgba(0,0,0,0.08);">
                                <i class="bi bi-book-half fs-5 text-primary"></i>
                            </span>
                            <span class="fs-4 fw-bold text-primary">BookStore</span>
                        </a>
                    </div>
                    <p class="text-secondary small pe-lg-4 mb-4" style="line-height: 1.7;">
                        Hệ sinh thái phân phối và kết nối tri thức trực tuyến hiện đại. Nơi hội tụ những tác phẩm kinh điển, kỹ năng sống và sách chuyên ngành tinh hoa dành cho độc giả cả nước.
                    </p>
                    <div class="footer-social d-flex align-items-center gap-2">
                        <a href="https://facebook.com" target="_blank" rel="noopener" class="social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://youtube.com" target="_blank" rel="noopener" class="social-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="https://tiktok.com" target="_blank" rel="noopener" class="social-btn" title="TikTok"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                <!-- Cột 2: Khám phá -->
                <div class="col-lg-2 col-md-6 col-6 mb-3">
                    <h6 class="text-dark fw-bold text-uppercase mb-3 footer-heading">Khám Phá</h6>
                    <ul class="list-unstyled footer-links mb-0">
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Trang chủ</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>book"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Tất cả sách</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>post"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Bài viết & Tin tức</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>home/about"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Về BookStore</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Hỗ trợ khách hàng -->
                <div class="col-lg-3 col-md-6 col-6 mb-3">
                    <h6 class="text-dark fw-bold text-uppercase mb-3 footer-heading">Hỗ Trợ Khách Hàng</h6>
                    <ul class="list-unstyled footer-links mb-0">
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>cart"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Giỏ hàng của bạn</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>order/history"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Tra cứu đơn hàng</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Chính sách đổi trả</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Chính sách bảo mật</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Phương thức thanh toán</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Thông tin liên hệ -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <h6 class="text-dark fw-bold text-uppercase mb-3 footer-heading">Thông Tin Liên Hệ</h6>
                    <ul class="list-unstyled text-secondary small mb-0">
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-primary flex-shrink-0 mt-1"></i>
                            <span>123 Đường Sách, P. Bến Nghé, Quận 1, TP. Hồ Chí Minh</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill text-primary flex-shrink-0"></i>
                            <span class="text-dark fw-semibold">0827 930 928 / 1900 6868</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-fill text-primary flex-shrink-0"></i>
                            <span>contact@bookstore.com</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-fill text-primary flex-shrink-0"></i>
                            <span>08:00 - 21:30 (Tất cả các ngày)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
