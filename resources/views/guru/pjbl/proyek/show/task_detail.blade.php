@extends('guru.layouts.app')

@section('title', 'Tinjau Tugas - CertiLearn')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('guru.pjbl.monitor', $project->id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Monitor Proyek
        </a>
        <span class="text-xs px-2.5 py-1 rounded-full font-bold uppercase tracking-wider
            @if($task->status === 'completed') bg-emerald-100 text-emerald-700
            @elseif($task->status === 'in_progress') bg-indigo-100 text-indigo-700
            @else bg-slate-200 text-slate-600 @endif">
            Status: {{ str_replace('_', ' ', $task->status) }}
        </span>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-xl flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                {{ session('success') }}
            </span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Card Informasional Tugas -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 leading-tight">{{ $task->judul_tugas }}</h1>
            <p class="text-xs text-slate-500 mt-1">
                Proyek: <span class="font-semibold text-slate-700">{{ $project->judul }}</span>
            </p>
        </div>

        @if($task->deskripsi)
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                <h4 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Deskripsi Tugas</h4>
                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $task->deskripsi }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-2 border-t border-slate-100">
            <div class="space-y-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                <span class="text-xs font-bold text-slate-600 block uppercase tracking-wider">
                    <i class="fa-solid fa-users text-indigo-500 mr-1"></i> Tim Pembimbing Proyek
                </span>

                @php
                    // Filter mentor berdasarkan tipe dan status dari relasi pivot project_mentors
                    $allMentors = $task->project->mentors ?? collect();
                    
                    $pembimbingUtama    = $allMentors->where('pivot.tipe', 'utama')->where('pivot.status', 'approved');
                    $pembimbingUmum     = $allMentors->where('pivot.tipe', 'umum')->where('pivot.status', 'approved');
                    $pembimbingIndustri = $allMentors->where('pivot.tipe', 'industri')->where('pivot.status', 'approved');
                @endphp

                <!-- List Pembimbing Utama -->
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wide block">
                        Pembimbing Utama:
                    </span>
                    @if($pembimbingUtama->count() > 0)
                        <ul class="space-y-1 pl-1">
                            @foreach($pembimbingUtama as $mentor)
                                <li class="flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                    <i class="fa-solid fa-user-tie text-indigo-500 text-[11px]"></i>
                                    <span>{{ $mentor->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-slate-400 italic text-[11px] block pl-1">- Belum ada -</span>
                    @endif
                </div>

                <!-- List Pembimbing Umum -->
                <div class="space-y-1 pt-1 border-t border-slate-200/60">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block">
                        Pembimbing Umum:
                    </span>
                    @if($pembimbingUmum->count() > 0)
                        <ul class="space-y-1 pl-1">
                            @foreach($pembimbingUmum as $mentor)
                                <li class="flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                    <i class="fa-regular fa-user text-slate-500 text-[11px]"></i>
                                    <span>{{ $mentor->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-slate-400 italic text-[11px] block pl-1">- Belum ada -</span>
                    @endif
                </div>

                <!-- List Pembimbing Industri -->
                <div class="space-y-1 pt-1 border-t border-slate-200/60">
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide block">
                        Pembimbing Industri:
                    </span>
                    @if($pembimbingIndustri->count() > 0)
                        <ul class="space-y-1 pl-1">
                            @foreach($pembimbingIndustri as $mentor)
                                <li class="flex items-center gap-1.5 text-xs font-semibold text-slate-700">
                                    <i class="fa-solid fa-building-user text-emerald-500 text-[11px]"></i>
                                    <span>{{ $mentor->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-slate-400 italic text-[11px] block pl-1">- Belum ada -</span>
                    @endif
                </div>
            </div>

            <!-- Informasi Deadline -->
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 flex flex-col justify-center">
                <span class="text-slate-400 block font-medium">Tenggat Waktu (Deadline)</span>
                <span class="font-semibold text-slate-700 flex items-center gap-1.5 mt-0.5">
                    <i class="fa-regular fa-calendar text-amber-500"></i>
                    {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d F Y') : 'Tanpa Tenggat' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Form Penilaian & Review -->
    <form action="{{ route('guru.pjbl.tasks.review', [$project->id, $task->id]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Riwayat Pengumpulan Siswa -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-file-arrow-up text-indigo-600"></i> Berkas & Hasil Pengumpulan Siswa
            </h3>

            @forelse($task->submissions as $submission)
                <div class="p-4 rounded-xl border border-slate-200/70 bg-slate-50/50 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-emerald-500 text-white font-bold text-xs flex items-center justify-center">
                                {{ strtoupper(substr($submission->user->name ?? 'S', 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $submission->user->name ?? 'Siswa' }}</p>
                                <p class="text-[10px] text-slate-400">
                                    Waktu Submit: {{ $submission->created_at ? $submission->created_at->format('d M Y, H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($submission->catatan)
                        <div class="text-xs text-slate-600 bg-white p-3 rounded-lg border border-slate-100">
                            <span class="font-semibold text-slate-700 block mb-0.5">Catatan Siswa:</span>
                            {{ $submission->catatan }}
                        </div>
                    @endif

                    <!-- Lampiran File PDF & Link Pengerjaan -->
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        @if($submission->file_berkas)
                            <a href="{{ asset('storage/' . $submission->file_berkas) }}" target="_blank" 
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-file-pdf text-rose-600 text-sm"></i>
                                <span>Buka Dokumen PDF</span>
                            </a>
                        @endif

                        @if($submission->link_lampiran)
                            <a href="{{ $submission->link_lampiran }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-xl text-xs font-semibold transition-colors">
                                <i class="fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                <span>Buka Link Pengerjaan</span>
                            </a>
                        @endif
                    </div>

                    <!-- Input Catatan Guru Khusus untuk Lembar Pengumpulan Ini (TaskModel ID) -->
                    <div class="pt-2 border-t border-slate-200/60 space-y-3">
                        
                        <!-- 1. Tampilkan Daftar Catatan dari Semua Guru/Mentor -->
                        @if(!empty($submission->catatan_guru) && count($submission->catatan_guru) > 0)
                            <div class="space-y-2">
                                <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                    <i class="fa-solid fa-comments text-indigo-500 mr-1"></i> Catatan Mentor Lain / Sebelumnya:
                                </span>
                                
                                <div class="space-y-1.5">
                                    @foreach($submission->catatan_guru as $guruId => $dataCatatan)
                                        <div class="p-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs space-y-0.5">
                                            <div class="flex items-center justify-between text-[10px]">
                                                <span class="font-bold text-indigo-700 flex items-center gap-1">
                                                    <i class="fa-solid fa-user-tie text-[9px]"></i> {{ $dataCatatan['nama_guru'] ?? 'Mentor' }}
                                                </span>
                                                <span class="text-slate-400 text-[9px]">{{ $dataCatatan['updated_at'] ?? '' }}</span>
                                            </div>
                                            <p class="text-slate-700 leading-relaxed italic">"{{ $dataCatatan['catatan'] }}"</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- 2. Form Input/Edit Catatan khusus Guru yang Sedang Login -->
                        @php
                            $myNote = $submission->catatan_guru[auth()->id()]['catatan'] ?? '';
                        @endphp

                        <div class="space-y-1">
                            <label for="catatan_submission_{{ $submission->id }}" class="block text-[11px] font-bold text-indigo-700 flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square"></i> Catatan Anda ({{ auth()->user()->name }}):
                            </label>
                            
                            <textarea 
                                name="catatan_submission[{{ $submission->id }}]" 
                                id="catatan_submission_{{ $submission->id }}" 
                                rows="2" 
                                placeholder="Tulis masukan spesifik Anda untuk berkas/jawaban siswa ini..."
                                class="w-full p-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-indigo-500 transition-all leading-relaxed">{{ old('catatan_submission.'.$submission->id, $myNote) }}</textarea>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs border-2 border-dashed border-slate-200 rounded-xl">
                    Belum ada pengumpulan berkas dari siswa untuk tugas ini.
                </div>
            @endforelse
            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-sm transition-colors">
                    <i class="fa-solid fa-paper-plane"></i> Simpan Semua Catatan & Status
                </button>
            </div>
        </div>
    </form>

</div>
@endsection