<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinCaNhan extends Model
{
    protected $table = 'ThongTinCaNhan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['KhachHangId', 'DiaChiThuongTru', 'NgaySinh', 'GioiTinh', 'TenCongTy', 'MaSoThue', 'NguoiDaiDien'];
}
