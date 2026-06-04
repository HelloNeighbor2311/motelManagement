<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToaNha extends Model
{
    protected $table = 'ToaNha';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['KhuVucId', 'TenToaNha', 'SoTang', 'MoTa'];
}
