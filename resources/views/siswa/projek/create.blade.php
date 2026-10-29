@extends('siswa.layouts.app')

@section('title', 'Ajukan Proyek Baru - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{
    tipeKelompok: 'kelompok',
    anggota: [
        { nama: '', peran: '' }
    ],
    tambahAnggota() {
        this.anggota.push({ nama: '', peran: '' });
    },
    hapusAnggota(index) {
        this.anggota.splice(index, 1);
    }
}">

    <!-- Breadcrumb & Navigasi Kembali -->
    <div class="flex items-center justify-between">
        <a href="" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Proyek
        </a>
        <span class="text-xs text-slate-400 font-medium">Langkah 1 dari 1: Pengisian Form</span>
    </div>

    <!-- Container Form Utama -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Header Form -->
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-base shadow-xs">
                    <i class="fa-solid fa-folder-plus"></i>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold text-slate-800">Form Pengajuan Proyek PjBL</h1>
                    <p class="text-xs text-slate-500">Isi detail proposal proyek kelompok atau individu Anda untuk direview oleh guru pembimbing.</p>
                </div>
            </div>
        </div>

        <form action="{{route('siswa.pjbl.store')}}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">

            <!-- Section 1: Informasi Dasar Proyek -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-500"></i> Informasi Dasar Proyek
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Judul Proyek -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul Proyek <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" required placeholder="Contoh: Sistem Kasir POS Cafe Suroboyo" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800 transition">
                    </div>

                    <!-- Kategori / Bidang -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori Proyek <span class="text-rose-500">*</span>
                        </label>
                        <select name="kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800 transition">
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="frontend">Web Frontend Development</option>
                            <option value="backend">Web Backend Development</option>
                            <option value="fullstack">Fullstack Web Development</option>
                            <option value="mobile">Mobile Application Development</option>
                            <option value="iot">Internet of Things (IoT)</option>
                            <option value="uiux">UI/UX Design & Prototyping</option>
                        </select>
                    </div>

                    <!-- Guru Pembimbing -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Guru Pembimbing <span class="text-rose-500">*</span>
                        </label>
                        <select name="guru_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800 transition">
                            <option value="" disabled selected>Pilih Pembimbing...</option>
                            <option value="1">Hendra, S.Kom</option>
                            <option value="2">Maya Indah, S.T</option>
                            <option value="3">Budi Utomo, M.T</option>
                        </select>
                    </div>

                    <!-- Deskripsi Proyek -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Singkat & Latar Belakang <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="deskripsi" rows="3" required placeholder="Jelaskan secara singkat latar belakang masalah dan solusi aplikasi yang dirancang..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800 transition"></textarea>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Format Kerja & Anggota Tim -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-users text-blue-500"></i> Format Kerja & Tim
                </h3>

                <!-- Tipe Pengerjaan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Tipe Pengerjaan
                    </label>
                    <div class="grid grid-cols-2 gap-3 max-w-md">
                        <label class="flex items-center gap-3 p-3 bg-slate-50 border rounded-xl cursor-pointer hover:bg-slate-100/60 transition" :class="tipeKelompok === 'kelompok' ? 'border-blue-500 bg-blue-50/20' : 'border-slate-200'">
                            <input type="radio" name="tipe" value="kelompok" x-model="tipeKelompok" class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Kelompok</span>
                                <span class="block text-[10px] text-slate-400">Pengerjaan 2 orang atau lebih</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 bg-slate-50 border rounded-xl cursor-pointer hover:bg-slate-100/60 transition" :class="tipeKelompok === 'individu' ? 'border-blue-500 bg-blue-50/20' : 'border-slate-200'">
                            <input type="radio" name="tipe" value="individu" x-model="tipeKelompok" class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Individu</span>
                                <span class="block text-[10px] text-slate-400">Pengerjaan mandiri</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Input Anggota Tim (Dynamic List via Alpine) -->
                <div x-show="tipeKelompok === 'kelompok'" class="space-y-3 pt-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Anggota Tim Tambahan
                        </label>
                        <button type="button" @click="tambahAnggota()" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            <i class="fa-solid fa-plus text-[10px]"></i> Tambah Anggota
                        </button>
                    </div>

                    <div class="space-y-2">
                        <template x-for="(item, index) in anggota" :key="index">
                            <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="text-xs font-bold text-slate-400 w-5 text-center" x-text="index + 1"></span>
                                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="text" x-model="item.nama" :name="'anggota['+index+'][nama]'" placeholder="Nama Lengkap / NISN Siswa" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-800">
                                    <input type="text" x-model="item.peran" :name="'anggota['+index+'][peran]'" placeholder="Peran (cth: Frontend / Designer)" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 text-slate-800">
                                </div>
                                <button type="button" @click="hapusAnggota(index)" x-show="anggota.length > 1" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: Target & Lampiran -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-paperclip text-blue-500"></i> Target & Proposal
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Target Selesai -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Target Tanggal Selesai <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="target_selesai" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800 transition">
                    </div>

                    <!-- Tautan Repositori Awal / Figma (Opsional) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Link Figma / Repositori Awal <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="url" name="link_referensi" placeholder="https://figma.com/file/..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800 transition font-mono">
                    </div>

                    <!-- Upload Berkas Proposal (PDF) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Unggah Dokumen Proposal (PDF) <span class="text-rose-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-slate-200 bg-slate-50 rounded-2xl p-6 text-center hover:bg-slate-100/50 transition cursor-pointer relative">
                            <input type="file" name="proposal_file" accept=".pdf" required class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="space-y-2">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 mx-auto flex items-center justify-center">
                                    <i class="fa-solid fa-cloud-arrow-up text-base"></i>
                                </div>
                                <div class="text-xs text-slate-600">
                                    <span class="font-bold text-blue-600">Klik untuk unggah berkas</span> atau tarik file ke sini
                                </div>
                                <p class="text-[10px] text-slate-400">Format PDF maks. 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i> Ajukan Proposal Proyek
                </button>
            </div>

        </form>
    </div>

</div>
@endsection