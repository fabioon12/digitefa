@extends('guru.layouts.app')

@section('title', 'Pembelajaran PjBL - CertiLearn')
@section('content')
<div class="space-y-6" x-data="{ 
    tipePenerima: 'kelas', 
    tipeKelompok: 'sistem',
    pembimbing: 'sendiri',
    kriteriaList: [{ nama: '', bobot: '' }] 
}">

    <!-- Header Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-800 rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-blue-600/20 mb-8 border border-blue-400/20">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-cyan-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                <!-- Breadcrumb -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-medium text-blue-100 shadow-inner">
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-house text-[10px]"></i>
                        Portal Guru
                    </a>
                    <i class="fa-solid fa-chevron-right text-[8px] text-blue-200/60"></i>
                    <a href="#" class="hover:text-white transition-colors">Pembelajaran PjBL</a>
                    <i class="fa-solid fa-chevron-right text-[8px] text-blue-200/60"></i>
                    <span class="text-white font-semibold">Buat Proyek</span>
                </div>

                <div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Buat Proyek PjBL Baru
                    </h1>
                    <p class="text-blue-100/90 text-xs sm:text-sm mt-1.5 leading-relaxed font-normal">
                        Rancang tugas berbasis proyek baru, tentukan target siswa, kriteria penilaian, dan tenggat waktu pengerjaan.
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <div class="flex items-center gap-3 shrink-0">
                <a href="#" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl text-xs font-bold border border-white/20 backdrop-blur-md transition-all duration-200">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Kembali ke Panel</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Form Main Container -->
    <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        <!-- Column Left: Informasi utama & Target -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card 1: Informasi Umum Proyek -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base shadow-inner">
                        <i class="fa-solid fa-folder-plus"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-800">Informasi Proyek</h2>
                        <p class="text-xs text-slate-400">Judul, deskripsi, dan arahan tugas utama</p>
                    </div>
                </div>

                <!-- Judul Proyek -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                        Judul Proyek <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="judul" required placeholder="Contoh: Pengembangan Aplikasi Monitoring Sampah Berbasis IoT" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition">
                </div>

                <!-- Kategori & Mata Pelajaran -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Mata Pelajaran / Modul <span class="text-rose-500">*</span>
                        </label>
                        <select name="mapel_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            <option value="1">Pemrograman Web & Perangkat Bergerak</option>
                            <option value="2">Administrasi Infrastruktur Jaringan</option>
                            <option value="3">Desain Grafis Percetakan</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Kategori Proyek <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="kategori" placeholder="Contoh: Software Development / IoT" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <!-- Deskripsi singkat -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                        Deskripsi & Latar Belakang Proyek <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan gambaran umum, masalah yang ingin diselesaikan, serta batasan proyek..." 
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition resize-none"></textarea>
                </div>
            </div>

            <!-- Card 2: Pengaturan Penerima & Kelompok -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-base shadow-inner">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-800">Target & Struktur Tim</h2>
                        <p class="text-xs text-slate-400">Tentukan siapa yang mengerjakan dan format pembentukan tim</p>
                    </div>
                </div>

                <!-- Tipe Penerima -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                        Tipe Penugasan <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label :class="tipePenerima === 'kelas' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/10' : 'border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100'" 
                               class="p-3.5 border rounded-2xl cursor-pointer flex flex-col items-center gap-2 text-center transition">
                            <input type="radio" name="tipe_penerima" value="kelas" x-model="tipePenerima" class="sr-only">
                            <i class="fa-solid fa-school text-lg"></i>
                            <span class="text-xs font-extrabold">Satu Kelas</span>
                        </label>

                        <label :class="tipePenerima === 'kelompok' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/10' : 'border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100'" 
                               class="p-3.5 border rounded-2xl cursor-pointer flex flex-col items-center gap-2 text-center transition">
                            <input type="radio" name="tipe_penerima" value="kelompok" x-model="tipePenerima" class="sr-only">
                            <i class="fa-solid fa-people-group text-lg"></i>
                            <span class="text-xs font-extrabold">Kelompok</span>
                        </label>

                        <label :class="tipePenerima === 'individu' ? 'border-blue-500 bg-blue-50/50 text-blue-700 ring-2 ring-blue-500/10' : 'border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100'" 
                               class="p-3.5 border rounded-2xl cursor-pointer flex flex-col items-center gap-2 text-center transition">
                            <input type="radio" name="tipe_penerima" value="individu" x-model="tipePenerima" class="sr-only">
                            <i class="fa-solid fa-user text-lg"></i>
                            <span class="text-xs font-extrabold">Individu</span>
                        </label>
                    </div>
                </div>

                <!-- Select Target Kelas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Target Kelas <span class="text-rose-500">*</span>
                        </label>
                        <select name="kelas_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition">
                            <option value="">Pilih Kelas Target</option>
                            <option value="XII-RPL-1">XII RPL 1</option>
                            <option value="XII-RPL-2">XII RPL 2</option>
                            <option value="XII-TKJ-1">XII TKJ 1</option>
                        </select>
                    </div>

                    <!-- Max Anggota (Jika Kelompok) -->
                    <div x-show="tipePenerima === 'kelompok' || tipePenerima === 'kelas'" class="space-y-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Maksimal Anggota / Kelompok
                        </label>
                        <input type="number" min="2" max="10" name="max_anggota" value="4" 
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition">
                    </div>
                </div>

                <!-- Opsi Pembentukan Kelompok -->
                <div x-show="tipePenerima === 'kelompok' || tipePenerima === 'kelas'" class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                    <span class="block text-xs font-extrabold text-slate-700">Metode Pembentukan Kelompok:</span>
                    <div class="flex flex-col sm:flex-row gap-4 text-xs font-bold text-slate-600">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="pembentukan_kelompok" value="bebas" class="text-blue-600 focus:ring-blue-500">
                            <span>Siswa Bebas Pilih Kelompok</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="pembentukan_kelompok" value="acak" checked class="text-blue-600 focus:ring-blue-500">
                            <span>Diacak Otomatis oleh Sistem</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Card 3: Rubrik & Indikator Penilaian -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base shadow-inner">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800">Indikator Penilaian</h2>
                            <p class="text-xs text-slate-400">Tentukan kriteria komponen nilai dan bobotnya</p>
                        </div>
                    </div>
                    <button type="button" @click="kriteriaList.push({ nama: '', bobot: '' })" 
                            class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-plus"></i> Tambah Kriteria
                    </button>
                </div>

                <!-- Dynamic Kriteria List -->
                <div class="space-y-3">
                    <template x-for="(kriteria, index) in kriteriaList" :key="index">
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="kriteria.nama" :name="'kriteria['+index+'][nama]'" placeholder="Nama Kriteria (misal: Desain UI/UX)" 
                                   class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500 transition">
                            <div class="w-28 relative">
                                <input type="number" min="1" max="100" x-model="kriteria.bobot" :name="'kriteria['+index+'][bobot]'" placeholder="Bobot" 
                                       class="w-full pl-3 pr-7 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-emerald-500 transition">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">%</span>
                            </div>
                            <button type="button" @click="kriteriaList.splice(index, 1)" x-show="kriteriaList.length > 1"
                                    class="w-9 h-9 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center text-xs transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        <!-- Column Right: Sidebar Metadata & Actions -->
        <div class="space-y-6">
            
            <!-- Card Timeline / Deadline -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base shadow-inner">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-800">Jadwal Proyek</h2>
                        <p class="text-xs text-slate-400">Atur durasi pengerjaan</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Tanggal Mulai -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Tanggal Mulai <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" required value="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:outline-none focus:border-amber-500 transition">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">
                            Tenggat Waktu (Deadline) <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal_selesai" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 focus:outline-none focus:border-amber-500 transition">
                    </div>
                </div>
            </div>

            <!-- Upload Panduan / File Lampiran -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-base shadow-inner">
                        <i class="fa-solid fa-paperclip"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-800">Lampiran & Rubrik</h2>
                        <p class="text-xs text-slate-400">PDF, DOCX, ZIP (Maks 10MB)</p>
                    </div>
                </div>

                <div class="relative border-2 border-dashed border-slate-200 hover:border-purple-400 rounded-2xl p-4 text-center transition cursor-pointer group bg-slate-50/50">
                    <input type="file" name="file_lampiran" class="absolute inset-0 opacity-0 cursor-pointer">
                    <div class="space-y-2">
                        <div class="w-10 h-10 mx-auto rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm transition group-hover:scale-110">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <span class="block text-xs font-bold text-slate-700">Unggah File Modul/Panduan</span>
                        <span class="block text-[10px] text-slate-400">Klik atau seret file ke area ini</span>
                    </div>
                </div>
            </div>

            <!-- Submit Action Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-xs font-bold shadow-lg shadow-blue-500/25 transition duration-200 active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Terbitkan Proyek Sekarang</span>
                </button>

                <button type="submit" name="status" value="draft" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-xs font-bold transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Sebagai Draft</span>
                </button>
            </div>

        </div>

    </form>
</div>
@endsection