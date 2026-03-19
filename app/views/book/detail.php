<?php $book = $data['book']; ?>
<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>book" class="text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo  htmlspecialchars($book['title']) ?></li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <div class="row">
                <!-- Book Image -->
                <div class="col-md-5 col-lg-4 mb-4 mb-md-0 text-center">
                    <img src="<?php echo  $book['image'] ? BASE_URL . 'assets/images/' . $book['image'] : 'https://placehold.co/400x600?text=Book+Cover' ?>" alt="<?php echo  htmlspecialchars($book['title']) ?>" class="img-fluid rounded shadow" style="max-height: 500px; object-fit: contain;">
                </div>
                
                <!-- Book Details -->
                <div class="col-md-7 col-lg-8">
                    <h2 class="fw-bold mb-3"><?php echo  htmlspecialchars($book['title']) ?></h2>
                    
                    <div class="d-flex flex-wrap gap-4 mb-4 text-muted">
                        <div><i class="fas fa-user-edit me-2"></i>Tác giả: <strong><?php echo isset($book['author_name']) ? $book['author_name'] : 'Đang cập nhật' ?></strong></div>
                        <div><i class="fas fa-layer-group me-2"></i>Thể loại: <strong><?php echo isset($book['category_name']) ? $book['category_name'] : 'Khác' ?></strong></div>
                        <div><i class="fas fa-box me-2"></i>Tình trạng: 
                            <?php if ($book['stock'] > 0) : ?>
                                <span class="badge bg-success">Còn <?php echo  $book['stock'] ?> cuốn</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Hết hàng</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <h3 class="price-tag display-6 mb-4"><?php echo  number_format($book['price'], 0, ',', '.') ?> VNĐ</h3>
                    
                    <p class="lead fs-6 mb-4" style="line-height: 1.8;">
                        <?php echo  nl2br(htmlspecialchars($book['description'])) ?>
                    </p>
                    
                    <hr>
                    
                    <?php if ($book['stock'] > 0) : ?>
                        <form action="<?php echo  BASE_URL ?>cart/add/<?php echo  $book['id'] ?>" method="POST" class="d-flex align-items-center gap-3 mt-4">
                            <div class="input-group" style="width: 140px;">
                                <span class="input-group-text bg-white">SL</span>
                                <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?php echo  $book['stock'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4"><i class="fas fa-cart-plus me-2"></i>Thêm Vào Giỏ Hàng</button>
                        </form>
                    <?php else : ?>
                        <div class="alert alert-warning mt-4 d-inline-block">
                            <i class="fas fa-exclamation-triangle me-2"></i>Sản phẩm hiện đang tạm hết hàng. Vui lòng quay lại sau!
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
