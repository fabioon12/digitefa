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
                    <!-- Wrapper Utama dengan State Alpine.js -->
                    <div x-data="{ openNotification: false, notifCount: {{ $totalNotifGuru ?? 0 }} }" class="relative">

                        <!-- Tombol Lonceng Notifikasi Guru -->
                        <button 
                            @click="openNotification = !openNotification" 
                            @click.outside="openNotification = false"
                            type="button"
                            class="relative p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50/80 rounded-xl transition cursor-pointer focus:outline-none"
                            title="Pengajuan Proyek Masuk"
                        >
                            <i class="fa-regular fa-bell text-lg"></i>
                            
                            <!-- Indicator Pulse Dot -->
                            <template x-if="notifCount > 0">
                                <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500 ring-2 ring-white"></span>
                                </span>
                            </template>
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
                            class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-slate-200/80 z-50 overflow-hidden"
                        >
                            <!-- Header Popover -->
                            <div class="px-4 py-3 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-file-signature text-xs text-amber-600"></i>
                                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Persetujuan Proyek</h3>
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-extrabold rounded-full" x-text="`${notifCount} Perlu ACC`"></span>
                                </div>
                                <button @click="openNotification = false" class="text-slate-400 hover:text-slate-600 text-xs p-1">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <!-- Body Popover / Item List -->
                            <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                                @forelse($notifGuru ?? [] as $project)
                                    <div class="p-4 hover:bg-slate-50/80 transition space-y-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5 border border-amber-100">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-slate-600 leading-relaxed">
                                                    <span class="font-bold text-slate-800">{{ $project->creator->name ?? 'Siswa' }}</span> 
                                                    mengajukan proyek baru <span class="font-bold text-blue-600">"{{ $project->judul }}"</span> 
                                                    dengan tipe <span class="font-semibold text-slate-700 capitalize">{{ $project->tipe }}</span>.
                                                </p>

                                                <!-- Badge Status Kelompok / Individu -->
                                                <div class="mt-1.5 flex items-center gap-2">
                                                    @if($project->tipe === 'kelompok')
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                                            <i class="fa-solid fa-users text-[9px]"></i>
                                                            Tim Lengkap ({{ $project->members->where('status', 'accepted')->count() }}/{{ $project->members->count() }} ACC)
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">
                                                            <i class="fa-solid fa-user text-[9px]"></i>
                                                            Individu
                                                        </span>
                                                    @endif

                                                    <span class="text-[10px] font-medium text-slate-400 flex items-center gap-1">
                                                        <i class="fa-regular fa-clock text-[9px]"></i>
                                                        {{ $project->created_at ? $project->created_at->diffForHumans() : 'Baru saja' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-end gap-2 pl-11">
                                            <!-- Form Tolak Guru -->
                                            <form id="form-reject-guru-{{ $project->id }}" action="{{ route('guru.pjbl.undangan.reject', $project->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="catatan_revisi" id="revisi-{{ $project->id }}">
                                                <button type="button" 
                                                    onclick="popupTolakProyek({{ $project->id }})" 
                                                    class="px-3 py-1.5 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 text-xs font-semibold rounded-lg transition cursor-pointer">
                                                    Tolak
                                                </button>
                                            </form>

                                            <!-- Form Terima (ACC) -->
                                            <form id="form-approve-guru-{{ $project->id }}" action="{{ route('guru.pjbl.undangan.approve', $project->id) }}" method="POST">
                                                @csrf
                                                <button type="button" 
                                                    onclick="prosesApproveProyek({{ $project->id }})"
                                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition cursor-pointer">
                                                    Terima
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Empty State -->
                                    <div class="p-8 text-center space-y-2">
                                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto">
                                            <i class="fa-regular fa-folder-closed text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-700">Tidak ada pengajuan proyek</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Pengajuan proyek baru akan muncul jika seluruh anggota tim telah menyetujui undangan.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="relative pl-2 border-l border-slate-100" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" type="button" 
                            class="flex items-center gap-3 p-1 rounded-xl hover:bg-slate-50 transition">
                            
                            <!-- Foto Profil Dinamis -->
                            @if(auth()->user()->image && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->image))
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                                    alt="{{ auth()->user()->name }}" 
                                    class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" 
                                    alt="{{ auth()->user()->name }}" 
                                    class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100">
                            @endif

                            <!-- Informasi Nama & Mapel Dinamis -->
                            <div class="hidden sm:block text-left leading-tight">
                                <div class="flex items-center gap-1.5">
                                    <h4 class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</h4>
                                    <i class="fa-solid fa-chevron-down text-[9px] text-slate-400"></i>
                                </div>
                                
                                <!-- Menampilkan Mata Pelajaran (jika ada) atau Role -->
                                <span class="text-[10px] text-slate-400 font-medium">
                                    {{ auth()->user()->subject ? 'Guru ' . auth()->user()->subject : 'Guru' }}
                                </span>
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
                            
                            <a href="{{ route('guru.profile.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs text-slate-600 font-medium rounded-xl hover:bg-slate-50 hover:text-blue-600 transition">
                                <i class="fa-regular fa-user text-slate-400 w-4"></i>
                                <span>Profil Saya</span>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            </script>
        @endif

        <script>
        // Fungsi Tolak Proposal
        function popupTolakProyek(projectId) {
            Swal.fire({
                title: 'Tolak Proposal Proyek',
                text: 'Masukkan catatan revisi untuk siswa:',
                input: 'textarea',
                inputPlaceholder: 'Tuliskan catatan revisi di sini (minimal 5 karakter)...',
                showCancelButton: true,
                confirmButtonText: 'Kirim Revisi & Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                inputValidator: (value) => {
                    if (!value || value.trim().length < 5) {
                        return 'Catatan revisi minimal berisi 5 karakter!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-reject-guru-' + projectId);
                    const hiddenInput = document.getElementById('revisi-' + projectId);
                    
                    // Set value ke hidden input form
                    hiddenInput.value = result.value;

                    // Tampilkan Loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.message || 'Terjadi kesalahan sistem.');
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', error.message || 'Terjadi kesalahan sistem.', 'error');
                    });
                }
            });
        }

        // Fungsi Terima Proposal
        function prosesApproveProyek(projectId) {
            Swal.fire({
                title: 'Setujui Proyek?',
                text: "Siswa akan menerima pemberitahuan untuk mulai mengerjakan proyek ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan Loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    const form = document.getElementById('form-approve-guru-' + projectId);
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.message || 'Terjadi kesalahan.');
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', error.message || 'Terjadi kesalahan sistem.', 'error');
                    });
                }
            });
        }
        </script>