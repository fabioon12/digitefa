@extends('siswa.layouts.app')

@section('title', 'Pengajuan Proyek PjBL - CertiLearn')

@section('content')
<div x-data="pengajuanProyek()" class="w-full p-6 space-y-6 bg-white min-h-screen text-slate-800">
    
    <!-- Header -->
    <div class="flex flex-col gap-1 w-full">
        <div class="flex items-center gap-2 text-xs text-slate-400">
            <a href="/Siswa/PjBL/Dashboard" class="hover:text-blue-600">Proyek PjBL</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-slate-600 font-medium">Pengajuan Proyek</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Pengajuan Proyek Baru</h1>
        <p class="text-sm text-slate-500">Lengkapi formulir di bawah ini untuk mengajukan ide proyek PjBL Anda.</p>
    </div>

    <!-- Main Form -->
    <form x-data="pengajuanProyek()" @submit.prevent="submitForm" class="w-full space-y-6" enctype="multipart/form-data">
        @csrf

        <!-- SECTION A: Informasi Proyek -->
        <div class="w-full p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-5">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">A</div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Informasi Proyek</h2>
                    <p class="text-xs text-slate-500">Detail umum mengenai tema, latar belakang, dan pembimbing proyek.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <!-- Tipe Pengerjaan -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-xs font-bold text-slate-700">Tipe Pengerjaan <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
                        <button type="button" @click="setTipe('individu')"
                                :class="formData.tipe === 'individu' ? 'border-blue-600 bg-blue-50/50 text-blue-700 shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                                class="p-3 border rounded-xl text-left transition flex items-center gap-3 w-full">
                            <div :class="formData.tipe === 'individu' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500'" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold transition shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold">Individu</p>
                                <p class="text-[10px] text-slate-500">Mengerjakan proyek secara mandiri</p>
                            </div>
                        </button>

                        <button type="button" @click="setTipe('kelompok')"
                                :class="formData.tipe === 'kelompok' ? 'border-blue-600 bg-blue-50/50 text-blue-700 shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                                class="p-3 border rounded-xl text-left transition flex items-center gap-3 w-full">
                            <div :class="formData.tipe === 'kelompok' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500'" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold transition shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold">Kelompok</p>
                                <p class="text-[10px] text-slate-500">Mengerjakan bersama rekan tim</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Judul Proyek -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-xs font-bold text-slate-700">1. Judul Proyek <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="formData.judul" placeholder="Contoh: Sistem Smart Garden Berbasis IoT" required
                        class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                </div>

                <!-- Deskripsi Proyek -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-xs font-bold text-slate-700">2. Deskripsi Proyek <span class="text-rose-500">*</span></label>
                    <textarea x-model="formData.deskripsi" rows="3" placeholder="Jelaskan secara singkat latar belakang dan tujuan proyek..." required
                            class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition"></textarea>
                </div>

                <!-- Kategori Proyek -->
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-xs font-bold text-slate-700">3. Mata Pelajaran / Kompetensi Utama <span class="text-rose-500">*</span></label>
                    <input type="text" 
                        x-model="formData.kategori" 
                        placeholder="Contoh: Pemrograman Web &amp; Bergerak" 
                        required 
                        class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                </div>

                <!-- DYNAMIC MULTIPLE PEMBIMBING CONTAINER -->
                <div class="md:col-span-2 bg-slate-50/70 p-5 border border-slate-200 rounded-2xl space-y-6">
                    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                        <i class="fa-solid fa-user-tie text-blue-600 text-sm"></i>
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">4. Tim Pembimbing & Penilai Proyek</h3>
                    </div>

                    <!-- 4A. PEMBIMBING UTAMA / PRODUKTIF -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-700">
                                Pembimbing Utama / Produktif <span class="text-rose-500">*</span>
                            </label>
                            <button type="button" @click="tambahPembimbingUtama" class="text-xs text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Pembimbing Utama
                            </button>
                        </div>

                        <template x-for="(item, index) in formData.pembimbing_utama" :key="index">
                            <div class="flex items-center gap-2">
                                <select x-model="formData.pembimbing_utama[index]" required class="w-full px-3.5 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                                    <option value="">-- Pilih Guru Produktif --</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}">
                                            {{ $guru->name }} {{ ($guru->mata_pelajaran ?? $guru->subject) ? '— (' . ($guru->mata_pelajaran ?? $guru->subject) . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" @click="hapusPembimbingUtama(index)" x-show="formData.pembimbing_utama.length > 1" class="p-2 text-slate-400 hover:text-rose-500 transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- 4B. PEMBIMBING UMUM / PENDAMPING -->
                    <div class="space-y-3 pt-2 border-t border-slate-200/60">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-slate-700">
                                Pembimbing Pendamping / Umum <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <button type="button" @click="tambahPembimbingUmum" class="text-xs text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Pembimbing Umum
                            </button>
                        </div>

                        <template x-for="(item, index) in formData.pembimbing_umum" :key="index">
                            <div class="flex items-center gap-2">
                                <select x-model="formData.pembimbing_umum[index]" class="w-full px-3.5 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                                    <option value="">-- Pilih Guru Umum --</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}">
                                            {{ $guru->name }} {{ ($guru->mata_pelajaran ?? $guru->subject) ? '— (' . ($guru->mata_pelajaran ?? $guru->subject) . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" @click="hapusPembimbingUmum(index)" class="p-2 text-slate-400 hover:text-rose-500 transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- 4C. PEMBIMBING INDUSTRI -->
                    <div class="space-y-3 pt-2 border-t border-slate-200/60">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="has_industri" x-model="hasIndustri" class="rounded text-blue-600 focus:ring-blue-500">
                                <label for="has_industri" class="text-xs font-bold text-slate-700 cursor-pointer">Libatkan Mentor / Penilai dari Pihak Industri (DUDI)</label>
                            </div>
                            <button type="button" x-show="hasIndustri" @click="tambahPembimbingIndustri" class="text-xs text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Mentor Industri
                            </button>
                        </div>

                        <div x-show="hasIndustri" x-transition class="space-y-3 pt-1">
                            <template x-for="(item, index) in formData.pembimbing_industri" :key="index">
                                <div class="flex items-center gap-2">
                                    <select x-model="formData.pembimbing_industri[index]" :required="hasIndustri" class="w-full px-3.5 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                                        <option value="">-- Pilih Mentor Industri / DUDI --</option>
                                        @foreach($industris as $industri)
                                            <option value="{{ $industri->id }}">
                                                {{ $industri->nama ?? $industri->name }} — ({{ $industri->perusahaan ?? $industri->company_name ?? 'Industri' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" @click="hapusPembimbingIndustri(index)" x-show="formData.pembimbing_industri.length > 1" class="p-2 text-slate-400 hover:text-rose-500 transition">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Mulai & Selesai -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700">5a. Tanggal Mulai <span class="text-rose-500">*</span></label>
                        <input type="date" x-model="formData.tanggal_mulai" :min="minDate" required
                            class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-700">5b. Tanggal Selesai (Deadline) <span class="text-rose-500">*</span></label>
                        <input type="date" x-model="formData.tanggal_selesai" :min="formData.tanggal_mulai || minDate" required
                            class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-blue-600 transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION B: Anggota Kelompok -->
        <div x-show="formData.tipe === 'kelompok'" x-transition class="w-full p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">B</div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Anggota Kelompok</h2>
                        <p class="text-xs text-slate-500">Tambahkan daftar siswa yang tergabung di kelompok proyek ini.</p>
                    </div>
                </div>
                <button type="button" @click="tambahAnggota" class="px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus"></i> Tambah Anggota
                </button>
            </div>

            <div class="space-y-3 w-full">
                <template x-for="(anggota, index) in formData.anggota" :key="index">
                    <div class="p-4 bg-slate-50 border rounded-xl space-y-3 w-full relative transition"
                        :class="anggota.is_leader ? 'border-amber-400 bg-amber-50/30' : 'border-slate-200'">
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-700" x-text="'Anggota ' + (index + 1)"></span>
                                <span x-show="anggota.is_leader" class="px-2 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-100 rounded-full border border-amber-300">
                                    <i class="fa-solid fa-crown mr-0.5"></i> Ketua Kelompok
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="button" 
                                        @click="setLeader(index)" 
                                        class="text-xs font-semibold transition"
                                        :class="anggota.is_leader ? 'text-amber-600 font-bold' : 'text-slate-400 hover:text-amber-600'">
                                    <i class="fa-solid fa-crown"></i> 
                                    <span x-text="anggota.is_leader ? 'Leader' : 'Jadikan Leader'"></span>
                                </button>

                                <button type="button" @click="hapusAnggota(index)" x-show="formData.anggota.length > 1" class="text-slate-400 hover:text-rose-500 text-xs">
                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                </button>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
                            <select x-model="anggota.siswa_id" :required="formData.tipe === 'kelompok'" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-blue-600">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->name }} - {{ $siswa->major }} - {{ $siswa->offering }}</option>
                                @endforeach
                            </select>
                            <input type="text" x-model="anggota.peran" placeholder="Peran / Jobdesk" :required="formData.tipe === 'kelompok'"
                                class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-blue-600">
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION C: Proposal -->
        <div class="w-full p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">C</div>
                <h2 class="text-base font-bold text-slate-900">Dokumen Proposal</h2>
            </div>
            <input type="file" @change="handleFileUpload" accept=".pdf" required class="w-full text-xs">
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3 pt-2">
            <button type="submit" :disabled="isSubmitting" class="px-5 py-2.5 text-xs font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 disabled:opacity-50">
                <span x-text="isSubmitting ? 'Mengirim...' : 'Kirim Pengajuan'"></span>
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js Logic -->
<script>
function pengajuanProyek() {
    return {
        minDate: new Date().toISOString().split('T')[0],
        fileObject: null,
        isSubmitting: false,
        hasIndustri: false,
        formData: {
            tipe: 'individu',
            judul: '',
            deskripsi: '',
            kategori: '',
            pembimbing_utama: [''], 
            pembimbing_umum: [],    
            pembimbing_industri: [''], 
            tanggal_mulai: '',
            tanggal_selesai: '',
            anggota: []
        },

        // Helper ubah tipe pengerjaan & reset data
        setTipe(tipe) {
            this.formData.tipe = tipe;
            if (tipe === 'individu') {
                this.formData.anggota = [];
            } else if (tipe === 'kelompok' && this.formData.anggota.length === 0) {
                this.tambahAnggota();
            }
        },
        
        tambahPembimbingUtama() { this.formData.pembimbing_utama.push(''); },
        hapusPembimbingUtama(index) { this.formData.pembimbing_utama.splice(index, 1); },

        tambahPembimbingUmum() { this.formData.pembimbing_umum.push(''); },
        hapusPembimbingUmum(index) { this.formData.pembimbing_umum.splice(index, 1); },

        tambahPembimbingIndustri() { this.formData.pembimbing_industri.push(''); },
        hapusPembimbingIndustri(index) { this.formData.pembimbing_industri.splice(index, 1); },

        // MODIFIKASI 1: Tambah Anggota tanpa mematok is_leader otomatis
        tambahAnggota() { 
            this.formData.anggota.push({ 
                siswa_id: '', 
                peran: '', 
                is_leader: false 
            }); 
        },

        // MODIFIKASI 2: Hapus Anggota tanpa mengubah paksa leader ke index 0
        hapusAnggota(index) { 
            this.formData.anggota.splice(index, 1); 
        },

        // Mengatur Leader secara bebas
        setLeader(targetIndex) {
            this.formData.anggota.forEach((item, index) => {
                const isTarget = (index === targetIndex);
                // Jika diklik ulang pada leader yang sama, toggle matikan status leader
                item.is_leader = isTarget ? !item.is_leader : false;
                
                if (item.is_leader && !item.peran) {
                    item.peran = 'Ketua Kelompok';
                }
            });
        },

        handleFileUpload(event) {
            this.fileObject = event.target.files[0];
        },

        async submitForm() {
            // MODIFIKASI 3: Validasi Leader Fleksibel saat Submit
            if (this.formData.tipe === 'kelompok') {
                if (this.formData.anggota.length === 0) {
                    alert('Proyek kelompok wajib memiliki minimal 1 anggota.');
                    return;
                }
                
                let hasLeader = this.formData.anggota.some(a => a.is_leader);
                if (!hasLeader) {
                    alert('Silakan pilih salah satu anggota sebagai Ketua Kelompok (Leader).');
                    return;
                }
            }

            this.isSubmitting = true;
            let data = new FormData();
            
            data.append('tipe', this.formData.tipe);
            data.append('judul', this.formData.judul);
            data.append('deskripsi', this.formData.deskripsi);
            data.append('kategori', this.formData.kategori);
            data.append('tanggal_mulai', this.formData.tanggal_mulai);
            data.append('tanggal_selesai', this.formData.tanggal_selesai);

            // Filter data kosong & re-index
            this.formData.pembimbing_utama
                .filter(id => id && id !== '')
                .forEach((id, index) => data.append(`pembimbing_utama[${index}]`, id));

            this.formData.pembimbing_umum
                .filter(id => id && id !== '')
                .forEach((id, index) => data.append(`pembimbing_umum[${index}]`, id));

            if (this.hasIndustri) {
                this.formData.pembimbing_industri
                    .filter(id => id && id !== '')
                    .forEach((id, index) => data.append(`pembimbing_industri[${index}]`, id));
            }

            if (this.formData.tipe === 'kelompok') {
                let validIndex = 0;
                this.formData.anggota.forEach((item) => {
                    if (item.siswa_id) {
                        data.append(`anggota[${validIndex}][siswa_id]`, item.siswa_id);
                        data.append(`anggota[${validIndex}][peran]`, item.peran || 'Anggota');
                        data.append(`anggota[${validIndex}][is_leader]`, item.is_leader ? '1' : '0');
                        validIndex++;
                    }
                });
            }

            if (this.fileObject) {
                data.append('proposal', this.fileObject);
            }

            try {
                let response = await fetch("{{ route('siswa.pjbl.store') }}", {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json' 
                    },
                    body: data
                });

                let resData = await response.json();

                if (response.ok) {
                    alert(resData.message || 'Proyek berhasil diajukan!');
                    window.location.href = resData.redirect || "/Siswa/PjBL/Dashboard";
                } else {
                    if (resData.errors) {
                        let errorMsg = Object.values(resData.errors).flat().join('\n');
                        alert('Gagal Mengirim:\n' + errorMsg);
                    } else {
                        alert(resData.message || 'Gagal mengirim pengajuan.');
                    }
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}
</script>
@endsection