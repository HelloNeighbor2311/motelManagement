<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\OwnedByUser;

class ToaNha extends Model
{
    use OwnedByUser;
    protected $table = 'ToaNha';
    protected $primaryKey = 'Id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'user_id',
        'KhuVucId',
        'TenToaNha',
        'SoTang',
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
    public function khuVuc()
    {
        return $this->belongsTo(KhuVuc::class, 'KhuVucId', 'Id');
    }

    public function canHos()
    {
        return $this->hasMany(CanHo::class, 'ToaNhaId', 'Id');
    }
}
