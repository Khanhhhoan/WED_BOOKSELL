<?php $book = $data['book']; ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">Sửa Sách</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/books" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form action="<?php echo BASE_URL; ?>admin/book_edit/<?php echo $book['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars((string)(isset($book['image']) ? $book['image'] : '')); ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tên Sách</label>
                    <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Danh Mục</label>
                    <select class="form-select" name="category_id" required>
                        <?php foreach($data['categories'] as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $book['category_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">ID Tác Giả</label>
                    <input type="number" class="form-control" name="author_id" value="<?php echo isset($book['author_id']) ? $book['author_id'] : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <input type="number" class="form-control" name="price" value="<?php echo $book['price']; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Số lượng (Kho)</label>
                    <input type="number" class="form-control" name="stock" value="<?php echo $book['stock']; ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh bìa</label>
                <?php if (!empty($book['image'])) : ?>
                    <div class="mb-2">
                        <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" alt="" class="rounded border" style="max-height: 180px; max-width: 140px; object-fit: cover;">
                        <div class="small text-muted mt-1">Ảnh hiện tại: <code><?php echo htmlspecialchars($book['image']); ?></code></div>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" name="book_image" accept="image/jpeg,image/png,image/gif,image/webp">
                <small class="text-muted d-block mt-1">Chọn ảnh mới từ máy để thay bìa (JPG, PNG, GIF, WebP). Để trống nếu chỉ sửa chữ — giữ ảnh cũ.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả nội dung</label>
                <textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars((string)isset($book['description'])?$book['description']:''); ?></textarea>
            </div>
            <div class="mb-4 form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?php echo (!isset($book['is_active']) || (int)$book['is_active'] === 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_active">Hiển thị trên cửa hàng</label>
            </div>
            <button type="submit" class="btn btn-dark">Cập Nhật Sách</button>
        </form>
    </div>
</div>
