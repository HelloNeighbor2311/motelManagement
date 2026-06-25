<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\OwnedByUser;

class BaoCaoTaiChinh extends Model
{
    use OwnedByUser;
    protected $table = 'BaoCaoTaiChinh';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['Id', 'user_id', 'TaiKhoanId', 'LoaiBaoCao', 'Thang', 'Nam', 'TongThu', 'TongChi', 'TienThueThu', 'TienDatCocThu', 'ChiPhiVanHanh'];

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
