<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">Thêm Sách Mới</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/books" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form action="<?php echo BASE_URL; ?>admin/book_add" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tên Sách</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Danh Mục</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach($data['categories'] as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">ID Tác Giả</label>
                    <input type="number" class="form-control" name="author_id" placeholder="Để trống nếu không rõ">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <input type="number" class="form-control" name="price" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Số lượng (Kho)</label>
                    <input type="number" class="form-control" name="stock" value="10" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tên file ảnh (VD: sach-hay.jpg)</label>
                <input type="text" class="form-control" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả nội dung</label>
                <textarea class="form-control" name="description" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu Sách</button>
        </form>
    </div>
</div>
