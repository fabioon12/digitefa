@extends('admin.layouts.app')

@section('title', 'Pembelajaran TEFA - CertiLearn')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pembelajaran Teaching Factory (TEFA)</h1>
            <p class="text-xs text-slate-400 mt-1">Kelola lini produksi, produk/jasa industri, pesanan mitra, dan keterlibatan siswa.</p>
        </div>

        <!-- Tombol Tambah Proyek/Produk TEFA -->
        <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium shadow-md shadow-blue-500/20 transition active:scale-95 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Layanan TEFA</span>
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
                <input type="text" placeholder="Cari nama produk/jasa, mitra DUDI, atau pembimbing..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Dropdown Kategori TEFA -->
                <div class="relative min-w-[140px]" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="w-full flex items-center justify-between gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <span class="text-slate-400 font-normal">Kategori:</span>
                        <span>Semua</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>
                </div>

                <!-- Dropdown Status Order/Produksi -->
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
                                <span>Produk / Layanan Jasa</span>
                                <i class="fa-solid fa-sort text-[10px]"></i>
                            </div>
                        </th>
                        <th class="py-3.5 px-4">Mitra DUDI</th>
                        <th class="py-3.5 px-4">Konsentrasi Keahlian</th>
                        <th class="py-3.5 px-4">Instruktur / Guru</th>
                        <th class="py-3.5 px-4 text-center">Siswa Terlibat</th>
                        <th class="py-3.5 px-4">Status Produksi</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-normal">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">1</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">Pembuatan Landing Page PT Teknologi Nusantara</div>
                            <div class="text-[11px] text-slate-400">Jasa Soft-Skill & Coding</div>
                        </td>
                        <td class="py-4 px-4 font-semibold text-slate-700">PT. Tekno Nusantara</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                RPL / PPLG
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Budi Santoso</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold text-slate-700">6</span> <span class="text-slate-400">Siswa</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-medium bg-amber-50 text-amber-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Dalam Proses
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition" title="Jurnal TEFA">
                                    <i class="fa-regular fa-clipboard text-xs"></i>
                                </a>
                                <a href="#" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Edit Data">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                                </a>
                                <button type="button" class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition" title="Hapus Data">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-4 px-5 font-medium text-slate-400">2</td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800">Cetak Branding Merchandise Festival</div>
                            <div class="text-[11px] text-slate-400">Produksi Banner & Kaos</div>
                        </td>
                        <td class="py-4 px-4 font-semibold text-slate-700">CV. Grafika Kreatif</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                Tek. Grafika
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Muhammad+Fikri&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Muhammad Fikri</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold text-slate-700">12</span> <span class="text-slate-400">Siswa</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Selesai / Lulus QC
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition">
                                    <i class="fa-regular fa-clipboard text-xs"></i>
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
                            <div class="font-bold text-slate-800">Desain Profil Perusahaan Video 3D</div>
                            <div class="text-[11px] text-slate-400">Animasi & Video Production</div>
                        </td>
                        <td class="py-4 px-4 font-semibold text-slate-700">Studio Lima Visual</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                DKV / MM
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Siti Aisyah</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold text-slate-700">8</span> <span class="text-slate-400">Siswa</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-medium bg-purple-50 text-purple-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                Quality Control
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition">
                                    <i class="fa-regular fa-clipboard text-xs"></i>
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
                            <div class="font-bold text-slate-800">Pemasangan Jaringan & Server Wifi</div>
                            <div class="text-[11px] text-slate-400">Instalasi & Maintenance</div>
                        </td>
                        <td class="py-4 px-4 font-semibold text-slate-700">Dinas Pendidikan Kab.</td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-blue-50 text-blue-600">
                                TKJ
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Rizky+Pratama&background=EBF4FF&color=1E40AF" class="w-7 h-7 rounded-full object-cover">
                                <span class="font-medium text-slate-800">Rizky Pratama</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold text-slate-700">5</span> <span class="text-slate-400">Siswa</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-medium bg-slate-100 text-slate-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Persiapan
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-emerald-600 hover:bg-emerald-50 border border-emerald-200 rounded-lg transition">
                                    <i class="fa-regular fa-clipboard text-xs"></i>
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
                Menampilkan 1 - 4 dari 8 proyek TEFA
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