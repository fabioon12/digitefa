<!-- Container Notification Dropdown -->
<div x-data="{ openNotification: false }" class="relative">
    
    <!-- Tombol Lonceng -->
    <button 
        @click="openNotification = !openNotification" 
        @click.outside="openNotification = false"
        class="relative p-2 text-slate-400 hover:text-blue-600 hover:bg-slate-50 rounded-xl transition cursor-pointer focus:outline-none"
        title="Notifikasi Undangan"
    >
        <i class="fa-regular fa-bell text-lg"></i>
        
        <!-- Dot Indicator Merah -->
        <span 
            x-show="{{ $totalUndangan ?? 0 }} > 0" 
            x-cloak
            class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"
        ></span>
    </button>

    <!-- Popover Dropdown Panel -->
    <div 
        x-show="openNotification"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        x-cloak
        class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden"
    >
        <!-- Header Popover -->
        <div class="px-4 py-3 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifikasi Undangan</h3>
                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full">
                    {{ $totalUndangan ?? 0 }} Baru
                </span>
            </div>
            <button @click="openNotification = false" class="text-slate-400 hover:text-slate-600 text-xs">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Body Popover / Item List -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
            @forelse($undanganProyek ?? [] as $item)
                <div class="p-4 hover:bg-slate-50/60 transition space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 text-sm font-bold mt-0.5">
                            <i class="fa-solid fa-users-rectangle"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-slate-600 leading-relaxed">
                                <span class="font-bold text-slate-800">
                                    {{ $item->leader->nama_siswa ?? 'Ketua Proyek' }}
                                </span> 
                                mengundang Anda ke proyek <span class="font-bold text-blue-600">"{{ $item->project->judul ?? 'Proyek Tanpa Judul' }}"</span> sebagai 
                                <span class="font-bold text-slate-800">{{ $item->peran }}</span>.
                            </p>
                            <span class="text-[10px] text-slate-400 mt-1 block">
                                {{ $item->created_at ? $item->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-2 pl-11">
                        <!-- Form Tolak -->
                        <a href="{{ route('siswa.pjbl.invitation.reject', $item->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 text-xs font-semibold rounded-lg transition">
                            Tolak
                        </a>
                        <a href="{{ route('siswa.pjbl.invitation.accept', $item->id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                            Terima
                        </a>
                    </div>
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-emerald-800 rounded-lg bg-emerald-50 border border-emerald-200" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            @empty
                <!-- Empty State jika tidak ada undangan -->
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto mb-3">
                        <i class="fa-regular fa-bell-slash text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-600">Tidak ada undangan pending</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Semua notifikasi proyek Anda sudah ditinjau.</p>
                </div>
            @endforelse
        </div>

        <!-- Footer Popover -->
        @if(($totalUndangan ?? 0) > 0)
            <div class="p-2.5 bg-slate-50 border-t border-slate-100 text-center">
                <a 
                    href="{{ route('siswa.pjbl.invitation.index') }}" 
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition block py-1"
                >
                    Lihat Semua Halaman Undangan →
                </a>
            </div>
        @endif
    </div>
</div>