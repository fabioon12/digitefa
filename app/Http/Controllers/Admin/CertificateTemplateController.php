<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificateTemplate;
use App\Models\TemplateIndicator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $templates = CertificateTemplate::withCount('indicators')
            ->latest()
            ->paginate(10);

        return view('admin.template_sertifikat.index', compact('templates'));
    }

    /**
     * Tampilkan form untuk membuat template baru.
     */
    public function create()
    {
        return view('admin.template_sertifikat.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Hapus is_active dari validasi agar tidak bentrok dengan string "1")
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'nomor_surat_format' => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'background_image'   => 'nullable|image|mimes:jpeg,png,jpg|max:10048',
            'indicators'         => 'required|array|min:1',
            'indicators.*'       => 'required|string|max:255',
        ], [
            'title.required'        => 'Judul template sertifikat wajib diisi.',
            'indicators.required'   => 'Setidaknya tambahkan 1 indikator capaian kompetensi.',
            'indicators.*.required' => 'Indikator tidak boleh kosong.',
        ]);

        $imagePath = null;

        DB::beginTransaction();
        try {
            // 2. Upload file gambar di dalam blok try
            if ($request->hasFile('background_image')) {
                $imagePath = $request->file('background_image')->store('certificate-backgrounds', 'public');
            }

            // 3. Simpan Template Sertifikat
            $template = CertificateTemplate::create([
                'title'              => $validated['title'],
                'nomor_surat_format' => $validated['nomor_surat_format'] ?? null,
                'description'        => $validated['description'] ?? null,
                'background_image'   => $imagePath,
                'is_active'          => $request->boolean('is_active'), // Gunakan helper boolean bawaan Laravel
            ]);

            // 4. Simpan Indikator
            foreach ($validated['indicators'] as $indikatorText) {
                if (!empty(trim($indikatorText))) {
                    TemplateIndicator::create([
                        'certificate_template_id' => $template->id,
                        'indikator'               => trim($indikatorText),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.certificate-templates.index')
                ->with('success', 'Template sertifikat berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file fisik jika transaksi database gagal
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan template: ' . $e->getMessage());
        }
    }
}
