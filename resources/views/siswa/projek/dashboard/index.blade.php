@extends('siswa.layouts.app')

@section('title', 'Dashboard Proyek PjBL')

@section('content')
<div class="w-full max-w-[98%] xl:max-w-[1600px] mx-auto py-6 px-4 space-y-6 text-slate-800">

    <div class="relative overflow-hidden bg-[#5352ed] p-6 sm:p-8 rounded-[28px] shadow-lg shadow-indigo-500/20 flex flex-col md:flex-row items-center justify-between gap-6 text-white">
        
        <div class="space-y-2 max-w-2xl z-10">
            <div class="text-[11px] font-extrabold uppercase tracking-widest text-indigo-200">
                DASHBOARD / DAFTAR PROYEK
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Halo, <span class="text-white">{{ Auth::user()->name ?? 'Siswa Teladan' }}</span>
            </h1>

            <p class="text-xs sm:text-sm text-indigo-100 font-medium leading-relaxed">
                Kelola proyekmu dan tawarkan keahlian kepada klien. Pantau perkembangan proyek serta kolaborasi kelompok Anda di sini.
            </p>
        </div>

        <div class="hidden sm:flex shrink-0 items-center justify-center z-10">
            <div class="w-28 h-24 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 relative">
                <i class="fa-solid fa-laptop-code text-3xl text-white"></i>
                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-400 rounded-full border-2 border-[#5352ed]"></span>
            </div>
        </div>

    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'semua']) }}" 
               class="px-5 py-2 rounded-xl text-xs font-bold transition-all shadow-xs shrink-0 {{ !request('filter') || request('filter') == 'semua' ? 'bg-indigo-600 text-white shadow-indigo-500/30' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
                Semua ({{ $myProjects->total() ?? count($myProjects) }})
            </a>

            <a href="{{ request()->fullUrlWithQuery(['filter' => 'approved']) }}" 
               class="px-5 py-2 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ request('filter') == 'approved' ? 'bg-emerald-600 text-white shadow-xs shadow-emerald-500/30 font-bold' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ request('filter') == 'approved' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                Approved ({{ $myProjects->where('status', 'approved')->count() }})
            </a>

            <a href="{{ request()->fullUrlWithQuery(['filter' => 'rejected']) }}" 
               class="px-5 py-2 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ request('filter') == 'rejected' ? 'bg-rose-600 text-white shadow-xs shadow-rose-500/30 font-bold' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ request('filter') == 'rejected' ? 'bg-white' : 'bg-rose-500' }}"></span>
                Rejected ({{ $myProjects->where('status', 'rejected')->count() }})
            </a>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari Proyek..." 
                       class="w-full pl-4 pr-10 py-2.5 bg-slate-100/80 border-0 rounded-2xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-slate-700 placeholder-slate-400">
                <i class="fa-solid fa-magnifying-glass absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </div>
            <button class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200/80 rounded-2xl text-xs font-bold text-slate-700 flex items-center gap-2 transition shrink-0">
                <i class="fa-solid fa-sliders text-xs"></i>
                <span>Filter</span>
            </button>
        </div>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $currentFilter = request('filter', 'semua');

                $filteredProjects = $myProjects->filter(function($project) use ($currentFilter) {
                    if ($currentFilter === 'approved') return $project->status === 'approved';
                    if ($currentFilter === 'rejected') return $project->status === 'rejected';
                    if ($currentFilter === 'pending') return $project->status === 'pending';
                    return true;
                });
            @endphp

            @forelse($filteredProjects as $project)
                @php
                    $isRejected = $project->status === 'rejected';
                    $isGuruApproved = $project->status === 'approved';
                    
                    $isMembersApproved = true;
                    if ($project->tipe === 'kelompok') {
                        $isMembersApproved = $project->members
                            ? $project->members->where('is_leader', false)->every(fn($member) => $member->status === 'accepted')
                            : true;
                    }
                    
                    $canWorkOnProject = $isGuruApproved && $isMembersApproved;

                    $totalTasks = $project->tasks ? $project->tasks->count() : 0;
                    $completedCount = $project->tasks ? $project->tasks->where('status', 'completed')->count() : 0;
                    $progressPercent = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0;

                    // Hitung Sisa Hari Deadline
                    $deadlineDate = $project->tanggal_selesai ? \Carbon\Carbon::parse($project->tanggal_selesai)->endOfDay() : null;
                    $diffInDays = $deadlineDate ? (int) floor(now()->startOfDay()->diffInDays($deadlineDate, false)) : null;

                    // Dinamika Border & Accent Bar berdasarkan status
                    $accentColor = match(true) {
                        $isRejected => 'bg-rose-500',
                        $project->status === 'pending' => 'bg-amber-400',
                        !$isMembersApproved => 'bg-sky-500',
                        default => 'bg-emerald-500',
                    };

                    // Cek apakah user saat ini adalah Ketua/Pembuat Proyek
                    $isLeader = $project->user_id === auth()->id();
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-indigo-300/80 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between relative overflow-hidden group">
                    
                    <div class="h-1.5 w-full {{ $accentColor }}"></div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        
                        <div class="space-y-3">
                            <div class="flex items-start justify-between gap-2">
                                <span class="px-2.5 py-1 {{ $isRejected ? 'bg-rose-50 text-rose-700 border-rose-100' : 'bg-indigo-50/80 text-indigo-600 border-indigo-100/60' }} border rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                                    {{ $project->kategori ?? 'Produk' }}
                                </span>
                                <div>
                                    @php
                                        $isMentorRejected = $project->mentors->contains(fn($m) => $m->pivot->status === 'rejected');
                                        $isMemberRejected = $project->members->contains(fn($m) => $m->status === 'rejected');
                                        $isAllMentorsApproved = $project->mentors->isNotEmpty() && 
                                                                $project->mentors->every(fn($m) => $m->pivot->status === 'approved');
                                        $isAllMembersApproved = $project->members->where('is_leader', false)->every(fn($m) => $m->status === 'accepted');
                                    @endphp

                                    @if($isMentorRejected || $isMemberRejected)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Proyek Ditolak / Revisi
                                        </span>

                                    @elseif(!$isAllMentorsApproved)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span> Menunggu Pembimbing
                                        </span>

                                    @elseif(!$isAllMembersApproved)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200 rounded-full text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Menunggu Anggota Tim
                                        </span>

                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Proyek Disetujui
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-indigo-600 transition-colors line-clamp-1" title="{{ $project->judul }}">
                                    {{ $project->judul }}
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mt-1">
                                    {{ $project->deskripsi }}
                                </p>
                            </div>

                            <!-- ALERT CATATAN PENOLAKAN -->
                            @if($isRejected)
                                <div class="p-3 bg-rose-50/70 border border-rose-200/80 rounded-xl text-xs space-y-1">
                                    <div class="flex items-center gap-1.5 font-bold text-rose-700 text-[11px]">
                                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                                        <span>Catatan Penolakan:</span>
                                    </div>
                                    <p class="text-rose-600 text-[11px] leading-relaxed italic">
                                        "{{ $project->catatan_penolakan ?? $project->catatan_revisi ?? 'Proyek belum memenuhi syarat minimal, silakan lakukan perbaikan.' }}"
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-3 pt-3 border-t border-slate-100">
                            
                            @if($canWorkOnProject)
                                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 space-y-1.5">
                                    <div class="flex justify-between items-center text-[11px] font-semibold">
                                        <span class="text-slate-500 flex items-center gap-1">
                                            <i class="fa-solid fa-tasks text-indigo-500"></i> Progres Task
                                        </span>
                                        <span class="text-indigo-600 font-bold">{{ $completedCount }}/{{ $totalTasks }} ({{ $progressPercent }}%)</span>
                                    </div>
                                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Info Meta (Deadline + Sisa Hari) -->
                            <div class="flex items-center justify-between gap-2 text-[11px] text-slate-500 bg-slate-50/60 p-2 rounded-xl border border-slate-100">
                                <div class="flex items-center gap-1.5 truncate">
                                    <i class="fa-regular fa-calendar-check text-slate-400 shrink-0"></i>
                                    <span class="truncate">
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Deadline:</span>
                                        <span class="font-bold text-slate-700 ml-0.5">
                                            {{ $deadlineDate ? $deadlineDate->format('d M Y') : '-' }}
                                        </span>
                                    </span>
                                </div>

                                <!-- Badge Hitung Mundur Sisa Hari -->
                                @if(!is_null($diffInDays))
                                    @if($diffInDays < 0)
                                        <span class="shrink-0 px-2 py-0.5 bg-rose-100 text-rose-700 border border-rose-200 rounded-md text-[10px] font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-clock-rotate-left text-[9px]"></i> Lewat {{ abs($diffInDays) }} hr
                                        </span>
                                    @elseif($diffInDays === 0)
                                        <span class="shrink-0 px-2 py-0.5 bg-rose-500 text-white rounded-md text-[10px] font-bold animate-pulse flex items-center gap-1 shadow-xs">
                                            <i class="fa-solid fa-fire text-[9px]"></i> Hari Ini
                                        </span>
                                    @elseif($diffInDays <= 3)
                                        <span class="shrink-0 px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-200 rounded-md text-[10px] font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-hourglass-half text-[9px]"></i> Sisa {{ $diffInDays }} hr
                                        </span>
                                    @else
                                        <span class="shrink-0 px-2 py-0.5 bg-slate-200/80 text-slate-700 rounded-md text-[10px] font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-hourglass-start text-[9px]"></i> {{ $diffInDays }} hari lagi
                                        </span>
                                    @endif
                                @endif
                            </div>

                            <div class="p-2 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-100 transition-colors flex items-center justify-between gap-2 text-[10px]">
                                
                                <!-- SEKTOR PEMBIMBING (Stack Avatar) -->
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Pembimbing:</span>
                                    <div class="flex -space-x-1.5 overflow-hidden p-0.5">
                                        
                                        <!-- Guru Utama -->
                                        <div class="relative group cursor-pointer">
                                            <div class="w-6 h-6 rounded-full bg-indigo-600 text-white font-bold text-[8px] flex items-center justify-center uppercase ring-2 ring-white shadow-xs">
                                                {{ !empty($project->nama_guru_utama) ? strtoupper(substr($project->nama_guru_utama[0], 0, 2)) : 'GU' }}
                                            </div>
                                            <!-- Tooltip Hover -->
                                            <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                                <span class="bg-slate-800 text-white text-[9px] px-2 py-0.5 rounded shadow-md whitespace-nowrap font-medium">
                                                    {{ !empty($project->nama_guru_utama) ? implode(', ', $project->nama_guru_utama) : 'Guru Utama: -' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Guru Umum -->
                                        <div class="relative group cursor-pointer">
                                            <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 font-bold text-[8px] flex items-center justify-center uppercase ring-2 ring-white shadow-xs">
                                                {{ !empty($project->nama_guru_umum) ? strtoupper(substr($project->nama_guru_umum[0], 0, 2)) : 'GM' }}
                                            </div>
                                            <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                                <span class="bg-slate-800 text-white text-[9px] px-2 py-0.5 rounded shadow-md whitespace-nowrap font-medium">
                                                    {{ !empty($project->nama_guru_umum) ? implode(', ', $project->nama_guru_umum) : 'Guru Umum: -' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Pembimbing Industri -->
                                        <div class="relative group cursor-pointer">
                                            <div class="w-6 h-6 rounded-full bg-emerald-500 text-white font-bold text-[8px] flex items-center justify-center uppercase ring-2 ring-white shadow-xs">
                                                {{ !empty($project->nama_industri) ? strtoupper(substr($project->nama_industri[0], 0, 2)) : 'IN' }}
                                            </div>
                                            <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                                <span class="bg-slate-800 text-white text-[9px] px-2 py-0.5 rounded shadow-md whitespace-nowrap font-medium">
                                                    {{ !empty($project->nama_industri) ? implode(', ', $project->nama_industri) : 'Industri: -' }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Garis Pemisah Vertikal -->
                                <div class="h-4 w-px bg-slate-200 shrink-0"></div>

                                <!-- SEKTOR ANGGOTA / TIM (Stack Avatar) -->
                                <div class="flex items-center gap-1.5 truncate">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Tim:</span>
                                    <div class="flex -space-x-1.5 overflow-hidden p-0.5 truncate">
                                        @forelse($project->members as $member)
                                            <div class="relative group cursor-pointer shrink-0">
                                                <!-- Bulatan Inisial Anggota (Ketua Emas, Anggota Biru Soft) -->
                                                <div class="w-6 h-6 rounded-full {{ $member->is_leader ? 'bg-amber-400 text-amber-950 font-extrabold ring-2 ring-amber-200' : 'bg-sky-100 text-sky-700 font-semibold ring-2 ring-white' }} text-[8px] flex items-center justify-center uppercase shadow-xs">
                                                    {{ strtoupper(substr($member->nama_siswa ?? $member->name ?? 'S', 0, 2)) }}
                                                </div>
                                                
                                                <!-- Tooltip Hover Nama Anggota -->
                                                <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:flex flex-col items-center z-20 pointer-events-none">
                                                    <span class="bg-slate-800 text-white text-[9px] px-2 py-0.5 rounded shadow-md whitespace-nowrap font-medium">
                                                        {{ $member->nama_siswa ?? $member->name }} {{ $member->is_leader ? '(Ketua)' : '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @empty
                                            <span class="text-slate-400 text-[9px] italic">-</span>
                                        @endforelse
                                    </div>
                                </div>

                            </div>

                            <!-- TOMBOL AKSI + TOMBOL HAPUS -->
                            <div class="pt-1 flex items-center gap-2">
                                <div class="flex-1">
                                    @php
                                        $isMentorRejected = $project->mentors->contains(fn($m) => $m->pivot->status === 'rejected');
                                        $isMemberRejected = $project->members->contains(fn($m) => $m->status === 'rejected');
                                        $isRejected = $isMentorRejected || $isMemberRejected;

                                        $isMentorsApproved = $project->mentors->isNotEmpty() && 
                                                            $project->mentors->every(fn($m) => $m->pivot->status === 'approved');
                                        $isMembersApproved = $project->members->where('is_leader', false)->every(fn($m) => $m->status === 'accepted');

                                        $canWorkOnProject = $isMentorsApproved && $isMembersApproved && !$isRejected;
                                    @endphp

                                    @if($isRejected)
                                        <button disabled class="w-full py-2.5 px-4 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs cursor-not-allowed flex items-center justify-center gap-2 border border-rose-200">
                                            <i class="fa-solid fa-circle-xmark text-xs"></i>
                                            <span>Proyek Ditolak / Perlu Revisi</span>
                                        </button>

                                    @elseif($canWorkOnProject && !is_null($diffInDays) && $diffInDays < 0)
                                        <a href="{{ route('siswa.pjbl.tasks.index', $project->id) }}" class="w-full py-2.5 px-4 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold text-xs shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span>Lihat Proyek (Selesai/Expired)</span>
                                        </a>

                                    @elseif($canWorkOnProject)
                                        <a href="{{ route('siswa.pjbl.tasks.index', $project->id) }}" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 group-hover:bg-indigo-700">
                                            <span>Buka Detail Proyek</span>
                                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-0.5"></i>
                                        </a>

                                    @else
                                        <button disabled class="w-full py-2.5 px-4 bg-slate-100 text-slate-400 rounded-xl font-bold text-xs cursor-not-allowed flex items-center justify-center gap-1.5 border border-slate-200/50">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                            <span>
                                                @if(!$isMentorsApproved)
                                                    Menunggu ACC Pembimbing
                                                @elseif(!$isMembersApproved)
                                                    Menunggu Anggota Lain
                                                @else
                                                    Akses Terkunci
                                                @endif
                                            </span>
                                        </button>
                                    @endif
                                </div>

                                <!-- Tombol Hapus (Hanya untuk Ketua / Pembuat Proyek) -->
                                @if($isLeader)
                                    <form action="{{ route('siswa.pjbl.destroy', $project->id) }}" method="POST" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="p-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-xl transition-colors flex items-center justify-center shrink-0 btn-delete" title="Hapus Proyek">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 bg-white rounded-2xl border border-dashed border-slate-200 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-folder-open text-xl"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-700">Tidak Ada Proyek</h4>
                    <p class="text-xs text-slate-400 mt-1">Tidak ada proyek yang sesuai dengan filter "{{ request('filter', 'semua') }}".</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="relative overflow-hidden bg-indigo-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-500/20 flex flex-col sm:flex-row items-center justify-between gap-6 mt-6">
        <div class="flex items-center gap-5 z-10">
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0 border border-white/20">
                <i class="fa-solid fa-lightbulb text-2xl text-amber-300"></i>
            </div>
            <div>
                <h2 class="text-lg sm:text-xl font-extrabold tracking-tight">Punya karya atau keahlian?</h2>
                <p class="text-xs sm:text-sm text-indigo-100 mt-1 max-w-xl">
                    Tampilkan jasa atau produkmu kepada klien dan jadikan keahlianmu sebagai proyek nyata.
                </p>
            </div>
        </div>

        <div class="z-10 shrink-0 w-full sm:w-auto">
            <a href="{{ route('siswa.pjbl.create') }}" 
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white hover:bg-indigo-50 text-slate-900 rounded-2xl font-bold text-xs shadow-lg transition active:scale-95">
                <i class="fa-solid fa-plus text-sm text-indigo-600"></i>
                <span>Tambah Proyek</span>
            </a>
        </div>

        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    </div>
</div>
<script>
    async function jawabUndangan(id, action) {
    const isAccept = action === 'accept';
    const actionText = isAccept ? 'menerima' : 'menolak';

    // Konfirmasi SweetAlert2
    const confirm = await Swal.fire({
        title: 'Konfirmasi Undangan',
        text: `Apakah Anda yakin ingin ${actionText} undangan proyek ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: isAccept ? '#059669' : '#dc2626'
    });

    if (!confirm.isConfirmed) return;

    try {
        // Mengirim GET Request dengan Query Parameters ?id=X&action=Y ke Route Laravel
        const url = `{{ route('siswa.pjbl.invitation.response') }}?id=${id}&action=${action}`;

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (response.ok && result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: result.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Reload halaman untuk memperbarui daftar proyek & menghilangkan card undangan
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: result.message || 'Terjadi kesalahan saat memproses undangan.'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: 'Gagal terhubung ke server.'
        });
    }
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.form-delete');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Semua file dan data anggota terkait akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48', 
                    cancelButtonColor: '#64748b',  
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-4 py-2 font-bold',
                        cancelButton: 'rounded-xl px-4 py-2 font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });
    });
</script>
@endsection