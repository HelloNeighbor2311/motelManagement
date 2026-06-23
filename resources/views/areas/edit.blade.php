@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Chỉnh Sửa Khu Vực</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('areas.index') }}">Khu Vực</a>
            <span class="separator">/</span>
            <span>Chỉnh Sửa</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Khu Vực: {{ $area->TenKhuVuc }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('areas.update', $area->Id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Tên Khu Vực -->
                    <div class="form-group">
                        <label for="TenKhuVuc" class="form-label">
                            Tên Khu Vực <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('TenKhuVuc') is-invalid @enderror" 
                               id="TenKhuVuc" name="TenKhuVuc" 
                               value="{{ old('TenKhuVuc', $area->TenKhuVuc) }}" required>
                        @error('TenKhuVuc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Địa Chỉ -->
                    <div class="form-group">
                        <label for="DiaChi" class="form-label">Địa Chỉ</label>
                        <input type="text" class="form-control @error('DiaChi') is-invalid @enderror" 
                               id="DiaChi" name="DiaChi" 
                               value="{{ old('DiaChi', $area->DiaChi) }}">
                        @error('DiaChi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-group">
                        <label for="MoTa" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('MoTa') is-invalid @enderror" 
                                  id="MoTa" name="MoTa" rows="4">{{ old('MoTa', $area->MoTa) }}</textarea>
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
                            <i class="fas fa-save"></i> Lưu Thay Đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-info-circle"></i> Thông Tin
                </h6>
            </div>
            <div class="card-body" style="font-size: 13px;">
                <p>
                    <strong>Ngày Tạo:</strong><br>
                    {{ $area->CreatedAt ? \Carbon\Carbon::parse($area->CreatedAt)->format('d/m/Y H:i') : 'N/A' }}
                </p>
                <hr>
                <p>
                    <strong>Tòa Nhà:</strong><br>
                    <span class="badge badge-primary">{{ $area->toaNhas()->count() }} tòa nhà</span>
                </p>
                <p>
                    <strong>Căn Hộ:</strong><br>
                    <span class="badge badge-secondary">{{ $area->toaNhas()->withCount('canHos')->get()->sum('canHos_count') }} căn hộ</span>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
