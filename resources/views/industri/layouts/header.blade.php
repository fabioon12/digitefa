<header class="bg-white/40 backdrop-blur-md border-b border-white/20 h-16 flex items-center justify-end px-6 sticky top-0 z-30 transition-all">
    <!-- Komponen Notifikasi -->
    <div x-data="{ notifOpen: false }" class="relative" @click.outside="notifOpen = false">
        <button 
            @click="notifOpen = !notifOpen" 
            class="relative p-2.5 text-slate-700 hover:text-amber-600 hover:bg-amber-500/10 rounded-xl transition"
            title="Notifikasi"
        >
            <i class="fa-regular fa-bell text-xl"></i>
            
            <!-- Badge Indikator Notifikasi -->
            @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
            @endif
        </button>

        <!-- Dropdown Notifikasi -->
        <div 
            x-show="notifOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            x-cloak
            class="absolute right-0 mt-2 w-80 sm:w-88 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 py-2 z-50 overflow-hidden"
        >
            <!-- Header Notifikasi -->
            <div class="px-4 py-2.5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifikasi Undangan</h3>
                <span class="text-[10px] bg-amber-100 text-amber-700 px-2.5 py-0.5 rounded-full font-bold border border-amber-200/60">
                    {{ $unreadNotifCount ?? 0 }} Baru
                </span>
            </div>

            <!-- List Notifikasi -->
            <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto custom-scrollbar">
                @forelse($notifications ?? [] as $item)
                    <a href="{{ route('industri.pjbl.undangan.show', $item->id) }}" class="flex gap-3 px-4 py-3 hover:bg-amber-50/40 transition group">
                        <div class="p-2 bg-amber-50 text-amber-600 rounded-xl border border-amber-100 h-fit shrink-0 group-hover:bg-amber-600 group-hover:text-white transition">
                            <i class="fa-solid fa-file-signature text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-800 truncate">Undangan Pembimbing Proyek</p>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-snug line-clamp-2">
                                <span class="font-bold text-slate-700">{{ $item->creator->name ?? 'Sekolah' }}</span> mengundang Anda sebagai mentor untuk proyek <span class="font-bold text-slate-700">"{{ $item->judul }}"</span>.
                            </p>
                            <span class="text-[9px] font-semibold text-slate-400 mt-1 block">
                                {{ $item->created_at ? $item->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                    </a>
                @empty
                    <!-- State Kosong -->
                    <div class="px-4 py-6 text-center">
                        <i class="fa-regular fa-bell-slash text-slate-300 text-2xl mb-2"></i>
                        <p class="text-xs text-slate-500 font-medium">Tidak ada undangan baru</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer Notifikasi -->
            <div class="px-4 py-2 border-t border-slate-100 bg-slate-50/50 text-center">
                <a href="{{ route('industri.pjbl.undangan.index', ['status' => 'pending']) }}" class="text-xs text-amber-600 font-bold hover:text-amber-700 transition">
                    Lihat Semua Undangan
                </a>
            </div>
        </div>
    </div>
</header>