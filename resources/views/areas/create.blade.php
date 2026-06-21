@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Thêm Khu Vực Mới</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('areas.index') }}">Khu Vực</a>
            <span class="separator">/</span>
            <span>Thêm Mới</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Khu Vực</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('areas.store') }}" method="POST">
                    @csrf

                    <!-- Tên Khu Vực -->
                    <div class="form-group">
                        <label for="TenKhuVuc" class="form-label">
                            Tên Khu Vực <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('TenKhuVuc') is-invalid @enderror" 
                               id="TenKhuVuc" name="TenKhuVuc" placeholder="VD: Khu A, Khu Trung Tâm"
                               value="{{ old('TenKhuVuc') }}" required>
                        @error('TenKhuVuc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Địa Chỉ -->
                    <div class="form-group">
                        <label for="DiaChi" class="form-label">Địa Chỉ</label>
                        <input type="text" class="form-control @error('DiaChi') is-invalid @enderror" 
                               id="DiaChi" name="DiaChi" placeholder="VD: 123 Đường ABC, Quận 1, TP.HCM"
                               value="{{ old('DiaChi') }}">
                        @error('DiaChi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="MoTa" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('MoTa') is-invalid @enderror" 
                                  id="MoTa" name="MoTa" rows="4" placeholder="Mô tả chi tiết về khu vực..."
                                  value="{{ old('MoTa') }}"></textarea>
                        @error('MoTa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <a href="{{ route('areas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu Khu Vực
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Box -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-lightbulb" style="color: #FFC107;"></i> Hướng Dẫn
                </h6>
            </div>
            <div class="card-body" style="font-size: 13px;">
                <p><strong>Tên Khu Vực:</strong> Tên duy nhất để phân biệt các khu vực (Bắt buộc)</p>
                <p><strong>Địa Chỉ:</strong> Địa chỉ chi tiết của khu vực (Tùy chọn)</p>
                <p><strong>Mô Tả:</strong> Thông tin bổ sung, đặc điểm riêng (Tùy chọn)</p>
                <hr>
                <p><strong>💡 Mẹo:</strong> Sau khi tạo khu vực, bạn có thể thêm tòa nhà vào khu vực này.</p>
            </div>
        </div>
    </div>
</div>

@endsection
