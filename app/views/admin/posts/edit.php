<?php $post = $data['post']; ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold">Sửa Bài Viết Tin Tức</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo BASE_URL; ?>admin/posts" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form action="<?php echo BASE_URL; ?>admin/post_edit/<?php echo $post['id']; ?>" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Tiêu đề bài viết</label>
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tên file ảnh</label>
                <input type="text" class="form-control" name="image" value="<?php echo htmlspecialchars((string)isset($post['image'])?$post['image']:''); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Đoạn trích (Mô tả ngắn)</label>
                <textarea class="form-control" name="excerpt" rows="2"><?php echo htmlspecialchars((string)isset($post['excerpt'])?$post['excerpt']:''); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nội dung bài viết</label>
                <textarea class="form-control" name="content" rows="10" required><?php echo htmlspecialchars((string)isset($post['content'])?$post['content']:''); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Cập Nhật</button>
        </form>
    </div>
</div>
