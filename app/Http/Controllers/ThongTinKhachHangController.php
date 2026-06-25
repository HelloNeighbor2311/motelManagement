<?php

namespace App\Http\Controllers;

use App\Models\ThongTinKhachHang;
use Illuminate\Http\Request;

class ThongTinKhachHangController extends Controller
{
    public function index()
    {
        return ThongTinKhachHang::whereHas('khachHang', function ($query) {
            $query->forCurrentUser();
        })->get();
    }

    public function show($id)
    {
        return ThongTinKhachHang::whereHas('khachHang', function ($query) {
            $query->forCurrentUser();
        })->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'KhachHangId' => 'required|uuid',
            'NgaySinh' => 'nullable|date',
            'GioiTinh' => 'nullable|in:Nam,Nu,Khac',
            'SoGiayTo' => 'nullable|string|max:50',
            'DiaChiThuongTru' => 'nullable|string|max:500',
            'QuocTich' => 'nullable|string|max:100',
            'GhiChu' => 'nullable|string|max:1000',
        ]);

        $model = ThongTinKhachHang::create($validated);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = ThongTinKhachHang::whereHas('khachHang', function ($query) {
            $query->forCurrentUser();
        })->findOrFail($id);

        $validated = $request->validate([
            'KhachHangId' => 'sometimes|required|uuid',
            'NgaySinh' => 'nullable|date',
            'GioiTinh' => 'nullable|in:Nam,Nu,Khac',
            'SoGiayTo' => 'nullable|string|max:50',
            'DiaChiThuongTru' => 'nullable|string|max:500',
            'QuocTich' => 'nullable|string|max:100',
            'GhiChu' => 'nullable|string|max:1000',
        ]);

        $m->update($validated);
        return $m;
    }

    public function destroy($id)
    {
        ThongTinKhachHang::whereHas('khachHang', function ($query) {
            $query->forCurrentUser();
        })->findOrFail($id)->delete();
        return response(null, 204);
    }
}
