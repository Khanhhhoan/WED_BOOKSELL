<div class="mb-5">
    <div class="p-4 mb-4 bg-light rounded-3 shadow-sm border">
        <h2 class="fw-bold"><i class="fas fa-newspaper text-primary me-2"></i>Tin Tức Nghệ Thuật Đọc Sự Kiện</h2>
        <p class="text-muted">Cập nhật những thông tin mới nhất về sách, tác giả và văn hóa đọc.</p>
    </div>

    <div class="row">
        <?php if (empty($data['posts'])) : ?>
            <div class="col-12 text-center py-5">
                <h5 class="text-muted">Chưa có bài viết nào được đăng.</h5>
            </div>
        <?php else : ?>
            <div class="col-lg-8">
                <?php foreach ($data['posts'] as $post) : ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Giả lập ảnh bài viết nếu không có -->
                                <img src="<?php echo  $post['image'] ? BASE_URL . 'assets/images/posts/' . $post['image'] : 'https://placehold.co/800x600?text=News' ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="Post thumbnail">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title fw-bold">
                                        <a href="<?php echo  BASE_URL ?>post/detail/<?php echo  $post['id'] ?>" class="text-decoration-none text-dark hover-primary"><?php echo  htmlspecialchars($post['title']) ?></a>
                                    </h5>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="far fa-calendar-alt me-1"></i> <?php echo  date('d/m/Y', strtotime($post['created_at'])) ?>
                                        <i class="far fa-user ms-3 me-1"></i> Admin
                                    </p>
                                    <p class="card-text flex-grow-1"><?php echo  htmlspecialchars($post['excerpt']) ?></p>
                                    <div class="mt-auto">
                                        <a href="<?php echo  BASE_URL ?>post/detail/<?php echo  $post['id'] ?>" class="btn btn-outline-primary btn-sm">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Chuyên Mục</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Sự kiện sách</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Review sách</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Góc tác giả</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Gợi ý đọc sách</a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
