<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    protected $table = 'HopDong';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['KhachHangId', 'CanHoId', 'ToaNhaId', 'MaHopDong', 'NgayBatDau', 'NgayKetThuc', 'GiaThueThaoThuan', 'TienDatCoc'];
}
