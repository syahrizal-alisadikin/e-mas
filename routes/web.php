<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RumahBUMNController;
use App\Http\Controllers\Mitra\DashboardController as MitraDashboardController;
use App\Http\Controllers\Mitra\PemasaranController;
use App\Http\Controllers\Mitra\ProductController as MitraProductController;
use App\Http\Controllers\Mitra\StatusUmkmController;
use App\Http\Controllers\Mitra\TransactionController;
use App\Http\Controllers\Mitra\UserController;
use App\Http\Controllers\User\BahanController;
use App\Http\Controllers\User\CertificateController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\DataAsetController;
use App\Http\Controllers\User\LaporanPenjualanController;
use App\Http\Controllers\User\ModalController;
use App\Http\Controllers\User\PemsaranController;
use App\Http\Controllers\User\ProductController;
use App\Models\User;
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
    $global = User::whereHas('status',function($q){
        $q->where('name','Go Global');
    })->count();
    $online = User::whereHas('status',function($q){
        $q->where('name','Go Online');
    })->count();
    $modern = User::whereHas('status',function($q){
        $q->where('name','Go Modern');
    })->count();
    $digital = User::whereHas('status',function($q){
        $q->where('name','Go Digital');
    })->count();
    $umkm = User::where('roles','MB')->count();
    return view('auth.login',['global' => $global,
                                'online' => $online,
                                'modern' => $modern,
                                'digital' => $digital,
                                'umkm' => $umkm]);
})->middleware('checkLogin');

Route::prefix('user')
        ->middleware('IsUser')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class,'index'])->name('user');

            Route::get('profile',[DashboardController::class,'profile'])->name('user.profile');
            // Route::get('status',[DashboardController::class,'status'])->name('user.status');
            Route::get('sertifikasi',[DashboardController::class,'sertifikasi'])->name('user.sertifikasi');
            Route::POST('sertificate',[CertificateController::class,'store'])->name('certificate.store');
            Route::PUT('profile/update/{id}',[DashboardController::class,'updateProfile'])->name('user.update');
            Route::PUT('profile/status/{id}',[DashboardController::class,'updateStatus'])->name('user.status-update');
            Route::resource('data-aset',DataAsetController::class);
            // Penjualan Product
            Route::resource('laporan-penjualan-product',LaporanPenjualanController::class);
            Route::get('laporan-penjualan-product-date',[LaporanPenjualanController::class,'TransactionLaporan'])->name('transaction-laporan');
            Route::get('transaksi-download-pdf',[LaporanPenjualanController::class,'TransaksiPdf'])->name('transaksi-download-pdf');
            Route::get('transaksi-date-download-pdf',[LaporanPenjualanController::class,'TransaksiPdfdate'])->name('transaksi-date-download-pdf');
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
            Route::resource('products-mitra',MitraProductController::class);
            Route::resource('transactions',TransactionController::class);
            Route::get('transactions-date',[TransactionController::class,'TransactionLaporan'])->name('transactions-mitra');
            Route::POST('transactions-rb',[TransactionController::class,'TransaksiDownloadPdf'])->name('transaksi-rb-download-pdf');
            Route::POST('transactions-rb-date',[TransactionController::class,'TransaksiDownloadPdfDate'])->name('transaksi-rb-download-date');
            Route::resource('pemasaran-mitra',PemasaranController::class);

           

        });
Route::prefix('admin')
        ->middleware('IsAdmin')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('admin');
            Route::resource('rumah-bumn',RumahBUMNController::class);
            Route::get('rumah-bumn/produk/{id}',[RumahBUMNController::class,'ShowProduk'])->name('rumah-bumn.produk');
            Route::get('rumah-bumn/pemasaran/{id}',[RumahBUMNController::class,'ShowPemasaran'])->name('rumah-bumn.pemasaran');
            Route::get('rumah-bumn/transaksi/{id}',[RumahBUMNController::class,'ShowTransaksi'])->name('rumah-bumn.transaksi');
            Route::get('rumah-bumn/transaksi/{id}/all',[RumahBUMNController::class,'ShowTransaksiAll'])->name('rumah-bumn.transaksi.all');
            Route::get('rumah-bumn/transaksi/detail/{id}/{user}',[RumahBUMNController::class,'DetailTransaksi'])->name('rumah-bumn.detailtransaksi');
            Route::get('rumah-bumn/transaksi/detail-all/{id}',[RumahBUMNController::class,'DetailTransaksiAll'])->name('rumah-bumn.detailtransaksi.all');
            Route::get('mitra-admin',[RumahBUMNController::class,'MitraAdmin'])->name('mitra-admin');
            Route::POST('transactions-admin',[TransactionController::class,'TransaksiDownloadPdf'])->name('transaksi-admin-download-pdf');
           
        });
Auth::routes();

