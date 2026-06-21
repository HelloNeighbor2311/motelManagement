@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Thêm Hợp Đồng Mới</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('contracts.index') }}">Hợp Đồng</a>
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
                <h6 class="mb-0 fw-bold">Thông Tin Hợp Đồng</h6>
            </div>
            <form action="{{ route('contracts.store') }}" method="POST" class="card-body">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã Hợp Đồng <span class="text-danger">*</span></label>
                        <input type="text" name="MaHopDong" class="form-control @error('MaHopDong') is-invalid @enderror" placeholder="VD: HD001" value="{{ old('MaHopDong') }}" required>
                        @error('MaHopDong')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select name="TrangThai" class="form-select @error('TrangThai') is-invalid @enderror" required>
                            <option value="">-- Chọn Trạng Thái --</option>
                            <option value="active" {{ old('TrangThai', 'active') == 'active' ? 'selected' : '' }}>✅ Đang Hoạt Động</option>
                            <option value="expired" {{ old('TrangThai') == 'expired' ? 'selected' : '' }}>⏰ Hết Hạn</option>
                            <option value="cancelled" {{ old('TrangThai') == 'cancelled' ? 'selected' : '' }}>❌ Đã Hủy</option>
                        </select>
                        @error('TrangThai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Khách Hàng <span class="text-danger">*</span></label>
                        <select name="KhachHangId" class="form-select @error('KhachHangId') is-invalid @enderror" required>
                            <option value="">-- Chọn Khách Hàng --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->Id }}" {{ old('KhachHangId') == $customer->Id ? 'selected' : '' }}>
                                    {{ $customer->TenKhachHang }} ({{ $customer->SoDienThoai }})
                                </option>
                            @endforeach
                        </select>
                        @error('KhachHangId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Căn Hộ <span class="text-danger">*</span></label>
                        <select name="CanHoId" class="form-select @error('CanHoId') is-invalid @enderror" required>
                            <option value="">-- Chọn Căn Hộ --</option>
                            @foreach ($apartments as $apartment)
                                <option value="{{ $apartment->Id }}" {{ old('CanHoId') == $apartment->Id ? 'selected' : '' }}>
                                    {{ $apartment->MaCanHo }} ({{ number_format($apartment->GiaThue, 0, ',', '.') }} đ/tháng)
                                </option>
                            @endforeach
                        </select>
                        @error('CanHoId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Bắt Đầu <span class="text-danger">*</span></label>
                        <input type="date" name="NgayBatDau" class="form-control @error('NgayBatDau') is-invalid @enderror" value="{{ old('NgayBatDau') }}" required>
                        @error('NgayBatDau')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Kết Thúc <span class="text-danger">*</span></label>
                        <input type="date" name="NgayKetThuc" class="form-control @error('NgayKetThuc') is-invalid @enderror" value="{{ old('NgayKetThuc') }}" required>
                        @error('NgayKetThuc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá Thuê (đ/tháng) <span class="text-danger">*</span></label>
                        <input type="number" name="GiaThue" class="form-control @error('GiaThue') is-invalid @enderror" placeholder="VD: 3000000" value="{{ old('GiaThue') }}" step="1000" min="0" required>
                        @error('GiaThue')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tiền Đặt Cọc (đ) <span class="text-danger">*</span></label>
                        <input type="number" name="TienDatCoc" class="form-control @error('TienDatCoc') is-invalid @enderror" placeholder="VD: 3000000" value="{{ old('TienDatCoc') }}" step="1000" min="0" required>
                        @error('TienDatCoc')
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
                        <i class="fas fa-save"></i> Lưu Hợp Đồng
                    </button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
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
                    <strong>📋 Mã Hợp Đồng:</strong>
                    <p>Mã định danh duy nhất, VD: HD001</p>
                </div>
                <div class="mb-3">
                    <strong>📅 Ngày Bắt Đầu/Kết Thúc:</strong>
                    <p>Thời hạn hợp đồng thuê</p>
                </div>
                <div class="mb-3">
                    <strong>💰 Giá Thuê:</strong>
                    <p>Giá thuê hàng tháng (đ)</p>
                </div>
                <div>
                    <strong>💵 Tiền Đặt Cọc:</strong>
                    <p>Tiền cọc ban đầu (thường = giá thuê)</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
