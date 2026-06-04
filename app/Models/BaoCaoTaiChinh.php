<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaoCaoTaiChinh extends Model
{
    protected $table = 'BaoCaoTaiChinh';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['TaiKhoanId', 'LoaiBaoCao', 'Thang', 'Quy', 'Nam', 'TongThu', 'TongChi', 'TienThueThu', 'TienDatCocThu', 'ChiPhiVanHanh'];
}
