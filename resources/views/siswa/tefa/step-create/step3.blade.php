<!-- STEP 3: Tim Pembimbing & Penilai Proyek -->
<div x-show="currentStep === 3" class="space-y-6" style="display: none;">
    <div class="border-b border-slate-100 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-extrabold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-chalkboard-user"></i> Tahap 3 dari 6
        </div>
        <h3 class="text-base font-black text-slate-800">Tim Pembimbing & Penilai Proyek</h3>
        <p class="text-xs text-slate-400 mt-0.5">Pilih guru pembimbing dan mentor industri yang akan mendampingi proyek Anda.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
        
        <!-- 1. Pembimbing Utama (Searchable) -->
        <div class="space-y-1.5" x-data="{ openUtama: false, search: '', selectedId: '', selectedText: '-- Cari & Pilih Guru Utama --' }">
            <label class="text-xs font-bold text-slate-700 tracking-wide">Pembimbing Utama / Produktif <span class="text-rose-500">*</span></label>
            <div class="relative">
                <input type="hidden" name="pembimbing_utama[]" x-model="selectedId">
                
                <div @click="openUtama = !openUtama" 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-700 cursor-pointer flex items-center justify-between min-h-[46px] transition shadow-sm">
                    <span class="truncate pr-2" x-text="selectedText" :class="selectedId ? 'text-slate-800 font-bold' : 'text-slate-400'"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 shrink-0" :class="openUtama ? 'rotate-180' : ''"></i>
                </div>

                <div x-show="openUtama" @click.away="openUtama = false"
                    class="absolute z-30 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden p-2 space-y-2" style="display: none;">
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input type="text" x-model="search" placeholder="Cari nama guru..." 
                            class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="max-h-48 overflow-y-auto space-y-1">
                        @foreach($gurus as $guru)
                            <div x-show="search === '' || '{{ strtolower($guru->name) }}'.includes(search.toLowerCase())"
                                @click="
                                    selectedId = '{{ $guru->id }}';
                                    selectedText = '{{ $guru->name }} ({{ $guru->subject ?? 'Produktif' }})';
                                    openUtama = false;
                                    search = '';
                                    updatePembimbingUtamaCustom('{{ $guru->name }} ({{ $guru->subject ?? 'Produktif' }})');
                                "
                                class="px-3 py-2 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer transition flex items-center justify-between">
                                <span class="font-medium">{{ $guru->name }}</span>
                                <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $guru->subject ?? 'Produktif' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Pembimbing Pendamping (Searchable) -->
        <div class="space-y-1.5" x-data="{ openPendamping: false, search: '', selectedId: '', selectedText: '-- Pilih Pembimbing Pendamping --' }">
            <label class="text-xs font-bold text-slate-700 tracking-wide">Pembimbing Pendamping <span class="text-slate-400 font-normal">(Opsional)</span></label>
            <div class="relative">
                <input type="hidden" name="pembimbing_umum[]" x-model="selectedId">
                
                <div @click="openPendamping = !openPendamping" 
                     class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-700 cursor-pointer flex items-center justify-between min-h-[46px] transition shadow-sm">
                    <span class="truncate pr-2" x-text="selectedText" :class="selectedId ? 'text-slate-800 font-bold' : 'text-slate-400'"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 shrink-0" :class="openPendamping ? 'rotate-180' : ''"></i>
                </div>

                <div x-show="openPendamping" @click.away="openPendamping = false"
                     class="absolute z-30 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden p-2 space-y-2" style="display: none;">
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input type="text" x-model="search" placeholder="Cari nama guru..." 
                            class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="max-h-48 overflow-y-auto space-y-1">
                        @foreach($gurus as $guru)
                            <div x-show="search === '' || '{{ strtolower($guru->name) }}'.includes(search.toLowerCase())"
                                 @click="
                                    selectedId = '{{ $guru->id }}';
                                    selectedText = '{{ $guru->name }}';
                                    openPendamping = false;
                                    search = '';
                                    updatePembimbingPendampingCustom('{{ $guru->name }}');
                                 "
                                 class="px-3 py-2 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer transition flex items-center justify-between">
                                <span class="font-medium">{{ $guru->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Pihak Industri (DUDI) dengan Searchable Dropdown -->
    <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 space-y-3" x-data="{ libatkanDudi: false, openDudi: false, search: '', selectedId: '', selectedText: '-- Pilih Perusahaan / Mentor Industri --' }">
        <div class="flex items-start gap-3">
            <input type="checkbox" id="dudi" x-model="libatkanDudi" class="w-4 h-4 text-blue-600 rounded border-slate-300 mt-0.5">
            <label for="dudi" class="text-xs text-slate-600 cursor-pointer">
                <span class="font-bold text-slate-800 block">Libatkan Mentor / Penilai dari Pihak Industri (DUDI)</span>
                <span class="text-[11px] text-slate-400">Centang jika proyek melibatkan mitra industri secara langsung.</span>
            </label>
        </div>

        <div x-show="libatkanDudi" class="space-y-1.5 pt-2 border-t border-slate-200" style="display: none;">
            <label class="text-xs font-bold text-slate-700">Pilih Mitra Industri / Mentor DUDI <span class="text-rose-500">*</span></label>
            <div class="relative">
                <!-- Atribut :required dihapus agar container tidak disembunyikan otomatis oleh browser -->
                <input type="hidden" name="pembimbing_industri[]" x-model="selectedId">
                
                <div @click="openDudi = !openDudi" 
                    class="w-full px-4 py-3 bg-white border border-blue-200 rounded-2xl text-xs font-medium text-slate-700 cursor-pointer flex items-center justify-between min-h-[46px] transition shadow-sm">
                    <span class="truncate pr-2" x-text="selectedText" :class="selectedId ? 'text-slate-800 font-bold' : 'text-slate-400'"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 shrink-0" :class="openDudi ? 'rotate-180' : ''"></i>
                </div>

                <div x-show="openDudi" @click.away="openDudi = false"
                    class="absolute z-30 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden p-2 space-y-2" style="display: none;">
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input type="text" x-model="search" placeholder="Cari nama perusahaan / industri..." 
                            class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="max-h-48 overflow-y-auto space-y-1">
                        @foreach($industris as $industri)
                            <div x-show="search === '' || '{{ strtolower($industri->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($industri->company_name ?? '') }}'.includes(search.toLowerCase())"
                                @click="
                                    selectedId = '{{ $industri->id }}';
                                    selectedText = '{{ $industri->name }} - {{ $industri->company_name ?? 'Mitra DUDI' }}';
                                    openDudi = false;
                                    search = '';
                                "
                                class="px-3 py-2 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer transition flex items-center justify-between">
                                <span class="font-medium">{{ $industri->name }}</span>
                                <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $industri->company_name ?? 'Mitra DUDI' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>