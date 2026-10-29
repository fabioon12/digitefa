@extends('industri.layouts.app')

@section('title', 'Pembelajaran PjBL - Portal Industri')

@section('content')
<div class="space-y-6">

    <!-- 1. Hero Banner (Orange Gradient Background) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 p-8 text-white shadow-xl shadow-orange-500/10">
        <!-- Pattern Grid Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-[size:16px_16px]"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl space-y-3">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-orange-100/80">
                    <span class="flex items-center gap-1 hover:text-white transition cursor-pointer">
                        <i class="fa-solid fa-house text-[10px]"></i> Portal Industri
                    </span>
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-60"></i>
                    <span class="text-white">Pembelajaran PjBL</span>
                </nav>

                <!-- Title & Badge -->
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Project-Based Learning</h1>
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 bg-white/20 backdrop-blur-md rounded-full text-[11px] font-bold text-white border border-white/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                    </span>
                </div>

                <!-- Description -->
                <p class="text-orange-100/90 text-xs sm:text-sm leading-relaxed">
                    Kelola, pantau kemajuan, dan verifikasi seluruh proposal serta aktivitas pembelajaran berbasis proyek siswa secara terpadu.
                </p>
            </div>

            <!-- Action Button -->
            <div class="shrink-0">
                <a href="#" 
                title="Buat Projek PjBL Baru" 
                class="w-12 h-12 bg-white text-orange-600 hover:bg-orange-50 text-xl rounded-2xl shadow-lg transition-all duration-200 active:scale-95 inline-flex items-center justify-center border border-orange-100">
                    <i class="fa-solid fa-rocket"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Control Bar (Tab & Search Box) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Tab Left -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            @php
                $currentStatus = request('status', 'berjalan');
            @endphp

            <!-- 1. Projek Berjalan -->
            <a href="{{ route('industri.pjbl.dashboard', array_merge(request()->query(), ['status' => 'berjalan'])) }}" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200 {{ $currentStatus === 'berjalan' ? 'bg-orange-500 text-white border-orange-500 shadow-md shadow-orange-500/20' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                <i class="fa-solid fa-rocket text-xs"></i> 
                Projek Berjalan
            </a>

            <!-- 2. Selesai -->
            <a href="{{ route('industri.pjbl.dashboard', array_merge(request()->query(), ['status' => 'selesai'])) }}" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200 {{ $currentStatus === 'selesai' ? 'bg-emerald-500 text-white border-emerald-500 shadow-md shadow-emerald-500/20' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                <i class="fa-solid fa-circle-check text-xs"></i> 
                Selesai
            </a>

            <!-- 3. Kedaluwarsa -->
            <a href="{{ route('industri.pjbl.dashboard', array_merge(request()->query(), ['status' => 'kedaluwarsa'])) }}" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200 {{ $currentStatus === 'kedaluwarsa' ? 'bg-rose-500 text-white border-rose-500 shadow-md shadow-rose-500/20' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                <i class="fa-solid fa-clock-rotate-left text-xs"></i> 
                Kedaluwarsa
            </a>
        </div>

        <!-- Search Bar (Terhubung langsung ke Controller) -->
        <form action="{{ route('industri.pjbl.dashboard') }}" method="GET" class="relative w-full sm:w-80">
            <input 
                type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama proyek, kelas, atau siswa..." 
                class="w-full pl-9 pr-8 py-2 bg-slate-50 border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
            >
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            
            @if(request('search'))
                <a href="{{ route('industri.pjbl.dashboard') }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-rose-500 transition text-xs" title="Hapus Pencarian">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- 3. Grid Card Proyek Dinamis -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($projects as $project)
            @php
                $sisaHari = now()->diffInDays($project->tanggal_selesai, false);
                $isExpired = $sisaHari < 0;
                $totalTasks = $project->tasks->count();
                $completedTasks = $project->tasks->where('status', 'completed')->count();
                $progressPercent = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

                // Cek apakah proyek sudah selesai seluruh task-nya
                $isCompleted = ($totalTasks > 0 && $completedTasks === $totalTasks);
                
                // Tentukan label dan style warna badge
                $statusLabel = $isCompleted ? 'Selesai' : 'Dalam Pengerjaan';
                $statusBg = $isCompleted ? 'bg-emerald-50' : 'bg-orange-50';
                $statusText = $isCompleted ? 'text-emerald-600' : 'text-orange-600';
                $statusDot = $isCompleted ? 'bg-emerald-500' : 'bg-orange-500';
            @endphp

            <!-- Card Proyek Item -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col justify-between border-t-4 border-t-orange-500">
                
                <div class="p-5 space-y-4">
                    <!-- Badges Status & Deadline -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $statusBg }} {{ $statusText }} rounded-xl text-[11px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span> 
                            {{ $statusLabel }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold {{ $isExpired ? 'text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-200/80 animate-pulse' : 'text-slate-600 bg-slate-100/80 px-3 py-1 rounded-full' }}">
                            <i class="fa-regular fa-clock text-xs"></i> 
                            {{ $isExpired ? 'Lewat Tenggat' : (int)$sisaHari . ' Hari Lagi' }}
                        </span>
                    </div>

                    <!-- Category Tag & Title -->
                    <div class="space-y-1">
                        <span class="inline-block px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-black uppercase tracking-wider">
                            {{ $project->kategori ?? 'PjBL' }}
                        </span>
                        <h3 class="text-base font-extrabold text-slate-800 leading-snug line-clamp-1" title="{{ $project->title }}">
                            {{ $project->judul ?? 'Proyek Tanpa Judul' }}
                        </h3>
                        <p class="text-xs text-slate-400 line-clamp-2">
                            {{ $project->deskripsi ?? 'Tidak ada deskripsi proyek.' }}
                        </p>
                    </div>

                    <!-- Progress Bar Box -->
                    <div class="p-3 bg-slate-50/80 rounded-2xl space-y-2">
                        <div class="flex justify-between items-center text-[11px] font-bold">
                            <span class="text-slate-500">Progres Penyelesaian</span>
                            <span class="text-orange-600">{{ $completedTasks }}/{{ $totalTasks }} ({{ $progressPercent }}%)</span>
                        </div>
                        <div class="w-full bg-slate-200/80 h-2 rounded-full overflow-hidden">
                            <div class="bg-orange-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                        </div>
                    </div>

                    <!-- Anggota Kelompok & Badge Jenis Proyek -->
                    <div class="flex items-center justify-between pt-1">
                        <!-- Avatar Stack -->
                        <div class="flex items-center">
                            <div class="flex -space-x-2 overflow-hidden">
                                @forelse($project->members->take(3) as $member)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-800 text-white text-[10px] font-bold ring-2 ring-white" title="{{ $member->user->name ?? 'Siswa' }}">
                                        {{ strtoupper(substr($member->user->name ?? 'S', 0, 2)) }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-500 text-white text-[10px] font-bold ring-2 ring-white">
                                        {{ strtoupper(substr($project->creator->name ?? 'U', 0, 2)) }}
                                    </span>
                                @endforelse
                            </div>
                            <span class="text-xs font-bold text-slate-700 ml-2">
                                {{ $project->members->count() > 0 ? $project->members->count() : 1 }} Anggota
                            </span>
                        </div>

                        <span class="px-2.5 py-1 bg-orange-50 text-orange-700 text-[10px] font-black tracking-wider uppercase rounded-lg">
                            {{ $project->members->count() > 1 ? 'KELOMPOK' : 'INDIVIDU' }}
                        </span>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="px-5 py-3.5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-500 font-bold flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-check text-indigo-500"></i>
                            {{ \Carbon\Carbon::parse($project->tanggal_selesai)->format('d M Y') }}
                        </span>
                    <a href="{{ route('industri.pjbl.dashboard.monitor', $project->id) }}" class="px-4 py-1.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs rounded-xl shadow-sm transition-all flex items-center gap-1.5">
                        Pantau <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>
        @empty
            <!-- Fallback Tampilan Kosong -->
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm space-y-3">
                <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Proyek Tidak Ditemukan</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                    @if(request('search'))
                        Tidak ada proyek yang sesuai dengan kata kunci "<span class="font-bold text-slate-600">{{ request('search') }}</span>".
                    @else
                        Belum ada proyek PjBL siswa yang terdaftar atau disetujui saat ini.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('industri.pjbl.index') }}" class="inline-block mt-2 text-xs text-orange-600 font-bold hover:underline">
                        Reset Pencarian
                    </a>
                @endif
            </div>
        @endforelse

    </div>

</div>
@endsection