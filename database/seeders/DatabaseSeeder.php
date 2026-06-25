<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure at least one user exists for seeded records
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            KhuVucSeeder::class,
            ToaNhaSeeder::class,
            CanHoSeeder::class,
            KhachHangSeeder::class,
            HopDongSeeder::class,
            HoaDonSeeder::class,
            ThuChiSeeder::class,
        ]);
    }
}
