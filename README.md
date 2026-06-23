<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Chạy dự án trước khi test API

Trước khi mở Postman, bạn cần khởi động ứng dụng Laravel bằng các bước sau:

1. Cài dependency PHP nếu chưa có:

```bash
composer install
```

2. Sao chép file môi trường và tạo APP_KEY nếu dự án chưa có:

```bash
cp .env.example .env
php artisan key:generate
```

Trên Windows PowerShell, nếu lệnh `cp` không dùng được, bạn có thể chạy:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

3. Kiểm tra lại cấu hình database trong file `.env`, đặc biệt là `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

4. Chạy migration và seed dữ liệu mẫu:

## Cấu Trúc Cơ Sở Dữ Liệu

Hệ thống quản lý phòng trọ sử dụng SQL Server/MySQL với các bảng sau:

### 1. **KhuVuc** - Quản lý Khu Vực
Lưu trữ thông tin các khu vực cho thuê
- `Id` (UUID): Khóa chính
- `TenKhuVuc` (string, 200): Tên khu vực
- `DiaChi` (string, 500): Địa chỉ khu vực
- `MoTa` (string, 1000): Mô tả chi tiết
- `CreatedAt` (datetime): Ngày tạo

### 2. **ToaNha** - Quản lý Tòa Nhà
Lưu trữ thông tin các tòa nhà trong khu vực
- `Id` (UUID): Khóa chính
- `KhuVucId` (UUID FK): Tham chiếu đến KhuVuc
- `TenToaNha` (string, 200): Tên tòa nhà
- `SoTang` (int): Số tầng
- `MoTa` (string, 1000): Mô tả
- `CreatedAt` (datetime): Ngày tạo

### 3. **CanHo** - Quản lý Căn Hộ
Lưu trữ thông tin chi tiết từng căn hộ
- `Id` (UUID): Khóa chính
- `ToaNhaId` (UUID FK): Tham chiếu đến ToaNha
- `MaCanHo` (string, 50): Mã căn hộ (VD: A101)
- `Tang` (int): Số tầng
- `DienTich` (float): Diện tích m²
- `SoPhong` (int): Số phòng trong căn hộ
- `TrangThai` (string): Trong/DangThue/BaoTri
- `GiaThue` (decimal): Giá thuê hàng tháng
- `CreatedAt` (datetime): Ngày tạo

### 4. **TaiKhoanNguoiDung** - Quản lý Tài Khoản Người Dùng
Lưu trữ thông tin tài khoản nhân viên/quản lý
- `Id` (UUID): Khóa chính
- `HoTen` (string, 200): Họ tên
- `SoDienThoai` (string, 20): Số điện thoại
- `Email` (string, 255): Email (UNIQUE)
- `TenDangNhap` (string, 100): Username (UNIQUE)
- `MatKhauHash` (string, 512): Hash password
- `RefreshToken` (string, 512): Token làm mới
- `OtpCode` (string, 10): Mã OTP
- `OtpHetHan` (datetime): Thời gian OTP hết hạn
- `TrangThaiTk` (string): Active/Inactive/Locked
- `VaiTro` (string): Admin/Staff/Viewer
- `LastLogin` (datetime): Lần đăng nhập cuối
- `CreatedAt` (datetime): Ngày tạo

### 5. **KhachHang** - Quản lý Khách Hàng
Lưu trữ thông tin khách thuê
- `Id` (UUID): Khóa chính
- `HoTen` (string, 200): Họ tên khách
- `LoaiKhachHang` (string): CaNhan/DoanhNghiep/NuocNgoai
- `SoCmndCccd` (string, 30): Số CMND/CCCD
- `QuocTich` (string, 100): Quốc tích
- `SoDienThoai` (string, 20): Số điện thoại
- `Email` (string, 255): Email
- `CreatedAt` (datetime): Ngày tạo

### 6. **ThongTinCaNhan** - Thông Tin Chi Tiết Khách Hàng
Lưu trữ thông tin cá nhân mở rộng
- `Id` (UUID): Khóa chính
- `KhachHangId` (UUID FK): Tham chiếu đến KhachHang (UNIQUE)
- `DiaChiThuongTru` (string, 500): Địa chỉ thường trú
- `NgaySinh` (date): Ngày sinh
- `GioiTinh` (string): Nam/Nu/Khac
- `TenCongTy` (string, 300): Tên công ty (nếu là doanh nghiệp)
- `MaSoThue` (string, 50): Mã số thuế
- `NguoiDaiDien` (string, 200): Người đại diện
- `QuocGia` (string, 100): Quốc gia
- `VisaType` (string, 50): Loại visa
- `VisaHetHan` (date): Ngày visa hết hạn
- `GhiChu` (string, 1000): Ghi chú
- `UpdatedAt` (datetime): Ngày cập nhật

### 7. **HopDong** - Quản lý Hợp Đồng Thuê
Lưu trữ thông tin hợp đồng thuê
- `Id` (UUID): Khóa chính
- `KhachHangId` (UUID FK): Tham chiếu đến KhachHang
- `CanHoId` (UUID FK, NULL): Tham chiếu đến CanHo
- `ToaNhaId` (UUID FK, NULL): Tham chiếu đến ToaNha
- `MaHopDong` (string, 50): Mã hợp đồng (UNIQUE)
- `NgayBatDau` (date): Ngày bắt đầu
- `NgayKetThuc` (date): Ngày kết thúc
- `GiaThueThaoThuan` (decimal): Giá thuê thỏa thuận
- `TienDatCoc` (decimal): Số tiền đặt cọc
- `PhuongThucThanhToan` (string): TienMat/ChuyenKhoan/TheNganHang
- `ChuKyThanhToan` (string): Thang/Quy/Nam
- `TrangThaiHopDong` (string): HieuLuc/HetHan/HuyBo/GiaHan
- `GhiChu` (string, 1000): Ghi chú
- `CreatedAt` (datetime): Ngày tạo

### 8. **HoaDon** - Quản lý Hóa Đơn
Lưu trữ thông tin hóa đơn thanh toán
- `Id` (UUID): Khóa chính
- `HopDongId` (UUID FK): Tham chiếu đến HopDong
- `KhachHangId` (UUID FK): Tham chiếu đến KhachHang
- `MaHoaDon` (string, 50): Mã hóa đơn (UNIQUE)
- `NgayPhatHanh` (date): Ngày phát hành
- `NgayDenHan` (date): Ngày đến hạn thanh toán
- `NgayThanhToan` (date, NULL): Ngày thanh toán thực tế
- `SoTien` (decimal): Số tiền hóa đơn
- `LoaiHoaDon` (string): TienThue/TienDatCoc/DichVu/PhatSinhKhac
- `TrangThaiThanhToan` (string): ChuaThanhToan/DaThanhToan/QuaHan/HuyBo
- `MoTa` (string, 500): Mô tả
- `Thang` (int, 1-12): Tháng
- `Nam` (int): Năm
- `CreatedAt` (datetime): Ngày tạo

### 9. **ThuChi** - Quản lý Thu Chi
Lưu trữ thông tin giao dịch thu chi
- `Id` (UUID): Khóa chính
- `HopDongId` (UUID FK, NULL): Tham chiếu đến HopDong
- `HoaDonId` (UUID FK, NULL): Tham chiếu đến HoaDon
- `TaiKhoanId` (UUID FK, NULL): Tham chiếu đến TaiKhoanNguoiDung
- `LoaiGiaoDich` (string): Thu/Chi
- `SoTien` (decimal): Số tiền
- `NgayGiaoDich` (date): Ngày giao dịch
- `Thang` (int, 1-12): Tháng
- `Nam` (int): Năm
- `MoTa` (string, 500): Mô tả giao dịch
- `ThamChieu` (string, 100): Mã tham chiếu
- `CreatedAt` (datetime): Ngày tạo

### 10. **BaoCaoTaiChinh** - Báo Cáo Tài Chính
Lưu trữ thông tin báo cáo tài chính định kỳ
- `Id` (UUID): Khóa chính
- `TaiKhoanId` (UUID FK, NULL): Tham chiếu đến TaiKhoanNguoiDung
- `LoaiBaoCao` (string): Thang/Quy/Nam
- `Thang` (int, 1-12, NULL): Tháng (nếu báo cáo tháng)
- `Quy` (int, 1-4, NULL): Quý (nếu báo cáo quý)
- `Nam` (int): Năm
- `TongThu` (decimal): Tổng doanh thu
- `TongChi` (decimal): Tổng chi phí
- `TienThueThu` (decimal): Tiền thuê thu được
- `TienDatCocThu` (decimal): Tiền đặt cọc thu được
- `ChiPhiVanHanh` (decimal): Chi phí vận hành
- `SoDu` (computed): Số dư = TongThu - TongChi
- `NgayTao` (datetime): Ngày tạo
- `GhiChu` (string, 1000): Ghi chú

### Ràng Buộc Và Ký Tự Đặc Biệt
- **Primary Key**: Tất cả bảng sử dụng UUID làm khóa chính
- **Foreign Keys**: Các quan hệ khóa ngoại được thiết lập giữa các bảng liên quan
- **Unique Constraints**: MaCanHo, MaHopDong, MaHoaDon, Email, TenDangNhap
- **Check Constraints**: Xác thực các giá trị enum cho các trường như TrangThai, LoaiKhachHang, VaiTro, v.v.
- **Computed Columns**: Cột SoDu trong BaoCaoTaiChinh được tính toán tự động

### Chỉ Mục (Indexes)
Để tối ưu hóa truy vấn:
- `IX_ToaNha_KhuVucId`: Tìm kiếm tòa nhà theo khu vực
- `IX_CanHo_ToaNhaId`: Tìm kiếm căn hộ theo tòa nhà
- `IX_CanHo_TrangThai`: Tìm kiếm căn hộ theo trạng thái
- `IX_HopDong_KhachHang`: Tìm kiếm hợp đồng theo khách hàng
- `IX_HopDong_TrangThai`: Tìm kiếm hợp đồng theo trạng thái
- `IX_HoaDon_HopDong`: Tìm kiếm hóa đơn theo hợp đồng
- `IX_HoaDon_ThangNam`: Tìm kiếm hóa đơn theo tháng/năm
- `IX_ThuChi_ThangNam`: Tìm kiếm giao dịch theo tháng/năm
- `IX_ThuChi_LoaiGiaoDich`: Tìm kiếm giao dịch theo loại (Thu/Chi)
- `IX_KhachHang_Loai`: Tìm kiếm khách hàng theo loại

```bash
php artisan migrate --seed
```

5. Khởi động server Laravel:

```bash
php artisan serve
```

6. Nếu dự án có dùng Vite cho frontend, mở thêm terminal khác và chạy:

```bash
npm install
npm run dev
```

Sau khi server chạy, API của bạn sẽ có dạng:

```text
http://127.0.0.1:8000/api/khu-vuc
```

## KhuVuc Seeder And Postman Test

### 1. Chạy seeder

```bash
php artisan db:seed
```

Nếu bạn muốn chạy lại toàn bộ migration và seed từ đầu:

```bash
php artisan migrate:fresh --seed
```

### 2. API `KhuVuc`

Route đang dùng là `/api/khu-vuc`.

- `GET /api/khu-vuc`: lấy danh sách khu vực.
- `GET /api/khu-vuc/{id}`: lấy chi tiết một khu vực.
- `POST /api/khu-vuc`: tạo khu vực mới.
- `PUT /api/khu-vuc/{id}`: cập nhật khu vực.
- `DELETE /api/khu-vuc/{id}`: xoá khu vực.

### 3. Test trên Postman

1. Mở Postman và tạo request mới.
2. Chọn method tương ứng với thao tác cần test.
3. Nhập URL ví dụ:

```text
http://127.0.0.1:8000/api/khu-vuc
```

4. Với `POST` hoặc `PUT`, vào tab `Body` -> chọn `raw` -> chọn `JSON` và gửi payload như sau:

```json
{
    "TenKhuVuc": "Quận 10",
    "DiaChi": "TP. Hồ Chí Minh",
    "MoTa": "Khu vực mẫu để test API"
}
```

5. Với `GET`, chỉ cần gửi request và xem JSON trả về.
6. Với `DELETE`, gọi đúng URL có `id` của bản ghi cần xoá.

### 4. Kết quả mong đợi

- `GET` trả về danh sách JSON của các khu vực.
- `POST` trả về bản ghi vừa tạo với status `201`.
- `PUT` trả về bản ghi đã cập nhật.
- `DELETE` trả về status `204` nếu xoá thành công.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
