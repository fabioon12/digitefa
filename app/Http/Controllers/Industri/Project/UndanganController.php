<?php

namespace App\Http\Controllers\Industri\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectMentor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UndanganController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $search = $request->query('search');
        $industriId = Auth::id();

        // 1. Query Proyek khusus untuk Mentor Industri yang logged-in
        $readyProjectsQuery = Project::whereHas('mentors', function ($q) use ($industriId, $status) {
            $q->where('project_mentors.user_id', $industriId)
              ->where('project_mentors.tipe', 'industri'); // Filter khusus pembimbing industri

            if ($status && $status !== 'all') {
                $q->where('project_mentors.status', $status);
            }
        });

        // 2. Menghitung Statistik Per Status
        $totalProjects = Project::whereHas('mentors', function ($q) use ($industriId) {
            $q->where('project_mentors.user_id', $industriId)->where('project_mentors.tipe', 'industri');
        })->count();

        $pendingCount = Project::whereHas('mentors', function ($q) use ($industriId) {
            $q->where('project_mentors.user_id', $industriId)
              ->where('project_mentors.tipe', 'industri')
              ->where('project_mentors.status', 'pending');
        })->count();

        $approvedCount = Project::whereHas('mentors', function ($q) use ($industriId) {
            $q->where('project_mentors.user_id', $industriId)
              ->where('project_mentors.tipe', 'industri')
              ->where('project_mentors.status', 'approved');
        })->count();

        $rejectedCount = Project::whereHas('mentors', function ($q) use ($industriId) {
            $q->where('project_mentors.user_id', $industriId)
              ->where('project_mentors.tipe', 'industri')
              ->where('project_mentors.status', 'rejected');
        })->count();

        $invitationCount = $pendingCount;

        // 3. Get Data Undangan dengan Eager Loading
        $projects = (clone $readyProjectsQuery)
            ->with(['creator', 'members', 'mentors' => function ($q) use ($industriId) {
                $q->where('project_mentors.user_id', $industriId);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('projects.judul', 'like', "%{$search}%")
                      ->orWhere('projects.kategori', 'like', "%{$search}%")
                      ->orWhereHas('creator', fn($u) => $u->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest('projects.created_at')
            ->paginate(10)
            ->withQueryString();

        return view('industri.project.undangan.index', compact(
            'projects',
            'status',
            'totalProjects',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'invitationCount'
        ));
    }
    public function approve($id)
    {
        $project = Project::findOrFail($id);
        
        $project->mentors()->updateExistingPivot(Auth::id(), [
            'status' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Proposal proyek berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required|string'
        ]);

        $project = Project::findOrFail($id);

        $project->mentors()->updateExistingPivot(Auth::id(), [
            'status' => 'rejected',
            'catatan_revisi' => $request->catatan_revisi
        ]);

        return redirect()->back()->with('success', 'Catatan penolakan/revisi berhasil dikirim.');
    }
    public function show($id)
    {
        $project = Project::with(['creator', 'members', 'mentors'])->findOrFail($id);

        return view('industri.project.undangan.show', compact('project'));
    }

    public function download($id)
    {
        $project = Project::findOrFail($id);

        if (!$project->file_proposal || !\Storage::disk('public')->exists($project->file_proposal)) {
            return redirect()->back()->with('error', 'File proposal tidak ditemukan.');
        }

        return \Storage::disk('public')->download($project->file_proposal);
    }
}
