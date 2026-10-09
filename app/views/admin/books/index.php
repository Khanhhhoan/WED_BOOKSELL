<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Quản Lý Sách</h2>
        <a href="<?php echo BASE_URL; ?>admin/book_add" class="btn btn-outline-secondary btn-sm">Thêm Sách Mới</a>
    </div>

    <div class="card shadow-sm border">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h6 class="m-0 fw-semibold text-dark">Danh Sách Sách Trong Kho</h6>
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control form-control-sm" placeholder="Tìm tên sách...">
                <button class="btn btn-sm btn-outline-secondary" type="button">Tìm</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Bìa</th>
                            <th>Tên sách</th>
                            <th>Danh mục</th>
                            <th class="text-end">Giá</th>
                            <th class="text-center">Tồn kho</th>
                            <th class="text-center">Cửa hàng</th>
                            <th class="text-center pe-4" style="width: 200px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['books'])) : ?>
                            <tr><td colspan="8" class="text-center py-4">Chưa có sản phẩm Sách nào.</td></tr>
                        <?php else : ?>
                            <?php foreach ($data['books'] as $book) : ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?php echo  $book['id'] ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" class="rounded shadow-sm" style="width: 40px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;" title="<?php echo  htmlspecialchars($book['title']) ?>">
                                            <?php echo  htmlspecialchars($book['title']) ?>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?php echo  htmlspecialchars($book['category_name']) ?></span></td>
                                    <td class="text-end fw-semibold text-dark"><?php echo  number_format($book['price'], 0, ',', '.') ?>đ</td>
                                    <td class="text-center">
                                        <?php if ($book['stock'] > 10) : ?>
                                            <span class="badge rounded-pill admin-badge-pill"><?php echo  $book['stock'] ?></span>
                                        <?php elseif ($book['stock'] > 0) : ?>
                                            <span class="badge rounded-pill admin-badge-pill"><?php echo  $book['stock'] ?></span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill admin-badge-pill text-danger">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($book['is_active'])) : ?>
                                            <span class="badge rounded-pill admin-badge-pill">Đang bán</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill admin-badge-pill text-secondary">Đã ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="<?php echo BASE_URL; ?>admin/book_edit/<?php echo $book['id']; ?>" class="btn btn-sm btn-outline-secondary mb-1" title="Sửa">Sửa</a>
                                        <?php if (!empty($book['is_active'])) : ?>
                                            <form action="<?php echo BASE_URL ?>admin/book_delete/<?php echo $book['id']; ?>" method="POST" class="d-inline-block">
                                                <button type="submit" class="btn btn-sm btn-outline-warning mb-1" title="Ẩn khỏi cửa hàng" onclick="return confirm('Ẩn sách khỏi cửa hàng? Sách vẫn giữ trong hệ thống và lịch sử đơn hàng.');">Ẩn</button>
                                            </form>
                                        <?php else : ?>
                                            <form action="<?php echo BASE_URL ?>admin/book_show/<?php echo $book['id']; ?>" method="POST" class="d-inline-block">
                                                <button type="submit" class="btn btn-sm btn-outline-success mb-1" title="Hiện lại trên cửa hàng">Hiện lại</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
