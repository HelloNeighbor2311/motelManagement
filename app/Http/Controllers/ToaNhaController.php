<?php

namespace App\Http\Controllers;

use App\Models\ToaNha;
use Illuminate\Http\Request;

class ToaNhaController extends Controller
{
    public function index(Request $request)
    {
        $query = ToaNha::query()
            ->with('khuVuc')
            ->withCount('canHos');

        if ($request->filled('area')) {
            $query->where('KhuVucId', $request->input('area'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($query) use ($search) {
                $query->where('TenToaNha', 'like', "%{$search}%")
                    ->orWhere('MoTa', 'like', "%{$search}%")
                    ->orWhereHas('khuVuc', function ($query) use ($search) {
                        $query->where('TenKhuVuc', 'like', "%{$search}%");
                    });
            });
        }

        return $query->get();
    }

    public function show($id)
    {
        return ToaNha::with(['khuVuc', 'canHos'])
            ->withCount('canHos')
            ->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'KhuVucId' => ['required', 'exists:KhuVuc,Id'],
            'TenToaNha' => ['required', 'string', 'max:200'],
            'SoTang' => ['required', 'integer', 'min:1'],
            'MoTa' => ['nullable', 'string', 'max:1000'],
        ]);

        $model = ToaNha::create($data);

        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = ToaNha::findOrFail($id);
        $data = $request->validate([
            'KhuVucId' => ['required', 'exists:KhuVuc,Id'],
            'TenToaNha' => ['required', 'string', 'max:200'],
            'SoTang' => ['required', 'integer', 'min:1'],
            'MoTa' => ['nullable', 'string', 'max:1000'],
        ]);

        $m->update($data);

        return $m;
    }

    public function destroy($id)
    {
        $toaNha = ToaNha::findOrFail($id);

        if ($toaNha->canHos()->exists()) {
            return response()->json([
                'message' => 'Khong the xoa toa nha dang co can ho.',
            ], 409);
        }

        $toaNha->delete();

        return response(null, 204);
    }
}
