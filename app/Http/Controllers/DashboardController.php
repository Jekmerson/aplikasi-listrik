<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirect based on role
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isOperator()) {
            return $this->operatorDashboard();
        } else {
            return $this->pelangganDashboard();
        }
    }

    /**
     * Admin Dashboard - Full Analytics
     */
    private function adminDashboard()
    {
        $stats = [
            'total_pelanggan' => Pelanggan::count(),
            'pelanggan_aktif' => Pelanggan::where('status', 'Aktif')->count(),
            'total_user' => User::where('is_active', true)->count(),
            'total_penggunaan_bulan_ini' => Penggunaan::whereMonth('tanggal_catat', now()->month)
                                            ->whereYear('tanggal_catat', now()->year)
                                            ->count(),
            'total_tagihan_belum_bayar' => Tagihan::belumBayar()->count(),
            'total_tagihan_terlambat' => Tagihan::terlambat()->count(),
            'total_pendapatan_bulan_ini' => Pembayaran::whereMonth('tanggal_bayar', now()->month)
                                            ->whereYear('tanggal_bayar', now()->year)
                                            ->sum('jumlah_bayar'),
            'total_pendapatan_tahun_ini' => Pembayaran::whereYear('tanggal_bayar', now()->year)
                                            ->sum('jumlah_bayar'),
            'total_tunggakan' => Tagihan::whereIn('status_bayar', ['Belum Bayar', 'Terlambat'])
                                        ->sum(DB::raw('total_tagihan + denda')),
        ];

        // User activity
        $users_online = User::where('is_active', true)->get();

        // Monthly revenue trend
        $monthly_revenue = Pembayaran::select(
                                DB::raw('MONTH(tanggal_bayar) as bulan'),
                                DB::raw('SUM(jumlah_bayar) as total')
                            )
                            ->whereYear('tanggal_bayar', now()->year)
                            ->groupBy('bulan')
                            ->orderBy('bulan')
                            ->get();

        // Pelanggan per daya
        $pelanggan_per_daya = Pelanggan::select('id_daya_listrik', DB::raw('COUNT(*) as jumlah'))
                                      ->with('dayaListrik')
                                      ->groupBy('id_daya_listrik')
                                      ->get();

        // Top 5 pelanggan dengan tagihan tertinggi
        $top_pelanggan = Tagihan::with('pelanggan')
                                ->where('status_bayar', 'Belum Bayar')
                                ->orderBy('total_tagihan', 'desc')
                                ->limit(5)
                                ->get();

        // Latest activities
        $latest_pembayaran = Pembayaran::with(['tagihan.pelanggan'])
                                       ->orderBy('tanggal_bayar', 'desc')
                                       ->limit(5)
                                       ->get();

        return view('dashboard.admin', compact(
            'stats',
            'users_online',
            'monthly_revenue',
            'pelanggan_per_daya',
            'top_pelanggan',
            'latest_pembayaran'
        ));
    }

    /**
     * Operator Dashboard - Operational Focus
     */
    private function operatorDashboard()
    {
        $stats = [
            'pelanggan_aktif' => Pelanggan::where('status', 'Aktif')->count(),
            'penggunaan_hari_ini' => Penggunaan::whereDate('tanggal_catat', now())->count(),
            'tagihan_belum_bayar' => Tagihan::belumBayar()->count(),
            'pembayaran_hari_ini' => Pembayaran::whereDate('tanggal_bayar', now())->count(),
            'total_pembayaran_hari_ini' => Pembayaran::whereDate('tanggal_bayar', now())
                                                     ->sum('jumlah_bayar'),
        ];

        // Today's activities
        $penggunaan_hari_ini = Penggunaan::with(['pelanggan.dayaListrik'])
                                        ->whereDate('tanggal_catat', now())
                                        ->orderBy('tanggal_catat', 'desc')
                                        ->get();

        $pembayaran_hari_ini = Pembayaran::with(['tagihan.pelanggan'])
                                        ->whereDate('tanggal_bayar', now())
                                        ->orderBy('tanggal_bayar', 'desc')
                                        ->get();

        // Tagihan jatuh tempo minggu ini
        $tagihan_jatuh_tempo = Tagihan::with(['pelanggan'])
                                      ->belumBayar()
                                      ->whereBetween('jatuh_tempo', [now(), now()->addDays(7)])
                                      ->orderBy('jatuh_tempo', 'asc')
                                      ->get();

        // Quick stats per metode bayar hari ini
        $pembayaran_per_metode = Pembayaran::select('metode_bayar', DB::raw('COUNT(*) as jumlah'))
                                          ->whereDate('tanggal_bayar', now())
                                          ->groupBy('metode_bayar')
                                          ->get();

        return view('dashboard.operator', compact(
            'stats',
            'penggunaan_hari_ini',
            'pembayaran_hari_ini',
            'tagihan_jatuh_tempo',
            'pembayaran_per_metode'
        ));
    }

    /**
     * Pelanggan Dashboard - Personal Info
     */
    private function pelangganDashboard()
    {
        $pelanggan = auth()->user()->pelanggan;

        if (!$pelanggan) {
            return view('dashboard.pelanggan-no-account');
        }

        // Personal stats
        $stats = [
            'total_tagihan_belum_bayar' => $pelanggan->tagihan()->belumBayar()->count(),
            'total_nominal_belum_bayar' => $pelanggan->tagihan()
                                                    ->whereIn('status_bayar', ['Belum Bayar', 'Terlambat'])
                                                    ->sum(DB::raw('total_tagihan + denda')),
            'penggunaan_bulan_ini' => $pelanggan->penggunaan()
                                               ->where('bulan', now()->month)
                                               ->where('tahun', now()->year)
                                               ->first(),
        ];

        // Last 6 months usage
        $penggunaan_6bulan = $pelanggan->penggunaan()
                                      ->with('tagihan')
                                      ->orderBy('tahun', 'desc')
                                      ->orderBy('bulan', 'desc')
                                      ->limit(6)
                                      ->get();

        // Unpaid bills
        $tagihan_belum_bayar = $pelanggan->tagihan()
                                        ->with('penggunaan')
                                        ->whereIn('status_bayar', ['Belum Bayar', 'Terlambat'])
                                        ->orderBy('jatuh_tempo', 'asc')
                                        ->get();

        // Payment history
        $riwayat_pembayaran = Pembayaran::whereHas('tagihan', function($q) use ($pelanggan) {
                                        $q->where('id_pelanggan', $pelanggan->id_pelanggan);
                                    })
                                    ->with(['tagihan.penggunaan'])
                                    ->orderBy('tanggal_bayar', 'desc')
                                    ->limit(5)
                                    ->get();

        return view('dashboard.pelanggan', compact(
            'pelanggan',
            'stats',
            'penggunaan_6bulan',
            'tagihan_belum_bayar',
            'riwayat_pembayaran'
        ));
    }
}
