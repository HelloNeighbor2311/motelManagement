<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'KhachHang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['HoTen', 'LoaiKhachHang', 'SoCmndCccd', 'QuocTich', 'SoDienThoai', 'Email'];
}
