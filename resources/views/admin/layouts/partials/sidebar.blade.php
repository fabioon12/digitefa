<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 bg-white border-r border-slate-100 h-screen flex flex-col justify-between p-4 select-none transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    
    <div class="overflow-y-auto pr-1">
        <!-- Header Logo -->
        <div class="flex items-center justify-between px-3 py-2 mb-6">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 text-white p-2.5 rounded-xl shadow-md flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 tracking-tight leading-none">CertiLearn</h2>
                    <span class="text-[10px] text-slate-400 font-medium">Sertifikasi Kompetensi</span>
                </div>
            </div>
            <!-- Tombol Close Khusus Mobile -->
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Menu Navigasi -->
        <nav class="space-y-1">
            {{-- Dashboard --}}
            <a href="{{ url('/admin/dashboard') }}" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition {{ request()->is('admin/dashboard*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                <i class="fa-solid fa-house text-sm"></i>
                <span>Dashboard</span>
            </a>

            {{-- Manajemen Industri --}}
            <div x-data="{ open: {{ request()->is('admin/manajemen-industri*') ? 'true' : 'false' }} }" class="space-y-1">
                
                <!-- Tombol Utama / Parent Dropdown -->
                <button type="button" @click="open = !open" 
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs transition-all duration-200 {{ request()->is('Admin/Manajemen-Industri*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                    
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-industry text-sm"></i>
                        <span>Manajemen Industri</span>
                    </div>
                        <div class="flex items-center gap-2">
                            @php $industriNotif = $pendingIndustriCount ?? 0; @endphp
                            @if($industriNotif > 0)
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                                </span>
                            @endif

                            <!-- Panah Indikator -->
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </div>
                </button>

                <!-- Container Sub-Menu -->
                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 -translate-y-2"
                    x-transition:enter-end="transform opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 -translate-y-2"
                    class="pl-7 space-y-1 pt-1">
                    
                    <!-- OPSI 1: Dashboard Manajemen Industri -->
                    <a href="{{ url('/admin/manajemen-industri/dashboard') }}" 
                        class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-industri/dashboard*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                        <i class="fa-solid fa-gauge-high text-[11px]"></i>
                        <span>Data Industri</span>
                    </a>

                    <!-- OPSI 2: Verifikasi Akun Industri -->
                    <a href="{{ url('/admin/manajemen-industri/verifikasi-akun') }}" 
                        class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-industri/verifikasi-akun*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                        
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-user-check text-[11px]"></i>
                            <span>Verifikasi Akun</span>
                        </div>

                        <!-- Badge Notifikasi Angka Dinamis -->
                        @if($pendingIndustriCount > 0)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full transition-all duration-200 {{ request()->is('admin/manajemen-industri/verifikasi-akun*') ? 'bg-white text-blue-600' : 'bg-amber-500 text-white' }}">
                                {{ $pendingIndustriCount }}
                            </span>
                        @endif
                    </a>

                </div>
            </div>
            {{-- Manajemen Guru --}}
            <div x-data="{ open: {{ request()->is('admin/manajemen-guru*') ? 'true' : 'false' }} }" class="space-y-1">
    
                    <!-- Tombol Utama / Parent Dropdown -->
                    <button type="button" @click="open = !open" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-guru*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                        
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-chalkboard-user text-sm"></i>
                            <span>Manajemen Guru</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Indikator / Badge Notifikasi Merah di Parent (Muncul saat ada notif) -->
                            @php $guruNotif = $pendingGuruCount ?? 0; @endphp
                            @if($guruNotif > 0)
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                                </span>
                            @endif

                            <!-- Panah Indikator -->
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </div>
                    </button>

                    <!-- Container Sub-Menu -->
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 -translate-y-2"
                        x-transition:enter-end="transform opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 translate-y-0"
                        x-transition:leave-end="transform opacity-0 -translate-y-2"
                        class="pl-7 space-y-1 pt-1" x-cloak>
                        
                        <!-- OPSI 1: Data / Dashboard Guru -->
                        <a href="{{ url('/admin/manajemen-guru/dashboard') }}" 
                            class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-guru/dashboard*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                            <i class="fa-solid fa-users text-[11px]"></i>
                            <span>Data Guru</span>
                        </a>

                        <!-- OPSI 2: Verifikasi Akun Guru (Dengan Badge Angka Merah) -->
                        <a href="{{ url('/admin/manajemen-guru/verifikasi-akun') }}" 
                            class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-guru/verifikasi-akun*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                            
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-user-clock text-[11px]"></i>
                                <span>Verifikasi Guru</span>
                            </div>

                            <!-- Badge Angka Notifikasi Merah -->
                            @if($guruNotif > 0)
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full transition-all duration-200 {{ request()->is('admin/manajemen-guru/verifikasi-akun*') ? 'bg-white text-rose-600' : 'bg-rose-500 text-white' }}">
                                    {{ $guruNotif }}
                                </span>
                            @endif
                        </a>

                    </div>
            </div>

            {{-- Manajemen Siswa --}}
            <div x-data="{ open: {{ request()->is('admin/manajemen-siswa*') ? 'true' : 'false' }} }" class="space-y-1">
                
                <!-- Tombol Utama / Parent Dropdown -->
                <button type="button" @click="open = !open" 
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs transition-all duration-200 {{ request()->is('Admin/Manajemen-Siswa*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                    
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap text-sm"></i>
                        <span>Manajemen Siswa</span>
                    </div>

                    <div class="flex items-center gap-2">
                            @php $siswaNotif = $pendingSiswaCount ?? 0; @endphp
                            @if($siswaNotif > 0)
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                                </span>
                            @endif

                            <!-- Panah Indikator -->
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </div>
                </button>

                <!-- Container Sub-Menu -->
                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 -translate-y-2"
                    x-transition:enter-end="transform opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 -translate-y-2"
                    class="pl-7 space-y-1 pt-1">
                    
                    <!-- Dashboard Manajemen Siswa -->
                    <a href="{{ url('/admin/manajemen-siswa/dashboard') }}" 
                        class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-siswa/dashboard*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                        <i class="fa-solid fa-gauge-high text-[11px]"></i>
                        <span>Data Siswa</span>
                    </a>

                    <!-- Verifikasi Akun Siswa -->
                    <a href="{{ url('/admin/manajemen-siswa/verifikasi-akun') }}" 
                        class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs transition-all duration-200 {{ request()->is('admin/manajemen-siswa/verifikasi-akun*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                        
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-user-check text-[11px]"></i>
                            <span>Verifikasi Akun</span>
                        </div>

                        <!-- Badge Notifikasi Angka Dinamis -->
                        @if($pendingSiswaCount > 0)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full transition-all duration-200 {{ request()->is('admin/manajemen-siswa/verifikasi-akun*') ? 'bg-white text-blue-600' : 'bg-amber-500 text-white' }}">
                            {{ $pendingSiswaCount }}
                            </span>
                        @endif
                    </a>

                </div>
            </div>

            {{-- Pembelajaran PjBL --}}
            <a href="{{ url('/Admin/PjBL') }}" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition {{ request()->is('Admin/PjBL*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                <i class="fa-regular fa-folder-open text-sm"></i>
                <span>Pembelajaran PjBL</span>
            </a>

            {{-- Pembelajaran TEFA --}}
            <a href="{{ url('/Admin/Tefa') }}" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition {{ request()->is('Admin/Tefa*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                <i class="fa-regular fa-file-lines text-sm"></i>
                <span>Pembelajaran TEFA</span>
            </a>

            {{-- Kompetensi --}}
            <a href="{{ url('/Admin/Kompetensi') }}" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition {{ request()->is('Admin/Kompetensi*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                <i class="fa-regular fa-circle-check text-sm"></i>
                <span>Kompetensi</span>
            </a>

            {{-- Sertifikat --}}
            <a href="{{ url('/Admin/Sertifikasi') }}" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition {{ request()->is('Admin/Sertifikasi*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                <i class="fa-regular fa-id-card text-sm"></i>
                <span>Sertifikat</span>
            </a>

            {{-- Template Sertifikat --}}
            <a href="{{ route('admin.certificate-templates.index') }}" 
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition {{ request()->is('Admin/Template*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50 font-medium' }}">
                <i class="fa-regular fa-copy text-sm"></i>
                <span>Template Sertifikat</span>
            </a>

        </nav>
    </div>

    <!-- Widget Bawah -->
    <div class="mt-4 bg-gradient-to-b from-blue-50/70 to-blue-50/30 border border-blue-100 rounded-2xl p-4 text-center shrink-0">
        <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-blue-100 flex items-center justify-center mx-auto mb-3 text-blue-600">
            <i class="fa-solid fa-shield-halved text-base"></i>
        </div>
        <h4 class="text-xs font-bold text-slate-800 mb-1">Verifikasi Sertifikat</h4>
        <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Cek keaslian sertifikat dengan mudah.</p>
        <a href="#" class="inline-flex items-center justify-center gap-1.5 w-full py-2 bg-white hover:bg-blue-600 hover:text-white border border-blue-200 text-blue-600 text-[11px] font-semibold rounded-xl shadow-sm transition">
            <span>Buka Verifikasi</span>
            <i class="fa-solid fa-arrow-right text-[9px]"></i>
        </a>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const header = document.getElementById('mainHeader');
        const mainContent = document.getElementById('mainContent');

        const isDesktop = window.innerWidth >= 1024;

        if (isDesktop) {
            // Sembunyikan/Tampilkan Sidebar di Desktop
            sidebar.classList.toggle('lg:-translate-x-full');
            
            // Geser Header dan Content ke Kiri/Kanan di Desktop
            if (header) header.classList.toggle('lg:ml-64');
            if (mainContent) mainContent.classList.toggle('lg:ml-64');
        } else {
            // Sembunyikan/Tampilkan Sidebar di Mobile
            sidebar.classList.toggle('-translate-x-full');
            if (overlay) overlay.classList.toggle('hidden');
        }
    }
</script>