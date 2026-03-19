<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="fas fa-tachometer-alt text-primary me-2"></i>Tổng Quan Hệ Thống</h2>
    <div>
        <a href="<?php echo  BASE_URL ?>admin/books" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus me-1"></i>Thêm Sách</a>
    </div>
</div>

<!-- Dashboard Stats Cards -->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-5">
    <!-- Doanh thu -->
    <div class="col">
        <div class="card shadow-sm border-0 border-start border-success border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Doanh thu (Hoàn Thành)</div>
                        <div class="h3 mb-0 fw-bold text-dark"><?php echo  number_format($data['stats']['total_revenue'], 0, ',', '.') ?> VNĐ</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng -->
    <div class="col">
        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Tổng Số Đơn Hàng</div>
                        <div class="h3 mb-0 fw-bold text-dark"><?php echo  $data['stats']['total_orders'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đầu sách -->
    <div class="col">
        <div class="card shadow-sm border-0 border-start border-info border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Sách Đang Bán</div>
                        <div class="h3 mb-0 fw-bold text-dark"><?php echo  $data['stats']['total_books'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Người dùng -->
    <div class="col">
        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Khách Hàng</div>
                        <div class="h3 mb-0 fw-bold text-dark"><?php echo  $data['stats']['total_users'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-muted opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lệnh mới nhất -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Đơn Hàng Gần Đây</h6>
        <a href="<?php echo  BASE_URL ?>admin/orders" class="btn btn-sm btn-outline-secondary">Xem tất cả</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['recentOrders'])): ?>
                        <tr><td colspan="5" class="text-center py-3">Chưa có đơn hàng nào</td></tr>
                    <?php else: ?>
                        <?php foreach($data['recentOrders'] as $order): ?>
                            <tr>
                                <td class="fw-bold">#ORD<?php echo  $order['id'] ?></td>
                                <td><?php echo  htmlspecialchars($order['user_name']) ?></td>
                                <td><?php echo  date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td class="text-danger fw-bold"><?php echo  number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                <td>
                                    <?php
                                    switch($order['status']) {
                                        case 'pending': echo '<span class="badge bg-warning text-dark">Chờ xác nhận</span>'; break;
                                        case 'confirmed': echo '<span class="badge bg-info text-dark">Đã xác nhận</span>'; break;
                                        case 'shipping': echo '<span class="badge bg-primary">Đang giao</span>'; break;
                                        case 'completed': echo '<span class="badge bg-success">Hoàn thành</span>'; break;
                                        case 'cancelled': echo '<span class="badge bg-danger">Đã hủy</span>'; break;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
