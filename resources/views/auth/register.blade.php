@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('register.perform') }}">
    @csrf

    <div class="row g-3">
        <div class="col-12">
            <label for="name" class="form-label fw-semibold">Tên</label>
            <input id="name" name="name" value="{{ old('name') }}" required class="form-control" placeholder="Nhập họ tên">
        </div>

        <div class="col-12">
            <label for="username" class="form-label fw-semibold">Tên đăng nhập</label>
            <input id="username" name="username" value="{{ old('username') }}" required class="form-control" placeholder="Chọn tên đăng nhập">
        </div>

        <div class="col-12">
            <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
            <input id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Nhập số điện thoại">
        </div>

        <div class="col-12">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" name="email" value="{{ old('email') }}" type="email" required class="form-control" placeholder="Nhập email">
        </div>

        <div class="col-12">
            <label for="password" class="form-label fw-semibold">Mật khẩu</label>
            <input id="password" name="password" type="password" required class="form-control" placeholder="Tạo mật khẩu">
        </div>

        <div class="col-12">
            <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="form-control" placeholder="Nhập lại mật khẩu">
        </div>

        <div class="col-12 mt-2">
            <button type="submit" class="btn btn-primary btn-auth w-100">
                <i class="fas fa-user-plus me-2"></i>Đăng ký
            </button>
        </div>
    </div>
</form>
@endsection

@section('footer')
<div class="text-center">
    Đã có tài khoản? <a href="{{ route('login') }}" class="auth-link">Đăng nhập</a>
</div>
@endsection
