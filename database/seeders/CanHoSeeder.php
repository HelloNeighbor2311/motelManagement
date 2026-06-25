<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CanHoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toas = DB::table('ToaNha')->get();
        $ownerId = \Illuminate\Support\Facades\DB::table('users')->orderBy('id')->value('id');

        foreach ($toas as $toa) {
            // create 6 apartments per building
            for ($i = 1; $i <= 6; $i++) {
                $ma = $toa->TenToaNha . '-C' . $i;
                $exists = DB::table('CanHo')->where('MaCanHo', $ma)->exists();
                if ($exists) continue;

                DB::table('CanHo')->insert([
                    'Id' => (string) Str::uuid(),
                    'ToaNhaId' => $toa->Id,
                    'MaCanHo' => $ma,
                    'Tang' => ceil($i / 2),
                    'DienTich' => 30 + $i * 5,
                    'SoPhong' => 1,
                    'TrangThai' => 'Trong',
                    'GiaThue' => 4000000 + $i * 500000,
                    'user_id' => $ownerId,
                ]);
            }
        }
    }
}
