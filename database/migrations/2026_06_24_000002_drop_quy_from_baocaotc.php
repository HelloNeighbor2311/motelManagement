<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('BaoCaoTaiChinh')) {
            if (Schema::hasColumn('BaoCaoTaiChinh', 'Quy')) {
                Schema::table('BaoCaoTaiChinh', function (Blueprint $table) {
                    $table->dropColumn('Quy');
                });
            }

            // Try to remove old check constraints and add new one
            try {
                DB::statement('ALTER TABLE BaoCaoTaiChinh DROP CONSTRAINT IF EXISTS CHK_BaoCaoTaiChinh_Quy');
            } catch (\Exception $e) {
            }

            try {
                DB::statement('ALTER TABLE BaoCaoTaiChinh DROP CONSTRAINT IF EXISTS CHK_BaoCaoTaiChinh_LoaiBaoCao');
            } catch (\Exception $e) {
            }

            try {
                DB::statement("ALTER TABLE BaoCaoTaiChinh ADD CONSTRAINT CHK_BaoCaoTaiChinh_LoaiBaoCao CHECK (LoaiBaoCao IN ('Thang','Nam'))");
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('BaoCaoTaiChinh')) {
            if (!Schema::hasColumn('BaoCaoTaiChinh', 'Quy')) {
                Schema::table('BaoCaoTaiChinh', function (Blueprint $table) {
                    $table->integer('Quy')->nullable();
                });
            }

            try {
                DB::statement('ALTER TABLE BaoCaoTaiChinh DROP CONSTRAINT IF EXISTS CHK_BaoCaoTaiChinh_LoaiBaoCao');
            } catch (\Exception $e) {
            }

            try {
                DB::statement("ALTER TABLE BaoCaoTaiChinh ADD CONSTRAINT CHK_BaoCaoTaiChinh_LoaiBaoCao CHECK (LoaiBaoCao IN ('Thang','Quy','Nam'))");
            } catch (\Exception $e) {
            }

            try {
                DB::statement("ALTER TABLE BaoCaoTaiChinh ADD CONSTRAINT CHK_BaoCaoTaiChinh_Quy CHECK (Quy BETWEEN 1 AND 4)");
            } catch (\Exception $e) {
            }
        }
    }
};
