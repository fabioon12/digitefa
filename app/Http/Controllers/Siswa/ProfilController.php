<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('siswa.profil.index');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'gender' => ['required', 'in:L,P'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password' => ['nullable', 'confirmed', Password::defaults()],

            // Validasi terikat dengan role asli dari Database
            'nisn' => [$user->role === 'siswa' ? 'required' : 'nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'class' => [$user->role === 'siswa' ? 'required' : 'nullable', 'string', 'max:50'],
            'major' => [$user->role === 'siswa' ? 'required' : 'nullable', 'string', 'max:100'],

            'nip' => [$user->role === 'guru' ? 'required' : 'nullable', 'string', Rule::unique('users')->ignore($user->id)],

            'company_name' => [$user->role === 'industri' ? 'required' : 'nullable', 'string', 'max:255'],
            'sector' => [$user->role === 'industri' ? 'required' : 'nullable', 'string', 'max:255'],
            'position' => [$user->role === 'industri' ? 'required' : 'nullable', 'string', 'max:255'],
        ]);

        // Upload Gambar Baru & Hapus Gambar Lama
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('profile-photos', 'public');
        }

        // Update Field Umum
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->gender = $request->gender;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update Field Khusus Berdasarkan Role Asli Pengguna
        if ($user->role === 'siswa') {
            $user->nisn = $request->nisn;
            $user->class = $request->class;
            $user->major = $request->major;
        } elseif ($user->role === 'guru') {
            $user->nip = $request->nip;
        } elseif ($user->role === 'industri') {
            $user->company_name = $request->company_name;
            $user->sector = $request->sector;
            $user->position = $request->position;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
