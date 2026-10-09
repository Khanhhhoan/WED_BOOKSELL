<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Quản Lý Bài Viết</h2>
        <a href="<?php echo BASE_URL; ?>admin/post_add" class="btn btn-outline-secondary btn-sm">Thêm Bài Viết Mới</a>
    </div>

    <div class="card shadow-sm border">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">ID</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề bài viết</th>
                            <th>Ngày đăng</th>
                            <th class="text-center" style="width: 150px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['posts'])) : ?>
                            <tr><td colspan="5" class="text-center py-4">Chưa có bài viết nào.</td></tr>
                        <?php else : ?>
                            <?php foreach ($data['posts'] as $post) : ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?php echo  $post['id'] ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars(post_image_url(isset($post['image']) ? $post['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 300px;" title="<?php echo  htmlspecialchars($post['title']) ?>">
                                            <?php echo  htmlspecialchars($post['title']) ?>
                                        </div>
                                    </td>
                                    <td><small class="text-muted"><?php echo  date('d/m/Y', strtotime($post['created_at'])) ?></small></td>
                                    <td class="text-center">
                                        <a href="<?php echo BASE_URL; ?>admin/post_edit/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Sửa">Sửa</a>
                                        
                                        <form action="<?php echo  BASE_URL ?>admin/post_delete/<?php echo  $post['id'] ?>" method="POST" class="d-inline-block">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Xóa bài viết này?');">Xóa</button>
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
