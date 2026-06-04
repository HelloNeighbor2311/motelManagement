<?php

namespace App\Http\Controllers;

use App\Models\CanHo;
use Illuminate\Http\Request;

class CanHoController extends Controller
{
    public function index()
    {
        return CanHo::all();
    }

    public function show($id)
    {
        return CanHo::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['ToaNhaId','MaCanHo','Tang','DienTich','SoPhong','TrangThai','GiaThue']);
        $model = CanHo::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = CanHo::findOrFail($id);
        $m->update($request->only(['ToaNhaId','MaCanHo','Tang','DienTich','SoPhong','TrangThai','GiaThue']));
        return $m;
    }

    public function destroy($id)
    {
        CanHo::findOrFail($id)->delete();
        return response(null, 204);
    }
}
