<?php 
$post = $data['post']; 
$coverUrl = post_image_url(isset($post['image']) ? $post['image'] : '');
?>
<div class="mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>post" class="text-decoration-none">Bài viết &amp; Tin tức</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 450px;" aria-current="page"><?php echo htmlspecialchars($post['title']); ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <article class="card shadow-sm border rounded-4 overflow-hidden bg-white">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Metadata & Chuyên mục -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3 text-muted small">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">Bài Viết Đặc Sắc</span>
                        <span><i class="bi bi-calendar3 me-1"></i><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                        <span>&bull;</span>
                        <span><i class="bi bi-person me-1"></i>Tác giả: <strong class="text-dark">Ban Biên Tập BookStore</strong></span>
                        <span>&bull;</span>
                        <span class="text-secondary"><i class="bi bi-clock me-1"></i>5 phút đọc</span>
                    </div>

                    <!-- Tiêu đề bài viết -->
                    <h1 class="fw-bold display-6 mb-4 text-dark" style="line-height: 1.35;">
                        <?php echo htmlspecialchars($post['title']); ?>
                    </h1>
                    
                    <!-- Lời tựa / Đoạn trích dẫn dẫn nhập -->
                    <div class="post-quote-box mb-4">
                        <p class="lead mb-0 text-secondary" style="font-size: 1.15rem; line-height: 1.7;">
                            <?php echo nl2br(htmlspecialchars($post['excerpt'])); ?>
                        </p>
                    </div>

                    <!-- Khung ảnh bìa bài viết chuẩn cân đối, chống tràn viền -->
                    <div class="post-detail-cover-box my-4">
                        <img src="<?php echo htmlspecialchars($coverUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                             alt="<?php echo htmlspecialchars($post['title']); ?>" 
                             class="post-detail-cover-img"
                             loading="eager">
                    </div>

                    <!-- Nội dung bài viết chi tiết -->
                    <div class="post-content lh-lg mt-4">
                        <?php 
                        // Tách nội dung theo dòng để render các đoạn văn và đề mục đẹp mắt
                        $paragraphs = explode("\n", str_replace("\r", "", $post['content']));
                        $insideQuote = false;
                        
                        foreach ($paragraphs as $para) {
                            $trimmed = trim($para);
                            if ($trimmed === '') {
                                continue;
                            }
                            
                            // Kiểm tra nếu là tiêu đề mục lớn (bắt đầu bằng số hoặc in hoa)
                            if (preg_match('/^[0-9]+\.\s+/', $trimmed)) {
                                echo '<h3 class="fw-bold mt-4 mb-2 text-dark" style="font-size: 1.3rem;">' . htmlspecialchars($trimmed) . '</h3>';
                            } elseif (strpos($trimmed, 'BÍ QUYẾT') === 0 || strpos($trimmed, 'Lời kết:') === 0) {
                                echo '<h4 class="fw-bold mt-4 mb-2 text-primary" style="font-size: 1.25rem;">' . htmlspecialchars($trimmed) . '</h4>';
                            } else {
                                echo '<p class="text-secondary mb-3" style="font-size: 1.05rem; line-height: 1.85;">' . htmlspecialchars($trimmed) . '</p>';
                            }
                        }
                        ?>
                    </div>

                    <!-- Box thông tin tác giả biên tập -->
                    <div class="p-4 rounded-3 bg-light border mt-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 55px; height: 55px; font-size: 1.3rem; flex-shrink: 0;">
                                BS
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Ban Biên Tập BookStore</h6>
                                <p class="text-muted small mb-0">
                                    Nơi kết nối những tâm hồn yêu sách, chia sẻ tri thức và đồng hành cùng độc giả trên hành trình mở rộng chân trời hiểu biết.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Call-to-action xem thêm sách -->
                    <div class="alert alert-light border shadow-sm rounded-3 mt-4 p-4 text-center">
                        <h5 class="fw-bold text-dark mb-2">Bạn đang tìm kiếm cuốn sách phù hợp cho mình?</h5>
                        <p class="text-muted small mb-3">Khám phá hàng ngàn tựa sách mới nhất được chọn lọc kỹ lưỡng tại BookStore với giá ưu đãi.</p>
                        <a href="<?php echo BASE_URL; ?>book" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold">
                            Xem Danh Mục Sách Ngay &rarr;
                        </a>
                    </div>

                    <hr class="my-4">

                    <!-- Nút điều hướng & chia sẻ -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <a href="<?php echo BASE_URL; ?>post" class="btn btn-outline-secondary rounded-pill px-4">
                            &larr; Quay lại danh sách bài viết
                        </a>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small fw-semibold">Chia sẻ bài viết:</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="if (navigator.clipboard) { navigator.clipboard.writeText(window.location.href); alert('Đã sao chép liên kết bài viết!'); }">
                                Sao chép liên kết
                            </button>
                        </div>
                    </div>

                </div>
            </article>
        </div>
    </div>
</div>
