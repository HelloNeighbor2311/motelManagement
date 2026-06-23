<?php

namespace App\Http\Controllers;

use App\Models\KhuVuc;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    // List all areas
    public function index(Request $request)
    {
        $areas = KhuVuc::withCount(['toaNhas as toaNhas_count'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('TenKhuVuc', 'like', "%{$search}%")
                        ->orWhere('DiaChi', 'like', "%{$search}%");
                });
            })
            ->orderBy('TenKhuVuc')
            ->get();

        return view('areas.index', compact('areas'));
    }

    // Show create form
    public function create()
    {
        return view('areas.create');
    }

    // Store new area
    public function store(Request $request)
    {
        $validated = $request->validate([
            'TenKhuVuc' => 'required|string|max:200',
            'DiaChi' => 'nullable|string|max:500',
            'MoTa' => 'nullable|string|max:1000',
        ]);

        try {
            KhuVuc::create($validated);

            return redirect()->route('areas.index')
                ->with('success', 'Thêm khu vực thành công!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    // Show area details
    public function show($id)
    {
        $area = KhuVuc::findOrFail($id);
        $buildings = $area->toaNhas()->with('canHos')->get();

        return view('areas.show', compact('area', 'buildings'));
    }

    // Show edit form
    public function edit($id)
    {
        $area = KhuVuc::findOrFail($id);

        return view('areas.edit', compact('area'));
    }

    // Update area
    public function update(Request $request, $id)
    {
        $area = KhuVuc::findOrFail($id);

        $validated = $request->validate([
            'TenKhuVuc' => 'required|string|max:200',
            'DiaChi' => 'nullable|string|max:500',
            'MoTa' => 'nullable|string|max:1000',
        ]);

        try {
            $area->update($validated);

            return redirect()->route('areas.index')
                ->with('success', 'Cập nhật khu vực thành công!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    // Delete area
    public function destroy($id)
    {
        try {
            $area = KhuVuc::findOrFail($id);

            // Check if area has buildings
            if ($area->toaNhas()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa khu vực đang có tòa nhà!',
                ], 400);
            }

            $area->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa khu vực thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: '.$e->getMessage(),
            ], 500);
        }
    }
}
