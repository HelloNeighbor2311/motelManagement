@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Dashboard</h1>
        <div class="breadcrumb">
            <span>Trang Chủ</span>
        </div>
    </div>
    <div class="page-actions">
        <button class="btn btn-outline-primary">
            <i class="fas fa-redo"></i> Làm Mới
        </button>
    </div>
</div>

<!-- Welcome Section -->
<div style="background: linear-gradient(135deg, #0066CC 0%, #004A99 100%); border-radius: 12px; padding: 32px; margin-bottom: 32px; color: white;">
    <h2 style="margin: 0 0 8px 0; font-size: 28px;">Chào mừng, Admin!</h2>
    <p style="margin: 0; opacity: 0.9;">Đây là tổng quan về tình hình hệ thống của bạn</p>
    <div style="margin-top: 16px; opacity: 0.8; font-size: 14px;">
        📅 Hôm nay: <strong>{{ date('d/m/Y') }}</strong>
    </div>
</div>

<!-- KPI Cards Section -->
<div style="margin-bottom: 32px;">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 16px; color: #343A40;">
        <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i>
        Thống Kê Tổng Quan
    </h3>

    <div class="row g-3">
        <!-- Card 1: Khu Vực -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-map"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 25%
                    </div>
                </div>
                <div class="stat-title">Khu Vực</div>
                <div class="stat-value">25</div>
                <div class="stat-subtitle">+5 từ tháng trước</div>
            </div>
        </div>

        <!-- Card 2: Tòa Nhà -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 9%
                    </div>
                </div>
                <div class="stat-title">Tòa Nhà</div>
                <div class="stat-value">180</div>
                <div class="stat-subtitle">+15 từ tháng trước</div>
            </div>
        </div>

        <!-- Card 3: Căn Hộ -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 4%
                    </div>
                </div>
                <div class="stat-title">Căn Hộ</div>
                <div class="stat-value">1,250</div>
                <div class="stat-subtitle">+50 từ tháng trước</div>
            </div>
        </div>

        <!-- Card 4: Khách Hàng -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 2%
                    </div>
                </div>
                <div class="stat-title">Khách Hàng</div>
                <div class="stat-value">620</div>
                <div class="stat-subtitle">+10 khách mới</div>
            </div>
        </div>

        <!-- Card 5: Căn Hộ Đang Thuê -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 3%
                    </div>
                </div>
                <div class="stat-title">Đang Thuê</div>
                <div class="stat-value">850</div>
                <div class="stat-subtitle">68% chiếm dụng</div>
            </div>
        </div>

        <!-- Card 6: Căn Hộ Trống -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: var(--warning);">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i> 2%
                    </div>
                </div>
                <div class="stat-title">Trống</div>
                <div class="stat-value">200</div>
                <div class="stat-subtitle">16% có sẵn</div>
            </div>
        </div>

        <!-- Card 7: Hợp Đồng Hiệu Lực -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 5%
                    </div>
                </div>
                <div class="stat-title">HĐ Hiệu Lực</div>
                <div class="stat-value">750</div>
                <div class="stat-subtitle">Đang hoạt động</div>
            </div>
        </div>

        <!-- Card 8: Hóa Đơn Chưa TT -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.1); color: var(--danger);">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i> 8%
                    </div>
                </div>
                <div class="stat-title">HĐ Chưa TT</div>
                <div class="stat-value">45</div>
                <div class="stat-subtitle">250 Triệu đ</div>
            </div>
        </div>

        <!-- Card 9: Doanh Thu Tháng -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 12%
                    </div>
                </div>
                <div class="stat-title">Doanh Thu</div>
                <div class="stat-value">850M</div>
                <div class="stat-subtitle">Tháng 6/2026</div>
            </div>
        </div>

        <!-- Card 10: Chi Phí Tháng -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: var(--warning);">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i> 3%
                    </div>
                </div>
                <div class="stat-title">Chi Phí</div>
                <div class="stat-value">180M</div>
                <div class="stat-subtitle">Tháng 6/2026</div>
            </div>
        </div>

        <!-- Card 11: Lợi Nhuận Tháng -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> 18%
                    </div>
                </div>
                <div class="stat-title">Lợi Nhuận</div>
                <div class="stat-value">670M</div>
                <div class="stat-subtitle">Tháng 6/2026</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div style="margin-bottom: 32px;">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 16px; color: #343A40;">
        <i class="fas fa-chart-bar" style="color: var(--primary); margin-right: 8px;"></i>
        Biểu Đồ Phân Tích
    </h3>

    <div class="row g-3">
        <!-- Chart 1: Doanh Thu 6 Tháng -->
        <div class="col-lg-6">
            <div class="card p-4">
                <h6 class="mb-3 fw-bold">Doanh Thu 6 Tháng Gần Đây</h6>
                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>

        <!-- Chart 2: Chi Phí vs Doanh Thu -->
        <div class="col-lg-6">
            <div class="card p-4">
                <h6 class="mb-3 fw-bold">Chi Phí vs Doanh Thu</h6>
                <canvas id="expenseChart" height="80"></canvas>
            </div>
        </div>

        <!-- Chart 3: Tỷ Lệ Căn Hộ -->
        <div class="col-lg-6">
            <div class="card p-4">
                <h6 class="mb-3 fw-bold">Tỷ Lệ Trạng Thái Căn Hộ</h6>
                <canvas id="apartmentChart" height="80"></canvas>
            </div>
        </div>

        <!-- Chart 4: Tỷ Lệ Thanh Toán -->
        <div class="col-lg-6">
            <div class="card p-4">
                <h6 class="mb-3 fw-bold">Tỷ Lệ Thanh Toán Hóa Đơn</h6>
                <canvas id="paymentChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div style="margin-bottom: 32px;">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 16px; color: #343A40;">
        <i class="fas fa-table" style="color: var(--primary); margin-right: 8px;"></i>
        Thông Tin Cần Chú Ý
    </h3>

    <!-- Table 1: Hóa Đơn Sắp Đến Hạn -->
    <div class="card mb-3">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
            <h6 class="mb-0 fw-bold">Hóa Đơn Sắp Đến Hạn (5 Cái Gần Nhất)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>Mã HĐ</th>
                            <th>Khách Hàng</th>
                            <th>Số Tiền</th>
                            <th>Ngày Hạn</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>INV-001</strong></td>
                            <td>Nguyễn Văn A</td>
                            <td><strong>5.5 Triệu đ</strong></td>
                            <td><span class="badge badge-warning">25/06</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Chi Tiết</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>INV-002</strong></td>
                            <td>Trần Thị B</td>
                            <td><strong>5.0 Triệu đ</strong></td>
                            <td><span class="badge badge-warning">26/06</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Chi Tiết</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>INV-003</strong></td>
                            <td>Lê Văn C</td>
                            <td><strong>6.0 Triệu đ</strong></td>
                            <td><span class="badge badge-danger">27/06</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Chi Tiết</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Table 2: Hợp Đồng Sắp Hết Hạn -->
    <div class="card mb-3">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
            <h6 class="mb-0 fw-bold">Hợp Đồng Sắp Hết Hạn (5 Cái Gần Nhất)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>Mã HĐ</th>
                            <th>Khách Hàng</th>
                            <th>Căn Hộ</th>
                            <th>Ngày Hết Hạn</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>CT-001</strong></td>
                            <td>Nguyễn Văn A</td>
                            <td>A101</td>
                            <td><span class="badge badge-warning">30 ngày</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Gia Hạn</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>CT-002</strong></td>
                            <td>Trần Thị B</td>
                            <td>B205</td>
                            <td><span class="badge badge-warning">60 ngày</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Chi Tiết</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Table 3: Khách Hàng Mới -->
    <div class="card">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
            <h6 class="mb-0 fw-bold">Khách Hàng Mới (5 Cái Gần Nhất)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>Tên Khách Hàng</th>
                            <th>CCCD</th>
                            <th>Điện Thoại</th>
                            <th>Ngày Tạo</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Phạm Văn D</strong></td>
                            <td>123456789</td>
                            <td>0987654321</td>
                            <td>20/06/2026</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Chi Tiết</a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Hoàng Thị E</strong></td>
                            <td>987654321</td>
                            <td>0912345678</td>
                            <td>19/06/2026</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Chi Tiết</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Chart 1: Doanh Thu 6 Tháng
    const ctx1 = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Doanh Thu',
                data: [750, 780, 800, 850, 820, 850],
                borderColor: '#0066CC',
                backgroundColor: 'rgba(0, 102, 204, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#0066CC',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + 'M';
                        }
                    }
                }
            }
        }
    });

    // Chart 2: Chi Phí vs Doanh Thu
    const ctx2 = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [
                {
                    label: 'Doanh Thu',
                    data: [750, 780, 800, 850, 820, 850],
                    backgroundColor: '#0066CC'
                },
                {
                    label: 'Chi Phí',
                    data: [150, 160, 170, 180, 175, 180],
                    backgroundColor: '#FFC107'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + 'M';
                        }
                    }
                }
            }
        }
    });

    // Chart 3: Tỷ Lệ Căn Hộ
    const ctx3 = document.getElementById('apartmentChart').getContext('2d');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ['Đang Thuê', 'Trống', 'Bảo Trì'],
            datasets: [{
                data: [68, 16, 2],
                backgroundColor: [
                    '#0066CC',
                    '#28A745',
                    '#DC3545'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Chart 4: Tỷ Lệ Thanh Toán
    const ctx4 = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: ['Đã TT', 'Chưa TT'],
            datasets: [{
                data: [92, 8],
                backgroundColor: [
                    '#28A745',
                    '#DC3545'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
