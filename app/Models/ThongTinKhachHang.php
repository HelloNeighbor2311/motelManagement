<?php

namespace App\Models;

use App\Models\KhachHang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ThongTinKhachHang extends Model
{
    protected $table = 'ThongTinKhachHang';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['KhachHangId', 'NgaySinh', 'GioiTinh', 'SoGiayTo', 'DiaChiThuongTru', 'QuocTich', 'GhiChu'];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'KhachHangId', 'Id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->Id)) {
                $model->Id = (string) Str::uuid();
            }
            if (empty($model->UpdatedAt)) {
                $model->UpdatedAt = now();
            }
        });
    }
}
