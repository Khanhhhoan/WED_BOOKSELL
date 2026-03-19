<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4 text-primary"><i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập</h3>
                
                <form action="<?php echo  BASE_URL ?>auth/login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control <?php echo  (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['email']; ?>" placeholder="Nhập địa chỉ email...">
                        <span class="invalid-feedback"><?php echo  $data['email_err']; ?></span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control <?php echo  (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['password']; ?>" placeholder="Nhập mật khẩu...">
                        <span class="invalid-feedback"><?php echo  $data['password_err']; ?></span>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Đăng Nhập</button>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Chưa có tài khoản? <a href="<?php echo  BASE_URL ?>auth/register" class="text-decoration-none">Đăng ký ngay</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
