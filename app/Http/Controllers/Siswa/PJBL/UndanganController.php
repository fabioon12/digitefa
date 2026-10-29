<?php

namespace App\Http\Controllers\Siswa\PJBL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Auth;

class UndanganController extends Controller
{
    public function indexInvitation()
    {
        $userName = auth()->user()->name;

        $undanganMasuk = ProjectMember::with(['project.members'])
            ->where('nama_siswa', auth()->user()->name)
            ->where('is_leader', false)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('siswa.projek.undangan.index', [
            'undanganMasuk' => $undanganMasuk,
            'totalUndangan' => $undanganMasuk->count(),
        ]);
    }
    public function accept($id)
    {
        $user = Auth::user();

        $member = ProjectMember::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('nama_siswa', $user->name);
            })
            ->where('is_leader', 0)
            ->firstOrFail();

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

        $member = ProjectMember::where('id', $id)
            ->where('nama_siswa', $user->name)
            ->where('is_leader', 0)
            ->firstOrFail();

        $member->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Undangan proyek telah ditolak.');
    }
}
