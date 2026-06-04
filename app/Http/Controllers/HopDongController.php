<?php

namespace App\Http\Controllers;

use App\Models\HopDong;
use Illuminate\Http\Request;

class HopDongController extends Controller
{
    public function index()
    {
        return HopDong::all();
    }

    public function show($id)
    {
        return HopDong::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['KhachHangId','CanHoId','ToaNhaId','MaHopDong','NgayBatDau','NgayKetThuc','GiaThueThaoThuan','TienDatCoc']);
        $model = HopDong::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = HopDong::findOrFail($id);
        $m->update($request->only(['KhachHangId','CanHoId','ToaNhaId','MaHopDong','NgayBatDau','NgayKetThuc','GiaThueThaoThuan','TienDatCoc']));
        return $m;
    }

    public function destroy($id)
    {
        HopDong::findOrFail($id)->delete();
        return response(null, 204);
    }
}
