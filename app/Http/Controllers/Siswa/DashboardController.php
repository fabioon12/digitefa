<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectTask;
use App\Models\ProjectMentor;
use App\Models\ProjectEvaluation;
use App\Models\CertificateTemplate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Total Proyek
        $totalProyek = Project::where('user_id', $user->id)
            ->orWhereHas('members', fn($q) => $q->where('user_id', $user->id))
            ->count();

        // 2. Status Tugas
        $tugasSelesai = ProjectTask::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->count();

        $tugasPending = ProjectTask::where('assigned_to', $user->id)
            ->whereIn('status', ['todo', 'in_progress'])
            ->count();

        // 3. Rata-rata Nilai
        $rataRataNilai = ProjectEvaluation::where('student_id', $user->id)
            ->avg('nilai_akhir') ?? 0;

        // 4. Proyek Aktif Terbaru
        $proyekAktif = Project::where('user_id', $user->id)
            ->orWhereHas('members', fn($q) => $q->where('user_id', $user->id))
            ->with(['tasks', 'mentors']) // Memanggil relasi mentors
            ->latest()
            ->first();

        // 5. Kalkulasi Progres
        $progres = 0;
        if ($proyekAktif && $proyekAktif->tasks->isNotEmpty()) {
            $totalTask = $proyekAktif->tasks->count();
            $completedTask = $proyekAktif->tasks->where('status', 'completed')->count();
            $progres = round(($completedTask / $totalTask) * 100);
        }

        $certificateTemplate = \App\Models\CertificateTemplate::where('is_active', true)->first();

        $isEligibleForCertificate = $rataRataNilai >= 75 && $totalProyek > 0;
        $tugasMendatang = ProjectTask::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();


        return view('siswa.dashboard.index', compact(
            'user',
            'totalProyek',
            'tugasSelesai',
            'tugasPending',
            'rataRataNilai',
            'proyekAktif',
            'progres',
            'tugasMendatang',
            'certificateTemplate',         
            'isEligibleForCertificate'
        ));
    }
}
