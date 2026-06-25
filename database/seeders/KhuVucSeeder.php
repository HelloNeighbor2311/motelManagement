<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KhuVucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerId = \Illuminate\Support\Facades\DB::table('users')->orderBy('id')->value('id');

        $items = [
            [
                'TenKhuVuc' => 'Quận 1',
                'DiaChi' => 'TP. Hồ Chí Minh',
                'MoTa' => 'Khu vực trung tâm, phù hợp mô hình căn hộ dịch vụ cao cấp.',
            ],
            [
                'TenKhuVuc' => 'Quận 3',
                'DiaChi' => 'TP. Hồ Chí Minh',
                'MoTa' => 'Khu vực có hạ tầng tốt, thuận tiện di chuyển.',
            ],
            [
                'TenKhuVuc' => 'Quận 7',
                'DiaChi' => 'TP. Hồ Chí Minh',
                'MoTa' => 'Phù hợp khách thuê gia đình và chuyên gia nước ngoài.',
            ],
            [
                'TenKhuVuc' => 'Thành phố Thủ Đức',
                'DiaChi' => 'TP. Hồ Chí Minh',
                'MoTa' => 'Khu vực có nhiều dự án nhà ở và tòa nhà mới.',
            ],
            [
                'TenKhuVuc' => 'Quận Bình Thạnh',
                'DiaChi' => 'TP. Hồ Chí Minh',
                'MoTa' => 'Khu vực gần trung tâm, lượng nhu cầu thuê cao.',
            ],
        ];

        foreach ($items as $item) {
            $exists = DB::table('KhuVuc')
                ->where('TenKhuVuc', $item['TenKhuVuc'])
                ->exists();

            if ($exists) {
                DB::table('KhuVuc')
                    ->where('TenKhuVuc', $item['TenKhuVuc'])
                    ->update([
                        'DiaChi' => $item['DiaChi'],
                        'MoTa' => $item['MoTa'],
                    ]);

                continue;
            }

            DB::table('KhuVuc')->insert([
                'Id' => (string) Str::uuid(),
                'TenKhuVuc' => $item['TenKhuVuc'],
                'DiaChi' => $item['DiaChi'],
                'MoTa' => $item['MoTa'],
                'user_id' => $ownerId,
            ]);
        }
    }
}
