<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ToaNhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['TenToaNha' => 'Sakura Building', 'SoTang' => 10, 'MoTa' => 'Tòa nhà dịch vụ cao cấp, gần trung tâm', 'KhuVucName' => 'Quận 1'],
            ['TenToaNha' => 'Lotus Tower', 'SoTang' => 8, 'MoTa' => 'Tòa nhà tiện nghi, an ninh tốt', 'KhuVucName' => 'Quận 3'],
            ['TenToaNha' => 'Maple Residence', 'SoTang' => 12, 'MoTa' => 'Gần cầu, tiện giao thông', 'KhuVucName' => 'Quận 7'],
        ];

        foreach ($items as $item) {
            // Try to find khu vuc
            $khu = DB::table('KhuVuc')->where('TenKhuVuc', $item['KhuVucName'])->first();
            $khuId = $khu->Id ?? null;

            $exists = DB::table('ToaNha')->where('TenToaNha', $item['TenToaNha'])->exists();
            if ($exists) continue;

            DB::table('ToaNha')->insert([
                'Id' => (string) Str::uuid(),
                'KhuVucId' => $khuId,
                'TenToaNha' => $item['TenToaNha'],
                'SoTang' => $item['SoTang'],
                'MoTa' => $item['MoTa'],
            ]);
        }
    }
}
