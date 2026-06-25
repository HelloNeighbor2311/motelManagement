<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'KhuVuc',
            'ToaNha',
            'CanHo',
            'KhachHang',
            'HopDong',
            'HoaDon',
            'ThuChi',
            'BaoCaoTaiChinh',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableBlueprint) {
                if (! Schema::hasColumn($tableBlueprint->getTable(), 'user_id')) {
                    $tableBlueprint->unsignedBigInteger('user_id')->nullable()->after('Id');
                    $tableBlueprint->index('user_id', 'IX_' . $tableBlueprint->getTable() . '_UserId');
                    $tableBlueprint->foreign('user_id')->references('id')->on('users');
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'KhuVuc',
            'ToaNha',
            'CanHo',
            'KhachHang',
            'HopDong',
            'HoaDon',
            'ThuChi',
            'BaoCaoTaiChinh',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableBlueprint) {
                if (Schema::hasColumn($tableBlueprint->getTable(), 'user_id')) {
                    $tableBlueprint->dropForeign(['user_id']);
                    $tableBlueprint->dropIndex(['user_id']);
                    $tableBlueprint->dropColumn('user_id');
                }
            });
        }
    }
};
