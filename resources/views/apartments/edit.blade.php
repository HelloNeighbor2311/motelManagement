@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Chỉnh Sửa Căn Hộ</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('apartments.index') }}">Căn Hộ</a>
            <span class="separator">/</span>
            <span>Chỉnh Sửa</span>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-circle"></i> Lỗi Validation!</strong>
        <ul class="mb-0" style="margin-top: 8px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Thông Tin Căn Hộ</h6>
            </div>
            <form action="{{ route('apartments.update', $apartment->Id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tòa Nhà <span class="text-danger">*</span></label>
                        <select name="ToaNhaId" class="form-select @error('ToaNhaId') is-invalid @enderror" required>
                            <option value="">-- Chọn Tòa Nhà --</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->Id }}" {{ old('ToaNhaId', $apartment->ToaNhaId) == $building->Id ? 'selected' : '' }}>
                                    {{ $building->TenToaNha }}
                                </option>
                            @endforeach
                        </select>
                        @error('ToaNhaId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã Căn Hộ <span class="text-danger">*</span></label>
                        <input type="text" name="MaCanHo" class="form-control @error('MaCanHo') is-invalid @enderror" placeholder="VD: A101" value="{{ old('MaCanHo', $apartment->MaCanHo) }}" required>
                        @error('MaCanHo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tầng <span class="text-danger">*</span></label>
                        <input type="number" name="Tang" class="form-control @error('Tang') is-invalid @enderror" placeholder="VD: 1" value="{{ old('Tang', $apartment->Tang) }}" min="1" required>
                        @error('Tang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Diện Tích (m²) <span class="text-danger">*</span></label>
                        <input type="number" name="DienTich" class="form-control @error('DienTich') is-invalid @enderror" placeholder="VD: 30" value="{{ old('DienTich', $apartment->DienTich) }}" step="0.01" min="0.1" required>
                        @error('DienTich')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Số Phòng <span class="text-danger">*</span></label>
                        <input type="number" name="SoPhong" class="form-control @error('SoPhong') is-invalid @enderror" placeholder="VD: 1" value="{{ old('SoPhong', $apartment->SoPhong) }}" min="1" required>
                        @error('SoPhong')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Giá Thuê (đ) <span class="text-danger">*</span></label>
                        <input type="number" name="GiaThue" class="form-control @error('GiaThue') is-invalid @enderror" placeholder="VD: 3000000" value="{{ old('GiaThue', $apartment->GiaThue) }}" step="1000" min="0" required>
                        @error('GiaThue')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="TrangThai" id="statusTrong" value="Trong" {{ old('TrangThai', $apartment->TrangThai) == 'Trong' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="statusTrong">✅ Trống</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="TrangThai" id="statusDangThue" value="DangThue" {{ old('TrangThai', $apartment->TrangThai) == 'DangThue' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusDangThue">⏳ Đang Thuê</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="TrangThai" id="statusBaoTri" value="BaoTri" {{ old('TrangThai', $apartment->TrangThai) == 'BaoTri' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusBaoTri">🔧 Bảo Trì</label>
                            </div>
                        </div>
                    </div>
                    @error('TrangThai')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập Nhật Căn Hộ
                    </button>
                    <a href="{{ route('apartments.show', $apartment->Id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Thông Tin Căn Hộ</h6>
            </div>
            <div class="card-body" style="font-size: 14px;">
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Mã Căn</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->MaCanHo }}</p>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Tòa Nhà</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->toaNha->TenToaNha ?? 'N/A' }}</p>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Trạng Thái Hiện Tại</label>
                    <p style="margin: 4px 0 0 0;">
                        <span class="badge {{ $apartment->status_badge }}">{{ $apartment->status_display }}</span>
                    </p>
                </div>
                <div>
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Ngày Tạo</label>
                    <p style="margin: 4px 0 0 0;">{{ $apartment->CreatedAt ? \Carbon\Carbon::parse($apartment->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
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
