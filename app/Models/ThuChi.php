<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ThuChi extends Model
{
    protected $table = 'ThuChi';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['Id', 'HopDongId', 'HoaDonId', 'TaiKhoanId', 'LoaiGiaoDich', 'SoTien', 'NgayGiaoDich', 'Thang', 'Nam', 'MoTa', 'ThamChieu'];

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
