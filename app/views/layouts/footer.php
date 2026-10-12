        </div> <!-- End container từ file header.php -->
    </main>
    
    <!-- Footer Nhẹ Nhàng & Đồng Bộ Tone Pastel (#c3cfe2) Cố Định Đáy Màn Hình -->
    <footer class="site-footer text-dark" style="background: linear-gradient(180deg, #eef3f8 0%, #c9d6e5 100%);">
        <!-- Khối nội dung Footer chính -->
        <div class="container py-3 py-lg-4">
            <div class="row g-3 g-lg-4 justify-content-between">
                <!-- Cột 1: Thông tin thương hiệu & Giới thiệu -->
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="footer-brand mb-2">
                        <a href="<?php echo BASE_URL ?>" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                            <span class="brand-badge rounded-3 p-2 d-inline-flex align-items-center justify-content-center bg-white shadow-sm" style="width: 36px; height: 36px; border: 1px solid rgba(0,0,0,0.08);">
                                <i class="bi bi-book-half fs-6 text-primary"></i>
                            </span>
                            <span class="fs-5 fw-bold text-primary">BookStore</span>
                        </a>
                    </div>
                    <p class="text-secondary small pe-lg-4 mb-3" style="line-height: 1.6;">
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
                <div class="col-lg-2 col-md-6 col-6 mb-2">
                    <h6 class="text-dark fw-bold text-uppercase mb-2 footer-heading">Khám Phá</h6>
                    <ul class="list-unstyled footer-links mb-0 small">
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Trang chủ</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>book"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Tất cả sách</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>post"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Bài viết & Tin tức</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>home/about"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Về BookStore</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Hỗ trợ khách hàng -->
                <div class="col-lg-3 col-md-6 col-6 mb-2">
                    <h6 class="text-dark fw-bold text-uppercase mb-2 footer-heading">Hỗ Trợ Khách Hàng</h6>
                    <ul class="list-unstyled footer-links mb-0 small">
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>cart"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Giỏ hàng của bạn</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>order/history"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Tra cứu đơn hàng</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Chính sách đổi trả</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Chính sách bảo mật</a></li>
                        <li class="mb-1"><a href="<?php echo BASE_URL ?>home/contact"><i class="bi bi-chevron-right me-1 small opacity-50"></i>Phương thức thanh toán</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Thông tin liên hệ -->
                <div class="col-lg-3 col-md-6 mb-2">
                    <h6 class="text-dark fw-bold text-uppercase mb-2 footer-heading">Thông Tin Liên Hệ</h6>
                    <ul class="list-unstyled text-secondary small mb-0">
                        <li class="mb-1 d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-primary flex-shrink-0 mt-1"></i>
                            <span>123 Đường Sách, P. Bến Nghé, Q.1, TP. HCM</span>
                        </li>
                        <li class="mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-telephone-fill text-primary flex-shrink-0"></i>
                            <span class="text-dark fw-semibold">0827 930 928 / 1900 6868</span>
                        </li>
                        <li class="mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-fill text-primary flex-shrink-0"></i>
                            <span>contact@bookstore.com</span>
                        </li>
                        <li class="mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-fill text-primary flex-shrink-0"></i>
                            <span>08:00 - 21:30 (Mỗi ngày)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Thanh bản quyền đáy (Bottom bar) -->
        <div class="footer-bottom py-2 border-top" style="background-color: #bcccdc; border-color: rgba(0,0,0,0.08) !important;">
            <div class="container text-center text-secondary small py-1">
                &copy; <?php echo date('Y') ?> <strong class="text-dark">BookStore</strong>. Bản quyền thuộc về Nhà Sách Trực Tuyến BookStore.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tự động căn chỉnh khoảng trống đáy màn hình để chân trang cố định không che nội dung
        function adjustFixedFooterSpacing() {
            var footer = document.querySelector('.site-footer');
            if (footer) {
                document.body.style.paddingBottom = (footer.offsetHeight + 16) + 'px';
            }
        }
        window.addEventListener('load', adjustFixedFooterSpacing);
        window.addEventListener('resize', adjustFixedFooterSpacing);
        document.addEventListener('DOMContentLoaded', adjustFixedFooterSpacing);
    </script>
</body>
</html>
