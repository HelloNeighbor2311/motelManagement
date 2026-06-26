@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Chỉnh sửa hóa đơn</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('invoices.index') }}">Hóa Đơn</a>
            <span class="separator">/</span>
            <span>Chỉnh Sửa</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('invoices.show', $invoice->Id) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Xem Chi Tiet
        </a>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lai
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-circle"></i> Loi Validation!</strong>
        <ul class="mb-0" style="margin-top: 8px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Thong Tin Hóa Đơn</h6>
            </div>
            <form action="{{ route('invoices.update', $invoice->Id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã Hóa Đơn <span class="text-danger">*</span></label>
                        <input type="text" name="MaHoaDon" class="form-control @error('MaHoaDon') is-invalid @enderror" value="{{ old('MaHoaDon', $invoice->MaHoaDon) }}" required>
                        @error('MaHoaDon')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trang Thái <span class="text-danger">*</span></label>
                        <select name="TrangThaiThanhToan" class="form-select @error('TrangThaiThanhToan') is-invalid @enderror" required>
                            <option value="">-- Chọn Trạng Thái --</option>
                            <option value="ChuaThanhToan" {{ old('TrangThaiThanhToan', $invoice->TrangThaiThanhToan) == 'ChuaThanhToan' ? 'selected' : '' }}>Chua Thanh Toan</option>
                            <option value="DaThanhToan" {{ old('TrangThaiThanhToan', $invoice->TrangThaiThanhToan) == 'DaThanhToan' ? 'selected' : '' }}>Da Thanh Toan</option>
                            <option value="QuaHan" {{ old('TrangThaiThanhToan', $invoice->TrangThaiThanhToan) == 'QuaHan' ? 'selected' : '' }}>Qua Han</option>
                            <option value="HuyBo" {{ old('TrangThaiThanhToan', $invoice->TrangThaiThanhToan) == 'HuyBo' ? 'selected' : '' }}>Huy Bo</option>
                        </select>
                        @error('TrangThaiThanhToan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Khách hàng <span class="text-danger">*</span></label>
                        <select name="KhachHangId" class="form-select @error('KhachHangId') is-invalid @enderror" required>
                            <option value="">-- Chọn Khách Hàng --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->Id }}" {{ old('KhachHangId', $invoice->KhachHangId) == $customer->Id ? 'selected' : '' }}>
                                    {{ $customer->TenKhachHang ?? $customer->HoTen }}
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
                                <option value="{{ $contract->Id }}" {{ old('HopDongId', $invoice->HopDongId) == $contract->Id ? 'selected' : '' }}>
                                    {{ $contract->MaHopDong }}{{ $contract->canHo ? ' - ' . $contract->canHo->MaCanHo : '' }}
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
                        <input type="date" name="NgayPhatHanh" class="form-control @error('NgayPhatHanh') is-invalid @enderror" value="{{ old('NgayPhatHanh', optional($invoice->NgayPhatHanh ? \Carbon\Carbon::parse($invoice->NgayPhatHanh) : null)->format('Y-m-d')) }}" required>
                        @error('NgayPhatHanh')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Dự Kiến <span class="text-danger">*</span></label>
                        <input type="date" name="NgayDenHan" class="form-control @error('NgayDenHan') is-invalid @enderror" value="{{ old('NgayDenHan', optional($invoice->NgayDenHan ? \Carbon\Carbon::parse($invoice->NgayDenHan) : null)->format('Y-m-d')) }}" required>
                        @error('NgayDenHan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Tiền (d) <span class="text-danger">*</span></label>
                        <input type="number" name="SoTien" class="form-control @error('SoTien') is-invalid @enderror" value="{{ old('SoTien', $invoice->SoTien) }}" step="1000" min="0" required>
                        @error('SoTien')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tháng</label>
                        <input type="number" name="Thang" class="form-control @error('Thang') is-invalid @enderror" value="{{ old('Thang', $invoice->Thang) }}" min="1" max="12">
                        @error('Thang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Năm</label>
                        <input type="number" name="Nam" class="form-control @error('Nam') is-invalid @enderror" value="{{ old('Nam', $invoice->Nam) }}" min="2000">
                        @error('Nam')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại Hóa Đơn</label>
                    <select name="LoaiHoaDon" class="form-select @error('LoaiHoaDon') is-invalid @enderror">
                        <option value="">-- Chọn Loại Hóa Đơn --</option>
                        <option value="TienThue" {{ old('LoaiHoaDon', $invoice->LoaiHoaDon) == 'TienThue' ? 'selected' : '' }}>Tiền Thuế</option>
                        <option value="TienDatCoc" {{ old('LoaiHoaDon', $invoice->LoaiHoaDon) == 'TienDatCoc' ? 'selected' : '' }}>Tiền Đặt Cọc</option>
                        <option value="DichVu" {{ old('LoaiHoaDon', $invoice->LoaiHoaDon) == 'DichVu' ? 'selected' : '' }}>ịch Vụ</option>
                        <option value="PhatSinhKhac" {{ old('LoaiHoaDon', $invoice->LoaiHoaDon) == 'PhatSinhKhac' ? 'selected' : '' }}>Phát Sinh Khác</option>
                    </select>
                    @error('LoaiHoaDon')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="GhiChu" class="form-control @error('GhiChu') is-invalid @enderror" rows="3">{{ old('GhiChu', $invoice->MoTa) }}</textarea>
                    @error('GhiChu')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập Nhật Hóa Đơn
                    </button>
                    <a href="{{ route('invoices.show', $invoice->Id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Tóm Tắt</h6>
            </div>
            <div class="card-body" style="font-size: 14px;">
                <div class="mb-3">
                    <strong>Mã hóa đơn:</strong>
                    <p class="mb-0">{{ $invoice->MaHoaDon }}</p>
                </div>
                <div class="mb-3">
                    <strong>Số tiền hiện tại:</strong>
                    <p class="mb-0">{{ number_format($invoice->SoTien, 0, ',', '.') }} d</p>
                </div>
                <div>
                    <strong>Trạng thái:</strong>
                    <p class="mb-0">{{ $invoice->TrangThaiThanhToan }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
