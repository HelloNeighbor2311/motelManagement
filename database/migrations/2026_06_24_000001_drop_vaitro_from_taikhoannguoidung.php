<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('TaiKhoanNguoiDung') && Schema::hasColumn('TaiKhoanNguoiDung', 'VaiTro')) {
            Schema::table('TaiKhoanNguoiDung', function (Blueprint $table) {
                $table->dropColumn('VaiTro');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('TaiKhoanNguoiDung') && ! Schema::hasColumn('TaiKhoanNguoiDung', 'VaiTro')) {
            Schema::table('TaiKhoanNguoiDung', function (Blueprint $table) {
                $table->string('VaiTro', 20)->default('Staff')->after('TrangThaiTk');
            });
        }
    }
};
