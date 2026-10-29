<?php

namespace App\Http\Controllers\Industri\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\TaskModel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $filterStatus = $request->query('status', 'berjalan'); 
        $userId = auth()->id();


        $query = Project::whereHas('mentors', function ($q) use ($userId) {
                            $q->where('project_mentors.user_id', $userId)
                            ->where('project_mentors.status', 'approved');
                        })

                        ->with(['creator', 'members.user', 'tasks', 'mentors']);

        // 2. Filter Status Tugas / Proyek
        if ($filterStatus === 'selesai') {
            $query->whereHas('tasks')
                ->whereDoesntHave('tasks', fn($q) => $q->where('status', '!=', 'completed'));
        } elseif ($filterStatus === 'kedaluwarsa') {
            $query->whereNotNull('tanggal_selesai')
                ->where('tanggal_selesai', '<', now()->format('Y-m-d'))
                ->whereHas('tasks', fn($q) => $q->where('status', '!=', 'completed'));
        } else {
            $query->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                ->orWhere('tanggal_selesai', '>=', now()->format('Y-m-d'));
            });
        }

        // 3. Pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $projects = $query->latest()->get();

        return view('industri.project.dashboard.index', compact('projects', 'search', 'filterStatus'));
    }
    /**
     * Menampilkan halaman monitor detail proyek untuk Industri.
     */
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

        return view('industri.pjbl.proyek.show.monitor', compact(
            'project',
            'todoTasks',
            'inProgressTasks',
            'completedTasks',
            'totalTasks',
            'completedCount',
            'progressPercent'
        ));
    }

    /**
     * Detail tugas/task proyek siswa.
     */
    public function showTask($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        
        $task = ProjectTask::with(['submissions.user', 'assignedUser'])
            ->where('project_id', $projectId) 
            ->findOrFail($taskId);

        return view('industri.pjbl.proyek.show.task_detail', compact('project', 'task'));
    }

    /**
     * Memberikan/memperbarui catatan dari Pembimbing Industri untuk siswa.
     */
    public function updateCatatanIndustri(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'catatan_industri'        => 'nullable|string', 
            'catatan_submission'   => 'nullable|array',  
            'catatan_submission.*' => 'nullable|string',
        ]);

        $projectTask = ProjectTask::findOrFail($taskId);
        $currentIndustri = auth()->user(); 

        // Update Catatan Umum Task dari Industri
        $projectTask->update([
            'catatan_industri' => $request->catatan_industri, 
        ]);

        // Update Catatan Per Submission Siswa dari Mentor Industri
        if ($request->has('catatan_submission')) {
            foreach ($request->catatan_submission as $submissionId => $catatanBaru) {
                $submission = TaskModel::where('id', $submissionId)
                    ->where('task_id', $projectTask->id)
                    ->first();

                if ($submission) {
                    $existingNotes = $submission->catatan_industri ?? [];

                    if (!empty(trim($catatanBaru))) {
                        $existingNotes[$currentIndustri->id] = [
                            'industri_id' => $currentIndustri->id,
                            'nama_mentor' => $currentIndustri->name,
                            'catatan'     => $catatanBaru,
                            'updated_at'  => now()->format('d M Y, H:i'),
                        ];
                    } else {
                        unset($existingNotes[$currentIndustri->id]);
                    }

                    $submission->update([
                        'catatan_industri' => $existingNotes
                    ]);
                }
            }
        }

        return back()->with('success', 'Catatan pembimbing industri berhasil disimpan!');
    }
}
