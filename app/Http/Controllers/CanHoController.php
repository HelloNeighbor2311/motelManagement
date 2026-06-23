<?php

namespace App\Http\Controllers;

use App\Models\CanHo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CanHoController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'area' => ['nullable', 'exists:KhuVuc,Id'],
            'building' => ['nullable', 'exists:ToaNha,Id'],
            'status' => ['nullable', Rule::in(['Trong', 'DangThue', 'BaoTri'])],
            'search' => ['nullable', 'string', 'max:200'],
        ]);

        $query = CanHo::query()->with('toaNha.khuVuc');

        if ($request->filled('area')) {
            $query->whereHas('toaNha', function ($query) use ($request) {
                $query->where('KhuVucId', $request->input('area'));
            });
        }

        if ($request->filled('building')) {
            $query->where('ToaNhaId', $request->input('building'));
        }

        if ($request->filled('status')) {
            $query->where('TrangThai', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($query) use ($search) {
                $query->where('MaCanHo', 'like', "%{$search}%")
                    ->orWhereHas('toaNha', function ($query) use ($search) {
                        $query->where('TenToaNha', 'like', "%{$search}%")
                            ->orWhereHas('khuVuc', function ($query) use ($search) {
                                $query->where('TenKhuVuc', 'like', "%{$search}%");
                            });
                    });
            });
        }

        return $query->get();
    }

    public function show($id)
    {
        return CanHo::with('toaNha.khuVuc')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ToaNhaId' => ['required', 'exists:ToaNha,Id'],
            'MaCanHo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('CanHo', 'MaCanHo')->where(function ($query) use ($request) {
                    return $query->where('ToaNhaId', $request->input('ToaNhaId'));
                }),
            ],
            'Tang' => ['required', 'integer', 'min:1'],
            'DienTich' => ['required', 'numeric', 'min:0'],
            'SoPhong' => ['required', 'integer', 'min:1'],
            'TrangThai' => ['required', Rule::in(['Trong', 'DangThue', 'BaoTri'])],
            'GiaThue' => ['required', 'numeric', 'min:0'],
        ]);

        $model = CanHo::create($data);

        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = CanHo::findOrFail($id);
        $data = $request->validate([
            'ToaNhaId' => ['required', 'exists:ToaNha,Id'],
            'MaCanHo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('CanHo', 'MaCanHo')->where(function ($query) use ($request) {
                    return $query->where('ToaNhaId', $request->input('ToaNhaId'));
                })->ignore($id, 'Id'),
            ],
            'Tang' => ['required', 'integer', 'min:1'],
            'DienTich' => ['required', 'numeric', 'min:0'],
            'SoPhong' => ['required', 'integer', 'min:1'],
            'TrangThai' => ['required', Rule::in(['Trong', 'DangThue', 'BaoTri'])],
            'GiaThue' => ['required', 'numeric', 'min:0'],
        ]);

        $m->update($data);

        return $m;
    }

    public function destroy($id)
    {
        $canHo = CanHo::findOrFail($id);

        if ($canHo->hopDongs()->where('TrangThaiHopDong', 'HieuLuc')->exists()) {
            return response()->json([
                'message' => 'Khong the xoa can ho dang co hop dong hieu luc.',
            ], 409);
        }

        $canHo->delete();

        return response(null, 204);
    }
}
