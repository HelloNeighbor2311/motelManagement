<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KhachHang extends Model
{
    protected $table = 'KhachHang';
    protected $primaryKey = 'Id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'HoTen',
        'LoaiKhachHang',
        'SoCmndCccd',
        'QuocTich',
        'SoDienThoai',
        'Email',
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
    public function thongTinCaNhan()
    {
        return $this->hasOne(ThongTinCaNhan::class, 'KhachHangId', 'Id');
    }

    public function hopDongs()
    {
        return $this->hasMany(HopDong::class, 'KhachHangId', 'Id');
    }

    public function hoaDons()
    {
        return $this->hasMany(HoaDon::class, 'KhachHangId', 'Id');
    }

    public function getTypeDisplayAttribute()
    {
        $types = [
            'CaNhan' => 'Cá Nhân',
            'DoanhNghiep' => 'Doanh Nghiệp',
            'NuocNgoai' => 'Nước Ngoài',
        ];
        return $types[$this->LoaiKhachHang] ?? $this->LoaiKhachHang;
    }
}
