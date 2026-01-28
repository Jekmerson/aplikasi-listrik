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

    // ========================================
    // ADMIN ONLY ROUTES
    // ========================================
    Route::middleware(['admin'])->group(function () {
        
        // User Management (Admin only)
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::post('users/{user}/toggle-active', [\App\Http\Controllers\UserController::class, 'toggleActive'])
            ->name('users.toggle-active');
        
        // Pelanggan - Delete only for Admin
        Route::delete('pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])
            ->name('pelanggan.destroy');
        
        // Full Reports Access (Admin only)
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('penggunaan', [LaporanController::class, 'penggunaan'])->name('penggunaan');
            Route::get('pembayaran', [LaporanController::class, 'pembayaran'])->name('pembayaran');
            Route::get('tunggakan', [LaporanController::class, 'tunggakan'])->name('tunggakan');
            Route::get('pelanggan-per-daya', [LaporanController::class, 'pelangganPerDaya'])->name('pelanggan-per-daya');
        });
    });

    // ========================================
    // ADMIN & OPERATOR ROUTES
    // ========================================
    Route::middleware(['role:Admin,Operator'])->group(function () {
        
        // Pelanggan management (View, Create, Edit for both)
        Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('pelanggan/{pelanggan}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::get('pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
        
        // Penggunaan management
        Route::resource('penggunaan', PenggunaanController::class);
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
    });

    // ========================================
    // PELANGGAN (CUSTOMER) ROUTES
    // ========================================
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

