<?php

namespace App\Http\Controllers\Siswa\Kompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectEvaluation;
use App\Models\CertificateTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SertifikasiController extends Controller
{
    public function index()
    {

        $studentId = Auth::id(); 

        $evaluations = ProjectEvaluation::with(['project', 'items'])
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        return view('siswa.sertifikat.index', compact('evaluations'));
    }

    public function downloadPdf($evaluationId)
    {
        $studentId = Auth::id();


        $evaluation = ProjectEvaluation::with(['student', 'project', 'items'])
            ->where('student_id', $studentId)
            ->findOrFail($evaluationId);

        if (strtolower($evaluation->status_kompetensi) !== 'kompeten') {
            return redirect()->back()->with('error', 'Sertifikat belum dapat diunduh karena Anda belum dinyatakan Kompeten.');
        }

        // Ambil template aktif atau default
        $template = CertificateTemplate::where('is_active', true)->first() 
                    ?? CertificateTemplate::first();

        $nomorSurat = "CERT/PJBL/" . date('Y/m') . "/" . sprintf("%04d", $evaluation->id);

        // Stream PDF
        $pdf = Pdf::loadView('guru.kompetensi.pjbl.print_pdf', compact('evaluation', 'template', 'nomorSurat'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Sertifikat-' . str_replace(' ', '_', $evaluation->student->name) . '.pdf');
    }
}
