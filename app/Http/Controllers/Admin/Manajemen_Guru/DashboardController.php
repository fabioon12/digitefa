<?php

namespace App\Http\Controllers\Admin\Manajemen_Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'guru');

        // Filter Pencarian Text (termasuk mata pelajaran)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('subject', 'like', "%{$search}%"); // Pencarian berdasarkan mata pelajaran
            });
        }

        // Filter Dropdown Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Specific Dropdown / Input Mata Pelajaran
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        $gurus = $query->latest()->paginate(10)->withQueryString();

        return view('admin.manajemen_guru.dashboard.index', compact('gurus'));
    }
    public function create()
    {
        return view('admin.manajemen_guru.dashboard.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|max:255|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'nip'                   => 'nullable|string|max:50',
            'subject'               => 'nullable|string|max:255',
            'gender'                => 'nullable|in:L,P',
            'status'                => 'required|in:approved,pending,rejected',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'must_change_password'  => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_photos', 'public');
        }

        User::create([
            'name'                 => $validated['name'],
            'username'             => $validated['username'],
            'email'                => $validated['email'],
            'password'             => Hash::make($validated['password']),
            'role'                 => 'guru',
            'nip'                  => $validated['nip'] ?? null,
            'subject'              => $validated['subject'] ?? null,
            'gender'               => $validated['gender'] ?? null,
            'status'               => $validated['status'],
            'image'                => $imagePath,
            'must_change_password' => $request->has('must_change_password') ? 1 : 0,
        ]);

        return redirect()->route('admin.manajemen-guru.dashboard')
            ->with('success', 'Akun guru berhasil dibuat.');
    }
    public function edit($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        return view('admin.manajemen_guru.dashboard.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|max:255|unique:users,username,' . $guru->id,
            'email'                 => 'required|email|unique:users,email,' . $guru->id,
            'password'              => 'nullable|string|min:8|confirmed',
            'nip'                   => 'nullable|string|max:50',
            'subject'               => 'nullable|string|max:255', // Validasi Mata Pelajaran
            'gender'                => 'nullable|in:L,P',
            'status'                => 'required|in:approved,pending,rejected',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'must_change_password'  => 'nullable|boolean',
        ]);

        // Olah Foto Profil jika ada upload baru
        if ($request->hasFile('image')) {
            if ($guru->image && Storage::disk('public')->exists($guru->image)) {
                Storage::disk('public')->delete($guru->image);
            }
            $validated['image'] = $request->file('image')->store('profile_photos', 'public');
        } else {
            unset($validated['image']);
        }

        // Olah Password (hanya diupdate jika diisi)
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['must_change_password'] = $request->has('must_change_password') ? 1 : 0;

        // Menyarankan default value null jika input subject tidak diisi
        $validated['subject'] = $request->input('subject');

        // Update seluruh data ter-validasi (termasuk 'subject') ke database
        $guru->update($validated);

        return redirect()->route('admin.manajemen-guru.dashboard')
            ->with('success', 'Data guru berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        if ($guru->image && Storage::disk('public')->exists($guru->image)) {
            Storage::disk('public')->delete($guru->image);
        }

        $guru->delete();

        return redirect()->route('admin.manajemen-guru.dashboard')
            ->with('success', 'Data guru beserta foto profil berhasil dihapus.');
    }
}
