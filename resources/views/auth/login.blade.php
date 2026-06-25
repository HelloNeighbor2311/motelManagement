@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login.perform') }}">
    @csrf

    <div class="mb-3">
        <label for="username" class="form-label fw-semibold">Tên đăng nhập</label>
        <input id="username" name="username" value="{{ old('username') }}" required autofocus class="form-control" placeholder="Nhập tên đăng nhập">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Mật khẩu</label>
        <input id="password" name="password" type="password" required class="form-control" placeholder="Nhập mật khẩu">
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4 gap-3 flex-wrap">
        <label class="form-check mb-0">
            <input class="form-check-input" type="checkbox" name="remember">
            <span class="form-check-label">Ghi nhớ đăng nhập</span>
        </label>
        <a href="{{ route('password.request') }}" class="auth-link">Quên mật khẩu?</a>
    </div>

    <button type="submit" class="btn btn-primary btn-auth w-100">
        <i class="fas fa-right-to-bracket me-2"></i>Đăng nhập
    </button>
</form>
@endsection

@section('footer')
<div class="text-center">
    Chưa có tài khoản? <a href="{{ route('register') }}" class="auth-link">Đăng ký ngay</a>
</div>
@endsection
