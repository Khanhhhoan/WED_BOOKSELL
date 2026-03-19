<!-- Book List Section -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-book text-primary me-2"></i>Tất Cả Sản Phẩm</h2>
        <?php if (!empty($data['keyword'])) : ?>
            <span class="text-muted">Kết quả tìm kiếm cho: <strong>"<?php echo  htmlspecialchars($data['keyword']) ?>"</strong></span>
        <?php endif; ?>
    </div>

    <!-- Sẽ có sidebar filter sau nếu cần (author, category...) -->
    
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if (empty($data['books'])) : ?>
            <div class="col-12 text-center py-5">
                <h5 class="text-muted">Không tìm thấy sản phẩm nào.</h5>
                <a href="<?php echo  BASE_URL ?>book" class="btn btn-primary mt-3">Xem tất cả sách</a>
            </div>
        <?php else : ?>
            <?php foreach ($data['books'] as $book) : ?>
                <div class="col">
                    <div class="card h-100 book-card shadow-sm border-0">
                        <img src="<?php echo  $book['image'] ? BASE_URL . 'assets/images/' . $book['image'] : 'https://placehold.co/400x600?text=Book+Cover' ?>" class="card-img-top book-img p-2" alt="<?php echo  htmlspecialchars($book['title']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate" title="<?php echo  htmlspecialchars($book['title']) ?>"><?php echo  htmlspecialchars($book['title']) ?></h6>
                            <p class="card-text text-muted small mb-2"><i class="fas fa-user-edit me-1"></i><?php echo isset($book['author_name']) ? $book['author_name'] : 'Đang cập nhật' ?></p>
                            <p class="price-tag mt-auto mb-3"><?php echo  number_format($book['price'], 0, ',', '.') ?> đ</p>
                            <div class="d-flex gap-2">
                                <a href="<?php echo  BASE_URL ?>cart/add/<?php echo  $book['id'] ?>" class="btn btn-primary btn-sm flex-grow-1"><i class="fas fa-cart-plus"></i> Chọn</a>
                                <a href="<?php echo  BASE_URL ?>book/detail/<?php echo  $book['id'] ?>" class="btn btn-outline-secondary btn-sm" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
