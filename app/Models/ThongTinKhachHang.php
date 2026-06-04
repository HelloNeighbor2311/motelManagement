<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinKhachHang extends Model
{
    protected $table = 'ThongTinKhachHang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['KhachHangId', 'NgaySinh', 'GioiTinh', 'SoGiayTo', 'DiaChiThuongTru', 'QuocTich', 'GhiChu'];
}
