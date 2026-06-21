<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\ThongTinCaNhan;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = KhachHang::with('thongTinCaNhan');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('TenKhachHang', 'like', "%$search%")
                    ->orWhere('SoDienThoai', 'like', "%$search%")
                    ->orWhere('Email', 'like', "%$search%");
            });
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('LoaiKhach', $request->type);
        }

        $customers = $query->orderBy('TenKhachHang', 'asc')->paginate(15);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'TenKhachHang' => 'required|string|max:100',
            'SoDienThoai' => 'required|string|max:20|unique:KhachHang,SoDienThoai',
            'Email' => 'required|email|unique:KhachHang,Email',
            'DiaChi' => 'required|string|max:200',
            'CCCD' => 'required|string|max:20|unique:KhachHang,CCCD',
            'LoaiKhach' => 'required|in:Nhan,Doanh',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            KhachHang::create($validated);
            return redirect()->route('customers.index')->with('success', 'Thêm khách hàng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $customer = KhachHang::with('thongTinCaNhan', 'hopDongs', 'hoaDons')->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = KhachHang::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = KhachHang::findOrFail($id);

        $validated = $request->validate([
            'TenKhachHang' => 'required|string|max:100',
            'SoDienThoai' => 'required|string|max:20|unique:KhachHang,SoDienThoai,' . $id . ',Id',
            'Email' => 'required|email|unique:KhachHang,Email,' . $id . ',Id',
            'DiaChi' => 'required|string|max:200',
            'CCCD' => 'required|string|max:20|unique:KhachHang,CCCD,' . $id . ',Id',
            'LoaiKhach' => 'required|in:Nhan,Doanh',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            $customer->update($validated);
            return redirect()->route('customers.show', $customer->Id)->with('success', 'Cập nhật khách hàng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $customer = KhachHang::findOrFail($id);

            // Check if customer has active contracts
            if ($customer->hopDongs()->where('TrangThai', 'active')->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa khách hàng có hợp đồng đang hoạt động!'
                ]);
            }

            $customer->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa khách hàng thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function info($id)
    {
        $customer = KhachHang::with('thongTinCaNhan')->findOrFail($id);
        return view('customers.info', compact('customer'));
    }
}
