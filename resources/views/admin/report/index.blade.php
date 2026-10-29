@extends('admin.layouts.app')

@section('title', 'Laporan Sertifikasi - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ format: 'excel' }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="#" class="hover:text-blue-600">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span>Laporan & Rekap</span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Laporan Asesmen & Sertifikasi</h1>
        </div>

        <!-- Action Export Buttons -->
        <div class="flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-emerald-500/20 transition active:scale-95">
                <i class="fa-solid fa-file-excel text-xs"></i>
                <span>Ekspor Excel</span>
            </button>
            <button type="button" class="inline-flex items-center gap-2 px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-red-500/20 transition active:scale-95">
                <i class="fa-solid fa-file-pdf text-xs"></i>
                <span>Cetak PDF</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form action="" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Filter Skema -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Skema Keahlian</label>
                <select name="scheme_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                    <option value="">Semua Skema</option>
                    <option value="1">Junior Web Developer</option>
                    <option value="2">Administrator Jaringan Muda</option>
                    <option value="3">Desainer Grafis Muda</option>
                </select>
            </div>

            <!-- Filter Status Asesmen -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Status Kelulusan</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                    <option value="">Semua Status</option>
                    <option value="kompeten">Kompeten (K)</option>
                    <option value="belum_kompeten">Belum Kompeten (BK)</option>
                    <option value="pending">Belum Diasesmen</option>
                </select>
            </div>

            <!-- Filter Rentang Tanggal -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="2026-01-01" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Sampai Tanggal</label>
                <div class="flex gap-2">
                    <input type="date" name="end_date" value="2026-08-06" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold">
                <i class="fa-solid fa-users text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium uppercase">Total Peserta</p>
                <h3 class="text-lg font-extrabold text-slate-800">142 Siswa</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                <i class="fa-solid fa-user-check text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium uppercase">Kompeten (K)</p>
                <h3 class="text-lg font-extrabold text-emerald-600">128 Siswa</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center font-bold">
                <i class="fa-solid fa-user-xmark text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium uppercase">Belum Kompeten</p>
                <h3 class="text-lg font-extrabold text-rose-600">14 Siswa</h3>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center font-bold">
                <i class="fa-solid fa-chart-line text-sm"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-medium uppercase">Tingkat Kelulusan</p>
                <h3 class="text-lg font-extrabold text-slate-800">90.1%</h3>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Rekapitulasi Hasil Asesmen</h2>
            <span class="text-[11px] text-slate-400">Menampilkan 1-5 dari 142 data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-[10px] border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">No. Sertifikat</th>
                        <th class="py-3 px-4">Siswa / Peserta</th>
                        <th class="py-3 px-4">Skema Kompetensi</th>
                        <th class="py-3 px-4">Asesor Penguji</th>
                        <th class="py-3 px-4">Tgl Asesmen</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-mono text-[11px] font-bold text-slate-800">CERT/2026/RPL/0089</td>
                        <td class="py-3 px-4">
                            <div class="font-bold text-slate-800">Ahmad Fauzi</div>
                            <div class="text-[10px] text-slate-400">NISN: 0054829102 • XII RPL 1</div>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">Junior Web Developer</td>
                        <td class="py-3 px-4">Budi Santoso, M.Kom</td>
                        <td class="py-3 px-4 text-slate-500">12 Feb 2026</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                Kompeten (K)
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-mono text-[11px] font-bold text-slate-800">CERT/2026/TKJ/0012</td>
                        <td class="py-3 px-4">
                            <div class="font-bold text-slate-800">Kevin Alamsyah</div>
                            <div class="text-[10px] text-slate-400">NISN: 0051293810 • XII TKJ 2</div>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">Administrator Jaringan Muda</td>
                        <td class="py-3 px-4">Siti Nurhaliza, S.ST</td>
                        <td class="py-3 px-4 text-slate-500">10 Feb 2026</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                Kompeten (K)
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-mono text-[11px] text-slate-400">-</td>
                        <td class="py-3 px-4">
                            <div class="font-bold text-slate-800">Rian Ardianto</div>
                            <div class="text-[10px] text-slate-400">NISN: 0058821903 • XII MM 1</div>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">Desainer Grafis Muda</td>
                        <td class="py-3 px-4">Andi Wijaya, S.Sn</td>
                        <td class="py-3 px-4 text-slate-500">08 Feb 2026</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                Belum Kompeten (BK)
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar Footer -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Menampilkan 3 dari 142 Data</span>
            <div class="flex gap-1">
                <button class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded-lg font-medium transition" disabled>Satu</button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded-lg font-medium shadow-xs">1</button>
                <button class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded-lg font-medium transition">2</button>
                <button class="px-3 py-1 bg-slate-100 hover:bg-slate-200 rounded-lg font-medium transition">28</button>
            </div>
        </div>
    </div>

</div>
@endsection