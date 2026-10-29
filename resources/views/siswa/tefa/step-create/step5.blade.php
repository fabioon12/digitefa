<!-- STEP 5: Dokumen Proposal -->
<div x-show="currentStep === 5" class="space-y-6" style="display: none;">
    <div class="border-b border-slate-100 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-extrabold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-file-arrow-up"></i> Tahap 5 dari 6
        </div>
        <h3 class="text-base font-black text-slate-800">Dokumen Proposal</h3>
        <p class="text-xs text-slate-400 mt-0.5">Unggah dokumen proposal proyek TEFA Anda (Format: PDF, Maks 5MB).</p>
    </div>

    <div class="relative group">
        <!-- TAMBAHKAN @change DI SINI -->
        <input type="file" name="proposal" @change="updateProposalName($event)" required accept=".pdf"
            class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer">
        
        <div class="border-2 border-dashed border-slate-200 group-hover:border-blue-500 bg-slate-50/50 p-8 rounded-3xl text-center space-y-3 transition-all">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl mx-auto flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-black text-slate-700">Klik atau seret file PDF proposal ke sini</p>
                <p class="text-[10px] text-slate-400 font-medium">Maksimal ukuran file 5MB</p>
            </div>
        </div>
    </div>
</div>