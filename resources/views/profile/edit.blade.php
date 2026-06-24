@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Hồ sơ của tôi</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card p-6 bg-white rounded shadow">
            <h2 class="font-semibold mb-3">Cập nhật thông tin</h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Tên</label>
                    <input name="name" value="{{ old('name', $user->name) }}" class="w-full border px-3 py-2 rounded" />
                </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full border px-3 py-2 rounded" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Tên đăng nhập</label>
                        <input name="username" value="{{ old('username', optional($taiKhoan ?? null)->TenDangNhap) }}" class="w-full border px-3 py-2 rounded bg-gray-100 opacity-70 cursor-not-allowed" readonly />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Số điện thoại</label>
                        <input name="phone" value="{{ old('phone', optional($taiKhoan ?? null)->SoDienThoai) }}" class="w-full border px-3 py-2 rounded" />
                    </div>

                <div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>

        <div class="card p-6 bg-white rounded shadow">
            <h2 class="font-semibold mb-3">Đổi mật khẩu</h2>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Mật khẩu hiện tại</label>
                    <input name="current_password" type="password" class="w-full border px-3 py-2 rounded" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Mật khẩu mới</label>
                    <input name="password" type="password" class="w-full border px-3 py-2 rounded" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Xác nhận mật khẩu mới</label>
                    <input name="password_confirmation" type="password" class="w-full border px-3 py-2 rounded" />
                </div>

                <div>
                    <button type="submit" class="btn btn-secondary">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
