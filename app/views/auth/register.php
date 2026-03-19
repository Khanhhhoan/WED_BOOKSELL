<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow border-0 rounded-3">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4 text-primary"><i class="fas fa-user-plus me-2"></i>Đăng Ký Tài Khoản</h3>
                
                <form action="<?php echo  BASE_URL ?>auth/register" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Họ và tên</label>
                            <input type="text" name="full_name" class="form-control <?php echo  (!empty($data['full_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['full_name']; ?>" placeholder="Nguyễn Văn A">
                            <span class="invalid-feedback"><?php echo  $data['full_name_err']; ?></span>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo  $data['phone']; ?>" placeholder="0987654321">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control <?php echo  (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['email']; ?>" placeholder="email@example.com">
                        <span class="invalid-feedback"><?php echo  $data['email_err']; ?></span>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control <?php echo  (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['password']; ?>" placeholder="Ít nhất 6 ký tự">
                            <span class="invalid-feedback"><?php echo  $data['password_err']; ?></span>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo  (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['confirm_password']; ?>">
                            <span class="invalid-feedback"><?php echo  $data['confirm_password_err']; ?></span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Ghi Danh</button>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Đã có tài khoản? <a href="<?php echo  BASE_URL ?>auth/login" class="text-decoration-none">Đăng nhập</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
