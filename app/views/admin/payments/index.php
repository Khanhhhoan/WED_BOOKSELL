<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Lịch Sử Thanh Toán</h2>
</div>

<!-- 4 Thẻ Thống Kê Nhanh -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card admin-stat-card shadow-sm h-100 p-3">
            <span class="admin-stat-label">Tổng tiền SePay</span>
            <h4 class="fw-bold text-success mb-0 mt-1">
                <?php echo number_format(isset($data['stats']['total_amount_success']) ? $data['stats']['total_amount_success'] : 0, 0, ',', '.') ?> đ
            </h4>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card admin-stat-card shadow-sm h-100 p-3">
            <span class="admin-stat-label">Giao dịch thành công</span>
            <h4 class="fw-bold text-primary mb-0 mt-1">
                <?php echo (int)(isset($data['stats']['success_count']) ? $data['stats']['success_count'] : 0) ?>
            </h4>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card admin-stat-card shadow-sm h-100 p-3">
            <span class="admin-stat-label">Chờ rà soát (Không khớp)</span>
            <h4 class="fw-bold text-warning mb-0 mt-1">
                <?php echo (int)(isset($data['stats']['unmatched_count']) ? $data['stats']['unmatched_count'] : 0) ?>
            </h4>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card admin-stat-card shadow-sm h-100 p-3">
            <span class="admin-stat-label">Lệch số tiền</span>
            <h4 class="fw-bold text-danger mb-0 mt-1">
                <?php echo (int)(isset($data['stats']['mismatch_count']) ? $data['stats']['mismatch_count'] : 0) ?>
            </h4>
        </div>
    </div>
</div>

<!-- Bộ lọc & Tìm kiếm -->
<div class="card shadow-sm border mb-4">
    <div class="card-body p-3">
        <form action="<?php echo BASE_URL ?>admin/payments" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4 col-lg-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="success" <?php echo ($data['status'] === 'success') ? 'selected' : '' ?>>Thành công (success)</option>
                    <option value="unmatched" <?php echo ($data['status'] === 'unmatched') ? 'selected' : '' ?>>Không khớp đơn (unmatched)</option>
                    <option value="amount_mismatch" <?php echo ($data['status'] === 'amount_mismatch') ? 'selected' : '' ?>>Sai lệch tiền (amount_mismatch)</option>
                    <option value="duplicate" <?php echo ($data['status'] === 'duplicate') ? 'selected' : '' ?>>Trùng lặp (duplicate)</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo mã đơn, STK, nội dung, mã GD..." value="<?php echo htmlspecialchars($data['keyword']) ?>">
                    <button class="btn btn-outline-secondary" type="submit">Tìm</button>
                </div>
            </div>
            <?php if (!empty($data['status']) || !empty($data['keyword'])) : ?>
                <div class="col-auto">
                    <a href="<?php echo BASE_URL ?>admin/payments" class="btn btn-outline-danger btn-sm">Xóa lọc</a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Bảng Danh Sách Lịch Sử Thanh Toán -->
<div class="card shadow-sm border">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#ID</th>
                        <th>Thời gian</th>
                        <th>Cổng / Ngân hàng</th>
                        <th>Mã Đơn Hàng</th>
                        <th class="text-end">Số tiền</th>
                        <th>Nội dung chuyển khoản</th>
                        <th>Mã tham chiếu</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center pe-4" style="width: 140px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['logs'])) : ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                Chưa có giao dịch thanh toán nào phù hợp.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($data['logs'] as $log) : ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?php echo $log['id'] ?></td>
                                <td>
                                    <small class="d-block text-dark fw-semibold"><?php echo date('d/m/Y H:i', strtotime($log['created_at'])) ?></small>
                                    <small class="text-muted"><?php echo htmlspecialchars(isset($log['transaction_date']) ? $log['transaction_date'] : '') ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo htmlspecialchars($log['gateway']) ?>
                                    </span>
                                    <?php if (!empty($log['account_number'])) : ?>
                                        <small class="d-block text-muted font-monospace mt-1"><?php echo htmlspecialchars($log['account_number']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($log['order_id'])) : ?>
                                        <a href="<?php echo BASE_URL ?>admin/order_detail/<?php echo $log['order_id'] ?>" class="fw-bold text-decoration-none">
                                            #ORD<?php echo $log['order_id'] ?>
                                        </a>
                                        <?php if (!empty($log['shipping_name'])) : ?>
                                            <small class="d-block text-muted"><?php echo htmlspecialchars($log['shipping_name']) ?></small>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <span class="badge bg-secondary-subtle text-secondary">Chưa gán</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-bold text-success font-monospace fs-6">
                                    +<?php echo number_format($log['transfer_amount'], 0, ',', '.') ?> đ
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($log['content']) ?>">
                                        <span class="font-monospace small bg-light px-2 py-1 rounded border"><?php echo htmlspecialchars($log['content']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <small class="font-monospace text-muted"><?php echo htmlspecialchars($log['reference_code']) ?></small>
                                </td>
                                <td class="text-center">
                                    <?php
                                    switch($log['status']) {
                                        case 'success':
                                            echo '<span class="badge bg-success-subtle text-success border border-success-subtle">Thành công</span>';
                                            break;
                                        case 'unmatched':
                                            echo '<span class="badge bg-warning-subtle text-warning border border-warning-subtle">Không khớp</span>';
                                            break;
                                        case 'amount_mismatch':
                                            echo '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Sai lệch tiền</span>';
                                            break;
                                        case 'duplicate':
                                            echo '<span class="badge bg-secondary-subtle text-secondary border">Trùng lặp</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-light text-dark border">' . htmlspecialchars($log['status']) . '</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary btn-view-json" 
                                                data-id="<?php echo $log['id'] ?>"
                                                data-raw="<?php echo htmlspecialchars($log['raw_data']) ?>"
                                                data-desc="<?php echo htmlspecialchars($log['description']) ?>"
                                                title="Xem chi tiết Raw Payload">
                                            JSON
                                        </button>
                                        <?php if ($log['status'] === 'unmatched') : ?>
                                            <button type="button" class="btn btn-outline-primary btn-link-order"
                                                    data-id="<?php echo $log['id'] ?>"
                                                    data-amount="<?php echo $log['transfer_amount'] ?>"
                                                    data-content="<?php echo htmlspecialchars($log['content']) ?>"
                                                    title="Gán vào đơn hàng">
                                                Gán đơn
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Phân trang -->
    <?php if ($data['totalPages'] > 1) : ?>
        <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center">
            <span class="text-muted small">Tổng cộng <strong><?php echo $data['totalLogs'] ?></strong> giao dịch (Trang <?php echo $data['currentPage'] ?>/<?php echo $data['totalPages'] ?>)</span>
            <ul class="pagination pagination-sm mb-0">
                <?php for ($p = 1; $p <= $data['totalPages']; $p++) : ?>
                    <li class="page-item <?php echo ($p == $data['currentPage']) ? 'active' : '' ?>">
                        <a class="page-link" href="<?php echo BASE_URL ?>admin/payments?page=<?php echo $p ?>&status=<?php echo urlencode($data['status']) ?>&keyword=<?php echo urlencode($data['keyword']) ?>"><?php echo $p ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<!-- Modal 1: Xem Raw Payload JSON -->
<div class="modal fade" id="jsonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Dữ Liệu Webhook Raw Payload #<span id="jsonLogId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Mô tả hệ thống:</label>
                    <div id="jsonLogDesc" class="alert alert-secondary py-2 small mb-0"></div>
                </div>
                <label class="form-label text-muted small fw-bold">Dữ liệu gốc (JSON từ SePay):</label>
                <pre id="jsonContent" class="bg-dark text-light p-3 rounded-3 small font-monospace" style="max-height: 350px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Gán giao dịch chưa khớp vào Đơn hàng -->
<div class="modal fade" id="linkOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Gán Giao Dịch Vào Đơn Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL ?>admin/payment_link_order" method="POST">
                <input type="hidden" name="log_id" id="linkLogId">
                <div class="modal-body">
                    <p class="text-muted small">Sử dụng trong trường hợp khách hàng chuyển khoản nhưng ghi nhầm cú pháp hoặc sai nội dung. Gán thủ công sẽ đánh dấu đơn hàng thành "Đã xác nhận" & "Đã thanh toán".</p>
                    
                    <div class="mb-3 bg-light p-3 rounded border">
                        <div><strong>Mã Log:</strong> #<span id="linkLogIdText"></span></div>
                        <div><strong>Số tiền:</strong> <span id="linkLogAmount" class="text-success fw-bold"></span> đ</div>
                        <div><strong>Nội dung khách ghi:</strong> <span id="linkLogContent" class="font-monospace small"></span></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhập Mã Đơn Hàng (Chỉ số):</label>
                        <input type="number" name="order_id" class="form-control" placeholder="Ví dụ: 15" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xác Nhận Gán Đơn</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Xem JSON Modal
    var jsonButtons = document.querySelectorAll('.btn-view-json');
    var jsonModal = new bootstrap.Modal(document.getElementById('jsonModal'));
    for (var i = 0; i < jsonButtons.length; i++) {
        jsonButtons[i].addEventListener('click', function() {
            var logId = this.getAttribute('data-id');
            var rawData = this.getAttribute('data-raw');
            var desc = this.getAttribute('data-desc');

            document.getElementById('jsonLogId').textContent = logId;
            document.getElementById('jsonLogDesc').textContent = desc || 'Không có mô tả chi tiết';

            try {
                var parsed = JSON.parse(rawData);
                document.getElementById('jsonContent').textContent = JSON.stringify(parsed, null, 2);
            } catch(e) {
                document.getElementById('jsonContent').textContent = rawData || '(Trống)';
            }

            jsonModal.show();
        });
    }

    // 2. Gán đơn Modal
    var linkButtons = document.querySelectorAll('.btn-link-order');
    var linkModal = new bootstrap.Modal(document.getElementById('linkOrderModal'));
    for (var j = 0; j < linkButtons.length; j++) {
        linkButtons[j].addEventListener('click', function() {
            var logId = this.getAttribute('data-id');
            var amount = this.getAttribute('data-amount');
            var content = this.getAttribute('data-content');

            document.getElementById('linkLogId').value = logId;
            document.getElementById('linkLogIdText').textContent = logId;
            document.getElementById('linkLogAmount').textContent = Number(amount).toLocaleString('vi-VN');
            document.getElementById('linkLogContent').textContent = content;

            linkModal.show();
        });
    }
});
</script>
