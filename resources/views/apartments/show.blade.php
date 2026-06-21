@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $apartment->MaCanHo }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('apartments.index') }}">Căn Hộ</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('apartments.edit', $apartment->Id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('apartments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Apartment Info -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Căn Hộ</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Mã Căn Hộ</label>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600;">{{ $apartment->MaCanHo }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Tòa Nhà</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->toaNha->TenToaNha ?? 'N/A' }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Tầng</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->Tang }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Diện Tích</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->DienTich }} m²</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Số Phòng</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->SoPhong }}</p>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Giá Thuê (Tháng)</label>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600; color: #28a745;">{{ number_format($apartment->GiaThue, 0, ',', '.') }} đ</p>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Trạng Thái</h6>
            </div>
            <div class="card-body" style="text-align: center;">
                <p style="margin: 0 0 8px 0; font-size: 12px; color: #6C757D; text-transform: uppercase; font-weight: 600;">Hiện Tại</p>
                <span class="badge {{ $apartment->status_badge }}" style="font-size: 14px; padding: 8px 12px;">{{ $apartment->status_display }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Contracts List -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 class="mb-0 fw-bold">Hợp Đồng Liên Quan</h6>
                    <a href="{{ route('contracts.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Thêm Hợp Đồng
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($apartment->hopDongs()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th>Mã Hợp Đồng</th>
                                    <th>Khách Hàng</th>
                                    <th style="text-align: center;">Ngày Bắt Đầu</th>
                                    <th style="text-align: center;">Ngày Kết Thúc</th>
                                    <th>Trạng Thái</th>
                                    <th style="text-align: center;">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apartment->hopDongs as $contract)
                                    <tr>
                                        <td><strong>{{ $contract->MaHopDong ?? 'N/A' }}</strong></td>
                                        <td>{{ $contract->khachHang->TenKhachHang ?? 'N/A' }}</td>
                                        <td style="text-align: center;">{{ $contract->NgayBatDau ? \Carbon\Carbon::parse($contract->NgayBatDau)->format('d/m/Y') : 'N/A' }}</td>
                                        <td style="text-align: center;">{{ $contract->NgayKetThuc ? \Carbon\Carbon::parse($contract->NgayKetThuc)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge" style="background-color: #ffc107; color: #333;">{{ $contract->TrangThai ?? 'N/A' }}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('contracts.show', $contract->Id ?? '#') }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0" role="alert">
                        <i class="fas fa-info-circle"></i> Chưa có hợp đồng nào cho căn hộ này.
                        <a href="{{ route('contracts.create') }}">Thêm hợp đồng</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Timeline/Details -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Lịch Sử & Chi Tiết</h6>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Tạo</label>
                        <p style="margin: 4px 0 0 0;">{{ $apartment->CreatedAt ? \Carbon\Carbon::parse($apartment->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Hợp Đồng Đang Hoạt Động</label>
                        <p style="margin: 4px 0 0 0; font-size: 18px; font-weight: 600; color: #0066cc;">{{ $apartment->hopDongs()->where('TrangThai', 'active')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-trong {
        background-color: #28a745 !important;
        color: white !important;
    }
    .badge-dang-thue {
        background-color: #ffc107 !important;
        color: #333 !important;
    }
    .badge-bao-tri {
        background-color: #ff6b6b !important;
        color: white !important;
    }
</style>

@endsection
