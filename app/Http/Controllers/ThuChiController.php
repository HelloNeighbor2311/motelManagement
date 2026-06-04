<?php

namespace App\Http\Controllers;

use App\Models\ThuChi;
use Illuminate\Http\Request;

class ThuChiController extends Controller
{
    public function index()
    {
        return ThuChi::all();
    }

    public function show($id)
    {
        return ThuChi::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['HopDongId','HoaDonId','TaiKhoanId','LoaiGiaoDich','SoTien','NgayGiaoDich','Thang','Nam','MoTa','ThamChieu']);
        $model = ThuChi::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = ThuChi::findOrFail($id);
        $m->update($request->only(['HopDongId','HoaDonId','TaiKhoanId','LoaiGiaoDich','SoTien','NgayGiaoDich','Thang','Nam','MoTa','ThamChieu']));
        return $m;
    }

    public function destroy($id)
    {
        ThuChi::findOrFail($id)->delete();
        return response(null, 204);
    }
}
