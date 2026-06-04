<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('KhuVuc', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->string('TenKhuVuc', 200);
            $table->string('DiaChi', 500)->nullable();
            $table->string('MoTa', 1000)->nullable();
            $table->dateTime('CreatedAt')->useCurrent();
        });

        Schema::create('ToaNha', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('KhuVucId');
            $table->string('TenToaNha', 200);
            $table->integer('SoTang')->default(1);
            $table->string('MoTa', 1000)->nullable();
            $table->dateTime('CreatedAt')->useCurrent();

            $table->foreign('KhuVucId')->references('Id')->on('KhuVuc');
            $table->index('KhuVucId', 'IX_ToaNha_KhuVucId');
        });

        Schema::create('CanHo', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('ToaNhaId');
            $table->string('MaCanHo', 50);
            $table->integer('Tang');
            $table->float('DienTich');
            $table->integer('SoPhong')->default(1);
            $table->string('TrangThai', 20)->default('Trong');
            $table->decimal('GiaThue', 18, 2)->default(0);
            $table->dateTime('CreatedAt')->useCurrent();

            $table->foreign('ToaNhaId')->references('Id')->on('ToaNha');
            $table->unique(['ToaNhaId', 'MaCanHo'], 'UQ_CanHo_Ma');
            $table->index('ToaNhaId', 'IX_CanHo_ToaNhaId');
            $table->index('TrangThai', 'IX_CanHo_TrangThai');
        });

        Schema::create('TaiKhoanNguoiDung', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->string('HoTen', 200);
            $table->string('SoDienThoai', 20)->nullable();
            $table->string('Email', 255);
            $table->string('TenDangNhap', 100);
            $table->string('MatKhauHash', 512);
            $table->string('RefreshToken', 512)->nullable();
            $table->string('OtpCode', 10)->nullable();
            $table->dateTime('OtpHetHan')->nullable();
            $table->string('TrangThaiTk', 20)->default('Active');
            $table->string('VaiTro', 20)->default('Staff');
            $table->dateTime('LastLogin')->nullable();
            $table->dateTime('CreatedAt')->useCurrent();

            $table->unique('Email', 'UQ_TaiKhoan_Email');
            $table->unique('TenDangNhap', 'UQ_TaiKhoan_TenDangNhap');
        });

        Schema::create('KhachHang', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->string('HoTen', 200);
            $table->string('LoaiKhachHang', 20)->default('CaNhan');
            $table->string('SoCmndCccd', 30)->nullable();
            $table->string('QuocTich', 100)->nullable();
            $table->string('SoDienThoai', 20)->nullable();
            $table->string('Email', 255)->nullable();
            $table->dateTime('CreatedAt')->useCurrent();

            $table->index('LoaiKhachHang', 'IX_KhachHang_Loai');
        });

        Schema::create('ThongTinCaNhan', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('KhachHangId');
            $table->string('DiaChiThuongTru', 500)->nullable();
            $table->date('NgaySinh')->nullable();
            $table->string('GioiTinh', 10)->nullable();
            $table->string('TenCongTy', 300)->nullable();
            $table->string('MaSoThue', 50)->nullable();
            $table->string('NguoiDaiDien', 200)->nullable();
            $table->string('QuocGia', 100)->nullable();
            $table->string('VisaType', 50)->nullable();
            $table->date('VisaHetHan')->nullable();
            $table->string('GhiChu', 1000)->nullable();
            $table->dateTime('UpdatedAt')->useCurrent();

            $table->foreign('KhachHangId')->references('Id')->on('KhachHang');
            $table->unique('KhachHangId', 'UQ_ThongTinCaNhan_KhachHang');
        });

        Schema::create('HopDong', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('KhachHangId');
            $table->uuid('CanHoId')->nullable();
            $table->uuid('ToaNhaId')->nullable();
            $table->string('MaHopDong', 50);
            $table->date('NgayBatDau');
            $table->date('NgayKetThuc');
            $table->decimal('GiaThueThaoThuan', 18, 2);
            $table->decimal('TienDatCoc', 18, 2)->default(0);
            $table->string('PhuongThucThanhToan', 30)->default('ChuyenKhoan');
            $table->string('ChuKyThanhToan', 20)->default('Thang');
            $table->string('TrangThaiHopDong', 20)->default('HieuLuc');
            $table->string('GhiChu', 1000)->nullable();
            $table->dateTime('CreatedAt')->useCurrent();

            $table->foreign('KhachHangId')->references('Id')->on('KhachHang');
            $table->foreign('CanHoId')->references('Id')->on('CanHo');
            $table->foreign('ToaNhaId')->references('Id')->on('ToaNha');
            $table->unique('MaHopDong', 'UQ_HopDong_Ma');
            $table->index('KhachHangId', 'IX_HopDong_KhachHang');
            $table->index('TrangThaiHopDong', 'IX_HopDong_TrangThai');
        });

        Schema::create('HoaDon', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('HopDongId');
            $table->uuid('KhachHangId');
            $table->string('MaHoaDon', 50);
            $table->date('NgayPhatHanh')->default(DB::raw('CURRENT_DATE'));
            $table->date('NgayDenHan');
            $table->date('NgayThanhToan')->nullable();
            $table->decimal('SoTien', 18, 2);
            $table->string('LoaiHoaDon', 30)->default('TienThue');
            $table->string('TrangThaiThanhToan', 20)->default('ChuaThanhToan');
            $table->string('MoTa', 500)->nullable();
            $table->integer('Thang');
            $table->integer('Nam');
            $table->dateTime('CreatedAt')->useCurrent();

            $table->foreign('HopDongId')->references('Id')->on('HopDong');
            $table->foreign('KhachHangId')->references('Id')->on('KhachHang');
            $table->unique('MaHoaDon', 'UQ_HoaDon_Ma');
            $table->index('HopDongId', 'IX_HoaDon_HopDong');
            $table->index(['Nam', 'Thang'], 'IX_HoaDon_ThangNam');
        });

        Schema::create('ThuChi', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('HopDongId')->nullable();
            $table->uuid('HoaDonId')->nullable();
            $table->uuid('TaiKhoanId')->nullable();
            $table->string('LoaiGiaoDich', 10);
            $table->decimal('SoTien', 18, 2);
            $table->date('NgayGiaoDich')->default(DB::raw('CURRENT_DATE'));
            $table->integer('Thang');
            $table->integer('Nam');
            $table->string('MoTa', 500)->nullable();
            $table->string('ThamChieu', 100)->nullable();
            $table->dateTime('CreatedAt')->useCurrent();

            $table->foreign('HopDongId')->references('Id')->on('HopDong');
            $table->foreign('HoaDonId')->references('Id')->on('HoaDon');
            $table->foreign('TaiKhoanId')->references('Id')->on('TaiKhoanNguoiDung');
            $table->index(['Nam', 'Thang'], 'IX_ThuChi_ThangNam');
            $table->index('LoaiGiaoDich', 'IX_ThuChi_LoaiGiaoDich');
        });

        Schema::create('BaoCaoTaiChinh', function (Blueprint $table) {
            $table->uuid('Id')->primary();
            $table->uuid('TaiKhoanId')->nullable();
            $table->string('LoaiBaoCao', 20)->default('Thang');
            $table->integer('Thang')->nullable();
            $table->integer('Quy')->nullable();
            $table->integer('Nam');
            $table->decimal('TongThu', 18, 2)->default(0);
            $table->decimal('TongChi', 18, 2)->default(0);
            $table->decimal('TienThueThu', 18, 2)->default(0);
            $table->decimal('TienDatCocThu', 18, 2)->default(0);
            $table->decimal('ChiPhiVanHanh', 18, 2)->default(0);
            $table->dateTime('NgayTao')->useCurrent();
            $table->string('GhiChu', 1000)->nullable();

            $table->foreign('TaiKhoanId')->references('Id')->on('TaiKhoanNguoiDung');
        });

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE TaiKhoanNguoiDung
                ADD CONSTRAINT CHK_TaiKhoanNguoiDung_TrangThai CHECK (TrangThaiTk IN ('Active', 'Inactive', 'Locked')),
                    CONSTRAINT CHK_TaiKhoanNguoiDung_VaiTro CHECK (VaiTro IN ('Admin', 'Staff', 'Viewer'));
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE CanHo
                ADD CONSTRAINT CHK_CanHo_TrangThai CHECK (TrangThai IN ('Trong', 'DangThue', 'BaoTri'));
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE KhachHang
                ADD CONSTRAINT CHK_KhachHang_LoaiKhachHang CHECK (LoaiKhachHang IN ('CaNhan', 'DoanhNghiep', 'NuocNgoai'));
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE ThongTinCaNhan
                ADD CONSTRAINT CHK_ThongTinCaNhan_GioiTinh CHECK (GioiTinh IN ('Nam', 'Nu', 'Khac'));
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE HopDong
                ADD CONSTRAINT CHK_HopDong_PhuongThucThanhToan CHECK (PhuongThucThanhToan IN ('TienMat', 'ChuyenKhoan', 'TheNganHang')),
                    CONSTRAINT CHK_HopDong_ChuKyThanhToan CHECK (ChuKyThanhToan IN ('Thang', 'Quy', 'Nam')),
                    CONSTRAINT CHK_HopDong_TrangThaiHopDong CHECK (TrangThaiHopDong IN ('HieuLuc', 'HetHan', 'HuyBo', 'GiaHan')),
                    CONSTRAINT CHK_HopDong_NguoiThue CHECK (CanHoId IS NOT NULL OR ToaNhaId IS NOT NULL);
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE HoaDon
                ADD CONSTRAINT CHK_HoaDon_LoaiHoaDon CHECK (LoaiHoaDon IN ('TienThue', 'TienDatCoc', 'DichVu', 'PhatSinhKhac')),
                    CONSTRAINT CHK_HoaDon_TrangThaiThanhToan CHECK (TrangThaiThanhToan IN ('ChuaThanhToan', 'DaThanhToan', 'QuaHan', 'HuyBo')),
                    CONSTRAINT CHK_HoaDon_Thang CHECK (Thang BETWEEN 1 AND 12),
                    CONSTRAINT CHK_HoaDon_Nam CHECK (Nam >= 2000);
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE ThuChi
                ADD CONSTRAINT CHK_ThuChi_LoaiGiaoDich CHECK (LoaiGiaoDich IN ('Thu', 'Chi')),
                    CONSTRAINT CHK_ThuChi_Thang CHECK (Thang BETWEEN 1 AND 12),
                    CONSTRAINT CHK_ThuChi_Nam CHECK (Nam >= 2000);
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE BaoCaoTaiChinh
                ADD CONSTRAINT CHK_BaoCaoTaiChinh_LoaiBaoCao CHECK (LoaiBaoCao IN ('Thang', 'Quy', 'Nam')),
                    CONSTRAINT CHK_BaoCaoTaiChinh_Thang CHECK (Thang BETWEEN 1 AND 12),
                    CONSTRAINT CHK_BaoCaoTaiChinh_Quy CHECK (Quy BETWEEN 1 AND 4),
                    CONSTRAINT CHK_BaoCaoTaiChinh_Nam CHECK (Nam >= 2000);
            SQL);
        }

        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement(<<<'SQL'
                ALTER TABLE BaoCaoTaiChinh
                ADD SoDu AS (TongThu - TongChi) PERSISTED;
            SQL);
        } elseif (DB::getDriverName() === 'mysql') {
            DB::statement(<<<'SQL'
                ALTER TABLE BaoCaoTaiChinh
                ADD COLUMN SoDu DECIMAL(18,2) AS (TongThu - TongChi) STORED;
            SQL);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('BaoCaoTaiChinh');
        Schema::dropIfExists('ThuChi');
        Schema::dropIfExists('HoaDon');
        Schema::dropIfExists('HopDong');
        Schema::dropIfExists('ThongTinCaNhan');
        Schema::dropIfExists('KhachHang');
        Schema::dropIfExists('TaiKhoanNguoiDung');
        Schema::dropIfExists('CanHo');
        Schema::dropIfExists('ToaNha');
        Schema::dropIfExists('KhuVuc');
    }
};
