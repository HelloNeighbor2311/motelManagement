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
        $query = HopDong::forCurrentUser()->with(['canHo', 'khachHang']);

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

        if ($request->wantsJson()) {
            return $query->orderBy('NgayBatDau', 'desc')->get();
        }

        $contracts = $query->orderBy('NgayBatDau', 'desc')->paginate(15);

        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $apartments = CanHo::forCurrentUser()->orderBy('MaCanHo', 'asc')->get();
        $customers = KhachHang::forCurrentUser()->orderBy('HoTen', 'asc')->get();
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
            'ToaNhaId' => 'nullable|uuid|exists:ToaNha,Id',
            'GiaThue' => 'required_without:GiaThueThaoThuan|numeric|min:0',
            'GiaThueThaoThuan' => 'required_without:GiaThue|numeric|min:0',
            'TienDatCoc' => 'required|numeric|min:0',
            'TrangThai' => 'required_without:TrangThaiHopDong|in:active,expired,cancelled,renewed,HieuLuc,HetHan,HuyBo,GiaHan',
            'TrangThaiHopDong' => 'required_without:TrangThai|in:HieuLuc,HetHan,HuyBo,GiaHan,active,expired,cancelled,renewed',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            $validated['user_id'] = auth()->id();
            // Map incoming `TrangThai` form field to DB column `TrangThaiHopDong`
            $map = [
                'active' => 'HieuLuc',
                'expired' => 'HetHan',
                'cancelled' => 'HuyBo',
                'renewed' => 'GiaHan',
            ];
            $status = $validated['TrangThaiHopDong'] ?? $validated['TrangThai'];
            $validated['TrangThaiHopDong'] = $map[$status] ?? $status;
            unset($validated['TrangThai']);
            $validated['GiaThueThaoThuan'] = $validated['GiaThueThaoThuan'] ?? $validated['GiaThue'];
            unset($validated['GiaThue']);

            $model = HopDong::create($validated);

            if ($request->wantsJson()) {
                return response($model, 201);
            }

            return redirect()->route('contracts.index')->with('success', 'Thêm hợp đồng thành công!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $contract = HopDong::forCurrentUser()->with(['canHo', 'khachHang'])->findOrFail($id);
        if (request()->wantsJson()) {
            return $contract;
        }

        return view('contracts.show', compact('contract'));
    }

    public function edit($id)
    {
        $contract = HopDong::forCurrentUser()->findOrFail($id);
        $apartments = CanHo::forCurrentUser()->orderBy('MaCanHo', 'asc')->get();
        $customers = KhachHang::forCurrentUser()->orderBy('HoTen', 'asc')->get();
        if (request()->wantsJson()) {
            $contract->load(['canHo', 'khachHang']);
            return $contract;
        }

        return view('contracts.edit', compact('contract', 'apartments', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $contract = HopDong::forCurrentUser()->findOrFail($id);

        $validated = $request->validate([
            'MaHopDong' => 'required|string|max:50|unique:HopDong,MaHopDong,' . $id . ',Id',
            'CanHoId' => 'required|uuid|exists:CanHo,Id',
            'KhachHangId' => 'required|uuid|exists:KhachHang,Id',
            'NgayBatDau' => 'required|date',
            'NgayKetThuc' => 'required|date|after:NgayBatDau',
            'ToaNhaId' => 'nullable|uuid|exists:ToaNha,Id',
            'GiaThue' => 'required_without:GiaThueThaoThuan|numeric|min:0',
            'GiaThueThaoThuan' => 'required_without:GiaThue|numeric|min:0',
            'TienDatCoc' => 'required|numeric|min:0',
            'TrangThai' => 'required_without:TrangThaiHopDong|in:active,expired,cancelled,renewed,HieuLuc,HetHan,HuyBo,GiaHan',
            'TrangThaiHopDong' => 'required_without:TrangThai|in:HieuLuc,HetHan,HuyBo,GiaHan,active,expired,cancelled,renewed',
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
            $status = $validated['TrangThaiHopDong'] ?? $validated['TrangThai'];
            $validated['TrangThaiHopDong'] = $map[$status] ?? $status;
            unset($validated['TrangThai']);
            $validated['GiaThueThaoThuan'] = $validated['GiaThueThaoThuan'] ?? $validated['GiaThue'];
            unset($validated['GiaThue']);

            $contract->update($validated);

            if ($request->wantsJson()) {
                return $contract;
            }

            return redirect()->route('contracts.show', $contract->Id)->with('success', 'Cập nhật hợp đồng thành công!');
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
            $contract = HopDong::forCurrentUser()->findOrFail($id);
            $contract->delete();
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa hợp đồng thành công!'
                ]);
            }

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
