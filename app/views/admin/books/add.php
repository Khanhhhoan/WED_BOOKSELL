<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">Thêm Sách Mới</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/books" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form action="<?php echo BASE_URL; ?>admin/book_add" method="POST" enctype="multipart/form-data">
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
                <label class="form-label fw-bold">Ảnh bìa (tùy chọn)</label>
                <input type="file" class="form-control" name="book_image" accept="image/jpeg,image/png,image/gif,image/webp">
                <small class="text-muted d-block mt-1">Chọn ảnh từ máy — hệ thống tự đặt tên file và lưu vào <code>public/assets/images/</code>. Không cần trùng tên với database.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả nội dung</label>
                <textarea class="form-control" name="description" rows="5"></textarea>
            </div>
            <div class="mb-4 form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                <label class="form-check-label" for="is_active">Hiển thị trên cửa hàng</label>
            </div>
            <button type="submit" class="btn btn-dark">Lưu Sách</button>
        </form>
    </div>
</div>
