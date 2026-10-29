<div x-show="currentStep === 4" class="space-y-6" style="display: none;">
    <div class="border-b border-slate-100 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-extrabold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-calendar-days"></i> Tahap 4 dari 6
        </div>
        <h3 class="text-base font-black text-slate-800">Timeline Proyek</h3>
        <p class="text-xs text-slate-400 mt-0.5">Tentukan jadwal pelaksanaan dan batas waktu penyelesaian proyek.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-2">
            <label class="text-xs font-bold text-slate-700 tracking-wide">Tanggal Mulai <span class="text-rose-500">*</span></label>
            <input type="date" name="tanggal_mulai" x-model="tanggal_mulai" required 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 transition shadow-sm">
        </div>
        <div class="space-y-2">
            <label class="text-xs font-bold text-slate-700 tracking-wide">Tanggal Selesai (Deadline) <span class="text-rose-500">*</span></label>
            <input type="date" name="tanggal_selesai" x-model="tanggal_selesai" required 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 transition shadow-sm">
        </div>
    </div>
</div>