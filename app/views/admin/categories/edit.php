<div class="row justify-content-center mb-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-1"></i>Sửa Danh Mục #<?php echo  $data['category']['id'] ?></h6>
                <a href="<?php echo  BASE_URL ?>admin/categories" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Quay lại</a>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo  BASE_URL ?>admin/category_edit/<?php echo  $data['category']['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php echo  htmlspecialchars($data['category']['name']) ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" class="form-control" rows="5"><?php echo  htmlspecialchars($data['category']['description']) ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="fas fa-save me-2"></i>Cập Nhật Thay Đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>
