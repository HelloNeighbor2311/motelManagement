@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Thêm Giao Dịch</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('transactions.index') }}">Thu Chi</a>
            <span class="separator">/</span>
            <span>Thêm Giao Dịch</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Thông Tin Giao Dịch</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Loại Giao Dịch -->
                <div class="col-md-6 mb-3">
                    <label for="LoaiGiaoDich" class="form-label">
                        <span class="text-danger">*</span> Loại Giao Dịch
                    </label>
                    <select id="LoaiGiaoDich" name="LoaiGiaoDich" class="form-select @error('LoaiGiaoDich') is-invalid @enderror" required>
                        <option value="">-- Chọn loại giao dịch --</option>
                        <option value="Thu" {{ old('LoaiGiaoDich') == 'Thu' ? 'selected' : '' }}>Thu (Nhập)</option>
                        <option value="Chi" {{ old('LoaiGiaoDich') == 'Chi' ? 'selected' : '' }}>Chi (Xuất)</option>
                    </select>
                    @error('LoaiGiaoDich')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số Tiền -->
                <div class="col-md-6 mb-3">
                    <label for="SoTien" class="form-label">
                        <span class="text-danger">*</span> Số Tiền (đ)
                    </label>
                    <input type="number" id="SoTien" name="SoTien" class="form-control @error('SoTien') is-invalid @enderror" 
                           placeholder="Nhập số tiền" value="{{ old('SoTien') }}" min="0" required>
                    @error('SoTien')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Ngày Giao Dịch -->
                <div class="col-md-6 mb-3">
                    <label for="NgayGiaoDich" class="form-label">
                        <span class="text-danger">*</span> Ngày Giao Dịch
                    </label>
                    <input type="date" id="NgayGiaoDich" name="NgayGiaoDich" class="form-control @error('NgayGiaoDich') is-invalid @enderror" 
                           value="{{ old('NgayGiaoDich', now()->format('Y-m-d')) }}" required>
                    @error('NgayGiaoDich')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tham Chiếu -->
                <div class="col-md-6 mb-3">
                    <label for="ThamChieu" class="form-label">Tham Chiếu (Mã)</label>
                    <input type="text" id="ThamChieu" name="ThamChieu" class="form-control @error('ThamChieu') is-invalid @enderror" 
                           placeholder="VD: INV-001, RCP-001" value="{{ old('ThamChieu') }}" maxlength="100">
                    @error('ThamChieu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Mô Tả -->
                <div class="col-12 mb-3">
                    <label for="MoTa" class="form-label">Mô Tả</label>
                    <textarea id="MoTa" name="MoTa" class="form-control @error('MoTa') is-invalid @enderror" 
                              rows="3" placeholder="Nhập mô tả chi tiết giao dịch" maxlength="500">{{ old('MoTa') }}</textarea>
                    <small class="text-muted">Tối đa 500 ký tự</small>
                    @error('MoTa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Advanced Options -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="Thang" class="form-label">Tháng</label>
                    <input type="number" id="Thang" name="Thang" class="form-control @error('Thang') is-invalid @enderror" 
                           placeholder="VD: 6" value="{{ old('Thang', now()->month) }}" min="1" max="12">
                    @error('Thang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="Nam" class="form-label">Năm</label>
                    <input type="number" id="Nam" name="Nam" class="form-control @error('Nam') is-invalid @enderror" 
                           placeholder="VD: 2026" value="{{ old('Nam', now()->year) }}" min="2000">
                    @error('Nam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="HopDongId" class="form-label">Hợp Đồng (UUID)</label>
                    <input type="text" id="HopDongId" name="HopDongId" class="form-control @error('HopDongId') is-invalid @enderror" 
                           placeholder="Để trống nếu không liên quan" value="{{ old('HopDongId') }}">
                    @error('HopDongId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu Giao Dịch
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-fill tháng/năm khi chọn ngày
    document.getElementById('NgayGiaoDich').addEventListener('change', function() {
        if (this.value) {
            const date = new Date(this.value);
            document.getElementById('Thang').value = date.getMonth() + 1;
            document.getElementById('Nam').value = date.getFullYear();
        }
    });
</script>
@endsection
