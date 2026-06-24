<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\HopDong;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = HoaDon::with(['khachHang', 'hopDong']);

        if ($request->has('status') && $request->status != '') {
            $query->where('TrangThaiThanhToan', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('MaHoaDon', 'like', "%$search%")
                    ->orWhereHas('khachHang', function ($q2) use ($search) {
                        $q2->where('HoTen', 'like', "%$search%");
                    });
            });
        }

        if ($request->wantsJson()) {
            return $query->orderBy('NgayPhatHanh', 'desc')->get();
        }

        $invoices = $query->orderBy('NgayPhatHanh', 'desc')->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = KhachHang::orderBy('HoTen', 'asc')->get();
        $contracts = HopDong::where('TrangThaiHopDong', 'HieuLuc')->with('canHo')->get();
        return view('invoices.create', compact('customers', 'contracts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MaHoaDon' => 'required|string|max:50|unique:HoaDon,MaHoaDon',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'HopDongId' => 'nullable|uuid|exists:HopDong,Id',
            'NgayPhatHanh' => 'required|date',
            'NgayDenHan' => 'required|date|after_or_equal:NgayPhatHanh',
            'SoTien' => 'required|numeric|min:0',
            'LoaiHoaDon' => 'nullable|string|max:50',
            'Thang' => 'nullable|integer|min:1|max:12',
            'Nam' => 'nullable|integer|min:2000',
            'GhiChu' => 'nullable|string|max:500',
            'TrangThaiThanhToan' => 'nullable|in:ChuaThanhToan,DaThanhToan,QuaHan,HuyBo',
        ]);

        try {
            $validated['TrangThaiThanhToan'] = $validated['TrangThaiThanhToan'] ?? 'ChuaThanhToan';
            $validated['Thang'] = $validated['Thang'] ?? date('n', strtotime($validated['NgayPhatHanh']));
            $validated['Nam'] = $validated['Nam'] ?? date('Y', strtotime($validated['NgayPhatHanh']));
            $invoice = HoaDon::create($validated);
            if ($request->wantsJson()) {
                return response($invoice, 201);
            }

            return redirect()->route('invoices.index')->with('success', 'Thêm hóa đơn thành công!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $invoice = HoaDon::with(['khachHang', 'hopDong'])->findOrFail($id);
        if (request()->wantsJson()) {
            return $invoice;
        }

        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = HoaDon::findOrFail($id);
        $customers = KhachHang::orderBy('HoTen', 'asc')->get();
        $contracts = HopDong::with('canHo')->get();
        if (request()->wantsJson()) {
            $invoice->load(['khachHang', 'hopDong']);
            return $invoice;
        }

        return view('invoices.edit', compact('invoice', 'customers', 'contracts'));
    }

    public function update(Request $request, $id)
    {
        $invoice = HoaDon::findOrFail($id);

        $validated = $request->validate([
            'MaHoaDon' => 'required|string|max:50|unique:HoaDon,MaHoaDon,' . $id . ',Id',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'HopDongId' => 'nullable|uuid|exists:HopDong,Id',
            'NgayPhatHanh' => 'required|date',
            'NgayDenHan' => 'required|date|after_or_equal:NgayPhatHanh',
            'SoTien' => 'required|numeric|min:0',
            'LoaiHoaDon' => 'nullable|string|max:50',
            'Thang' => 'nullable|integer|min:1|max:12',
            'Nam' => 'nullable|integer|min:2000',
            'GhiChu' => 'nullable|string|max:500',
            'TrangThaiThanhToan' => 'nullable|in:ChuaThanhToan,DaThanhToan,QuaHan,HuyBo',
        ]);

        try {
            $validated['TrangThaiThanhToan'] = $validated['TrangThaiThanhToan'] ?? $invoice->TrangThaiThanhToan;
            $validated['Thang'] = $validated['Thang'] ?? date('n', strtotime($validated['NgayPhatHanh']));
            $validated['Nam'] = $validated['Nam'] ?? date('Y', strtotime($validated['NgayPhatHanh']));
            $invoice->update($validated);
            if ($request->wantsJson()) {
                return $invoice;
            }

            return redirect()->route('invoices.show', $invoice->Id)->with('success', 'Cập nhật hóa đơn thành công!');
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
            $invoice = HoaDon::findOrFail($id);
            $invoice->delete();
            if (request()->wantsJson()) {
                return response(null, 204);
            }

            return response()->json([
                'success' => true,
                'message' => 'Xóa hóa đơn thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markPaid($id)
    {
        try {
            $invoice = HoaDon::findOrFail($id);
            $invoice->update(['TrangThaiThanhToan' => 'DaThanhToan', 'NgayThanhToan' => now()]);
            return response()->json([
                'success' => true,
                'message' => 'Đánh dấu hóa đơn là đã thanh toán!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
