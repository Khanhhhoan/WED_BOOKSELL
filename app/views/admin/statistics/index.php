<div class="mb-4">
    <!-- Breadcrumb & Tiêu đề -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>admin" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Báo cáo & Thống kê</li>
                </ol>
            </nav>
            <h2 class="fw-bold text-dark mb-0">Thống Kê Đơn Hàng & Doanh Thu</h2>
            <p class="text-muted small mb-0">Theo dõi số lượng sản phẩm bán ra và thành tiền theo Tháng, Quý, Năm</p>
        </div>
        
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm shadow-sm">
                In Báo Cáo
            </button>
            <a href="<?php echo BASE_URL ?>admin/export_statistics?tab=<?php echo $data['tab'] ?>&year=<?php echo $data['year'] ?>&status=<?php echo $data['statusFilter'] ?>" class="btn btn-outline-success btn-sm shadow-sm">
                Xuất Excel (CSV)
            </a>
        </div>
    </div>

    <!-- Thanh Điều Khiển Bộ Lọc (Tabs, Chọn Năm, Lọc Trạng Thái) -->
    <div class="card border shadow-sm rounded-3 mb-4 bg-white">
        <div class="card-body p-3">
            <form action="<?php echo BASE_URL ?>admin/statistics" method="GET" class="row g-3 align-items-center" id="statFilterForm">
                
                <!-- 1. Tabs chọn chu kỳ: Tháng / Quý / Năm -->
                <div class="col-12 col-md-auto">
                    <div class="btn-group shadow-sm" role="group">
                        <a href="<?php echo BASE_URL ?>admin/statistics?tab=month&year=<?php echo $data['year'] ?>&status=<?php echo $data['statusFilter'] ?>" 
                           class="btn btn-sm <?php echo ($data['tab'] === 'month') ? 'btn-primary active fw-semibold' : 'btn-outline-secondary' ?>">
                            Theo Tháng
                        </a>
                        <a href="<?php echo BASE_URL ?>admin/statistics?tab=quarter&year=<?php echo $data['year'] ?>&status=<?php echo $data['statusFilter'] ?>" 
                           class="btn btn-sm <?php echo ($data['tab'] === 'quarter') ? 'btn-primary active fw-semibold' : 'btn-outline-secondary' ?>">
                            Theo Quý
                        </a>
                        <a href="<?php echo BASE_URL ?>admin/statistics?tab=year&status=<?php echo $data['statusFilter'] ?>" 
                           class="btn btn-sm <?php echo ($data['tab'] === 'year') ? 'btn-primary active fw-semibold' : 'btn-outline-secondary' ?>">
                            Theo Năm
                        </a>
                    </div>
                </div>

                <input type="hidden" name="tab" value="<?php echo htmlspecialchars($data['tab']) ?>">

                <!-- 2. Chọn Năm (khi xem theo Tháng hoặc Quý) -->
                <?php if ($data['tab'] !== 'year'): ?>
                    <div class="col-auto d-flex align-items-center gap-2">
                        <label class="small fw-semibold text-muted text-nowrap">Năm:</label>
                        <select name="year" class="form-select form-select-sm" style="min-width: 110px;" onchange="this.form.submit()">
                            <?php foreach ($data['availableYears'] as $y): ?>
                                <option value="<?php echo $y ?>" <?php echo ((int)$data['year'] === (int)$y) ? 'selected' : '' ?>>
                                    Năm <?php echo $y ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- 3. Lọc Trạng Thái Đơn Hàng -->
                <div class="col-auto d-flex align-items-center gap-2">
                    <label class="small fw-semibold text-muted text-nowrap">Trạng thái:</label>
                    <select name="status" class="form-select form-select-sm" style="min-width: 200px;" onchange="this.form.submit()">
                        <option value="valid" <?php echo ($data['statusFilter'] === 'valid') ? 'selected' : '' ?>>Đơn hợp lệ (Trừ đã hủy)</option>
                        <option value="completed" <?php echo ($data['statusFilter'] === 'completed') ? 'selected' : '' ?>>Chỉ đơn hoàn thành</option>
                        <option value="all" <?php echo ($data['statusFilter'] === 'all') ? 'selected' : '' ?>>Toàn bộ đơn hàng (kể cả pending)</option>
                    </select>
                </div>

                <!-- 4. Gợi ý trạng thái đang xem -->
                <div class="col-12 col-xl text-xl-end">
                    <span class="badge bg-light text-secondary border px-3 py-2 small">
                        <?php 
                        if ($data['tab'] === 'month') {
                            echo 'Đang xem 12 tháng năm <strong>' . $data['year'] . '</strong>';
                        } elseif ($data['tab'] === 'quarter') {
                            echo 'Đang xem 4 quý năm <strong>' . $data['year'] . '</strong>';
                        } else {
                            echo 'Đang xem tổng hợp qua tất cả các năm';
                        }
                        ?>
                    </span>
                </div>

            </form>
        </div>
    </div>

    <!-- 4 THẺ KPI TỔNG QUAN -->
    <?php $s = $data['summary']; ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-4">
        
        <!-- KPI 1: Tổng Thành Tiền (Doanh Thu) -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3 shadow-sm border-start border-4 border-success">
                <div>
                    <div class="admin-stat-label mb-1 text-uppercase fw-semibold">Tổng Thành Tiền (Doanh Thu)</div>
                    <div class="h3 mb-0 fw-bold text-success">
                        <?php echo number_format($s['total_amount'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">đ</span>
                    </div>
                </div>
                <div class="small text-muted mt-2">
                    <?php if (!empty($s['peak_period']) && $s['peak_amount'] > 0): ?>
                        Đỉnh: <strong><?php echo $s['peak_period'] ?></strong> (<?php echo number_format($s['peak_amount'], 0, ',', '.') ?> đ)
                    <?php else: ?>
                        Tổng doanh thu trong kỳ được chọn
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- KPI 2: Số Lượng Sản Phẩm Bán Ra -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3 shadow-sm border-start border-4 border-primary">
                <div>
                    <div class="admin-stat-label mb-1 text-uppercase fw-semibold">Số Lượng Sản Phẩm Bán Ra</div>
                    <div class="h3 mb-0 fw-bold text-primary">
                        <?php echo number_format($s['total_products'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">cuốn</span>
                    </div>
                </div>
                <div class="small text-muted mt-2">
                    Trung bình <?php echo ($s['total_orders'] > 0) ? round($s['total_products'] / $s['total_orders'], 1) : 0 ?> cuốn / đơn hàng
                </div>
            </div>
        </div>

        <!-- KPI 3: Tổng Số Đơn Hàng -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3 shadow-sm border-start border-4 border-warning">
                <div>
                    <div class="admin-stat-label mb-1 text-uppercase fw-semibold">Tổng Số Đơn Hàng</div>
                    <div class="h3 mb-0 fw-bold text-dark">
                        <?php echo number_format($s['total_orders'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">đơn</span>
                    </div>
                </div>
                <div class="small text-muted mt-2">
                    Số đơn phát sinh theo bộ lọc trạng thái
                </div>
            </div>
        </div>

        <!-- KPI 4: Doanh Thu Trung Bình / Đơn (AOV) -->
        <div class="col">
            <div class="admin-stat-card h-100 p-3 shadow-sm border-start border-4 border-info">
                <div>
                    <div class="admin-stat-label mb-1 text-uppercase fw-semibold">Giá Trị Đơn Trung Bình</div>
                    <div class="h3 mb-0 fw-bold text-dark">
                        <?php echo number_format($s['avg_order_value'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">đ</span>
                    </div>
                </div>
                <div class="small text-muted mt-2">
                    Average Order Value (AOV)
                </div>
            </div>
        </div>

    </div>

    <!-- KHU VỰC BIỂU ĐỒ TRỰC QUAN (CHART.JS) -->
    <div class="row g-4 mb-4">
        <!-- Biểu đồ chính: Thành tiền (Cột) & Số lượng sản phẩm (Đường) -->
        <div class="col-12 col-xl-8">
            <div class="card border shadow-sm rounded-3 h-100 bg-white">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">
                        Biểu Đồ Doanh Thu & Số Lượng Sản Phẩm
                    </h6>
                    <span class="small text-muted">
                        <?php echo ($data['tab'] === 'month' ? '12 Tháng (' . $data['year'] . ')' : ($data['tab'] === 'quarter' ? '4 Quý (' . $data['year'] . ')' : 'Toàn bộ năm')) ?>
                    </span>
                </div>
                <div class="card-body p-3">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="mainStatsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ phụ: Phương thức thanh toán -->
        <div class="col-12 col-xl-4">
            <div class="card border shadow-sm rounded-3 h-100 bg-white">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">
                        Phương Thức Thanh Toán
                    </h6>
                    <span class="small text-muted">Tỷ lệ theo đơn</span>
                </div>
                <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                    <div style="position: relative; height: 230px; width: 100%;">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                    
                    <div class="w-100 mt-3 border-top pt-2">
                        <div class="d-flex justify-content-between small text-muted">
                            <?php if (!empty($data['paymentStats'])): ?>
                                <?php foreach ($data['paymentStats'] as $p): ?>
                                    <div>
                                        <span class="fw-semibold text-dark">
                                            <?php 
                                            $mName = $p['payment_method'];
                                            if ($mName === 'sepay' || $mName === 'online') echo 'SePay VietQR';
                                            elseif ($mName === 'cod') echo 'COD (Tiền mặt)';
                                            else echo ucfirst($mName);
                                            ?>:
                                        </span>
                                        <?php echo (int)$p['total_orders'] ?> đơn (<?php echo number_format($p['total_amount'], 0, ',', '.') ?> đ)
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">Chưa có giao dịch</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BẢNG SỐ LIỆU CHI TIẾT THEO CHU KỲ (THÁNG / QUÝ / NĂM) -->
    <div class="card border shadow-sm rounded-3 mb-4 bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark">
                Bảng Số Liệu Chi Tiết: 
                <?php 
                if ($data['tab'] === 'month') echo 'Theo Từng Tháng (Năm ' . $data['year'] . ')';
                elseif ($data['tab'] === 'quarter') echo 'Theo Từng Quý (Năm ' . $data['year'] . ')';
                else echo 'Theo Từng Năm';
                ?>
            </h6>
            <span class="small text-muted">
                Đơn vị tiền: <strong>VNĐ</strong> | Số lượng: <strong>Cuốn</strong>
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="min-width: 150px;">Thời Gian</th>
                            <th class="text-center" style="min-width: 110px;">Số Đơn Hàng</th>
                            <th class="text-center" style="min-width: 140px;">Số Lượng SP Bán</th>
                            <th class="text-end" style="min-width: 160px;">Tổng Thành Tiền</th>
                            <th class="text-end" style="min-width: 150px;">Đơn Trung Bình</th>
                            <th class="pe-4" style="min-width: 180px;">Tỷ Lệ Doanh Thu</th>
                            <?php if ($data['tab'] === 'year'): ?>
                                <th class="text-center" style="min-width: 130px;">Tăng Trưởng</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['statisticsData'])): ?>
                            <tr>
                                <td colspan="<?php echo ($data['tab'] === 'year' ? 7 : 6) ?>" class="text-center py-4 text-muted">
                                    Không có dữ liệu trong khoảng thời gian này
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['statisticsData'] as $row): ?>
                                <?php 
                                $percent = ($s['total_amount'] > 0) ? round(((float)$row['total_amount'] / $s['total_amount']) * 100, 1) : 0;
                                $isPeak = (!empty($s['peak_amount']) && (float)$row['total_amount'] === (float)$s['peak_amount'] && $s['peak_amount'] > 0);
                                ?>
                                <tr class="<?php echo $isPeak ? 'table-success-subtle' : '' ?>">
                                    <td class="ps-4 fw-bold">
                                        <?php 
                                        if ($data['tab'] === 'month') {
                                            echo $row['month_label'];
                                        } elseif ($data['tab'] === 'quarter') {
                                            echo $row['quarter_label'] . ' <span class="text-muted fw-normal small">(' . $row['months_label'] . ')</span>';
                                        } else {
                                            echo $row['year_label'];
                                        }
                                        ?>
                                        <?php if ($isPeak): ?>
                                            <span class="badge bg-success ms-1 small">Đỉnh</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Số đơn hàng -->
                                    <td class="text-center">
                                        <?php if ((int)$row['total_orders'] > 0): ?>
                                            <span class="badge bg-light text-dark border fw-bold px-2 py-1">
                                                <?php echo (int)$row['total_orders'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Số lượng sản phẩm bán ra -->
                                    <td class="text-center fw-semibold text-primary">
                                        <?php if ((int)$row['total_products'] > 0): ?>
                                            <strong><?php echo number_format($row['total_products'], 0, ',', '.') ?></strong> <small class="text-muted">cuốn</small>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Thành tiền -->
                                    <td class="text-end fw-bold text-dark">
                                        <?php if ((float)$row['total_amount'] > 0): ?>
                                            <?php echo number_format($row['total_amount'], 0, ',', '.') ?> đ
                                        <?php else: ?>
                                            <span class="text-muted">0 đ</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Đơn TB -->
                                    <td class="text-end text-muted small">
                                        <?php if ((float)$row['avg_order_value'] > 0): ?>
                                            <?php echo number_format($row['avg_order_value'], 0, ',', '.') ?> đ
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <!-- Tỷ lệ % Doanh Thu -->
                                    <td class="pe-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent ?>%;" aria-valuenow="<?php echo $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="small fw-semibold text-muted text-nowrap" style="min-width: 45px; text-align: right;">
                                                <?php echo $percent ?>%
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Tăng trưởng theo năm (nếu có) -->
                                    <?php if ($data['tab'] === 'year'): ?>
                                        <td class="text-center">
                                            <?php if ($row['growth_rate'] !== null): ?>
                                                <?php if ($row['growth_rate'] >= 0): ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                        +<?php echo $row['growth_rate'] ?>%
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                        <?php echo $row['growth_rate'] ?>%
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                    <!-- DÒNG TỔNG CỘNG -->
                    <tfoot class="table-light border-top border-2">
                        <tr class="fw-bold">
                            <td class="ps-4 text-uppercase">TỔNG CỘNG</td>
                            <td class="text-center text-dark"><?php echo number_format($s['total_orders'], 0, ',', '.') ?> đơn</td>
                            <td class="text-center text-primary"><?php echo number_format($s['total_products'], 0, ',', '.') ?> cuốn</td>
                            <td class="text-end text-success fs-6"><?php echo number_format($s['total_amount'], 0, ',', '.') ?> đ</td>
                            <td class="text-end text-muted small"><?php echo number_format($s['avg_order_value'], 0, ',', '.') ?> đ</td>
                            <td class="pe-4 text-muted small">100%</td>
                            <?php if ($data['tab'] === 'year'): ?>
                                <td class="text-center">-</td>
                            <?php endif; ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- BẢNG PHỤ: TOP 5 SẢN PHẨM BÁN CHẠY NHẤT -->
    <div class="card border shadow-sm rounded-3 bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark">
                Top 5 Sách Bán Chạy Nhất Trong Kỳ
            </h6>
            <span class="small text-muted">Xếp theo số lượng sản phẩm bán ra</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Sách</th>
                            <th>Thể loại</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-center">Đã Bán</th>
                            <th class="text-end pe-4">Tổng Doanh Thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['topProducts'])): ?>
                            <tr><td colspan="6" class="text-center py-3 text-muted">Chưa có dữ liệu sách bán ra trong khoảng thời gian này.</td></tr>
                        <?php else: ?>
                            <?php $rank = 1; foreach ($data['topProducts'] as $book): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted"><?php echo $rank++; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?php echo htmlspecialchars(book_image_url(isset($book['image']) ? $book['image'] : ''), ENT_QUOTES, 'UTF-8'); ?>" 
                                                 alt="<?php echo htmlspecialchars($book['title']) ?>" 
                                                 style="width: 36px; height: 50px; object-fit: cover; border-radius: 4px;" class="border shadow-xs">
                                            <div>
                                                <a href="<?php echo BASE_URL ?>admin/book_edit/<?php echo $book['id'] ?>" class="text-dark fw-bold text-decoration-none small">
                                                    <?php echo htmlspecialchars($book['title']) ?>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border small">
                                            <?php echo isset($book['category_name']) ? htmlspecialchars($book['category_name']) : 'Khác' ?>
                                        </span>
                                    </td>
                                    <td class="text-end small"><?php echo number_format($book['price'], 0, ',', '.') ?> đ</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2 py-1">
                                            <?php echo (int)$book['total_sold'] ?> cuốn
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-success">
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
    // Chuẩn bị dữ liệu từ PHP
    var labels = [];
    var revenueData = [];
    var productsData = [];

    <?php foreach ($data['statisticsData'] as $row): ?>
        <?php 
        $label = '';
        if ($data['tab'] === 'month') $label = $row['month_label'];
        elseif ($data['tab'] === 'quarter') $label = $row['quarter_label'];
        else $label = $row['year_label'];
        ?>
        labels.push(<?php echo json_encode($label) ?>);
        revenueData.push(<?php echo (float)$row['total_amount'] ?>);
        productsData.push(<?php echo (int)$row['total_products'] ?>);
    <?php endforeach; ?>

    // 1. Khởi tạo Biểu đồ chính (Bar + Line)
    var ctxMain = document.getElementById('mainStatsChart');
    if (ctxMain) {
        new Chart(ctxMain, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Thành tiền / Doanh thu (VNĐ)',
                        data: revenueData,
                        backgroundColor: 'rgba(26, 95, 74, 0.75)',
                        borderColor: '#1a5f4a',
                        borderWidth: 1.5,
                        borderRadius: 4,
                        yAxisID: 'yRevenue',
                        order: 2
                    },
                    {
                        label: 'Số lượng sản phẩm bán (Cuốn)',
                        data: productsData,
                        type: 'line',
                        borderColor: '#e67e22',
                        backgroundColor: 'rgba(230, 126, 34, 0.2)',
                        borderWidth: 3,
                        pointBackgroundColor: '#e67e22',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        yAxisID: 'yProducts',
                        order: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    yRevenue: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)',
                            color: '#1a5f4a',
                            font: { weight: 'bold' }
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    yProducts: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Sản phẩm (Cuốn)',
                            color: '#e67e22',
                            font: { weight: 'bold' }
                        },
                        grid: { drawOnChartArea: false },
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (context.datasetIndex === 0) {
                                    return label + ': ' + new Intl.NumberFormat('vi-VN').format(context.raw) + ' VNĐ';
                                } else {
                                    return label + ': ' + context.raw + ' cuốn';
                                }
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Khởi tạo Biểu đồ Doughnut (Phương thức thanh toán)
    var ctxPay = document.getElementById('paymentMethodChart');
    if (ctxPay) {
        var payLabels = [];
        var payCounts = [];
        var payColors = ['#1a5f4a', '#0d6efd', '#6c757d', '#ffc107'];

        <?php if (!empty($data['paymentStats'])): ?>
            <?php foreach ($data['paymentStats'] as $p): ?>
                <?php 
                $lbl = $p['payment_method'];
                if ($lbl === 'sepay' || $lbl === 'online') $lbl = 'SePay VietQR';
                elseif ($lbl === 'cod') $lbl = 'COD';
                else $lbl = ucfirst($lbl);
                ?>
                payLabels.push(<?php echo json_encode($lbl) ?>);
                payCounts.push(<?php echo (int)$p['total_orders'] ?>);
            <?php endforeach; ?>
        <?php endif; ?>

        if (payCounts.length === 0) {
            payLabels = ['Chưa có đơn'];
            payCounts = [1];
            payColors = ['#dee2e6'];
        }

        new Chart(ctxPay, {
            type: 'doughnut',
            data: {
                labels: payLabels,
                datasets: [{
                    data: payCounts,
                    backgroundColor: payColors,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12 }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>

<style>
@media print {
    .sidebar, .top-navbar, .btn, #statFilterForm {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: 1px solid #ccc !important;
        box-shadow: none !important;
        break-inside: avoid;
    }
}
</style>
