<?php

namespace App\Http\Controllers\Siswa\PJBL\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectMember;
use App\Models\User;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index($projectId)
    {
        $project = Project::with([
            'members', 
            'tasks.assignedUser.projectMemberships',
            'tasks.latestSubmission.user.projectMemberships'
        ])->findOrFail($projectId);

        $todoTasks       = $project->tasks->where('status', 'todo');
        $inProgressTasks = $project->tasks->where('status', 'in_progress');
        $completedTasks  = $project->tasks->where('status', 'completed');    
        $totalTasks      = $project->tasks->count();
        $completedCount  = $completedTasks->count();
        $progressPercent = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0;

        return view('siswa.projek.tasks.dashboard.index', compact(
            'project',
            'todoTasks',
            'inProgressTasks',
            'completedTasks',
            'totalTasks',
            'completedCount',
            'progressPercent'
        ));
    }

    public function store(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi'   => 'required|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline'    => [
                'nullable',
                'date',
                'after_or_equal:' . $project->tanggal_mulai,   
                'before_or_equal:' . $project->tanggal_selesai, 
            ],
        ], [
            'deadline.after_or_equal'  => 'Tenggat tugas tidak boleh sebelum tanggal mulai proyek (' . \Carbon\Carbon::parse($project->tanggal_mulai)->format('d-m-Y') . ').',
            'deadline.before_or_equal' => 'Tenggat tugas tidak boleh melebihi tanggal selesai proyek (' . \Carbon\Carbon::parse($project->tanggal_selesai)->format('d-m-Y') . ').',
        ]);

        ProjectTask::create([
            'project_id'  => $projectId,
            'judul_tugas' => $request->judul_tugas,
            'deskripsi'   => $request->deskripsi,
            'assigned_to' => $request->assigned_to,
            'deadline'    => $request->deadline,
            'status'      => 'todo',
        ]);

        return back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $taskId)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,completed',
        ]);

        $task = ProjectTask::findOrFail($taskId);
        $task->update(['status' => $request->status]);

        if ($request->status === 'in_progress') {
            return redirect()->route('siswa.pjbl.tasks.show', [$task->project_id, $task->id])
                            ->with('success', 'Tugas dimulai! Silakan kerjakan di bawah ini.');
        }

        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    public function destroy($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId);

        $isMember = ProjectMember::where('user_id', auth()->id())->exists();
        if (!$isMember) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus tugas di proyek ini.');
        }

        $task = ProjectTask::where('project_id', $project->id)
            ->where('id', $taskId)
            ->firstOrFail();

        if ($task->relationLoaded('submissions') || method_exists($task, 'submissions')) {
            foreach ($task->submissions as $submission) {
                if ($submission->file_path && \Illuminate\Support\Facades\Storage::exists($submission->file_path)) {
                    \Illuminate\Support\Facades\Storage::delete($submission->file_path);
                }
            }
        }

        $task->delete();

        return back()->with('success', 'Tugas berhasil dihapus!');
    }
    public function show($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        $task = ProjectTask::with(['project', 'assignedUser'])->where('project_id', $projectId)->findOrFail($taskId);
        return view('siswa.projek.tasks.dashboard.show', compact('project', 'task'));
    }

    public function storeProgress(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'catatan'       => 'required|string',
            'link_lampiran' => 'nullable|url',
            'file_berkas'   => 'nullable|file|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:10240', 
        ]);

        $task = ProjectTask::findOrFail($taskId);

        $filePath = null;
        if ($request->hasFile('file_berkas')) {
            $filePath = $request->file('file_berkas')->store('task-progresses', 'public');
        }

        TaskModel::create([
            'task_id'       => $task->id,
            'user_id'       => Auth::id(),
            'catatan'       => $request->catatan,
            'link_lampiran' => $request->link_lampiran,
            'file_berkas'   => $filePath,
        ]);

        if ($task->status === 'todo') {
            $task->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Progres lembar kerja berhasil ditambahkan!');
    }
    public function destroyProgress($projectId, $taskId, $progressId)
    {
        $progress = TaskModel::where('task_id', $taskId)->findOrFail($progressId);

        if ($progress->file_berkas && Storage::disk('public')->exists($progress->file_berkas)) {
            Storage::disk('public')->delete($progress->file_berkas);
        }

        $progress->delete();

        return redirect()->back()->with('success', 'Progres berhasil dihapus.');
    }
}
