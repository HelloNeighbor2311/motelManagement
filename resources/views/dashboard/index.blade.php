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
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-redo"></i> Làm Mới
        </a>
    </div>
</div>

<div style="background: linear-gradient(135deg, #0066CC 0%, #004A99 100%); border-radius: 12px; padding: 32px; margin-bottom: 32px; color: white;">
    <h2 style="margin: 0 0 8px 0; font-size: 28px;">Tổng quan quản lý tòa nhà</h2>
    <p style="margin: 0; opacity: 0.9;">Số liệu được lấy trực tiếp từ dữ liệu khu vực, tòa nhà và căn hộ.</p>
    <div style="margin-top: 16px; opacity: 0.8; font-size: 14px;">
        Hôm nay: <strong>{{ now()->format('d/m/Y') }}</strong>
    </div>
</div>

<div style="margin-bottom: 32px;">
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 16px; color: #343A40;">
        <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i>
        Thống Kê Tổng Quan
    </h3>

    <div class="row g-3">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-map"></i>
                    </div>
                </div>
                <div class="stat-title">Khu Vực</div>
                <div class="stat-value">{{ number_format($stats['areas']) }}</div>
                <div class="stat-subtitle">Tổng số khu vực</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                <div class="stat-title">Tòa Nhà</div>
                <div class="stat-value">{{ number_format($stats['buildings']) }}</div>
                <div class="stat-subtitle">Tổng số tòa nhà</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-door-open"></i>
                    </div>
                </div>
                <div class="stat-title">Căn Hộ</div>
                <div class="stat-value">{{ number_format($stats['apartments']) }}</div>
                <div class="stat-subtitle">Tổng số căn hộ</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-percent"></i>
                    </div>
                </div>
                <div class="stat-title">Tỷ Lệ Lấp Đầy</div>
                <div class="stat-value">{{ $stats['occupancyRate'] }}%</div>
                <div class="stat-subtitle">Theo trạng thái Đang Thuê</div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
                <div class="stat-title">Trống</div>
                <div class="stat-value">{{ number_format($stats['empty']) }}</div>
                <div class="stat-subtitle">Có thể cho thuê</div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(0, 102, 204, 0.1); color: var(--primary);">
                        <i class="fas fa-key"></i>
                    </div>
                </div>
                <div class="stat-title">Đang Thuê</div>
                <div class="stat-value">{{ number_format($stats['occupied']) }}</div>
                <div class="stat-subtitle">Đã có khách thuê</div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.1); color: var(--danger);">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
                <div class="stat-title">Bảo Trì</div>
                <div class="stat-value">{{ number_format($stats['maintenance']) }}</div>
                <div class="stat-subtitle">Cần xử lý</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3" style="margin-bottom: 32px;">
    <div class="col-lg-6">
        <div class="card p-4 h-100">
            <h6 class="mb-3 fw-bold">Tỷ Lệ Trạng Thái Căn Hộ</h6>
            <canvas id="apartmentChart" height="140"></canvas>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Khu Vực & Tòa Nhà</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th>Khu Vực</th>
                                <th>Địa Chỉ</th>
                                <th style="text-align: center;">Tòa Nhà</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($areas as $area)
                                <tr>
                                    <td><strong>{{ $area->TenKhuVuc }}</strong></td>
                                    <td>{{ \Illuminate\Support\Str::limit($area->DiaChi ?? 'N/A', 40) }}</td>
                                    <td style="text-align: center;"><span class="badge badge-primary">{{ $area->toaNhas_count }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Chưa có khu vực nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
        <h6 class="mb-0 fw-bold">Căn Hộ Mới Nhất</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th>Mã Căn</th>
                        <th>Tòa Nhà</th>
                        <th>Khu Vực</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        <th style="text-align: center;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentApartments as $apartment)
                        <tr>
                            <td><strong>{{ $apartment->MaCanHo }}</strong></td>
                            <td>{{ $apartment->toaNha->TenToaNha ?? 'N/A' }}</td>
                            <td>{{ $apartment->toaNha->khuVuc->TenKhuVuc ?? 'N/A' }}</td>
                            <td><span class="badge {{ $apartment->status_badge }}">{{ $apartment->status_display }}</span></td>
                            <td>{{ $apartment->CreatedAt ? \Carbon\Carbon::parse($apartment->CreatedAt)->format('d/m/Y') : 'N/A' }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('apartments.show', $apartment->Id) }}" class="btn btn-sm btn-info table-action-btn" title="Xem Chi Tiết"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có căn hộ nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const apartmentChart = document.getElementById('apartmentChart').getContext('2d');
    new Chart(apartmentChart, {
        type: 'doughnut',
        data: {
            labels: ['Trống', 'Đang Thuê', 'Bảo Trì'],
            datasets: [{
                data: @json([$stats['empty'], $stats['occupied'], $stats['maintenance']]),
                backgroundColor: ['#28A745', '#0066CC', '#DC3545'],
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
