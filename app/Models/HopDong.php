<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HopDong extends Model
{
    protected $table = 'HopDong';

    protected $primaryKey = 'Id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['Id', 'KhachHangId', 'CanHoId', 'ToaNhaId', 'MaHopDong', 'NgayBatDau', 'NgayKetThuc', 'GiaThueThaoThuan', 'TienDatCoc', 'PhuongThucThanhToan', 'ChuKyThanhToan', 'TrangThaiHopDong', 'GhiChu', 'CreatedAt'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->Id)) {
                $model->Id = (string) Str::uuid();
            }

            if (empty($model->CreatedAt)) {
                $model->CreatedAt = now();
            }
        });
    }

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'KhachHangId', 'Id');
    }

    public function canHo()
    {
        return $this->belongsTo(CanHo::class, 'CanHoId', 'Id');
    }

    public function toaNha()
    {
        return $this->belongsTo(ToaNha::class, 'ToaNhaId', 'Id');
    }
}
