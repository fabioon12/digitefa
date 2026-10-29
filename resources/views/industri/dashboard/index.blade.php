@extends('industri.layouts.app')

@section('title', 'Dashboard Utama - Admin Industri')

@section('content')
<div class="space-y-8">

    <!-- 1. Header / Banner Selamat Datang (Modern Glassmorphism Style) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 p-8 text-white shadow-xl shadow-orange-500/10">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold text-white mb-3 border border-white/20">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span> Panel Admin Industri
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang Kembali! 👋</h1>
                <p class="text-orange-100 text-xs sm:text-sm mt-2 leading-relaxed">
                    Kelola dan pantau progres proyek Project Based Learning (PjBL) serta Teaching Factory (TeFa) siswa secara terintegrasi dan real-time.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <button class="px-5 py-2.5 bg-white text-orange-600 hover:bg-orange-50 font-bold text-xs rounded-2xl shadow-md transition-all duration-200 active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Buat Proyek Baru
                </button>
            </div>
        </div>
        <!-- Decorative Circle Shapes -->
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-black/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- 2. Ringkasan Kartu Statistik (Clean & Modern Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Card 1: Total Bimbingan Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Bimbingan Siswa</span>
                <h3 class="text-2xl font-black text-slate-800">147 Siswa</h3>
                <div class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                    <span>4 Kelas Aktif</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-user-group"></i>
            </div>
        </div>

        <!-- Card 2: Project PjBL Berjalan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Project PjBL Berjalan</span>
                <h3 class="text-2xl font-black text-blue-600">12 Proyek</h3>
                <div class="text-xs font-medium text-slate-400">
                    <span>8 On-Track</span>
                    <span class="mx-0.5">•</span>
                    <span>4 Mendekati Deadline</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
        </div>

        <!-- Card 3: Pesanan TeFa (DUDI) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Pesanan TeFa (DUDI)</span>
                <h3 class="text-2xl font-black text-amber-600">5 Order</h3>
                <div class="flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                    <i class="fa-solid fa-clock text-xs"></i>
                    <span>3 Dalam Proses Produksi</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-industry"></i>
            </div>
        </div>

        <!-- Card 4: Perlu Penilaian (K) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Perlu Penilaian (K)</span>
                <h3 class="text-2xl font-black text-rose-500">18 Siswa</h3>
                <div class="flex items-center gap-1.5 text-xs font-semibold text-rose-500">
                    <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                    <span>Butuh Review Segera</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-clipboard-question"></i>
            </div>
        </div>

    </div>

    <!-- 3. Akses Cepat & Ringkasan Status Proyek (Quick Actions & Metrics) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Akses Cepat (Quick Actions Grid) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-extrabold text-slate-800">Akses Pintar Admin</h2>
                    <span class="text-[11px] text-slate-400 font-semibold">Pintasan Fitur</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <a href="#" class="p-4 bg-slate-50 hover:bg-orange-50/50 border border-slate-100 hover:border-orange-200/60 rounded-2xl transition-all group flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center text-base mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-folder-plus"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-orange-600">PjBL Baru</span>
                    </a>
                    <a href="#" class="p-4 bg-slate-50 hover:bg-amber-50/50 border border-slate-100 hover:border-amber-200/60 rounded-2xl transition-all group flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-base mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-industry"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-amber-600">Modul TeFa</span>
                    </a>
                    <a href="#" class="p-4 bg-slate-50 hover:bg-blue-50/50 border border-slate-100 hover:border-blue-200/60 rounded-2xl transition-all group flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-base mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-blue-600">Undang Siswa</span>
                    </a>
                    <a href="#" class="p-4 bg-slate-50 hover:bg-emerald-50/50 border border-slate-100 hover:border-emerald-200/60 rounded-2xl transition-all group flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-base mb-2 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-600">Cetak Laporan</span>
                    </a>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between text-xs text-slate-400">
                <span>Butuh bantuan konfigurasi?</span>
                <a href="#" class="text-orange-600 font-bold hover:underline">Panduan Admin <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
            </div>
        </div>

        <!-- Progress Overview Chart / Bar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-800 mb-1">Status Portofolio</h2>
                <p class="text-xs text-slate-400 mb-4">Distribusi status pengerjaan proyek</p>
                
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600">Selesai / Disetujui</span>
                            <span class="text-emerald-600">75% (15 Proyek)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600">Dalam Pengerjaan</span>
                            <span class="text-amber-600">20% (4 Proyek)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600">Perlu Review Industry</span>
                            <span class="text-orange-600">5% (1 Proyek)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 5%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-50 text-[11px] text-slate-400 text-center">
                Diperbarui secara otomatis dari sistem pembelajaran
            </div>
        </div>

    </div>

    <!-- 4. Layout 2 Kolom: Tabel Proyek & Timeline Aktivitas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Tabel Progres Pengerjaan (Clean Table Minimalist) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            
            <!-- Filter & Header Tabel -->
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800">Progres Pengerjaan Proyek</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pantau secara berkala tingkat penyelesaian proyek oleh tim siswa.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari proyek..." class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 w-44 sm:w-52 transition">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Data Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-4 px-6">Nama Proyek</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Mitra / Sekolah</th>
                            <th class="py-4 px-6">Progres</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                        
                        <!-- Proyek 1: PjBL -->
                        <tr class="hover:bg-orange-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 block text-sm">Aplikasi Kasir Berbasis IoT</span>
                                <span class="text-[10px] text-slate-400">ID: PRJ-2026-001</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-[10px] font-bold bg-orange-100 text-orange-700 rounded-xl">PjBL</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-semibold">SMKN 1 Malang</td>
                            <td class="py-4 px-6 w-36">
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="font-bold text-slate-600">75%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80 rounded-xl">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Dev
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button class="w-8 h-8 inline-flex items-center justify-center text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-xl transition-all">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Proyek 2: TeFa -->
                        <tr class="hover:bg-orange-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 block text-sm">Sparepart Mesin CNC</span>
                                <span class="text-[10px] text-slate-400">ID: PRJ-2026-002</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-[10px] font-bold bg-amber-100 text-amber-800 rounded-xl">TeFa</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-semibold">SMK Tekno Utama</td>
                            <td class="py-4 px-6 w-36">
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="font-bold text-slate-600">40%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-2 rounded-full" style="width: 40%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold bg-orange-50 text-orange-700 border border-orange-200/80 rounded-xl">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Produksi
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button class="w-8 h-8 inline-flex items-center justify-center text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-xl transition-all">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Proyek 3: TeFa (Selesai) -->
                        <tr class="hover:bg-orange-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 block text-sm">Kemasan Produk UMKM</span>
                                <span class="text-[10px] text-slate-400">ID: PRJ-2026-003</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-[10px] font-bold bg-amber-100 text-amber-800 rounded-xl">TeFa</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-semibold">SMK BISA Grafika</td>
                            <td class="py-4 px-6 w-36">
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="font-bold text-slate-600">100%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80 rounded-xl">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button class="w-8 h-8 inline-flex items-center justify-center text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-xl transition-all">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
        </div>

        <!-- Timeline Aktivitas Terbaru (Recent Activity Feed) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-extrabold text-slate-800">Aktivitas Terkini</h2>
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-ping"></span>
                </div>

                <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-100">
                    
                    <!-- Item Aktivitas 1 -->
                    <div class="flex gap-3 relative">
                        <div class="w-7 h-7 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xs shrink-0 z-10 font-bold border-2 border-white">
                            <i class="fa-solid fa-upload text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">
                                <span class="font-bold text-orange-600">Budi Santoso</span> mengunggah laporan revisi IoT.
                            </p>
                            <span class="text-[10px] text-slate-400">10 menit yang lalu</span>
                        </div>
                    </div>

                    <!-- Item Aktivitas 2 -->
                    <div class="flex gap-3 relative">
                        <div class="w-7 h-7 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs shrink-0 z-10 font-bold border-2 border-white">
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">
                                Proyek <span class="font-bold text-slate-700">Desain Kemasan</span> telah disetujui industri.
                            </p>
                            <span class="text-[10px] text-slate-400">1 jam yang lalu</span>
                        </div>
                    </div>

                    <!-- Item Aktivitas 3 -->
                    <div class="flex gap-3 relative">
                        <div class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs shrink-0 z-10 font-bold border-2 border-white">
                            <i class="fa-solid fa-comment text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">
                                Catatan pembimbing ditambahkan pada modul TeFa.
                            </p>
                            <span class="text-[10px] text-slate-400">3 jam yang lalu</span>
                        </div>
                    </div>

                </div>
            </div>

            <a href="#" class="mt-6 block text-center text-xs font-bold text-orange-600 hover:text-orange-700 hover:underline py-2 bg-orange-50/50 rounded-xl transition">
                Lihat Semua Catatan Aktivitas
            </a>
        </div>

    </div>

</div>
@endsection