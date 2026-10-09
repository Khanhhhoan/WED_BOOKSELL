<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Quản Lý Đơn Hàng</h2>
    <div>
        <a href="<?php echo BASE_URL ?>admin/statistics" class="btn btn-primary btn-sm shadow-sm">
            <i class="bi bi-bar-chart-line me-1"></i> Xem Thống Kê & Doanh Thu
        </a>
    </div>
</div>

<div class="card shadow-sm border">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th class="text-end">Tổng tiền</th>
                        <th class="text-center">Thanh toán</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center pe-4" style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['orders'])) : ?>
                        <tr><td colspan="7" class="text-center py-4">Chưa có đơn hàng nào trong hệ thống.</td></tr>
                    <?php else : ?>
                        <?php foreach ($data['orders'] as $order) : ?>
                            <tr>
                                <td class="ps-4 fw-bold">#ORD<?php echo  $order['id'] ?></td>
                                <td>
                                    <strong><?php echo  htmlspecialchars($order['shipping_name']) ?></strong><br>
                                    <small class="text-muted"><?php echo  htmlspecialchars($order['user_name']) ?> (Acc)</small>
                                </td>
                                <td><?php echo  date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td class="text-end fw-semibold text-dark">
                                    <?php echo  number_format($order['total_amount'], 0, ',', '.') ?> đ
                                </td>
                                <td class="text-center">
                                    <?php 
                                    $pMethod = isset($order['payment_method']) ? $order['payment_method'] : 'cod';
                                    $pStatus = isset($order['payment_status']) ? $order['payment_status'] : 'pending';

                                    if ($pMethod === 'sepay' || $pMethod === 'online') {
                                        if ($pStatus === 'success') {
                                            echo '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-qr-code me-1"></i> SePay: Đã TT</span>';
                                        } else {
                                            echo '<span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="bi bi-clock me-1"></i> SePay: Chờ TT</span>';
                                        }
                                    } else {
                                        echo '<span class="badge bg-secondary-subtle text-secondary border">COD (Tiền mặt)</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
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
                                <td class="text-center pe-4">
                                    <a href="<?php echo  BASE_URL ?>admin/order_detail/<?php echo  $order['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Xem & Xử lý">Xử lý</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
