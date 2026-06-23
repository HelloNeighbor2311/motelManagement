<?php

namespace App\Http\Controllers;

use App\Models\ToaNha;
use App\Models\KhuVuc;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    // List all buildings
    public function index()
    {
        $buildings = ToaNha::with('khuVuc')->withCount('canHos')->get();
        $areas = KhuVuc::all();
        return view('buildings.index', compact('buildings', 'areas'));
    }

    // Show create form
    public function create()
    {
        $areas = KhuVuc::all();
        return view('buildings.create', compact('areas'));
    }

    // Store new building
    public function store(Request $request)
    {
        $validated = $request->validate([
            'KhuVucId' => 'required|exists:KhuVuc,Id',
            'TenToaNha' => 'required|string|max:200',
            'SoTang' => 'required|integer|min:1',
            'MoTa' => 'nullable|string|max:1000',
        ]);

        try {
            ToaNha::create($validated);
            return redirect()->route('buildings.index')
                ->with('success', 'Thêm tòa nhà thành công!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Show building details
    public function show($id)
    {
        $building = ToaNha::with('khuVuc', 'canHos')->findOrFail($id);
        return view('buildings.show', compact('building'));
    }

    // Show edit form
    public function edit($id)
    {
        $building = ToaNha::findOrFail($id);
        $areas = KhuVuc::all();
        return view('buildings.edit', compact('building', 'areas'));
    }

    // Update building
    public function update(Request $request, $id)
    {
        $building = ToaNha::findOrFail($id);

        $validated = $request->validate([
            'KhuVucId' => 'required|exists:KhuVuc,Id',
            'TenToaNha' => 'required|string|max:200',
            'SoTang' => 'required|integer|min:1',
            'MoTa' => 'nullable|string|max:1000',
        ]);

        try {
            $building->update($validated);
            return redirect()->route('buildings.index')
                ->with('success', 'Cập nhật tòa nhà thành công!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Delete building
    public function destroy($id)
    {
        try {
            $building = ToaNha::findOrFail($id);
            
            // Check if building has apartments
            if ($building->canHos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tòa nhà đang có căn hộ!'
                ], 400);
            }

            $building->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa tòa nhà thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}

