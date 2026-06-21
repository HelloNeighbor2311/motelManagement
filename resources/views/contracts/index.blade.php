@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Quản Lý Hợp Đồng</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <span>Hợp Đồng</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('contracts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Hợp Đồng
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
            <div class="col-md-4">
                <select id="statusFilter" class="form-select" onchange="applyFilters()">
                    <option value="">-- Tất Cả Trạng Thái --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Đang Hoạt Động</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>⏰ Hết Hạn</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Đã Hủy</option>
                </select>
            </div>
            <div class="col-md-8">
                <form method="GET" action="{{ route('contracts.index') }}" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="text" name="search" class="form-control" placeholder="Tìm mã hợp đồng, căn hộ, khách hàng..." value="{{ request('search') }}">
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
                    <th>Mã Hợp Đồng</th>
                    <th>Khách Hàng</th>
                    <th>Căn Hộ</th>
                    <th style="text-align: center;">Ngày Bắt Đầu</th>
                    <th style="text-align: center;">Ngày Kết Thúc</th>
                    <th style="text-align: right;">Giá Thuê</th>
                    <th>Trạng Thái</th>
                    <th style="text-align: center;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contracts as $contract)
                    <tr>
                        <td><strong>{{ $contract->MaHopDong }}</strong></td>
                        <td>{{ $contract->khachHang->TenKhachHang ?? 'N/A' }}</td>
                        <td>{{ $contract->canHo->MaCanHo ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $contract->NgayBatDau ? \Carbon\Carbon::parse($contract->NgayBatDau)->format('d/m/Y') : 'N/A' }}</td>
                        <td style="text-align: center;">{{ $contract->NgayKetThuc ? \Carbon\Carbon::parse($contract->NgayKetThuc)->format('d/m/Y') : 'N/A' }}</td>
                        <td style="text-align: right; font-weight: 600;">{{ number_format($contract->GiaThue, 0, ',', '.') }} đ</td>
                        <td>
                            <span class="badge {{ $contract->TrangThai == 'active' ? 'bg-success' : ($contract->TrangThai == 'expired' ? 'bg-warning' : 'bg-danger') }}">
                                {{ $contract->TrangThai == 'active' ? '✅ Đang Hoạt Động' : ($contract->TrangThai == 'expired' ? '⏰ Hết Hạn' : '❌ Đã Hủy') }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('contracts.show', $contract->Id) }}" class="btn btn-sm btn-info" title="Xem Chi Tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('contracts.edit', $contract->Id) }}" class="btn btn-sm btn-warning" title="Chỉnh Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $contract->Id }}" data-url="{{ route('contracts.destroy', $contract->Id) }}" title="Xóa">
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

    @if ($contracts->hasPages())
        <div class="card-footer">
            {{ $contracts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script>
    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        window.location.href = `{{ route('contracts.index') }}?status=${status}`;
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const contractId = this.dataset.id;
            const url = this.dataset.url;

            Swal.fire({
                title: 'Xóa Hợp Đồng?',
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
