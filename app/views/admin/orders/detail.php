<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-file-invoice text-primary me-2"></i>Chi Tiết Đơn Hàng #ORD<?php echo  $data['order']['id'] ?></h2>
        <a href="<?php echo  BASE_URL ?>admin/orders" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Trở về danh sách</a>
    </div>

    <div class="row">
        <!-- Thông tin đơn hàng & Cập nhật trạng thái -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 mb-4 bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Trạng Thái Đơn Hàng</h5>
                    
                    <form action="<?php echo  BASE_URL ?>admin/order_update_status" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo  $data['order']['id'] ?>">
                        <div class="mb-3">
                            <select name="status" class="form-select border-primary shadow-sm fw-bold">
                                <option value="pending" <?php echo  ($data['order']['status'] == 'pending') ? 'selected' : '' ?>>Chờ xác nhận (Pending)</option>
                                <option value="confirmed" <?php echo  ($data['order']['status'] == 'confirmed') ? 'selected' : '' ?>>Đã xác nhận (Confirmed)</option>
                                <option value="shipping" <?php echo  ($data['order']['status'] == 'shipping') ? 'selected' : '' ?>>Đang giao (Shipping)</option>
                                <option value="completed" <?php echo  ($data['order']['status'] == 'completed') ? 'selected' : '' ?>>Hoàn thành (Completed)</option>
                                <option value="cancelled" <?php echo  ($data['order']['status'] == 'cancelled') ? 'selected' : '' ?>>Đã hủy (Cancelled)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sync-alt me-2"></i>Cập Nhật Trạng Thái</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Thông Tin Giao Hàng</h5>
                    <p class="mb-1"><i class="fas fa-user text-muted me-2"></i><strong>Khách hàng:</strong> <?php echo  htmlspecialchars($data['order']['shipping_name']) ?></p>
                    <p class="mb-1"><i class="fas fa-phone text-muted me-2"></i><strong>Điện thoại:</strong> <?php echo  htmlspecialchars($data['order']['shipping_phone']) ?></p>
                    <p class="mb-1"><i class="fas fa-envelope text-muted me-2"></i><strong>Email LH:</strong> <?php echo  htmlspecialchars($data['order']['user_email']) ?></p>
                    <p class="mb-1"><i class="fas fa-map-marker-alt text-muted me-2"></i><strong>Địa chỉ:</strong> <?php echo  htmlspecialchars($data['order']['shipping_address']) ?></p>
                    <p class="mb-0 mt-3 text-muted small"><i class="fas fa-clock me-1"></i>Đặt lúc: <?php echo  date('d/m/Y H:i:s', strtotime($data['order']['created_at'])) ?></p>
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Danh Sách Sản Phẩm (<?php echo  count($data['items']) ?>)</h6>
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
                                                <img src="<?php echo  $item['image'] ? BASE_URL . 'assets/images/' . $item['image'] : 'https://placehold.co/400x600' ?>" class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
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
        </div>
    </div>
</div>
