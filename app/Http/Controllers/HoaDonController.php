<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    public function index()
    {
        return HoaDon::all();
    }

    public function show($id)
    {
        return HoaDon::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['HopDongId','KhachHangId','MaHoaDon','NgayPhatHanh','NgayDenHan','SoTien','LoaiHoaDon','Thang','Nam']);
        $model = HoaDon::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = HoaDon::findOrFail($id);
        $m->update($request->only(['HopDongId','KhachHangId','MaHoaDon','NgayPhatHanh','NgayDenHan','SoTien','LoaiHoaDon','Thang','Nam']));
        return $m;
    }

    public function destroy($id)
    {
        HoaDon::findOrFail($id)->delete();
        return response(null, 204);
    }
}
