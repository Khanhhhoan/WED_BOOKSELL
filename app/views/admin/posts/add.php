<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">Thêm Bài Viết Tin Tức</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/posts" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form action="<?php echo BASE_URL; ?>admin/post_add" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Tiêu đề bài viết</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tên file ảnh (banner.jpg)</label>
                <input type="text" class="form-control" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Đoạn trích (Mô tả ngắn)</label>
                <textarea class="form-control" name="excerpt" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nội dung bài viết</label>
                <textarea class="form-control" name="content" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Lưu Bài Viết</button>
        </form>
    </div>
</div>
