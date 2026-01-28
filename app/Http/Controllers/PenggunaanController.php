<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggunaan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

class PenggunaanController extends Controller
{
    /**
     * Display a listing of penggunaan
     */
    public function index(Request $request)
    {
        $query = Penggunaan::with(['pelanggan.dayaListrik.tarif', 'tagihan']);

        // Filter by period
        if ($request->has('bulan') && $request->bulan != '') {
            $query->where('bulan', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Search by pelanggan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pelanggan', function($q) use ($search) {
                $q->where('id_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'LIKE', "%{$search}%");
            });
        }

        $penggunaan = $query->orderBy('tahun', 'desc')
                           ->orderBy('bulan', 'desc')
                           ->paginate(15);

        return view('penggunaan.index', compact('penggunaan'));
    }

    /**
     * Show the form for creating a new penggunaan
     */
    public function create()
    {
        $pelanggan = Pelanggan::where('status', 'Aktif')
                             ->with('dayaListrik')
                             ->get();

        return view('penggunaan.create', compact('pelanggan'));
    }

    /**
     * Get latest meter reading for pelanggan
     */
    public function getLatestMeter($id_pelanggan)
    {
        $latest = Penggunaan::where('id_pelanggan', $id_pelanggan)
                           ->orderBy('tahun', 'desc')
                           ->orderBy('bulan', 'desc')
                           ->first();

        return response()->json([
            'meter_akhir' => $latest ? $latest->meter_akhir : 0
        ]);
    }

    /**
     * Store a newly created penggunaan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|min:0|gt:meter_awal',
        ]);

        // Check if already exists
        $exists = Penggunaan::where('id_pelanggan', $validated['id_pelanggan'])
                           ->where('bulan', $validated['bulan'])
                           ->where('tahun', $validated['tahun'])
                           ->exists();

        if ($exists) {
            return back()->withInput()
                        ->withErrors(['error' => 'Data penggunaan untuk periode ini sudah ada']);
        }

        try {
            $validated['tanggal_catat'] = now();
            Penggunaan::create($validated);

            return redirect()->route('penggunaan.index')
                           ->with('success', 'Data penggunaan berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified penggunaan
     */
    public function show($id)
    {
        $penggunaan = Penggunaan::with(['pelanggan.dayaListrik.tarif', 'tagihan.pembayaran'])
                               ->findOrFail($id);

        return view('penggunaan.show', compact('penggunaan'));
    }

    /**
     * Show the form for editing the specified penggunaan
     */
    public function edit($id)
    {
        $penggunaan = Penggunaan::findOrFail($id);
        $pelanggan = Pelanggan::where('status', 'Aktif')
                             ->with('dayaListrik')
                             ->get();

        return view('penggunaan.edit', compact('penggunaan', 'pelanggan'));
    }

    /**
     * Update the specified penggunaan
     */
    public function update(Request $request, $id)
    {
        $penggunaan = Penggunaan::findOrFail($id);

        $validated = $request->validate([
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|min:0|gt:meter_awal',
        ]);

        $penggunaan->update($validated);

        // Update tagihan if exists
        if ($penggunaan->tagihan) {
            $pelanggan = $penggunaan->pelanggan;
            $tarif = $pelanggan->dayaListrik->tarif;
            $total_kwh = $validated['meter_akhir'] - $validated['meter_awal'];
            $total_tagihan = ($total_kwh * $tarif->tarif_per_kwh) + $tarif->biaya_beban;

            $penggunaan->tagihan->update([
                'total_tagihan' => $total_tagihan
            ]);
        }

        return redirect()->route('penggunaan.index')
                       ->with('success', 'Data penggunaan berhasil diupdate');
    }

    /**
     * Remove the specified penggunaan
     */
    public function destroy($id)
    {
        try {
            $penggunaan = Penggunaan::findOrFail($id);
            $penggunaan->delete();

            return redirect()->route('penggunaan.index')
                           ->with('success', 'Data penggunaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('penggunaan.index')
                           ->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
