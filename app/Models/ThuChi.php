<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThuChi extends Model
{
    protected $table = 'ThuChi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['HopDongId', 'HoaDonId', 'TaiKhoanId', 'LoaiGiaoDich', 'SoTien', 'NgayGiaoDich', 'Thang', 'Nam', 'MoTa', 'ThamChieu'];
}
