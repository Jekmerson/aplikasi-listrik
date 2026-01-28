<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of users (Admin only)
     */
    public function index()
    {
        $users = User::with('level')->orderBy('created_at', 'desc')->paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $levels = Level::all();
        return view('users.create', compact('levels'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:user,username|max:50',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'id_level' => 'required|exists:level,id_level',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = md5($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        User::create($validated);

        return redirect()->route('users.index')
                       ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $levels = Level::all();
        return view('users.edit', compact('user', 'levels'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'id_level' => 'required|exists:level,id_level',
            'is_active' => 'boolean',
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = md5($request->password);
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $user->update($validated);

        return redirect()->route('users.index')
                       ->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting own account
            if ($user->id_user == auth()->id()) {
                return redirect()->route('users.index')
                               ->withErrors(['error' => 'Tidak dapat menghapus akun sendiri']);
            }

            $user->delete();

            return redirect()->route('users.index')
                           ->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                           ->withErrors(['error' => 'Gagal menghapus user: ' . $e->getMessage()]);
        }
    }
}
