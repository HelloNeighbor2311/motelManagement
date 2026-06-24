<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KhachHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['HoTen' => 'Nguyễn Văn A', 'LoaiKhachHang' => 'CaNhan', 'QuocTich' => 'VN', 'SoDienThoai' => '0909000001', 'Email' => 'a@example.com'],
            ['HoTen' => 'Công ty B', 'LoaiKhachHang' => 'DoanhNghiep', 'QuocTich' => 'VN', 'SoDienThoai' => '0909000002', 'Email' => 'b@company.com'],
            ['HoTen' => 'John Doe', 'LoaiKhachHang' => 'NuocNgoai', 'QuocTich' => 'US', 'SoDienThoai' => '+12025550123', 'Email' => 'john@example.com'],
            ['HoTen' => 'Trần Thị C', 'LoaiKhachHang' => 'CaNhan', 'QuocTich' => 'VN', 'SoDienThoai' => '0909000003', 'Email' => 'c@example.com'],
        ];

        foreach ($items as $item) {
            $exists = DB::table('KhachHang')->where('Email', $item['Email'])->exists();
            if ($exists) continue;

            $id = (string) Str::uuid();

            DB::table('KhachHang')->insert([
                'Id' => $id,
                'HoTen' => $item['HoTen'],
                'LoaiKhachHang' => $item['LoaiKhachHang'],
                'SoDienThoai' => $item['SoDienThoai'],
                'Email' => $item['Email'],
            ]);

            // Insert into ThongTinKhachHang for extra details like QuocTich
            DB::table('ThongTinKhachHang')->insert([
                'Id' => (string) Str::uuid(),
                'KhachHangId' => $id,
                'QuocTich' => $item['QuocTich'] ?? null,
            ]);
        }
    }
}
