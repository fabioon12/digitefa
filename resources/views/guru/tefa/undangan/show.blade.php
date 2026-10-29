@extends('guru.layouts.app')

@section('title', 'Show Undangan TEFA - CertiLearn')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    
    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('guru.tefa.undangan.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Verifikasi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM UTAMA (KIRI): Detail Proyek & Anggota --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Card Detail Proyek --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 tracking-wide uppercase mb-3">
                            {{ $project->kategori }}
                        </span>
                        <h1 class="text-2xl font-bold text-gray-900 leading-snug">{{ $project->judul }}</h1>
                    </div>
                    <div>
                        @if($project->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending
                            </span>
                        @elseif($project->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <hr class="border-gray-100 my-6">

                <div>
                    <h2 class="text-base font-bold text-gray-900 mb-3">Deskripsi Proyek</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line text-sm">
                        {{ $project->deskripsi }}
                    </p>
                </div>

                {{-- Alert Catatan Revisi jika Ditolak --}}
                @if($project->status === 'rejected' && $project->catatan_revisi)
                    <div class="mt-6 p-4 rounded-xl bg-rose-50 border border-rose-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-bold text-rose-900">Catatan Revisi Guru</h3>
                                <p class="text-xs text-rose-700 mt-1 leading-relaxed">{{ $project->catatan_revisi }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Card Anggota Kelompok --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-base font-bold text-gray-900">Anggota Kelompok</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($project->members as $member)
                        <div class="p-4 sm:px-6 flex items-center justify-between hover:bg-gray-50/50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-gray-600 text-sm">
                                    {{ strtoupper(substr($member->nama_siswa, 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">{{ $member->nama_siswa }}</h3>
                                    <p class="text-xs text-gray-500">Peran: {{ $member->peran }}</p>
                                </div>
                            </div>
                            <div>
                                @if($member->is_leader)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-100 text-indigo-700">
                                        Ketua Proyek
                                    </span>
                                @else
                                    @if($member->status === 'accepted')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Menyetujui Undangan
                                        </span>
                                    @elseif($member->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-rose-100 text-rose-800">
                                            Menolak Undangan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-800">
                                            Pending Undangan
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- SIDEBAR (KANAN): Informasi Metadata & Aksi --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                    Informasi Pengajuan
                </h2>

                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-xs font-medium text-gray-400">Pengaju / Ketua</span>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $project->creator->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $project->creator->email ?? '' }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-medium text-gray-400">Guru Pembimbing</span>
                        
                        @php
                            // Mengambil data dari relasi mentorRecords
                            $mentors = $project->mentorRecords ?? collect();
                            
                            $utamaList = $mentors->where('tipe', 'utama');
                            $umumList = $mentors->where('tipe', 'umum');
                            $industriList = $mentors->where('tipe', 'industri');
                        @endphp

                        <div class="flex flex-wrap gap-1.5 mt-1">
                            <!-- Pembimbing Utama -->
                            @foreach($utamaList as $mentor)
                                @if($mentor->user)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                        <span>Utama: {{ $mentor->user->name }}</span>
                                        @if($mentor->status === 'approved')
                                            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.2 rounded-md font-bold">ACC</span>
                                        @elseif($mentor->status === 'rejected')
                                            <span class="text-[10px] bg-rose-100 text-rose-700 px-1.5 py-0.2 rounded-md font-bold">Ditolak</span>
                                        @else
                                            <span class="text-[10px] bg-amber-100 text-amber-700 px-1.5 py-0.2 rounded-md font-bold">Pending</span>
                                        @endif
                                    </span>
                                @endif
                            @endforeach

                            <!-- Pembimbing Umum -->
                            @foreach($umumList as $mentor)
                                @if($mentor->user)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                        <span>Umum: {{ $mentor->user->name }}</span>
                                        @if($mentor->status === 'approved')
                                            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.2 rounded-md font-bold">ACC</span>
                                        @elseif($mentor->status === 'rejected')
                                            <span class="text-[10px] bg-rose-100 text-rose-700 px-1.5 py-0.2 rounded-md font-bold">Ditolak</span>
                                        @else
                                            <span class="text-[10px] bg-amber-100 text-amber-700 px-1.5 py-0.2 rounded-md font-bold">Pending</span>
                                        @endif
                                    </span>
                                @endif
                            @endforeach

                            <!-- Pembimbing Industri -->
                            @foreach($industriList as $mentor)
                                @if($mentor->user)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        <span>Industri: {{ $mentor->user->name }}</span>
                                        @if($mentor->status === 'approved')
                                            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.2 rounded-md font-bold">ACC</span>
                                        @elseif($mentor->status === 'rejected')
                                            <span class="text-[10px] bg-rose-100 text-rose-700 px-1.5 py-0.2 rounded-md font-bold">Ditolak</span>
                                        @else
                                            <span class="text-[10px] bg-amber-100 text-amber-700 px-1.5 py-0.2 rounded-md font-bold">Pending</span>
                                        @endif
                                    </span>
                                @endif
                            @endforeach

                            <!-- Jika Tidak Ada Pembimbing -->
                            @if($mentors->isEmpty())
                                <p class="font-semibold text-gray-800 mt-0.5">-</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="block text-xs font-medium text-gray-400">Tipe Proyek</span>
                        <p class="font-semibold text-gray-800 mt-0.5 capitalize">{{ $project->tipe }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-medium text-gray-400">Jangka Waktu Pengerjaan</span>
                        <p class="font-semibold text-gray-800 mt-0.5">
                            {{ $project->tanggal_mulai->format('d M Y') }} — {{ $project->tanggal_selesai->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('guru.tefa.undangan.download', $project->id) }}" 
                       class="w-full py-2.5 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh File Proposal (PDF)
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection