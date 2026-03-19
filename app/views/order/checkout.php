<div class="mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo  BASE_URL ?>cart" class="text-decoration-none">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
        </ol>
    </nav>
    <h2 class="fw-bold mb-4"><i class="fas fa-credit-card text-success me-2"></i>Tiến Hành Thanh Toán</h2>

    <div class="row">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-3 border-bottom border-light">
                    <h5 class="card-title fw-bold mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Thông tin vận chuyển</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo  BASE_URL ?>order/checkout" method="POST" id="checkoutForm">
                        
                        <div class="mb-3">
                            <label class="form-label">Họ và tên người nhận</label>
                            <input type="text" name="shipping_name" class="form-control" value="<?php echo  $data['user']['full_name'] ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại liên hệ</label>
                            <input type="text" name="shipping_phone" class="form-control" value="<?php echo  $data['user']['phone'] ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Địa chỉ giao hàng chi tiết</label>
                            <textarea name="shipping_address" class="form-control" rows="3" required><?php echo  $data['user']['address'] ?></textarea>
                        </div>
                        
                        <h5 class="fw-bold mb-3 mt-4 text-primary"><i class="fas fa-wallet me-2"></i>Phương thức thanh toán</h5>
                        
                        <div class="list-group mb-4">
                            <label class="list-group-item d-flex gap-3 bg-light border-light shadow-sm mb-2 rounded pe-auto cursor-pointer">
                                <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="cod" checked>
                                <span>
                                    <span class="fw-bold d-block"><i class="fas fa-money-bill-wave text-success me-2"></i>Thanh toán khi nhận hàng (COD)</span>
                                    <small class="text-muted">Nhận sách và thanh toán tiền mặt trực tiếp cho người giao hàng.</small>
                                </span>
                            </label>
                            
                            <label class="list-group-item d-flex gap-3 bg-light border-light shadow-sm rounded pe-auto cursor-pointer">
                                <input class="form-check-input flex-shrink-0" type="radio" name="payment_method" value="online">
                                <span>
                                    <span class="fw-bold d-block"><i class="fas fa-credit-card text-primary me-2"></i>Thanh toán trực tuyến (Mock/Tiền trạm)</span>
                                    <small class="text-muted">Mô phỏng thanh toán thành công qua thẻ/ví điện tử.</small>
                                </span>
                            </label>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Đơn hàng của bạn (<?php echo  count($data['cart']) ?> sản phẩm)</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($data['cart'] as $item) : ?>
                            <li class="list-group-item bg-transparent px-0 d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0"><?php echo  htmlspecialchars($item['title']) ?></h6>
                                    <small class="text-muted">Số lượng: <?php echo  $item['quantity'] ?></small>
                                </div>
                                <span class="text-muted"><?php echo  number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between my-3 fs-5">
                        <span class="fw-bold d-block">Tổng cộng</span>
                        <strong class="text-danger"><?php echo  number_format($data['total'], 0, ',', '.') ?> VNĐ</strong>
                    </div>
                    
                    <button type="submit" form="checkoutForm" class="btn btn-success btn-lg w-100 shadow mt-3"><i class="fas fa-cart-arrow-down me-2"></i>Xác Nhận Đặt Hàng</button>
                </div>
            </div>
        </div>
    </div>
</div>
