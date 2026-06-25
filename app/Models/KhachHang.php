<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\OwnedByUser;

class KhachHang extends Model
{
    use OwnedByUser;
    protected $table = 'KhachHang';
    protected $primaryKey = 'Id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'user_id',
        'HoTen',
        'LoaiKhachHang',
        'QuocTich',
        'SoDienThoai',
        'Email',
        'CreatedAt',
    ];

    // Attribute accessors to keep compatibility with views/controllers
    public function getTenKhachHangAttribute()
    {
        return $this->HoTen;
    }

    public function getCCCDAttribute()
    {
        return null;
    }

    public function getLoaiKhachAttribute()
    {
        // Map stored values to legacy short values if needed
        $map = [
            'CaNhan' => 'Nhan',
            'DoanhNghiep' => 'Doanh',
            'NuocNgoai' => 'NuocNgoai',
        ];
        return $map[$this->LoaiKhachHang] ?? $this->LoaiKhachHang;
    }

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

    
    public function thongTinKhachHang()
    {
        return $this->hasOne(ThongTinKhachHang::class, 'KhachHangId', 'Id');
    }

    // Backwards-compatible alias for older code using the previous method name
    public function thongTinCaNhan()
    {
        return $this->thongTinKhachHang();
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
