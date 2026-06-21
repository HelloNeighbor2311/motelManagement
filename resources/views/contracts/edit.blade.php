@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Chỉnh Sửa Hợp Đồng</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('contracts.index') }}">Hợp Đồng</a>
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
                <h6 class="mb-0 fw-bold">Thông Tin Hợp Đồng</h6>
            </div>
            <form action="{{ route('contracts.update', $contract->Id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã Hợp Đồng <span class="text-danger">*</span></label>
                        <input type="text" name="MaHopDong" class="form-control @error('MaHopDong') is-invalid @enderror" placeholder="VD: HD001" value="{{ old('MaHopDong', $contract->MaHopDong) }}" required>
                        @error('MaHopDong')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select name="TrangThai" class="form-select @error('TrangThai') is-invalid @enderror" required>
                            <option value="">-- Chọn Trạng Thái --</option>
                            <option value="active" {{ old('TrangThai', $contract->TrangThai) == 'active' ? 'selected' : '' }}>✅ Đang Hoạt Động</option>
                            <option value="expired" {{ old('TrangThai', $contract->TrangThai) == 'expired' ? 'selected' : '' }}>⏰ Hết Hạn</option>
                            <option value="cancelled" {{ old('TrangThai', $contract->TrangThai) == 'cancelled' ? 'selected' : '' }}>❌ Đã Hủy</option>
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
                                <option value="{{ $customer->Id }}" {{ old('KhachHangId', $contract->KhachHangId) == $customer->Id ? 'selected' : '' }}>
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
                                <option value="{{ $apartment->Id }}" {{ old('CanHoId', $contract->CanHoId) == $apartment->Id ? 'selected' : '' }}>
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
                        <input type="date" name="NgayBatDau" class="form-control @error('NgayBatDau') is-invalid @enderror" value="{{ old('NgayBatDau', \Carbon\Carbon::parse($contract->NgayBatDau)->format('Y-m-d')) }}" required>
                        @error('NgayBatDau')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Kết Thúc <span class="text-danger">*</span></label>
                        <input type="date" name="NgayKetThuc" class="form-control @error('NgayKetThuc') is-invalid @enderror" value="{{ old('NgayKetThuc', \Carbon\Carbon::parse($contract->NgayKetThuc)->format('Y-m-d')) }}" required>
                        @error('NgayKetThuc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá Thuê (đ/tháng) <span class="text-danger">*</span></label>
                        <input type="number" name="GiaThue" class="form-control @error('GiaThue') is-invalid @enderror" placeholder="VD: 3000000" value="{{ old('GiaThue', $contract->GiaThue) }}" step="1000" min="0" required>
                        @error('GiaThue')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tiền Đặt Cọc (đ) <span class="text-danger">*</span></label>
                        <input type="number" name="TienDatCoc" class="form-control @error('TienDatCoc') is-invalid @enderror" placeholder="VD: 3000000" value="{{ old('TienDatCoc', $contract->TienDatCoc) }}" step="1000" min="0" required>
                        @error('TienDatCoc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="GhiChu" class="form-control @error('GhiChu') is-invalid @enderror" placeholder="Ghi chú thêm..." rows="3">{{ old('GhiChu', $contract->GhiChu) }}</textarea>
                    @error('GhiChu')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập Nhật Hợp Đồng
                    </button>
                    <a href="{{ route('contracts.show', $contract->Id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Thông Tin Hiện Tại</h6>
            </div>
            <div class="card-body" style="font-size: 14px;">
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Trạng Thái</label>
                    <p style="margin: 4px 0 0 0;">
                        <span class="badge {{ $contract->TrangThai == 'active' ? 'bg-success' : ($contract->TrangThai == 'expired' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $contract->TrangThai == 'active' ? '✅ Đang Hoạt Động' : ($contract->TrangThai == 'expired' ? '⏰ Hết Hạn' : '❌ Đã Hủy') }}
                        </span>
                    </p>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Khách Hàng</label>
                    <p style="margin: 4px 0 0 0;">{{ $contract->khachHang->TenKhachHang ?? 'N/A' }}</p>
                </div>
                <div>
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Ngày Tạo</label>
                    <p style="margin: 4px 0 0 0;">{{ $contract->CreatedAt ? \Carbon\Carbon::parse($contract->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
