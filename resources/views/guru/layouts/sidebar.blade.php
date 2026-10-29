<!-- Mobile Overlay Backdrop -->
<div x-show="mobileOpen" 
     @click="mobileOpen = false" 
     x-cloak
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 lg:hidden"></div>

<!-- Sidebar Container -->
<aside :class="{
            'translate-x-0': mobileOpen, 
            '-translate-x-full': !mobileOpen,
            'lg:w-64': sidebarOpen,
            'lg:w-20': !sidebarOpen
       }" 
       class="fixed inset-y-0 left-0 bg-white border-r border-slate-100 flex flex-col justify-between z-50 transition-all duration-300 ease-in-out lg:translate-x-0">

    <!-- Top Brand & Menu Section -->
    <div class="p-4 space-y-6 overflow-y-auto overflow-x-hidden">

        <!-- Logo Brand -->
        <a href="#" class="flex items-center gap-3 px-2">
            <div class="w-9 h-9 shrink-0 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-500/20">
                <i class="fa-solid fa-award text-base"></i>
            </div>
            <span x-show="sidebarOpen" x-cloak class="text-base font-extrabold text-slate-800 tracking-tight whitespace-nowrap">
                Certi<span class="text-blue-600">Learn</span>
            </span>
        </a>

        <!-- Menu Group 1: Utama -->
        <div class="space-y-1">
            <span x-show="sidebarOpen" x-cloak class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Utama</span>

            <!-- Dashboard -->
            <a href="/Guru/Dashboard" 
               title="Dashboard TEFA/PjBL"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs transition {{ request()->is('Guru/Dashboard*') ? 'font-semibold text-blue-600 bg-blue-50' : 'font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid fa-chart-pie text-sm shrink-0 {{ request()->is('Guru/Dashboard*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span x-show="sidebarOpen" x-cloak class="whitespace-nowrap">Dashboard TEFA/PjBL</span>
            </a>

            <!-- Pembelajaran PjBL (Dropdown) -->
            <div x-data="{ open: {{ request()->is('Guru/PJBL*') || request()->is('Guru/PjBL*') ? 'true' : 'false' }} }" class="space-y-1">
                <!-- Main Button -->
                <button @click="if(!sidebarOpen) { sidebarOpen = true; open = true; } else { open = !open }" 
                        type="button" 
                        title="Pembelajaran PjBL @if(($invitationCount ?? 0) > 0) ({{ $invitationCount }} Undangan Baru) @endif"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition select-none relative group {{ request()->is('Guru/PJBL*') || request()->is('Guru/PjBL*') ? 'font-semibold text-blue-600 bg-blue-50/70' : 'font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <i class="fa-solid fa-diagram-project text-sm shrink-0 {{ request()->is('Guru/PJBL*') || request()->is('Guru/PjBL*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            
                            {{-- Dot Notifikasi Kecil pada Icon jika Sidebar Terlipat (!sidebarOpen) --}}
                            @if(($invitationCount ?? 0) > 0)
                                <span x-show="!sidebarOpen" x-cloak class="absolute -top-1 -right-1 flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                </span>
                            @endif
                        </div>

                        <span x-show="sidebarOpen" x-cloak class="whitespace-nowrap">Pembelajaran PjBL</span>
                    </div>

                    {{-- Sisi Kanan: Dot Notifikasi + Chevron (Tampil Saat Sidebar Terbuka) --}}
                    <div x-show="sidebarOpen" x-cloak class="flex items-center gap-2">
                        {{-- Dot Merah Ping hanya tampil jika ada undangan masuk (> 0) --}}
                        @if(($invitationCount ?? 0) > 0)
                            <span class="flex h-2 w-2 relative" title="{{ $invitationCount }} Undangan Masuk">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                            </span>
                        @endif

                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180 text-blue-600' : 'text-slate-400'"></i>
                    </div>
                </button>

                <!-- Sub-Menu -->
                <div x-show="open && sidebarOpen" x-cloak class="pl-9 pr-1 space-y-1 pt-0.5">
                    <a href="/Guru/PjBL/Dashboard" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs transition {{ request()->is('Guru/PjBL/Dashboard*') ? 'font-semibold text-blue-600 bg-blue-50' : 'font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span class="whitespace-nowrap">Dashboard Proyek</span>
                    </a>
                    
                    <a href="/Guru/PjBL/Undangan" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs transition {{ request()->is('Guru/PjBL/Undangan*') ? 'font-semibold text-blue-600 bg-blue-50' : 'font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span class="whitespace-nowrap">Undangan Proyek</span>
                        
                        {{-- Badge Angka Notifikasi --}}
                        @if(($invitationCount ?? 0) > 0)
                            <span class="px-1.5 py-0.5 bg-rose-500 text-white font-bold text-[10px] rounded-full min-w-[18px] text-center animate-pulse">
                                {{ $invitationCount > 99 ? '99+' : $invitationCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Pembelajaran TEFA -->
            <div x-data="{ openTefa: {{ request()->routeIs('guru.tefa.*') ? 'true' : 'false' }} }" class="space-y-1">
                
                <!-- Tombol Utama Dropdown TEFA (Guru) -->
                <button 
                    type="button" 
                    @click="openTefa = !openTefa"
                    class="w-full relative flex items-center justify-between p-2.5 rounded-xl transition-all duration-200 cursor-pointer select-none border {{ request()->routeIs('guru.tefa.*') ? 'bg-gradient-to-r from-purple-50/80 to-indigo-50/40 border-purple-200 shadow-sm text-purple-700 font-bold' : 'bg-white hover:bg-slate-100/80 text-slate-600 border border-slate-100' }}"
                >
                    <div class="flex items-center gap-3 min-w-0">
                        <!-- Ikon Utama -->
                        <div class="relative w-7 h-7 rounded-lg flex items-center justify-center shrink-0 {{ request()->routeIs('guru.tefa.*') ? 'bg-purple-600 text-white shadow-sm' : 'bg-purple-50 text-purple-600' }}">
                            <i class="fa-solid fa-industry text-xs"></i>
                        </div>

                        <div x-show="sidebarOpen" x-cloak class="flex flex-col text-left min-w-0">
                            <span class="text-xs font-bold leading-snug whitespace-nowrap">Pembelajaran TEFA</span>
                            <span class="text-[10px] font-normal text-slate-400">Unit & Aktivitas TEFA</span>
                        </div>
                    </div>

                    <div x-show="sidebarOpen" x-cloak class="shrink-0 text-slate-400">
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="openTefa ? 'rotate-180 text-purple-600' : ''"></i>
                    </div>
                </button>

                <!-- Sub-Menu Dropdown (Dashboard TEFA & Undangan/Monitoring) -->
                <div x-show="sidebarOpen && openTefa" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="pl-4 space-y-1 pt-1">
                    
                    <!-- 1. Sub-Menu: Dashboard TEFA -->
                    <a href="{{ route('guru.tefa.dashboard') }}" 
                    class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-all {{ request()->routeIs('guru.tefa.dashboard*') ? 'bg-purple-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:bg-slate-100/80' }}">
                        <i class="fa-solid fa-chart-pie text-[11px] {{ request()->routeIs('guru.tefa.dashboard*') ? 'text-white' : 'text-purple-500' }}"></i>
                        <span class="truncate">Dashboard TEFA</span>
                    </a>

                    <!-- 2. Sub-Menu: Undangan / Kelola Tim TEFA -->
                    <a href="{{route('guru.tefa.undangan.index')}}" 
                    class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium transition-all {{ request()->routeIs('guru.tefa.undangan*') ? 'bg-purple-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i class="fa-solid fa-envelope-open-text text-[11px] {{ request()->routeIs('guru.tefa.undangan*') ? 'text-white' : 'text-purple-500' }}"></i>
                            <span class="truncate">Undangan / Tim</span>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <!-- Menu Group 2: Asesmen & Lisensi -->
        <div class="space-y-1">
            <span x-show="sidebarOpen" x-cloak class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Asesmen & Lisensi</span>

            <div x-data="{ open: {{ request()->routeIs('guru.kompetensi.pjbl.*') || request()->is('Guru/Kompetensi*') ? 'true' : 'false' }} }" class="space-y-1">
                
                <!-- Tombol Utama Parent Menu -->
                <button @click="if(!sidebarOpen) { sidebarOpen = true; open = true; } else { open = !open }" 
                        type="button" 
                        title="Penentuan Kompetensi"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition select-none {{ request()->routeIs('guru.kompetensi.pjbl.*') || request()->is('Guru/Kompetensi*') ? 'font-semibold text-blue-600 bg-blue-50/70' : 'font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-check text-sm shrink-0 {{ request()->routeIs('guru.kompetensi.pjbl.*') || request()->is('Guru/Kompetensi*') ? 'text-blue-600' : 'text-slate-500' }}"></i>
                        <span x-show="sidebarOpen" x-cloak class="whitespace-nowrap">Penentuan Kompetensi</span>
                    </div>

                    <div x-show="sidebarOpen" x-cloak class="flex items-center gap-2">
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180 text-blue-600' : 'text-slate-500'"></i>
                    </div>
                </button>

                <!-- Sub-menu Items -->
                <div x-show="open && sidebarOpen" x-collapse x-cloak class="pl-9 pr-1 space-y-1 pt-0.5">
                    
                    <a href="{{ route('guru.kompetensi.pjbl.index') }}" 
                    class="flex items-center justify-between px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('guru.kompetensi.pjbl.*') ? 'font-semibold text-blue-600 bg-blue-50' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <span class="whitespace-nowrap">Kompetensi PjBL</span>
                    </a>

                    <!-- Link Kompetensi TEFA -->
                    <div title="Kompetensi TEFA (Terkunci)"
                        class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium text-slate-400 bg-slate-50/50 cursor-not-allowed select-none opacity-70">
                        <span class="whitespace-nowrap">Kompetensi TEFA</span>
                        <i class="fa-solid fa-lock text-[10px] text-slate-400 ml-2 shrink-0"></i>
                    </div>

                </div>
            </div>

            <a href="{{ route('guru.sertifikat.index') }}" 
            title="Penerbitan Sertifikat"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('guru.sertifikat.*') ? 'font-semibold text-blue-600 bg-blue-50' : 'font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid fa-certificate text-sm shrink-0 {{ request()->routeIs('guru.sertifikat.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span x-show="sidebarOpen" x-cloak class="whitespace-nowrap">Penerbitan Sertifikat</span>
            </a>

        </div>

    </div>


</aside>