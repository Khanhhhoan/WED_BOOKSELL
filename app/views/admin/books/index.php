<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-book text-primary me-2"></i>Quản Lý Sách</h2>
        <a href="<?php echo BASE_URL; ?>admin/book_add" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Thêm Sách Mới</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-list me-1"></i>Danh Sách Sách Trong Kho</h6>
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control form-control-sm" placeholder="Tìm tên sách...">
                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
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
                            <th class="text-center pe-4" style="width: 120px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['books'])) : ?>
                            <tr><td colspan="7" class="text-center py-4">Chưa có sản phẩm Sách nào.</td></tr>
                        <?php else : ?>
                            <?php foreach ($data['books'] as $book) : ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?php echo  $book['id'] ?></td>
                                    <td>
                                        <img src="<?php echo  $book['image'] ? BASE_URL . 'assets/images/' . $book['image'] : 'https://placehold.co/100x150' ?>" class="rounded shadow-sm" style="width: 40px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;" title="<?php echo  htmlspecialchars($book['title']) ?>">
                                            <?php echo  htmlspecialchars($book['title']) ?>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?php echo  htmlspecialchars($book['category_name']) ?></span></td>
                                    <td class="text-end fw-bold text-danger"><?php echo  number_format($book['price'], 0, ',', '.') ?>đ</td>
                                    <td class="text-center">
                                        <?php if ($book['stock'] > 10) : ?>
                                            <span class="badge bg-success rounded-pill"><?php echo  $book['stock'] ?></span>
                                        <?php elseif ($book['stock'] > 0) : ?>
                                            <span class="badge bg-warning text-dark rounded-pill"><?php echo  $book['stock'] ?></span>
                                        <?php else : ?>
                                            <span class="badge bg-danger rounded-pill">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="<?php echo BASE_URL; ?>admin/book_edit/<?php echo $book['id']; ?>" class="btn btn-sm btn-info text-white mb-1" title="Sửa"><i class="fas fa-edit"></i></a>
                                        <form action="<?php echo  BASE_URL ?>admin/book_delete/<?php echo  $book['id'] ?>" method="POST" class="d-inline-block">
                                            <button type="submit" class="btn btn-sm btn-danger mb-1" title="Xóa" onclick="return confirm('Xóa sách vĩnh viễn?');"><i class="fas fa-trash-alt"></i></button>
                                        </form>
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
