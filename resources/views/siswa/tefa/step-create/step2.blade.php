<div x-show="currentStep === 2" class="space-y-6" style="display: none;">
    <div class="border-b border-slate-100 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-extrabold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-book-open"></i> Tahap 2 dari 6
        </div>
        <h3 class="text-base font-black text-slate-800">Mata Pelajaran / Kompetensi Utama</h3>
        <p class="text-xs text-slate-400 mt-0.5">Tuliskan mata pelajaran atau bidang kompetensi utama yang sesuai.</p>
    </div>

    <div class="space-y-2">
        <label class="text-xs font-bold text-slate-700 tracking-wide">Mata Pelajaran / Kompetensi Utama <span class="text-rose-500">*</span></label>
        <div class="relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <i class="fa-solid fa-graduation-cap text-xs"></i>
            </div>
            <input type="text" name="kategori" x-model="kategori" required placeholder="Contoh: Pemrograman Web & Bergerak"
                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 transition shadow-sm">
        </div>
    </div>
</div>