@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $building->TenToaNha }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('buildings.index') }}">Tòa Nhà</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('buildings.edit', $building->Id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Building Info -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Tòa Nhà</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Tên Tòa Nhà</label>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600;">{{ $building->TenToaNha }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Khu Vực</label>
                    <p style="margin: 4px 0 0 0;">{{ $building->khuVuc->TenKhuVuc ?? 'N/A' }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Số Tầng</label>
                    <p style="margin: 4px 0 0 0;">{{ $building->SoTang }}</p>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Tạo</label>
                    <p style="margin: 4px 0 0 0;">{{ $building->CreatedAt ? \Carbon\Carbon::parse($building->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thống Kê</h6>
            </div>
            <div class="card-body">
                <div style="text-align: center;">
                    <p style="font-size: 12px; color: #6C757D; margin: 0; text-transform: uppercase; font-weight: 600;">Tổng Căn Hộ</p>
                    <p style="font-size: 32px; font-weight: 700; margin: 8px 0 0 0; color: #28A745;">
                        {{ $building->canHos()->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Apartments List -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 class="mb-0 fw-bold">Danh Sách Căn Hộ ({{ $building->canHos()->count() }} cái)</h6>
                    <a href="{{ route('apartments.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Thêm Căn
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($building->canHos()->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th>Mã Căn</th>
                                    <th style="text-align: center;">Tầng</th>
                                    <th style="text-align: center;">Diện Tích</th>
                                    <th style="text-align: center;">Giá Thuê</th>
                                    <th>Trạng Thái</th>
                                    <th style="text-align: center;">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($building->canHos as $apartment)
                                    <tr>
                                        <td><strong>{{ $apartment->MaCanHo }}</strong></td>
                                        <td style="text-align: center;">{{ $apartment->Tang }}</td>
                                        <td style="text-align: center;">{{ $apartment->DienTich }} m²</td>
                                        <td style="text-align: center;">{{ number_format($apartment->GiaThue, 0, ',', '.') }} đ</td>
                                        <td>
                                            <span class="badge {{ $apartment->status_badge }}">{{ $apartment->status_display }}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('apartments.show', $apartment->Id) }}" class="btn btn-sm btn-info table-action-btn" title="Xem Chi Tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('apartments.edit', $apartment->Id) }}" class="btn btn-sm btn-warning table-action-btn" title="Chỉnh Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info m-0" role="alert">
                        <i class="fas fa-info-circle"></i> Chưa có căn hộ trong tòa nhà này.
                        <a href="{{ route('apartments.create') }}">Thêm căn hộ</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
