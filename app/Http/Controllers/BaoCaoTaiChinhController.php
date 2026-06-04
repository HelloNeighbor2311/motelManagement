<?php

namespace App\Http\Controllers;

use App\Models\BaoCaoTaiChinh;
use Illuminate\Http\Request;

class BaoCaoTaiChinhController extends Controller
{
    public function index()
    {
        return BaoCaoTaiChinh::all();
    }

    public function show($id)
    {
        return BaoCaoTaiChinh::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['TaiKhoanId','LoaiBaoCao','Thang','Quy','Nam','TongThu','TongChi','TienThueThu','TienDatCocThu','ChiPhiVanHanh']);
        $model = BaoCaoTaiChinh::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = BaoCaoTaiChinh::findOrFail($id);
        $m->update($request->only(['TaiKhoanId','LoaiBaoCao','Thang','Quy','Nam','TongThu','TongChi','TienThueThu','TienDatCocThu','ChiPhiVanHanh']));
        return $m;
    }

    public function destroy($id)
    {
        BaoCaoTaiChinh::findOrFail($id)->delete();
        return response(null, 204);
    }
}
