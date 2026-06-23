<?php

namespace App\Http\Controllers;

use App\Models\CanHo;
use App\Models\KhuVuc;
use App\Models\ToaNha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = CanHo::with('toaNha.khuVuc');

        if ($request->filled('area')) {
            $areaId = $request->string('area')->toString();

            $query->whereHas('toaNha', function ($query) use ($areaId) {
                $query->where('KhuVucId', $areaId);
            });
        }

        if ($request->filled('building')) {
            $query->where('ToaNhaId', $request->string('building')->toString());
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('MaCanHo', 'like', "%$search%")
                    ->orWhere('Tang', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('TrangThai', $request->string('status')->toString());
        }

        $apartments = $query->orderBy('ToaNhaId', 'asc')->orderBy('Tang', 'asc')->paginate(15);
        $areas = KhuVuc::orderBy('TenKhuVuc', 'asc')->get();
        $buildings = ToaNha::with('khuVuc')->orderBy('TenToaNha', 'asc')->get();

        return view('apartments.index', compact('apartments', 'areas', 'buildings'));
    }

    public function create()
    {
        $buildings = ToaNha::with('khuVuc')->orderBy('TenToaNha', 'asc')->get();

        return view('apartments.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ToaNhaId' => 'required|uuid|exists:ToaNha,Id',
            'MaCanHo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('CanHo', 'MaCanHo')->where('ToaNhaId', $request->input('ToaNhaId')),
            ],
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
            return back()->withInput()->with('error', 'Có lỗi xảy ra: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $apartment = CanHo::with('toaNha.khuVuc', 'hopDongs.khachHang')->findOrFail($id);

        return view('apartments.show', compact('apartment'));
    }

    public function edit($id)
    {
        $apartment = CanHo::with('toaNha.khuVuc')->findOrFail($id);
        $buildings = ToaNha::with('khuVuc')->orderBy('TenToaNha', 'asc')->get();

        return view('apartments.edit', compact('apartment', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $apartment = CanHo::findOrFail($id);

        $validated = $request->validate([
            'ToaNhaId' => 'required|uuid|exists:ToaNha,Id',
            'MaCanHo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('CanHo', 'MaCanHo')
                    ->where('ToaNhaId', $request->input('ToaNhaId'))
                    ->ignore($id, 'Id'),
            ],
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
            return back()->withInput()->with('error', 'Có lỗi xảy ra: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $apartment = CanHo::findOrFail($id);

            // Check if apartment has active contracts
            if ($apartment->hopDongs()->where('TrangThaiHopDong', 'HieuLuc')->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa căn hộ này vì có hợp đồng đang hoạt động!',
                ], 400);
            }

            $apartment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa căn hộ thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: '.$e->getMessage(),
            ], 500);
        }
    }

    public function floorPlan(Request $request)
    {
        $buildings = ToaNha::with('khuVuc')->orderBy('TenToaNha')->get();
        $building = $request->filled('building')
            ? $buildings->firstWhere('Id', $request->string('building')->toString())
            : $buildings->first();

        abort_if($request->filled('building') && ! $building, 404);

        $apartments = $building ? CanHo::where('ToaNhaId', $building->Id)
            ->orderBy('Tang', 'asc')
            ->get()
            ->groupBy('Tang') : collect();

        return view('apartments.floor-plan', compact('buildings', 'building', 'apartments'));
    }
}
