<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function index()
    {
        return KhachHang::all();
    }

    public function show($id)
    {
        return KhachHang::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'HoTen' => 'required|string|max:200',
            'LoaiKhachHang' => 'required|in:CaNhan,DoanhNghiep,NuocNgoai',
            'SoDienThoai' => 'required|string|max:20',
            'Email' => 'nullable|email|max:255',
        ]);

        $model = KhachHang::create($validated);
        return response($model, 201);
    }

    public function update(Request $request, $id)
    {
        $m = KhachHang::findOrFail($id);
        $validated = $request->validate([
            'HoTen' => 'sometimes|required|string|max:200',
            'LoaiKhachHang' => 'sometimes|required|in:CaNhan,DoanhNghiep,NuocNgoai',
            'SoDienThoai' => 'sometimes|required|string|max:20',
            'Email' => 'nullable|email|max:255',
        ]);

        $m->update($validated);
        return $m;
    }

    public function destroy($id)
    {
        KhachHang::findOrFail($id)->delete();
        return response(null, 204);
    }
}
