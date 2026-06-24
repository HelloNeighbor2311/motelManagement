@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $customer->TenKhachHang }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('customers.index') }}">Khách Hàng</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('customers.edit', $customer->Id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Cơ Bản</h6>
            </div>
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 16px;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 24px;">
                        {{ substr($customer->TenKhachHang, 0, 1) }}
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Tên Khách Hàng</label>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600;">{{ $customer->TenKhachHang }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Loại</label>
                    <p style="margin: 4px 0 0 0;">
                        <span class="badge {{ $customer->LoaiKhach == 'Nhan' ? 'bg-info' : 'bg-success' }}">
                            {{ $customer->LoaiKhach == 'Nhan' ? '👤 Cá Nhân' : '🏢 Doanh Nghiệp' }}
                        </span>
                    </p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Số Điện Thoại</label>
                    <p style="margin: 4px 0 0 0;">
                        <a href="tel:{{ $customer->SoDienThoai }}" style="color: #0066cc; text-decoration: none;">{{ $customer->SoDienThoai }}</a>
                    </p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Email</label>
                    <p style="margin: 4px 0 0 0;">
                        <a href="mailto:{{ $customer->Email }}" style="color: #0066cc; text-decoration: none;">{{ $customer->Email }}</a>
                    </p>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">CCCD/MST</label>
                    <p style="margin: 4px 0 0 0;">{{ optional($customer->thongTinKhachHang)->SoGiayTo ?? $customer->CCCD ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thống Kê</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e0e0e0;">
                    <p style="font-size: 12px; color: #6C757D; margin: 0; text-transform: uppercase; font-weight: 600;">Hợp Đồng</p>
                    <p style="font-size: 28px; font-weight: 700; margin: 8px 0 0 0; color: #0066cc;">
                        {{ $customer->hopDongs()->count() }}
                    </p>
                </div>

                <div>
                    <p style="font-size: 12px; color: #6C757D; margin: 0; text-transform: uppercase; font-weight: 600;">Hóa Đơn</p>
                    <p style="font-size: 28px; font-weight: 700; margin: 8px 0 0 0; color: #28a745;">
                        {{ $customer->hoaDons()->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Details -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Chi Tiết</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Địa Chỉ</label>
                        <p style="margin: 6px 0 0 0; color: #333;">{{ optional($customer->thongTinKhachHang)->DiaChiThuongTru ?? $customer->DiaChi ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Sinh</label>
                        <p style="margin: 6px 0 0 0;">{{ optional($customer->thongTinKhachHang)->NgaySinh ? \Carbon\Carbon::parse(optional($customer->thongTinKhachHang)->NgaySinh)->format('d/m/Y') : 'N/A' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Giới Tính</label>
                        @php
                            $__gender = optional($customer->thongTinKhachHang)->GioiTinh ?? $customer->GioiTinh ?? null;
                            if ($__gender === 'Nu' || strtolower($__gender) === 'nu') {
                                $__gender_display = 'Nữ';
                            } elseif ($__gender === 'Nam' || strtolower($__gender) === 'nam') {
                                $__gender_display = 'Nam';
                            } else {
                                $__gender_display = $__gender ?: 'N/A';
                            }
                        @endphp
                        <p style="margin: 6px 0 0 0;">{{ $__gender_display }}</p>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Quốc Tịch</label>
                        <p style="margin: 6px 0 0 0;">{{ optional($customer->thongTinKhachHang)->QuocTich ?? $customer->QuocTich ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">CCCD / MST</label>
                        <p style="margin: 6px 0 0 0;">{{ optional($customer->thongTinKhachHang)->SoGiayTo ?? $customer->CCCD ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Tạo</label>
                        <p style="margin: 6px 0 0 0;">{{ $customer->CreatedAt ? \Carbon\Carbon::parse($customer->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>

                    @if (optional($customer->thongTinKhachHang)->GhiChu || $customer->GhiChu)
                        <div class="col-12">
                            <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ghi Chú</label>
                            <p style="margin: 6px 0 0 0; white-space: pre-line;">{{ optional($customer->thongTinKhachHang)->GhiChu ?? $customer->GhiChu }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contracts List -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 class="mb-0 fw-bold">Hợp Đồng ({{ $customer->hopDongs()->count() }})</h6>
                    <a href="{{ route('contracts.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Thêm Hợp Đồng
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($customer->hopDongs()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th>Mã HĐ</th>
                                    <th>Căn Hộ</th>
                                    <th style="text-align: center;">Ngày Bắt Đầu</th>
                                    <th style="text-align: center;">Ngày Kết Thúc</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->hopDongs as $contract)
                                    <tr>
                                        <td><strong>{{ $contract->MaHopDong ?? 'N/A' }}</strong></td>
                                        <td>{{ $contract->canHo->MaCanHo ?? 'N/A' }}</td>
                                        <td style="text-align: center;">{{ $contract->NgayBatDau ? \Carbon\Carbon::parse($contract->NgayBatDau)->format('d/m/Y') : 'N/A' }}</td>
                                        <td style="text-align: center;">{{ $contract->NgayKetThuc ? \Carbon\Carbon::parse($contract->NgayKetThuc)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-warning" style="color: #333;">{{ $contract->TrangThai ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0" role="alert">
                        <i class="fas fa-info-circle"></i> Chưa có hợp đồng nào.
                    </div>
                @endif
            </div>
        </div>

        <!-- Invoices List -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 class="mb-0 fw-bold">Hóa Đơn ({{ $customer->hoaDons()->count() }})</h6>
                    <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Thêm Hóa Đơn
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($customer->hoaDons()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th>Mã HĐ</th>
                                    <th style="text-align: center;">Ngày Lập</th>
                                    <th style="text-align: right;">Số Tiền</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->hoaDons()->latest()->take(5)->get() as $invoice)
                                    <tr>
                                        <td><strong>{{ $invoice->MaHoaDon ?? 'N/A' }}</strong></td>
                                        <td style="text-align: center;">{{ $invoice->NgayPhatHanh ? \Carbon\Carbon::parse($invoice->NgayPhatHanh)->format('d/m/Y') : 'N/A' }}</td>
                                        <td style="text-align: right; font-weight: 600;">{{ number_format($invoice->SoTien ?? 0, 0, ',', '.') }} đ</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $invoice->TrangThaiThanhToan ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0" role="alert">
                        <i class="fas fa-info-circle"></i> Chưa có hóa đơn nào.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
