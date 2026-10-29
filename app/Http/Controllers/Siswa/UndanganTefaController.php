<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TefaMember;

class UndanganTefaController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $undanganMasuk = TefaMember::with(['tefa.members', 'tefa.mentors'])
            ->where('user_id', $userId)
            ->where('is_leader', false)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $totalUndangan = $undanganMasuk->count();

        return view('siswa.tefa.undangan.index', compact('undanganMasuk', 'totalUndangan'));
    }

    /**
     * Memproses respon undangan (Terima / Tolak) via AJAX.
     */
    public function accept($id)
    {
        $user = Auth::user();

        // Cari berdasarkan ID undangan saja, pastikan statusnya masih pending dan bukan leader
        $member = TefaMember::where('id', $id)
            ->where('is_leader', false)
            ->where('status', 'pending')
            ->first();

        // Jika data tidak ditemukan, berikan pesan error yang jelas (bukan error system)
        if (!$member) {
            return redirect()->back()->with('error', 'Undangan tidak ditemukan atau sudah diproses.');
        }

        // Update user_id (jika sebelumnya masih null) dan ubah status jadi accepted
        $member->update([
            'user_id' => $user->id, 
            'status'  => 'accepted'
        ]);

        return redirect()->back()->with('success', 'Berhasil bergabung dengan proyek!');
    }

    /**
     * Menolak Undangan Proyek
     */
    public function reject($id)
    {
        $user = Auth::user();

        // Cari berdasarkan ID undangan, pastikan milik user yang login, bukan leader, dan masih pending
        $member = TefaMember::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('nama_siswa', $user->name);
            })
            ->where('is_leader', false)
            ->where('status', 'pending')
            ->first(); // Menggunakan first() alih-alih firstOrFail() agar tidak crash

        // Jika data tidak ditemukan, kembalikan dengan pesan peringatan yang ramah
        if (!$member) {
            return redirect()->back()->with('error', 'Undangan tidak ditemukan atau sudah diproses.');
        }

        // Pastikan user_id juga terikat jika sebelumnya masih kosong
        $member->update([
            'user_id' => $user->id,
            'status'  => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Undangan proyek telah ditolak.');
    }
}
