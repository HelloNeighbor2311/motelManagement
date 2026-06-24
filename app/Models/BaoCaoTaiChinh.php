<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaoCaoTaiChinh extends Model
{
    protected $table = 'BaoCaoTaiChinh';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['Id', 'TaiKhoanId', 'LoaiBaoCao', 'Thang', 'Nam', 'TongThu', 'TongChi', 'TienThueThu', 'TienDatCocThu', 'ChiPhiVanHanh'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->Id)) {
                $model->Id = (string) Str::uuid();
            }
        });
    }
}
