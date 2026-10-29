<!-- STEP 6: Review & Konfirmasi -->
<div x-show="currentStep === 6" class="space-y-6" style="display: none;">
    <div class="border-b border-slate-100 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-extrabold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-clipboard-check"></i> Tahap 6 dari 6
        </div>
        <h3 class="text-base font-black text-slate-800">Review & Konfirmasi</h3>
        <p class="text-xs text-slate-400 mt-0.5">Periksa kembali seluruh ringkasan data pengajuan Anda dari tahap 1 sampai 5 sebelum dikirim.</p>
    </div>

    <!-- Kotak Ringkasan Data Keseluruhan -->
    <div class="p-5 rounded-3xl border border-slate-200/80 bg-slate-50/50 space-y-5">
        
        <!-- BAGIAN 1: Informasi Proyek & Anggota -->
        <div class="space-y-3">
            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200/60 pb-2">
                <i class="fa-solid fa-circle-info text-blue-600"></i> 1. Informasi Proyek & Anggota
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tipe Pengerjaan</span>
                    <span class="font-bold text-slate-800 capitalize" x-text="tipe"></span>
                </div>
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kategori / Mapel</span>
                    <span class="font-bold text-slate-800" x-text="kategori || '-'"></span>
                </div>
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 sm:col-span-2 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Judul Proyek</span>
                    <span class="font-bold text-slate-800 text-sm" x-text="judul || '-'"></span>
                </div>
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 sm:col-span-2 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi Proyek</span>
                    <p class="font-medium text-slate-600 text-[11px] leading-relaxed" x-text="deskripsi || '-'"></p>
                </div>
            </div>

            <!-- Tampil bersih & rapi jika tipe Kelompok (Tanpa duplikasi) -->
            <div x-show="tipe === 'kelompok'" class="bg-white p-4 rounded-2xl border border-slate-200 space-y-2.5 shadow-sm" style="display: none;">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Anggota Kelompok & Peran</span>
                <div class="space-y-1.5">
                    <template x-for="(m, idx) in members">
                        <div class="text-xs text-slate-700 flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-lg bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-[10px]" x-text="idx + 1"></span>
                                <span class="font-bold text-slate-800" x-text="m.siswa_nama || 'Siswa belum dipilih'"></span>
                            </div>
                            <span class="px-2.5 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-[10px] font-bold shadow-2xs" x-text="m.peran || 'Peran belum diisi'"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: Tim Pembimbing -->
        <div class="space-y-3 pt-2">
            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200/60 pb-2">
                <i class="fa-solid fa-chalkboard-user text-blue-600"></i> 2. Tim Pembimbing & Mentor
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pembimbing Utama</span>
                    <span class="font-bold text-slate-800" x-text="pembimbingUtamaText"></span>
                </div>
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pembimbing Pendamping</span>
                    <span class="font-bold text-slate-800" x-text="pembimbingPendampingText"></span>
                </div>
            </div>
        </div>

        <!-- BAGIAN 3: Timeline & Proposal -->
        <div class="space-y-3 pt-2">
            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200/60 pb-2">
                <i class="fa-solid fa-calendar-days text-blue-600"></i> 3. Timeline & Dokumen Proposal
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Mulai - Selesai</span>
                    <span class="font-bold text-slate-800 flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-blue-500 text-[11px]"></i>
                        <span x-text="(tanggal_mulai || '...') + ' s/d ' + (tanggal_selesai || '...')"></span>
                    </span>
                </div>
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 space-y-1 shadow-sm">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">File Proposal</span>
                    <span class="font-bold text-blue-600 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-file-pdf text-rose-500 text-[11px]"></i>
                        <span class="truncate" x-text="proposalName"></span>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Peringatan Akhir -->
    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 flex items-start gap-3">
        <div class="text-amber-600 text-base mt-0.5">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="space-y-0.5 text-xs text-amber-900">
            <span class="font-black block">Konfirmasi Pengiriman</span>
            <p class="text-[11px] text-amber-700">Pastikan data di atas sudah benar. Setelah tombol dikirim, data akan masuk ke sistem peninjauan.</p>
        </div>
    </div>
</div>