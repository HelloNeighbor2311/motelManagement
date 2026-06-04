<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'HoaDon';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['HopDongId', 'KhachHangId', 'MaHoaDon', 'NgayPhatHanh', 'NgayDenHan', 'SoTien', 'LoaiHoaDon', 'Thang', 'Nam'];
}
