<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard
Route::group([], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Khu Vực (Areas)
    Route::prefix('areas')->group(function () {
        Route::get('/', [AreaController::class, 'index'])->name('areas.index');
        Route::get('/create', [AreaController::class, 'create'])->name('areas.create');
        Route::post('/', [AreaController::class, 'store'])->name('areas.store');
        Route::get('/{id}', [AreaController::class, 'show'])->name('areas.show');
        Route::get('/{id}/edit', [AreaController::class, 'edit'])->name('areas.edit');
        Route::put('/{id}', [AreaController::class, 'update'])->name('areas.update');
        Route::delete('/{id}', [AreaController::class, 'destroy'])->name('areas.destroy');
    });

    // Tòa Nhà (Buildings)
    Route::prefix('buildings')->group(function () {
        Route::get('/', [BuildingController::class, 'index'])->name('buildings.index');
        Route::get('/create', [BuildingController::class, 'create'])->name('buildings.create');
        Route::post('/', [BuildingController::class, 'store'])->name('buildings.store');
        Route::get('/{id}', [BuildingController::class, 'show'])->name('buildings.show');
        Route::get('/{id}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
        Route::put('/{id}', [BuildingController::class, 'update'])->name('buildings.update');
        Route::delete('/{id}', [BuildingController::class, 'destroy'])->name('buildings.destroy');
    });

    // Căn Hộ (Apartments)
    Route::prefix('apartments')->group(function () {
        Route::get('/', [ApartmentController::class, 'index'])->name('apartments.index');
        Route::get('/floor-plan', [ApartmentController::class, 'floorPlan'])->name('apartments.floor-plan');
        Route::get('/create', [ApartmentController::class, 'create'])->name('apartments.create');
        Route::post('/', [ApartmentController::class, 'store'])->name('apartments.store');
        Route::get('/{id}', [ApartmentController::class, 'show'])->name('apartments.show');
        Route::get('/{id}/edit', [ApartmentController::class, 'edit'])->name('apartments.edit');
        Route::put('/{id}', [ApartmentController::class, 'update'])->name('apartments.update');
        Route::delete('/{id}', [ApartmentController::class, 'destroy'])->name('apartments.destroy');
    });

    // Khách Hàng (Customers)
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/info/{id?}', [CustomerController::class, 'info'])->name('customers.info');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // Hợp Đồng (Contracts)
    Route::prefix('contracts')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('/create', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/', [ContractController::class, 'store'])->name('contracts.store');
        Route::get('/{id}', [ContractController::class, 'show'])->name('contracts.show');
        Route::get('/{id}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::put('/{id}', [ContractController::class, 'update'])->name('contracts.update');
        Route::delete('/{id}', [ContractController::class, 'destroy'])->name('contracts.destroy');
    });

    // Hóa Đơn (Invoices)
    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::post('/{id}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
    });

    // Thu Chi (Transactions)
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/{id}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    // Báo Cáo (Reports)
    Route::prefix('reports')->group(function () {
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/quarterly', [ReportController::class, 'quarterly'])->name('reports.quarterly');
        Route::get('/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
    });

    // Tài Khoản Người Dùng (Users)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Roles
    Route::prefix('roles')->group(function () {
        Route::get('/', [UserController::class, 'roles'])->name('roles.index');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [UserController::class, 'settings'])->name('settings.index');
        Route::get('/profile', [UserController::class, 'profileSettings'])->name('settings.profile');
    });

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
