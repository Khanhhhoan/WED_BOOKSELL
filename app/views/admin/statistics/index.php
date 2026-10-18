<div class="mb-4">
    <!-- Tiêu đề & Bộ lọc: Theo Tháng / Theo Quý / Chọn Năm -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Thống Kê Doanh Thu</h2>
            <p class="text-muted small mb-0">Theo dõi doanh thu và số lượng đơn hàng theo tháng hoặc quý</p>
        </div>
        
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Nút chọn xem theo Tháng hoặc theo Quý -->
            <div class="btn-group btn-group-sm" role="group">
                <a href="<?php echo BASE_URL ?>admin/statistics?tab=month&year=<?php echo $data['year'] ?>" 
                   class="btn <?php echo ($data['tab'] === 'month') ? 'btn-secondary active fw-semibold' : 'btn-outline-secondary' ?>">
                    Theo Tháng
                </a>
                <a href="<?php echo BASE_URL ?>admin/statistics?tab=quarter&year=<?php echo $data['year'] ?>" 
                   class="btn <?php echo ($data['tab'] === 'quarter') ? 'btn-secondary active fw-semibold' : 'btn-outline-secondary' ?>">
                    Theo Quý
                </a>
            </div>

            <!-- Form chọn năm cơ bản -->
            <form action="<?php echo BASE_URL ?>admin/statistics" method="GET" class="d-flex align-items-center gap-1">
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars($data['tab']) ?>">
                <select name="year" class="form-select form-select-sm" style="min-width: 105px;" onchange="this.form.submit()">
                    <?php foreach ($data['availableYears'] as $y): ?>
                        <option value="<?php echo $y ?>" <?php echo ((int)$data['year'] === (int)$y) ? 'selected' : '' ?>>
                            Năm <?php echo $y ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <!-- Nút Xuất Excel -->
            <div class="btn-group btn-group-sm">
                <a href="<?php echo BASE_URL ?>admin/export_statistics?tab=<?php echo $data['tab'] ?>&year=<?php echo $data['year'] ?>" 
                   class="btn btn-outline-secondary d-flex align-items-center gap-1" title="Tải file Excel báo cáo thống kê">
                    <i class="bi bi-file-earmark-excel"></i> Xuất Excel
                </a>
                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" title="Tùy chọn xuất">
                    <span class="visually-hidden">Tùy chọn xuất</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border">
                    <li>
                        <a class="dropdown-item small py-2" href="<?php echo BASE_URL ?>admin/export_statistics?tab=<?php echo $data['tab'] ?>&year=<?php echo $data['year'] ?>">
                            <i class="bi bi-bar-chart me-1 text-secondary"></i> Báo cáo thống kê (<?php echo ($data['tab'] === 'quarter') ? 'Theo Quý' : 'Theo Tháng' ?> <?php echo $data['year'] ?>)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small py-2" href="<?php echo BASE_URL ?>admin/export_orders?year=<?php echo $data['year'] ?>">
                            <i class="bi bi-list-check me-1 text-secondary"></i> Danh sách đơn hàng (Năm <?php echo $data['year'] ?>)
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item small py-2" href="<?php echo BASE_URL ?>admin/export_orders">
                            <i class="bi bi-receipt me-1 text-secondary"></i> Toàn bộ đơn hàng (Tất cả)
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 3 Thẻ thống kê cơ bản (Không viền màu, không icon màu, chuẩn mộc mạc) -->
    <?php $s = $data['summary']; ?>
    <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
        <!-- 1. Doanh thu -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3">
                <div class="admin-stat-label mb-2">Tổng Doanh Thu</div>
                <div class="h4 mb-0 fw-semibold text-dark">
                    <?php echo number_format($s['total_amount'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">đ</span>
                </div>
            </div>
        </div>

        <!-- 2. Số đơn hàng -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3">
                <div class="admin-stat-label mb-2">Tổng Số Đơn Hàng</div>
                <div class="h4 mb-0 fw-semibold text-dark">
                    <?php echo number_format($s['total_orders'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">đơn</span>
                </div>
            </div>
        </div>

        <!-- 3. Số sách bán ra -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3">
                <div class="admin-stat-label mb-2">Số Sách Đã Bán</div>
                <div class="h4 mb-0 fw-semibold text-dark">
                    <?php echo number_format($s['total_products'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">cuốn</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ cột cơ bản: Doanh thu theo Tháng / Quý -->
    <div class="card border rounded-0 shadow-sm mb-4 bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-semibold mb-0 text-dark">
                Biểu Đồ Doanh Thu <?php echo ($data['tab'] === 'quarter') ? '4 Quý' : '12 Tháng' ?> (Năm <?php echo $data['year'] ?>)
            </h6>
            <span class="small text-muted">Đơn vị: VNĐ</span>
        </div>
        <div class="card-body p-3">
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bảng số liệu chi tiết theo Tháng / Quý -->
    <div class="card border rounded-0 shadow-sm mb-4 bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-semibold mb-0 text-dark">
                Bảng Doanh Thu Chi Tiết <?php echo ($data['tab'] === 'quarter') ? 'Theo Quý' : 'Theo Tháng' ?> (Năm <?php echo $data['year'] ?>)
            </h6>
            <a href="<?php echo BASE_URL ?>admin/export_statistics?tab=<?php echo $data['tab'] ?>&year=<?php echo $data['year'] ?>" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.8rem;" title="Xuất bảng này ra Excel">
                <i class="bi bi-file-earmark-excel me-1"></i>Xuất Excel
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4"><?php echo ($data['tab'] === 'quarter') ? 'Quý' : 'Tháng' ?></th>
                            <th class="text-center">Số Đơn Hàng</th>
                            <th class="text-center">Số Sách Đã Bán</th>
                            <th class="text-end pe-4">Doanh Thu (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['statisticsData'])): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    Chưa có dữ liệu cho năm này
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['statisticsData'] as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold">
                                        <?php 
                                        if ($data['tab'] === 'quarter') {
                                            echo $row['quarter_label'] . ' <small class="text-muted fw-normal">(' . $row['months_label'] . ')</small>';
                                        } else {
                                            echo isset($row['month_label']) ? $row['month_label'] : ('Tháng ' . $row['month']);
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ((int)$row['total_orders'] > 0): ?>
                                            <span class="badge bg-light text-dark border px-2 py-1">
                                                <?php echo (int)$row['total_orders'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ((int)$row['total_products'] > 0): ?>
                                            <strong><?php echo number_format($row['total_products'], 0, ',', '.') ?></strong> cuốn
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">
                                        <?php if ((float)$row['total_amount'] > 0): ?>
                                            <?php echo number_format($row['total_amount'], 0, ',', '.') ?> đ
                                        <?php else: ?>
                                            <span class="text-muted">0 đ</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <!-- Dòng Tổng cộng -->
                    <tfoot class="table-light border-top border-2">
                        <tr class="fw-bold">
                            <td class="ps-4 text-uppercase">Tổng Cộng</td>
                            <td class="text-center"><?php echo number_format($s['total_orders'], 0, ',', '.') ?> đơn</td>
                            <td class="text-center"><?php echo number_format($s['total_products'], 0, ',', '.') ?> cuốn</td>
                            <td class="text-end pe-4 text-dark fs-6"><?php echo number_format($s['total_amount'], 0, ',', '.') ?> đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Top 5 Sách bán chạy nhất -->
    <div class="card border rounded-0 shadow-sm bg-white">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="fw-semibold mb-0 text-dark">
                Top 5 Sách Bán Chạy Nhất (Năm <?php echo $data['year'] ?>)
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Tên Sách</th>
                            <th>Thể Loại</th>
                            <th class="text-center">Đã Bán</th>
                            <th class="text-end pe-4">Tổng Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['topProducts'])): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">Chưa có dữ liệu sách bán ra trong năm này.</td>
                            </tr>
                        <?php else: ?>
                            <?php $rank = 1; foreach ($data['topProducts'] as $book): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted"><?php echo $rank++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" 
                                                 alt="<?php echo htmlspecialchars($book['title']) ?>" 
                                                 style="width: 32px; height: 44px; object-fit: cover; border-radius: 4px;" class="border">
                                            <a href="<?php echo BASE_URL ?>admin/book_edit/<?php echo $book['id'] ?>" class="text-dark text-decoration-none fw-semibold small">
                                                <?php echo htmlspecialchars($book['title']) ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border small">
                                            <?php echo isset($book['category_name']) ? htmlspecialchars($book['category_name']) : 'Khác' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border fw-bold px-2 py-1">
                                            <?php echo (int)$book['total_sold'] ?> cuốn
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">
                                        <?php echo number_format($book['total_revenue'], 0, ',', '.') ?> đ
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Thư viện Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var labels = [];
    var revenueData = [];

    <?php foreach ($data['statisticsData'] as $row): ?>
        <?php 
        $lbl = '';
        if ($data['tab'] === 'quarter') {
            $lbl = $row['quarter_label'];
        } else {
            $lbl = isset($row['month_label']) ? $row['month_label'] : ('Tháng ' . $row['month']);
        }
        ?>
        labels.push(<?php echo json_encode($lbl) ?>);
        revenueData.push(<?php echo (float)$row['total_amount'] ?>);
    <?php endforeach; ?>

    var ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: 'rgba(52, 58, 64, 0.75)',
                    borderColor: '#343a40',
                    borderWidth: 1,
                    borderRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.raw) + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
