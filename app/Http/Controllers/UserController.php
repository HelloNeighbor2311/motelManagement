<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\TaiKhoanNguoiDung;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index() {}
    public function create() {}
    public function store(Request $request) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
    public function roles() {}
    public function settings() {}
    public function profileSettings() {}
    public function profile()
    {
        $user = Auth::user();
        $taiKhoan = TaiKhoanNguoiDung::where('Email', $user->email)->first();
        return view('profile.edit', compact('user', 'taiKhoan'));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', Rule::unique('TaiKhoanNguoiDung', 'TenDangNhap')],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create TaiKhoanNguoiDung record to match migration schema
        TaiKhoanNguoiDung::create([
            'Id' => (string) Str::uuid(),
            'HoTen' => $data['name'],
            'SoDienThoai' => $data['phone'] ?? null,
            'Email' => $data['email'],
            'TenDangNhap' => $data['username'],
            'MatKhauHash' => Hash::make($data['password']),
            'TrangThaiTk' => 'Active',
            'CreatedAt' => now(),
        ]);

        Auth::login($user);

        return redirect()->intended(route('dashboard'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // Authenticate against TaiKhoanNguoiDung by TenDangNhap
        $taiKhoan = TaiKhoanNguoiDung::where('TenDangNhap', $data['username'])->first();
        if (! $taiKhoan || ! Hash::check($data['password'], $taiKhoan->MatKhauHash)) {
            return back()->withErrors([
                'username' => 'Thông tin đăng nhập không hợp lệ.',
            ])->onlyInput('username');
        }

        // Find or create corresponding users record and log in
        $user = User::where('email', $taiKhoan->Email)->first();
        if (! $user) {
            $user = User::create([
                'name' => $taiKhoan->HoTen ?? $taiKhoan->TenDangNhap,
                'email' => $taiKhoan->Email,
                'password' => Hash::make($data['password']),
            ]);
        }

        Auth::login($user, $remember);
        $request->session()->regenerate();

        // Optionally update last login in TaiKhoanNguoiDung
        $taiKhoan->LastLogin = now();
        $taiKhoan->save();

        return redirect()->intended(route('dashboard'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update(['name' => $data['name'], 'email' => $data['email']]);

        $taiKhoan = TaiKhoanNguoiDung::where('Email', $user->getOriginal('email'))->first();
        if ($taiKhoan) {
            $taiKhoan->HoTen = $data['name'];
            $taiKhoan->Email = $data['email'];
            $taiKhoan->SoDienThoai = $data['phone'] ?? null;
            $taiKhoan->save();
        }

        return redirect()->route('profile')->with('success', 'Thông tin cá nhân đã được cập nhật.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        // sync password into TaiKhoanNguoiDung if exists
        $taiKhoan = TaiKhoanNguoiDung::where('Email', $user->email)->first();
        if ($taiKhoan) {
            $taiKhoan->MatKhauHash = Hash::make($request->input('password'));
            $taiKhoan->save();
        }

        return redirect()->route('profile')->with('success', 'Mật khẩu đã được thay đổi.');
    }

    public function logout()
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('login');
    }

    // --- API methods for TaiKhoanNguoiDung (merged) ---
    public function taiKhoanIndex()
    {
        return TaiKhoanNguoiDung::all();
    }

    public function taiKhoanShow($id)
    {
        return TaiKhoanNguoiDung::findOrFail($id);
    }

    public function taiKhoanStore(Request $request)
    {
        $data = $request->only(['Id','HoTen','SoDienThoai','Email','TenDangNhap','MatKhauHash','TrangThaiTk']);
        if (empty($data['Id'])) {
            $data['Id'] = (string) Str::uuid();
        }
        if (empty($data['TrangThaiTk'])) {
            $data['TrangThaiTk'] = 'Active';
        }
        $model = TaiKhoanNguoiDung::create($data);
        return response($model, 201);
    }

    public function taiKhoanUpdate(Request $request, $id)
    {
        $m = TaiKhoanNguoiDung::findOrFail($id);
        $m->update($request->only(['HoTen','SoDienThoai','Email','TenDangNhap','MatKhauHash','TrangThaiTk']));
        return $m;
    }

    public function taiKhoanDestroy($id)
    {
        TaiKhoanNguoiDung::findOrFail($id)->delete();
        return response(null, 204);
    }
}
