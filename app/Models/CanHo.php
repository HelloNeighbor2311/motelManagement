<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CanHo extends Model
{
    protected $table = 'CanHo';
    protected $primaryKey = 'Id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'ToaNhaId',
        'MaCanHo',
        'Tang',
        'DienTich',
        'SoPhong',
        'TrangThai',
        'GiaThue',
        'CreatedAt',
    ];

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

    // Relationships
    public function toaNha()
    {
        return $this->belongsTo(ToaNha::class, 'ToaNhaId', 'Id');
    }

    public function hopDongs()
    {
        return $this->hasMany(HopDong::class, 'CanHoId', 'Id');
    }

    // Status Badge
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'Trong' => 'badge-trong',
            'DangThue' => 'badge-dang-thue',
            'BaoTri' => 'badge-bao-tri',
        ];
        return $statuses[$this->TrangThai] ?? 'badge-secondary';
    }

    public function getStatusDisplayAttribute()
    {
        $displays = [
            'Trong' => '✅ Trống',
            'DangThue' => '⏳ Đang Thuê',
            'BaoTri' => '🔧 Bảo Trì',
        ];
        return $displays[$this->TrangThai] ?? $this->TrangThai;
    }
}
