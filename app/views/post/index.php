<div class="mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bài viết &amp; Tin tức</li>
        </ol>
    </nav>

    <!-- Tiêu đề trang cơ bản -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Bài Viết &amp; Tin Tức</h2>
        <p class="text-muted small mb-0">Chia sẻ góc nhìn, bài học và cảm nhận về những cuốn sách hay</p>
    </div>

    <?php if (empty($data['posts'])) : ?>
        <div class="text-center py-5">
            <div class="p-5 bg-white rounded-3 shadow-sm border">
                <h5 class="text-muted mb-2">Chưa có bài viết nào được đăng.</h5>
                <p class="text-muted small">Vui lòng quay lại sau để đón đọc những bài viết mới nhất từ BookStore.</p>
                <a href="<?php echo BASE_URL ?>" class="btn btn-outline-secondary btn-sm mt-2">Về trang chủ</a>
            </div>
        </div>
    <?php else : ?>
        <!-- Danh sách bài viết dạng lưới đơn giản -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($data['posts'] as $post) : ?>
                <?php 
                $imageUrl = post_image_url(isset($post['image']) ? $post['image'] : '');
                ?>
                <div class="col">
                    <article class="card h-100 shadow-sm border rounded-3 overflow-hidden bg-white">
                        <a href="<?php echo BASE_URL ?>post/detail/<?php echo $post['id'] ?>" class="d-block text-decoration-none">
                            <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($post['title']) ?>"
                                 style="height: 180px; width: 100%; object-fit: cover;"
                                 loading="lazy">
                        </a>
                        <div class="card-body d-flex flex-column p-3">
                            <div class="text-muted small mb-2">
                                <?php echo date('d/m/Y', strtotime($post['created_at'])) ?>
                            </div>
                            <h5 class="card-title fw-bold fs-6 mb-2">
                                <a href="<?php echo BASE_URL ?>post/detail/<?php echo $post['id'] ?>" 
                                   class="text-decoration-none text-dark hover-primary"
                                   style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.45;"
                                   title="<?php echo htmlspecialchars($post['title']) ?>">
                                    <?php echo htmlspecialchars($post['title']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small flex-grow-1 mb-3" 
                               style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                                <?php echo htmlspecialchars($post['excerpt']) ?>
                            </p>
                            <div class="mt-auto pt-2 border-top">
                                <a href="<?php echo BASE_URL ?>post/detail/<?php echo $post['id'] ?>" class="btn btn-sm btn-outline-secondary w-100">
                                    Đọc tiếp &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
