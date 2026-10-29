@extends('admin.layouts.app')

@section('title', 'Pembelajaran PjBL - CertiLearn')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pembelajaran PjBL</h1>
            <p class="text-xs text-slate-400 mt-1">Kelola proyek berbasis masalah, sintaks PjBL, dan progres proyek siswa.</p>
        </div>

        <!-- Tombol Buat Proyek Baru -->
        <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium shadow-md shadow-blue-500/20 transition active:scale-95 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Buat Proyek PjBL</span>
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
                <input type="text" placeholder="Cari judul proyek, mata pelajaran, atau guru..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Dropdown Mata Pelajaran -->
                <div class="relative min-w-[140px]" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <span class="text-slate-400 font-normal">Mapel:</span>
                        <span>Semua</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>
                </div>

                <!-- Dropdown Phase / Sintaks -->
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
                        <th class="py-3.5 px-4 min-w-[200px]">
                            <div class="flex items-center gap-1.5 cursor-pointer hover:text-slate-600">
                                <span>Judul Proyek</span>
                                <i class="fa-solid fa-sort text-[10px]"></i>
                            </div>
                        </th>
                        <th class="py-3.5 px-4">Mata Pelajaran</th>
                        <th class="py-3.5 px-4">Kelas</th>
                        <th class="py-3.5 px-4">Guru Pembimbing</th>
                        <th class="py-3.5 px-4 min-w-[140px]">Progres Sintaks</th>
                        <th class="py-3.5 px-4">Deadline</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-normal">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">1</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">Pengembangan Web CertiLearn</div>
                            <div class="text-[11px] text-slate-400">Proyek Sistem Manajemen Sertifikat</div>
                        </td>
                        <td class="py-4 px-4 text-slate-700 font-medium">Pemrograman Web</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                XI RPL 1
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Budi Santoso</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="w-full">
                                <div class="flex justify-between items-center text-[10px] mb-1">
                                    <span class="font-medium text-blue-600">Pembuatan Jadwal</span>
                                    <span class="font-bold text-slate-700">50%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500">25 Mar 2026</td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition" title="Monitoring PjBL">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Edit Proyek">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition" title="Hapus Proyek">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">2</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">Desain UI/UX E-Commerce</div>
                            <div class="text-[11px] text-slate-400">Prototipe Aplikasi Belanja Lokal</div>
                        </td>
                        <td class="py-4 px-4 text-slate-700 font-medium">Desain Grafis</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                XI DKV 1
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Siti Aisyah</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="w-full">
                                <div class="flex justify-between items-center text-[10px] mb-1">
                                    <span class="font-medium text-emerald-600">Monev Proyek</span>
                                    <span class="font-bold text-slate-700">80%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500">10 Apr 2026</td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
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
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">Aplikasi Game Edukasi 2D</div>
                            <div class="text-[11px] text-slate-400">Media Pembelajaran Interaktif</div>
                        </td>
                        <td class="py-4 px-4 text-slate-700 font-medium">Pemrograman Gim</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                XI RPL 2
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Andi+Saputra&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Andi Saputra</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="w-full">
                                <div class="flex justify-between items-center text-[10px] mb-1">
                                    <span class="font-medium text-amber-600">Pertanyaan Mendasar</span>
                                    <span class="font-bold text-slate-700">15%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: 15%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500">18 Mei 2026</td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition">
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
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">Sistem Kasir Berbasis IoT</div>
                            <div class="text-[11px] text-slate-400">Perangkat Keras & Lunak Integrasi</div>
                        </td>
                        <td class="py-4 px-4 text-slate-700 font-medium">Sistem Tertanam</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                XII TKJ 1
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Rizky+Pratama&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Rizky Pratama</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="w-full">
                                <div class="flex justify-between items-center text-[10px] mb-1">
                                    <span class="font-medium text-emerald-600">Selesai / Evaluasi</span>
                                    <span class="font-bold text-slate-700">100%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500">01 Feb 2026</td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
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
                Menampilkan 1 - 4 dari 12 proyek
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