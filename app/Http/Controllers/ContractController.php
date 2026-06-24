<?php

namespace App\Http\Controllers;

use App\Models\HopDong;
use App\Models\CanHo;
use App\Models\KhachHang;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = HopDong::with(['canHo', 'khachHang']);

        if ($request->has('status') && $request->status != '') {
            // Translate possible legacy/frontend statuses to DB values
            $status = $request->status;
            $map = [
                'active' => 'HieuLuc',
                'expired' => 'HetHan',
                'cancelled' => 'HuyBo',
                'renewed' => 'GiaHan',
            ];
            $dbStatus = $map[$status] ?? $status;
            $query->where('TrangThaiHopDong', $dbStatus);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('MaHopDong', 'like', "%$search%")
                    ->orWhereHas('canHo', function ($q2) use ($search) {
                        $q2->where('MaCanHo', 'like', "%$search%");
                    })
                    ->orWhereHas('khachHang', function ($q3) use ($search) {
                        $q3->where('HoTen', 'like', "%$search%");
                    });
            });
        }

        $contracts = $query->orderBy('NgayBatDau', 'desc')->paginate(15);

        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $apartments = CanHo::orderBy('MaCanHo', 'asc')->get();
        $customers = KhachHang::orderBy('HoTen', 'asc')->get();
        return view('contracts.create', compact('apartments', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MaHopDong' => 'required|string|max:50|unique:HopDong,MaHopDong',
            'CanHoId' => 'required|uuid|exists:CanHo,Id',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after:NgayBatDau',
            'GiaThue' => 'required|numeric|min:0',
            'TienDatCoc' => 'required|numeric|min:0',
            'TrangThai' => 'required|in:active,expired,cancelled,renewed',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            // Map incoming `TrangThai` form field to DB column `TrangThaiHopDong`
            $map = [
                'active' => 'HieuLuc',
                'expired' => 'HetHan',
                'cancelled' => 'HuyBo',
                'renewed' => 'GiaHan',
            ];
            $validated['TrangThaiHopDong'] = $map[$validated['TrangThai']] ?? $validated['TrangThai'];
            unset($validated['TrangThai']);

            HopDong::create($validated);
            return redirect()->route('contracts.index')->with('success', 'Thêm hợp đồng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $contract = HopDong::with(['canHo', 'khachHang'])->findOrFail($id);
        return view('contracts.show', compact('contract'));
    }

    public function edit($id)
    {
        $contract = HopDong::findOrFail($id);
        $apartments = CanHo::orderBy('MaCanHo', 'asc')->get();
        $customers = KhachHang::orderBy('HoTen', 'asc')->get();
        return view('contracts.edit', compact('contract', 'apartments', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $contract = HopDong::findOrFail($id);

        $validated = $request->validate([
            'MaHopDong' => 'required|string|max:50|unique:HopDong,MaHopDong,' . $id . ',Id',
            'CanHoId' => 'required|uuid|exists:CanHo,Id',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after:NgayBatDau',
            'GiaThue' => 'required|numeric|min:0',
            'TienDatCoc' => 'required|numeric|min:0',
            'TrangThai' => 'required|in:active,expired,cancelled,renewed',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            // Translate `TrangThai` to DB column `TrangThaiHopDong` before update
            $map = [
                'active' => 'HieuLuc',
                'expired' => 'HetHan',
                'cancelled' => 'HuyBo',
                'renewed' => 'GiaHan',
            ];
            $validated['TrangThaiHopDong'] = $map[$validated['TrangThai']] ?? $validated['TrangThai'];
            unset($validated['TrangThai']);

            $contract->update($validated);
            return redirect()->route('contracts.show', $contract->Id)->with('success', 'Cập nhật hợp đồng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $contract = HopDong::findOrFail($id);
            $contract->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa hợp đồng thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
