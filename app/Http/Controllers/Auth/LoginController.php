<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    protected function redirectByUserRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil. Selamat datang, Admin!');
        } elseif ($user->role === 'guru') {
            return redirect()->route('guru.dashboard')->with('success', 'Login berhasil. Selamat datang, Guru!');
        } elseif ($user->role === 'industri') {
            return redirect()->route('industri.dashboard')->with('success', 'Login berhasil. Selamat datang, Industri!');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard')->with('success', 'Login berhasil. Selamat datang, Siswa!');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role pengguna tidak valid.');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
            'role'     => ['required', 'string'],
        ], [
            'login.required'    => 'Username, Email, NISN, atau NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        
        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        
        if ($loginType === 'username') {
            if ($credentials['role'] === 'siswa') {
                $loginType = is_numeric($credentials['login']) ? 'nisn' : 'username';
            } elseif ($credentials['role'] === 'guru') {
                $loginType = is_numeric($credentials['login']) ? 'nip' : 'username';
            }
        }

        $user = User::where($loginType, $credentials['login'])
                    ->where('role', $credentials['role'])
                    ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            
            if ($user->status === 'pending') {
                return back()->withErrors([
                    'login' => 'Akun Anda masih menunggu verifikasi dari Admin. Silakan tunggu konfirmasi.',
                ])->onlyInput('login', 'role');
            }

            if ($user && $user->status === 'rejected') {
                return back()->withErrors([
                    'login' => 'Akun Anda telah ditolak. Alasan: ' . $user->rejection_reason,
                ])->onlyInput('login', 'role');
            }

            Auth::login($user);
            $request->session()->regenerate();

            return $this->redirectByUserRole($user);
        }

        return back()->withErrors([
            'login' => 'Inputan  yang Anda masukkan tidak cocok atau role tidak sesuai.',
        ])->onlyInput('login', 'role');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
