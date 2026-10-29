@extends('guru.layouts.app')

@section('title', 'Pembelajaran TEFA - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'projek-aktif', filterKelas: '{{ $filterKelas ?? 'all' }}', search: '' }">
    <!-- Hero Header Banner -->
    <div class="relative overflow-hidden bg-gradient-to-br from-purple-700 via-indigo-600 to-blue-800 rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-purple-600/20 mb-8 border border-purple-400/20">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-pink-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-medium text-purple-100 shadow-inner">
                    <a href="#" class="hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-house text-[10px]"></i>
                        Portal Guru
                    </a>
                    <i class="fa-solid fa-chevron-right text-[8px] text-purple-200/60"></i>
                    <span class="text-white font-semibold">Pembelajaran TEFA</span>
                </div>

                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                            Teaching Factory (TEFA)
                        </h1>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-400/25 text-purple-100 border border-purple-300/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-pink-300 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>
                    <p class="text-purple-100/90 text-xs sm:text-sm mt-1.5 leading-relaxed font-normal">
                        Kelola, pantau kemajuan produksi, dan verifikasi seluruh unit proyek berbasis Teaching Factory siswa secara terpadu.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="" 
                title="Buat Projek TEFA Baru" 
                class="group relative inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-purple-600 to-indigo-500 hover:from-purple-700 hover:to-indigo-600 text-white rounded-2xl shadow-xl shadow-purple-600/30 hover:shadow-2xl hover:shadow-purple-600/50 transition-all duration-300 active:scale-95">
                    <i class="fa-solid fa-industry text-2xl transition-transform group-hover:-translate-y-1 group-hover:translate-x-1 duration-300"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Status & Pencarian -->
    <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2 p-1 bg-slate-100/80 rounded-xl w-fit">
            @php
                $currentStatus = request('status', 'berjalan');
            @endphp

            <!-- 1. Projek Berjalan -->
            <a href="{{ route('guru.tefa.dashboard', array_merge(request()->query(), ['status' => 'berjalan'])) }}"
            class="px-4 py-2 rounded-lg text-xs transition-all duration-200 flex items-center gap-2 {{ $currentStatus === 'berjalan' ? 'bg-white text-purple-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                <i class="fa-solid fa-gears text-[12px]"></i>
                <span>Projek Berjalan</span>
            </a>

            <!-- 2. Selesai -->
            <a href="{{ route('guru.tefa.dashboard', array_merge(request()->query(), ['status' => 'selesai'])) }}"
            class="px-4 py-2 rounded-lg text-xs transition-all duration-200 flex items-center gap-2 {{ $currentStatus === 'selesai' ? 'bg-white text-emerald-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                <i class="fa-solid fa-circle-check text-[12px]"></i>
                <span>Selesai</span>
            </a>

            <!-- 3. Kedaluwarsa -->
            <a href="{{ route('guru.tefa.dashboard', array_merge(request()->query(), ['status' => 'kedaluwarsa'])) }}"
            class="px-4 py-2 rounded-lg text-xs transition-all duration-200 flex items-center gap-2 {{ $currentStatus === 'kedaluwarsa' ? 'bg-white text-rose-600 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                <i class="fa-solid fa-clock-rotate-left text-[12px]"></i>
                <span>Kedaluwarsa</span>
            </a>
        </div>

        <div class="flex items-center gap-2 px-1">
            <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Cari:</span>
            <div class="relative w-full max-w-xs">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-[11px] text-slate-400 pointer-events-none"></i>
                <input type="text" 
                    x-model="search" 
                    placeholder="Cari kategori, judul, atau deskripsi..." 
                    class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs font-bold text-slate-700 placeholder:text-slate-400 placeholder:font-normal focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 transition">
            </div>
        </div>
    </div>

    <!-- Grid List Proyek TEFA -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
        @forelse($projects as $project)
            @php
                $sisaHari = now()->diffInDays($project->tanggal_selesai, false);
                $isExpired = $sisaHari < 0;

                // Menggunakan relasi tasks/progress jika ada, atau default aman
                $totalTasks = method_exists($project, 'tasks') ? $project->tasks->count() : 0;
                $completedCount = method_exists($project, 'tasks') ? $project->tasks->where('status', 'completed')->count() : 0;
                $progressPercent = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : ($project->status === 'approved' ? 50 : 10);

                // Kondisi warna berdasarkan persentase atau status TEFA
                if ($progressPercent === 100) {
                    $faseStatus = 'Selesai';
                    $barBg      = 'bg-emerald-500';
                    $textColor  = 'text-emerald-600';
                    $badgeBg    = 'bg-emerald-50 text-emerald-700 border-emerald-200/80';
                } elseif ($progressPercent >= 80) {
                    $faseStatus = 'Tahap Akhir';
                    $barBg      = 'bg-teal-500';
                    $textColor  = 'text-teal-600';
                    $badgeBg    = 'bg-teal-50 text-teal-700 border-teal-200/80';
                } elseif ($progressPercent >= 36) {
                    $faseStatus = 'Dalam Pengerjaan';
                    $barBg      = 'bg-purple-500';
                    $textColor  = 'text-purple-600';
                    $badgeBg    = 'bg-purple-50 text-purple-700 border-purple-200/80';
                } elseif ($progressPercent > 0) {
                    $faseStatus = 'Awal Pengerjaan';
                    $barBg      = 'bg-amber-500';
                    $textColor  = 'text-amber-600';
                    $badgeBg    = 'bg-amber-50 text-amber-700 border-amber-200/80';
                } else {
                    $faseStatus = 'Belum Dimulai';
                    $barBg      = 'bg-slate-400';
                    $textColor  = 'text-slate-600';
                    $badgeBg    = 'bg-slate-100 text-slate-700 border-slate-200/80';
                }
            @endphp

            <div class="group relative bg-white rounded-3xl border border-slate-200/80 hover:border-purple-500/40 shadow-xs hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <!-- Accent Top Line -->
                <div class="h-1.5 w-full {{ $barBg }}"></div>

                <div class="p-6 space-y-5">
                    <!-- Status Header -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold border {{ $badgeBg }}">
                            <span class="h-2 w-2 rounded-full {{ $barBg }} {{ $progressPercent < 100 ? 'animate-pulse' : '' }}"></span>
                            {{ $faseStatus }}
                        </span>
                        
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold {{ $isExpired ? 'text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-200/80 animate-pulse' : 'text-slate-600 bg-slate-100/80 px-3 py-1 rounded-full' }}">
                            <i class="fa-regular fa-clock text-xs"></i> 
                            {{ $isExpired ? 'Lewat Tenggat' : (int)$sisaHari . ' Hari Lagi' }}
                        </span>
                    </div>

                    <!-- Informasi Proyek TEFA -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-[10px] font-black text-slate-600 uppercase tracking-wider">
                                {{ $project->kategori ?? 'Umum' }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">
                                Tipe: {{ $project->tipe ?? 'Kelompok' }}
                            </span>
                        </div>
                        <h3 class="text-base font-black text-slate-800 group-hover:text-purple-600 transition-colors line-clamp-1 leading-snug" title="{{ $project->judul }}">
                            {{ $project->judul }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                            {{ $project->deskripsi ?? 'Tidak ada deskripsi singkat untuk proyek Teaching Factory ini.' }}
                        </p>
                    </div>

                    <!-- Progres Penyelesaian -->
                    <div class="space-y-2 bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-slate-500 text-[11px]">Progres Unit TEFA</span>
                            <span class="{{ $textColor }} font-extrabold">
                                {{ $completedCount }}/{{ $totalTasks > 0 ? $totalTasks : '-' }} ({{ $progressPercent }}%)
                            </span>
                        </div>
                        <div class="w-full bg-slate-200/70 h-2.5 rounded-full overflow-hidden">
                            <div class="{{ $barBg }} h-full rounded-full transition-all duration-700 ease-out" 
                                style="width: {{ $progressPercent }}%"></div>
                        </div>
                    </div>

                    <!-- Tim Proyek (Members) -->
                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2 overflow-hidden">
                                @php
                                    $leader = $project->members->firstWhere('is_leader', true);
                                    $leaderName = $leader->nama_siswa ?? $project->creator->name ?? 'Ketua';
                                @endphp

                                <div class="relative w-8 h-8 rounded-full bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-black text-[11px] flex items-center justify-center ring-2 ring-white shadow-xs" 
                                    title="Ketua: {{ $leaderName }}">
                                    {{ strtoupper(substr($leaderName, 0, 2)) }}
                                </div>

                                @if($project->members)
                                    @foreach($project->members->where('is_leader', false)->take(2) as $member)
                                        @php
                                            $memberName = $member->nama_siswa ?? optional($member->user)->name ?? 'Anggota';
                                        @endphp
                                        <div class="w-8 h-8 rounded-full bg-slate-800 text-white font-bold text-[11px] flex items-center justify-center ring-2 ring-white shadow-xs" 
                                            title="{{ $member->peran ?? 'Anggota' }}: {{ $memberName }}">
                                            {{ strtoupper(substr($memberName, 0, 2)) }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <span class="text-xs font-extrabold text-slate-700">
                                {{ $project->members->count() }} Anggota
                            </span>
                        </div>
                        
                        <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg text-[10px] font-extrabold border border-purple-100/80">
                            TEFA UNIT
                        </span>
                    </div>
                </div>

                <!-- Footer Card -->
                <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <div class="flex flex-col gap-1">
                        <span class="text-[11px] text-slate-500 font-bold flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-check text-purple-500"></i>
                            {{ \Carbon\Carbon::parse($project->tanggal_selesai)->format('d M Y') }}
                        </span>

                        @if($project->members)
                            @php
                                $pendingMembersCount = $project->members->where('status', 'pending')->count();
                            @endphp

                            @if($pendingMembersCount > 0)
                                <div class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200/80 px-2 py-0.5 rounded-lg">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-[10px] animate-pulse"></i>
                                    <span>{{ $pendingMembersCount }} anggota belum konfirmasi</span>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Sesuaikan route monitoring TEFA Anda di sini -->
                    <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md shadow-purple-500/20 transition-all duration-200 active:scale-95 shrink-0">
                        <span>Pantau TEFA</span>
                        <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-3xl shadow-xs">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800">Belum Ada Projek TEFA</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto leading-relaxed">
                    Semua unit proyek Teaching Factory yang aktif akan muncul di panel ini untuk dipantau proses produksinya.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection