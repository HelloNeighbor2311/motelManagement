@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Thêm Khách Hàng Mới</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('customers.index') }}">Khách Hàng</a>
            <span class="separator">/</span>
            <span>Thêm Mới</span>
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
                <h6 class="mb-0 fw-bold">Thông Tin Khách Hàng</h6>
            </div>
            <form action="{{ route('customers.store') }}" method="POST" class="card-body">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên Khách Hàng <span class="text-danger">*</span></label>
                        <input type="text" name="TenKhachHang" class="form-control @error('TenKhachHang') is-invalid @enderror" placeholder="VD: Nguyễn Văn A" value="{{ old('TenKhachHang') }}" required>
                        @error('TenKhachHang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Loại Khách <span class="text-danger">*</span></label>
                        <select name="LoaiKhach" class="form-select @error('LoaiKhach') is-invalid @enderror" required>
                            <option value="">-- Chọn Loại --</option>
                            <option value="Nhan" {{ old('LoaiKhach') == 'Nhan' ? 'selected' : '' }}>👤 Cá Nhân</option>
                            <option value="Doanh" {{ old('LoaiKhach') == 'Doanh' ? 'selected' : '' }}>🏢 Doanh Nghiệp</option>
                        </select>
                        @error('LoaiKhach')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                        <input type="text" name="SoDienThoai" class="form-control @error('SoDienThoai') is-invalid @enderror" placeholder="VD: 0912345678" value="{{ old('SoDienThoai') }}" required>
                        @error('SoDienThoai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="Email" class="form-control @error('Email') is-invalid @enderror" placeholder="VD: abc@gmail.com" value="{{ old('Email') }}" required>
                        @error('Email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CCCD/MST <span class="text-danger">*</span></label>
                        <input type="text" name="CCCD" class="form-control @error('CCCD') is-invalid @enderror" placeholder="VD: 123456789" value="{{ old('CCCD') }}" required>
                        @error('CCCD')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa Chỉ <span class="text-danger">*</span></label>
                        <input type="text" name="DiaChi" class="form-control @error('DiaChi') is-invalid @enderror" placeholder="VD: 123 Đường ABC, Thành Phố" value="{{ old('DiaChi') }}" required>
                        @error('DiaChi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ngày Sinh</label>
                        <input type="date" name="NgaySinh" class="form-control @error('NgaySinh') is-invalid @enderror" value="{{ old('NgaySinh') }}">
                        @error('NgaySinh')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giới Tính</label>
                        <select name="GioiTinh" class="form-select @error('GioiTinh') is-invalid @enderror">
                            <option value="">-- Chọn --</option>
                            <option value="Nam" {{ old('GioiTinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nu" {{ old('GioiTinh') == 'Nu' ? 'selected' : '' }}>Nữ</option>
                        </select>
                        @error('GioiTinh')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quốc Tịch</label>
                        <input type="text" name="QuocTich" class="form-control @error('QuocTich') is-invalid @enderror" placeholder="VD: Việt Nam" value="{{ old('QuocTich') }}">
                        @error('QuocTich')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="GhiChu" class="form-control @error('GhiChu') is-invalid @enderror" placeholder="Ghi chú thêm..." rows="3">{{ old('GhiChu') }}</textarea>
                    @error('GhiChu')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu Khách Hàng
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Hướng Dẫn</h6>
            </div>
            <div class="card-body" style="font-size: 14px;">
                <div class="mb-3">
                    <strong>👤 Loại Khách:</strong>
                    <p>Chọn Cá Nhân hoặc Doanh Nghiệp</p>
                </div>
                <div class="mb-3">
                    <strong>📋 CCCD/MST:</strong>
                    <p>Chứng minh thư hoặc Mã số thuế</p>
                </div>
                <div class="mb-3">
                    <strong>📍 Địa Chỉ:</strong>
                    <p>Địa chỉ liên hệ hoặc thường trú</p>
                </div>
                <div>
                    <strong>📝 Ghi Chú:</strong>
                    <p>Thêm thông tin bổ sung nếu cần</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
