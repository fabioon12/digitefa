<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminVerificationController extends Controller
{
    public function siswa(Request $request)
    {
        $query = User::where('role', 'siswa')->where('status', 'pending');

        // Pencarian Dinamis
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendingSiswa = $query->latest()->paginate(10);

        $totalPending = User::where('role', 'siswa')->where('status', 'pending')->count();
        $approvedThisMonth = User::where('role', 'siswa')
            ->where('status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();
        $totalRejected = User::where('role', 'siswa')->where('status', 'rejected')->count();

        return view('admin.manajemen_siswa.verifikasi_akun.index', compact(
            'pendingSiswa', 
            'totalPending', 
            'approvedThisMonth', 
            'totalRejected'
        ));
    }

    public function guru(Request $request)
    {
        $query = User::where('role', 'guru')->where('status', 'pending');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendingGuru = $query->latest()->paginate(10);

        $totalPending = User::where('role', 'guru')->where('status', 'pending')->count();
        $approvedThisMonth = User::where('role', 'guru')
            ->where('status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();
        $totalRejected = User::where('role', 'guru')->where('status', 'rejected')->count();

        return view('admin.manajemen_guru.verifikasi_akun.index', compact(
            'pendingGuru', 
            'totalPending', 
            'approvedThisMonth', 
            'totalRejected'
        ));
    }
    public function industri(Request $request)
    {
        $query = User::where('role', 'industri')->where('status', 'pending');

        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")          
                  ->orWhere('sector', 'like', "%{$search}%")        
                  ->orWhere('pic_name', 'like', "%{$search}%")      
                  ->orWhere('email', 'like', "%{$search}%")         
                  ->orWhere('phone', 'like', "%{$search}%");       
            });
        }

        
        $pendingIndustri = $query->latest()->paginate(10)->withQueryString();

        $totalPending = User::where('role', 'industri')->where('status', 'pending')->count();
        
        $approvedThisMonth = User::where('role', 'industri')
            ->where('status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();
            
        $totalRejected = User::where('role', 'industri')->where('status', 'rejected')->count();

        return view('admin.manajemen_industri.verifikasi_akun.index', compact(
            'pendingIndustri', 
            'totalPending', 
            'approvedThisMonth', 
            'totalRejected'
        ));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved', 'email_verified_at' => now(),]);

        return redirect()->back()->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);
        $reason = $request->input('rejection_reason') ?? 'Akun Anda belum memenuhi syarat verifikasi.';
        $user = User::findOrFail($id);
        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return redirect()->back()->with('success', "Pendaftaran {$user->name} ditolak.");
    }
}
