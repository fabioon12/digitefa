@extends('guru.layouts.app')

@section('title', 'Pantau Proyek PjBL - CertiLearn')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Information Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="{{ route('guru.pjbl.dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Daftar Proyek
                </a>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Monitoring Proyek Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">
                Proyek: <span class="font-semibold text-slate-700">{{ $project->judul }}</span> 
                <span class="mx-1">•</span> 
                Kelompok: <span class="font-semibold text-indigo-600">{{ $project->nama_kelompok ?? 'Kelompok ' . $project->id }}</span>
            </p>
        </div>

        <!-- Metric Summary Card -->
        <div class="flex items-center gap-4 bg-slate-50 p-3.5 rounded-xl border border-slate-100 min-w-[300px]">
            <div class="flex-1">
                <div class="flex justify-between text-xs font-semibold mb-1.5">
                    <span class="text-slate-500">Progres Keseluruhan</span>
                    <span class="text-indigo-600">{{ $completedCount }}/{{ $totalTasks }} ({{ $progressPercent }}%)</span>
                </div>
                <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota Kelompok Bar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-3">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
            <i class="fa-solid fa-users text-indigo-500"></i> Anggota Kelompok Proyek
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            @forelse($project->members as $member)
                <div class="flex items-center gap-3 p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($member->nama_siswa ?? $member->user->name ?? 'S', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-semibold text-slate-800 truncate">
                            {{ $member->nama_siswa ?? $member->user->name }}
                        </p>
                        <p class="text-[10px] text-slate-500 font-medium truncate">
                            {{ $member->peran ?? 'Anggota' }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic col-span-full">Belum ada anggota terdaftar di proyek ini.</p>
            @endforelse
        </div>
    </div>

    <!-- Read-Only Kanban Board Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

        <!-- KOLOM 1: TO DO -->
        <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-200/60 flex flex-col h-fit">
            <div class="flex items-center justify-between px-1 mb-3 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Akan Dikerjakan</h2>
                </div>
                <span class="text-xs font-bold bg-slate-200 text-slate-600 px-2 py-0.5 rounded-full">
                    {{ $todoTasks->count() }}
                </span>
            </div>

            <div class="space-y-2.5 max-h-[520px] overflow-y-auto pr-1.5 custom-scrollbar">
                @forelse($todoTasks as $task)
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-sm space-y-2.5">
                        <div class="space-y-1">
                            <h3 class="text-xs font-semibold text-slate-800 leading-snug">
                                <span class="text-slate-400 font-normal mr-1">{{ $loop->iteration }}.</span>{{ $task->judul_tugas }}
                            </h3>
                            @if($task->deskripsi)
                                <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed pl-4">{{ $task->deskripsi }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between text-[10px] pt-2 border-t border-slate-100 text-slate-400">
                            @if($task->deadline)
                                <span class="flex items-center gap-1 font-medium text-slate-500">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">Tanpa Tenggat</span>
                            @endif

                            @if($task->assignedUser)
                                <div class="w-5 h-5 rounded-full bg-slate-200 text-slate-700 font-bold text-[8px] flex items-center justify-center shrink-0" title="PJ: {{ $task->assignedUser->name }}">
                                    {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs border-2 border-dashed border-slate-200/80 rounded-xl">
                        Tidak ada tugas terdaftar
                    </div>
                @endforelse
            </div>
        </div>

        <!-- KOLOM 2: IN PROGRESS -->
        <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-200/60 flex flex-col h-fit">
            <div class="flex items-center justify-between px-1 mb-3 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Sedang Dikerjakan</h2>
                </div>
                <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">
                    {{ $inProgressTasks->count() }}
                </span>
            </div>

            <div class="space-y-2.5 max-h-[520px] overflow-y-auto pr-1.5 custom-scrollbar">
                @forelse($inProgressTasks as $task)
                    <div class="bg-white p-3.5 rounded-xl border border-indigo-100 shadow-sm space-y-2.5">
                        <div class="space-y-1">
                            <h3 class="text-xs font-semibold text-slate-800 leading-snug flex items-start gap-1">
                                <span class="text-indigo-400 font-normal shrink-0">{{ $loop->iteration }}.</span>
                                <span>{{ $task->judul_tugas }}</span>
                            </h3>
                            <div class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-indigo-50 text-[9px] font-bold text-indigo-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-ping"></span>
                                In Progress
                            </div>
                            @if($task->deskripsi)
                                <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed pl-4">{{ $task->deskripsi }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between text-[10px] pt-2 border-t border-slate-100 text-slate-400">
                            @if($task->deadline)
                                <span class="flex items-center gap-1 font-medium text-slate-500">
                                    <i class="fa-regular fa-clock text-indigo-500"></i>
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">Tanpa Tenggat</span>
                            @endif

                            @if($task->assignedUser)
                                <div class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-700 font-bold text-[8px] flex items-center justify-center shrink-0" title="PJ: {{ $task->assignedUser->name }}">
                                    {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs border-2 border-dashed border-slate-200/80 rounded-xl">
                        Tidak ada tugas aktif
                    </div>
                @endforelse
            </div>
        </div>

        <!-- KOLOM 3: COMPLETED -->
        <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-200/60 flex flex-col h-fit">
            <div class="flex items-center justify-between px-1 mb-3 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Selesai</h2>
                </div>
                <span class="text-xs font-bold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">
                    {{ $completedTasks->count() }}
                </span>
            </div>

            <div class="space-y-2.5 max-h-[520px] overflow-y-auto pr-1.5 custom-scrollbar">
                @forelse($completedTasks as $task)
                    <div class="bg-white/80 p-3.5 rounded-xl border border-slate-200/80 shadow-sm space-y-2.5">
                        <div class="flex items-start justify-between gap-2">
                            <div class="space-y-1">
                                <h3 class="text-xs font-semibold leading-snug flex items-start gap-1">
                                    <span class="text-slate-400 font-normal shrink-0">{{ $loop->iteration }}.</span>
                                    <span class="text-slate-600 line-through">{{ $task->judul_tugas }}</span>
                                </h3>
                                @if($task->deskripsi)
                                    <p class="text-[11px] text-slate-400 line-clamp-2 leading-relaxed line-through pl-4">{{ $task->deskripsi }}</p>
                                @endif
                            </div>

                            <a href="{{ route('guru.pjbl.tasks.show', [$project->id, $task->id]) }}" 
                            class="inline-flex items-center justify-center text-[10px] font-bold px-2 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 transition-colors shrink-0" 
                            title="Tinjau Hasil Pekerjaan">
                                <i class="fa-solid fa-eye text-[10px] mr-1"></i> Tinjau
                            </a>
                        </div>

                        <div class="flex items-center justify-between text-[10px] pt-2 border-t border-slate-100 text-slate-400">
                            <span class="flex items-center gap-1 font-medium text-emerald-600">
                                <i class="fa-solid fa-circle-check"></i> Selesai
                            </span>

                            @if($task->latestSubmission && $task->latestSubmission->user)
                                <div class="flex items-center gap-1.5 bg-emerald-50 px-2 py-1 rounded-full border border-emerald-100" title="Dikumpulkan oleh: {{ $task->latestSubmission->user->name }}">
                                    <div class="w-4 h-4 rounded-full bg-emerald-500 text-white font-bold text-[7px] flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($task->latestSubmission->user->name, 0, 2)) }}
                                    </div>
                                    <span class="text-[9px] font-semibold text-emerald-700 max-w-[90px] truncate">
                                        {{ $task->latestSubmission->user->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-xs border-2 border-dashed border-slate-200/80 rounded-xl">
                        Belum ada tugas selesai
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection