<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark mb-1">Thêm Bài Viết Mới</h2>
        <p class="text-muted small mb-0">Tạo bài viết tin tức, bài chia sẻ cảm nhận hoặc giới thiệu sách</p>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/posts" class="btn btn-outline-secondary">Quay lại danh sách</a>
    </div>
</div>

<div class="card shadow-sm border rounded-3">
    <div class="card-body p-4 p-md-5">
        <form action="<?php echo BASE_URL; ?>admin/post_add" method="POST" enctype="multipart/form-data">
            
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Tiêu đề bài viết <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-lg" name="title" placeholder="Nhập tiêu đề bài viết..." required>
            </div>
            
            <!-- Khu vực tải lên hình ảnh bìa bài viết -->
            <div class="mb-4 p-4 bg-light rounded-3 border">
                <label class="form-label fw-bold text-dark d-block mb-1">
                    Hình ảnh bìa bài viết
                </label>
                <p class="text-muted small mb-3">Tải lên file ảnh trực tiếp từ máy tính. Hỗ trợ JPG, PNG, GIF, WebP (Tỷ lệ khuyến nghị 16:9 hoặc khoảng 800x500px).</p>
                
                <div class="row g-3 align-items-center">
                    <div class="col-md-7">
                        <label class="form-label small text-secondary fw-semibold">Chọn file ảnh từ thiết bị:</label>
                        <input type="file" class="form-control" name="post_image" id="postImageInput" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewSelectedPostImage(this);">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small text-secondary fw-semibold">Hoặc nhập tên file / link URL:</label>
                        <input type="text" class="form-control" name="image" placeholder="Ví dụ: post_1_sach_kinh_dien.jpg">
                    </div>
                </div>

                <!-- Khung xem trước ảnh tải lên ngay trên trình duyệt -->
                <div id="imagePreviewContainer" class="mt-3 p-3 bg-white rounded-3 border shadow-sm d-none" style="max-width: 380px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-success">Xem trước ảnh mới:</span>
                        <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none p-0" onclick="clearSelectedPostImage();">Hủy chọn</button>
                    </div>
                    <img id="postImagePreview" src="#" alt="Preview" class="img-fluid rounded border" style="max-height: 200px; width: 100%; object-fit: cover;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Đoạn trích dẫn / Tóm tắt ngắn</label>
                <textarea class="form-control" name="excerpt" rows="3" placeholder="Đoạn mô tả ngắn hiển thị bên ngoài danh sách bài viết..."></textarea>
                <small class="text-muted">Khoảng 1 - 3 câu tóm tắt làm nổi bật chủ đề bài viết.</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nội dung bài viết chi tiết <span class="text-danger">*</span></label>
                <textarea class="form-control font-monospace" name="content" rows="14" placeholder="Nhập toàn văn bài viết chi tiết..." required style="line-height: 1.6;"></textarea>
                <small class="text-muted">Các mục đánh số (1., 2...) sẽ được hệ thống tự động định dạng thành các đề mục lớn đẹp mắt.</small>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 fw-bold">Lưu Bài Viết</button>
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
