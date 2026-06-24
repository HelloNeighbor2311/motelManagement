<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiKhoanNguoiDung extends Model
{
    protected $table = 'TaiKhoanNguoiDung';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['HoTen', 'SoDienThoai', 'Email', 'TenDangNhap', 'MatKhauHash', 'TrangThaiTk'];

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
