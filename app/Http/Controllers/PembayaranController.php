<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of pembayaran
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with(['tagihan.pelanggan']);

        // Filter by date range
        if ($request->has('dari') && $request->dari != '') {
            $query->whereDate('tanggal_bayar', '>=', $request->dari);
        }
        if ($request->has('sampai') && $request->sampai != '') {
            $query->whereDate('tanggal_bayar', '<=', $request->sampai);
        }

        // Filter by payment method
        if ($request->has('metode') && $request->metode != '') {
            $query->where('metode_bayar', $request->metode);
        }

        $pembayaran = $query->orderBy('tanggal_bayar', 'desc')
                           ->paginate(15);

        return view('pembayaran.index', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new pembayaran
     */
    public function create(Request $request)
    {
        // Get tagihan belum bayar
        $tagihan = Tagihan::with(['pelanggan', 'penggunaan'])
                         ->whereIn('status_bayar', ['Belum Bayar', 'Terlambat'])
                         ->orderBy('jatuh_tempo', 'asc')
                         ->get();

        // If id_tagihan provided in query
        $selected_tagihan = null;
        if ($request->has('id_tagihan')) {
            $selected_tagihan = Tagihan::with(['pelanggan', 'penggunaan'])
                                      ->find($request->id_tagihan);
        }

        return view('pembayaran.create', compact('tagihan', 'selected_tagihan'));
    }

    /**
     * Store a newly created pembayaran
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_tagihan' => 'required|exists:tagihan,id_tagihan',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Tunai,Transfer,EDC,QRIS',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $tagihan = Tagihan::findOrFail($validated['id_tagihan']);

            // Check if tagihan already paid
            if ($tagihan->status_bayar == 'Sudah Bayar') {
                return back()->withInput()
                            ->withErrors(['error' => 'Tagihan sudah dibayar']);
            }

            // Calculate total with denda
            $total_harus_bayar = $tagihan->total_tagihan + $tagihan->denda;

            // Validate payment amount
            if ($validated['jumlah_bayar'] < $total_harus_bayar) {
                return back()->withInput()
                            ->withErrors(['jumlah_bayar' => 'Jumlah pembayaran kurang dari total tagihan']);
            }

            // Create pembayaran
            $validated['tanggal_bayar'] = now();
            Pembayaran::create($validated);

            // Update tagihan status
            $tagihan->update([
                'status_bayar' => 'Sudah Bayar'
            ]);

            DB::commit();

            return redirect()->route('pembayaran.index')
                           ->with('success', 'Pembayaran berhasil diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->withErrors(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified pembayaran
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['tagihan.pelanggan.dayaListrik.tarif', 'tagihan.penggunaan'])
                               ->findOrFail($id);

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Print receipt
     */
    public function printReceipt($id)
    {
        $pembayaran = Pembayaran::with(['tagihan.pelanggan.dayaListrik.tarif', 'tagihan.penggunaan'])
                               ->findOrFail($id);

        return view('pembayaran.receipt', compact('pembayaran'));
    }
}
