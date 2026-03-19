<div class="mb-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-shopping-cart text-primary me-2"></i>Giỏ Hàng Của Bạn</h2>

    <?php if (empty($data['cart'])) : ?>
        <div class="alert alert-info shadow-sm p-4 text-center">
            <h4 class="alert-heading mb-3"><i class="fas fa-box-open fa-2x mb-2 d-block"></i>Giỏ hàng trống</h4>
            <p>Bạn chưa thêm sản phẩm nào vào giỏ hàng.</p>
            <a href="<?php echo  BASE_URL ?>book" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
        </div>
    <?php else : ?>
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0 table-responsive">
                        <form action="<?php echo  BASE_URL ?>cart/update" method="POST">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Sản phẩm</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center" style="width: 140px;">Số lượng</th>
                                        <th class="text-end">Thành tiền</th>
                                        <th class="text-center pe-4" style="width: 80px;">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['cart'] as $id => $item) : ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo  $item['image'] ? BASE_URL . 'assets/images/' . $item['image'] : 'https://placehold.co/400x600?text=Book' ?>" alt="Book" class="rounded me-3" style="width: 60px; height: 80px; object-fit: cover;">
                                                    <div>
                                                        <a href="<?php echo  BASE_URL ?>book/detail/<?php echo  $id ?>" class="text-decoration-none fw-bold text-dark text-truncate d-block" style="max-width: 200px;"><?php echo  htmlspecialchars($item['title']) ?></a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center text-danger fw-bold">
                                                <?php echo  number_format($item['price'], 0, ',', '.') ?> đ
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="quantity[<?php echo  $id ?>]" value="<?php echo  $item['quantity'] ?>" min="1" class="form-control text-center form-control-sm">
                                            </td>
                                            <td class="text-end fw-bold">
                                                <?php echo  number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="<?php echo  BASE_URL ?>cart/remove/<?php echo  $id ?>" class="text-danger p-2" onclick="return confirm('Bạn có chắc muốn xóa?')"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="card-footer bg-white p-3 d-flex justify-content-between align-items-center">
                                <a href="<?php echo  BASE_URL ?>cart/clear" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa toàn bộ giỏ hàng?')"><i class="fas fa-times me-1"></i>Xóa tất cả</a>
                                <button type="submit" class="btn btn-sm btn-secondary"><i class="fas fa-sync-alt me-1"></i>Cập nhật giỏ hàng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white p-3">
                        <h5 class="card-title mb-0"><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tổng cộng</span>
                            <span class="fw-bold"><?php echo  number_format($data['total'], 0, ',', '.') ?> đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Phí vận chuyển</span>
                            <span class="text-success fw-bold">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Thành tiền</span>
                            <span class="fw-bold fs-5 text-danger"><?php echo  number_format($data['total'], 0, ',', '.') ?> đ</span>
                        </div>
                        
                        <?php if (Session::isLoggedIn()) : ?>
                            <a href="<?php echo  BASE_URL ?>order/checkout" class="btn btn-success btn-lg w-100 shadow-sm"><i class="fas fa-check-circle me-2"></i>Tiến Hành Thanh Toán</a>
                        <?php else : ?>
                            <div class="alert alert-warning p-3 mb-0 text-center small">
                                <i class="fas fa-info-circle mb-2 fa-lg d-block"></i>
                                Bạn cần <a href="<?php echo  BASE_URL ?>auth/login" class="fw-bold">đăng nhập</a> để thanh toán
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?php echo  BASE_URL ?>book" class="btn btn-outline-primary w-100 mt-3"><i class="fas fa-arrow-left me-2"></i>Tiếp tục mua hàng</a>
            </div>
        </div>
    <?php endif; ?>
</div>
