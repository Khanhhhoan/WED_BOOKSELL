<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-users text-primary me-2"></i>Quản Lý Người Dùng</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th class="text-center">Quyền hạn</th>
                            <th class="text-center">Ngày đăng ký</th>
                            <th class="text-center pe-4" style="width: 100px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['users'])) : ?>
                            <tr><td colspan="7" class="text-center py-4">Chưa có người dùng nào.</td></tr>
                        <?php else : ?>
                            <?php foreach ($data['users'] as $u) : ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?php echo  $u['id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <?php echo  strtoupper(substr($u['full_name'], 0, 1)) ?>
                                            </div>
                                            <span class="fw-bold"><?php echo  htmlspecialchars($u['full_name']) ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo  htmlspecialchars($u['email']) ?></td>
                                    <td><?php echo  htmlspecialchars($u['phone']) ?></td>
                                    <td class="text-center">
                                        <?php if ($u['role'] == 'admin') : ?>
                                            <span class="badge bg-danger"><i class="fas fa-user-shield me-1"></i>Admin</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary"><i class="fas fa-user me-1"></i>User</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><small class="text-muted"><?php echo  date('d/m/Y H:i', strtotime($u['created_at'])) ?></small></td>
                                    <td class="text-center pe-4">
                                        <?php if ($u['role'] != 'admin') : ?>
                                            <form action="<?php echo  BASE_URL ?>admin/user_delete/<?php echo  $u['id'] ?>" method="POST" class="d-inline-block">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa khách hàng" onclick="return confirm('Xóa khách hàng này sẽ xóa toàn bộ đơn hàng của họ?');"><i class="fas fa-user-times"></i></button>
                                            </form>
                                        <?php else : ?>
                                            <button class="btn btn-sm btn-light disabled" title="Không thể xóa Quản trị viên"><i class="fas fa-ban text-muted"></i></button>
                                        <?php endif; ?>
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
