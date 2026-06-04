<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanHo extends Model
{
    protected $table = 'CanHo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['ToaNhaId', 'MaCanHo', 'Tang', 'DienTich', 'SoPhong', 'TrangThai', 'GiaThue'];
}
