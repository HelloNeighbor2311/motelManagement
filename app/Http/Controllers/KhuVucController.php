<?php

namespace App\Http\Controllers;

use App\Models\KhuVuc;
use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    public function index(Request $request)
    {
        $query = KhuVuc::query()->withCount('toaNhas');

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($query) use ($search) {
                $query->where('TenKhuVuc', 'like', "%{$search}%")
                    ->orWhere('DiaChi', 'like', "%{$search}%")
                    ->orWhere('MoTa', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function show($id)
    {
        return KhuVuc::with('toaNhas')
            ->withCount('toaNhas')
            ->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'TenKhuVuc' => ['required', 'string', 'max:200'],
            'DiaChi' => ['nullable', 'string', 'max:500'],
            'MoTa' => ['nullable', 'string', 'max:1000'],
        ]);

        $model = KhuVuc::create($data);

        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = KhuVuc::findOrFail($id);
        $data = $request->validate([
            'TenKhuVuc' => ['required', 'string', 'max:200'],
            'DiaChi' => ['nullable', 'string', 'max:500'],
            'MoTa' => ['nullable', 'string', 'max:1000'],
        ]);

        $m->update($data);

        return $m;
    }

    public function destroy($id)
    {
        $khuVuc = KhuVuc::findOrFail($id);

        if ($khuVuc->toaNhas()->exists()) {
            return response()->json([
                'message' => 'Khong the xoa khu vuc dang co toa nha.',
            ], 409);
        }

        $khuVuc->delete();

        return response(null, 204);
    }
}
