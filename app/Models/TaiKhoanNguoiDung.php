<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiKhoanNguoiDung extends Model
{
    protected $table = 'TaiKhoanNguoiDung';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['HoTen', 'SoDienThoai', 'Email', 'TenDangNhap', 'MatKhauHash', 'VaiTro', 'TrangThaiTk'];
}
