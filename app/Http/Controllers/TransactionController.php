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
            $query->where('LoaiGiaoDich', $request->type);
        }

        if ($request->has('month') && $request->month != '') {
            $month = $request->month;
            $query->whereMonth('NgayGiaoDich', '=', substr($month, 5));
            $query->whereYear('NgayGiaoDich', '=', substr($month, 0, 4));
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ThamChieu', 'like', "%$search%")
                    ->orWhere('MoTa', 'like', "%$search%");
            });
        }

        if ($request->wantsJson()) {
            return $query->orderBy('NgayGiaoDich', 'desc')->get();
        }

        $transactions = $query->orderBy('NgayGiaoDich', 'desc')->paginate(20);

        // Calculate summary statistics
        $statistics = [
            'totalIncome' => ThuChi::where('LoaiGiaoDich', 'Thu')->sum('SoTien'),
            'totalExpense' => ThuChi::where('LoaiGiaoDich', 'Chi')->sum('SoTien'),
            'monthIncome' => ThuChi::where('LoaiGiaoDich', 'Thu')
                ->whereMonth('NgayGiaoDich', now()->month)
                ->whereYear('NgayGiaoDich', now()->year)
                ->sum('SoTien'),
            'monthExpense' => ThuChi::where('LoaiGiaoDich', 'Chi')
                ->whereMonth('NgayGiaoDich', now()->month)
                ->whereYear('NgayGiaoDich', now()->year)
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
            'HopDongId' => 'nullable|uuid|exists:HopDong,Id',
            'HoaDonId' => 'nullable|uuid|exists:HoaDon,Id',
            'TaiKhoanId' => 'nullable|uuid|exists:TaiKhoanNguoiDung,Id',
            'LoaiGiaoDich' => 'required_without:LoaiThuChi|in:Thu,Chi',
            'LoaiThuChi' => 'required_without:LoaiGiaoDich|in:Thu,Chi',
            'SoTien' => 'required|numeric|min:0',
            'NgayGiaoDich' => 'required_without:NgayThuChi|date',
            'NgayThuChi' => 'required_without:NgayGiaoDich|date',
            'Thang' => 'nullable|integer|min:1|max:12',
            'Nam' => 'nullable|integer|min:2000',
            'MoTa' => 'nullable|string|max:500',
            'NoiDung' => 'nullable|string|max:500',
            'ThamChieu' => 'nullable|string|max:100',
            'MaThuChi' => 'nullable|string|max:100',
        ]);

        try {
            $validated = $this->normalizeTransactionData($validated);
            $transaction = ThuChi::create($validated);
            if ($request->wantsJson()) {
                return response($transaction, 201);
            }

            return redirect()->route('transactions.index')->with('success', 'Thêm giao dịch thành công!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = ThuChi::findOrFail($id);
        if (request()->wantsJson()) {
            return $transaction;
        }

        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = ThuChi::findOrFail($id);
        if (request()->wantsJson()) {
            return $transaction;
        }

        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = ThuChi::findOrFail($id);

        $validated = $request->validate([
            'HopDongId' => 'nullable|uuid|exists:HopDong,Id',
            'HoaDonId' => 'nullable|uuid|exists:HoaDon,Id',
            'TaiKhoanId' => 'nullable|uuid|exists:TaiKhoanNguoiDung,Id',
            'LoaiGiaoDich' => 'required_without:LoaiThuChi|in:Thu,Chi',
            'LoaiThuChi' => 'required_without:LoaiGiaoDich|in:Thu,Chi',
            'SoTien' => 'required|numeric|min:0',
            'NgayGiaoDich' => 'required_without:NgayThuChi|date',
            'NgayThuChi' => 'required_without:NgayGiaoDich|date',
            'Thang' => 'nullable|integer|min:1|max:12',
            'Nam' => 'nullable|integer|min:2000',
            'MoTa' => 'nullable|string|max:500',
            'NoiDung' => 'nullable|string|max:500',
            'ThamChieu' => 'nullable|string|max:100',
            'MaThuChi' => 'nullable|string|max:100',
        ]);

        try {
            $validated = $this->normalizeTransactionData($validated);
            $transaction->update($validated);
            if ($request->wantsJson()) {
                return $transaction;
            }

            return redirect()->route('transactions.show', $transaction->Id)->with('success', 'Cập nhật giao dịch thành công!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = ThuChi::findOrFail($id);
            $transaction->delete();
            if (request()->wantsJson()) {
                return response(null, 204);
            }

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

    private function normalizeTransactionData(array $data): array
    {
        $data['LoaiGiaoDich'] = $data['LoaiGiaoDich'] ?? $data['LoaiThuChi'];
        $data['NgayGiaoDich'] = $data['NgayGiaoDich'] ?? $data['NgayThuChi'];
        $data['MoTa'] = $data['MoTa'] ?? ($data['NoiDung'] ?? null);
        $data['ThamChieu'] = $data['ThamChieu'] ?? ($data['MaThuChi'] ?? null);
        $data['Thang'] = $data['Thang'] ?? date('n', strtotime($data['NgayGiaoDich']));
        $data['Nam'] = $data['Nam'] ?? date('Y', strtotime($data['NgayGiaoDich']));

        unset($data['LoaiThuChi'], $data['NgayThuChi'], $data['NoiDung'], $data['MaThuChi']);

        return $data;
    }
}
