@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h1 class="text-xl font-semibold mb-4">Đăng ký</h1>

        @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.perform') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tên</label>
                <input name="name" value="{{ old('name') }}" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tên đăng nhập</label>
                <input name="username" value="{{ old('username') }}" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Số điện thoại</label>
                <input name="phone" value="{{ old('phone') }}" class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input name="email" value="{{ old('email') }}" type="email" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Mật khẩu</label>
                <input name="password" type="password" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Xác nhận mật khẩu</label>
                <input name="password_confirmation" type="password" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div>
                <button class="btn btn-primary w-full">Đăng ký</button>
            </div>
        </form>

        <p class="mt-4 text-sm">Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-600">Đăng nhập</a></p>
    </div>
</div>
@endsection
