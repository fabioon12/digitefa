@extends('admin.layouts.app')

@section('title', 'Manajemen Sertifikasi - CertiLearn')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Sertifikasi</h1>
            <p class="text-xs text-slate-400 mt-1">Kelola terbitan sertifikat kompetensi, verifikasi nomor sertifikat, dan kelulusan siswa.</p>
        </div>

        <!-- Tombol Terbit Sertifikat Baru -->
        <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium shadow-md shadow-blue-500/20 transition active:scale-95 self-start sm:self-auto">
            <i class="fa-solid fa-award text-xs"></i>
            <span>Terbit Sertifikat</span>
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="p-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            
            <!-- Search Input -->
            <div class="relative flex-1 max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" placeholder="Cari No. Sertifikat, nama siswa, NISN, atau skema..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Dropdown Skema / Jenis Sertifikasi -->
                <div class="relative min-w-[140px]" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <span class="text-slate-400 font-normal">Jenis:</span>
                        <span>Semua</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>
                </div>

                <!-- Dropdown Status Sertifikat -->
                <div class="relative min-w-[140px]" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <span class="text-slate-400 font-normal">Status:</span>
                        <span>Semua</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>
                </div>

                <!-- Tombol Filter -->
                <button type="button" class="flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-100 transition shadow-sm">
                    <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                    <span>Filter</span>
                </button>
            </div>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-slate-100 bg-slate-50/50 text-[11px] font-semibold text-slate-400">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-4 min-w-[170px]">No. Sertifikat</th>
                        <th class="py-3.5 px-4 min-w-[180px]">
                            <div class="flex items-center gap-1.5 cursor-pointer hover:text-slate-600">
                                <span>Penerima (Siswa)</span>
                                <i class="fa-solid fa-sort text-[10px]"></i>
                            </div>
                        </th>
                        <th class="py-3.5 px-4">Jenis Sertifikasi</th>
                        <th class="py-3.5 px-4">Skema Sertifikasi</th>
                        <th class="py-3.5 px-4">Asesor / Penguji</th>
                        <th class="py-3.5 px-4">Tgl Terbit</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-normal">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">1</td>
                        <td class="py-4 px-4 font-mono font-bold text-blue-600">CERT/2026/RPL/0089</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2.5">
                                <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=EBF4FF&color=1E40AF" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-slate-800">Ahmad Fauzi</div>
                                    <div class="text-[10px] text-slate-400">NISN: 0054829102 • XI RPL 1</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Pembelajaran PjBL</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Junior Web Developer</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-600">
                                BNSP / LSP-P1
                            </span>
                        </td>
                        <td class="py-4 px-4 font-medium text-slate-700">Budi Santoso, M.Kom</td>
                        <td class="py-4 px-4 text-slate-500">12 Feb 2026</td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                <i class="fa-solid fa-circle-check text-[9px]"></i>
                                Kompeten
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Cetak / Download PDF">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-lg transition" title="Verifikasi QR">
                                    <i class="fa-solid fa-qrcode text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition" title="Revoke / Hapus">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">2</td>
                        <td class="py-4 px-4 font-mono font-bold text-blue-600">CERT/2026/DKV/0042</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2.5">
                                <img src="https://ui-avatars.com/api/?name=Dina+Larasati&background=EBF4FF&color=1E40AF" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-slate-800">Dina Larasati</div>
                                    <div class="text-[10px] text-slate-400">NISN: 0061938201 • XI DKV 2</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Pembelajaran PjBL</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Desainer Grafis Muda</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-50 text-purple-600">
                                Industri (TEFA)
                            </span>
                        </td>
                        <td class="py-4 px-4 font-medium text-slate-700">Siti Aisyah, S.Ds</td>
                        <td class="py-4 px-4 text-slate-500">28 Jan 2026</td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                <i class="fa-solid fa-circle-check text-[9px]"></i>
                                Kompeten
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-lg transition">
                                    <i class="fa-solid fa-qrcode text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">3</td>
                        <td class="py-4 px-4 font-mono font-bold text-slate-400">DRAFT-TKJ-2026-11</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2.5">
                                <img src="https://ui-avatars.com/api/?name=Kevin+Alamsyah&background=EBF4FF&color=1E40AF" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-slate-800">Kevin Alamsyah</div>
                                    <div class="text-[10px] text-slate-400">NISN: 0058291039 • XII TKJ 1</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Pembelajaran PjBL</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Administrator Jaringan Muda</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-600">
                                Mikrotik MTCNA
                            </span>
                        </td>
                        <td class="py-4 px-4 font-medium text-slate-700">Rizky Pratama, S.Kom</td>
                        <td class="py-4 px-4 text-slate-400">-</td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-medium bg-amber-50 text-amber-600">
                                <i class="fa-solid fa-clock text-[9px]"></i>
                                Menunggu Asesmen
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition" title="Input Nilai / Asesmen">
                                    <i class="fa-solid fa-square-check text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Edit Draft">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">4</td>
                        <td class="py-4 px-4 font-mono font-bold text-red-600">CERT/2025/RPL/0012</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2.5">
                                <img src="https://ui-avatars.com/api/?name=Siti+Nurbaya&background=EBF4FF&color=1E40AF" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-slate-800">Siti Nurbaya</div>
                                    <div class="text-[10px] text-slate-400">NISN: 0049201928 • XII RPL 2</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Pembelajaran PjBL</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700">Junior Mobile Programmer</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-600">
                                BNSP / LSP-P1
                            </span>
                        </td>
                        <td class="py-4 px-4 font-medium text-slate-700">Andi Saputra, M.T</td>
                        <td class="py-4 px-4 text-slate-500">10 Nov 2025</td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-medium bg-red-50 text-red-600">
                                <i class="fa-solid fa-ban text-[9px]"></i>
                                Dicabut / Revoked
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:bg-slate-50 border border-slate-200 rounded-lg transition">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="p-5 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100 text-xs text-slate-500">
            <div>
                Menampilkan 1 - 4 dari 56 sertifikat terbit
            </div>

            <div class="flex items-center gap-3">
                <!-- Pagination Buttons -->
                <div class="flex items-center gap-1">
                    <button type="button" disabled class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded-lg text-slate-300 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </button>
                    <button type="button" class="w-8 h-8 flex items-center justify-center border border-blue-600 bg-blue-50 text-blue-600 font-bold rounded-lg">
                        1
                    </button>
                    <button type="button" class="w-8 h-8 flex items-center justify-center border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg transition">
                        2
                    </button>
                    <button type="button" class="w-8 h-8 flex items-center justify-center border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg transition">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Per Page Select -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center gap-2 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 transition">
                        <span>10 / halaman</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection