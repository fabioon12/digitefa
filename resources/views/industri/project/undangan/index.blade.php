@extends('industri.layouts.app')

@section('title', 'Verifikasi Proposal PJBL - Industri')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">

    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-1">
        <div class="w-10 h-10 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 shadow-2xs">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4m0 0h4m-4 0a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v7a2 2 0 01-2 2"/>
            </svg>
        </div>
        <div class="flex items-center gap-2">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Verifikasi Proposal Proyek</h1>
            <span class="px-2.5 py-0.5 text-xs font-semibold text-sky-600 bg-sky-50/80 rounded-full border border-sky-100">
                Mentor Industri
            </span>
        </div>
    </div>
    <p class="text-xs text-slate-400 mb-6 pl-13">Tinjau, evaluasi, dan berikan persetujuan untuk pengajuan proposal proyek siswa mitra.</p>

    <!-- Stat Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card 1: Total Proposal -->
        <div class="bg-sky-50/40 border border-sky-100/60 p-5 rounded-2xl flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-sky-500">Total Proposal</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalProjects ?? $projects->total() }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Semua pengajuan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-100/60 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Menunggu Verifikasi -->
        <div class="bg-amber-50/40 border border-amber-100/60 p-5 rounded-2xl flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-amber-600/80">Menunggu Verifikasi</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $pendingCount ?? 0 }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Perlu ditinjau</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100/60 text-amber-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3: Disetujui -->
        <div class="bg-emerald-50/40 border border-emerald-100/60 p-5 rounded-2xl flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-emerald-600/80">Disetujui</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $approvedCount ?? 0 }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Telah disetujui</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100/60 text-emerald-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <!-- Card 4: Ditolak / Revisi -->
        <div class="bg-rose-50/40 border border-rose-100/60 p-5 rounded-2xl flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-rose-600/80">Ditolak / Revisi</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $rejectedCount ?? 0 }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Perlu perbaikan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-100/60 text-rose-500 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m2 0a2 2 0 100-4 2 2 0 000 4zm-8 4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v2m-4 8a2 2 0 110-4 2 2 0 010 4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter Tabs & Search Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <!-- Tab Filter Status -->
        <div class="bg-slate-100/70 p-1.5 rounded-2xl inline-flex flex-wrap items-center gap-1 border border-slate-200/50">
            <a href="{{ route('industri.pjbl.undangan.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-2 {{ $status == 'pending' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Menunggu Verifikasi</span>
                @if(isset($invitationCount) && $invitationCount > 0)
                    <span class="ml-1 px-2 py-0.5 text-[10px] font-extrabold text-white bg-sky-600 rounded-full">
                        {{ $invitationCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('industri.pjbl.undangan.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-2 {{ $status == 'approved' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Disetujui</span>
            </a>

            <a href="{{ route('industri.pjbl.undangan.index', ['status' => 'rejected']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-2 {{ $status == 'rejected' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2zm0 0h18"/></svg>
                <span>Ditolak / Revisi</span>
            </a>
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('industri.pjbl.undangan.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative w-full sm:w-80">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul proyek, pengaju, atau kategori..." 
                       class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/10 transition">
            </div>
            <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-200/80 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-50 transition shrink-0">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter</span>
            </button>
        </form>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/70 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-4 text-center w-12">NO.</th>
                        <th class="py-4 px-6">JUDUL PROYEK</th>
                        <th class="py-4 px-6">PENGAJU (KETUA)</th>
                        <th class="py-4 px-6">TIPE</th>
                        <th class="py-4 px-6">KATEGORI</th>
                        <th class="py-4 px-6">PELAKSANAAN</th>
                        <th class="py-4 px-6">STATUS SAYA</th>
                        <th class="py-4 px-6 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse ($projects as $index => $project)
                        @php
                            $mentorPivot = $project->mentors->first();
                            $myStatus = $mentorPivot ? $mentorPivot->pivot->status : 'pending';
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $projects->firstItem() + $index }}
                            </td>

                            <td class="py-4 px-6 font-bold text-slate-800">
                                <div class="flex items-center gap-3 max-w-xs">
                                    <span class="line-clamp-2 leading-snug" title="{{ $project->judul }}">
                                        {{ $project->judul }}
                                    </span>
                                </div>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-sky-600 text-white font-extrabold text-[10px] flex items-center justify-center uppercase shrink-0">
                                        {{ strtoupper(substr($project->creator->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 truncate">{{ $project->creator->name ?? '-' }}</div>
                                        <div class="text-[10px] text-slate-400 truncate">{{ $project->creator->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($project->tipe === 'kelompok')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                        Kelompok ({{ $project->members->count() }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                        Individu
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="font-bold text-sky-600 bg-sky-50/80 px-3 py-1 rounded-full text-[11px] border border-sky-100">
                                    {{ $project->kategori }}
                                </span>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-slate-600 font-medium text-[11px]">
                                {{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($project->tanggal_selesai)->format('d M Y') }}
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($myStatus === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>
                                @elseif($myStatus === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <a href="{{ route('industri.pjbl.undangan.show', $project->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl font-bold text-xs transition">
                                        Detail
                                    </a>

                                    @if($myStatus === 'pending')
                                        <button type="button" 
                                                onclick="approveProject('{{ $project->id }}', '{{ addslashes($project->judul) }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs transition shadow-2xs">
                                            Setujui
                                        </button>

                                        <button type="button" 
                                                onclick="rejectProject('{{ $project->id }}', '{{ addslashes($project->judul) }}')"
                                                class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition border border-rose-100"
                                                title="Tolak / Revisi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>

                                        <form id="approve-form-{{ $project->id }}" action="{{ route('industri.pjbl.undangan.approve', $project->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>

                                        <form id="reject-form-{{ $project->id }}" action="{{ route('industri.pjbl.undangan.reject', $project->id) }}" method="POST" class="hidden">
                                            @csrf
                                            <input type="hidden" name="catatan_revisi" id="catatan-input-{{ $project->id }}">
                                        </form>
                                    @elseif($myStatus === 'approved')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-xs font-semibold">
                                            Anda Menyetujui
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-16 text-center text-slate-400">
                                <p class="text-xs font-bold text-slate-600">Tidak Ada Proposal Proyek</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Belum ada pengajuan proposal dari siswa untuk mitra industri Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination Section -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
            <div>
                Menampilkan {{ $projects->firstItem() ?? 0 }} dari {{ $projects->total() ?? 0 }} data
            </div>
            @if($projects->hasPages())
                <div>
                    {{ $projects->appends(['status' => $status, 'search' => request('search')])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function approveProject(id, judul) {
    Swal.fire({
        title: 'Setujui Proposal?',
        html: `Apakah Anda yakin ingin menyetujui proposal <br><strong class="text-sky-600">"${judul}"</strong>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Setujui!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
            cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`approve-form-${id}`).submit();
        }
    });
}

function rejectProject(id, judul) {
    Swal.fire({
        title: 'Tolak / Minta Revisi',
        html: `Berikan catatan penolakan untuk proposal <br><strong class="text-rose-600">"${judul}"</strong>:`,
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Tuliskan catatan revisi di sini...',
        inputAttributes: { 'aria-label': 'Catatan Revisi', 'rows': 4 },
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Kirim Penolakan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
            cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
            input: 'text-xs rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500'
        },
        inputValidator: (value) => {
            if (!value) {
                return 'Anda harus memasukkan alasan penolakan!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`catatan-input-${id}`).value = result.value;
            document.getElementById(`reject-form-${id}`).submit();
        }
    });
}
</script>
@endsection