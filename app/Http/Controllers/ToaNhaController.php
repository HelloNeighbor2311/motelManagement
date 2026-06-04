<?php

namespace App\Http\Controllers;

use App\Models\ToaNha;
use Illuminate\Http\Request;

class ToaNhaController extends Controller
{
    public function index()
    {
        return ToaNha::all();
    }

    public function show($id)
    {
        return ToaNha::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['KhuVucId','TenToaNha','SoTang','MoTa']);
        $model = ToaNha::create($data);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = ToaNha::findOrFail($id);
        $m->update($request->only(['KhuVucId','TenToaNha','SoTang','MoTa']));
        return $m;
    }

    public function destroy($id)
    {
        ToaNha::findOrFail($id)->delete();
        return response(null, 204);
    }
}
