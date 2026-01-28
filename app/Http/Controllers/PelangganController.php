<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\DayaListrik;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Display a listing of pelanggan
     */
    public function index(Request $request)
    {
        $query = Pelanggan::with(['dayaListrik.tarif', 'user']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('no_telepon', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pelanggan = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('pelanggan.index', compact('pelanggan'));
    }

    /**
     * Show the form for creating a new pelanggan
     */
    public function create()
    {
        $dayaListrik = DayaListrik::with('tarif')->get();
        $nextId = Pelanggan::generateIdPelanggan();
        
        return view('pelanggan.create', compact('dayaListrik', 'nextId'));
    }

    /**
     * Store a newly created pelanggan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|max:100',
            'alamat' => 'required',
            'no_telepon' => 'nullable|max:15',
            'email' => 'nullable|email|max:100',
            'id_daya_listrik' => 'required|exists:daya_listrik,id_daya_listrik',
            'tanggal_registrasi' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Generate ID Pelanggan
            $validated['id_pelanggan'] = Pelanggan::generateIdPelanggan();
            $validated['status'] = 'Aktif';

            // Create pelanggan
            $pelanggan = Pelanggan::create($validated);

            // Optionally create user account for pelanggan
            if ($request->has('create_user_account')) {
                $levelPelanggan = Level::where('nama_level', 'Pelanggan')->first();
                
                $user = User::create([
                    'username' => $validated['id_pelanggan'],
                    'password' => md5('password123'), // Default password
                    'nama_lengkap' => $validated['nama_pelanggan'],
                    'email' => $validated['email'],
                    'id_level' => $levelPelanggan->id_level,
                    'is_active' => true,
                ]);

                // Link user to pelanggan
                $pelanggan->update(['id_user' => $user->id_user]);
            }

            DB::commit();

            return redirect()->route('pelanggan.index')
                           ->with('success', 'Pelanggan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->withErrors(['error' => 'Gagal menambahkan pelanggan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified pelanggan
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::with(['dayaListrik.tarif', 'user', 'penggunaan.tagihan.pembayaran'])
                              ->findOrFail($id);

        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified pelanggan
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $dayaListrik = DayaListrik::with('tarif')->get();

        return view('pelanggan.edit', compact('pelanggan', 'dayaListrik'));
    }

    /**
     * Update the specified pelanggan
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'nama_pelanggan' => 'required|max:100',
            'alamat' => 'required',
            'no_telepon' => 'nullable|max:15',
            'email' => 'nullable|email|max:100',
            'id_daya_listrik' => 'required|exists:daya_listrik,id_daya_listrik',
            'status' => 'required|in:Aktif,Nonaktif,Suspend',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
                       ->with('success', 'Data pelanggan berhasil diupdate');
    }

    /**
     * Remove the specified pelanggan
     */
    public function destroy($id)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);
            $pelanggan->delete();

            return redirect()->route('pelanggan.index')
                           ->with('success', 'Pelanggan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pelanggan.index')
                           ->withErrors(['error' => 'Gagal menghapus pelanggan: ' . $e->getMessage()]);
        }
    }
}
