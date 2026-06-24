<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\ThongTinKhachHang;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = KhachHang::with('thongTinCaNhan');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('HoTen', 'like', "%$search%")
                    ->orWhere('SoDienThoai', 'like', "%$search%")
                    ->orWhere('Email', 'like', "%$search%");
            });
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('LoaiKhachHang', $request->type === 'Nhan' ? 'CaNhan' : ($request->type === 'Doanh' ? 'DoanhNghiep' : $request->type));
        }

        $customers = $query->orderBy('HoTen', 'asc')->paginate(15);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'TenKhachHang' => 'required|string|max:200',
            'SoDienThoai' => 'required|string|max:20|unique:KhachHang,SoDienThoai',
            'Email' => 'required|email|unique:KhachHang,Email',
            'DiaChi' => 'required|string|max:200',
            'CCCD' => 'required|string|max:50',
            'LoaiKhach' => 'required|in:Nhan,Doanh',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            // Map incoming legacy form fields to actual DB columns
            $khData = [
                'HoTen' => $validated['TenKhachHang'],
                'SoDienThoai' => $validated['SoDienThoai'],
                'Email' => $validated['Email'],
                'LoaiKhachHang' => $validated['LoaiKhach'] === 'Nhan' ? 'CaNhan' : 'DoanhNghiep',
            ];


            // Ensure CCCD is unique across ThongTinKhachHang
            if (ThongTinKhachHang::where('SoGiayTo', $validated['CCCD'])->exists()) {
                return back()->withInput()->withErrors(['CCCD' => 'CCCD/MST đã tồn tại trong hệ thống.']);
            }

            $customer = KhachHang::create($khData);

            // Create related ThongTinKhachHang record for SoGiayTo/DiaChi/GhiChu
            ThongTinKhachHang::create([
                'KhachHangId' => $customer->Id,
                'SoGiayTo' => $validated['CCCD'],
                'DiaChiThuongTru' => $validated['DiaChi'],
                'GhiChu' => $validated['GhiChu'] ?? null,
            ]);

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
            'TenKhachHang' => 'required|string|max:200',
            'SoDienThoai' => 'required|string|max:20|unique:KhachHang,SoDienThoai,' . $id . ',Id',
            'Email' => 'required|email|unique:KhachHang,Email,' . $id . ',Id',
            'DiaChi' => 'required|string|max:200',
            'CCCD' => 'required|string|max:50',
            'LoaiKhach' => 'required|in:Nhan,Doanh',
            'GhiChu' => 'nullable|string|max:500',
        ]);

        try {
            // Map to DB columns

            $khData = [
                'HoTen' => $validated['TenKhachHang'],
                'SoDienThoai' => $validated['SoDienThoai'],
                'Email' => $validated['Email'],
                'LoaiKhachHang' => $validated['LoaiKhach'] === 'Nhan' ? 'CaNhan' : 'DoanhNghiep',
            ];

            $customer->update($khData);

            // Ensure CCCD uniqueness (not used as a column on KhachHang)
            if (ThongTinKhachHang::where('SoGiayTo', $validated['CCCD'])->where('KhachHangId', '<>', $id)->exists()) {
                return back()->withInput()->withErrors(['CCCD' => 'CCCD/MST đã tồn tại trong hệ thống.']);
            }

            // Update or create ThongTinKhachHang with SoGiayTo
            $tt = $customer->thongTinCaNhan;
            if ($tt) {
                $tt->update([
                    'SoGiayTo' => $validated['CCCD'],
                    'DiaChiThuongTru' => $validated['DiaChi'],
                    'GhiChu' => $validated['GhiChu'] ?? null,
                ]);
            } else {
                ThongTinKhachHang::create([
                    'KhachHangId' => $customer->Id,
                    'SoGiayTo' => $validated['CCCD'],
                    'DiaChiThuongTru' => $validated['DiaChi'],
                    'GhiChu' => $validated['GhiChu'] ?? null,
                ]);
            }

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

    public function info($id = null)
    {
        if ($id) {
            $customer = KhachHang::with('thongTinCaNhan')->findOrFail($id);
            return view('customers.info', compact('customer'));
        }

        // No id provided — render the info page without a specific customer.
        // The view can handle displaying the current user's info or a prompt to select a customer.
        return view('customers.info');
    }
}
