<!-- Sidebar Backdrop untuk Mobile -->
<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

<!-- Sidebar Layout -->
<aside :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:w-64': !sidebarCollapsed,
        'lg:w-20': sidebarCollapsed
    }" 
    class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-100 transition-all duration-300 lg:static lg:translate-x-0 flex flex-col h-screen overflow-hidden">
    
    <!-- Logo / Brand & Mobile Close -->
    <div class="flex items-center justify-between px-5 py-5 border-b border-slate-100/60 h-16 shrink-0">
        <a href="/Industri/PjBL/Dashboard" class="flex items-center gap-3 overflow-hidden">
            <div class="w-9 h-9 bg-gradient-to-tr from-amber-600 to-orange-500 rounded-xl flex items-center justify-center text-white text-sm shadow-md shadow-amber-500/25 shrink-0">
                <i class="fa-solid fa-building"></i>
            </div>
            <span x-show="!sidebarCollapsed" x-transition.opacity class="text-lg font-extrabold text-slate-800 tracking-tight whitespace-nowrap">
                Industri<span class="text-amber-600">Hub</span>
            </span>
        </a>

        <!-- Close Button (Mobile Only) -->
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
        
        <!-- HEADER SECTION: MENU UTAMA -->
        <p x-show="!sidebarCollapsed" x-cloak class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 whitespace-nowrap">
            Menu Utama
        </p>
        
        <!-- 1. Link Dashboard -->
        <a href="/Industri/Dashboard" 
        title="Dashboard"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->is('Industri/Dashboard*') ? 'bg-amber-50 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
            <i class="fa-solid fa-chart-pie text-sm w-5 text-center shrink-0 {{ request()->is('Industri/Dashboard*') ? 'text-amber-600' : 'text-slate-500' }}"></i>
            <span x-show="!sidebarCollapsed" x-cloak class="text-xs whitespace-nowrap">Dashboard</span>
        </a>

        <!-- 2. Dropdown Menu Kerjasama PjBL -->
        <div x-data="{ 
                openPjbl: {{ request()->routeIs('industri.pjbl.*') ? 'true' : 'false' }}, 
                count: {{ $pendingCount ?? 0 }} 
            }" 
            class="space-y-1">

            <button type="button" 
                    @click="if(sidebarCollapsed) { sidebarCollapsed = false; openPjbl = true; } else { openPjbl = !openPjbl }"
                    title="Project & PjBL"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition cursor-pointer select-none {{ request()->routeIs('industri.pjbl.*') ? 'bg-amber-50 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
                
                <div class="flex items-center gap-3 min-w-0">
                    <div class="relative shrink-0">
                        <i class="fa-solid fa-diagram-project text-sm w-5 text-center {{ request()->routeIs('industri.pjbl.*') ? 'text-amber-600' : 'text-slate-500' }}"></i>
                        <!-- Indicator saat Collapsed -->
                        <span x-show="sidebarCollapsed && count > 0" 
                            x-cloak
                            class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                    </div>
                    <span x-show="!sidebarCollapsed" x-cloak class="text-xs whitespace-nowrap">Project & PjBL</span>
                </div>

                <div x-show="!sidebarCollapsed" x-cloak class="flex items-center gap-2">
                    <span x-show="count > 0" 
                        class="w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-rose-200 animate-pulse shrink-0"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"
                    :class="openPjbl ? 'rotate-180 text-amber-600' : 'text-slate-500'"></i>
                </div>
            </button>

            <!-- Submenu PjBL -->
            <div x-show="openPjbl && !sidebarCollapsed" 
                x-collapse 
                x-cloak 
                class="pl-9 pr-1 space-y-1 pt-0.5">
                
                <a href="{{ route('industri.pjbl.dashboard') }}" 
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('industri.pjbl.dashboard*') ? 'bg-amber-100/60 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
                    <i class="fa-solid fa-circle-dot text-[6px] {{ request()->routeIs('industri.pjbl.dashboard*') ? 'text-amber-600' : 'text-slate-400' }}"></i>
                    <span class="whitespace-nowrap">Dashboard Proyek</span>
                </a>

                <a href="{{ route('industri.pjbl.undangan.index') }}" 
                class="flex items-center justify-between px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('industri.pjbl.undangan.*') ? 'bg-amber-100/60 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-dot text-[6px] {{ request()->routeIs('industri.pjbl.undangan.*') ? 'text-amber-600' : 'text-slate-400' }}"></i>
                        <span class="whitespace-nowrap">Undangan Proyek</span>
                    </div>
                    @if(isset($pendingCount) && $pendingCount > 0)
                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-extrabold text-white bg-rose-500 rounded-full min-w-[18px] h-[18px] shadow-xs animate-pulse">
                            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- 3. Link Pembelajaran TEFA -->
        <div title="Teaching Factory (TEFA) - Terkunci"
            class="flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-400 bg-slate-50 cursor-not-allowed opacity-60 select-none">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-industry text-sm w-5 text-center shrink-0 text-slate-400"></i>
                <span x-show="!sidebarCollapsed" x-cloak class="text-xs whitespace-nowrap font-medium">Pembelajaran TEFA</span>
            </div>
            <!-- Icon Gembok indikator terkunci -->
            <i x-show="!sidebarCollapsed" x-cloak class="fa-solid fa-lock text-[10px] text-slate-400"></i>
        </div>

        <!-- HEADER SECTION: PENILAIAN & ASESMEN -->
        <div class="pt-3 pb-1">
            <p x-show="!sidebarCollapsed" x-cloak class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">
                Penilaian & Asesmen
            </p>
        </div>

        <!-- 4. Dropdown Asesmen Siswa -->
        <div x-data="{ openAsesmen: {{ request()->is('Industri/Penilaian*') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" 
                    @click="if(sidebarCollapsed) { sidebarCollapsed = false; openAsesmen = true; } else { openAsesmen = !openAsesmen }"
                    title="Penilaian & Asesmen Siswa"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition cursor-pointer select-none {{ request()->is('Industri/Penilaian*') ? 'bg-amber-50 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
                
                <div class="flex items-center gap-3 min-w-0">
                    <i class="fa-solid fa-user-check text-sm w-5 text-center shrink-0 {{ request()->is('Industri/Penilaian*') ? 'text-amber-600' : 'text-slate-500' }}"></i>
                    <span x-show="!sidebarCollapsed" x-cloak class="text-xs whitespace-nowrap">Asesmen Siswa</span>
                </div>

                <div x-show="!sidebarCollapsed" x-cloak class="flex items-center gap-2">
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" 
                    :class="openAsesmen ? 'rotate-180 text-amber-600' : 'text-slate-500'"></i>
                </div>
            </button>

            <!-- Submenu Asesmen -->
            <div x-show="openAsesmen && !sidebarCollapsed" 
                x-collapse 
                x-cloak 
                class="pl-9 pr-1 space-y-1 pt-0.5">
                
                <a href="{{ route('industri.kompetensi.pjbl.index') }}" 
                class="flex items-center justify-between px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('kompetensi.pjbl.*') ? 'bg-amber-100/60 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
                    <span class="whitespace-nowrap">Kompetensi PjBL</span>
                </a>

                <a href="/Industri/Penilaian/TEFA" 
                class="flex items-center justify-between px-3 py-2 rounded-lg text-xs transition {{ request()->is('Industri/Penilaian/TEFA*') ? 'bg-amber-100/60 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
                    <span class="whitespace-nowrap">Kompetensi TEFA</span>
                </a>
            </div>
        </div>

        <!-- 5. Link Penerbitan Sertifikat -->
        <a href="/Industri/Sertifikasi" 
        title="Sertifikasi Industri"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->is('Industri/Sertifikasi*') ? 'bg-amber-50 text-amber-800 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-semibold' }}">
            <i class="fa-solid fa-award text-sm w-5 text-center shrink-0 {{ request()->is('Industri/Sertifikasi*') ? 'text-amber-600' : 'text-slate-500' }}"></i>
            <span x-show="!sidebarCollapsed" x-cloak class="text-xs whitespace-nowrap">Penerbitan Sertifikat</span>
        </a>

    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-slate-100/60 bg-slate-50/50 shrink-0">
        <a href="/Industri/Bantuan" 
           title="Pusat Bantuan Industri"
           class="flex items-center gap-3 px-2 py-1 text-slate-500 hover:text-amber-700 transition font-medium">
            <i class="fa-regular fa-circle-question w-5 text-center text-base shrink-0"></i>
            <span x-show="!sidebarCollapsed" class="text-xs whitespace-nowrap">Pusat Bantuan & CS</span>
        </a>
    </div>
</aside>

<!-- Script Global Alpine Data -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sidebarPjbl', (initialCount = 0) => ({
            openPjbl: {{ request()->is('Industri/PjBL*') ? 'true' : 'false' }},
            count: initialCount,
            
            init() {
                // Listener Realtime Broadcast jika menggunakan Laravel Echo
                if (typeof window.Echo !== 'undefined' && {{ auth()->check() ? 'true' : 'false' }}) {
                    window.Echo.private(`company.{{ auth()->user()->company_id ?? auth()->id() }}`)
                        .listen('NewProjectRequest', (e) => {
                            this.count = e.newCount;
                        });
                }
            }
        }));
    });
</script>

<!-- Custom Scrollbar Style -->
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #f59e0b; border-radius: 10px; }
</style>