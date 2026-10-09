<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử đơn hàng</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Lịch Sử Đơn Hàng</h2>
    </div>

    <?php if (empty($data['orders'])) : ?>
        <div class="alert alert-info text-center shadow-sm p-5">
            <h4>Bạn chưa có đơn hàng nào</h4>
            <p>Hãy bắt đầu mua sắm ngay hôm nay để nhận những cuốn sách hay nhất!</p>
            <a href="<?php echo  BASE_URL ?>book" class="btn btn-primary mt-3">Tiếp Tục Mua Sắm</a>
        </div>
    <?php else : ?>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Mã ĐH</th>
                            <th>Ngày đặt</th>
                            <th>Thông tin nhận hàng</th>
                            <th class="text-end">Tổng tiền</th>
                            <th class="text-center">Thanh toán</th>
                            <th class="text-center">Trạng thái đơn</th>
                            <th class="pe-4 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['orders'] as $order) : ?>
                            <tr>
                                <td class="ps-4 fw-bold">#ORD<?php echo  $order['id'] ?></td>
                                <td><?php echo  date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <strong><?php echo  htmlspecialchars($order['shipping_name']) ?></strong><br>
                                    <small class="text-muted"><?php echo  htmlspecialchars($order['shipping_phone']) ?></small>
                                </td>
                                <td class="text-end fw-bold text-danger">
                                    <?php echo  number_format($order['total_amount'], 0, ',', '.') ?> đ
                                </td>
                                <td class="text-center">
                                    <?php 
                                    $pMethod = isset($order['payment_method']) ? $order['payment_method'] : 'cod';
                                    $pStatus = isset($order['payment_status']) ? $order['payment_status'] : 'pending';

                                    if ($pMethod === 'sepay' || $pMethod === 'online') {
                                        if ($pStatus === 'success') {
                                            echo '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i> Đã thanh toán</span>';
                                        } else {
                                            echo '<span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="bi bi-clock me-1"></i> Chờ chuyển khoản</span>';
                                        }
                                    } else {
                                        echo '<span class="badge bg-secondary-subtle text-secondary border"><i class="bi bi-cash me-1"></i> COD (Tiền mặt)</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $status = $order['status'];
                                    $badgeClass = 'bg-secondary';
                                    $statusText = 'Chờ xác nhận';
                                    
                                    switch($status) {
                                        case 'pending': $badgeClass = 'bg-warning text-dark'; $statusText = 'Chờ xác nhận'; break;
                                        case 'confirmed': $badgeClass = 'bg-info text-dark'; $statusText = 'Đã xác nhận'; break;
                                        case 'shipping': $badgeClass = 'bg-primary'; $statusText = 'Đang giao'; break;
                                        case 'completed': $badgeClass = 'bg-success'; $statusText = 'Hoàn thành'; break;
                                        case 'cancelled': $badgeClass = 'bg-danger'; $statusText = 'Đã hủy'; break;
                                    }
                                    ?>
                                    <span class="badge <?php echo  $badgeClass ?>"><?php echo  $statusText ?></span>
                                </td>
                                <td class="pe-4 text-center">
                                    <?php if (($pMethod === 'sepay' || $pMethod === 'online') && $pStatus !== 'success' && $order['status'] !== 'cancelled') : ?>
                                        <a href="<?php echo BASE_URL ?>sepay/pay/<?php echo $order['id'] ?>" class="btn btn-sm btn-danger shadow-sm">
                                            <i class="bi bi-qr-code-scan me-1"></i> Trả ngay
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="alert('Đơn hàng #ORD<?php echo $order['id'] ?>: <?php echo htmlspecialchars($order['shipping_name']) ?> - <?php echo number_format($order['total_amount'], 0, ',', '.') ?> đ');">Xem</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
