<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Chi Tiết Đơn Hàng #ORD<?php echo  $data['order']['id'] ?></h2>
        <a href="<?php echo  BASE_URL ?>admin/orders" class="btn btn-outline-secondary">Trở về danh sách</a>
    </div>

    <div class="row">
        <!-- Thông tin đơn hàng & Cập nhật trạng thái -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border mb-4 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Trạng Thái Đơn Hàng</h5>
                    
                    <form action="<?php echo  BASE_URL ?>admin/order_update_status" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo  $data['order']['id'] ?>">
                        <div class="mb-3">
                            <select name="status" class="form-select border-secondary">
                                <option value="pending" <?php echo  ($data['order']['status'] == 'pending') ? 'selected' : '' ?>>Chờ xác nhận (Pending)</option>
                                <option value="confirmed" <?php echo  ($data['order']['status'] == 'confirmed') ? 'selected' : '' ?>>Đã xác nhận (Confirmed)</option>
                                <option value="shipping" <?php echo  ($data['order']['status'] == 'shipping') ? 'selected' : '' ?>>Đang giao (Shipping)</option>
                                <option value="completed" <?php echo  ($data['order']['status'] == 'completed') ? 'selected' : '' ?>>Hoàn thành (Completed)</option>
                                <option value="cancelled" <?php echo  ($data['order']['status'] == 'cancelled') ? 'selected' : '' ?>>Đã hủy (Cancelled)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Cập Nhật Trạng Thái</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Thông Tin Giao Hàng</h5>
                    <p class="mb-1"><strong>Khách hàng:</strong> <?php echo  htmlspecialchars($data['order']['shipping_name']) ?></p>
                    <p class="mb-1"><strong>Điện thoại:</strong> <?php echo  htmlspecialchars($data['order']['shipping_phone']) ?></p>
                    <p class="mb-1"><strong>Email LH:</strong> <?php echo  htmlspecialchars($data['order']['user_email']) ?></p>
                    <p class="mb-1"><strong>Địa chỉ:</strong> <?php echo  htmlspecialchars($data['order']['shipping_address']) ?></p>
                    <p class="mb-0 mt-3 text-muted small">Đặt lúc: <?php echo  date('d/m/Y H:i:s', strtotime($data['order']['created_at'])) ?></p>
                </div>
            </div>

            <!-- Thông tin thanh toán SePay / COD -->
            <div class="card shadow-sm border">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-credit-card me-1 text-primary"></i>Thanh Toán</h5>
                    <p class="mb-2">
                        <strong>Hình thức:</strong> 
                        <?php if (isset($data['order']['payment_method']) && ($data['order']['payment_method'] === 'sepay' || $data['order']['payment_method'] === 'online')) : ?>
                            <span class="badge bg-primary"><i class="bi bi-qr-code me-1"></i> SePay Chuyển Khoản</span>
                        <?php else : ?>
                            <span class="badge bg-secondary"><i class="bi bi-cash me-1"></i> COD Tiền Mặt</span>
                        <?php endif; ?>
                    </p>
                    <p class="mb-2">
                        <strong>Trạng thái:</strong>
                        <?php if (isset($data['order']['payment_status']) && $data['order']['payment_status'] === 'success') : ?>
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Đã thanh toán</span>
                        <?php else : ?>
                            <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Chờ thanh toán</span>
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($data['order']['payment_transaction_id'])) : ?>
                        <p class="mb-1 small">
                            <strong>Mã GD SePay:</strong>
                            <span class="font-monospace text-dark d-block bg-light p-1 rounded border mt-1"><?php echo htmlspecialchars($data['order']['payment_transaction_id']) ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="col-lg-8">
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-semibold text-dark">Danh Sách Sản Phẩm (<?php echo  count($data['items']) ?>)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['items'] as $item) : ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo htmlspecialchars(book_image_url(isset($item['image']) ? $item['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                                <a href="<?php echo  BASE_URL ?>book/detail/<?php echo  $item['book_id'] ?>" target="_blank" class="fw-bold text-dark text-decoration-none"><?php echo  htmlspecialchars($item['title']) ?></a>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo  number_format($item['price'], 0, ',', '.') ?> đ</td>
                                        <td class="text-center fw-bold"><?php echo  $item['quantity'] ?></td>
                                        <td class="text-end pe-4 fw-bold"><?php echo  number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end pe-4 fw-bold text-danger fs-5"><?php echo  number_format($data['order']['total_amount'], 0, ',', '.') ?> đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bảng Log Thanh Toán Gắn Với Đơn Hàng -->
            <?php if (!empty($data['logs'])) : ?>
                <div class="card shadow-sm border">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-semibold text-primary"><i class="bi bi-clock-history me-2"></i>Lịch Sử Giao Dịch SePay Đơn Hàng Này (<?php echo count($data['logs']) ?>)</h6>
                        <a href="<?php echo BASE_URL ?>admin/payments?keyword=<?php echo $data['order']['id'] ?>" class="btn btn-sm btn-outline-secondary">Xem lịch sử thanh toán</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">#Log ID</th>
                                        <th>Thời gian</th>
                                        <th>Ngân hàng</th>
                                        <th class="text-end">Số tiền</th>
                                        <th>Nội dung</th>
                                        <th>Mã tham chiếu</th>
                                        <th class="text-center pe-3">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['logs'] as $l) : ?>
                                        <tr>
                                            <td class="ps-3 fw-bold">#<?php echo $l['id'] ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($l['created_at'])) ?></td>
                                            <td><?php echo htmlspecialchars($l['gateway']) ?></td>
                                            <td class="text-end fw-bold text-success">+<?php echo number_format($l['transfer_amount'], 0, ',', '.') ?> đ</td>
                                            <td><span class="font-monospace"><?php echo htmlspecialchars($l['content']) ?></span></td>
                                            <td class="font-monospace text-muted"><?php echo htmlspecialchars($l['reference_code']) ?></td>
                                            <td class="text-center pe-3">
                                                <span class="badge bg-<?php echo ($l['status'] === 'success') ? 'success' : 'warning' ?>">
                                                    <?php echo htmlspecialchars($l['status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
