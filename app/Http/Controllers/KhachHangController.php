<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function index()
    {
        return KhachHang::all();
    }

    public function show($id)
    {
        return KhachHang::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['HoTen','LoaiKhachHang','SoCmndCccd','QuocTich','SoDienThoai','Email']);
        $model = KhachHang::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = KhachHang::findOrFail($id);
        $m->update($request->only(['HoTen','LoaiKhachHang','SoCmndCccd','QuocTich','SoDienThoai','Email']));
        return $m;
    }

    public function destroy($id)
    {
        KhachHang::findOrFail($id)->delete();
        return response(null, 204);
    }
}
