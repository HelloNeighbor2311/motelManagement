@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Quản Lý Tòa Nhà</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('buildings.index') }}">Bất Động Sản</a>
            <span class="separator">/</span>
            <span>Tòa Nhà</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('buildings.create') }}" class="btn btn-primary">
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

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('buildings.index') }}" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1;">
                <label class="form-label" style="font-weight: 600; font-size: 12px;">Lọc theo Khu Vực</label>
                <select name="area" id="areaFilter" class="form-select">
                    <option value="">-- Tất Cả --</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->Id }}" {{ request('area') == $area->Id ? 'selected' : '' }}>{{ $area->TenKhuVuc }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" style="font-weight: 600; font-size: 12px;">Tìm kiếm</label>
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tìm kiếm..." class="form-control" style="min-width: 220px;">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Lọc
            </button>
            @if (request()->filled('area') || request()->filled('search'))
                <a href="{{ route('buildings.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
        <h6 class="mb-0 fw-bold">Danh Sách Tòa Nhà ({{ $buildings->count() }} cái)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            @if ($buildings->count() > 0)
                <table class="table table-hover mb-0" id="buildingsTable">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="width: 50px;">STT</th>
                            <th>Tên Tòa Nhà</th>
                            <th>Khu Vực</th>
                            <th style="text-align: center;">Số Tầng</th>
                            <th style="text-align: center;">Căn Hộ</th>
                            <th>Ngày Tạo</th>
                            <th style="text-align: center; width: 180px;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buildings as $index => $building)
                            <tr data-area-id="{{ $building->KhuVucId }}" data-building-id="{{ $building->Id }}">
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td><strong>{{ $building->TenToaNha }}</strong></td>
                                <td>{{ $building->khuVuc->TenKhuVuc ?? 'N/A' }}</td>
                                <td style="text-align: center;">{{ $building->SoTang }}</td>
                                <td style="text-align: center;">
                                    <span class="badge badge-info">{{ $building->canHos_count }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $building->CreatedAt ? \Carbon\Carbon::parse($building->CreatedAt)->format('d/m/Y') : 'N/A' }}
                                    </small>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('buildings.show', $building->Id) }}" class="btn btn-sm btn-info table-action-btn" title="Xem Chi Tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('buildings.edit', $building->Id) }}" class="btn btn-sm btn-warning table-action-btn" title="Chỉnh Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-btn table-action-btn" data-building-id="{{ $building->Id }}" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info m-0" role="alert">
                    <i class="fas fa-info-circle"></i> Chưa có tòa nhà nào. <a href="{{ route('buildings.create') }}">Thêm ngay</a>
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
            const buildingId = this.getAttribute('data-building-id');
            const row = document.querySelector(`tr[data-building-id="${buildingId}"]`);
            const buildingName = row.querySelector('td:nth-child(2)').textContent;

            showConfirm(
                'Xóa Tòa Nhà',
                `Bạn có chắc chắn muốn xóa tòa nhà "${buildingName}"?`,
                () => {
                    fetch(`{{ url('buildings') }}/${buildingId}`, {
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
