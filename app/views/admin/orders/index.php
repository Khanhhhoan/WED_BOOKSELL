<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="fas fa-shopping-cart text-primary me-2"></i>Quản Lý Đơn Hàng</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th class="text-end">Tổng tiền</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center pe-4" style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['orders'])) : ?>
                        <tr><td colspan="6" class="text-center py-4">Chưa có đơn hàng nào trong hệ thống.</td></tr>
                    <?php else : ?>
                        <?php foreach ($data['orders'] as $order) : ?>
                            <tr>
                                <td class="ps-4 fw-bold">#ORD<?php echo  $order['id'] ?></td>
                                <td>
                                    <strong><?php echo  htmlspecialchars($order['shipping_name']) ?></strong><br>
                                    <small class="text-muted"><?php echo  htmlspecialchars($order['user_name']) ?> (Acc)</small>
                                </td>
                                <td><?php echo  date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td class="text-end fw-bold text-danger">
                                    <?php echo  number_format($order['total_amount'], 0, ',', '.') ?> đ
                                </td>
                                <td class="text-center">
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
                                <td class="text-center pe-4">
                                    <a href="<?php echo  BASE_URL ?>admin/order_detail/<?php echo  $order['id'] ?>" class="btn btn-sm btn-primary shadow-sm" title="Xem & Xử lý"><i class="fas fa-edit me-1"></i>Xử lý</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
