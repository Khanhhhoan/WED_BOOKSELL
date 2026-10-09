<!-- Hero/Banner Section -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm border" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold text-primary">Kho Sách Phong Phú</h1>
        <p class="col-md-8 fs-4 text-secondary">
            Khám phá hàng ngàn tựa sách hấp dẫn từ văn học, kinh tế, công nghệ cho đến kỹ năng sống. Cùng nâng tầm tri thức mỗi ngày!
        </p>
        <a href="<?php echo  BASE_URL ?>book" class="btn btn-primary btn-lg mt-3 shadow">Khám Phá Ngay</a>
    </div>
</div>

<!-- Featured Books -->
<div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Sách Nổi Bật</h2>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php foreach ($data['featuredBooks'] as $book) : ?>
            <div class="col">
                <div class="card h-100 book-card shadow-sm border-0">
                    <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="text-decoration-none book-img-wrapper d-flex align-items-center justify-content-center text-center w-100" style="height: 240px; display: flex !important; align-items: center !important; justify-content: center !important; text-align: center !important; background-color: #f8fafc; overflow: hidden; padding: 12px;">
                        <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" class="book-img mx-auto d-block" style="max-height: 100%; max-width: 100%; height: 216px; width: auto; object-fit: contain; margin: 0 auto !important; display: block !important;" alt="<?php echo htmlspecialchars($book['title']) ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold text-truncate" title="<?php echo htmlspecialchars($book['title']) ?>"><?php echo htmlspecialchars($book['title']) ?></h6>
                        <p class="card-text text-muted small mb-2"><?php echo isset($book['author_name']) ? $book['author_name'] : 'Đang cập nhật' ?></p>
                        <p class="price-tag mt-auto mb-3"><?php echo number_format($book['price'], 0, ',', '.') ?> đ</p>
                        <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="btn btn-outline-primary btn-sm w-100">Chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- New Books -->
<div class="mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">Sách Mới Cập Nhật</h2>
        <a href="<?php echo BASE_URL ?>book" class="text-decoration-none">Xem tất cả</a>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php foreach ($data['newBooks'] as $book) : ?>
            <div class="col">
                <div class="card h-100 book-card shadow-sm border-0">
                    <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="text-decoration-none book-img-wrapper d-flex align-items-center justify-content-center text-center w-100" style="height: 240px; display: flex !important; align-items: center !important; justify-content: center !important; text-align: center !important; background-color: #f8fafc; overflow: hidden; padding: 12px;">
                        <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" class="book-img mx-auto d-block" style="max-height: 100%; max-width: 100%; height: 216px; width: auto; object-fit: contain; margin: 0 auto !important; display: block !important;" alt="<?php echo htmlspecialchars($book['title']) ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-danger mb-2" style="width: fit-content;">Mới</span>
                        <h6 class="card-title fw-bold text-truncate" title="<?php echo htmlspecialchars($book['title']) ?>"><?php echo htmlspecialchars($book['title']) ?></h6>
                        <p class="card-text text-muted small mb-2"><?php echo isset($book['category_name']) ? $book['category_name'] : 'Khác' ?></p>
                        <p class="price-tag mt-auto mb-3"><?php echo number_format($book['price'], 0, ',', '.') ?> đ</p>
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL ?>cart/add/<?php echo $book['id'] ?>" class="btn btn-primary btn-sm flex-grow-1">Chọn</a>
                            <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="btn btn-outline-secondary btn-sm" title="Xem chi tiết">Xem</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



