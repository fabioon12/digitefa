@extends('guru.layouts.app')

@section('title', 'Penentuan Kompetensi - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ filterStatus: 'all', search: '' }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="/Guru/Dashboard" class="hover:text-blue-600">Portal Guru</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span>Asesmen & Lisensi</span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Penentuan Kompetensi Siswa</h1>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-emerald-500/20 transition active:scale-95">
                <i class="fa-solid fa-file-export text-xs"></i>
                <span>Export Berita Acara</span>
            </button>
        </div>
    </div>

    <!-- Ringkasan Status Kompetensi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Perlu Penilaian</p>
                <h3 class="text-lg font-extrabold text-amber-600 mt-0.5">18 Siswa</h3>
            </div>
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-user-clock"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Direkomendasikan (K)</p>
                <h3 class="text-lg font-extrabold text-emerald-600 mt-0.5">124 Siswa</h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Belum Kompeten (BK)</p>
                <h3 class="text-lg font-extrabold text-rose-600 mt-0.5">5 Siswa</h3>
            </div>
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Siap Terbit Sertifikat</p>
                <h3 class="text-lg font-extrabold text-blue-600 mt-0.5">124 Berkas</h3>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-certificate"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Filter Bar -->
    <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <div class="relative min-w-[220px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" x-model="search" placeholder="Cari nama atau NISN..." class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-600 transition">
            </div>

            <select class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-600 transition">
                <option value="all">Semua Kelas</option>
                <option value="XII-RPL-1">XII RPL 1</option>
                <option value="XII-RPL-2">XII RPL 2</option>
                <option value="XII-DKV-1">XII DKV 1</option>
            </select>

            <select x-model="filterStatus" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-600 transition">
                <option value="all">Semua Status Status</option>
                <option value="pending">Perlu Review (18)</option>
                <option value="kompeten">Kompeten (K)</option>
                <option value="belum">Belum Kompeten (BK)</option>
            </select>
        </div>

        <div class="text-[11px] text-slate-400 font-semibold">
            Menampilkan <span class="text-slate-800">147</span> Siswa Total
        </div>
    </div>

    <!-- Tabel Evaluasi & Penentuan Kompetensi -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Matriks Kelayakan Kompetensi Siswa</h2>
            <span class="text-[10px] text-slate-400">Akumulasi Nilai Praktik PjBL & Standar QC TEFA</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">Siswa / NISN</th>
                        <th class="py-3 px-4">Kelas & Konsentrasi</th>
                        <th class="py-3 px-4">Nilai PjBL</th>
                        <th class="py-3 px-4">Skor QC TEFA</th>
                        <th class="py-3 px-4">Status Kompetensi</th>
                        <th class="py-3 px-4 text-right">Keputusan Assessor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Row 1: Pending Action -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">Ahmad Rizky Pratama</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054892011</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">XII RPL 1</div>
                            <div class="text-[9px] text-slate-400">Rekayasa Perangkat Lunak</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-emerald-600">88.5</span>
                            <div class="text-[9px] text-slate-400">Selesai 3 Project</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-emerald-600">92.0</span>
                            <div class="text-[9px] text-purple-600 font-medium">QC Pass (POS Cafe)</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <i class="fa-solid fa-hourglass-half text-[8px]"></i> Menunggu Keputusan
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[10px] font-semibold transition shadow-xs">
                                    Tetapkan (K)
                                </button>
                                <button type="button" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-[10px] font-semibold transition">
                                    (BK)
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2: Approved (Kompeten) -->
                    <tr class="hover:bg-slate-50/50 transition bg-slate-50/30">
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">Siti Nurhaliza</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054892044</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">XII RPL 1</div>
                            <div class="text-[9px] text-slate-400">Rekayasa Perangkat Lunak</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-emerald-600">94.0</span>
                            <div class="text-[9px] text-slate-400">Selesai 4 Project</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-emerald-600">95.0</span>
                            <div class="text-[9px] text-purple-600 font-medium">QC Pass (ERP System)</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-check text-[8px]"></i> Kompeten (K)
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[10px] font-semibold transition">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Keputusan
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3: Belum Kompeten -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">Budi Santoso</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054892102</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">XII DKV 1</div>
                            <div class="text-[9px] text-slate-400">Desain Komunikasi Visual</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-amber-600">68.0</span>
                            <div class="text-[9px] text-slate-400">Selesai 1 Project</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-rose-600">60.0</span>
                            <div class="text-[9px] text-rose-600 font-medium">QC Defect (Cetak)</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                <i class="fa-solid fa-xmark text-[8px]"></i> Belum Kompeten (BK)
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[10px] font-semibold transition">
                                <i class="fa-solid fa-rotate-right mr-1"></i> Jadwalkan Remedial
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection