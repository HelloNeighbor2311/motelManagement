<?php

namespace App\Http\Controllers;

use App\Models\KhuVuc;
use App\Models\ToaNha;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    // List all buildings
    public function index(Request $request)
    {
        $buildings = ToaNha::with('khuVuc')
            ->withCount(['canHos as canHos_count'])
            ->when($request->filled('area'), function ($query) use ($request) {
                $query->where('KhuVucId', $request->string('area')->toString());
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('TenToaNha', 'like', "%{$search}%")
                        ->orWhere('MoTa', 'like', "%{$search}%");
                });
            })
            ->orderBy('TenToaNha');

        if ($request->wantsJson()) {
            return $buildings->get();
        }

        $buildings = $buildings->get();
        $areas = KhuVuc::orderBy('TenKhuVuc')->get();

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
            $building = ToaNha::create($validated);

            if ($request->wantsJson()) {
                return response($building, 201);
            }

            return redirect()->route('buildings.index')
                ->with('success', 'Thêm tòa nhà thành công!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->withInput()
                ->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    // Show building details
    public function show($id)
    {
        $building = ToaNha::with('khuVuc', 'canHos')->findOrFail($id);

        if (request()->wantsJson()) {
            return $building->loadCount('canHos');
        }

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

            if (request()->wantsJson()) {
                return $building;
            }

            return redirect()->route('buildings.index')
                ->with('success', 'Cập nhật tòa nhà thành công!');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return back()->withInput()
                ->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    // Delete building
    public function destroy($id)
    {
        try {
            $building = ToaNha::findOrFail($id);

            // Check if building has apartments
            if ($building->canHos()->count() > 0) {
                if (request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể xóa tòa nhà đang có căn hộ!',
                    ], 400);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tòa nhà đang có căn hộ!',
                ], 400);
            }

            $building->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa tòa nhà thành công!',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Xóa tòa nhà thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: '.$e->getMessage(),
            ], 500);
        }
    }
}
