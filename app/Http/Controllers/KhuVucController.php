<?php

namespace App\Http\Controllers;

use App\Models\KhuVuc;
use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    public function index()
    {
        return KhuVuc::all();
    }

    public function show($id)
    {
        return KhuVuc::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['TenKhuVuc','DiaChi','MoTa']);
        $model = KhuVuc::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = KhuVuc::findOrFail($id);
        $m->update($request->only(['TenKhuVuc','DiaChi','MoTa']));
        return $m;
    }

    public function destroy($id)
    {
        KhuVuc::findOrFail($id)->delete();
        return response(null, 204);
    }
}
