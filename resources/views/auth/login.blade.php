@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h1 class="text-xl font-semibold mb-4">Đăng nhập</h1>

        @if($errors->any())
            <div class="mb-4 text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tên đăng nhập</label>
                <input name="username" value="{{ old('username') }}" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Mật khẩu</label>
                <input name="password" type="password" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ghi nhớ</label>
                <a href="#" class="text-sm text-blue-600">Quên mật khẩu?</a>
            </div>

            <div>
                <button class="btn btn-primary w-full">Đăng nhập</button>
            </div>
        </form>

        <p class="mt-4 text-sm">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-blue-600">Đăng ký</a></p>
    </div>
</div>
@endsection
