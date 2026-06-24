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
}
