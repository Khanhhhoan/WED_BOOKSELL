<?php $post = $data['post']; ?>
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>post" class="text-decoration-none">Tin tức</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo  htmlspecialchars($post['title']) ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-3"><?php echo  htmlspecialchars($post['title']) ?></h1>
                    
                    <div class="d-flex align-items-center mb-4 text-muted small">
                        <i class="far fa-calendar-alt me-2"></i> <?php echo  date('d/m/Y', strtotime($post['created_at'])) ?>
                        <span class="mx-3">|</span>
                        <i class="far fa-user me-2"></i> Đăng bởi: <strong>Admin</strong>
                    </div>
                    
                    <p class="lead fst-italic text-secondary border-start border-4 border-primary ps-3 mb-4">
                        <?php echo  nl2br(htmlspecialchars($post['excerpt'])) ?>
                    </p>
                    
                    <div class="mb-4 text-center">
                        <img src="<?php echo  $post['image'] ? BASE_URL . 'assets/images/posts/' . $post['image'] : 'https://placehold.co/1200x600?text=Cover+Image' ?>" alt="<?php echo  htmlspecialchars($post['title']) ?>" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                    </div>
                    
                    <div class="post-content lh-lg text-justify fs-5">
                        <!-- Nội dung thường có HTML (từ CSDL), ta chỉ demo text thì dùng nl2br. Thực thế sẽ là htmlspecialchars_decode(post[content]) nếu đã escape cẩn thận, hoặc strip_tags... Tuy nhiên theo yc đồ án mình sẽ echo bth -->
                        <?php echo  nl2br(htmlspecialchars($post['content'])) ?>
                    </div>
                    
                    <hr class="my-5">
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php echo  BASE_URL ?>post" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Quay lại danh sách</a>
                        
                        <div class="social-share">
                            <span class="me-2 text-muted fw-bold">Chia sẻ:</span>
                            <a href="#" class="btn btn-sm btn-light text-primary"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-sm btn-light text-info"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-sm btn-light text-danger"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
