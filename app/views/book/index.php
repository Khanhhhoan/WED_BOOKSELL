<div class="mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cửa hàng sách</li>
        </ol>
    </nav>

    <!-- Header & Thống kê kết quả -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">
                <?php if (!empty($data['filters']['category_id'])) : ?>
                    <?php
                    $activeCatName = '';
                    foreach ($data['categories'] as $c) {
                        if ((int)$c['id'] === (int)$data['filters']['category_id']) {
                            $activeCatName = $c['name'];
                            break;
                        }
                    }
                    echo htmlspecialchars($activeCatName !== '' ? 'Danh mục: ' . $activeCatName : 'Cửa Hàng Sách');
                    ?>
                <?php else : ?>
                    Tất Cả Sản Phẩm Sách
                <?php endif; ?>
            </h2>
            <p class="text-muted small mb-0">
                Tìm thấy <strong class="text-primary"><?php echo $data['totalBooks'] ?></strong> cuốn sách phù hợp
            </p>
        </div>

        <!-- Nút toggle bộ lọc trên Mobile -->
        <button class="btn btn-outline-primary d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-expanded="false" aria-controls="filterSidebar">
            <i class="bi bi-funnel me-1"></i> Bộ lọc & Tìm kiếm
        </button>
    </div>

    <!-- Thanh tiêu chí đang lọc (Active Filter Chips) -->
    <?php
    $f = $data['filters'];
    $hasActiveFilters = (!empty($f['keyword']) || !empty($f['category_id']) || !empty($f['author_id']) || !empty($f['price_range']) || !empty($f['min_price']) || !empty($f['max_price']) || !empty($f['in_stock']));
    ?>
    <?php if ($hasActiveFilters) : ?>
        <div class="card border-0 bg-light-subtle shadow-sm p-3 mb-4 rounded-3 border">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="small fw-bold text-muted me-1"><i class="bi bi-funnel-fill me-1 text-primary"></i>Đang lọc theo:</span>

                <!-- Chip từ khóa -->
                <?php if (!empty($f['keyword'])) : ?>
                    <?php
                    $u = $f; unset($u['keyword']);
                    $removeUrl = BASE_URL . 'book?' . http_build_query($u);
                    ?>
                    <span class="badge bg-white text-dark border shadow-sm p-2 rounded-pill d-inline-flex align-items-center gap-1">
                        Từ khóa: "<strong><?php echo htmlspecialchars($f['keyword']) ?></strong>"
                        <a href="<?php echo $removeUrl ?>" class="text-danger text-decoration-none ms-1">&times;</a>
                    </span>
                <?php endif; ?>

                <!-- Chip danh mục -->
                <?php if (!empty($f['category_id'])) : ?>
                    <?php
                    $cName = 'Danh mục';
                    foreach ($data['categories'] as $c) {
                        if ((int)$c['id'] === (int)$f['category_id']) { $cName = $c['name']; break; }
                    }
                    $u = $f; unset($u['category_id']);
                    $removeUrl = BASE_URL . 'book?' . http_build_query($u);
                    ?>
                    <span class="badge bg-white text-dark border shadow-sm p-2 rounded-pill d-inline-flex align-items-center gap-1">
                        Danh mục: <strong><?php echo htmlspecialchars($cName) ?></strong>
                        <a href="<?php echo $removeUrl ?>" class="text-danger text-decoration-none ms-1">&times;</a>
                    </span>
                <?php endif; ?>

                <!-- Chip tác giả -->
                <?php if (!empty($f['author_id'])) : ?>
                    <?php
                    $aName = 'Tác giả';
                    foreach ($data['authors'] as $a) {
                        if ((int)$a['id'] === (int)$f['author_id']) { $aName = $a['name']; break; }
                    }
                    $u = $f; unset($u['author_id']);
                    $removeUrl = BASE_URL . 'book?' . http_build_query($u);
                    ?>
                    <span class="badge bg-white text-dark border shadow-sm p-2 rounded-pill d-inline-flex align-items-center gap-1">
                        Tác giả: <strong><?php echo htmlspecialchars($aName) ?></strong>
                        <a href="<?php echo $removeUrl ?>" class="text-danger text-decoration-none ms-1">&times;</a>
                    </span>
                <?php endif; ?>

                <!-- Chip khoảng giá định sẵn -->
                <?php if (!empty($f['price_range'])) : ?>
                    <?php
                    $prText = '';
                    switch ($f['price_range']) {
                        case 'under_50': $prText = 'Dưới 50.000 đ'; break;
                        case '50_100': $prText = '50.000 đ - 100.000 đ'; break;
                        case '100_200': $prText = '100.000 đ - 200.000 đ'; break;
                        case 'above_200': $prText = 'Trên 200.000 đ'; break;
                    }
                    $u = $f; unset($u['price_range']);
                    $removeUrl = BASE_URL . 'book?' . http_build_query($u);
                    ?>
                    <span class="badge bg-white text-dark border shadow-sm p-2 rounded-pill d-inline-flex align-items-center gap-1">
                        Giá: <strong><?php echo $prText ?></strong>
                        <a href="<?php echo $removeUrl ?>" class="text-danger text-decoration-none ms-1">&times;</a>
                    </span>
                <?php endif; ?>

                <!-- Chip giá tùy chỉnh -->
                <?php if (!empty($f['min_price']) || !empty($f['max_price'])) : ?>
                    <?php
                    $u = $f; unset($u['min_price']); unset($u['max_price']);
                    $removeUrl = BASE_URL . 'book?' . http_build_query($u);
                    ?>
                    <span class="badge bg-white text-dark border shadow-sm p-2 rounded-pill d-inline-flex align-items-center gap-1">
                        Giá: <strong><?php echo !empty($f['min_price']) ? number_format($f['min_price'], 0, ',', '.') : '0' ?> đ &rarr; <?php echo !empty($f['max_price']) ? number_format($f['max_price'], 0, ',', '.') : '...' ?> đ</strong>
                        <a href="<?php echo $removeUrl ?>" class="text-danger text-decoration-none ms-1">&times;</a>
                    </span>
                <?php endif; ?>

                <!-- Chip còn hàng -->
                <?php if (!empty($f['in_stock'])) : ?>
                    <?php
                    $u = $f; unset($u['in_stock']);
                    $removeUrl = BASE_URL . 'book?' . http_build_query($u);
                    ?>
                    <span class="badge bg-white text-dark border shadow-sm p-2 rounded-pill d-inline-flex align-items-center gap-1">
                        <i class="bi bi-check2-circle text-success"></i> Còn hàng
                        <a href="<?php echo $removeUrl ?>" class="text-danger text-decoration-none ms-1">&times;</a>
                    </span>
                <?php endif; ?>

                <!-- Nút xóa tất cả -->
                <a href="<?php echo BASE_URL ?>book" class="btn btn-sm btn-link text-danger text-decoration-none fw-semibold ms-auto">
                    <i class="bi bi-trash3 me-1"></i>Xóa tất cả bộ lọc
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- ========================================== -->
        <!-- SIDEBAR BỘ LỌC SẢN PHẨM (TRÁI) -->
        <!-- ========================================== -->
        <div class="col-lg-3">
            <div class="collapse d-lg-block" id="filterSidebar">
                <form action="<?php echo BASE_URL ?>book" method="GET" id="catalogFilterForm">
                    
                    <!-- Giữ lại sắp xếp nếu đang chọn -->
                    <?php if (!empty($f['sort'])) : ?>
                        <input type="hidden" name="sort" value="<?php echo htmlspecialchars($f['sort']) ?>">
                    <?php endif; ?>

                    <!-- 1. Tìm kiếm từ khóa -->
                    <div class="card border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <div class="card-header bg-white py-3 border-bottom fw-bold text-dark d-flex align-items-center">
                            <i class="bi bi-search me-2 text-primary"></i>Tìm Kiếm Sách
                        </div>
                        <div class="card-body p-3">
                            <div class="input-group">
                                <input type="search" name="keyword" class="form-control" placeholder="Tên sách, tác giả..." value="<?php echo htmlspecialchars($f['keyword']) ?>">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Lọc theo Danh mục -->
                    <div class="card border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <div class="card-header bg-white py-3 border-bottom fw-bold text-dark d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-grid me-2 text-primary"></i>Thể Loại Sách</span>
                            <?php if (!empty($f['category_id'])) : ?>
                                <a href="<?php echo BASE_URL ?>book?<?php $u = $f; unset($u['category_id']); echo http_build_query($u); ?>" class="small text-muted text-decoration-none">Bỏ chọn</a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-3 border-0 pe-auto cursor-pointer <?php echo empty($f['category_id']) ? 'bg-light-subtle fw-bold' : '' ?>">
                                    <div class="d-flex align-items-center gap-2">
                                        <input class="form-check-input mt-0" type="radio" name="category_id" value="" onchange="this.form.submit()" <?php echo empty($f['category_id']) ? 'checked' : '' ?>>
                                        <span>Tất cả thể loại</span>
                                    </div>
                                </label>
                                <?php if (!empty($data['categories'])) : ?>
                                    <?php foreach ($data['categories'] as $cat) : ?>
                                        <?php $isSelected = ((int)$f['category_id'] === (int)$cat['id']); ?>
                                        <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-3 border-0 pe-auto cursor-pointer <?php echo $isSelected ? 'bg-light-subtle fw-bold text-primary' : '' ?>">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input mt-0" type="radio" name="category_id" value="<?php echo $cat['id'] ?>" onchange="this.form.submit()" <?php echo $isSelected ? 'checked' : '' ?>>
                                                <span><?php echo htmlspecialchars($cat['name']) ?></span>
                                            </div>
                                            <span class="badge rounded-pill bg-light text-secondary border"><?php echo (int)$cat['book_count'] ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Lọc theo Khoảng giá -->
                    <div class="card border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <div class="card-header bg-white py-3 border-bottom fw-bold text-dark d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-tag me-2 text-primary"></i>Khoảng Giá</span>
                            <?php if (!empty($f['price_range']) || !empty($f['min_price']) || !empty($f['max_price'])) : ?>
                                <a href="<?php echo BASE_URL ?>book?<?php $u = $f; unset($u['price_range']); unset($u['min_price']); unset($u['max_price']); echo http_build_query($u); ?>" class="small text-muted text-decoration-none">Bỏ chọn</a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-3">
                            <!-- Các mức giá định sẵn -->
                            <div class="d-flex flex-column gap-2 mb-3">
                                <label class="form-check d-flex align-items-center gap-2 mb-0 cursor-pointer">
                                    <input class="form-check-input" type="radio" name="price_range" value="" onchange="this.form.submit()" <?php echo empty($f['price_range']) && empty($f['min_price']) ? 'checked' : '' ?>>
                                    <span class="small">Tất cả mức giá</span>
                                </label>
                                <label class="form-check d-flex align-items-center gap-2 mb-0 cursor-pointer">
                                    <input class="form-check-input" type="radio" name="price_range" value="under_50" onchange="this.form.submit()" <?php echo ($f['price_range'] === 'under_50') ? 'checked' : '' ?>>
                                    <span class="small">Dưới 50.000 đ</span>
                                </label>
                                <label class="form-check d-flex align-items-center gap-2 mb-0 cursor-pointer">
                                    <input class="form-check-input" type="radio" name="price_range" value="50_100" onchange="this.form.submit()" <?php echo ($f['price_range'] === '50_100') ? 'checked' : '' ?>>
                                    <span class="small">50.000 đ - 100.000 đ</span>
                                </label>
                                <label class="form-check d-flex align-items-center gap-2 mb-0 cursor-pointer">
                                    <input class="form-check-input" type="radio" name="price_range" value="100_200" onchange="this.form.submit()" <?php echo ($f['price_range'] === '100_200') ? 'checked' : '' ?>>
                                    <span class="small">100.000 đ - 200.000 đ</span>
                                </label>
                                <label class="form-check d-flex align-items-center gap-2 mb-0 cursor-pointer">
                                    <input class="form-check-input" type="radio" name="price_range" value="above_200" onchange="this.form.submit()" <?php echo ($f['price_range'] === 'above_200') ? 'checked' : '' ?>>
                                    <span class="small">Trên 200.000 đ</span>
                                </label>
                            </div>

                            <hr class="my-2 border-light">

                            <!-- Nhập khoảng giá thủ công -->
                            <span class="small text-muted d-block mb-2">Hoặc nhập khoảng giá (đ):</span>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control form-control-sm font-monospace" placeholder="Từ" value="<?php echo htmlspecialchars($f['min_price']) ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control form-control-sm font-monospace" placeholder="Đến" value="<?php echo htmlspecialchars($f['max_price']) ?>">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">Áp Dụng Giá</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Lọc theo Tác giả -->
                    <?php if (!empty($data['authors'])) : ?>
                        <div class="card border-0 shadow-sm rounded-3 mb-3 bg-white">
                            <div class="card-header bg-white py-3 border-bottom fw-bold text-dark d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person me-2 text-primary"></i>Tác Giả</span>
                                <?php if (!empty($f['author_id'])) : ?>
                                    <a href="<?php echo BASE_URL ?>book?<?php $u = $f; unset($u['author_id']); echo http_build_query($u); ?>" class="small text-muted text-decoration-none">Bỏ chọn</a>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-3">
                                <select name="author_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="">-- Tất cả tác giả --</option>
                                    <?php foreach ($data['authors'] as $author) : ?>
                                        <option value="<?php echo $author['id'] ?>" <?php echo ((int)$f['author_id'] === (int)$author['id']) ? 'selected' : '' ?>>
                                            <?php echo htmlspecialchars($author['name']) ?> (<?php echo (int)$author['book_count'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 5. Tình trạng tồn kho -->
                    <div class="card border-0 shadow-sm rounded-3 mb-3 bg-white">
                        <div class="card-body p-3">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" name="in_stock" id="stockSwitch" value="1" onchange="this.form.submit()" <?php echo (!empty($f['in_stock']) && $f['in_stock'] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold small cursor-pointer" for="stockSwitch">
                                    Chỉ hiển thị sách còn hàng
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Nút thao tác -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2"><i class="bi bi-funnel me-1"></i> Áp Dụng Lọc</button>
                        <?php if ($hasActiveFilters) : ?>
                            <a href="<?php echo BASE_URL ?>book" class="btn btn-outline-secondary py-2">Xóa Tất Cả Bộ Lọc</a>
                        <?php endif; ?>
                    </div>

                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- DANH SÁCH SẢN PHẨM & THANH SẮP XẾP (PHẢI) -->
        <!-- ========================================== -->
        <div class="col-lg-9">
            
            <!-- Thanh Sắp xếp trên đầu danh sách -->
            <div class="card border-0 shadow-sm p-3 mb-4 rounded-3 bg-white">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span class="text-muted small">
                        Hiển thị <strong><?php echo count($data['books']) ?></strong> trên tổng số <strong><?php echo $data['totalBooks'] ?></strong> sản phẩm
                    </span>

                    <div class="d-flex align-items-center gap-2">
                        <label class="small text-muted text-nowrap fw-semibold"><i class="bi bi-sort-down me-1"></i>Sắp xếp:</label>
                        <select class="form-select form-select-sm" style="min-width: 170px;" onchange="updateSortFilter(this.value)">
                            <option value="newest" <?php echo ($f['sort'] === 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price_asc" <?php echo ($f['sort'] === 'price_asc') ? 'selected' : '' ?>>Giá: Thấp đến Cao</option>
                            <option value="price_desc" <?php echo ($f['sort'] === 'price_desc') ? 'selected' : '' ?>>Giá: Cao đến Thấp</option>
                            <option value="name_asc" <?php echo ($f['sort'] === 'name_asc') ? 'selected' : '' ?>>Tên: A &rarr; Z</option>
                            <option value="name_desc" <?php echo ($f['sort'] === 'name_desc') ? 'selected' : '' ?>>Tên: Z &rarr; A</option>
                            <option value="oldest" <?php echo ($f['sort'] === 'oldest') ? 'selected' : '' ?>>Cũ nhất</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Lưới Sản Phẩm Sách -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php if (empty($data['books'])) : ?>
                    <div class="col-12 text-center py-5">
                        <div class="p-5 bg-white rounded-4 shadow-sm border">
                            <i class="bi bi-search text-secondary" style="font-size: 3.5rem;"></i>
                            <h4 class="fw-bold mt-3 mb-2">Không tìm thấy cuốn sách nào!</h4>
                            <p class="text-muted mb-4">Thử thay đổi từ khóa, chọn danh mục khác hoặc xóa bộ lọc để xem toàn bộ sách.</p>
                            <a href="<?php echo BASE_URL ?>book" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Xóa Bộ Lọc & Xem Tất Cả
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <?php foreach ($data['books'] as $book) : ?>
                        <?php 
                        $inStock = ((int)$book['stock'] > 0);
                        ?>
                        <div class="col">
                            <div class="card h-100 book-card shadow-sm border-0 position-relative rounded-3 overflow-hidden">
                                
                                <!-- Badge tình trạng kho / danh mục -->
                                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1" style="z-index: 2;">
                                    <?php if (!$inStock) : ?>
                                        <span class="badge bg-danger shadow-sm">Hết hàng</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Ảnh bìa -->
                                <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="text-decoration-none book-img-wrapper d-flex align-items-center justify-content-center text-center w-100" style="height: 240px; display: flex !important; align-items: center !important; justify-content: center !important; text-align: center !important; background-color: #f8fafc; overflow: hidden; padding: 12px;">
                                    <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" 
                                         class="book-img mx-auto d-block" 
                                         style="max-height: 100%; max-width: 100%; height: 216px; width: auto; object-fit: contain; margin: 0 auto !important; display: block !important;"
                                         alt="<?php echo htmlspecialchars($book['title']) ?>"
                                         loading="lazy">
                                </a>

                                <div class="card-body d-flex flex-column p-3">
                                    <!-- Thể loại -->
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge bg-light text-dark border small text-truncate" style="max-width: 140px;">
                                            <?php echo isset($book['category_name']) ? htmlspecialchars($book['category_name']) : 'Khác'; ?>
                                        </span>
                                        <?php if ($inStock) : ?>
                                            <small class="text-success small"><i class="bi bi-check-circle me-1"></i>Còn <?php echo (int)$book['stock'] ?></small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Tiêu đề -->
                                    <h6 class="card-title fw-bold mt-2 mb-1" style="line-height: 1.4;">
                                        <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="text-dark text-decoration-none text-truncate-2" title="<?php echo htmlspecialchars($book['title']) ?>">
                                            <?php echo htmlspecialchars($book['title']) ?>
                                        </a>
                                    </h6>

                                    <!-- Tác giả -->
                                    <p class="card-text text-muted small mb-3">
                                        <i class="bi bi-pen me-1"></i><?php echo isset($book['author_name']) && $book['author_name'] ? htmlspecialchars($book['author_name']) : 'Nhiều tác giả' ?>
                                    </p>

                                    <!-- Giá tiền -->
                                    <div class="mt-auto pt-2 border-top d-flex align-items-center justify-content-between mb-3">
                                        <span class="price-tag mb-0 fs-5"><?php echo number_format($book['price'], 0, ',', '.') ?> đ</span>
                                    </div>

                                    <!-- Thao tác mua -->
                                    <div class="d-flex gap-2">
                                        <?php if ($inStock) : ?>
                                            <a href="<?php echo BASE_URL ?>cart/add/<?php echo $book['id'] ?>" class="btn btn-primary btn-sm flex-grow-1 shadow-sm">
                                                <i class="bi bi-cart-plus me-1"></i> Chọn Mua
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                                Tạm Hết Hàng
                                            </button>
                                        <?php endif; ?>
                                        <a href="<?php echo BASE_URL ?>book/detail/<?php echo $book['id'] ?>" class="btn btn-outline-secondary btn-sm" title="Xem chi tiết sách">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
function updateSortFilter(sortValue) {
    var form = document.getElementById('catalogFilterForm');
    if (!form) return;

    var sortInput = form.querySelector('input[name="sort"]');
    if (!sortInput) {
        sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        form.appendChild(sortInput);
    }
    sortInput.value = sortValue;
    form.submit();
}
</script>

<style>
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 2.8em;
}
.cursor-pointer {
    cursor: pointer;
}
.book-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.book-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
}
</style>
