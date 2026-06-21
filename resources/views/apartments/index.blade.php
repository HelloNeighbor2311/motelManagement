@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Quản Lý Căn Hộ</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <span>Căn Hộ</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('apartments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Căn Hộ
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <select id="buildingFilter" class="form-select" onchange="applyFilters()">
                    <option value="">-- Tất Cả Tòa Nhà --</option>
                    @foreach ($buildings as $building)
                        <option value="{{ $building->Id }}" {{ request('building') == $building->Id ? 'selected' : '' }}>
                            {{ $building->TenToaNha }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select" onchange="applyFilters()">
                    <option value="">-- Tất Cả Trạng Thái --</option>
                    <option value="Trong" {{ request('status') == 'Trong' ? 'selected' : '' }}>✅ Trống</option>
                    <option value="DangThue" {{ request('status') == 'DangThue' ? 'selected' : '' }}>⏳ Đang Thuê</option>
                    <option value="BaoTri" {{ request('status') == 'BaoTri' ? 'selected' : '' }}>🔧 Bảo Trì</option>
                </select>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('apartments.index') }}" class="d-flex gap-2">
                    <input type="hidden" name="building" value="{{ request('building') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="text" name="search" class="form-control" placeholder="Tìm mã căn, tầng..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm Kiếm
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background-color: #f8f9fa;">
                <tr>
                    <th>Mã Căn</th>
                    <th>Tòa Nhà</th>
                    <th style="text-align: center;">Tầng</th>
                    <th style="text-align: center;">Diện Tích</th>
                    <th style="text-align: center;">Phòng</th>
                    <th style="text-align: center;">Giá Thuê</th>
                    <th>Trạng Thái</th>
                    <th style="text-align: center;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apartments as $apartment)
                    <tr>
                        <td><strong>{{ $apartment->MaCanHo }}</strong></td>
                        <td>{{ $apartment->toaNha->TenToaNha ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $apartment->Tang }}</td>
                        <td style="text-align: center;">{{ $apartment->DienTich }} m²</td>
                        <td style="text-align: center;">{{ $apartment->SoPhong }}</td>
                        <td style="text-align: center; font-weight: 600;">{{ number_format($apartment->GiaThue, 0, ',', '.') }} đ</td>
                        <td>
                            <span class="badge {{ $apartment->status_badge }}">{{ $apartment->status_display }}</span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('apartments.show', $apartment->Id) }}" class="btn btn-sm btn-info" title="Xem Chi Tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('apartments.edit', $apartment->Id) }}" class="btn btn-sm btn-warning" title="Chỉnh Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $apartment->Id }}" data-url="{{ route('apartments.destroy', $apartment->Id) }}" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-inbox" style="font-size: 32px; color: #ccc;"></i>
                            <p style="margin-top: 8px; color: #999;">Không có dữ liệu</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($apartments->hasPages())
        <div class="card-footer">
            {{ $apartments->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script>
    function applyFilters() {
        const building = document.getElementById('buildingFilter').value;
        const status = document.getElementById('statusFilter').value;
        window.location.href = `{{ route('apartments.index') }}?building=${building}&status=${status}`;
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const apartmentId = this.dataset.id;
            const url = this.dataset.url;

            Swal.fire({
                title: 'Xóa Căn Hộ?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Thành Công',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Lỗi', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Lỗi', 'Có lỗi xảy ra: ' + error, 'error');
                    });
                }
            });
        });
    });
</script>

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
