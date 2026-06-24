@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Chi Tiết Giao Dịch</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('transactions.index') }}">Thu Chi</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông Tin Giao Dịch</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <td style="width: 30%; font-weight: 600;">Mã Giao Dịch</td>
                            <td>
                                <code>{{ $transaction->Id }}</code>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $transaction->Id }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Loại Giao Dịch</td>
                            <td>
                                @if ($transaction->LoaiGiaoDich == 'Thu')
                                    <span class="badge bg-success fs-6">Thu (Nhập)</span>
                                @else
                                    <span class="badge bg-danger fs-6">Chi (Xuất)</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Số Tiền</td>
                            <td>
                                <span style="font-size: 18px; font-weight: 700; color: #0066CC;">
                                    {{ number_format($transaction->SoTien, 0, ',', '.') }} đ
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Ngày Giao Dịch</td>
                            <td>{{ $transaction->NgayGiaoDich ? \Carbon\Carbon::parse($transaction->NgayGiaoDich)->format('d/m/Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Tháng / Năm</td>
                            <td>
                                {{ $transaction->Thang ?? '-' }} / {{ $transaction->Nam ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Tham Chiếu</td>
                            <td>{{ $transaction->ThamChieu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Mô Tả</td>
                            <td>{{ $transaction->MoTa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Hợp Đồng ID</td>
                            <td>{{ $transaction->HopDongId ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Hóa Đơn ID</td>
                            <td>{{ $transaction->HoaDonId ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">Tài Khoản ID</td>
                            <td>{{ $transaction->TaiKhoanId ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Thao Tác</h5>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('transactions.edit', $transaction->Id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Sửa Giao Dịch
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteTransaction()">
                    <i class="fas fa-trash"></i> Xóa Giao Dịch
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Trạng Thái</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Tạo / Cập nhật:</small>
                    <p class="mb-0" style="font-size: 12px;">
                        {{ $transaction->created_at ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" action="{{ route('transactions.destroy', $transaction->Id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                title: 'Thành công',
                text: 'Đã sao chép mã giao dịch',
                icon: 'success',
                timer: 1500
            });
        });
    }

    function deleteTransaction() {
        Swal.fire({
            title: 'Xóa giao dịch?',
            text: 'Hành động này sẽ không thể hoàn tác',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endsection
