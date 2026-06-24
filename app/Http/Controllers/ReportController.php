<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaoCaoTaiChinh;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $years = BaoCaoTaiChinh::select('Nam')->distinct()->orderBy('Nam', 'desc')->pluck('Nam')->toArray();
        $year = $request->get('year', date('Y'));
        $month = (int) $request->get('month', date('n'));

        $records = BaoCaoTaiChinh::where('LoaiBaoCao', 'Thang')
            ->where('Nam', $year)
            ->where('Thang', $month)
            ->get();

        $totals = [
            'TongThu' => $records->sum('TongThu'),
            'TongChi' => $records->sum('TongChi'),
            'TienThueThu' => $records->sum('TienThueThu'),
            'TienDatCocThu' => $records->sum('TienDatCocThu'),
            'ChiPhiVanHanh' => $records->sum('ChiPhiVanHanh'),
        ];

        return view('reports.monthly', compact('years', 'year', 'month', 'records', 'totals'));
    }

    public function quarterly()
    {
        abort(404);
    }

    public function yearly(Request $request)
    {
        $years = BaoCaoTaiChinh::select('Nam')->distinct()->orderBy('Nam', 'desc')->pluck('Nam')->toArray();
        $year = $request->get('year', date('Y'));

        $records = BaoCaoTaiChinh::where('LoaiBaoCao', 'Nam')
            ->where('Nam', $year)
            ->get();

        $totals = [
            'TongThu' => $records->sum('TongThu'),
            'TongChi' => $records->sum('TongChi'),
            'TienThueThu' => $records->sum('TienThueThu'),
            'TienDatCocThu' => $records->sum('TienDatCocThu'),
            'ChiPhiVanHanh' => $records->sum('ChiPhiVanHanh'),
        ];

        return view('reports.yearly', compact('years', 'year', 'records', 'totals'));
    }

    // API: list all finance reports
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return BaoCaoTaiChinh::all();
        }

        abort(404);
    }

    public function show($id)
    {
        $model = BaoCaoTaiChinh::findOrFail($id);

        if (request()->wantsJson()) {
            return $model;
        }

        abort(404);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['TaiKhoanId' => ['nullable'], 'LoaiBaoCao' => ['required', 'string'], 'Thang' => ['nullable','integer'], 'Nam' => ['required','integer'], 'TongThu' => ['nullable','numeric'], 'TongChi' => ['nullable','numeric'], 'TienThueThu' => ['nullable','numeric'], 'TienDatCocThu' => ['nullable','numeric'], 'ChiPhiVanHanh' => ['nullable','numeric']]);

        $model = BaoCaoTaiChinh::create($data);

        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = BaoCaoTaiChinh::findOrFail($id);
        $data = $request->validate(['TaiKhoanId' => ['nullable'], 'LoaiBaoCao' => ['required', 'string'], 'Thang' => ['nullable','integer'], 'Nam' => ['required','integer'], 'TongThu' => ['nullable','numeric'], 'TongChi' => ['nullable','numeric'], 'TienThueThu' => ['nullable','numeric'], 'TienDatCocThu' => ['nullable','numeric'], 'ChiPhiVanHanh' => ['nullable','numeric']]);

        $m->update($data);

        return $m;
    }

    public function destroy($id)
    {
        $m = BaoCaoTaiChinh::findOrFail($id);
        $m->delete();

        return response(null, 204);
    }
}
