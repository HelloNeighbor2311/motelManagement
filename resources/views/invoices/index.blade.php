@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Quản Lý Hóa Đơn</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <span>Hóa Đơn</span>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo Hóa Đơn
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div style="padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; color: white; text-align: center;">
                    <p style="margin: 0; font-size: 12px; text-transform: uppercase; opacity: 0.9;">Chưa Thanh Toán</p>
                    <p style="margin: 8px 0 0 0; font-size: 24px; font-weight: 700;">
                        {{ \App\Models\HoaDon::where('TrangThai', 'Chua')->count() }}
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div style="padding: 16px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 8px; color: white; text-align: center;">
                    <p style="margin: 0; font-size: 12px; text-transform: uppercase; opacity: 0.9;">Quá Hạn</p>
                    <p style="margin: 8px 0 0 0; font-size: 24px; font-weight: 700;">
                        {{ \App\Models\HoaDon::where('TrangThai', 'QuaHan')->count() }}
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div style="padding: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 8px; color: white; text-align: center;">
                    <p style="margin: 0; font-size: 12px; text-transform: uppercase; opacity: 0.9;">Đã Thanh Toán</p>
                    <p style="margin: 8px 0 0 0; font-size: 24px; font-weight: 700;">
                        {{ \App\Models\HoaDon::where('TrangThai', 'DaThanhToan')->count() }}
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div style="padding: 16px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 8px; color: white; text-align: center;">
                    <p style="margin: 0; font-size: 12px; text-transform: uppercase; opacity: 0.9;">Tổng Doanh Thu</p>
                    <p style="margin: 8px 0 0 0; font-size: 18px; font-weight: 700;">
                        {{ number_format(\App\Models\HoaDon::sum('TongTien'), 0, ',', '.') }} đ
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <select id="statusFilter" class="form-select" onchange="applyFilters()">
                    <option value="">-- Tất Cả Trạng Thái --</option>
                    <option value="Chua" {{ request('status') == 'Chua' ? 'selected' : '' }}>⏳ Chưa Thanh Toán</option>
                    <option value="DaThanhToan" {{ request('status') == 'DaThanhToan' ? 'selected' : '' }}>✅ Đã Thanh Toán</option>
                    <option value="QuaHan" {{ request('status') == 'QuaHan' ? 'selected' : '' }}>❌ Quá Hạn</option>
                </select>
            </div>
            <div class="col-md-8">
                <form method="GET" action="{{ route('invoices.index') }}" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="text" name="search" class="form-control" placeholder="Tìm mã hóa đơn, khách hàng..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background-color: #f8f9fa;">
                <tr>
                    <th>Mã HĐ</th>
                    <th>Khách Hàng</th>
                    <th>Ngày Lập</th>
                    <th>Ngày Dự Kiến</th>
                    <th style="text-align: right;">Số Tiền</th>
                    <th>Trạng Thái</th>
                    <th style="text-align: center;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td><strong>{{ $invoice->MaHoaDon }}</strong></td>
                        <td>{{ $invoice->khachHang->TenKhachHang ?? 'N/A' }}</td>
                        <td>{{ $invoice->NgayLap ? \Carbon\Carbon::parse($invoice->NgayLap)->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $invoice->NgayDuKien ? \Carbon\Carbon::parse($invoice->NgayDuKien)->format('d/m/Y') : 'N/A' }}</td>
                        <td style="text-align: right; font-weight: 600;">{{ number_format($invoice->TongTien, 0, ',', '.') }} đ</td>
                        <td>
                            @if ($invoice->TrangThai == 'Chua')
                                <span class="badge bg-warning" style="color: #333;">⏳ Chưa Thanh Toán</span>
                            @elseif ($invoice->TrangThai == 'DaThanhToan')
                                <span class="badge bg-success">✅ Đã Thanh Toán</span>
                            @else
                                <span class="badge bg-danger">❌ Quá Hạn</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('invoices.show', $invoice->Id) }}" class="btn btn-sm btn-info" title="Xem Chi Tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('invoices.edit', $invoice->Id) }}" class="btn btn-sm btn-warning" title="Chỉnh Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $invoice->Id }}" data-url="{{ route('invoices.destroy', $invoice->Id) }}" title="Xóa">
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

    @if ($invoices->hasPages())
        <div class="card-footer">
            {{ $invoices->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script>
    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        window.location.href = `{{ route('invoices.index') }}?status=${status}`;
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const invoiceId = this.dataset.id;
            const url = this.dataset.url;

            Swal.fire({
                title: 'Xóa Hóa Đơn?',
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
