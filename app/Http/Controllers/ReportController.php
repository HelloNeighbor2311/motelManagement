<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaoCaoTaiChinh;
use App\Models\ThuChi;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $years = BaoCaoTaiChinh::forCurrentUser()->select('Nam')->distinct()->orderBy('Nam', 'desc')->pluck('Nam')->toArray();
        if (empty($years)) {
            $years = [date('Y')];
        }
        
        $year = $request->get('year', date('Y'));
        $month = (int) $request->get('month', date('n'));

        // Calculate from ThuChi and get or create report
        $transactions = ThuChi::forCurrentUser()->where('Nam', $year)
            ->where('Thang', $month)
            ->get();

        $thu = $transactions->where('LoaiGiaoDich', 'Thu')->sum('SoTien');
        $chi = $transactions->where('LoaiGiaoDich', 'Chi')->sum('SoTien');

        // Create or get BaoCaoTaiChinh record
        $record = BaoCaoTaiChinh::firstOrCreate(
            ['user_id' => auth()->id(), 'LoaiBaoCao' => 'Thang', 'Thang' => $month, 'Nam' => $year],
            ['TongThu' => $thu, 'TongChi' => $chi]
        );

        // Update with latest data
        $record->update(['TongThu' => $thu, 'TongChi' => $chi]);

        $records = collect([$record]);

        $totals = [
            'TongThu' => $thu,
            'TongChi' => $chi,
            'TienThueThu' => $record->TienThueThu ?? 0,
            'TienDatCocThu' => $record->TienDatCocThu ?? 0,
            'ChiPhiVanHanh' => $record->ChiPhiVanHanh ?? 0,
        ];

        return view('reports.monthly', compact('years', 'year', 'month', 'records', 'totals'));
    }

    public function quarterly()
    {
        abort(404);
    }

    public function yearly(Request $request)
    {
        $years = BaoCaoTaiChinh::forCurrentUser()->select('Nam')->distinct()->orderBy('Nam', 'desc')->pluck('Nam')->toArray();
        if (empty($years)) {
            $years = [date('Y')];
        }
        
        $year = $request->get('year', date('Y'));

        // Calculate from ThuChi grouped by month
        $transactions = ThuChi::forCurrentUser()->where('Nam', $year)->get();
        $monthlyData = $transactions->groupBy('Thang');

        $records = collect();
        $totalThu = 0;
        $totalChi = 0;

        foreach ($monthlyData as $month => $monthTransactions) {
            $thu = $monthTransactions->where('LoaiGiaoDich', 'Thu')->sum('SoTien');
            $chi = $monthTransactions->where('LoaiGiaoDich', 'Chi')->sum('SoTien');

            // Create or get BaoCaoTaiChinh record
            $record = BaoCaoTaiChinh::firstOrCreate(
                ['user_id' => auth()->id(), 'LoaiBaoCao' => 'Thang', 'Thang' => $month, 'Nam' => $year],
                ['TongThu' => $thu, 'TongChi' => $chi]
            );
            $record->update(['TongThu' => $thu, 'TongChi' => $chi]);

            $records->push($record);
            $totalThu += $thu;
            $totalChi += $chi;
        }

        $totals = [
            'TongThu' => $totalThu,
            'TongChi' => $totalChi,
            'TienThueThu' => 0,
            'TienDatCocThu' => 0,
            'ChiPhiVanHanh' => 0,
        ];

        return view('reports.yearly', compact('years', 'year', 'records', 'totals'));
    }

    // API: list all finance reports
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return BaoCaoTaiChinh::forCurrentUser()->get();
        }

        abort(404);
    }

    public function show($id)
    {
        $model = BaoCaoTaiChinh::forCurrentUser()->findOrFail($id);

        if (request()->wantsJson()) {
            return $model;
        }

        abort(404);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['TaiKhoanId' => ['nullable'], 'LoaiBaoCao' => ['required', 'string'], 'Thang' => ['nullable','integer'], 'Nam' => ['required','integer'], 'TongThu' => ['nullable','numeric'], 'TongChi' => ['nullable','numeric'], 'TienThueThu' => ['nullable','numeric'], 'TienDatCocThu' => ['nullable','numeric'], 'ChiPhiVanHanh' => ['nullable','numeric']]);
        $data['user_id'] = auth()->id();

        $model = BaoCaoTaiChinh::create($data);

        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = BaoCaoTaiChinh::forCurrentUser()->findOrFail($id);
        $data = $request->validate(['TaiKhoanId' => ['nullable'], 'LoaiBaoCao' => ['required', 'string'], 'Thang' => ['nullable','integer'], 'Nam' => ['required','integer'], 'TongThu' => ['nullable','numeric'], 'TongChi' => ['nullable','numeric'], 'TienThueThu' => ['nullable','numeric'], 'TienDatCocThu' => ['nullable','numeric'], 'ChiPhiVanHanh' => ['nullable','numeric']]);

        $m->update($data);

        return $m;
    }

    public function destroy($id)
    {
        $m = BaoCaoTaiChinh::forCurrentUser()->findOrFail($id);
        $m->delete();

        return response(null, 204);
    }
}
