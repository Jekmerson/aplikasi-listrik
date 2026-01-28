<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistics
        $stats = [
            'total_pelanggan' => Pelanggan::where('status', 'Aktif')->count(),
            'total_penggunaan' => Penggunaan::whereMonth('tanggal_catat', now()->month)
                                            ->whereYear('tanggal_catat', now()->year)
                                            ->count(),
            'total_tagihan_belum_bayar' => Tagihan::belumBayar()->count(),
            'total_pendapatan' => Pembayaran::whereMonth('tanggal_bayar', now()->month)
                                            ->whereYear('tanggal_bayar', now()->year)
                                            ->sum('jumlah_bayar'),
        ];

        // Latest activities
        $latest_penggunaan = Penggunaan::with(['pelanggan.dayaListrik.tarif'])
                                      ->orderBy('tanggal_catat', 'desc')
                                      ->limit(10)
                                      ->get();

        $tagihan_jatuh_tempo = Tagihan::with(['pelanggan'])
                                      ->belumBayar()
                                      ->where('jatuh_tempo', '<=', now()->addDays(7))
                                      ->orderBy('jatuh_tempo', 'asc')
                                      ->limit(10)
                                      ->get();

        $latest_pembayaran = Pembayaran::with(['tagihan.pelanggan'])
                                       ->orderBy('tanggal_bayar', 'desc')
                                       ->limit(10)
                                       ->get();

        // Monthly revenue chart data
        $monthly_revenue = Pembayaran::select(
                                DB::raw('MONTH(tanggal_bayar) as bulan'),
                                DB::raw('SUM(jumlah_bayar) as total')
                            )
                            ->whereYear('tanggal_bayar', now()->year)
                            ->groupBy('bulan')
                            ->orderBy('bulan')
                            ->get();

        return view('dashboard.index', compact(
            'user',
            'stats',
            'latest_penggunaan',
            'tagihan_jatuh_tempo',
            'latest_pembayaran',
            'monthly_revenue'
        ));
    }
}
