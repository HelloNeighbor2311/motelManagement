@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $contract->MaHopDong }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('contracts.index') }}">Hợp Đồng</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('contracts.edit', $contract->Id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Contract Info -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Hợp Đồng</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Mã Hợp Đồng</label>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600;">{{ $contract->MaHopDong }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Trạng Thái</label>
                    <p style="margin: 4px 0 0 0;">
                        <span class="badge {{ $contract->TrangThai == 'active' ? 'bg-success' : ($contract->TrangThai == 'expired' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $contract->TrangThai == 'active' ? '✅ Đang Hoạt Động' : ($contract->TrangThai == 'expired' ? '⏰ Hết Hạn' : '❌ Đã Hủy') }}
                        </span>
                    </p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Bắt Đầu</label>
                    <p style="margin: 4px 0 0 0;">{{ $contract->NgayBatDau ? \Carbon\Carbon::parse($contract->NgayBatDau)->format('d/m/Y') : 'N/A' }}</p>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Kết Thúc</label>
                    <p style="margin: 4px 0 0 0;">{{ $contract->NgayKetThuc ? \Carbon\Carbon::parse($contract->NgayKetThuc)->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Financial Info -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Tài Chính</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e0e0e0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Giá Thuê/Tháng</label>
                    <p style="margin: 4px 0 0 0; font-size: 18px; font-weight: 600; color: #28a745;">{{ number_format($contract->GiaThue, 0, ',', '.') }} đ</p>
                </div>

                <div>
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Tiền Đặt Cọc</label>
                    <p style="margin: 4px 0 0 0; font-size: 18px; font-weight: 600; color: #0066cc;">{{ number_format($contract->TienDatCoc, 0, ',', '.') }} đ</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Customer & Apartment -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                        <h6 class="mb-0 fw-bold">👤 Khách Hàng</h6>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Tên</label>
                            <p style="margin: 4px 0 0 0;">{{ $contract->khachHang->TenKhachHang ?? 'N/A' }}</p>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Số ĐT</label>
                            <p style="margin: 4px 0 0 0;">
                                <a href="tel:{{ $contract->khachHang->SoDienThoai }}" style="color: #0066cc;">{{ $contract->khachHang->SoDienThoai ?? 'N/A' }}</a>
                            </p>
                        </div>

                        <div>
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Email</label>
                            <p style="margin: 4px 0 0 0;">
                                <a href="mailto:{{ $contract->khachHang->Email }}" style="color: #0066cc;">{{ $contract->khachHang->Email ?? 'N/A' }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                        <h6 class="mb-0 fw-bold">🏢 Căn Hộ</h6>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Mã Căn</label>
                            <p style="margin: 4px 0 0 0;">{{ $contract->canHo->MaCanHo ?? 'N/A' }}</p>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Tòa Nhà</label>
                            <p style="margin: 4px 0 0 0;">{{ $contract->canHo->toaNha->TenToaNha ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Tầng / Diện Tích</label>
                            <p style="margin: 4px 0 0 0;">{{ $contract->canHo->Tang ?? 'N/A' }} / {{ $contract->canHo->DienTich ?? 'N/A' }} m²</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Chi Tiết</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" style="margin-bottom: 16px;">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Tạo</label>
                        <p style="margin: 4px 0 0 0;">{{ $contract->CreatedAt ? \Carbon\Carbon::parse($contract->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 16px;">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Thời Hạn</label>
                        <p style="margin: 4px 0 0 0;">
                            @if ($contract->NgayBatDau && $contract->NgayKetThuc)
                                {{ \Carbon\Carbon::parse($contract->NgayBatDau)->diffInMonths(\Carbon\Carbon::parse($contract->NgayKetThuc)) + 1 }} tháng
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>

                @if ($contract->GhiChu)
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e0e0e0;">
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ghi Chú</label>
                        <p style="margin: 4px 0 0 0;">{{ $contract->GhiChu }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
