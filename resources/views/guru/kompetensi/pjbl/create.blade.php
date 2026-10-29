@extends('guru.layouts.app')

@section('title', 'Penentuan Capaian Kompetensi - CertiLearn')

@section('content')
<div class="space-y-6" x-data="kompetensiPjblForm()" x-init="initForm()">

    <!-- Page Header & Action Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="" class="hover:text-blue-600 transition">Penentuan Kompetensi</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-slate-600 font-semibold">Penilaian Siswa</span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Penentuan Capaian Kompetensi PjBL</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tentukan poin capaian yang berhasil dipenuhi siswa setelah menyelesaikan produk proyek.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('guru.kompetensi.pjbl.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali</span>
            </a>
            <!-- PERBAIKAN: Menambahkan type="button" secara eksplisit -->
            <button type="button" @click="submitForm($event)" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-1.5">
                <i class="fa-solid fa-floppy-disk text-[10px]"></i>
                <span>Simpan Penilaian</span>
            </button>
        </div>
    </div>

    <!-- Layout Grid Utama (2 Kolom) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KOLOM KIRI (1/3): Summary Informasi Siswa & Produk -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Card Informasi Siswa -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 font-bold text-sm flex items-center justify-center shrink-0">
                        <span x-text="siswa.nama.split(' ').map(n => n[0]).join('').substring(0,2)"></span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm" x-text="siswa.nama"></h3>
                        <p class="text-xs text-slate-400">NISN: <span x-text="siswa.nisn"></span></p>
                        <span class="inline-block mt-1 px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold" x-text="siswa.kelas + ' • ' + siswa.jurusan"></span>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Detail Produk Proyek -->
                <div class="space-y-3">
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md uppercase" x-text="siswa.kategori"></span>
                        <h4 class="font-bold text-slate-800 text-sm mt-1.5" x-text="siswa.projekJudul"></h4>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between text-slate-500">
                            <span>Status Produk:</span>
                            <span class="font-bold text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Selesai (100%)
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-slate-500">
                            <span>Tanggal Selesai:</span>
                            <span class="font-semibold text-slate-700" x-text="siswa.tanggalSelesai"></span>
                        </div>
                    </div>

                    <a href="{{ route('guru.pjbl.monitor', $project->id) }}" target="_blank" class="w-full mt-2 px-3 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        <span>Lihat Hasil / Repositori Produk</span>
                    </a>
                </div>
            </div>

            <!-- Card Summary Indikator Capaian -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-5 rounded-2xl text-white space-y-3 shadow-md shadow-blue-500/10">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-200">Ringkasan Ketercapaian</span>
                
                <div class="flex items-baseline justify-between">
                    <div>
                        <span class="text-3xl font-extrabold">{{ $completedCount }}</span>
                        <span class="text-sm opacity-80">/ {{ $totalTasks }} Indikator</span>
                    </div>
                    <span class="text-xl font-bold">{{ $progressPercent }}%</span>
                </div>

                <div class="w-full bg-white/20 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-400 h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <!-- PERBAIKAN: Form submit dihandle dengan prevent -->
            <form @submit.prevent="submitForm($event)" class="space-y-6">

                <!-- PANEL 1: Input & Checklist Capaian Kompetensi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Item Capaian Kompetensi (CP / KD)</h3>
                            <p class="text-xs text-slate-400">Tambahkan dan pilih capaian yang berhasil dipenuhi siswa dalam produk ini.</p>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg w-fit" x-text="totalTerpenuhi + ' dari ' + form.capaianList.length + ' Tercentang'"></span>
                    </div>

                    <!-- Form Tambah Capaian Baru -->
                    <div class="flex items-center gap-2">
                        <input type="text" x-model="newCapaianText" @keydown.enter.prevent="addCapaian()" placeholder="+ Tambahkan indikator capaian kompetensi baru..." class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:bg-white focus:outline-none focus:border-blue-600 transition">
                        <button type="button" @click="addCapaian()" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl text-xs transition flex items-center gap-1.5 shrink-0">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>Tambah Item</span>
                        </button>
                    </div>

                    <!-- Checklist Interactive List -->
                    <div class="space-y-2.5 pt-2">
                        <template x-for="(capaian, idx) in form.capaianList" :key="capaian.id">
                            <div class="flex items-center justify-between p-3.5 rounded-xl border transition cursor-pointer select-none"
                                 :class="capaian.achieved ? 'border-emerald-200 bg-emerald-50/30 text-slate-800' : 'border-slate-200 bg-slate-50/50 text-slate-400 hover:bg-slate-50'"
                                 @click="toggleCapaian(idx)">
                                
                                <div class="flex items-start gap-3 flex-1 pr-3">
                                    <div class="mt-0.5">
                                        <!-- PERBAIKAN: Menggunakan x-model untuk dua arah binding yang konsisten -->
                                        <input type="checkbox" x-model="capaian.achieved" @click.stop class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                                    </div>
                                    <span class="text-xs leading-relaxed" :class="capaian.achieved ? 'font-semibold text-slate-800' : 'line-through text-slate-400'" x-text="capaian.teks"></span>
                                </div>

                                <button type="button" @click.stop="removeCapaian(idx)" class="text-slate-300 hover:text-rose-500 p-1.5 transition rounded-lg hover:bg-rose-50">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </template>

                        <template x-if="form.capaianList.length === 0">
                            <div class="text-center py-8 border border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                                <i class="fa-solid fa-list-check text-2xl text-slate-300 mb-1"></i>
                                <p class="text-xs text-slate-400 font-medium">Belum ada indikator capaian. Tambahkan item pada input di atas.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- PANEL 2: Keputusan Kompetensi & Penilaian Akhir -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3">Keputusan Kelulusan & Nilai Produk</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Choice Keputusan Akhir -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Keputusan Kompetensi *</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="p-3 bg-slate-50 border rounded-xl flex items-center justify-center gap-2 cursor-pointer transition" :class="form.statusKompetensi === 'kompeten' ? 'border-emerald-500 bg-emerald-50 text-emerald-800 font-bold' : 'border-slate-200 text-slate-600'">
                                    <input type="radio" value="kompeten" x-model="form.statusKompetensi" class="hidden">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    <span class="text-xs">Kompeten</span>
                                </label>
                                <label class="p-3 bg-slate-50 border rounded-xl flex items-center justify-center gap-2 cursor-pointer transition" :class="form.statusKompetensi === 'belum_kompeten' ? 'border-rose-500 bg-rose-50 text-rose-800 font-bold' : 'border-slate-200 text-slate-600'">
                                    <input type="radio" value="belum_kompeten" x-model="form.statusKompetensi" class="hidden">
                                    <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                                    <span class="text-xs">Belum Kompeten</span>
                                </label>
                            </div>
                        </div>

                        <!-- Input Nilai Akhir -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Nilai Akhir Produk (0 - 100) *</label>
                            <input type="number" min="0" max="100" x-model="form.nilaiAkhir" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:bg-white focus:outline-none focus:border-blue-600 transition">
                        </div>
                    </div>

                    <!-- Input Catatan Ulasan Guru -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Catatan & Ulasan Evaluasi Guru</label>
                        <textarea x-model="form.catatanGuru" rows="3" placeholder="Tuliskan umpan balik atau apresiasi atas produk yang telah dikerjakan siswa..." class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-600 transition"></textarea>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('guru.kompetensi.pjbl.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Penentuan Kompetensi</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
function kompetensiPjblForm() {
    return {
        siswa: {
            id: {{ $student->id }},
            nama: @js($student->name),
            nisn: @js($student->nisn ?? '-'),
            kelas: @js($student->kelas ?? 'Kelas'),
            jurusan: @js($student->jurusan ?? 'Jurusan'),
            projekJudul: @js($project->title ?? $project->nama_proyek),
            kategori: @js($project->category ?? 'PjBL'),
            tanggalSelesai: @js($project->updated_at->format('d M Y')),
            linkProduk: @js($project->link_produk ?? '#')
        },
        newCapaianText: '',
        form: {
            statusKompetensi: @js($evaluation->status_kompetensi ?? 'kompeten'),
            nilaiAkhir: @js($evaluation->nilai_akhir ?? 80),
            catatanGuru: @js($evaluation->catatan_guru ?? ''),
            capaianList: @js(
                $evaluation && $evaluation->items->count() > 0 
                ? $evaluation->items->map(fn($item) => ['id' => $item->id, 'teks' => $item->indikator, 'achieved' => (bool)$item->is_achieved])
                : [
                    ['id' => 1, 'teks' => 'Mampu menganalisis kebutuhan sistem proyek dengan tepat', 'achieved' => true],
                    ['id' => 2, 'teks' => 'Menghasilkan desain antarmuka produk yang responsif', 'achieved' => true],
                    ['id' => 3, 'teks' => 'Melakukan pengujian fungsi utama produk secara mandiri', 'achieved' => false],
                ]
            )
        },
        initForm() {
            // Inisialisasi jika dibutuhkan
        },
        get totalTerpenuhi() {
            return this.form.capaianList.filter(item => item.achieved).length;
        },
        addCapaian() {
            if (this.newCapaianText.trim() === '') return;
            this.form.capaianList.push({
                id: Date.now(),
                teks: this.newCapaianText.trim(),
                achieved: true
            });
            this.newCapaianText = '';
        },
        toggleCapaian(index) {
            this.form.capaianList[index].achieved = !this.form.capaianList[index].achieved;
        },
        removeCapaian(index) {
            this.form.capaianList.splice(index, 1);
        },
        async submitForm(event) {
            // PERBAIKAN: Mencegah submit default secara eksplisit
            if (event) {
                event.preventDefault();
            }

            if (this.form.capaianList.length === 0) {
                alert('Harap tambahkan setidaknya satu indikator capaian!');
                return;
            }

            try {
                const response = await fetch("{{ route('guru.kompetensi.pjbl.store', [$project->id, $student->id]) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(this.form)
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message);
                    window.location.href = result.redirect_url;
                } else {
                    alert(result.message || 'Terjadi kesalahan saat menyimpan.');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan koneksi.');
            }
        }
    }
}
</script>
@endsection