@extends('industri.layouts.app')

@section('title', 'Detail Proposal Proyek - Industri')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    
    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('industri.pjbl.undangan.index') }}" 
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-sky-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Verifikasi
        </a>
    </div>

    @php
        // Ambil status & catatan khusus untuk mentor industri yang sedang login
        $currentMentor = $project->mentors->where('id', Auth::id())->first();
        $myStatus = $currentMentor ? $currentMentor->pivot->status : 'pending';
        $myCatatan = $currentMentor ? $currentMentor->pivot->catatan_revisi : null;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM UTAMA (KIRI): Detail Proyek & Anggota --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Card Detail Proyek --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-600 border border-sky-100 tracking-wide uppercase mb-3">
                            {{ $project->kategori }}
                        </span>
                        <h1 class="text-2xl font-extrabold text-slate-900 leading-snug">{{ $project->judul }}</h1>
                    </div>
                    <div>
                        @if($myStatus === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending Verifikasi
                            </span>
                        @elseif($myStatus === 'approved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Anda Menyetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Ditolak / Revisi
                            </span>
                        @endif
                    </div>
                </div>

                <hr class="border-slate-100 my-6">

                <div>
                    <h2 class="text-sm font-bold text-slate-900 mb-3">Deskripsi Proyek</h2>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line text-xs font-medium">
                        {{ $project->deskripsi }}
                    </p>
                </div>

                {{-- Alert Catatan Revisi jika Pernah Ditolak --}}
                @if($myStatus === 'rejected' && $myCatatan)
                    <div class="mt-6 p-4 rounded-2xl bg-rose-50/60 border border-rose-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <h3 class="text-xs font-bold text-rose-900">Catatan Evaluasi / Revisi Anda:</h3>
                                <p class="text-xs text-rose-700 mt-1 leading-relaxed font-medium">{{ $myCatatan }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Card Anggota Kelompok --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-sm font-bold text-slate-800">Tim Pelaksana Proyek</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($project->members as $member)
                        <div class="p-4 sm:px-6 flex items-center justify-between hover:bg-slate-50/50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-sky-600 text-white flex items-center justify-center font-extrabold text-xs uppercase shrink-0">
                                    {{ strtoupper(substr($member->nama_siswa ?? $member->name ?? 'A', 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-800">{{ $member->nama_siswa ?? $member->name }}</h3>
                                    <p class="text-[11px] text-slate-400 font-medium">Peran: {{ $member->peran ?? 'Anggota' }}</p>
                                </div>
                            </div>
                            <div>
                                @if($member->is_leader)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-600 border border-sky-100">
                                        Ketua Proyek
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                        Anggota
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400 font-medium">
                            Tidak ada data anggota tim.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- SIDEBAR (KANAN): Informasi Metadata & Aksi --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6">
                <h2 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-4 pb-3 border-b border-slate-100">
                    Informasi Pengajuan
                </h2>

                <div class="space-y-4 text-xs">
                    <div>
                        <span class="block text-[11px] font-medium text-slate-400">Pengaju / Ketua</span>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $project->creator->name ?? '-' }}</p>
                        <p class="text-[11px] text-slate-400">{{ $project->creator->email ?? '' }}</p>
                    </div>

                    <div>
                        <span class="block text-[11px] font-medium text-slate-400">Daftar Pembimbing</span>
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            @forelse($project->mentors as $mentor)
                                @php
                                    $badgeColor = match($mentor->pivot->tipe) {
                                        'utama' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'industri' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold border {{ $badgeColor }}">
                                    {{ ucfirst($mentor->pivot->tipe) }}: {{ $mentor->name }}
                                </span>
                            @empty
                                <p class="font-semibold text-slate-500">-</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <span class="block text-[11px] font-medium text-slate-400">Tipe Proyek</span>
                        <p class="font-bold text-slate-800 mt-0.5 capitalize">{{ $project->tipe }}</p>
                    </div>

                    <div>
                        <span class="block text-[11px] font-medium text-slate-400">Jangka Waktu Pengerjaan</span>
                        <p class="font-bold text-slate-800 mt-0.5">
                            {{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y') }} — {{ \Carbon\Carbon::parse($project->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                {{-- Download File Proposal --}}
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('industri.pjbl.undangan.download', $project->id) }}" 
                       class="w-full py-2.5 px-4 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200/80 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh Proposal (PDF)
                    </a>
                </div>

                {{-- Action Buttons jika Status Masih Pending --}}
                @if($myStatus === 'pending')
                    <div class="mt-3 space-y-2">
                        <button type="button" 
                                onclick="approveProject('{{ $project->id }}', '{{ addslashes($project->judul) }}')"
                                class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-xs">
                            Setujui Proposal
                        </button>
                        <button type="button" 
                                onclick="rejectProject('{{ $project->id }}', '{{ addslashes($project->judul) }}')"
                                class="w-full py-2.5 px-4 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 rounded-xl text-xs font-bold transition">
                            Tolak / Minta Revisi
                        </button>

                        <form id="approve-form-{{ $project->id }}" action="{{ route('industri.pjbl.undangan.approve', $project->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <form id="reject-form-{{ $project->id }}" action="{{ route('industri.pjbl.undangan.reject', $project->id) }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="catatan_revisi" id="catatan-input-{{ $project->id }}">
                        </form>
                    </div>
                @endif
            </div>
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
        html: `Berikan catatan revisi/penolakan untuk proposal <br><strong class="text-rose-600">"${judul}"</strong>:`,
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Tuliskan alasan penolakan atau perbaikan yang dibutuhkan...',
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