@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa - CertiLearn')

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-8">

    <!-- 1. WELCOME BANNER (Gaya Modern dengan Ilustrasi 3D) -->
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 rounded-3xl p-8 lg:p-10 text-white shadow-2xl overflow-hidden border border-slate-800/80">
        
        <!-- Efek Cahaya / Glow Dekoratif di Latar Belakang -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
            
            <!-- Sisi Kiri: Teks Sambutan & Badge -->
            <div class="space-y-4 max-w-2xl">
                <!-- Badge Workspace -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-white/10 backdrop-blur-xl border border-white/15 rounded-full text-xs font-semibold tracking-wide text-blue-200 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ ucfirst($user->role) }} Workspace</span>
                    <span class="text-white/40">|</span>
                    <span class="text-amber-300 font-bold">Active</span>
                </div>

                <!-- Judul Utama -->
                <h1 class="text-3xl sm:text-4xl lg:text-[2.5rem] font-black tracking-tight leading-tight text-white">
                    Selamat Datang Kembali, <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-cyan-300 bg-clip-text text-transparent">
                        {{ $user->name }}!
                    </span> 
                    <span class="inline-block animate-bounce">👋</span>
                </h1>

                <!-- Deskripsi -->
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-xl font-normal">
                    Pantau perkembangan proyek PjBL Anda, selesaikan tugas tepat waktu, dan raih sertifikat kompetensi terbaik tahun ini.
                </p>
            </div>

            <!-- Sisi Kanan: Tombol Aksi & Kartu Motivasi Mini -->
            <div class="flex flex-col sm:flex-row lg:flex-col items-stretch sm:items-center lg:items-end gap-4 shrink-0 w-full lg:w-auto">

                <!-- Badge Motivasi / Info Kecil -->
                <div class="flex items-center gap-3 bg-white/5 backdrop-blur-xl px-4 py-3 rounded-2xl border border-white/10 shadow-lg w-full sm:w-auto">
                    <div class="w-10 h-10 rounded-xl bg-amber-400/20 border border-amber-400/30 text-amber-300 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-bullseye text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide">Capai Target</h4>
                        <p class="text-[11px] text-slate-400">Pertahankan performa belajarmu!</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- Elemen Visual Tambahan: Garis Aksen Bawah Bergradasi -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-transparent"></div>
    </div>

    <!-- 2. METRIC / STATS CARDS (4 Kolom dengan Mini Chart Tren) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
        <!-- Card 1: Total Proyek -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 flex flex-col justify-between space-y-4 relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-28 h-28 bg-blue-500/5 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-folder-open text-base"></i>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                    <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +2
                </span>
            </div>
            <div class="relative z-10 pb-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Proyek</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1 tracking-tight">{{ $totalProyek ?? 2 }}</h3>
            </div>
        </div>

        <!-- Card 2: Tugas Pending -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-amber-100 transition-all duration-300 flex flex-col justify-between space-y-4 relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-28 h-28 bg-amber-500/5 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-600 text-white flex items-center justify-center font-bold shadow-md shadow-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-clock-rotate-left text-base"></i>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-full">
                    Stable
                </span>
            </div>
            <div class="relative z-10 pb-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tugas Pending</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1 tracking-tight">{{ $tugasPending ?? 0 }}</h3>
            </div>
        </div>

        <!-- Card 3: Tugas Selesai -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all duration-300 flex flex-col justify-between space-y-4 relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-28 h-28 bg-emerald-500/5 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-circle-check text-base"></i>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                    <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +2
                </span>
            </div>
            <div class="relative z-10 pb-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tugas Selesai</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1 tracking-tight">{{ $tugasSelesai ?? 2 }}</h3>
            </div>
        </div>

        <!-- Card 4: Rata-rata Nilai -->
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-purple-100 transition-all duration-300 flex flex-col justify-between space-y-4 relative overflow-hidden">
            <div class="absolute -right-12 -top-12 w-28 h-28 bg-purple-500/5 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-purple-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-award text-base"></i>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-600 bg-purple-50 border border-purple-100 px-2.5 py-1 rounded-full">
                    <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +5.0
                </span>
            </div>
            <div class="relative z-10 pb-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata Nilai</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1 tracking-tight">{{ number_format($rataRataNilai ?? 100.0, 1) }}</h3>
            </div>
        </div>

    </div>

    <!-- 3. MAIN CONTENT GRID (2 Kolom Kiri & 1 Kolom Kanan) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI (Proyek Aktif & Progres Keseluruhan) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Proyek Aktif Saat Ini -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Proyek Aktif Saat Ini</h2>
                        <p class="text-xs text-slate-400">Proyek yang sedang berjalan dan membutuhkan perhatian Anda.</p>
                    </div>
                    <a href="" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">Lihat Semua →</a>
                </div>

                @if($proyekAktif ?? true)
                    <div class="p-5 bg-slate-50/70 rounded-3xl border border-slate-200/60 flex flex-col md:flex-row gap-6 items-center">
                        <!-- Thumbnail Proyek -->
                        <div class="w-full md:w-56 h-36 rounded-2xl overflow-hidden shrink-0 shadow-sm relative group">
                            <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80" alt="Project Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                        </div>

                        <!-- Detail Proyek -->
                        <div class="flex-1 space-y-4 w-full">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                                        {{ $proyekAktif->kategori ?? 'Wireframe UMKM' }}
                                    </span>
                                    <h3 class="text-xl font-black text-slate-800 mt-1.5">{{ $proyekAktif->judul ?? 'Wireframe UMKM' }}</h3>
                                    <p class="text-slate-500 text-xs mt-0.5 leading-relaxed">Perancangan wireframe untuk sistem informasi UMKM.</p>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[11px] font-bold whitespace-nowrap">
                                    ● Sedang Dikerjakan
                                </span>
                            </div>

                            <!-- Bar Progress -->
                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center text-xs font-bold text-slate-600">
                                    <span>Progres Keseluruhan</span>
                                    <span class="text-blue-600">{{ $progres ?? 60 }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $progres ?? 60 }}%"></div>
                                </div>
                            </div>

                            <!-- Footer Info & Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-t border-slate-200/60">
                                <div class="flex items-center gap-4 text-xs text-slate-400">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <span>Mulai: <strong class="text-slate-700">12 Sep 2026</strong></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-flag text-slate-400"></i>
                                        <span>Target: <strong class="text-slate-700">19 Sep 2026</strong></span>
                                    </div>
                                </div>

                                <a href="" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-500/20 transition">
                                    <span>Lanjutkan</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <p class="text-slate-400 text-xs">Belum ada proyek aktif saat ini.</p>
                        <a href="" class="mt-3 inline-block text-xs font-bold text-blue-600 hover:underline">+ Buat Proyek Baru</a>
                    </div>
                @endif
            </div>

            <!-- Progres Proyek Saya (Ringkasan Semua Proyek) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Progres Proyek Saya</h2>
                        <p class="text-xs text-slate-400">Ringkasan progres seluruh proyek yang Anda ikuti.</p>
                    </div>
                    <a href="" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">Lihat Semua →</a>
                </div>

                <div class="space-y-4">
                    <!-- Item Proyek 1 -->
                    <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60 flex flex-col sm:flex-row items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=200&q=80" class="w-16 h-16 rounded-xl object-cover shrink-0" alt="Thumbnail">
                        <div class="flex-1 w-full space-y-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800">Wireframe UMKM</h4>
                                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold">Sedang Dikerjakan</span>
                            </div>
                            <p class="text-xs text-slate-400">Perancangan wireframe untuk sistem informasi UMKM.</p>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-slate-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700">60%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Item Proyek 2 -->
                    <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60 flex flex-col sm:flex-row items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=200&q=80" class="w-16 h-16 rounded-xl object-cover shrink-0" alt="Thumbnail">
                        <div class="flex-1 w-full space-y-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800">Aplikasi Kasir</h4>
                                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold">Selesai</span>
                            </div>
                            <p class="text-xs text-slate-400">Pengembangan aplikasi kasir sederhana untuk UMKM.</p>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-slate-200 rounded-full h-2 overflow-hidden">
                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700">100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN (Tugas Mendatang & Sertifikat) -->
        <div class="space-y-8">
            
            <!-- Box Tugas Mendatang -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Tugas Mendatang</h2>
                        <p class="text-xs text-slate-400">Daftar deadline tugas terdekat Anda.</p>
                    </div>
                    <a href="" class="text-xs font-bold text-blue-600 hover:text-blue-800">Lihat Semua →</a>
                </div>

                <div class="space-y-3">
                    <!-- Task Item 1 -->
                    <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex items-center justify-between">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-file-lines text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Laporan Progress 2</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Proyek: Wireframe UMKM</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-[11px] font-bold text-slate-700 block"><i class="fa-regular fa-calendar text-[10px] mr-1"></i> 15 Sep 2026</span>
                            <span class="text-[10px] font-bold text-rose-500 bg-rose-50 px-2 py-0.5 rounded-md inline-block mt-1">3 hari lagi</span>
                        </div>
                    </div>

                    <!-- Task Item 2 -->
                    <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex items-center justify-between">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-file-pen text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Revisi Desain</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Proyek: Aplikasi Kasir</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-[11px] font-bold text-slate-700 block"><i class="fa-regular fa-calendar text-[10px] mr-1"></i> 18 Sep 2026</span>
                            <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md inline-block mt-1">6 hari lagi</span>
                        </div>
                    </div>

                    <!-- Task Item 3 -->
                    <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex items-center justify-between">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fa-solid fa-presentation-screen text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800">Presentasi Akhir</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Proyek: Wireframe UMKM</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-[11px] font-bold text-slate-700 block"><i class="fa-regular fa-calendar text-[10px] mr-1"></i> 19 Sep 2026</span>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md inline-block mt-1">7 hari lagi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box Sertifikat Ringkas (Compact) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Sertifikat</h3>
                        <p class="text-[11px] text-slate-400">Status kelulusan PjBL Anda.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-700">
                        Siap
                    </span>
                </div>

                <!-- Preview Mini Sertifikat Bergaya Klasik Mewah -->
                <div id="printable-certificate" class="relative bg-gradient-to-br from-amber-50/60 via-amber-100/30 to-amber-50/80 rounded-2xl p-5 border-2 border-dashed border-amber-300 text-center space-y-3 shadow-inner">
                    <div>
                        <span class="text-xs font-serif font-black text-slate-800 tracking-widest uppercase block">
                            SERTIFIKASI PJBL
                        </span>
                        <span class="text-[10px] font-mono text-slate-400 block mt-0.5">
                            No: 0884/PjBL/2026
                        </span>
                    </div>

                    <div class="py-1">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">DIBERIKAN KEPADA</p>
                        <p class="text-base font-black text-indigo-950 underline decoration-amber-400 decoration-2 underline-offset-4 mt-0.5">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-slate-600 pt-3 border-t border-amber-200/80">
                        <span>Nilai Akhir: <strong class="text-amber-600 font-extrabold">100.0</strong></span>
                        <span class="font-black text-emerald-600 tracking-wider">KOMPETEN</span>
                    </div>
                </div>

                <button onclick="window.print()" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-blue-500/25 transition active:scale-[0.98]">
                    <i class="fa-solid fa-print mr-2 text-sm"></i>
                    Cetak / Simpan PDF
                </button>
            </div>

        </div>

    </div>

</div>

<!-- SweetAlert Popup Trigger -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success') || session('login_success'))
        Swal.fire({
            title: "Selamat Datang Kembali!",
            text: "Senang melihatmu lagi, {{ $user->name }}!",
            icon: "success",
            showConfirmButton: true,
            confirmButtonText: "Lanjutkan",
            confirmButtonColor: "#2563eb",
            timer: 4000,
            timerProgressBar: true,
            background: '#ffffff',
            customClass: {
                title: 'font-black text-slate-800 text-xl',
                popup: 'rounded-3xl p-6 shadow-2xl',
                confirmButton: 'rounded-xl px-8 py-3 font-bold shadow-lg shadow-blue-500/20'
            }
        });
    @endif
</script>

<!-- CSS Khusus untuk Print / Cetak PDF -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-certificate, #printable-certificate * {
            visibility: visible;
        }
        #printable-certificate {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border-width: 4px !important;
        }
    }
</style>
@endsection