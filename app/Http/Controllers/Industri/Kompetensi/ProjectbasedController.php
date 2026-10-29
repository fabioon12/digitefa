<?php

namespace App\Http\Controllers\Industri\Kompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PenilaianPjbl;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectEvaluation;
use App\Models\CertificateTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ProjectbasedController extends Controller
{
    public function index()
    {
        $industriId = Auth::id();

        
        $students = User::where('role', 'siswa')
            ->whereHas('projects.mentors', function ($query) use ($industriId) {
                $query->where('users.id', $industriId);
            })
            ->with(['projects' => function ($query) use ($industriId) {
                $query->whereHas('mentors', function ($q) use ($industriId) {
                    $q->where('users.id', $industriId);
                })
                ->with(['evaluations' => function ($evalQuery) {
                    $evalQuery->with('items');
                }])
                ->latest();
            }])
            ->get();

        // Hitung ringkasan status penilaian untuk Metric Stat Cards
        $totalAntrean       = $students->count();
        $totalKompeten      = 0;
        $totalBelumKompeten = 0;
        $totalBelumDinilai  = 0;

        foreach ($students as $student) {
            $project = $student->projects->first();
            $eval    = $project ? $project->evaluations->where('student_id', $student->id)->first() : null;

            if ($eval) {
                if ($eval->status_kompetensi === 'kompeten') {
                    $totalKompeten++;
                } elseif ($eval->status_kompetensi === 'belum_kompeten') {
                    $totalBelumKompeten++;
                } else {
                    $totalBelumDinilai++;
                }
            } else {
                $totalBelumDinilai++;
            }
        }

        return view('industri.kompetensi.pjbl.index', compact(
            'students',
            'totalAntrean',
            'totalBelumDinilai',
            'totalKompeten',
            'totalBelumKompeten'
        ));
    }

    /**
     * Menampilkan form penilaian kompetensi siswa oleh Industri.
     */
    public function create(Request $request, $projectId, $studentId)
    {
        $industriId = Auth::id();

        $project = Project::with(['tasks'])
            ->where('id', $projectId)
            ->whereHas('mentors', function ($q) use ($industriId) {
                $q->where('users.id', $industriId);
            })
            ->firstOrFail();

        $student = User::where('id', $studentId)
            ->where('role', 'siswa')
            ->firstOrFail();

        $evaluation = ProjectEvaluation::with('items')
            ->where('project_id', $projectId)
            ->where('student_id', $studentId)
            ->where('evaluator_id', $industriId)
            ->first();

        $allTasks        = $project->tasks;
        $totalTasks      = $allTasks->count();
        $completedCount  = $allTasks->where('status', 'completed')->count();
        $progressPercent = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0;

        $textColor = $progressPercent == 100 ? 'text-emerald-600' : 'text-amber-600';

        return view('industri.kompetensi.pjbl.create', compact(
            'project',
            'student',
            'evaluation',
            'totalTasks',
            'completedCount',
            'progressPercent',
            'textColor'
        ));
    }

    /**
     * Menyimpan atau memperbarui penilaian kompetensi oleh Industri.
     */
    public function store(Request $request, $projectId, $studentId)
    {
        $industriId = Auth::id();

        // Validasi Request
        $validated = $request->validate([
            'statusKompetensi'       => 'required|in:kompeten,belum_kompeten',
            'nilaiAkhir'             => 'required|numeric|min:0|max:100',
            'catatanGuru'            => 'nullable|string', // Dapat diisi catatan dari pihak industri
            'capaianList'            => 'required|array|min:1',
            'capaianList.*.teks'     => 'required|string',
            'capaianList.*.achieved' => 'required|boolean',
        ], [
            'capaianList.required' => 'Atur setidaknya 1 item indikator capaian kompetensi.',
            'nilaiAkhir.required'  => 'Nilai akhir wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $evaluation = ProjectEvaluation::updateOrCreate(
                [
                    'project_id'   => $projectId,
                    'student_id'   => $studentId,
                    'evaluator_id' => $industriId,
                ],
                [
                    'status_kompetensi' => $validated['statusKompetensi'],
                    'nilai_akhir'       => $validated['nilaiAkhir'],
                    'catatan_guru'      => $validated['catatanGuru'] ?? null,
                ]
            );

            // Hapus indikator capaian lama sebelum menyisipkan yang baru
            $evaluation->items()->delete();

            $itemsData = [];
            foreach ($validated['capaianList'] as $item) {
                $itemsData[] = [
                    'project_evaluation_id' => $evaluation->id,
                    'indikator'             => $item['teks'],
                    'is_achieved'           => $item['achieved'],
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];
            }

            $evaluation->items()->insert($itemsData);

            DB::commit();

            return response()->json([
                'status'       => 'success',
                'message'      => 'Penilaian kompetensi industri berhasil disimpan!',
                'redirect_url' => route('industri.kompetensi.pjbl.index')
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan penilaian: ' . $e->getMessage()
            ], 500);
        }
    }
}
