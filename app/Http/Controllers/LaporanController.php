<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Laporan Penggunaan Listrik
     */
    public function penggunaan(Request $request)
    {
        $query = Penggunaan::with(['pelanggan.dayaListrik.tarif']);

        if ($request->has('bulan') && $request->bulan != '') {
            $query->where('bulan', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->orderBy('tahun', 'desc')
                     ->orderBy('bulan', 'desc')
                     ->get();

        return view('laporan.penggunaan', compact('data'));
    }

    /**
     * Laporan Pembayaran
     */
    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['tagihan.pelanggan']);

        if ($request->has('dari') && $request->dari != '') {
            $query->whereDate('tanggal_bayar', '>=', $request->dari);
        }
        if ($request->has('sampai') && $request->sampai != '') {
            $query->whereDate('tanggal_bayar', '<=', $request->sampai);
        }

        $data = $query->orderBy('tanggal_bayar', 'desc')->get();
        $total_pembayaran = $data->sum('jumlah_bayar');

        return view('laporan.pembayaran', compact('data', 'total_pembayaran'));
    }

    /**
     * Laporan Tunggakan
     */
    public function tunggakan()
    {
        $data = Tagihan::with(['pelanggan', 'penggunaan'])
                      ->whereIn('status_bayar', ['Belum Bayar', 'Terlambat'])
                      ->orderBy('jatuh_tempo', 'asc')
                      ->get();

        $total_tunggakan = $data->sum(function($tagihan) {
            return $tagihan->total_tagihan + $tagihan->denda;
        });

        return view('laporan.tunggakan', compact('data', 'total_tunggakan'));
    }

    /**
     * Laporan Pelanggan per Daya
     */
    public function pelangganPerDaya()
    {
        $data = Pelanggan::select('id_daya_listrik', DB::raw('COUNT(*) as jumlah'))
                        ->with('dayaListrik.tarif')
                        ->groupBy('id_daya_listrik')
                        ->get();

        return view('laporan.pelanggan-per-daya', compact('data'));
    }
}
