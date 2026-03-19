<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-newspaper text-primary me-2"></i>Quản Lý Bài Viết</h2>
        <a href="<?php echo BASE_URL; ?>admin/post_add" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Thêm Bài Viết Mới</a>
    </div>

    <div class="card shadow-sm border-0">
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
                                        <img src="<?php echo  $post['image'] ? BASE_URL . 'assets/images/posts/' . $post['image'] : 'https://placehold.co/100x70' ?>" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 300px;" title="<?php echo  htmlspecialchars($post['title']) ?>">
                                            <?php echo  htmlspecialchars($post['title']) ?>
                                        </div>
                                    </td>
                                    <td><small class="text-muted"><i class="far fa-calendar-alt me-1"></i><?php echo  date('d/m/Y', strtotime($post['created_at'])) ?></small></td>
                                    <td class="text-center">
                                        <a href="<?php echo BASE_URL; ?>admin/post_edit/<?php echo $post['id']; ?>" class="btn btn-sm btn-info text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>
                                        
                                        <form action="<?php echo  BASE_URL ?>admin/post_delete/<?php echo  $post['id'] ?>" method="POST" class="d-inline-block">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Xóa bài viết này?');"><i class="fas fa-trash-alt"></i></button>
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
