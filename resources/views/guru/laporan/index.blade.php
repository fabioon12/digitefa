@extends('guru.layouts.app')

@section('title', 'Laporan & Rekapitulasi - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'rekap-kompetensi', periode: '2025/2026-ganjil' }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="/Guru/Dashboard" class="hover:text-blue-600">Portal Guru</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span>Laporan & Analitik</span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Laporan Rekapitulasi TEFA, PjBL & Sertifikasi</h1>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-emerald-500/20 transition active:scale-95">
                <i class="fa-solid fa-file-excel text-xs"></i>
                <span>Export Excel</span>
            </button>
            <button type="button" class="inline-flex items-center gap-2 px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-rose-500/20 transition active:scale-95">
                <i class="fa-solid fa-file-pdf text-xs"></i>
                <span>Cetak PDF</span>
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Laporan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tingkat Kelulusan (K)</p>
                <h3 class="text-lg font-extrabold text-emerald-600 mt-0.5">94.8%</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">124 dari 131 Siswa</p>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Proyek PjBL Tuntas</p>
                <h3 class="text-lg font-extrabold text-blue-600 mt-0.5">38 Proyek</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Rata-rata Skor: 89.2</p>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Nilai Produksi TEFA</p>
                <h3 class="text-lg font-extrabold text-purple-600 mt-0.5">18 Work Order</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">QC Pass Rate: 96.5%</p>
            </div>
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-industry"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Sertifikat Terbit</p>
                <h3 class="text-lg font-extrabold text-amber-600 mt-0.5">124 Lembar</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Terverifikasi Publik</p>
            </div>
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-certificate"></i>
            </div>
        </div>
    </div>

    <!-- Navigation Bar & Options -->
    <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl text-xs font-medium overflow-x-auto">
            <button @click="activeTab = 'rekap-kompetensi'" 
                    :class="activeTab === 'rekap-kompetensi' ? 'bg-white text-slate-800 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-3.5 py-1.5 rounded-lg transition whitespace-nowrap">
                <i class="fa-solid fa-graduation-cap text-[11px] mr-1.5"></i> Rekap Kompetensi Siswa
            </button>
            <button @click="activeTab = 'laporan-tefa'" 
                    :class="activeTab === 'laporan-tefa' ? 'bg-white text-slate-800 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-3.5 py-1.5 rounded-lg transition whitespace-nowrap">
                <i class="fa-solid fa-boxes-stacked text-[11px] mr-1.5"></i> Evaluasi TEFA & DUDI
            </button>
            <button @click="activeTab = 'laporan-pjbl'" 
                    :class="activeTab === 'laporan-pjbl' ? 'bg-white text-slate-800 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-3.5 py-1.5 rounded-lg transition whitespace-nowrap">
                <i class="fa-solid fa-list-check text-[11px] mr-1.5"></i> Capaian Project PjBL
            </button>
        </div>

        <div class="flex items-center gap-2">
            <select x-model="periode" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-blue-600 transition">
                <option value="2025/2026-ganjil">TA 2025/2026 (Ganjil)</option>
                <option value="2024/2025-genap">TA 2024/2025 (Genap)</option>
            </select>
        </div>
    </div>

    <!-- TAB 1: Rekapitulasi Kelayakan Kompetensi Siswa -->
    <div x-show="activeTab === 'rekap-kompetensi'" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Rekapitulasi Penilaian Kelayakan Sertifikasi</h2>
                <p class="text-[10px] text-slate-400">Gabungan Nilai Proyek PjBL, Hasil QC TEFA, dan Rekomendasi Akhir Assessor</p>
            </div>
            <span class="text-[10px] font-semibold text-slate-500 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">
                Total Data: 131 Siswa
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Siswa / NISN</th>
                        <th class="py-3 px-4">Kelas / Keahlian</th>
                        <th class="py-3 px-4 text-center">Rata-Rata PjBL</th>
                        <th class="py-3 px-4 text-center">Skor QC TEFA</th>
                        <th class="py-3 px-4 text-center">Nilai Akhir</th>
                        <th class="py-3 px-4">Keputusan Final</th>
                        <th class="py-3 px-4">No. Sertifikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-400">01</td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">Ahmad Rizky Pratama</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054892011</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">XII RPL 1</div>
                            <div class="text-[9px] text-slate-400">Software Engineering</div>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">88.5</td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">92.0</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="font-bold text-emerald-600">90.25</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-check text-[8px]"></i> Kompeten (K)
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-[10px] text-slate-600 font-bold">
                            CERT/2026/RPL/0081
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-400">02</td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">Siti Nurhaliza</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054892044</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">XII RPL 1</div>
                            <div class="text-[9px] text-slate-400">Software Engineering</div>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">94.0</td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">95.0</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="font-bold text-emerald-600">94.50</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-check text-[8px]"></i> Kompeten (K)
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-[10px] text-slate-600 font-bold">
                            CERT/2026/RPL/0082
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-400">03</td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">Budi Santoso</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054892102</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">XII DKV 1</div>
                            <div class="text-[9px] text-slate-400">Graphic Design</div>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">68.0</td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">60.0</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="font-bold text-rose-600">64.00</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                <i class="fa-solid fa-xmark text-[8px]"></i> Belum Kompeten (BK)
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-400 italic text-[10px]">
                            Belum Diterbitkan
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB 2: Evaluasi TEFA & DUDI -->
    <div x-show="activeTab === 'laporan-tefa'" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-4" x-cloak>
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Laporan Kinerja Unit Produksi TEFA & Partner DUDI</h2>
            <p class="text-[10px] text-slate-400">Evaluasi tingkat kepuasan mitra industri dan tingkat kelolosan Quality Control (QC)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-800 text-xs">PT Solusi Digital Indonesia</span>
                    <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded">Software House</span>
                </div>
                <div class="text-[11px] text-slate-600 space-y-1">
                    <p>• Total Order: <strong class="text-slate-800">4 Project</strong></p>
                    <p>• Rate QC Pass: <strong class="text-emerald-600">100%</strong></p>
                    <p>• Testimoni DUDI: <em class="text-slate-500">"Hasil pengerjaan aplikasi POS sesuai dengan spesifikasi industri."</em></p>
                </div>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-800 text-xs">CV Rasa Utama</span>
                    <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded">Percetakan & Kemasan</span>
                </div>
                <div class="text-[11px] text-slate-600 space-y-1">
                    <p>• Total Order: <strong class="text-slate-800">8 Work Order</strong></p>
                    <p>• Rate QC Pass: <strong class="text-emerald-600">92.5%</strong></p>
                    <p>• Testimoni DUDI: <em class="text-slate-500">"Waktu cetak cepat, koordinasi tim siswa sangat profesional."</em></p>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: Capaian Project PjBL -->
    <div x-show="activeTab === 'laporan-pjbl'" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-4" x-cloak>
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Laporan Capaian Pembelajaran Berbasis Proyek (PjBL)</h2>
            <p class="text-[10px] text-slate-400">Ringkasan penyelesaian modul dan penilaian portofolio kelompok siswa</p>
        </div>

        <div class="space-y-3 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between">
                <div>
                    <span class="font-bold text-slate-800">Proyek Web E-Commerce Produk Lokal</span>
                    <p class="text-[10px] text-slate-400">XII RPL 1 • 8 Kelompok</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-bold rounded-lg text-[10px]">
                    100% Tuntas
                </span>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between">
                <div>
                    <span class="font-bold text-slate-800">Desain Identitas Visual Brand UMKM</span>
                    <p class="text-[10px] text-slate-400">XII DKV 1 • 6 Kelompok</p>
                </div>
                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 font-bold rounded-lg text-[10px]">
                    85% Tuntas
                </span>
            </div>
        </div>
    </div>

</div>
@endsection