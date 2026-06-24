@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Tạo Hóa Đơn Mới</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('invoices.index') }}">Hóa Đơn</a>
            <span class="separator">/</span>
            <span>Tạo Mới</span>
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
                <h6 class="mb-0 fw-bold">Thông Tin Hóa Đơn</h6>
            </div>
            <form action="{{ route('invoices.store') }}" method="POST" class="card-body">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã Hóa Đơn <span class="text-danger">*</span></label>
                        <input type="text" name="MaHoaDon" class="form-control @error('MaHoaDon') is-invalid @enderror" placeholder="VD: HD001" value="{{ old('MaHoaDon') }}" required>
                        @error('MaHoaDon')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select name="TrangThaiThanhToan" class="form-select @error('TrangThaiThanhToan') is-invalid @enderror" required>
                            <option value="">-- Chọn Trạng Thái --</option>
                            <option value="ChuaThanhToan" {{ old('TrangThaiThanhToan', 'ChuaThanhToan') == 'ChuaThanhToan' ? 'selected' : '' }}>⏳ Chưa Thanh Toán</option>
                            <option value="DaThanhToan" {{ old('TrangThaiThanhToan') == 'DaThanhToan' ? 'selected' : '' }}>✅ Đã Thanh Toán</option>
                            <option value="QuaHan" {{ old('TrangThaiThanhToan') == 'QuaHan' ? 'selected' : '' }}>❌ Quá Hạn</option>
                        </select>
                        @error('TrangThaiThanhToan')
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
                                    {{ $customer->TenKhachHang }}
                                </option>
                            @endforeach
                        </select>
                        @error('KhachHangId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hợp Đồng</label>
                        <select name="HopDongId" class="form-select @error('HopDongId') is-invalid @enderror">
                            <option value="">-- Chọn Hợp Đồng (Tùy Chọn) --</option>
                            @foreach ($contracts as $contract)
                                <option value="{{ $contract->Id }}" {{ old('HopDongId') == $contract->Id ? 'selected' : '' }}>
                                    {{ $contract->MaHopDong }} - {{ $contract->canHo->MaCanHo }}
                                </option>
                            @endforeach
                        </select>
                        @error('HopDongId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Lập <span class="text-danger">*</span></label>
                        <input type="date" name="NgayPhatHanh" class="form-control @error('NgayPhatHanh') is-invalid @enderror" value="{{ old('NgayPhatHanh', now()->format('Y-m-d')) }}" required>
                        @error('NgayPhatHanh')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Dự Kiến <span class="text-danger">*</span></label>
                        <input type="date" name="NgayDenHan" class="form-control @error('NgayDenHan') is-invalid @enderror" value="{{ old('NgayDenHan', now()->addMonth()->format('Y-m-d')) }}" required>
                        @error('NgayDenHan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số Tiền (đ) <span class="text-danger">*</span></label>
                    <input type="number" name="SoTien" class="form-control @error('SoTien') is-invalid @enderror" placeholder="VD: 3000000" value="{{ old('SoTien') }}" step="1000" min="0" required>
                    @error('SoTien')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
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
                        <i class="fas fa-save"></i> Lưu Hóa Đơn
                    </button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
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
                    <strong>📋 Mã Hóa Đơn:</strong>
                    <p>Mã định danh duy nhất</p>
                </div>
                <div class="mb-3">
                    <strong>👤 Khách Hàng:</strong>
                    <p>Chọn khách hàng cần lập hóa đơn</p>
                </div>
                <div class="mb-3">
                    <strong>📅 Ngày Dự Kiến:</strong>
                    <p>Hạn thanh toán hóa đơn</p>
                </div>
                <div>
                    <strong>💰 Số Tiền:</strong>
                    <p>Tổng giá trị hóa đơn</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
