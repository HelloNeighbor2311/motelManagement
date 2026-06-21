<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KhuVuc extends Model
{
    protected $table = 'KhuVuc';
    protected $primaryKey = 'Id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'TenKhuVuc',
        'DiaChi',
        'MoTa',
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
    public function toaNhas()
    {
        return $this->hasMany(ToaNha::class, 'KhuVucId', 'Id');
    }

    public function getTotalBuildingsAttribute()
    {
        return $this->toaNhas()->count();
    }
}
