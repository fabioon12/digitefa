<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tefa;
use App\Models\User;
use App\Models\TefaMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UndanganTefaController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $search = $request->query('search');
        $guruId = Auth::id();

        // 1. Base Query dengan penentuan spesifik tabel 'project_mentors.status'
        $readyProjectsQuery = Tefa::whereHas('mentors', function ($q) use ($guruId, $status) {
            $q->where('tefa_mentors.user_id', $guruId);
            if ($status && $status !== 'all') {
                // SPESIFIKAN TABEL: project_mentors.status
                $q->where('tefa_mentors.status', $status); 
            }
        });

        // 2. Menhitung Statistik (Gunakan nama tabel secara eksplisit)
        $totalProjects   = (clone $readyProjectsQuery)->count();
        
        $pendingCount    = Tefa::whereHas('mentors', function ($q) use ($guruId) {
            $q->where('tefa_mentors.user_id', $guruId)->where('tefa_mentors.status', 'pending');
        })->count();

        $approvedCount   = Tefa::whereHas('mentors', function ($q) use ($guruId) {
            $q->where('tefa_mentors.user_id', $guruId)->where('tefa_mentors.status', 'approved');
        })->count();

        $rejectedCount   = Tefa::whereHas('mentors', function ($q) use ($guruId) {
            $q->where('tefa_mentors.user_id', $guruId)->where('tefa_mentors.status', 'rejected');
        })->count();

        $invitationCount = $pendingCount;

        // 3. Ambil Data Proyek beserta Filter Search
        $projects = (clone $readyProjectsQuery)
            ->with(['creator', 'members', 'mentors' => function ($q) use ($guruId) {
                $q->where('tefa_mentors.user_id', $guruId);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('tefa.judul', 'like', "%{$search}%")
                    ->orWhere('tefa.kategori', 'like', "%{$search}%")
                    ->orWhereHas('creator', fn($u) => $u->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $notifGuru = (clone $readyProjectsQuery)->latest()->take(5)->get();
        $totalNotifGuru = $pendingCount;

        return view('guru.tefa.undangan.index', compact(
            'projects', 
            'status', 
            'totalProjects', 
            'pendingCount', 
            'approvedCount', 
            'rejectedCount', 
            'invitationCount',
            'notifGuru',
            'totalNotifGuru'
        ));
    }   
    public function show($id)
    {
        $project = Tefa::with(['creator', 'members', 'mentorRecords.user'])->findOrFail($id);
        
        return view('guru.tefa.undangan.show', compact('project'));
    }


    public function approve(Request $request, $id)
    {
        $project = Tefa::findOrFail($id);
        $currentUserId = Auth::id();

        // 1. Validasi jika proyek sudah disetujui sepenuhnya sebelumnya
        if ($project->status === 'approved') {
            $msg = 'Proyek ini sudah disetujui sepenuhnya sebelumnya.';
            return $request->expectsJson()
                ? response()->json(['status' => 'error', 'message' => $msg], 400)
                : redirect()->back()->with('error', $msg);
        }

        DB::transaction(function () use ($project, $currentUserId) {
            // 2. Update status mentor yang sedang login di tabel pivot
            $project->mentors()->updateExistingPivot($currentUserId, [
                'status' => 'approved'
            ]);

            // 3. Cek apakah seluruh mentor dalam proyek ini sudah menyetujui (approved)
            // Ambil status pivot untuk semua mentor pada proyek ini
            $allMentorsApproved = !$project->mentors()
                ->wherePivot('status', '!=', 'approved')
                ->exists();

            // 4. Tentukan status utama proyek (HANYA 'approved' jika SEMUA mentor 'approved')
            $projectStatus = $allMentorsApproved ? 'approved' : 'pending';

            $project->update([
                'status'         => $projectStatus,
                'catatan_revisi' => $allMentorsApproved ? null : $project->catatan_revisi,
            ]);
        });

        // 5. Tentukan pesan respon
        $message = 'Persetujuan Anda telah disimpan. Menunggu pembimbing lainnya.';
        if ($project->fresh()->status === 'approved') {
            $message = 'Seluruh pembimbing telah menyetujui. Proposal proyek resmi disetujui!';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status'   => 'success',
                'message'  => $message,
                'redirect' => route('guru.tefa.undangan.index')
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required|string|min:5|max:1000',
        ], [
            'catatan_revisi.required' => 'Catatan revisi wajib diisi jika menolak proposal.',
            'catatan_revisi.min'      => 'Catatan revisi minimal berisi 5 karakter.',
            'catatan_revisi.max'      => 'Catatan revisi maksimal 1000 karakter.',
        ]);

        $project = Tefa::findOrFail($id);
        $currentUserId = Auth::id();

        DB::transaction(function () use ($project, $request, $currentUserId) {
            // 1. Update status mentor & simpan catatan revisi di tabel pivot
            $project->mentors()->updateExistingPivot($currentUserId, [
                'status'         => 'rejected',
                'catatan_revisi' => $request->catatan_revisi
            ]);

            // 2. Jika salah satu mentor menolak, status proyek utama langsung 'rejected'
            $project->update([
                'status'         => 'rejected',
                'catatan_revisi' => $request->catatan_revisi,
            ]);
        });

        $message = 'Proposal proyek telah ditolak dan catatan revisi dikirimkan ke siswa.';

        if ($request->expectsJson()) {
            return response()->json([
                'status'   => 'success',
                'message'  => $message,
                'redirect' => route('industri.project.undangan.index')
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function downloadProposal($id)
    {
        $project = Tefa::findOrFail($id);

        if (!Storage::disk('public')->exists($project->proposal_path)) {
            return back()->with('error', 'Berkas proposal PDF tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $project->proposal_path, 
            'Proposal_' . \Str::slug($project->judul) . '.pdf'
        );
    }
}
