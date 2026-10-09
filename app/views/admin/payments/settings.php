<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-gear-fill me-2 text-primary"></i>Cấu Hình Cổng Thanh Toán SePay</h2>
            <p class="text-muted small mb-0">Thiết lập tài khoản ngân hàng nhận tiền và tích hợp Webhook tự động với SePay</p>
        </div>
        <a href="<?php echo BASE_URL ?>admin/payments" class="btn btn-outline-secondary">
            Xem Lịch Sử Thanh Toán
        </a>
    </div>

    <div class="row">
        <!-- Cột Trái: Form cài đặt tài khoản ngân hàng & SePay -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-bank me-2"></i>Thông Tin Tài Khoản Nhận Chuyển Khoản</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo BASE_URL ?>admin/sepay_settings" method="POST">
                        
                        <!-- Ngân hàng -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ngân Hàng (Gateway / Bank):</label>
                            <select name="sepay_bank" class="form-select" required>
                                <?php
                                $currentBank = isset($data['settings']['sepay_bank']) ? $data['settings']['sepay_bank'] : 'MBBank';
                                $banks = array(
                                    'MBBank' => 'MBBank (Ngân hàng Quân Đội)',
                                    'Vietcombank' => 'Vietcombank (Ngoại thương Việt Nam)',
                                    'Techcombank' => 'Techcombank (Kỹ thương Việt Nam)',
                                    'ACB' => 'ACB (Á Châu)',
                                    'TPBank' => 'TPBank (Tiên Phong)',
                                    'VPBank' => 'VPBank (Việt Nam Thịnh Vượng)',
                                    'BIDV' => 'BIDV (Đầu tư và Phát triển)',
                                    'VietinBank' => 'VietinBank (Công thương)',
                                    'Agribank' => 'Agribank (Nông nghiệp)',
                                    'Sacombank' => 'Sacombank (Sài Gòn Thương Tín)',
                                    'HDBank' => 'HDBank (Phát triển TP.HCM)',
                                    'VIB' => 'VIB (Quốc tế)',
                                    'OCB' => 'OCB (Phương Đông)',
                                    'MSB' => 'MSB (Hàng Hải)'
                                );
                                foreach ($banks as $code => $name) {
                                    $selected = ($currentBank === $code) ? 'selected' : '';
                                    echo '<option value="' . $code . '" ' . $selected . '>' . $name . ' (' . $code . ')</option>';
                                }
                                ?>
                            </select>
                            <div class="form-text small">Chọn ngân hàng bạn đã liên kết với tài khoản SePay của bạn.</div>
                        </div>

                        <!-- Số tài khoản -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số Tài Khoản Ngân Hàng:</label>
                            <input type="text" name="sepay_account_no" class="form-control font-monospace fs-6" 
                                   value="<?php echo htmlspecialchars(isset($data['settings']['sepay_account_no']) ? $data['settings']['sepay_account_no'] : '') ?>" 
                                   placeholder="Ví dụ: 0345678999" required>
                            <div class="form-text small">Số tài khoản thực tế nhận tiền của bạn.</div>
                        </div>

                        <!-- Tên chủ tài khoản -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Chủ Tài Khoản (Không dấu):</label>
                            <input type="text" name="sepay_account_name" class="form-control text-uppercase font-monospace" 
                                   value="<?php echo htmlspecialchars(isset($data['settings']['sepay_account_name']) ? $data['settings']['sepay_account_name'] : '') ?>" 
                                   placeholder="Ví dụ: NGUYEN VAN A" required>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check me-2 text-success"></i>Cấu Hình Tích Hợp Webhook & API SePay</h6>

                        <!-- SePay API Key -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">SePay API Key / Webhook Token:</label>
                            <input type="text" name="sepay_api_key" class="form-control font-monospace" 
                                   value="<?php echo htmlspecialchars(isset($data['settings']['sepay_api_key']) ? $data['settings']['sepay_api_key'] : '') ?>" 
                                   placeholder="Để trống nếu không dùng xác thực hoặc điền token từ my.sepay.vn">
                            <div class="form-text small">Mã API bí mật để xác thực khi SePay gửi Webhook sang website (Tùy chọn nhưng khuyến nghị để bảo mật).</div>
                        </div>

                        <div class="row">
                            <!-- Tiền tố nội dung -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tiền tố đơn hàng (Prefix):</label>
                                <input type="text" name="sepay_prefix" class="form-control font-monospace text-uppercase" 
                                       value="<?php echo htmlspecialchars(isset($data['settings']['sepay_prefix']) ? $data['settings']['sepay_prefix'] : 'DH') ?>" 
                                       placeholder="DH" required>
                                <div class="form-text small">Ví dụ: <code>DH</code> thì nội dung chuyển khoản đơn #15 sẽ là <code>DH15</code>.</div>
                            </div>

                            <!-- Template VietQR -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giao diện VietQR:</label>
                                <select name="sepay_qr_template" class="form-select">
                                    <?php
                                    $curTpl = isset($data['settings']['sepay_qr_template']) ? $data['settings']['sepay_qr_template'] : 'compact';
                                    ?>
                                    <option value="compact" <?php echo ($curTpl === 'compact') ? 'selected' : '' ?>>Compact (Gọn gàng - Khuyên dùng)</option>
                                    <option value="qr_only" <?php echo ($curTpl === 'qr_only') ? 'selected' : '' ?>>QR Only (Chỉ hình QR)</option>
                                    <option value="template3" <?php echo ($curTpl === 'template3') ? 'selected' : '' ?>>Template 3</option>
                                </select>
                            </div>
                        </div>

                        <!-- Trạng thái kích hoạt -->
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="sepay_is_active" id="sepayIsActive" value="1" 
                                   <?php echo (!isset($data['settings']['sepay_is_active']) || $data['settings']['sepay_is_active'] === '1') ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="sepayIsActive">Kích hoạt phương thức thanh toán SePay trên Website</label>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-save me-1"></i> Lưu Cấu Hình SePay
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cột Phải: Hướng dẫn cài đặt Webhook trên my.sepay.vn -->
        <div class="col-lg-5">
            <!-- Box URL Webhook -->
            <div class="card shadow-sm border mb-4 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2 text-dark"><i class="bi bi-link-45deg me-2 text-primary"></i>Webhook Endpoint URL</h5>
                    <p class="text-muted small mb-2">Copy link này dán vào mục Webhook trên tài khoản SePay của bạn:</p>
                    
                    <div class="input-group mb-2">
                        <input type="text" id="webhookUrlInput" class="form-control font-monospace small bg-white" 
                               value="<?php echo htmlspecialchars($data['webhookUrl']) ?>" readonly>
                        <button class="btn btn-outline-primary" type="button" id="btnCopyWebhook" title="Sao chép">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <small class="text-muted d-block"><i class="bi bi-info-circle me-1"></i>URL này sẽ tự động nhận thông báo từ SePay khi có biến động tiền vào.</small>
                </div>
            </div>

            <!-- Hướng dẫn từng bước -->
            <div class="card shadow-sm border">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-card-checklist me-2 text-success"></i>Các Bước Kết Nối Với SePay (Thật)</h6>
                </div>
                <div class="card-body p-4">
                    <ol class="ps-3 mb-0 small text-secondary lh-lg">
                        <li class="mb-2">
                            Đăng ký tài khoản miễn phí tại <a href="https://my.sepay.vn" target="_blank" class="fw-bold text-decoration-none">my.sepay.vn <i class="bi bi-box-arrow-up-right"></i></a>.
                        </li>
                        <li class="mb-2">
                            Vào mục <strong>Ngân Hàng</strong> &rarr; Bấm <strong>Thêm Tài Khoản</strong> &rarr; Đăng nhập ngân hàng để SePay đọc biến động số dư.
                        </li>
                        <li class="mb-2">
                            Vào mục <strong>Webhook</strong> &rarr; Bấm <strong>Thêm Webhook</strong>:
                            <ul>
                                <li><strong>Endpoint URL:</strong> Dán URL Webhook ở trên.</li>
                                <li><strong>Kiểu dữ liệu:</strong> JSON (POST).</li>
                                <li><strong>Sự kiện:</strong> Giao dịch tiền vào (Money In).</li>
                                <li><strong>API Key:</strong> Nhập cùng mã với ô "SePay API Key" ở form bên trái (nếu có).</li>
                            </ul>
                        </li>
                        <li class="mb-2">
                            Bấm <strong>Lưu</strong> và kiểm tra gửi test từ SePay.
                        </li>
                        <li>
                            Khách hàng thanh toán &rarr; Tiền vào tài khoản thật của bạn &rarr; SePay bắn Webhook &rarr; Hệ thống website tự động duyệt đơn và ghi log trong tích tắc!
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnCopy = document.getElementById('btnCopyWebhook');
    var input = document.getElementById('webhookUrlInput');
    if (btnCopy && input) {
        btnCopy.addEventListener('click', function() {
            input.select();
            document.execCommand('copy');
            alert('Đã sao chép Webhook URL: ' + input.value);
        });
    }
});
</script>
