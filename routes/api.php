<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ThongTinKhachHangController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

Route::middleware('api')->group(function () {
    Route::apiResource('khu-vuc', AreaController::class);
    Route::apiResource('toa-nha', BuildingController::class);
    Route::apiResource('can-ho', ApartmentController::class);
    //account resource handled by UserController
    Route::get('tai-khoan', [UserController::class, 'taiKhoanIndex']);
    Route::post('tai-khoan', [UserController::class, 'taiKhoanStore']);
    Route::get('tai-khoan/{id}', [UserController::class, 'taiKhoanShow']);
    Route::put('tai-khoan/{id}', [UserController::class, 'taiKhoanUpdate']);
    Route::patch('tai-khoan/{id}', [UserController::class, 'taiKhoanUpdate']);
    Route::delete('tai-khoan/{id}', [UserController::class, 'taiKhoanDestroy']);
    Route::apiResource('khach-hang', CustomerController::class);
    Route::apiResource('thong-tin-khach-hang', ThongTinKhachHangController::class);
    Route::apiResource('hop-dong', ContractController::class);
    Route::apiResource('hoa-don', InvoiceController::class);
    Route::apiResource('thu-chi', TransactionController::class);
    Route::apiResource('bao-cao-tai-chinh', ReportController::class);
});
