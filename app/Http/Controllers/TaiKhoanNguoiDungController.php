<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoanNguoiDung;
use Illuminate\Http\Request;

class TaiKhoanNguoiDungController extends Controller
{
    public function index()
    {
        return TaiKhoanNguoiDung::all();
    }

    public function show($id)
    {
        return TaiKhoanNguoiDung::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['HoTen','SoDienThoai','Email','TenDangNhap','MatKhauHash','VaiTro','TrangThaiTk']);
        $model = TaiKhoanNguoiDung::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = TaiKhoanNguoiDung::findOrFail($id);
        $m->update($request->only(['HoTen','SoDienThoai','Email','TenDangNhap','MatKhauHash','VaiTro','TrangThaiTk']));
        return $m;
    }

    public function destroy($id)
    {
        TaiKhoanNguoiDung::findOrFail($id)->delete();
        return response(null, 204);
    }
}
