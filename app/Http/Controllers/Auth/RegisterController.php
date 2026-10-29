<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;
use App\Events\UserMendaftarEvent;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'in:siswa,guru,industri'],
            'gender' => ['required', 'in:L,P'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            
            // Field khusus Siswa
            'nisn' => ['required_if:role,siswa', 'nullable', 'string', 'unique:users,nisn'],
            'class' => ['required_if:role,siswa', 'nullable', 'string', 'max:50'],
            'major' => ['required_if:role,siswa', 'nullable', 'string', 'max:100'],
            'offering' => ['required_if:role,siswa', 'nullable', 'string', 'max:10'],
            
            // Field khusus Guru
            'nip' => ['required_if:role,guru', 'nullable', 'string', 'unique:users,nip'],
            'subject' => ['required_if:role,guru', 'nullable', 'string', 'max:255'],
            
            // Field khusus Industri
            'company_name' => ['required_if:role,industri', 'nullable', 'string', 'max:255'],
            'sector' => ['required_if:role,industri', 'nullable', 'string', 'max:255'],
            'position' => ['required_if:role,industri', 'nullable', 'string', 'max:255'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile-photos', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'image' => $imagePath,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'gender' => $request->gender,
            
            'nisn' => $request->role === 'siswa' ? $request->nisn : null,
            'class' => $request->role === 'siswa' ? $request->class : null,
            'major' => $request->role === 'siswa' ? $request->major : null,
            'offering' => $request->role === 'siswa' ? $request->offering : null,
            
            'nip' => $request->role === 'guru' ? $request->nip : null,
            'subject' => $request->role === 'guru' ? $request->subject : null,
            
            'company_name' => $request->role === 'industri' ? $request->company_name : null,
            'sector' => $request->role === 'industri' ? $request->sector : null,
            'position' => $request->role === 'industri' ? $request->position : null,
            
            'status' => 'pending',
        ]);

        broadcast(new UserMendaftarEvent($user));
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Akun Anda sedang menunggu verifikasi dari Admin.');
    }
}
