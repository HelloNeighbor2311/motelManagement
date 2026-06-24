@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Quản Lý Khu Vực</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('areas.index') }}">Bất Động Sản</a>
            <span class="separator">/</span>
            <span>Khu Vực</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('areas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Mới
        </a>
    </div>
</div>

<!-- Alerts -->
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Thành công!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Lỗi!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Table -->
<div class="card">
    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
            <h6 class="mb-0 fw-bold">Danh Sách Khu Vực ({{ $areas->count() }} cái)</h6>
            <form method="GET" action="{{ route('areas.index') }}" style="display: flex; gap: 8px;">
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tìm kiếm..." class="form-control form-control-sm" style="max-width: 220px;">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-search"></i> Lọc
                </button>
                @if (request()->filled('search'))
                    <a href="{{ route('areas.index') }}" class="btn btn-sm btn-outline-secondary">Xóa lọc</a>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            @if ($areas->count() > 0)
                <table class="table table-hover mb-0" id="areasTable">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="width: 50px;">STT</th>
                            <th>Tên Khu Vực</th>
                            <th>Địa Chỉ</th>
                            <th style="text-align: center;">Tòa Nhà</th>
                            <th>Ngày Tạo</th>
                            <th style="text-align: center; width: 180px;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $index => $area)
                            <tr data-area-id="{{ $area->Id }}">
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td><strong>{{ $area->TenKhuVuc }}</strong></td>
                                <td>
                                    <span class="text-muted" title="{{ $area->DiaChi }}">
                                        {{ Str::limit($area->DiaChi ?? 'N/A', 40) }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge badge-primary">{{ $area->toaNhas_count }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $area->CreatedAt ? \Carbon\Carbon::parse($area->CreatedAt)->format('d/m/Y') : 'N/A' }}
                                    </small>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('areas.show', $area->Id) }}" class="btn btn-sm btn-info table-action-btn" title="Xem Chi Tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('areas.edit', $area->Id) }}" class="btn btn-sm btn-warning table-action-btn" title="Chỉnh Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-btn table-action-btn" data-area-id="{{ $area->Id }}" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info m-0" role="alert">
                    <i class="fas fa-info-circle"></i> Chưa có khu vực nào. <a href="{{ route('areas.create') }}">Thêm ngay</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const areaId = this.getAttribute('data-area-id');
            const row = document.querySelector(`tr[data-area-id="${areaId}"]`);
            const areaName = row.querySelector('td:nth-child(2)').textContent;

                    showConfirm(
                'Xóa Khu Vực',
                `Bạn có chắc chắn muốn xóa khu vực "${areaName}"?`,
                () => {
                    fetch(`{{ route('areas.index') }}/${areaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('Thành công!', data.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showAlert('Lỗi!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        showAlert('Lỗi!', 'Có lỗi xảy ra: ' + error.message, 'error');
                    });
                }
            );
        });
    });
</script>
@endpush
