@extends('admin.layouts.app')

@section('title', 'Manajemen Kompetensi - CertiLearn')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Kompetensi</h1>
            <p class="text-xs text-slate-400 mt-1">Kelola Capaian Pembelajaran (CP), Elemen, dan Tujuan Pembelajaran (TP) tiap mata pelajaran.</p>
        </div>

        <!-- Tombol Tambah Kompetensi -->
        <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium shadow-md shadow-blue-500/20 transition active:scale-95 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Kompetensi</span>
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
                <input type="text" placeholder="Cari kode, deskripsi kompetensi, atau mapel..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Dropdown Kurikulum -->
                <div class="relative min-w-[130px]" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <span class="text-slate-400 font-normal">Kurikulum:</span>
                        <span>Merdeka</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>
                </div>

                <!-- Dropdown Tingkat / Fase -->
                <div class="relative min-w-[130px]" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <span class="text-slate-400 font-normal">Fase:</span>
                        <span>Fase F</span>
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
                        <th class="py-3.5 px-4">Kode</th>
                        <th class="py-3.5 px-4 min-w-[160px]">Mata Pelajaran</th>
                        <th class="py-3.5 px-4">Elemen / Unit</th>
                        <th class="py-3.5 px-4 min-w-[280px]">Capaian Pembelajaran (CP / TP)</th>
                        <th class="py-3.5 px-4 text-center">Tingkat / Fase</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-normal">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">1</td>
                        <td class="py-4 px-4 font-bold text-slate-800">CP-RPL-01</td>
                        <td class="py-4 px-4 font-semibold text-slate-700">Pemrograman Web & Perangkat Bergerak</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-blue-50 text-blue-600">
                                Front-End Dev
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-600 leading-relaxed">
                            Mampu merancang, mengimplementasikan, dan menguji antarmuka pengguna (UI/UX) berbasis web responsif menggunakan HTML, CSS, Tailwind, dan JavaScript.
                        </td>
                        <td class="py-4 px-4 text-center font-medium text-slate-700">
                            Fase F (Kelas XI)
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Edit Kompetensi">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition" title="Hapus Kompetensi">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">2</td>
                        <td class="py-4 px-4 font-bold text-slate-800">CP-RPL-02</td>
                        <td class="py-4 px-4 font-semibold text-slate-700">Pemrograman Web & Perangkat Bergerak</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-blue-50 text-blue-600">
                                Back-End Dev
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-600 leading-relaxed">
                            Memahami pemrosesan data sisi server, arsitektur basis data relasional, pembuatan API RESTful, serta pengintegrasian framework Laravel.
                        </td>
                        <td class="py-4 px-4 text-center font-medium text-slate-700">
                            Fase F (Kelas XI)
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
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
                        <td class="py-4 px-4 font-bold text-slate-800">CP-DKV-01</td>
                        <td class="py-4 px-4 font-semibold text-slate-700">Desain Grafis Komunikasi</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-purple-50 text-purple-600">
                                Layout & Vektor
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-600 leading-relaxed">
                            Menguasai prinsip tata letak (layout), tipografi, pewarnaan, dan pembuatan elemen grafis berbasis vektor untuk media publikasi cetak dan digital.
                        </td>
                        <td class="py-4 px-4 text-center font-medium text-slate-700">
                            Fase E (Kelas X)
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
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
                        <td class="py-4 px-4 font-bold text-slate-800">CP-TKJ-01</td>
                        <td class="py-4 px-4 font-semibold text-slate-700">Administrasi Infrastruktur Jaringan</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-amber-50 text-amber-600">
                                Routing & Switching
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-600 leading-relaxed">
                            Mampu melakukan konfigurasi Mikrotik/Cisco router, VLAN, routing statis & dinamis, serta manajemen bandwidth jaringan lokal.
                        </td>
                        <td class="py-4 px-4 text-center font-medium text-slate-700">
                            Fase F (Kelas XII)
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-slate-100 text-slate-500">
                                Nonaktif
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
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
                Menampilkan 1 - 4 dari 24 kompetensi
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