@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $area->TenKhuVuc }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('areas.index') }}">Khu Vực</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('areas.edit', $area->Id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Area Info -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Khu Vực</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Tên Khu Vực</label>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600;">{{ $area->TenKhuVuc }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Địa Chỉ</label>
                    <p style="margin: 4px 0 0 0;">{{ $area->DiaChi ?? 'N/A' }}</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Mô Tả</label>
                    <p style="margin: 4px 0 0 0; white-space: pre-wrap;">{{ $area->MoTa ?? 'Không có mô tả' }}</p>
                </div>

                <div style="margin-bottom: 0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 12px; text-transform: uppercase;">Ngày Tạo</label>
                    <p style="margin: 4px 0 0 0;">{{ $area->CreatedAt ? \Carbon\Carbon::parse($area->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thống Kê</h6>
            </div>
            <div class="card-body">
                <div style="text-align: center; margin-bottom: 16px;">
                    <p style="font-size: 12px; color: #6C757D; margin: 0; text-transform: uppercase; font-weight: 600;">Tòa Nhà</p>
                    <p style="font-size: 32px; font-weight: 700; margin: 8px 0 0 0; color: #0066CC;">{{ $buildings->count() }}</p>
                </div>
                <hr>
                <div style="text-align: center;">
                    <p style="font-size: 12px; color: #6C757D; margin: 0; text-transform: uppercase; font-weight: 600;">Tổng Căn Hộ</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 8px 0 0 0; color: #28A745;">
                        {{ $buildings->sum(function ($b) { return $b->canHos()->count(); }) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Buildings List -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 class="mb-0 fw-bold">Danh Sách Tòa Nhà ({{ $buildings->count() }} cái)</h6>
                    <a href="{{ route('buildings.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Thêm Tòa Nhà
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($buildings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th>Tên Tòa Nhà</th>
                                    <th style="text-align: center;">Số Tầng</th>
                                    <th style="text-align: center;">Căn Hộ</th>
                                    <th style="text-align: center;">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buildings as $building)
                                    <tr>
                                        <td><strong>{{ $building->TenToaNha }}</strong></td>
                                        <td style="text-align: center;">{{ $building->SoTang }} tầng</td>
                                        <td style="text-align: center;">
                                            <span class="badge badge-info">{{ $building->canHos()->count() }}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('buildings.show', $building->Id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('buildings.edit', $building->Id) }}" class="btn btn-sm btn-warning">
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
                        <i class="fas fa-info-circle"></i> Chưa có tòa nhà trong khu vực này.
                        <a href="{{ route('buildings.create') }}">Thêm tòa nhà</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
