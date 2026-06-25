<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // pick a default owner: prefer user id 1, otherwise first user
        $default = DB::table('users')->where('id', 1)->value('id') ?? DB::table('users')->orderBy('id')->value('id');

        if (! $default) {
            // no users exist yet — nothing to backfill
            return;
        }

        $tables = ['KhuVuc', 'ToaNha', 'CanHo', 'KhachHang', 'HopDong', 'HoaDon', 'ThuChi', 'BaoCaoTaiChinh'];

        foreach ($tables as $table) {
            DB::table($table)->whereNull('user_id')->update(['user_id' => $default]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $default = DB::table('users')->where('id', 1)->value('id') ?? DB::table('users')->orderBy('id')->value('id');
        if (! $default) return;

        $tables = ['KhuVuc', 'ToaNha', 'CanHo', 'KhachHang', 'HopDong', 'HoaDon', 'ThuChi', 'BaoCaoTaiChinh'];
        foreach ($tables as $table) {
            DB::table($table)->where('user_id', $default)->update(['user_id' => null]);
        }
    }
};
