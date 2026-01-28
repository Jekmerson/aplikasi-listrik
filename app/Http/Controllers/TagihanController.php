<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanController extends Controller
{
    /**
     * Display a listing of tagihan
     */
    public function index(Request $request)
    {
        $query = Tagihan::with(['pelanggan', 'penggunaan']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_bayar', $request->status);
        }

        // Search by pelanggan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pelanggan', function($q) use ($search) {
                $q->where('id_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'LIKE', "%{$search}%");
            });
        }

        $tagihan = $query->orderBy('tanggal_tagihan', 'desc')
                        ->paginate(15);

        // Update status terlambat
        Tagihan::where('status_bayar', 'Belum Bayar')
               ->where('jatuh_tempo', '<', now())
               ->update(['status_bayar' => 'Terlambat']);

        return view('tagihan.index', compact('tagihan'));
    }

    /**
     * Display the specified tagihan
     */
    public function show($id)
    {
        $tagihan = Tagihan::with(['pelanggan.dayaListrik.tarif', 'penggunaan', 'pembayaran'])
                         ->findOrFail($id);

        return view('tagihan.show', compact('tagihan'));
    }

    /**
     * Calculate and add denda for late payment
     */
    public function hitungDenda($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        if ($tagihan->status_bayar == 'Belum Bayar' && now()->greaterThan($tagihan->jatuh_tempo)) {
            // Hitung denda 2% per bulan
            $hari_terlambat = now()->diffInDays($tagihan->jatuh_tempo);
            $bulan_terlambat = ceil($hari_terlambat / 30);
            $denda = $tagihan->total_tagihan * 0.02 * $bulan_terlambat;

            $tagihan->update([
                'denda' => $denda,
                'status_bayar' => 'Terlambat'
            ]);

            return redirect()->back()
                           ->with('success', 'Denda berhasil dihitung: Rp ' . number_format($denda, 0, ',', '.'));
        }

        return redirect()->back()
                       ->with('info', 'Tidak ada denda untuk tagihan ini');
    }

    /**
     * Export tagihan to PDF
     */
    public function exportPdf($id)
    {
        $tagihan = Tagihan::with(['pelanggan.dayaListrik.tarif', 'penggunaan'])
                         ->findOrFail($id);

        // You can implement PDF export here using packages like dompdf or snappy
        // For now, return view
        return view('tagihan.pdf', compact('tagihan'));
    }
}
