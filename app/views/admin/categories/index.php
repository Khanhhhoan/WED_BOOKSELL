<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-tags text-primary me-2"></i>Quản Lý Danh Mục</h2>
    </div>

    <div class="row">
        <!-- Form thêm mới danh mục -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-plus-circle me-1"></i>Thêm Danh Mục Mới</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo  BASE_URL ?>admin/category_add" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Nhập tên danh mục...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Mô tả ngắn..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i>Lưu Danh Mục</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách danh mục -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-list me-1"></i>Danh Sách Danh Mục</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th class="text-center" style="width: 150px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($data['categories'])) : ?>
                                    <tr><td colspan="4" class="text-center py-4">Chưa có danh mục nào.</td></tr>
                                <?php else : ?>
                                    <?php foreach ($data['categories'] as $cat) : ?>
                                        <tr>
                                            <td class="ps-4 fw-bold">#<?php echo  $cat['id'] ?></td>
                                            <td class="fw-bold text-primary"><?php echo  htmlspecialchars($cat['name']) ?></td>
                                            <td><?php echo  htmlspecialchars(mb_strimwidth($cat['description'], 0, 50, '...')) ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo  BASE_URL ?>admin/category_edit/<?php echo  $cat['id'] ?>" class="btn btn-sm btn-info text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>
                                                
                                                <form action="<?php echo  BASE_URL ?>admin/category_delete/<?php echo  $cat['id'] ?>" method="POST" class="d-inline-block">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Mọi sách thuộc danh mục có thể bị xóa theo!');"><i class="fas fa-trash-alt"></i></button>
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
    </div>
</div>
