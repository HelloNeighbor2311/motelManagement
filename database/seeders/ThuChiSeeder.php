<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ThuChiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerId = DB::table('users')->orderBy('id')->value('id');

        $types = ['Thu', 'Chi'];
        $now = Carbon::now();

        for ($m = 1; $m <= 6; $m++) {
            $date = (clone $now)->subMonths($m);
            for ($i = 0; $i < 5; $i++) {
                DB::table('ThuChi')->insert([
                    'Id' => (string) Str::uuid(),
                    'LoaiGiaoDich' => $types[array_rand($types)],
                    'SoTien' => rand(500000, 5000000),
                    'Nam' => $date->year,
                    'Thang' => $date->month,
                    'MoTa' => 'Seeded transaction',
                    'NgayGiaoDich' => $date->toDateString(),
                    'user_id' => $ownerId,
                ]);
            }
        }
    }
}
