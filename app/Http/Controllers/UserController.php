<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
=======
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\DB;
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd

class UserController extends Controller
{
    /**
<<<<<<< HEAD
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('level')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
=======
     * Display a listing of users (Admin only)
     */
    public function index()
    {
        $users = User::with('level')->orderBy('created_at', 'desc')->paginate(15);
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
        return view('users.index', compact('users'));
    }

    /**
<<<<<<< HEAD
     * Show the form for creating a new user.
=======
     * Show the form for creating a new user
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
     */
    public function create()
    {
        $levels = Level::all();
        return view('users.create', compact('levels'));
    }

    /**
<<<<<<< HEAD
     * Store a newly created user in storage.
=======
     * Store a newly created user
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'username' => 'required|string|max:50|unique:user,username',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
=======
            'username' => 'required|unique:user,username|max:50',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required|max:100',
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
            'email' => 'nullable|email|max:100',
            'id_level' => 'required|exists:level,id_level',
            'is_active' => 'boolean',
        ]);

<<<<<<< HEAD
        $validated['password'] = Hash::make($validated['password']);
=======
        $validated['password'] = md5($validated['password']);
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
        $validated['is_active'] = $request->has('is_active') ? true : false;

        User::create($validated);

        return redirect()->route('users.index')
<<<<<<< HEAD
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('level');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
=======
                       ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
        $levels = Level::all();
        return view('users.edit', compact('user', 'levels'));
    }

    /**
<<<<<<< HEAD
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('user', 'username')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
=======
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|max:100',
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
            'email' => 'nullable|email|max:100',
            'id_level' => 'required|exists:level,id_level',
            'is_active' => 'boolean',
        ]);

<<<<<<< HEAD
        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
=======
        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = md5($request->password);
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $user->update($validated);

        return redirect()->route('users.index')
<<<<<<< HEAD
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id_user === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('users.index')
            ->with('success', "User berhasil {$status}.");
=======
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
>>>>>>> ae5d0ab0a4757f5681c21bcfc152c870054960fd
    }
}
