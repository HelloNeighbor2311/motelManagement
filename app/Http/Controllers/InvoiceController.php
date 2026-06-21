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
            $query->where('TrangThai', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('MaHoaDon', 'like', "%$search%")
                    ->orWhereHas('khachHang', function ($q2) use ($search) {
                        $q2->where('TenKhachHang', 'like', "%$search%");
                    });
            });
        }

        $invoices = $query->orderBy('NgayLap', 'desc')->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = KhachHang::orderBy('TenKhachHang', 'asc')->get();
        $contracts = HopDong::where('TrangThai', 'active')->with('canHo')->get();
        return view('invoices.create', compact('customers', 'contracts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MaHoaDon' => 'required|string|max:50|unique:HoaDon,MaHoaDon',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'HopDongId' => 'nullable|uuid|exists:HopDong,Id',
            'NgayLap' => 'required|date',
            'NgayDuKien' => 'required|date|after_or_equal:NgayLap',
            'TongTien' => 'required|numeric|min:0',
            'GhiChu' => 'nullable|string|max:500',
            'TrangThai' => 'required|in:Chua,DaThanhToan,QuaHan',
        ]);

        try {
            HoaDon::create($validated);
            return redirect()->route('invoices.index')->with('success', 'Thêm hóa đơn thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $invoice = HoaDon::with(['khachHang', 'hopDong'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = HoaDon::findOrFail($id);
        $customers = KhachHang::orderBy('TenKhachHang', 'asc')->get();
        $contracts = HopDong::with('canHo')->get();
        return view('invoices.edit', compact('invoice', 'customers', 'contracts'));
    }

    public function update(Request $request, $id)
    {
        $invoice = HoaDon::findOrFail($id);

        $validated = $request->validate([
            'MaHoaDon' => 'required|string|max:50|unique:HoaDon,MaHoaDon,' . $id . ',Id',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'HopDongId' => 'nullable|uuid|exists:HopDong,Id',
            'NgayLap' => 'required|date',
            'NgayDuKien' => 'required|date|after_or_equal:NgayLap',
            'TongTien' => 'required|numeric|min:0',
            'GhiChu' => 'nullable|string|max:500',
            'TrangThai' => 'required|in:Chua,DaThanhToan,QuaHan',
        ]);

        try {
            $invoice->update($validated);
            return redirect()->route('invoices.show', $invoice->Id)->with('success', 'Cập nhật hóa đơn thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $invoice = HoaDon::findOrFail($id);
            $invoice->delete();
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
            $invoice->update(['TrangThai' => 'DaThanhToan']);
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
