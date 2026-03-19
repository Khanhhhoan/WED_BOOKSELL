<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6 text-center">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold mb-3 text-success">Cảm ơn bạn đã đặt hàng!</h2>
                <p class="text-muted fs-5 mb-4">Mã đơn hàng của bạn là: <strong>#ORD<?php echo  htmlspecialchars($data['orderId']) ?></strong></p>
                <p class="mb-4">Chúng tôi đã nhận được thông tin đơn hàng và sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận. Bạn có thể theo dõi trạng thái đơn hàng trong phần Lịch sử đơn hàng.</p>
                
                <div class="d-flex gap-3 justify-content-center">
                    <a href="<?php echo  BASE_URL ?>order/history" class="btn btn-primary px-4 shadow-sm">Xem Lịch Sử Lập Đơn</a>
                    <a href="<?php echo  BASE_URL ?>home" class="btn btn-outline-secondary px-4 shadow-sm">Về Trang Chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>
