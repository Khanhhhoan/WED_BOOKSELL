<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6 text-center">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-3 text-success"><i class="bi bi-bag-check-fill me-2"></i>Cảm ơn bạn đã đặt hàng!</h2>
                <p class="text-muted fs-5 mb-3">Mã đơn hàng của bạn là: <strong>#ORD<?php echo  htmlspecialchars($data['orderId']) ?></strong></p>
                
                <?php if (isset($data['payment']) && $data['payment']) : ?>
                    <div class="card bg-light border-0 rounded-3 p-3 mb-4 mx-auto" style="max-width: 450px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Hình thức thanh toán:</span>
                            <?php if ($data['payment']['method'] === 'sepay' || $data['payment']['method'] === 'online') : ?>
                                <span class="badge bg-primary"><i class="bi bi-qr-code-scan me-1"></i> Chuyển khoản SePay</span>
                            <?php else : ?>
                                <span class="badge bg-secondary"><i class="bi bi-cash-stack me-1"></i> COD (Tiền mặt)</span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Trạng thái thanh toán:</span>
                            <?php if ($data['payment']['status'] === 'success') : ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> Đã thanh toán thành công</span>
                            <?php else : ?>
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock-history me-1"></i> Chờ thanh toán</span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($data['payment']['transaction_id'])) : ?>
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <span class="text-muted small">Mã giao dịch SePay:</span>
                                <span class="fw-bold font-monospace small text-dark"><?php echo htmlspecialchars($data['payment']['transaction_id']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <p class="mb-4 text-muted">Chúng tôi đã ghi nhận đơn hàng và chuẩn bị đóng gói chuyển đến địa chỉ của bạn. Bạn có thể theo dõi tiến độ xử lý bất kỳ lúc nào.</p>
                
                <div class="d-flex gap-3 justify-content-center">
                    <a href="<?php echo  BASE_URL ?>order/history" class="btn btn-primary px-4 shadow-sm"><i class="bi bi-receipt me-1"></i> Lịch Sử Đơn Hàng</a>
                    <a href="<?php echo  BASE_URL ?>" class="btn btn-outline-secondary px-4 shadow-sm"><i class="bi bi-house me-1"></i> Về Trang Chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>
