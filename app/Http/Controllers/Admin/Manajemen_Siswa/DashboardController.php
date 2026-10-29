<?php

namespace App\Http\Controllers\Admin\Manajemen_Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        // 1. Pencarian Teks (Name, NISN, Email, Major, Offering)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('major', 'like', "%{$search}%")
                ->orWhere('offering', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('major')) {
            $query->where('major', $request->major);
        }

        if ($request->filled('offering')) {
            $query->where('offering', $request->offering);
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.manajemen_siswa.dashboard.index', compact('siswas'));
    }
    public function create()
    {
        return view('admin.manajemen_siswa.dashboard.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'username'             => 'required|string|max:255|unique:users,username',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|string|min:8|confirmed',
            'nisn'                 => 'nullable|string|max:50',
            'class'                => 'nullable|in:X,XI,XII',
            'major'                => 'nullable|string|max:255',
            'offering'             => 'nullable|in:A,B,C,D,E,F',
            'gender'               => 'nullable|in:L,P',
            'status'               => 'required|in:approved,pending,rejected',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'must_change_password' => 'nullable|boolean',
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
            'role'                 => 'siswa',
            'nisn'                 => $validated['nisn'] ?? null,
            'class'                => $validated['class'] ?? null,
            'major'                => $validated['major'] ?? null,
            'offering'             => $validated['offering'] ?? null,
            'gender'               => $validated['gender'] ?? null,
            'status'               => $validated['status'],
            'image'                => $imagePath,
            'must_change_password' => $request->has('must_change_password') ? 1 : 0,
        ]);

        return redirect()->route('admin.manajemen-siswa.dashboard')
            ->with('success', 'Akun siswa berhasil dibuat.');
    }
    public function edit($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        return view('admin.manajemen_siswa.dashboard.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'username'             => 'required|string|max:255|unique:users,username,' . $siswa->id,
            'email'                => 'required|email|unique:users,email,' . $siswa->id,
            'password'             => 'nullable|string|min:8|confirmed',
            'nisn'                 => 'nullable|string|max:50',
            'class'                => 'nullable|string|max:255',
            'major'                => 'nullable|string|max:255',
            'offering'             => 'nullable|string|max:255',
            'gender'               => 'nullable|in:L,P',
            'status'               => 'required|in:approved,pending,rejected',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'must_change_password' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($siswa->image && Storage::disk('public')->exists($siswa->image)) {
                Storage::disk('public')->delete($siswa->image);
            }
            $validated['image'] = $request->file('image')->store('profile_photos', 'public');
        } else {
            unset($validated['image']);
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['must_change_password'] = $request->has('must_change_password') ? 1 : 0;

        $siswa->update($validated);

        return redirect()->route('admin.manajemen-siswa.dashboard')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        if ($siswa->image && Storage::disk('public')->exists($siswa->image)) {
            Storage::disk('public')->delete($siswa->image);
        }

        $siswa->delete();

        return redirect()->route('admin.manajemen-siswa.dashboard')
            ->with('success', 'Data siswa beserta foto profil berhasil dihapus.');
    }
    
}
