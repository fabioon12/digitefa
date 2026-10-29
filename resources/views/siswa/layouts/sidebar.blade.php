<!-- Sidebar Backdrop untuk Mobile -->
<div x-show="sidebarOpen" 
     x-transition.opacity 
     class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden" 
     @click="sidebarOpen = false"></div>

<!-- Sidebar Layout -->
<aside :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:w-72': !sidebarCollapsed,
        'lg:w-20': sidebarCollapsed
    }" 
    class="fixed inset-y-0 left-0 z-50 bg-white/95 backdrop-blur-xl border-r border-slate-200/80 transition-all duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col h-screen overflow-hidden shadow-2xl lg:shadow-none">
    
    <!-- 1. HEADER LOGO -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 h-20 shrink-0">
        <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 overflow-hidden group">
            <div class="relative w-11 h-11 bg-gradient-to-tr from-pink-600 via-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-base shadow-lg shadow-pink-500/30 shrink-0 group-hover:scale-105 transition-transform duration-200">
                <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <i class="fa-solid fa-graduation-cap relative z-10"></i>
            </div>
            <div x-show="!sidebarCollapsed" x-transition.opacity class="flex flex-col">
                <span class="text-base font-black text-slate-800 tracking-tight whitespace-nowrap leading-tight flex items-center gap-1">
                    Digi <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">TEFA</span>
                </span>
                <span class="text-[9px] font-bold text-slate-400 tracking-widest uppercase whitespace-nowrap mt-0.5">
                    Learning System
                </span>
            </div>
        </a>

        <!-- Close Button (Mobile Only) -->
        <button @click="sidebarOpen = false" class="lg:hidden w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- 2. NAVIGATION LINKS (Scrollable Area) -->
    <nav class="flex-1 px-4 py-5 space-y-4 overflow-y-auto custom-scrollbar">
        
        <!-- Link Dashboard (Card Style Utama) -->
        <a href="{{ route('siswa.dashboard') }}" 
           title="Dashboard"
           class="group relative flex items-center justify-between p-3.5 rounded-2xl transition-all duration-200 border {{ request()->routeIs('siswa.dashboard*') ? 'bg-gradient-to-r from-blue-50/80 to-indigo-50/40 border-blue-200 shadow-sm text-blue-700' : 'bg-slate-50/50 hover:bg-slate-100/80 border-slate-200/60 text-slate-700' }}">
            
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm {{ request()->routeIs('siswa.dashboard*') ? 'bg-blue-600 text-white shadow-blue-500/30' : 'bg-white text-blue-600 border border-slate-100' }}">
                    <i class="fa-solid fa-house text-sm"></i>
                </div>
                <div x-show="!sidebarCollapsed" class="flex flex-col min-w-0">
                    <span class="text-sm font-bold tracking-tight whitespace-nowrap">Dashboard</span>
                    <span class="text-[11px] font-medium text-slate-400 truncate">Ringkasan aktivitas Anda</span>
                </div>
            </div>

            <div x-show="!sidebarCollapsed" class="shrink-0 text-slate-400 group-hover:translate-x-0.5 transition-transform">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </div>
        </a>

        <!-- Group PjBL -->
        <div x-data="sidebarInvitation({{ $totalUndangan ?? 0 }})" class="space-y-2">
            
            <p x-show="!sidebarCollapsed" class="px-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">
                Menu Utama
            </p>

            <!-- Card PjBL Utama (Dropdown Trigger) -->
            <button 
                type="button" 
                @click="openPjbl = !openPjbl"
                class="w-full relative flex items-center justify-between p-3.5 rounded-2xl transition-all duration-200 cursor-pointer select-none border {{ request()->routeIs('siswa.pjbl.*') ? 'bg-gradient-to-r from-blue-50/80 to-indigo-50/40 border-blue-200 shadow-sm text-blue-700' : 'bg-slate-50/50 hover:bg-slate-100/80 border-slate-200/60 text-slate-700' }}"
            >
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="relative shrink-0">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm {{ request()->routeIs('siswa.pjbl.*') ? 'bg-blue-600 text-white shadow-blue-500/30' : 'bg-violet-50 text-violet-600 border border-violet-100' }}">
                            <i class="fa-solid fa-diagram-project text-sm"></i>
                        </div>
                        <span 
                            x-show="sidebarCollapsed && count > 0" 
                            x-cloak
                            class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"
                        ></span>
                    </div>

                    <div x-show="!sidebarCollapsed" class="flex flex-col text-left min-w-0">
                        <span class="text-sm font-bold tracking-tight whitespace-nowrap">Pembelajaran PjBL</span>
                        <span class="text-[11px] font-medium text-slate-400 truncate">Proyek dan kolaborasi</span>
                    </div>
                </div>

                <div x-show="!sidebarCollapsed" class="flex items-center gap-2 shrink-0">
                    <span 
                        x-show="count > 0"
                        x-cloak
                        class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"
                    ></span>
                    <i 
                        class="fa-solid fa-chevron-down text-xs transition-transform duration-200 text-slate-400"
                        :class="openPjbl ? 'rotate-180 text-blue-600' : ''"
                    ></i>
                </div>
            </button>

            <!-- Submenu List PjBL dengan Konektor Garis Alur -->
            <div 
                x-show="openPjbl && !sidebarCollapsed" 
                x-collapse
                class="relative pl-6 ml-5 space-y-2.5 border-l-2 border-slate-200/60 my-2"
            >
                <!-- Submenu 1 -->
                <a href="{{ route('siswa.pjbl.dashboard') }}" 
                   class="relative flex items-center justify-between p-2.5 rounded-xl transition-all {{ request()->routeIs('siswa.pjbl.dashboard*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('siswa.pjbl.dashboard*') ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-600' }}">
                            <i class="fa-solid fa-chart-line text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold leading-snug">Dashboard Proyek</span>
                            <span class="text-[10px] opacity-80">Lihat progress proyek</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] opacity-60"></i>
                </a>

                <!-- Submenu 2 -->
                @if(!($isLeader ?? false))
                <a href="{{ route('siswa.pjbl.invitation.index') }}" 
                   class="relative flex items-center justify-between p-2.5 rounded-xl transition-all {{ request()->routeIs('siswa.pjbl.invitation.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('siswa.pjbl.invitation.*') ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-600' }}">
                            <i class="fa-solid fa-users text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold leading-snug">Undangan Proyek</span>
                            <span class="text-[10px] opacity-80">Kelola undangan</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span x-show="count > 0" x-cloak class="px-1.5 py-0.5 bg-rose-500 text-white text-[9px] rounded-full font-black animate-pulse" x-text="count"></span>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-60"></i>
                    </div>
                </a>
                @endif

                <!-- Submenu 3 -->
                <a href="{{ route('siswa.sertifikat.index') }}" 
                   class="relative flex items-center justify-between p-2.5 rounded-xl transition-all {{ request()->routeIs('siswa.sertifikat.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('siswa.sertifikat.*') ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-600' }}">
                            <i class="fa-solid fa-award text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold leading-snug">Sertifikat Capaian</span>
                            <span class="text-[10px] opacity-80">Lihat sertifikat proyek</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] opacity-60"></i>
                </a>
            </div>

        </div>

        <!-- Card Pembelajaran TEFA / Digi TEFA (Dropdown) -->
        <div x-data="{ openTefa: {{ request()->routeIs('siswa.tefa.*') ? 'true' : 'false' }} }" class="space-y-2">
            
            @php
                // Menghitung jumlah undangan TEFA yang masih pending untuk user yang login
                $pendingUndanganCount = \App\Models\TefaMember::where('user_id', auth()->id())
                    ->where('is_leader', false)
                    ->where('status', 'pending')
                    ->count();
            @endphp

            <button 
                type="button" 
                @click="openTefa = !openTefa"
                class="w-full relative flex items-center justify-between p-3.5 rounded-2xl transition-all duration-200 cursor-pointer select-none border {{ request()->routeIs('siswa.tefa.*') ? 'bg-gradient-to-r from-pink-50/80 to-rose-50/40 border-pink-200 shadow-sm text-rose-700' : 'bg-slate-50/50 hover:bg-slate-100/80 border-slate-200/60 text-slate-700' }}"
            >
                <div class="flex items-center gap-3.5 min-w-0">
                    <!-- Icon dengan Indikator Titik Merah Berkedip -->
                    <div class="relative w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm bg-rose-50 text-rose-600 border border-rose-100">
                        <i class="fa-solid fa-folder-open text-sm"></i>
                        
                        @if($pendingUndanganCount > 0)
                            <!-- Titik merah berkedip halus (animate-pulse) -->
                            <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                                <span class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-600 border-2 border-white"></span>
                            </span>
                        @endif
                    </div>

                    <div x-show="!sidebarCollapsed" class="flex flex-col text-left min-w-0">
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm font-bold tracking-tight whitespace-nowrap">Pembelajaran TEFA</span>
                            
                            <!-- Badge angka opsional di sebelah teks jika ada undangan -->
                            @if($pendingUndanganCount > 0)
                                <span class="px-1.5 py-0.2 text-[9px] bg-rose-500 text-white rounded-full font-extrabold animate-pulse">
                                    {{ $pendingUndanganCount }}
                                </span>
                            @endif
                        </div>
                        <span class="text-[11px] font-medium text-slate-400 truncate">Materi dan aktivitas TEFA</span>
                    </div>
                </div>

                <div x-show="!sidebarCollapsed" class="flex items-center gap-2 shrink-0 text-slate-400">
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="openTefa ? 'rotate-180 text-rose-600' : ''"></i>
                </div>
            </button>


            <!-- Submenu TEFA -->
            <div x-show="openTefa && !sidebarCollapsed" x-collapse class="relative pl-6 ml-5 space-y-2.5 border-l-2 border-slate-200/60 my-2">
                
                <!-- Submenu 1: Dashboard TEFA -->
                <a href="{{ route('siswa.tefa') }}" 
                class="relative flex items-center justify-between p-2.5 rounded-xl transition-all {{ request()->routeIs('siswa.tefa*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('siswa.tefa.*') ? 'bg-white/20 text-white' : 'bg-rose-50 text-rose-600' }}">
                            <i class="fa-solid fa-chart-pie text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold leading-snug">Dashboard TEFA</span>
                            <span class="text-[10px] {{ request()->routeIs('siswa.tefa*') ? 'text-blue-100' : 'text-slate-400' }}">Ringkasan Kegiatan TEFA</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('siswa.tefa*') ? 'text-white/70' : 'text-slate-400' }}"></i>
                </a>

                <!-- Submenu 2: Undangan TEFA -->
                <a href="{{ route('siswa.invitations') }}" 
                class="relative flex items-center justify-between p-2.5 rounded-xl transition-all {{ request()->routeIs('siswa.invitations*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}">
                    
                    <div class="flex items-center gap-3">
                        <!-- Icon dengan Indikator Titik Merah Berkedip -->
                        <div class="relative w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('siswa.invitations*') ? 'bg-white/20 text-white' : 'bg-indigo-50 text-indigo-600' }}">
                            <i class="fa-solid fa-envelope-open-text text-xs"></i>
                            
                            @php
                                $pendingCount = \App\Models\TefaMember::where('user_id', auth()->id())
                                    ->where('is_leader', false)
                                    ->where('status', 'pending')
                                    ->count();
                            @endphp

                            @if($pendingCount > 0)
                                <!-- Titik merah dengan efek kedip halus (animate-pulse) -->
                                <span class="absolute -top-0.5 -right-0.5 flex h-2.5 w-2.5">
                                    <span class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-600"></span>
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-col">
                            <span class="text-xs font-bold leading-snug flex items-center gap-1.5">
                                Undangan TEFA
                                
                                @if($pendingCount > 0)
                                    <span class="px-1.5 py-0.2 text-[9px] bg-rose-500 text-white rounded-full font-extrabold animate-pulse">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </span>
                            <span class="text-[10px] {{ request()->routeIs('siswa.invitations*') ? 'text-blue-100' : 'text-slate-400' }}">Kelola undangan unit</span>
                        </div>
                    </div>

                    <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('siswa.invitations*') ? 'text-white/70' : 'text-slate-400' }}"></i>
                </a>

                <!-- Submenu 3: Sertifikat Capaian -->
                <a href="#" 
                class="relative flex items-center justify-between p-2.5 rounded-xl transition-all {{ request()->routeIs('') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('') ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-600' }}">
                            <i class="fa-solid fa-certificate text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold leading-snug">Sertifikat Capaian</span>
                            <span class="text-[10px] {{ request()->routeIs('') ? 'text-blue-100' : 'text-slate-400' }}">Capaian kompetensi TEFA</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] {{ request()->routeIs('') ? 'text-white/70' : 'text-slate-400' }}"></i>
                </a>

            </div>

        </div>

        <!-- Section Penilaian & Evaluasi -->
        <div class="space-y-2 pt-2">
            <p x-show="!sidebarCollapsed" class="px-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">
                Penilaian & Evaluasi
            </p>

            <a href="{{ route('siswa.sertifikat.index') }}" 
               title="Sertifikasi"
               class="group relative flex items-center justify-between p-3.5 rounded-2xl transition-all duration-200 border {{ request()->routeIs('siswa.sertifikasi*') ? 'bg-gradient-to-r from-emerald-50/80 to-teal-50/40 border-emerald-200 shadow-sm text-emerald-700' : 'bg-slate-50/50 hover:bg-slate-100/80 border-slate-200/60 text-slate-700' }}">
                
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm {{ request()->routeIs('siswa.sertifikasi*') ? 'bg-emerald-600 text-white shadow-emerald-500/30' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                        <i class="fa-solid fa-clipboard-check text-sm"></i>
                    </div>
                    <div x-show="!sidebarCollapsed" class="flex flex-col min-w-0">
                        <span class="text-sm font-bold tracking-tight whitespace-nowrap">Sertifikasi</span>
                        <span class="text-[11px] font-medium text-slate-400 truncate">Kelola sertifikat kompetensi</span>
                    </div>
                </div>

                <div x-show="!sidebarCollapsed" class="shrink-0 text-slate-400 group-hover:translate-x-0.5 transition-transform">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </div>
            </a>
        </div>

    </nav>

    <!-- 3. FOOTER STICKY (Banner Bantuan Proyek) -->
    <div class="p-4 border-t border-slate-100 shrink-0 bg-white/60 backdrop-blur-md">
        
        <!-- Widget Banner saat Sidebar Terbuka/Expanded -->
        <div x-show="!sidebarCollapsed" x-transition.opacity>
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-900 p-4 text-white shadow-xl shadow-blue-500/20">
                <!-- Elemen Cahaya Dekoratif Latar Belakang -->
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-blue-400/20 rounded-full blur-xl pointer-events-none"></div>

                <div class="relative z-10 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center text-amber-300 text-sm border border-white/10 shadow-inner">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <i class="fa-solid fa-sparkles text-amber-200/60 text-xs"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white tracking-tight">Butuh Bantuan Proyek?</h4>
                        <p class="text-[11px] text-blue-100/80 leading-relaxed mt-0.5">
                            Pelajari panduan PjBL atau hubungi instruktur Anda.
                        </p>
                    </div>
                    <a href="" class="inline-flex items-center justify-center gap-1.5 w-full py-2 px-3 bg-white text-slate-900 hover:bg-blue-50 rounded-xl text-xs font-bold transition-all shadow-md active:scale-[0.98]">
                        <i class="fa-solid fa-book-open text-[11px] text-blue-600"></i>
                        <span>Buka Panduan</span>
                        <i class="fa-solid fa-chevron-right text-[9px] text-slate-400 ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mini Icon saat Sidebar Collapse -->
        <div x-show="sidebarCollapsed" x-transition.opacity class="flex justify-center py-1">
            <a href="" title="Pusat Bantuan & Panduan" class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-md">
                <i class="fa-solid fa-circle-question text-lg"></i>
            </a>
        </div>

    </div>

</aside>

<!-- Alpine Data Handler -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sidebarInvitation', (initialCount = 0) => ({
            openPjbl: {{ request()->routeIs('siswa.pjbl.*') ? 'true' : 'false' }},
            count: initialCount,
            
            init() {
                if (typeof window.Echo !== 'undefined' && {{ auth()->check() ? 'true' : 'false' }}) {
                    window.Echo.private(`user.{{ auth()->id() }}`)
                        .listen('InvitationReceived', (e) => {
                            this.count = e.newCount;
                        });
                }
            }
        }));
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
</style>