<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử đơn hàng</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Lịch Sử Đơn Hàng</h2>
    </div>

    <?php if (empty($data['orders'])) : ?>
        <div class="alert alert-info text-center shadow-sm p-5">
            <i class="fas fa-clipboard-list fa-3x mb-3 text-secondary"></i>
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
                            <th class="text-center">Trạng thái</th>
                            <th class="pe-4 text-center">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['orders'] as $order) : ?>
                            <tr>
                                <td class="ps-4 fw-bold">#ORD<?php echo  $order['id'] ?></td>
                                <td><?php echo  date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <strong><?php echo  htmlspecialchars($order['shipping_name']) ?></strong><br>
                                    <small class="text-muted"><i class="fas fa-phone-alt me-1"></i><?php echo  htmlspecialchars($order['shipping_phone']) ?></small>
                                </td>
                                <td class="text-end fw-bold text-danger">
                                    <?php echo  number_format($order['total_amount'], 0, ',', '.') ?> đ
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
                                    <button class="btn btn-sm btn-outline-primary" onclick="alert('Chức năng xem chi tiết đơn hàng đang được cập nhật...');"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
