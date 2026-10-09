<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Chi Tiết Giao Dịch #<?php echo $data['log']['id'] ?></h2>
            <p class="text-muted small mb-0">Thời gian ghi nhận: <?php echo date('d/m/Y H:i:s', strtotime($data['log']['created_at'])) ?></p>
        </div>
        <a href="<?php echo BASE_URL ?>admin/payments" class="btn btn-outline-secondary">
            Trở về danh sách
        </a>
    </div>

    <div class="row">
        <!-- Cột Trái: Thông tin giao dịch -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-primary">Thông Tin Biến Động Số Dư (SePay)</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 200px;" class="bg-light">Trạng thái xử lý:</th>
                                <td>
                                    <?php
                                    switch($data['log']['status']) {
                                        case 'success':
                                            echo '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">Thành công</span>';
                                            break;
                                        case 'unmatched':
                                            echo '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fs-6">Không khớp đơn hàng</span>';
                                            break;
                                        case 'amount_mismatch':
                                            echo '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6">Sai lệch số tiền</span>';
                                            break;
                                        case 'duplicate':
                                            echo '<span class="badge bg-secondary-subtle text-secondary border px-3 py-2 fs-6">Trùng lặp</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-light text-dark border px-3 py-2 fs-6">' . htmlspecialchars($data['log']['status']) . '</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Số tiền nhận được:</th>
                                <td class="fs-4 fw-bold text-success font-monospace">
                                    +<?php echo number_format($data['log']['transfer_amount'], 0, ',', '.') ?> VND
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Cổng / Ngân hàng:</th>
                                <td><strong><?php echo htmlspecialchars($data['log']['gateway']) ?></strong></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Số tài khoản nhận:</th>
                                <td class="font-monospace fw-semibold"><?php echo htmlspecialchars($data['log']['account_number']) ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nội dung chuyển khoản:</th>
                                <td>
                                    <span class="bg-light p-2 rounded border font-monospace d-inline-block"><?php echo htmlspecialchars($data['log']['content']) ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Mã tham chiếu ngân hàng:</th>
                                <td class="font-monospace text-muted"><?php echo htmlspecialchars($data['log']['reference_code']) ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Thời gian giao dịch phía Bank:</th>
                                <td><?php echo htmlspecialchars($data['log']['transaction_date']) ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Mô tả xử lý:</th>
                                <td><?php echo htmlspecialchars($data['log']['description']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Khung Raw JSON Webhook -->
            <div class="card shadow-sm border">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">Dữ Liệu Raw Webhook Payload (JSON)</h6>
                </div>
                <div class="card-body p-0">
                    <pre class="bg-dark text-light p-3 m-0 small font-monospace rounded-bottom" style="max-height: 300px; overflow-y: auto;"><?php 
                    $jsonDecoded = json_decode($data['log']['raw_data'], true);
                    if ($jsonDecoded) {
                        echo htmlspecialchars(json_encode($jsonDecoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    } else {
                        echo htmlspecialchars($data['log']['raw_data']);
                    }
                    ?></pre>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Đơn hàng liên kết -->
        <div class="col-lg-5">
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">Đơn Hàng Liên Kết</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($data['log']['order_id'])) : ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-muted small">Mã đơn hàng:</span>
                                <h4 class="fw-bold text-primary mb-0">#ORD<?php echo $data['log']['order_id'] ?></h4>
                            </div>
                            <a href="<?php echo BASE_URL ?>admin/order_detail/<?php echo $data['log']['order_id'] ?>" class="btn btn-sm btn-outline-primary">
                                Xem đơn hàng
                            </a>
                        </div>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Khách nhận:</span>
                                <strong><?php echo htmlspecialchars($data['log']['shipping_name']) ?></strong>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Số điện thoại:</span>
                                <span><?php echo htmlspecialchars($data['log']['shipping_phone']) ?></span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Tổng tiền đơn hàng:</span>
                                <strong class="text-danger fs-6"><?php echo number_format($data['log']['order_amount'], 0, ',', '.') ?> đ</strong>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Trạng thái đơn:</span>
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($data['log']['order_status']) ?></span>
                            </li>
                        </ul>
                    <?php else : ?>
                        <div class="alert alert-warning mb-3">
                            Giao dịch này chưa được liên kết với đơn hàng nào trong hệ thống.
                        </div>

                        <form action="<?php echo BASE_URL ?>admin/payment_link_order" method="POST">
                            <input type="hidden" name="log_id" value="<?php echo $data['log']['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nhập Mã đơn hàng cần gán:</label>
                                <input type="number" name="order_id" class="form-control" placeholder="Ví dụ: 15" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Gán vào đơn hàng ngay
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
