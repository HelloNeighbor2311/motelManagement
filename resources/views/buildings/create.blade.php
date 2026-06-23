@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Thêm Tòa Nhà Mới</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('buildings.index') }}">Tòa Nhà</a>
            <span class="separator">/</span>
            <span>Thêm Mới</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Tòa Nhà</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('buildings.store') }}" method="POST">
                    @csrf

                    <!-- Khu Vực -->
                    <div class="form-group">
                        <label for="KhuVucId" class="form-label">
                            Khu Vực <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('KhuVucId') is-invalid @enderror" 
                                id="KhuVucId" name="KhuVucId" required>
                            <option value="">-- Chọn Khu Vực --</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->Id }}" {{ old('KhuVucId') == $area->Id ? 'selected' : '' }}>
                                    {{ $area->TenKhuVuc }}
                                </option>
                            @endforeach
                        </select>
                        @error('KhuVucId')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tên Tòa Nhà -->
                    <div class="form-group">
                        <label for="TenToaNha" class="form-label">
                            Tên Tòa Nhà <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('TenToaNha') is-invalid @enderror" 
                               id="TenToaNha" name="TenToaNha" placeholder="VD: Tòa A, Tòa Trung Tâm"
                               value="{{ old('TenToaNha') }}" required>
                        @error('TenToaNha')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Số Tầng -->
                    <div class="form-group">
                        <label for="SoTang" class="form-label">
                            Số Tầng <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control @error('SoTang') is-invalid @enderror" 
                               id="SoTang" name="SoTang" placeholder="VD: 5" min="1"
                               value="{{ old('SoTang') }}" required>
                        @error('SoTang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="MoTa" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('MoTa') is-invalid @enderror" 
                                  id="MoTa" name="MoTa" rows="4" placeholder="Mô tả chi tiết về tòa nhà...">{{ old('MoTa') }}</textarea>
                        @error('MoTa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu Tòa Nhà
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
                <p><strong>Khu Vực:</strong> Chọn khu vực mà tòa nhà thuộc về (Bắt buộc)</p>
                <p><strong>Tên Tòa Nhà:</strong> Tên duy nhất để phân biệt (Bắt buộc)</p>
                <p><strong>Số Tầng:</strong> Số tầng của tòa nhà (Bắt buộc)</p>
                <p><strong>Mô Tả:</strong> Thông tin bổ sung (Tùy chọn)</p>
                <hr>
                <p><strong>💡 Mẹo:</strong> Sau khi tạo tòa nhà, bạn có thể thêm căn hộ vào tòa nhà này.</p>
            </div>
        </div>
    </div>
</div>

@endsection
