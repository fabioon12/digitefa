<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index()
    {
        return view('guru.profil.index');
    }
    public function update(Request $request)
    {
        $guru = Auth::user();

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($guru->id)],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($guru->id)],
            'nip'       => ['nullable', 'string', 'max:50'],
            'subject'   => ['nullable', 'string', 'max:255'],
            'gender'    => ['nullable', 'in:L,P'],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
            'image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($guru->image && Storage::disk('public')->exists($guru->image)) {
                Storage::disk('public')->delete($guru->image);
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

        $guru->update($validated);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
