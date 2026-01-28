<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes for Admin ONLY
    Route::middleware(['role:Admin'])->group(function () {
        // User Management (Admin exclusive)
        Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        
        // Delete operations (Admin only)
        Route::delete('pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
        Route::delete('penggunaan/{id}', [PenggunaanController::class, 'destroy'])->name('penggunaan.destroy');
    });

    // Routes for Admin & Operator
    Route::middleware(['role:Admin,Operator'])->group(function () {
        
        // Pelanggan management (Operator can't delete)
        Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::get('pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
        
        // Penggunaan management (Operator can't delete)
        Route::get('penggunaan', [PenggunaanController::class, 'index'])->name('penggunaan.index');
        Route::get('penggunaan/create', [PenggunaanController::class, 'create'])->name('penggunaan.create');
        Route::post('penggunaan', [PenggunaanController::class, 'store'])->name('penggunaan.store');
        Route::get('penggunaan/{id}', [PenggunaanController::class, 'show'])->name('penggunaan.show');
        Route::get('penggunaan/{id}/edit', [PenggunaanController::class, 'edit'])->name('penggunaan.edit');
        Route::put('penggunaan/{id}', [PenggunaanController::class, 'update'])->name('penggunaan.update');
        Route::get('penggunaan/latest-meter/{id_pelanggan}', [PenggunaanController::class, 'getLatestMeter'])
            ->name('penggunaan.latest-meter');
        
        // Tagihan management
        Route::get('tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
        Route::get('tagihan/{id}', [TagihanController::class, 'show'])->name('tagihan.show');
        Route::post('tagihan/{id}/hitung-denda', [TagihanController::class, 'hitungDenda'])->name('tagihan.hitung-denda');
        Route::get('tagihan/{id}/pdf', [TagihanController::class, 'exportPdf'])->name('tagihan.pdf');
        
        // Pembayaran management
        Route::resource('pembayaran', PembayaranController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('pembayaran/{id}/receipt', [PembayaranController::class, 'printReceipt'])->name('pembayaran.receipt');
        
        // Laporan (Reports)
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('penggunaan', [LaporanController::class, 'penggunaan'])->name('penggunaan');
            Route::get('pembayaran', [LaporanController::class, 'pembayaran'])->name('pembayaran');
            Route::get('tunggakan', [LaporanController::class, 'tunggakan'])->name('tunggakan');
            Route::get('pelanggan-per-daya', [LaporanController::class, 'pelangganPerDaya'])->name('pelanggan-per-daya');
        });
    });

    // Routes for Pelanggan (Customer)
    Route::middleware(['role:Pelanggan'])->group(function () {
        Route::get('/my-account', function () {
            $pelanggan = auth()->user()->pelanggan;
            return view('pelanggan.my-account', compact('pelanggan'));
        })->name('my-account');
        
        Route::get('/my-usage', function () {
            $pelanggan = auth()->user()->pelanggan;
            $penggunaan = $pelanggan->penggunaan()->with('tagihan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
            return view('pelanggan.my-usage', compact('pelanggan', 'penggunaan'));
        })->name('my-usage');
        
        Route::get('/my-bills', function () {
            $pelanggan = auth()->user()->pelanggan;
            $tagihan = $pelanggan->tagihan()->with('penggunaan', 'pembayaran')->orderBy('tanggal_tagihan', 'desc')->get();
            return view('pelanggan.my-bills', compact('pelanggan', 'tagihan'));
        })->name('my-bills');
    });
});

