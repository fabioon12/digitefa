                <div class="flex items-center gap-3 sm:gap-4">

                    @php
                        // Data pendaftaran pending awal dari database (termasuk industri)
                        $pendingUsers = \App\Models\User::where('status', 'pending')
                            ->whereIn('role', ['siswa', 'guru', 'industri'])
                            ->latest()
                            ->take(5)
                            ->get();

                        $pendingCount = \App\Models\User::where('status', 'pending')
                            ->whereIn('role', ['siswa', 'guru', 'industri'])
                            ->count();
                    @endphp

                    <div class="relative" x-data="{ 
                        open: false,
                        unreadCount: {{ $pendingCount }},
                        realtimeNotifications: [],
                        init() {
                            if (typeof window.Echo !== 'undefined') {
                                window.Echo.channel('admin-notifications')
                                    .listen('.user.mendaftar', (e) => {
                                        this.unreadCount++;
                                        const role = e.user.role;
                                        
                                        // Opsi Judul & URL berdasarkan Role
                                        let title = 'Pendaftaran Baru';
                                        let url = '#';

                                        if (role === 'siswa') {
                                            title = 'Pendaftaran Siswa Baru';
                                            url = '{{ route("admin.verifikasi.siswa") }}';
                                        } else if (role === 'guru') {
                                            title = 'Pendaftaran Guru Baru';
                                            url = '{{ route("admin.verifikasi.guru") }}';
                                        } else if (role === 'industri') {
                                            title = 'Pendaftaran Industri Baru';
                                            url = '{{ route("admin.manajemen-industri.dashboard") }}';
                                        }

                                        this.realtimeNotifications.unshift({
                                            id: Date.now(),
                                            title: title,
                                            message: (role === 'industri' ? (e.user.company_name || e.user.name) : e.user.name) + ' menunggu verifikasi',
                                            role: role,
                                            time: 'Baru saja',
                                            url: url
                                        });
                                    });
                            }
                        }
                    }">
                        <!-- Tombol Bell Notifikasi -->
                        <button @click="open = !open" @click.away="open = false" type="button" 
                            class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-50 rounded-xl transition">
                            <i class="fa-regular fa-bell text-base"></i>
                            
                            <!-- Badge Jumlah Notifikasi -->
                            <template x-if="unreadCount > 0">
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center border-2 border-white" x-text="unreadCount"></span>
                            </template>
                        </button>

                        <!-- Dropdown Container -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden"
                            style="display: none;">
                            
                            <!-- Header Dropdown -->
                            <div class="p-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                <h5 class="text-xs font-bold text-slate-800">Notifikasi</h5>
                                <span class="text-[10px] bg-blue-50 text-blue-600 font-semibold px-2 py-0.5 rounded-full" x-text="unreadCount + ' Baru'"></span>
                            </div>

                            <!-- List Notifikasi -->
                            <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                                
                                <!-- 1. Notifikasi Realtime via Reverb/Echo -->
                                <template x-for="notif in realtimeNotifications" :key="notif.id">
                                    <a :href="notif.url" class="flex gap-3 p-3 bg-blue-50/30 hover:bg-slate-50 transition">
                                        <div :class="{
                                                'bg-amber-50 text-amber-500': notif.role === 'siswa',
                                                'bg-blue-50 text-blue-500': notif.role === 'guru',
                                                'bg-purple-50 text-purple-600': notif.role === 'industri'
                                            }" 
                                            class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0">
                                            <i :class="{
                                                'fa-user-clock': notif.role === 'siswa',
                                                'fa-user-tie': notif.role === 'guru',
                                                'fa-building': notif.role === 'industri'
                                            }" class="fa-solid text-xs"></i>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-xs font-semibold text-slate-700" x-text="notif.title"></p>
                                            <p class="text-[10px] text-slate-400 mt-0.5" x-text="notif.message"></p>
                                            <span class="text-[9px] text-blue-500 font-medium mt-1 block" x-text="notif.time"></span>
                                        </div>
                                    </a>
                                </template>

                                <!-- 2. Data Notifikasi Awal dari Database -->
                                @forelse ($pendingUsers as $pending)
                                    @php
                                        $role = $pending->role;
                                        $title = 'Pendaftaran Baru';
                                        $url = '#';
                                        $icon = 'fa-user-clock';
                                        $colorClass = 'bg-amber-50 text-amber-500';

                                        if ($role === 'siswa') {
                                            $title = 'Pendaftaran Siswa Baru';
                                            $url = route('admin.verifikasi.siswa');
                                            $icon = 'fa-user-clock';
                                            $colorClass = 'bg-amber-50 text-amber-500';
                                        } elseif ($role === 'guru') {
                                            $title = 'Pendaftaran Guru Baru';
                                            $url = route('admin.verifikasi.guru');
                                            $icon = 'fa-user-tie';
                                            $colorClass = 'bg-blue-50 text-blue-500';
                                        } elseif ($role === 'industri') {
                                            $title = 'Pendaftaran Industri Baru';
                                            $url = route('admin.manajemen-industri.dashboard', ['status' => 'pending']);
                                            $icon = 'fa-building';
                                            $colorClass = 'bg-purple-50 text-purple-600';
                                        }
                                    @endphp
                                    <a href="{{ $url }}" class="flex gap-3 p-3 hover:bg-slate-50 transition">
                                        <div class="w-8 h-8 rounded-lg {{ $colorClass }} flex items-center justify-center shrink-0">
                                            <i class="fa-solid {{ $icon }} text-xs"></i>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-xs font-semibold text-slate-700">{{ $title }}</p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">
                                                {{ $role === 'industri' ? ($pending->company_name ?? $pending->name) : $pending->name }} menunggu verifikasi
                                            </p>
                                            <span class="text-[9px] text-slate-300 mt-1 block">{{ $pending->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @empty
                                    <template x-if="realtimeNotifications.length === 0">
                                        <div class="p-6 text-center text-slate-400">
                                            <i class="fa-regular fa-bell-slash text-base mb-1 block"></i>
                                            <span class="text-xs">Tidak ada pendaftaran baru</span>
                                        </div>
                                    </template>
                                @endforelse

                            </div>

                            <!-- Footer Dropdown -->
                            <a href="#" class="block p-2.5 text-center text-[11px] font-semibold text-blue-600 bg-slate-50 hover:bg-slate-100 border-t border-slate-100 transition">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>

                    <!-- 2. DROPDOWN PROFILE SUPER ADMIN -->
                    <div class="relative pl-2 border-l border-slate-100" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" type="button" 
                            class="flex items-center gap-3 p-1 rounded-xl hover:bg-slate-50 transition">
                            <img src="https://ui-avatars.com/api/?name=Super+Admin&background=0D8ABC&color=fff" 
                                alt="Super Admin" 
                                class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100">
                            <div class="hidden sm:block text-left leading-tight">
                                <div class="flex items-center gap-1.5">
                                    <h4 class="text-xs font-bold text-slate-800">Super Admin</h4>
                                    <i class="fa-solid fa-chevron-down text-[9px] text-slate-400"></i>
                                </div>
                                <span class="text-[10px] text-slate-400 font-medium">Administrator</span>
                            </div>
                        </button>

                        <!-- Menu Dropdown Profile -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 p-1.5"
                            style="display: none;">
                            
                            <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-600 font-medium rounded-xl hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-regular fa-user text-slate-400 w-4"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-600 font-medium rounded-xl hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-solid fa-gear text-slate-400 w-4"></i>
                                <span>Pengaturan</span>
                            </a>

                            <div class="my-1 border-t border-slate-100"></div>

                            <!-- Form Logout Laravel -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition">
                                    <i class="fa-solid fa-right-from-bracket text-rose-500 w-4"></i>
                                    <span>Keluar / Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>             