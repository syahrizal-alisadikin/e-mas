<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mitra\DashboardController as MitraDashboardController;
use App\Http\Controllers\Mitra\StatusUmkmController;
use App\Http\Controllers\Mitra\UserController;
use App\Http\Controllers\User\BahanController;
use App\Http\Controllers\User\CertificateController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LaporanPenjualanController;
use App\Http\Controllers\User\ModalController;
use App\Http\Controllers\User\PemsaranController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('auth.login');
})->middleware('checkLogin');

Route::prefix('user')
        ->middleware('IsUser')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class,'index'])->name('user');

            Route::get('profile',[DashboardController::class,'profile'])->name('user.profile');
            Route::get('status',[DashboardController::class,'status'])->name('user.status');
            Route::get('sertifikasi',[DashboardController::class,'sertifikasi'])->name('user.sertifikasi');
            Route::POST('sertificate',[CertificateController::class,'store'])->name('certificate.store');
            Route::PUT('profile/update/{id}',[DashboardController::class,'updateProfile'])->name('user.update');
            Route::PUT('profile/status/{id}',[DashboardController::class,'updateStatus'])->name('user.status-update');

            // Penjualan Product
            Route::resource('laporan-penjualan-product',LaporanPenjualanController::class);
            Route::get('laporan-penjualan-product-date',[LaporanPenjualanController::class,'TransactionLaporan'])->name('transaction-laporan');
            // Pemsaran Kegiatan
            Route::resource('pemasaran',PemsaranController::class);
            // Product
            Route::resource('products',ProductController::class);
            // Modal
            Route::resource('modal',ModalController::class);
            // Bahan
            Route::resource('bahan-product',BahanController::class);
        });
Route::prefix('mitra')
        ->middleware('IsMitra')
        ->group(function () {
            Route::get('/dashboard', [MitraDashboardController::class,'index'])->name('rb');
            Route::resource('status-umkm',StatusUmkmController::class);
            Route::resource('users',UserController::class);

           

        });
Route::prefix('admin')
        ->middleware('IsAdmin')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('admin');

           
        });
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
