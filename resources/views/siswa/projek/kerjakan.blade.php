@extends('siswa.layouts.app')

@section('title', 'Kerjakan Tugas Proyek - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{
    // State Modal Tambah Target Mandiri
    modalTarget: false,
    newTargetTitle: '',
    newTargetPj: '',
    newTargetDeadline: '',

    // State Modal Setor Bukti Tugas
    modalSetor: false,
    selectedTask: null,
    submitType: 'link',
    submitLink: '',
    submitNote: '',

    // Task Checklist Data
    tasks: [
        { 
            id: 1, 
            judul: 'Slicing UI Kasir dengan Tailwind CSS', 
            pj: 'Ahmad Rizky (Saya)', 
            tenggat: '10 Agu 2026', 
            status: 'acc', // Status: pending, review, acc, ditolak
            bukti: 'https://github.com/certilearn/pos-cafe/pull/1',
            catatanGuru: 'Sudah bagus dan responsif.'
        },
        { 
            id: 2, 
            judul: 'Integrasi Modul Keranjang & Total Harga', 
            pj: 'Ahmad Rizky (Saya)', 
            tenggat: '12 Agu 2026', 
            status: 'review', 
            bukti: 'https://github.com/certilearn/pos-cafe/pull/2',
            catatanGuru: null
        },
        { 
            id: 3, 
            judul: 'Sistem Cetak Struk via Bluetooth Printer', 
            pj: 'Ahmad Rizky (Saya)', 
            tenggat: '16 Agu 2026', 
            status: 'ditolak', 
            bukti: 'https://github.com/certilearn/pos-cafe/pull/3',
            catatanGuru: 'Cetak struk masih error pada ukuran kertas 58mm. Perbaiki dulu.'
        },
        { 
            id: 4, 
            judul: 'Integrasi API Payment QRIS', 
            pj: 'Budi Santoso', 
            tenggat: '18 Agu 2026', 
            status: 'pending', 
            bukti: null,
            catatanGuru: null
        }
    ],

    // Function Tambah Target Baru
    tambahTarget() {
        if (this.newTargetTitle.trim() === '') return;
        
        this.tasks.push({
            id: Date.now(),
            judul: this.newTargetTitle,
            pj: this.newTargetPj || 'Ahmad Rizky (Saya)',
            tenggat: this.newTargetDeadline || 'Belum diatur',
            status: 'pending',
            bukti: null,
            catatanGuru: null
        });

        this.newTargetTitle = '';
        this.newTargetPj = '';
        this.newTargetDeadline = '';
        this.modalTarget = false;
    },

    // Buka Modal Setor Bukti
    openSetorModal(task) {
        this.selectedTask = task;
        this.submitLink = task.bukti || '';
        this.modalSetor = true;
    },

    // Kirim Bukti Pengerjaan (Status berubah ke Review)
    kirimBukti() {
        if (!this.selectedTask) return;
        this.selectedTask.bukti = this.submitLink || 'File_Bukti_Proyek.pdf';
        this.selectedTask.status = 'review';
        this.modalSetor = false;
    },

    // Kalkulasi Progres HANYA dari tugas yang di-ACC Guru
    get progressPercentage() {
        if (this.tasks.length === 0) return 0;
        let accTasks = this.tasks.filter(t => t.status === 'acc').length;
        return Math.round((accTasks / this.tasks.length) * 100);
    }
}">

    <!-- Top Bar Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="/Siswa/PjBL" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Proyek
        </a>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg border border-blue-100">
                <i class="fa-solid fa-spinner fa-spin mr-1"></i> Sedang Berjalan
            </span>
            <span class="text-xs text-slate-400 font-medium">• Tenggat: 20 Agu 2026</span>
        </div>
    </div>

    <!-- Header Summary Proyek -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-md uppercase tracking-wider">
                        Kelompok 2 (Frontend)
                    </span>
                    <span class="text-xs text-slate-400">Pembimbing: <strong class="text-slate-700">Hendra, S.Kom</strong></span>
                </div>
                <h1 class="text-xl font-extrabold text-slate-800 tracking-tight mt-1">Sistem Kasir POS Cafe Suroboyo</h1>
                <p class="text-xs text-slate-500 mt-0.5">Setiap target tugas wajib menyertakan bukti pengerjaan dan disetujui (ACC) oleh guru pembimbing.</p>
            </div>

            <!-- Tombol Aksi Tambah Target Mandiri -->
            <button @click="modalTarget = true" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Target Mandiri
            </button>
        </div>

        <!-- Metric & Progres Bar -->
        <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div class="md:col-span-2 space-y-1.5">
                <div class="flex justify-between text-xs font-bold">
                    <span class="text-slate-500 uppercase tracking-wider">Progres Resmi (ACC Guru)</span>
                    <span class="text-blue-600" x-text="progressPercentage + '%'"></span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" :style="'width: ' + progressPercentage + '%'"></div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 text-xs font-semibold text-slate-600">
                <span class="px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                    Total: <strong class="text-slate-800" x-text="tasks.length"></strong>
                </span>
                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100">
                    ACC: <strong x-text="tasks.filter(t => t.status === 'acc').length"></strong>
                </span>
                <span class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl border border-amber-100">
                    Review: <strong x-text="tasks.filter(t => t.status === 'review').length"></strong>
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- List Target Tugas (2 Column) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-500"></i> Checklist Target & Verifikasi Guru
                </h3>
            </div>

            <div class="space-y-3">
                <template x-for="task in tasks" :key="task.id">
                    <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition space-y-3">
                        
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <h4 class="text-xs font-bold text-slate-800" x-text="task.judul"></h4>
                                <div class="flex flex-wrap items-center gap-3 text-[10px] text-slate-400">
                                    <span><i class="fa-solid fa-user-gear mr-1"></i> <span x-text="task.pj"></span></span>
                                    <span><i class="fa-regular fa-calendar mr-1"></i> Tenggat: <span x-text="task.tenggat"></span></span>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                <template x-if="task.status === 'acc'">
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-bold border border-emerald-100 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Disetujui (ACC)
                                    </span>
                                </template>
                                <template x-if="task.status === 'review'">
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-lg text-[10px] font-bold border border-amber-100 flex items-center gap-1">
                                        <i class="fa-solid fa-hourglass-half fa-spin"></i> Menunggu ACC
                                    </span>
                                </template>
                                <template x-if="task.status === 'ditolak'">
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-lg text-[10px] font-bold border border-rose-100 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-xmark"></i> Perlu Perbaikan
                                    </span>
                                </template>
                                <template x-if="task.status === 'pending'">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold border border-slate-200">
                                        Belum Dikerjakan
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- Info Bukti Pengerjaan / Catatan Revisi -->
                        <div class="text-xs space-y-2 pt-2 border-t border-slate-50">
                            <!-- Link / File Bukti jika ada -->
                            <template x-if="task.bukti">
                                <div class="flex items-center gap-2 text-[11px] bg-slate-50 p-2 rounded-lg border border-slate-100">
                                    <i class="fa-solid fa-paperclip text-slate-400"></i>
                                    <span class="text-slate-500">Bukti:</span>
                                    <a :href="task.bukti" target="_blank" class="text-blue-600 font-mono underline truncate max-w-xs" x-text="task.bukti"></a>
                                </div>
                            </template>

                            <!-- Catatan Revisi / Penolakan Guru -->
                            <template x-if="task.catatanGuru">
                                <div class="p-2.5 rounded-lg text-[11px] space-y-0.5" :class="task.status === 'ditolak' ? 'bg-rose-50 text-rose-800 border border-rose-100' : 'bg-slate-50 text-slate-700'">
                                    <span class="font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-comment-dots"></i> Catatan Guru:
                                    </span>
                                    <p class="italic" x-text="task.catatanGuru"></p>
                                </div>
                            </template>
                        </div>

                        <!-- Action Button untuk Siswa -->
                        <div class="flex items-center justify-end pt-1">
                            <template x-if="task.status === 'pending' || task.status === 'ditolak'">
                                <button @click="openSetorModal(task)" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                    <i class="fa-solid fa-upload text-[10px]"></i> 
                                    <span x-text="task.status === 'ditolak' ? 'Kirim Ulang Bukti' : 'Setor Bukti Tugas'"></span>
                                </button>
                            </template>

                            <template x-if="task.status === 'review'">
                                <button @click="openSetorModal(task)" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-pen text-[10px]"></i> Edit Bukti Pengerjaan
                                </button>
                            </template>

                            <template x-if="task.status === 'acc'">
                                <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-check-double"></i> Selesai & Terverifikasi
                                </span>
                            </template>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <!-- Kolom Kanan: Artefak Utama & Informasi Guru -->
        <div class="space-y-6">
            
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-link text-blue-500"></i> Link Repository Utama
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Repository Git Tim</label>
                        <div class="relative">
                            <i class="fa-brands fa-github absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="url" value="https://github.com/certilearn/pos-cafe" class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-mono focus:bg-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <button type="button" class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition">
                        Simpan Repository
                    </button>
                </div>
            </div>

            <!-- Petunjuk Alur Verifikasi -->
            <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100 space-y-2">
                <h4 class="text-xs font-bold text-blue-900 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info"></i> Alur Penilaian Progres
                </h4>
                <ol class="text-[11px] text-slate-600 space-y-1.5 list-decimal list-inside leading-relaxed">
                    <li>Kerjakan tugas lalu klik <strong>Setor Bukti Tugas</strong>.</li>
                    <li>Sertakan Link Pull Request / Drive / File bukti.</li>
                    <li>Tunggu Guru Pembimbing memeriksa & melakukan <strong>ACC</strong>.</li>
                    <li>Progres indikator proyek akan otomatis bertambah setelah di-ACC.</li>
                </ol>
            </div>

        </div>

    </div>

    <!-- Modal 1: Tambah Target Mandiri -->
    <div x-show="modalTarget" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto" x-transition.opacity>
        <div @click.outside="modalTarget = false" class="bg-white rounded-2xl border border-slate-100 shadow-2xl w-full max-w-md overflow-hidden space-y-4">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-sm font-bold text-slate-800">Tambah Target Mandiri</h3>
                <button @click="modalTarget = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form @submit.prevent="tambahTarget()" class="p-6 space-y-4 pt-0">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Target / Tugas *</label>
                    <input type="text" x-model="newTargetTitle" required placeholder="Contoh: Membuat Validasi Form Checkout" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Penanggung Jawab</label>
                    <select x-model="newTargetPj" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800">
                        <option value="Ahmad Rizky (Saya)">Ahmad Rizky (Saya)</option>
                        <option value="Budi Santoso">Budi Santoso</option>
                        <option value="Citra Dewi">Citra Dewi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tenggat Selesai</label>
                    <input type="date" x-model="newTargetDeadline" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 text-slate-800">
                </div>
                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="modalTarget = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20">Simpan Target</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Setor Bukti Pengerjaan (Link / File) -->
    <div x-show="modalSetor" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4 overflow-y-auto" x-transition.opacity>
        <div @click.outside="modalSetor = false" class="bg-white rounded-2xl border border-slate-100 shadow-2xl w-full max-w-lg overflow-hidden space-y-4">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Setor Bukti Pengerjaan</h3>
                    <p class="text-[10px] text-slate-400" x-text="selectedTask ? selectedTask.judul : ''"></p>
                </div>
                <button @click="modalSetor = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form @submit.prevent="kirimBukti()" class="p-6 space-y-4 pt-0">
                <!-- Tab Pilihan Tipe Bukti -->
                <div class="flex gap-2 p-1 bg-slate-100 rounded-xl">
                    <button type="button" @click="submitType = 'link'" :class="submitType === 'link' ? 'bg-white font-bold text-blue-600 shadow-xs' : 'text-slate-500'" class="flex-1 py-1.5 text-xs rounded-lg transition">Tautan / Link</button>
                    <button type="button" @click="submitType = 'file'" :class="submitType === 'file' ? 'bg-white font-bold text-blue-600 shadow-xs' : 'text-slate-500'" class="flex-1 py-1.5 text-xs rounded-lg transition">Unggah Berkas File</button>
                </div>

                <!-- Input Link -->
                <div x-show="submitType === 'link'" class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">URL Tautan Bukti (PR Github / Drive / Figma) *</label>
                    <input type="url" x-model="submitLink" placeholder="https://github.com/..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <!-- Input File -->
                <div x-show="submitType === 'file'" class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">File Lampiran (PDF/ZIP/Gambar) *</label>
                    <input type="file" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Catatan Tambahan untuk Guru (Opsional)</label>
                    <textarea x-model="submitNote" rows="2" placeholder="Tuliskan penjelasan singkat pengerjaan..." class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" @click="modalSetor = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20">Kirim untuk Di-ACC</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection