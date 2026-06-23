<?php

namespace App\Http\Controllers;

use App\Models\CanHo;
use App\Models\ToaNha;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = CanHo::with('toaNha');

        if ($request->has('building') && $request->building != '') {
            $query->where('ToaNhaId', $request->building);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('MaCanHo', 'like', "%$search%")
                    ->orWhere('Tang', 'like', "%$search%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('TrangThai', $request->status);
        }

        $apartments = $query->orderBy('ToaNhaId', 'asc')->orderBy('Tang', 'asc')->paginate(15);
        $buildings = ToaNha::orderBy('TenToaNha', 'asc')->get();

        return view('apartments.index', compact('apartments', 'buildings'));
    }

    public function create()
    {
        $buildings = ToaNha::orderBy('TenToaNha', 'asc')->get();
        return view('apartments.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ToaNhaId' => 'required|uuid|exists:ToaNha,Id',
            'MaCanHo' => 'required|string|max:50|unique:CanHo,MaCanHo',
            'Tang' => 'required|integer|min:1|max:100',
            'DienTich' => 'required|numeric|min:0.1',
            'SoPhong' => 'required|integer|min:1|max:10',
            'TrangThai' => 'required|in:Trong,DangThue,BaoTri',
            'GiaThue' => 'required|numeric|min:0',
        ]);

        try {
            CanHo::create($validated);
            return redirect()->route('apartments.index')->with('success', 'Thêm căn hộ thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $apartment = CanHo::findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }

    public function edit($id)
    {
        $apartment = CanHo::findOrFail($id);
        $buildings = ToaNha::orderBy('TenToaNha', 'asc')->get();
        return view('apartments.edit', compact('apartment', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $apartment = CanHo::findOrFail($id);

        $validated = $request->validate([
            'ToaNhaId' => 'required|uuid|exists:ToaNha,Id',
            'MaCanHo' => 'required|string|max:50|unique:CanHo,MaCanHo,' . $id . ',Id',
            'Tang' => 'required|integer|min:1|max:100',
            'DienTich' => 'required|numeric|min:0.1',
            'SoPhong' => 'required|integer|min:1|max:10',
            'TrangThai' => 'required|in:Trong,DangThue,BaoTri',
            'GiaThue' => 'required|numeric|min:0',
        ]);

        try {
            $apartment->update($validated);
            return redirect()->route('apartments.show', $apartment->Id)->with('success', 'Cập nhật căn hộ thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $apartment = CanHo::findOrFail($id);

            // Check if apartment has active contracts
            if ($apartment->hopDongs()->where('TrangThai', 'active')->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa căn hộ này vì có hợp đồng đang hoạt động!'
                ]);
            }

            $apartment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa căn hộ thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function floorPlan($buildingId)
    {
        $building = ToaNha::findOrFail($buildingId);
        $apartments = CanHo::where('ToaNhaId', $buildingId)
            ->orderBy('Tang', 'asc')
            ->get()
            ->groupBy('Tang');

        return view('apartments.floor-plan', compact('building', 'apartments'));
    }
}
