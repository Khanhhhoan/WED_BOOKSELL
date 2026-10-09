<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Tổng Quan Hệ Thống</h2>
    <div class="d-flex gap-2">
        <a href="<?php echo  BASE_URL ?>admin/statistics" class="btn btn-primary btn-sm shadow-sm"><i class="bi bi-bar-chart-line me-1"></i> Báo Cáo Thống Kê</a>
        <a href="<?php echo  BASE_URL ?>admin/books" class="btn btn-outline-secondary btn-sm">Thêm Sách</a>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-5">
    <div class="col">
        <div class="admin-stat-card h-100 p-3">
            <div class="admin-stat-label mb-2">Doanh thu (hoàn thành)</div>
            <div class="h4 mb-0 fw-semibold text-dark"><?php echo  number_format($data['stats']['total_revenue'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">VNĐ</span></div>
        </div>
    </div>
    <div class="col">
        <div class="admin-stat-card h-100 p-3">
            <div class="admin-stat-label mb-2">Tổng đơn hàng</div>
            <div class="h4 mb-0 fw-semibold text-dark"><?php echo  (int)$data['stats']['total_orders'] ?></div>
        </div>
    </div>
    <div class="col">
        <div class="admin-stat-card h-100 p-3">
            <div class="admin-stat-label mb-2">Sách đang bán</div>
            <div class="h4 mb-0 fw-semibold text-dark"><?php echo  (int)$data['stats']['total_books'] ?></div>
        </div>
    </div>
    <div class="col">
        <div class="admin-stat-card h-100 p-3">
            <div class="admin-stat-label mb-2">Khách hàng</div>
            <div class="h4 mb-0 fw-semibold text-dark"><?php echo  (int)$data['stats']['total_users'] ?></div>
        </div>
    </div>
</div>

<div class="card border rounded-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
        <h6 class="m-0 fw-semibold text-dark">Đơn hàng gần đây</h6>
        <a href="<?php echo  BASE_URL ?>admin/orders" class="btn btn-sm btn-outline-secondary">Xem tất cả</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['recentOrders'])): ?>
                        <tr><td colspan="5" class="text-center py-3 text-muted">Chưa có đơn hàng nào</td></tr>
                    <?php else: ?>
                        <?php foreach($data['recentOrders'] as $order): ?>
                            <tr>
                                <td class="fw-semibold">#ORD<?php echo  $order['id'] ?></td>
                                <td><?php echo  htmlspecialchars($order['user_name']) ?></td>
                                <td class="text-muted"><?php echo  date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td class="text-end fw-semibold text-dark"><?php echo  number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                <td>
                                    <?php
                                    switch($order['status']) {
                                        case 'pending': echo '<span class="badge rounded-pill admin-badge-pill">Chờ xác nhận</span>'; break;
                                        case 'confirmed': echo '<span class="badge rounded-pill admin-badge-pill">Đã xác nhận</span>'; break;
                                        case 'shipping': echo '<span class="badge rounded-pill admin-badge-pill">Đang giao</span>'; break;
                                        case 'completed': echo '<span class="badge rounded-pill admin-badge-pill">Hoàn thành</span>'; break;
                                        case 'cancelled': echo '<span class="badge rounded-pill admin-badge-pill text-danger">Đã hủy</span>'; break;
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
