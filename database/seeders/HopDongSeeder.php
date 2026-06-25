<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HopDongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $khachs = DB::table('KhachHang')->take(10)->get();
        $canhos = DB::table('CanHo')->take(20)->get();
        $ownerId = \Illuminate\Support\Facades\DB::table('users')->orderBy('id')->value('id');

        $i = 0;
        foreach ($khachs as $kh) {
            $canho = $canhos[$i % max(1, $canhos->count())] ?? null;
            if (!$canho) break;

            $prefix = Str::ascii(substr($kh->HoTen, 0, 3));
            $prefix = strtoupper(preg_replace('/[^A-Z0-9]/', '', $prefix));
            if (empty($prefix)) {
                $prefix = 'KH';
            }
            $ma = 'HD-' . $prefix . '-' . rand(100, 999);
            $exists = DB::table('HopDong')->where('MaHopDong', $ma)->exists();
            if ($exists) { $i++; continue; }

            $start = Carbon::now()->subMonths(rand(0, 12))->startOfMonth();
            $end = (clone $start)->addMonths(12);

            DB::table('HopDong')->insert([
                'Id' => (string) Str::uuid(),
                'KhachHangId' => $kh->Id,
                'CanHoId' => $canho->Id,
                'ToaNhaId' => $canho->ToaNhaId,
                'MaHopDong' => $ma,
                'NgayBatDau' => $start->toDateString(),
                'NgayKetThuc' => $end->toDateString(),
                'GiaThueThaoThuan' => $canho->GiaThue,
                'TienDatCoc' => intval($canho->GiaThue * 0.5),
                'PhuongThucThanhToan' => 'ChuyenKhoan',
                'ChuKyThanhToan' => 'Thang',
                'TrangThaiHopDong' => 'HieuLuc',
                'user_id' => $ownerId,
            ]);

            // mark apartment as rented
            DB::table('CanHo')->where('Id', $canho->Id)->update(['TrangThai' => 'DangThue']);

            $i++;
        }
    }
}
