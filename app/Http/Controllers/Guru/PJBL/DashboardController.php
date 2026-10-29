<?php

namespace App\Http\Controllers\Guru\PJBL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectMember;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $guruId       = Auth::id();
        $filterKelas  = $request->query('kelas', 'all');
        $filterStatus = $request->query('status', 'berjalan'); 
        $search       = $request->query('search');

        // 1. FILTER: Hanya ambil proyek yang SUDAH DI-ACC oleh guru ini
        $query = Project::with(['creator', 'members.user', 'tasks', 'mentors'])
                        ->whereHas('mentors', function ($q) use ($guruId) {
                            $q->where('project_mentors.user_id', $guruId)
                            ->where('project_mentors.status', 'approved'); 
                        });

        if ($filterKelas !== 'all') {
            $query->where('kelas', $filterKelas);
        }


        if ($filterStatus === 'selesai') {
            $query->whereHas('tasks')
                ->whereDoesntHave('tasks', function ($q) {
                    $q->where('status', '!=', 'completed');
                });

        } elseif ($filterStatus === 'kedaluwarsa') {
            // Lewat tanggal selesai & ada task yang belum completed
            $query->whereNotNull('tanggal_selesai')
                ->where('tanggal_selesai', '<', now()->format('Y-m-d'))
                ->whereHas('tasks', function ($q) {
                    $q->where('status', '!=', 'completed');
                });

        } else {
            $query->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                ->orWhere('tanggal_selesai', '>=', now()->format('Y-m-d'));
            })->where(function ($q) {
                $q->doesntHave('tasks') 
                ->orWhereHas('tasks', function ($taskQuery) {
                    $taskQuery->where('status', '!=', 'completed');
                });
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $projects = $query->latest()->get();

        return view('guru.pjbl.proyek.index', compact('projects', 'filterKelas', 'filterStatus', 'search'));
    }
    public function create(){
        return view('guru.pjbl.proyek.create');
    }
    public function monitor($projectId)
    {
        $project = Project::with([
            'members.user', 
            'tasks.assignedUser',
            'tasks.submissions.user'
        ])->findOrFail($projectId);

        $allTasks        = $project->tasks;
        $todoTasks       = $allTasks->where('status', 'todo');
        $inProgressTasks = $allTasks->where('status', 'in_progress');
        $completedTasks  = $allTasks->where('status', 'completed');

        $totalTasks      = $allTasks->count();
        $completedCount  = $completedTasks->count();
        $progressPercent = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0;

        return view('guru.pjbl.proyek.show.monitor', compact(
            'project',
            'todoTasks',
            'inProgressTasks',
            'completedTasks',
            'totalTasks',
            'completedCount',
            'progressPercent'
        ));
    }

    public function showTask($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        
        $task = ProjectTask::with(['submissions.user', 'assignedUser'])
            ->where('project_id', $projectId) 
            ->findOrFail($taskId);

        return view('guru.pjbl.proyek.show.task_detail', compact('project', 'task'));
    }
    public function updateCatatanGuru(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'catatan_guru'         => 'nullable|string', 
            'catatan_submission'   => 'nullable|array',  
            'catatan_submission.*' => 'nullable|string',
        ]);

        $projectTask = ProjectTask::findOrFail($taskId);
        $currentGuru = auth()->user(); 

        // Update Catatan Umum Task
        $projectTask->update([
            'catatan_guru' => $request->catatan_guru, 
        ]);

        // Update Catatan Per Submission Siswa
        if ($request->has('catatan_submission')) {
            foreach ($request->catatan_submission as $submissionId => $catatanBaru) {
                $submission = TaskModel::where('id', $submissionId)
                    ->where('task_id', $projectTask->id)
                    ->first();

                if ($submission) {

                    $existingNotes = $submission->catatan_guru ?? [];

                    if (!empty(trim($catatanBaru))) {

                        $existingNotes[$currentGuru->id] = [
                            'guru_id'    => $currentGuru->id,
                            'nama_guru'  => $currentGuru->name,
                            'catatan'    => $catatanBaru,
                            'updated_at' => now()->format('d M Y, H:i'),
                        ];
                    } else {

                        unset($existingNotes[$currentGuru->id]);
                    }

                    $submission->update([
                        'catatan_guru' => $existingNotes
                    ]);
                }
            }
        }

        return back()->with('success', 'Catatan mentor berhasil disimpan!');
    }
}
