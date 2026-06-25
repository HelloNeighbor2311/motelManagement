<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\OwnedByUser;

class HoaDon extends Model
{
    use OwnedByUser;
    protected $table = 'HoaDon';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'Id', 'user_id', 'HopDongId', 'KhachHangId', 'MaHoaDon', 'NgayPhatHanh', 'NgayDenHan', 'NgayThanhToan',
        'SoTien', 'LoaiHoaDon', 'TrangThaiThanhToan', 'Thang', 'Nam'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->Id)) {
                $model->Id = (string) Str::uuid();
            }
        });
    }

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'KhachHangId', 'Id');
    }

    public function hopDong()
    {
        return $this->belongsTo(HopDong::class, 'HopDongId', 'Id');
    }
}
