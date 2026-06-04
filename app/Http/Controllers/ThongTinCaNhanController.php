<?php

namespace App\Http\Controllers;

use App\Models\ThongTinCaNhan;
use Illuminate\Http\Request;

class ThongTinCaNhanController extends Controller
{
    public function index()
    {
        return ThongTinCaNhan::all();
    }

    public function show($id)
    {
        return ThongTinCaNhan::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['KhachHangId','DiaChiThuongTru','NgaySinh','GioiTinh','TenCongTy','MaSoThue','NguoiDaiDien']);
        $model = ThongTinCaNhan::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = ThongTinCaNhan::findOrFail($id);
        $m->update($request->only(['KhachHangId','DiaChiThuongTru','NgaySinh','GioiTinh','TenCongTy','MaSoThue','NguoiDaiDien']));
        return $m;
    }

    public function destroy($id)
    {
        ThongTinCaNhan::findOrFail($id)->delete();
        return response(null, 204);
    }
}
