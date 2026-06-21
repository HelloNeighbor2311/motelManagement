<?php

namespace App\Http\Controllers;

use App\Models\ThuChi;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = ThuChi::query();

        if ($request->has('type') && $request->type != '') {
            $query->where('LoaiThuChi', $request->type);
        }

        if ($request->has('month') && $request->month != '') {
            $month = $request->month;
            $query->whereMonth('NgayThuChi', '=', substr($month, 5));
            $query->whereYear('NgayThuChi', '=', substr($month, 0, 4));
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('MaThuChi', 'like', "%$search%")
                    ->orWhere('NoiDung', 'like', "%$search%");
            });
        }

        $transactions = $query->orderBy('NgayThuChi', 'desc')->paginate(20);

        // Calculate summary statistics
        $statistics = [
            'totalIncome' => ThuChi::where('LoaiThuChi', 'Thu')->sum('SoTien'),
            'totalExpense' => ThuChi::where('LoaiThuChi', 'Chi')->sum('SoTien'),
            'monthIncome' => ThuChi::where('LoaiThuChi', 'Thu')
                ->whereMonth('NgayThuChi', now()->month)
                ->whereYear('NgayThuChi', now()->year)
                ->sum('SoTien'),
            'monthExpense' => ThuChi::where('LoaiThuChi', 'Chi')
                ->whereMonth('NgayThuChi', now()->month)
                ->whereYear('NgayThuChi', now()->year)
                ->sum('SoTien'),
        ];

        return view('transactions.index', compact('transactions', 'statistics'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MaThuChi' => 'required|string|max:50|unique:ThuChi,MaThuChi',
            'LoaiThuChi' => 'required|in:Thu,Chi',
            'SoTien' => 'required|numeric|min:0',
            'NgayThuChi' => 'required|date',
            'NoiDung' => 'required|string|max:200',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            ThuChi::create($validated);
            return redirect()->route('transactions.index')->with('success', 'Thêm giao dịch thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = ThuChi::findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = ThuChi::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = ThuChi::findOrFail($id);

        $validated = $request->validate([
            'MaThuChi' => 'required|string|max:50|unique:ThuChi,MaThuChi,' . $id . ',Id',
            'LoaiThuChi' => 'required|in:Thu,Chi',
            'SoTien' => 'required|numeric|min:0',
            'NgayThuChi' => 'required|date',
            'NoiDung' => 'required|string|max:200',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            $transaction->update($validated);
            return redirect()->route('transactions.show', $transaction->Id)->with('success', 'Cập nhật giao dịch thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = ThuChi::findOrFail($id);
            $transaction->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa giao dịch thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
