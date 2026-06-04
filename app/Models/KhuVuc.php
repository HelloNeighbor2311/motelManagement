<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhuVuc extends Model
{
    protected $table = 'KhuVuc';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['TenKhuVuc', 'DiaChi', 'MoTa'];
}
