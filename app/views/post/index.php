<div class="mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bài viết &amp; Tin tức</li>
        </ol>
    </nav>

    <!-- Header Hero Banner - Giới thiệu chỉnh chu chuyên trang bài viết -->
    <div class="hero-page-banner mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-semibold mb-3 shadow-sm">
                    Góc Tri Thức &amp; Văn Hóa Đọc
                </span>
                <h1 class="display-6 fw-bold mb-3">Lan Tỏa Niềm Say Mê Con Chữ &amp; Tri Thức</h1>
                <p class="lead fs-6 mb-3">
                    Chào mừng bạn đến với chuyên trang bài viết của BookStore. Nơi hội tụ những góc nhìn sâu sắc về các tác phẩm kinh điển, bí quyết rèn luyện thói quen đọc hiệu quả và câu chuyện truyền cảm hứng sống tích cực mỗi ngày.
                </p>
                <div class="d-flex flex-wrap gap-2 text-white-50 small">
                    <span class="d-inline-flex align-items-center gap-1 text-white">
                        <strong><?php echo !empty($data['posts']) ? count($data['posts']) : 0; ?></strong> bài viết chọn lọc
                    </span>
                    <span class="mx-2 text-white-50">|</span>
                    <span class="text-white">Cập nhật thường xuyên</span>
                    <span class="mx-2 text-white-50">|</span>
                    <span class="text-white">Đồng hành cùng độc giả</span>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <div class="p-3 bg-white bg-opacity-10 rounded-4 text-start border border-white border-opacity-25 shadow-sm">
                    <p class="small fst-italic mb-2 text-white">
                        "Không có người bạn nào trung thành như một cuốn sách hay."
                    </p>
                    <small class="text-white-50">— Ernest Hemingway</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($data['posts'])) : ?>
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm border">
                    <h5 class="text-muted mb-2">Chưa có bài viết nào được đăng.</h5>
                    <p class="text-muted small">Vui lòng quay lại sau để đón đọc những bài viết mới nhất từ BookStore.</p>
                    <a href="<?php echo BASE_URL ?>" class="btn btn-outline-primary btn-sm mt-2">Về trang chủ</a>
                </div>
            </div>
        <?php else : ?>
            <!-- Danh sách bài viết chính -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0 text-dark">Tất Cả Bài Viết Tuyển Chọn</h4>
                    <span class="badge bg-secondary-subtle text-secondary border">Tổng số: <?php echo count($data['posts']); ?> bài</span>
                </div>

                <?php 
                $postCategories = array(
                    1 => 'Sách Kinh Điển',
                    2 => 'Kỹ Năng Đọc',
                    3 => 'Văn Hóa Đọc',
                    4 => 'Phương Pháp',
                    5 => 'Không Gian Sống',
                    6 => 'Review Sách'
                );
                ?>

                <?php foreach ($data['posts'] as $post) : ?>
                    <?php 
                    $postId = (int)$post['id'];
                    $catName = isset($postCategories[$postId]) ? $postCategories[$postId] : 'Chia sẻ';
                    $imageUrl = post_image_url(isset($post['image']) ? $post['image'] : '');
                    ?>
                    <article class="card post-card mb-4 shadow-sm border">
                        <div class="row g-0">
                            <!-- Khung ảnh bài viết đồng đều, chống tràn viền -->
                            <div class="col-md-5 col-sm-12">
                                <a href="<?php echo BASE_URL ?>post/detail/<?php echo $post['id'] ?>" class="post-thumb-wrapper d-flex align-items-center justify-content-center text-center position-relative text-decoration-none">
                                    <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                                         class="post-thumb-img mx-auto d-block" 
                                         alt="<?php echo htmlspecialchars($post['title']) ?>"
                                         loading="lazy">
                                    <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small">
                                        <?php echo htmlspecialchars($catName); ?>
                                    </span>
                                </a>
                            </div>

                            <!-- Nội dung tóm tắt bài viết -->
                            <div class="col-md-7 col-sm-12">
                                <div class="card-body d-flex flex-column p-4 h-100">
                                    <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                        <span><?php echo date('d/m/Y', strtotime($post['created_at'])) ?></span>
                                        <span>&bull;</span>
                                        <span>Ban Biên Tập</span>
                                        <span>&bull;</span>
                                        <span class="text-primary fw-semibold">5 phút đọc</span>
                                    </div>

                                    <h5 class="card-title fw-bold mb-2">
                                        <a href="<?php echo BASE_URL ?>post/detail/<?php echo $post['id'] ?>" class="text-decoration-none text-dark hover-primary text-truncate-2" title="<?php echo htmlspecialchars($post['title']) ?>">
                                            <?php echo htmlspecialchars($post['title']) ?>
                                        </a>
                                    </h5>

                                    <p class="card-text text-muted small text-truncate-3 flex-grow-1 mb-3" style="line-height: 1.6;">
                                        <?php echo htmlspecialchars($post['excerpt']) ?>
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <a href="<?php echo BASE_URL ?>post/detail/<?php echo $post['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                            Đọc toàn bài &rarr;
                                        </a>
                                        <span class="text-muted small fst-italic">Miễn phí</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Sidebar bên phải -->
            <div class="col-lg-4">
                <!-- Box Giới thiệu chuyên mục -->
                <div class="card shadow-sm border mb-4 rounded-3 overflow-hidden">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold fs-6">Về Chuyên Mục Bài Viết</h5>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-3" style="line-height: 1.6;">
                            Chúng tôi tin rằng việc đọc sách không chỉ dừng lại ở trang bìa cuối cùng. Các bài viết tại BookStore được biên soạn kỹ lưỡng nhằm mang đến giá trị thực tiễn, giúp độc giả chọn sách chuẩn xác và ứng dụng tri thức vào cuộc sống.
                        </p>
                        <div class="d-flex flex-column gap-2 small">
                            <div class="d-flex justify-content-between text-secondary py-1 border-bottom">
                                <span>Phân loại tác phẩm:</span>
                                <strong class="text-dark">Sâu sắc &amp; Chọn lọc</strong>
                            </div>
                            <div class="d-flex justify-content-between text-secondary py-1 border-bottom">
                                <span>Tần suất cập nhật:</span>
                                <strong class="text-dark">Hàng tuần</strong>
                            </div>
                            <div class="d-flex justify-content-between text-secondary py-1">
                                <span>Đội ngũ chấp bút:</span>
                                <strong class="text-dark">Biên tập viên BookStore</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chuyên Mục Đọc Sách -->
                <div class="card shadow-sm border mb-4 rounded-3 overflow-hidden">
                    <div class="card-header bg-light py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark">Chuyên Mục Chủ Đề</h6>
                    </div>
                    <div class="list-group list-group-flush small">
                        <a href="<?php echo BASE_URL ?>post" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                            <span>Sách Kinh Điển Khuyên Đọc</span>
                            <span class="badge bg-light text-dark border rounded-pill">1</span>
                        </a>
                        <a href="<?php echo BASE_URL ?>post" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                            <span>Kỹ Năng &amp; Phương Pháp Đọc</span>
                            <span class="badge bg-light text-dark border rounded-pill">2</span>
                        </a>
                        <a href="<?php echo BASE_URL ?>post" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                            <span>Văn Hóa Đọc Hiện Đại</span>
                            <span class="badge bg-light text-dark border rounded-pill">1</span>
                        </a>
                        <a href="<?php echo BASE_URL ?>post" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                            <span>Không Gian Sống &amp; Cảm Hứng</span>
                            <span class="badge bg-light text-dark border rounded-pill">1</span>
                        </a>
                        <a href="<?php echo BASE_URL ?>post" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                            <span>Review &amp; Cảm Nhận Tác Phẩm</span>
                            <span class="badge bg-light text-dark border rounded-pill">1</span>
                        </a>
                    </div>
                </div>

                <!-- Bài viết được quan tâm -->
                <div class="card shadow-sm border mb-4 rounded-3 overflow-hidden">
                    <div class="card-header bg-light py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark">Bài Viết Đọc Nhiều</h6>
                    </div>
                    <div class="card-body p-3">
                        <?php 
                        $highlightPosts = array_slice($data['posts'], 0, 3);
                        ?>
                        <?php foreach ($highlightPosts as $hp) : ?>
                            <?php 
                            $hpThumb = post_image_url(isset($hp['image']) ? $hp['image'] : '');
                            ?>
                            <div class="d-flex gap-3 mb-3 pb-3 border-bottom align-items-center">
                                <a href="<?php echo BASE_URL ?>post/detail/<?php echo $hp['id'] ?>" style="width: 70px; height: 50px; flex-shrink: 0; overflow: hidden; border-radius: 6px;">
                                    <img src="<?php echo htmlspecialchars($hpThumb, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($hp['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                <div class="flex-grow-1">
                                    <a href="<?php echo BASE_URL ?>post/detail/<?php echo $hp['id'] ?>" class="text-dark text-decoration-none fw-semibold small text-truncate-2 hover-primary" style="line-height: 1.4;">
                                        <?php echo htmlspecialchars($hp['title']); ?>
                                    </a>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?php echo date('d/m/Y', strtotime($hp['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-center mt-2">
                            <a href="<?php echo BASE_URL ?>book" class="btn btn-sm btn-outline-secondary w-100 rounded-pill">
                                Khám phá kho sách &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Câu nói hay -->
                <div class="card border-0 bg-light-subtle shadow-sm p-4 rounded-3 border text-center">
                    <p class="fst-italic text-secondary small mb-2">
                        "Sách là ngọn đèn bất diệt soi sáng bước đường phát triển của nền văn minh nhân loại."
                    </p>
                    <small class="fw-bold text-dark">— Francis Bacon</small>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
