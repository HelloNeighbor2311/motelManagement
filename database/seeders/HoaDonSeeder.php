<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HoaDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerId = DB::table('users')->orderBy('id')->value('id');

        $contracts = DB::table('HopDong')->take(30)->get();
        foreach ($contracts as $c) {
            $ma = 'HDN-' . strtoupper(Str::random(6));
            $exists = DB::table('HoaDon')->where('MaHoaDon', $ma)->exists();
            if ($exists) continue;

            $amount = $c->GiaThueThaoThuan ?? 0;
            $date = Carbon::now()->subDays(rand(0, 180));
            $due = (clone $date)->addDays(10);

            DB::table('HoaDon')->insert([
                'Id' => (string) Str::uuid(),
                'HopDongId' => $c->Id,
                'KhachHangId' => $c->KhachHangId,
                'MaHoaDon' => $ma,
                'NgayPhatHanh' => $date->toDateString(),
                'NgayDenHan' => $due->toDateString(),
                'SoTien' => $amount,
                'LoaiHoaDon' => 'TienThue',
                'TrangThaiThanhToan' => 'ChuaThanhToan',
                'Thang' => (int) $date->format('n'),
                'Nam' => (int) $date->format('Y'),
                'user_id' => $ownerId,
            ]);
        }
    }
}
