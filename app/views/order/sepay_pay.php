<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>order/history" class="text-decoration-none">Lịch sử đơn hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán SePay #ORD<?php echo $data['orderId'] ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <!-- Cột Trái: Mã QR VietQR SePay -->
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100 bg-white">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                            <span class="badge bg-primary px-3 py-2 rounded-pill fs-6"><i class="bi bi-qr-code me-1"></i> VietQR SePay</span>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fs-6 border border-success-subtle">Tự động 24/7</span>
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">Quét Mã QR Thanh Toán</h4>
                        <p class="text-muted small mb-3">Mở ứng dụng Ngân hàng hoặc Ví điện tử để quét mã</p>
                    </div>

                    <!-- Khung ảnh QR Code SePay -->
                    <div class="p-3 bg-light rounded-4 border d-inline-block mx-auto position-relative shadow-sm my-2" style="max-width: 330px;">
                        <img id="sepayQrImage" src="<?php echo htmlspecialchars($data['qrUrl']) ?>" alt="Mã VietQR SePay" class="img-fluid rounded-3" style="width: 290px; height: 290px; object-fit: contain;">
                        
                        <!-- Overlay khi thanh toán thành công -->
                        <div id="paymentSuccessOverlay" class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-95 rounded-4 d-flex flex-column align-items-center justify-content-center d-none" style="z-index: 10;">
                            <div class="text-success mb-3">
                                <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-1">Thanh toán thành công!</h5>
                            <p class="text-muted small mb-0">Đang chuyển tiếp về đơn hàng...</p>
                        </div>
                    </div>

                    <!-- Trạng thái chờ thanh toán & Đồng hồ đếm ngược -->
                    <div class="mt-3">
                        <div id="paymentStatusBox" class="alert alert-warning py-2 px-3 rounded-pill d-inline-flex align-items-center gap-2 shadow-sm mb-2">
                            <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                            <span class="small fw-semibold" id="statusText">Đang chờ nhận chuyển khoản...</span>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-clock me-1"></i>Hết hạn sau: <span id="countdownTimer" class="fw-bold text-danger">15:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Thông tin Chuyển khoản chi tiết -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 bg-white p-4 h-100">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Đơn hàng</span>
                        <h4 class="fw-bold text-dark mb-0">#ORD<?php echo $data['orderId'] ?></h4>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small text-uppercase fw-semibold">Số tiền thanh toán</span>
                        <h3 class="fw-bold text-danger mb-0"><?php echo number_format($data['amount'], 0, ',', '.') ?> đ</h3>
                    </div>
                </div>

                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-bank me-2"></i>Thông tin tài khoản nhận tiền</h6>

                <!-- Danh sách thông tin chuyển khoản kèm nút sao chép -->
                <div class="list-group list-group-flush mb-4">
                    <!-- Ngân hàng -->
                    <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center border-light">
                        <span class="text-muted">Ngân hàng</span>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark fs-6"><?php echo htmlspecialchars($data['bank']) ?></strong>
                            <button type="button" class="btn btn-sm btn-light border btn-copy" data-copy="<?php echo htmlspecialchars($data['bank']) ?>" title="Sao chép">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Số tài khoản -->
                    <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center border-light">
                        <span class="text-muted">Số tài khoản</span>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-primary fs-5 font-monospace"><?php echo htmlspecialchars($data['accNo']) ?></strong>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-copy" data-copy="<?php echo htmlspecialchars($data['accNo']) ?>" title="Sao chép số tài khoản">
                                <i class="bi bi-clipboard"></i> Chép
                            </button>
                        </div>
                    </div>

                    <!-- Chủ tài khoản -->
                    <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center border-light">
                        <span class="text-muted">Chủ tài khoản</span>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark text-uppercase"><?php echo htmlspecialchars($data['accName']) ?></strong>
                            <button type="button" class="btn btn-sm btn-light border btn-copy" data-copy="<?php echo htmlspecialchars($data['accName']) ?>" title="Sao chép tên chủ tài khoản">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Số tiền chính xác -->
                    <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center border-light">
                        <span class="text-muted">Số tiền chuyển</span>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-danger fs-5 font-monospace"><?php echo number_format($data['amount'], 0, ',', '.') ?> VND</strong>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-copy" data-copy="<?php echo $data['amount'] ?>" title="Sao chép số tiền">
                                <i class="bi bi-clipboard"></i> Chép
                            </button>
                        </div>
                    </div>

                    <!-- Nội dung chuyển khoản -->
                    <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center bg-light-subtle rounded-3 mt-2 border">
                        <div class="ps-2">
                            <span class="text-muted d-block small">Nội dung chuyển khoản (bắt buộc):</span>
                            <span class="fs-5 fw-bold text-success font-monospace" id="transferContentText"><?php echo htmlspecialchars($data['transferContent']) ?></span>
                        </div>
                        <div class="pe-2">
                            <button type="button" class="btn btn-success btn-sm btn-copy px-3 shadow-sm" data-copy="<?php echo htmlspecialchars($data['transferContent']) ?>">
                                <i class="bi bi-clipboard-check me-1"></i> Sao chép nội dung
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cảnh báo quan trọng -->
                <div class="alert alert-info py-2 px-3 small rounded-3 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-info fs-5 flex-shrink-0"></i>
                    <div>
                        Vui lòng giữ nguyên <strong>Nội dung chuyển khoản</strong> để SePay tự động xác thực đơn hàng cho bạn ngay sau khi nhận tiền.
                    </div>
                </div>

                <!-- Nút thao tác -->
                <div class="d-flex gap-2">
                    <button type="button" id="btnManualCheck" class="btn btn-primary flex-grow-1 shadow-sm py-2">
                        <i class="bi bi-arrow-repeat me-1" id="manualCheckIcon"></i> Kiểm tra thanh toán ngay
                    </button>
                    <a href="<?php echo BASE_URL ?>order/history" class="btn btn-outline-secondary py-2">
                        Lịch sử đơn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast thông báo sao chép -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
    <div id="copyToast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <i class="bi bi-check-circle me-1 text-success"></i> Đã sao chép vào bộ nhớ tạm!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
(function() {
    var orderId = <?php echo (int)$data['orderId'] ?>;
    var checkUrl = "<?php echo BASE_URL ?>sepay/check_status/" + orderId;
    var successUrl = "<?php echo BASE_URL ?>order/success/" + orderId;
    var isChecking = false;
    var pollInterval = null;
    var remainingSeconds = 15 * 60; // 15 phút

    // Xử lý sao chép clipboard
    var copyButtons = document.querySelectorAll('.btn-copy');
    var toastElement = document.getElementById('copyToast');
    var toast = toastElement && window.bootstrap ? new bootstrap.Toast(toastElement, { delay: 2000 }) : null;

    for (var i = 0; i < copyButtons.length; i++) {
        copyButtons[i].addEventListener('click', function() {
            var textToCopy = this.getAttribute('data-copy');
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(textToCopy).then(showToast);
            } else {
                // Fallback cho trình duyệt cũ
                var tempInput = document.createElement('input');
                tempInput.value = textToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                showToast();
            }
        });
    }

    function showToast() {
        if (toast) {
            toast.show();
        } else {
            alert('Đã sao chép: ' + textToCopy);
        }
    }

    // Đếm ngược 15 phút
    var timerEl = document.getElementById('countdownTimer');
    var timerInterval = setInterval(function() {
        remainingSeconds--;
        if (remainingSeconds <= 0) {
            clearInterval(timerInterval);
            if (timerEl) timerEl.textContent = "00:00 (Hết hạn)";
            return;
        }
        var m = Math.floor(remainingSeconds / 60);
        var s = remainingSeconds % 60;
        if (timerEl) {
            timerEl.textContent = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        }
    }, 1000);

    // Hàm gọi API kiểm tra trạng thái
    function checkPaymentStatus(isManual) {
        if (isChecking) return;
        isChecking = true;

        var manualIcon = document.getElementById('manualCheckIcon');
        if (isManual && manualIcon) {
            manualIcon.classList.add('spin-animation');
        }

        var xhr = new XMLHttpRequest();
        xhr.open('GET', checkUrl + '?t=' + new Date().getTime(), true);
        xhr.onload = function() {
            isChecking = false;
            if (isManual && manualIcon) {
                manualIcon.classList.remove('spin-animation');
            }

            if (xhr.status === 200) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res && res.paid === true) {
                        // Thành công!
                        clearInterval(pollInterval);
                        clearInterval(timerInterval);
                        onPaymentSuccess();
                    } else if (isManual) {
                        var statusBox = document.getElementById('statusText');
                        if (statusBox) {
                            statusBox.textContent = 'Chưa nhận được giao dịch. Vui lòng thử lại sau vài giây...';
                        }
                    }
                } catch(e) {}
            }
        };
        xhr.onerror = function() {
            isChecking = false;
            if (isManual && manualIcon) {
                manualIcon.classList.remove('spin-animation');
            }
        };
        xhr.send();
    }

    // Xử lý khi thanh toán thành công
    function onPaymentSuccess() {
        var overlay = document.getElementById('paymentSuccessOverlay');
        if (overlay) {
            overlay.classList.remove('d-none');
        }
        var statusBox = document.getElementById('paymentStatusBox');
        if (statusBox) {
            statusBox.className = 'alert alert-success py-2 px-3 rounded-pill d-inline-flex align-items-center gap-2 shadow-sm mb-2';
            statusBox.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i><span class="small fw-bold">Đã nhận được thanh toán!</span>';
        }

        // Tự động chuyển hướng về trang hoàn tất đơn sau 1.5 giây
        setTimeout(function() {
            window.location.href = successUrl;
        }, 1500);
    }

    // Polling tự động mỗi 3 giây
    pollInterval = setInterval(function() {
        checkPaymentStatus(false);
    }, 3000);

    // Nút bấm kiểm tra thủ công
    var btnManual = document.getElementById('btnManualCheck');
    if (btnManual) {
        btnManual.addEventListener('click', function() {
            checkPaymentStatus(true);
        });
    }
})();
</script>

<style>
.spin-animation {
    display: inline-block;
    animation: spin 1s infinite linear;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
