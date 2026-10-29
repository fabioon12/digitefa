<?php

namespace App\Http\Controllers\Guru;

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
public function index(Request $request)
    {
        $guruId = Auth::id();
        $periode = $request->get('periode', '2025/2026');

        // ------------------------------------------------------------------
        // 1. DATA METRIC CARDS
        // ------------------------------------------------------------------

        // Mengambil seluruh ID proyek yang dibimbing oleh guru ini (dari tabel project_mentors)
        $projectIdsBimbingan = ProjectMentor::where('user_id', $guruId)
            ->where('status', 'approved')
            ->pluck('project_id');

        // Card 1: Total Bimbingan Siswa (Siswa dalam proyek bimbingan guru)
        $totalSiswa = ProjectMember::whereIn('project_id', $projectIdsBimbingan)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        // Total Kelas unik dari siswa bimbingan (menggunakan kolom `class` di tabel users)
        $totalKelas = User::whereIn('id', function ($query) use ($projectIdsBimbingan) {
                $query->select('user_id')
                    ->from('project_members')
                    ->whereIn('project_id', $projectIdsBimbingan)
                    ->whereNotNull('user_id');
            })
            ->whereNotNull('class')
            ->distinct('class')
            ->count('class');

        // Card 2: Proyek PjBL Berjalan yang Dimentori
        $proyekBerjalanCount = Project::whereIn('id', $projectIdsBimbingan)
            ->where('status', 'approved')
            ->count();

        // Proyek On-Track (yang tanggal selesainya masih berjalan)
        $proyekOnTrack = Project::whereIn('id', $projectIdsBimbingan)
            ->where('status', 'approved')
            ->where('tanggal_selesai', '>=', now()->toDateString())
            ->count();

        // Proyek Mendekati Deadline (tanggal_selesai dalam 7 hari mendatang)
        $proyekDeadlineNear = Project::whereIn('id', $projectIdsBimbingan)
            ->where('status', 'approved')
            ->whereBetween('tanggal_selesai', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->count();

        // Card 3: Pesanan / Proyek Kategori TEFA
        $orderTefaCount = Project::whereIn('id', $projectIdsBimbingan)
            ->where('kategori', 'TEFA')
            ->count();

        $orderDalamProduksi = Project::whereIn('id', $projectIdsBimbingan)
            ->where('kategori', 'TEFA')
            ->where('status', 'approved')
            ->count();

        // Card 4: Perlu Penilaian Kompetensi
        // Mengambil ID siswa yang sudah pernah dievaluasi oleh guru ini (tabel project_evaluations)
        $evaluatedStudentIds = ProjectEvaluation::where('evaluator_id', $guruId)->pluck('student_id');

        // Siswa dalam proyek bimbingan yang BELUM dievaluasi
        $perluPenilaianCount = ProjectMember::whereIn('project_id', $projectIdsBimbingan)
            ->whereNotNull('user_id')
            ->whereNotIn('user_id', $evaluatedStudentIds)
            ->distinct('user_id')
            ->count('user_id');

        // ------------------------------------------------------------------
        // 2. DATA TABEL: AKTIVITAS PROYEK PJBL & TEFA
        // ------------------------------------------------------------------
        $aktivitasProyek = Project::with(['members.user', 'tasks'])
            ->whereIn('id', $projectIdsBimbingan)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($project) {
                // Menghitung progres dari tabel project_tasks (kolom status = 'completed')
                $totalTasks = $project->tasks->count();
                $completedTasks = $project->tasks->where('status', 'completed')->count();
                $progres = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;

                // Ambil data siswa/kelas dari anggota proyek
                $firstMember = $project->members->first();
                $namaKelas = ($firstMember && $firstMember->user) ? $firstMember->user->class : '-';
                $namaTim = $project->tipe === 'kelompok' ? 'Kelompok' : 'Individu';

                // Status pengerjaan
                if ($progres == 100) {
                    $statusTeks = 'QC Ready / Selesai';
                } elseif ($progres >= 50) {
                    $statusTeks = 'In Progress';
                } else {
                    $statusTeks = 'In Preparation';
                }

                return [
                    'id'             => $project->id,
                    'nama_proyek'    => $project->judul,
                    'keterangan'     => $project->deskripsi,
                    'kategori'       => strtoupper($project->kategori),
                    'shift_atau_tim' => $namaTim,
                    'kelas'          => $namaKelas,
                    'progres'        => $progres,
                    'status_teks'    => $statusTeks,
                    'is_ready_qc'    => $progres >= 100,
                ];
            });

        // ------------------------------------------------------------------
        // 3. ANTREAN LISENSI SERTIFIKAT (Berdasarkan Jurusan / Major)
        // ------------------------------------------------------------------
        // Mengambil jurusan (major) dari siswa yang berstatus 'kompeten' pada project_evaluations
        $antreanSertifikat = User::selectRaw('major as jurusan, count(*) as total_siswa')
            ->whereIn('id', function ($query) {
                $query->select('student_id')
                    ->from('project_evaluations')
                    ->where('status_kompetensi', 'kompeten');
            })
            ->whereNotNull('major')
            ->groupBy('major')
            ->get();

        $totalSertifikatReady = $antreanSertifikat->sum('total_siswa');

        // ------------------------------------------------------------------
        // 4. TIMELINE AGENDA PENGUJIAN TERDEKAT
        // ------------------------------------------------------------------
        // Mengambil agenda berdasarkan tanggal_selesai proyek yang didampingi
        $agendaPengujian = Project::whereIn('id', $projectIdsBimbingan)
            ->where('tanggal_selesai', '>=', now()->toDateString())
            ->orderBy('tanggal_selesai', 'asc')
            ->take(3)
            ->get()
            ->map(function ($project) {
                return (object)[
                    'nama_agenda' => 'Evaluasi Proyek: ' . $project->judul,
                    'tanggal'     => $project->tanggal_selesai,
                    'lokasi'      => 'Ruang Lab / TEFA (' . strtoupper($project->kategori) . ')',
                    'penguji'     => 'Tim Mentor Guru',
                ];
            });

        return view('guru.dashboard.index', compact(
            'periode',
            'totalSiswa',
            'totalKelas',
            'proyekBerjalanCount',
            'proyekOnTrack',
            'proyekDeadlineNear',
            'orderTefaCount',
            'orderDalamProduksi',
            'perluPenilaianCount',
            'aktivitasProyek',
            'antreanSertifikat',
            'totalSertifikatReady',
            'agendaPengujian'
        ));
    }
}
