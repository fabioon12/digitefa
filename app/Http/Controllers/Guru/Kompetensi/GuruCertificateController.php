<?php

namespace App\Http\Controllers\Guru\Kompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificateTemplate;
use App\Models\ProjectEvaluation;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruCertificateController extends Controller
{
    public function index(Request $request)
    {

        $evaluations = ProjectEvaluation::with(['student', 'project', 'items'])
            ->where('status_kompetensi', 'kompeten')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        $templates = CertificateTemplate::all();

        return view('guru.sertifikat.index', compact('evaluations', 'templates'));
    }

    /**
     * Generasi & Cetak PDF Sertifikat
     */
    public function generatePdf(Request $request, $evaluationId)
    {
        $evaluation = ProjectEvaluation::with(['student', 'project', 'items'])->findOrFail($evaluationId);

        // Ambil template berdasarkan query string (?template_id=X) atau default ke template pertama
        $templateId = $request->query('template_id');
        if ($templateId) {
            $template = CertificateTemplate::findOrFail($templateId);
        } else {
            $template = CertificateTemplate::first();
        }

        // Nomor Surat Otomatis
        $nomorSurat = "CERT/PJBL/" . date('Y/m') . "/" . sprintf("%04d", $evaluation->id);

        // Stream / Download PDF
        $pdf = Pdf::loadView('guru.kompetensi.pjbl.print_pdf', compact('evaluation', 'template', 'nomorSurat'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Sertifikat-' . str_replace(' ', '_', $evaluation->student->name) . '.pdf');
    }
}
