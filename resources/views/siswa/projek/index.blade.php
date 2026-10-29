@extends('siswa.layouts.app')

@section('title', 'Proyek PjBL - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ 
    filterStatus: 'semua', 
    detailModal: false, 
    selectedProject: null 
}">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-md uppercase tracking-wider">
                    Project-Based Learning
                </span>
                <span class="text-xs text-slate-400 font-medium">• TA 2025/2026 Ganjil</span>
            </div>
            <h1 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight mt-1">Daftar Proyek PjBL Siswa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola tugas kelompok, pantau progres pencapaian, dan kumpulkan hasil karya industri Anda.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Metric Quick Glance -->
            <div class="flex items-center gap-2">
                <div class="px-3.5 py-2 bg-slate-50 border border-slate-100 rounded-xl text-center">
                    <span class="block text-[9px] font-bold text-slate-400 uppercase">Aktif</span>
                    <span class="text-sm font-extrabold text-blue-600">2 Proyek</span>
                </div>
                <div class="px-3.5 py-2 bg-slate-50 border border-slate-100 rounded-xl text-center">
                    <span class="block text-[9px] font-bold text-slate-400 uppercase">Selesai</span>
                    <span class="text-sm font-extrabold text-emerald-600">1 Proyek</span>
                </div>
            </div>

            <!-- Tombol Ajukan Proyek Baru -->
            <a href="" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-plus text-xs"></i> Ajukan Proyek Baru
            </a>
        </div>
    </div>

    <!-- Navigation & Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Filter Tabs -->
        <div class="flex items-center gap-1.5 bg-slate-200/60 p-1 rounded-xl w-fit">
            <button @click="filterStatus = 'semua'" 
                    :class="filterStatus === 'semua' ? 'bg-white text-slate-800 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700 font-semibold'" 
                    class="px-3.5 py-1.5 rounded-lg text-xs transition">
                Semua
            </button>
            <button @click="filterStatus = 'berjalan'" 
                    :class="filterStatus === 'berjalan' ? 'bg-white text-blue-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700 font-semibold'" 
                    class="px-3.5 py-1.5 rounded-lg text-xs transition">
                Sedang Berjalan
            </button>
            <button @click="filterStatus = 'review'" 
                    :class="filterStatus === 'review' ? 'bg-white text-amber-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700 font-semibold'" 
                    class="px-3.5 py-1.5 rounded-lg text-xs transition">
                Tahap Penilaian
            </button>
            <button @click="filterStatus = 'selesai'" 
                    :class="filterStatus === 'selesai' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-700 font-semibold'" 
                    class="px-3.5 py-1.5 rounded-lg text-xs transition">
                Selesai
            </button>
        </div>

        <!-- Search Bar -->
        <div class="relative w-full sm:w-64">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" placeholder="Cari nama proyek..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 text-slate-700 placeholder-slate-400 shadow-xs">
        </div>
    </div>

    <!-- Grid List Proyek -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card 1: Proyek POS Cafe (Sedang Berjalan) -->
        <div x-show="filterStatus === 'semua' || filterStatus === 'berjalan'" 
             class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden">
            
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 font-bold rounded-md text-[10px]">
                                Kelompok 2 (Frontend)
                            </span>
                            <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 font-bold rounded-md text-[10px]">
                                <i class="fa-regular fa-clock mr-1"></i> Sisa 12 Hari
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Sistem Kasir POS Cafe Suroboyo</h3>
                    </div>
                    <span class="w-3 h-3 rounded-full bg-blue-500 ring-4 ring-blue-100 shrink-0" title="Status: Berjalan"></span>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                    Pengembangan antarmuka transaksi kasir, cetak resi thermal, serta integrasi pemesanan via QRIS menggunakan Tailwind CSS dan Vue.js.
                </p>

                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-1">
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                        <span>Guru: <strong class="text-slate-700">Hendra, S.Kom</strong></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-slate-400"></i>
                        <span>Tugas: <strong class="text-slate-700">8/10 Selesai</strong></span>
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    <div class="flex justify-between text-[11px] font-bold">
                        <span class="text-slate-400 uppercase tracking-wider">Progres Pengerjaan</span>
                        <span class="text-blue-600">85%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 85%"></div>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                    <div class="flex items-center -space-x-2">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Rizky&background=2563eb&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Ahmad Rizky (Ketua)">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=10b981&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Budi Santoso">
                        <img src="https://ui-avatars.com/api/?name=Citra+Dewi&background=f59e0b&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Citra Dewi">
                        <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-100 text-slate-500 text-[10px] font-bold flex items-center justify-center">+1</div>
                    </div>
                    <span class="text-[10px] text-slate-400 font-semibold">Tenggat: 20 Agu 2026</span>
                </div>
            </div>

            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <i class="fa-brands fa-github text-sm"></i> Repository
                </a>
                <button @click="detailModal = true; selectedProject = 'POS Cafe'" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-xs">
                    Kelola Tugas <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </button>
            </div>
        </div>

        <!-- Card 2: E-Commerce Marketplace (Tahap Review) -->
        <div x-show="filterStatus === 'semua' || filterStatus === 'review'" 
             class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden">
            
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-purple-50 text-purple-700 font-bold rounded-md text-[10px]">
                                Kelompok 1 (Fullstack)
                            </span>
                            <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 font-bold rounded-md text-[10px]">
                                <i class="fa-solid fa-spinner fa-spin mr-1"></i> Dalam Evaluasi
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Aplikasi E-Commerce CraftLokal</h3>
                    </div>
                    <span class="w-3 h-3 rounded-full bg-amber-500 ring-4 ring-amber-100 shrink-0" title="Status: Penilaian"></span>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                    Platform lokapasar produk UMKM kriya dengan integrasi payment gateway Midtrans dan manajemen inventaris real-time.
                </p>

                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-1">
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                        <span>Guru: <strong class="text-slate-700">Maya Indah, S.T</strong></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-slate-400"></i>
                        <span>Tugas: <strong class="text-slate-700">12/12 Selesai</strong></span>
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    <div class="flex justify-between text-[11px] font-bold">
                        <span class="text-slate-400 uppercase tracking-wider">Progres Pengerjaan</span>
                        <span class="text-amber-600">100%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-amber-500 h-2 rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                    <div class="flex items-center -space-x-2">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Rizky&background=2563eb&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Ahmad Rizky">
                        <img src="https://ui-avatars.com/api/?name=Dian+Sastro&background=ec4899&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Dian Sastro">
                    </div>
                    <span class="text-[10px] text-slate-400 font-semibold">Dikumpulkan: 02 Agu 2026</span>
                </div>
            </div>

            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <a href="#" class="text-xs font-bold text-slate-600 hover:text-slate-800 flex items-center gap-1">
                    <i class="fa-solid fa-link text-xs"></i> Demo Staging
                </a>
                <button @click="detailModal = true; selectedProject = 'CraftLokal'" class="px-3.5 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition shadow-xs">
                    Lihat Penilaian <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                </button>
            </div>
        </div>

        <!-- Card 3: Presensi Sekolah IoT (Selesai) -->
        <div x-show="filterStatus === 'semua' || filterStatus === 'selesai'" 
             class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden">
            
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-md text-[10px]">
                                IoT & Mobile
                            </span>
                            <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 font-bold rounded-md text-[10px]">
                                <i class="fa-solid fa-check text-[9px] mr-1"></i> Nilai Akhir: 91.5
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Sistem Presensi RFID & Face Recognition</h3>
                    </div>
                    <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100 shrink-0" title="Status: Selesai"></span>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                    Integrasi hardware NodeMCU RFID dengan aplikasi mobile Flutter untuk pencatatan kehadiran siswa otomatis.
                </p>

                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-1">
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                        <span>Guru: <strong class="text-slate-700">Hendra, S.Kom</strong></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fa-solid fa-award text-amber-500"></i>
                        <span>Predikat: <strong class="text-emerald-600">Sangat Memuaskan</strong></span>
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    <div class="flex justify-between text-[11px] font-bold">
                        <span class="text-slate-400 uppercase tracking-wider">Status Evaluasi</span>
                        <span class="text-emerald-600">Tuntas</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                    <div class="flex items-center -space-x-2">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Rizky&background=2563eb&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Ahmad Rizky">
                        <img src="https://ui-avatars.com/api/?name=Eko+Prabowo&background=6366f1&color=fff" class="w-7 h-7 rounded-full border-2 border-white object-cover" title="Eko Prabowo">
                    </div>
                    <span class="text-[10px] text-slate-400 font-semibold">Selesai: 15 Jun 2026</span>
                </div>
            </div>

            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 italic">Sertifikat terbit di Sistem</span>
                <button @click="detailModal = true; selectedProject = 'Presensi IoT'" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    Lihat Arsip <i class="fa-solid fa-file-lines ml-1 text-[10px]"></i>
                </button>
            </div>
        </div>

    </div>

    <!-- Modal Detail & Pengerjaan Proyek -->
    <div x-show="detailModal" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto"
         x-transition.opacity>
        
        <div @click.outside="detailModal = false" class="bg-white rounded-2xl border border-slate-100 shadow-2xl w-full max-w-2xl overflow-hidden my-8">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-diagram-project"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800" x-text="selectedProject || 'Detail Proyek'"></h3>
                        <p class="text-[10px] text-slate-400">Papan Kontrol Tugas Kelompok PjBL</p>
                    </div>
                </div>
                <button @click="detailModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto custom-scrollbar">
                
                <div class="p-4 bg-blue-50/60 border border-blue-100 rounded-xl space-y-3">
                    <h4 class="text-xs font-bold text-blue-900 flex items-center gap-2">
                        <i class="fa-solid fa-link"></i> Tautan Artefak Proyek (Kelompok)
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Repository Git</label>
                            <input type="text" value="https://github.com/certilearn/pos-cafe-fe" class="w-full text-xs p-2 bg-white border border-slate-200 rounded-lg text-slate-700 font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Desain Figma / Dokumen</label>
                            <input type="text" value="https://figma.com/file/sample-pos-design" class="w-full text-xs p-2 bg-white border border-slate-200 rounded-lg text-slate-700 font-mono">
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Modul & Tugas Saya</h4>
                    
                    <div class="space-y-2">
                        <label class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 cursor-pointer hover:bg-slate-100/60 transition">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                <div>
                                    <p class="text-xs font-bold text-slate-700 line-through">Slicing UI Kasir dengan Tailwind CSS</p>
                                    <p class="text-[10px] text-slate-400">Penanggung Jawab: Ahmad Rizky</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[9px] font-bold">Selesai</span>
                        </label>

                        <label class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 cursor-pointer hover:bg-slate-100/60 transition">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                <div>
                                    <p class="text-xs font-bold text-slate-700 line-through">Integrasi Modul Keranjang & Total Harga</p>
                                    <p class="text-[10px] text-slate-400">Penanggung Jawab: Ahmad Rizky</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[9px] font-bold">Selesai</span>
                        </label>

                        <label class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Sistem Cetak Struk via Bluetooth Printer</p>
                                    <p class="text-[10px] text-slate-400">Penanggung Jawab: Ahmad Rizky</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[9px] font-bold">Proses</span>
                        </label>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Catatan Pembimbing (Hendra, S.Kom)</span>
                    <p class="text-xs text-slate-600 italic">"Pengembangan UI sudah sangat rapi. Pastikan respon pada saat pemindaian QRIS diberi indikator loading agar UX lebih interaktif."</p>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button @click="detailModal = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold transition">
                    Tutup
                </button>
                <button @click="detailModal = false" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </div>

</div>
@endsection