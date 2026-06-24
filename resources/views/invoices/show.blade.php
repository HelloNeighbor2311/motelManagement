@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $invoice->MaHoaDon }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('invoices.index') }}">Hóa Đơn</a>
            <span class="separator">/</span>
            <span>Chi Tiết</span>
        </div>
    </div>
    <div class="page-actions">
        @if ($invoice->TrangThaiThanhToan == 'ChuaThanhToan')
            <button type="button" class="btn btn-success" onclick="markAsPaid()">
                <i class="fas fa-check"></i> Đánh Dấu Là Đã Thanh Toán
            </button>
        @endif
        <a href="{{ route('invoices.edit', $invoice->Id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Invoice Status -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Trạng Thái Hóa Đơn</h6>
            </div>
            <div class="card-body" style="text-align: center;">
                @if ($invoice->TrangThaiThanhToan == 'ChuaThanhToan')
                    <div style="padding: 20px; background-color: #fff3cd; border-radius: 8px;">
                        <p style="font-size: 32px; margin: 0;">⏳</p>
                        <p style="margin: 8px 0 0 0; font-weight: 600; color: #856404;">Chưa Thanh Toán</p>
                    </div>
                @elseif ($invoice->TrangThaiThanhToan == 'DaThanhToan')
                    <div style="padding: 20px; background-color: #d4edda; border-radius: 8px;">
                        <p style="font-size: 32px; margin: 0;">✅</p>
                        <p style="margin: 8px 0 0 0; font-weight: 600; color: #155724;">Đã Thanh Toán</p>
                    </div>
                @else
                    <div style="padding: 20px; background-color: #f8d7da; border-radius: 8px;">
                        <p style="font-size: 32px; margin: 0;">❌</p>
                        <p style="margin: 8px 0 0 0; font-weight: 600; color: #721c24;">Quá Hạn</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Amount Info -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Thông Tin Thanh Toán</h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 12px;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Số Tiền</label>
                    <p style="margin: 8px 0 0 0; font-size: 24px; font-weight: 700; color: #28a745;">{{ number_format($invoice->SoTien, 0, ',', '.') }} đ</p>
                </div>
                <div style="padding-top: 12px; border-top: 1px solid #e0e0e0;">
                    <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Ngày Dự Kiến</label>
                    <p style="margin: 4px 0 0 0;">{{ $invoice->NgayDenHan ? \Carbon\Carbon::parse($invoice->NgayDenHan)->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Customer Info -->
        <div class="card mb-3">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">👤 Thông Tin Khách Hàng</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Tên</label>
                        <p style="margin: 4px 0 0 0;">{{ $invoice->khachHang->TenKhachHang ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Loại</label>
                        <p style="margin: 4px 0 0 0;">
                            <span class="badge {{ $invoice->khachHang->LoaiKhach == 'Nhan' ? 'bg-info' : 'bg-success' }}">
                                {{ $invoice->khachHang->LoaiKhach == 'Nhan' ? '👤 Cá Nhân' : '🏢 Doanh Nghiệp' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row" style="margin-top: 12px;">
                    <div class="col-md-6">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Số ĐT</label>
                        <p style="margin: 4px 0 0 0;">
                            <a href="tel:{{ $invoice->khachHang->SoDienThoai }}" style="color: #0066cc;">{{ $invoice->khachHang->SoDienThoai ?? 'N/A' }}</a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Email</label>
                        <p style="margin: 4px 0 0 0;">
                            <a href="mailto:{{ $invoice->khachHang->Email }}" style="color: #0066cc;">{{ $invoice->khachHang->Email ?? 'N/A' }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="card">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0; padding: 16px;">
                <h6 class="mb-0 fw-bold">Chi Tiết Hóa Đơn</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Mã Hóa Đơn</label>
                        <p style="margin: 4px 0 0 0;">{{ $invoice->MaHoaDon }}</p>
                    </div>
                    <div class="col-md-6">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Ngày Lập</label>
                        <p style="margin: 4px 0 0 0;">{{ $invoice->NgayPhatHanh ? \Carbon\Carbon::parse($invoice->NgayPhatHanh)->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                </div>

                @if ($invoice->hopDong)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Hợp Đồng</label>
                            <p style="margin: 4px 0 0 0;">{{ $invoice->hopDong->MaHopDong }}</p>
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Căn Hộ</label>
                            <p style="margin: 4px 0 0 0;">{{ $invoice->hopDong->canHo->MaCanHo ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif

                @if ($invoice->GhiChu)
                    <div style="padding-top: 12px; border-top: 1px solid #e0e0e0;">
                        <label style="font-weight: 600; color: #6C757D; font-size: 11px; text-transform: uppercase;">Ghi Chú</label>
                        <p style="margin: 4px 0 0 0;">{{ $invoice->GhiChu }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function markAsPaid() {
        Swal.fire({
            title: 'Đánh dấu là đã thanh toán?',
            text: 'Xác nhận hóa đơn này đã được thanh toán',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xác Nhận',
            cancelButtonText: 'Hủy'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`{{ route('invoices.mark-paid', $invoice->Id) }}`, {
                    method: 'POST',
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
                });
            }
        });
    }
</script>

@endsection
