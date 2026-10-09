<?php $post = $data['post']; ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark mb-1">Chỉnh Sửa Bài Viết</h2>
        <p class="text-muted small mb-0">Cập nhật nội dung, tiêu đề hoặc thay đổi hình ảnh bài viết #<?php echo (int)$post['id']; ?></p>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/posts" class="btn btn-outline-secondary">Quay lại danh sách</a>
    </div>
</div>

<div class="card shadow-sm border rounded-3">
    <div class="card-body p-4 p-md-5">
        <form action="<?php echo BASE_URL; ?>admin/post_edit/<?php echo $post['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars(isset($post['image']) ? (string)$post['image'] : ''); ?>">
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Tiêu đề bài viết <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-lg" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            
            <!-- Khu vực quản lý và tải lên hình ảnh bìa bài viết -->
            <div class="mb-4 p-4 bg-light rounded-3 border">
                <label class="form-label fw-bold text-dark d-block mb-1">
                    Hình ảnh bìa bài viết
                </label>
                <p class="text-muted small mb-3">Tải lên file ảnh mới từ thiết bị nếu muốn thay thế ảnh hiện tại. Hỗ trợ JPG, PNG, GIF, WebP.</p>

                <div class="row g-4 align-items-start">
                    <!-- Ảnh bìa hiện tại -->
                    <div class="col-md-4">
                        <label class="form-label small text-secondary fw-semibold">Ảnh hiện tại:</label>
                        <div class="p-2 bg-white rounded-3 border text-center shadow-sm">
                            <img src="<?php echo htmlspecialchars(post_image_url(isset($post['image']) ? $post['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid rounded border mb-2" style="max-height: 140px; width: 100%; object-fit: cover;" alt="Current Image">
                            <div class="small text-muted text-truncate" title="<?php echo htmlspecialchars(isset($post['image']) ? $post['image'] : ''); ?>">
                                File: <code><?php echo htmlspecialchars(!empty($post['image']) ? $post['image'] : '(Chưa có ảnh)'); ?></code>
                            </div>
                        </div>
                    </div>

                    <!-- Tải lên ảnh mới -->
                    <div class="col-md-8">
                        <label class="form-label small text-secondary fw-semibold">Chọn file ảnh mới để thay thế:</label>
                        <input type="file" class="form-control mb-2" name="post_image" id="postImageInput" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewSelectedPostImage(this);">
                        <small class="text-muted d-block mb-3">Để trống nếu bạn muốn tiếp tục sử dụng ảnh bìa hiện tại.</small>

                        <div class="pt-2 border-top">
                            <label class="form-label small text-secondary fw-semibold">Hoặc giữ/đổi tên file thủ công:</label>
                            <input type="text" class="form-control form-control-sm" name="image" value="<?php echo htmlspecialchars(isset($post['image']) ? (string)$post['image'] : ''); ?>" placeholder="Tên file trong public/assets/images/posts/ hoặc URL">
                        </div>

                        <!-- Khung xem trước ảnh mới tải lên -->
                        <div id="imagePreviewContainer" class="mt-3 p-3 bg-white rounded-3 border shadow-sm d-none" style="max-width: 320px;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold text-success">Ảnh mới sẽ thay thế:</span>
                                <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none p-0" onclick="clearSelectedPostImage();">Hủy</button>
                            </div>
                            <img id="postImagePreview" src="#" alt="Preview" class="img-fluid rounded border" style="max-height: 160px; width: 100%; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Đoạn trích dẫn / Tóm tắt ngắn</label>
                <textarea class="form-control" name="excerpt" rows="3"><?php echo htmlspecialchars(isset($post['excerpt']) ? (string)$post['excerpt'] : ''); ?></textarea>
                <small class="text-muted">Đoạn tóm tắt hiển thị ở trang danh sách bài viết.</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nội dung bài viết chi tiết <span class="text-danger">*</span></label>
                <textarea class="form-control font-monospace" name="content" rows="15" required style="line-height: 1.6;"><?php echo htmlspecialchars(isset($post['content']) ? (string)$post['content'] : ''); ?></textarea>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu Thay Đổi</button>
                <a href="<?php echo BASE_URL; ?>admin/posts" class="btn btn-outline-secondary px-3">Hủy Bỏ</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewSelectedPostImage(input) {
    var previewContainer = document.getElementById('imagePreviewContainer');
    var previewImg = document.getElementById('postImagePreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.classList.add('d-none');
    }
}

function clearSelectedPostImage() {
    var input = document.getElementById('postImageInput');
    input.value = '';
    document.getElementById('imagePreviewContainer').classList.add('d-none');
    document.getElementById('postImagePreview').src = '#';
}
</script>
