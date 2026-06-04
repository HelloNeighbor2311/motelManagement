<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\ToaNhaController;
use App\Http\Controllers\CanHoController;
use App\Http\Controllers\TaiKhoanNguoiDungController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\ThongTinCaNhanController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\ThuChiController;
use App\Http\Controllers\BaoCaoTaiChinhController;

Route::middleware('api')->group(function () {
    Route::apiResource('khu-vuc', KhuVucController::class);
    Route::apiResource('toa-nha', ToaNhaController::class);
    Route::apiResource('can-ho', CanHoController::class);
    Route::apiResource('tai-khoan', TaiKhoanNguoiDungController::class);
    Route::apiResource('khach-hang', KhachHangController::class);
    Route::apiResource('thong-tin-ca-nhan', ThongTinCaNhanController::class);
    Route::apiResource('hop-dong', HopDongController::class);
    Route::apiResource('hoa-don', HoaDonController::class);
    Route::apiResource('thu-chi', ThuChiController::class);
    Route::apiResource('bao-cao-tai-chinh', BaoCaoTaiChinhController::class);
});
