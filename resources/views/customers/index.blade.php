@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Quản Lý Khách Hàng</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <span>Khách Hàng</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Khách Hàng
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
                <select id="typeFilter" class="form-select" onchange="applyFilters()">
                    <option value="">-- Tất Cả Loại --</option>
                    <option value="Nhan" {{ request('type') == 'Nhan' ? 'selected' : '' }}>👤 Cá Nhân</option>
                    <option value="Doanh" {{ request('type') == 'Doanh' ? 'selected' : '' }}>🏢 Doanh Nghiệp</option>
                </select>
            </div>
            <div class="col-md-9">
                <form method="GET" action="{{ route('customers.index') }}" class="d-flex gap-2">
                    <input type="hidden" name="type" value="{{ request('type') }}">
                    <input type="text" name="search" class="form-control" placeholder="Tìm tên, số điện thoại, email..." value="{{ request('search') }}">
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
                    <th>Tên Khách Hàng</th>
                    <th>Loại</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>CCCD/MST</th>
                    <th style="text-align: center;">Hợp Đồng</th>
                    <th style="text-align: center;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td><strong>{{ $customer->TenKhachHang }}</strong></td>
                        <td>
                            <span class="badge {{ $customer->LoaiKhach == 'Nhan' ? 'bg-info' : 'bg-success' }}">
                                {{ $customer->LoaiKhach == 'Nhan' ? '👤 Cá Nhân' : '🏢 Doanh Nghiệp' }}
                            </span>
                        </td>
                        <td>{{ $customer->SoDienThoai }}</td>
                        <td>{{ $customer->Email }}</td>
                        <td>{{ $customer->CCCD }}</td>
                        <td style="text-align: center; font-weight: 600;">{{ $customer->hopDongs()->count() }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('customers.show', $customer->Id) }}" class="btn btn-sm btn-info" title="Xem Chi Tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('customers.edit', $customer->Id) }}" class="btn btn-sm btn-warning" title="Chỉnh Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $customer->Id }}" data-url="{{ route('customers.destroy', $customer->Id) }}" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox" style="font-size: 32px; color: #ccc;"></i>
                            <p style="margin-top: 8px; color: #999;">Không có dữ liệu</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($customers->hasPages())
        <div class="card-footer">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script>
    function applyFilters() {
        const type = document.getElementById('typeFilter').value;
        window.location.href = `{{ route('customers.index') }}?type=${type}`;
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const customerId = this.dataset.id;
            const url = this.dataset.url;

            Swal.fire({
                title: 'Xóa Khách Hàng?',
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

@endsection
