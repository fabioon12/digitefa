<?php

namespace App\Http\Controllers\Industri\Project\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function monitor($projectId)
    {
        $industriId = Auth::id();

        $project = Project::with([
            'members.user', 
            'tasks.assignedUser',
            'tasks.submissions.user',
            'mentors'
        ])
        ->whereHas('mentors', function ($q) use ($industriId) {
            $q->where('project_mentors.user_id', $industriId)
              ->where('project_mentors.status', 'approved'); 
        })
        ->findOrFail($projectId);


        $allTasks        = $project->tasks;
        $todoTasks       = $allTasks->where('status', 'todo');
        $inProgressTasks = $allTasks->where('status', 'in_progress');
        $completedTasks  = $allTasks->where('status', 'completed');


        $totalTasks      = $allTasks->count();
        $completedCount  = $completedTasks->count();
        $progressPercent = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0;


        return view('industri.project.show.monitor', compact(
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
        $industriId = Auth::id();

        $project = Project::whereHas('mentors', function ($q) use ($industriId) {
            $q->where('project_mentors.user_id', $industriId)
              ->where('project_mentors.status', 'approved');
        })->findOrFail($projectId);

        $task = ProjectTask::with(['submissions.user', 'assignedUser'])
            ->where('project_id', $project->id) 
            ->findOrFail($taskId);

        return view('industri.project.show.task_detail', compact('project', 'task'));
    }


    public function updateCatatan(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'catatan_guru'         => 'nullable|string', 
            'catatan_submission'   => 'nullable|array',  
            'catatan_submission.*' => 'nullable|string',
        ]);

        $currentUser = Auth::user(); 
        $userIdString = (string) $currentUser->id; // Cast ke string untuk kunci JSON yang konsisten

        // 1. Keamanan & Pembaruan Task Utama
        $projectTask = ProjectTask::where('project_id', $projectId)->findOrFail($taskId);
        $projectTask->update([
            'catatan_guru' => $request->catatan_guru, 
        ]);

        // 2. Simpan Catatan Per Submission
        if ($request->has('catatan_submission')) {
            foreach ($request->catatan_submission as $submissionId => $catatanBaru) {
                $submission = TaskModel::where('id', $submissionId)
                    ->where('task_id', $projectTask->id)
                    ->first();

                if ($submission) {
                    $existingNotes = $submission->catatan_guru;
                    
                    // Pastikan selalu dalam format array
                    if (is_string($existingNotes)) {
                        $existingNotes = json_decode($existingNotes, true) ?? [];
                    } elseif (!is_array($existingNotes)) {
                        $existingNotes = [];
                    }

                    if (!empty(trim($catatanBaru))) {
                        // Gunakan String ID agar konsisten dengan format JSON MySQL
                        $existingNotes[$userIdString] = [
                            'guru_id'    => $currentUser->id,
                            'nama_guru'  => $currentUser->name . ' (Industri)',
                            'catatan'    => $catatanBaru,
                            'updated_at' => now()->format('d M Y, H:i'),
                        ];
                    } else {
                        unset($existingNotes[$userIdString]);
                        unset($existingNotes[$currentUser->id]); // Hapus juga key integer jika ada legacy data
                    }

                    $submission->update([
                        'catatan_guru' => $existingNotes
                    ]);
                }
            }
        }

        return back()->with('success', 'Catatan pembimbing industri berhasil diperbarui!');
    }
}
