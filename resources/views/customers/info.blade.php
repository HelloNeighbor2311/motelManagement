@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Thông Tin Cá Nhân</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Trang Chủ</a>
            <span class="separator">/</span>
            <a href="{{ route('customers.index') }}">Khách Hàng</a>
            <span class="separator">/</span>
            <span>Thông Tin Cá Nhân</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(isset($customer))
            <h4>{{ $customer->TenKhachHang }}</h4>
            <table class="table">
                <tr><th>Số điện thoại</th><td>{{ $customer->SoDienThoai }}</td></tr>
                <tr><th>Email</th><td>{{ $customer->Email }}</td></tr>
                <tr><th>Địa chỉ</th><td>{{ $customer->DiaChi }}</td></tr>
                <tr><th>CCCD</th><td>{{ $customer->CCCD }}</td></tr>
                <tr><th>Loại khách</th><td>{{ $customer->LoaiKhach }}</td></tr>
                <tr><th>Ghi chú</th><td>{{ $customer->GhiChu }}</td></tr>
                <tr><th>Ngày tạo</th><td>{{ $customer->CreatedAt ? \Carbon\Carbon::parse($customer->CreatedAt)->format('d/m/Y') : 'N/A' }}</td></tr>
            </table>
        @else
            <div class="alert alert-info">
                Không có thông tin khách hàng để hiển thị. Bạn có thể xem danh sách khách hàng hoặc chọn một khách hàng cụ thể.
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-primary">Danh Sách Khách Hàng</a>
        @endif
    </div>
</div>
@endsection
