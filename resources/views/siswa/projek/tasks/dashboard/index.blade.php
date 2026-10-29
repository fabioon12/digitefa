@extends('siswa.layouts.app')

@section('title', 'Tasks Proyek PjBL - CertiLearn')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Progress Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="{{ route('siswa.pjbl.dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Dashboard PjBL
                </a>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Task Management Board</h1>
            <p class="text-xs text-slate-500 mt-1">
                Proyek: <span class="font-semibold text-slate-700">{{ $project->judul }}</span>
            </p>
        </div>

        <!-- Metric & Action -->
        <div class="flex items-center gap-4 bg-slate-50 p-3.5 rounded-xl border border-slate-100 min-w-[280px]">
            <div class="flex-1">
                <div class="flex justify-between text-xs font-semibold mb-1.5">
                    <span class="text-slate-500">Progres Selesai</span>
                    <span class="text-indigo-600">{{ $completedCount }}/{{ $totalTasks }} ({{ $progressPercent }}%)</span>
                </div>
                <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                    <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>
            <button onclick="document.getElementById('modalTambahTask').classList.remove('hidden')" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition-all shrink-0 flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Tugas Baru</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi -->
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


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

    <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-200/80 flex flex-col h-fit">
        <div class="flex items-center justify-between px-1 mb-3.5 shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 ring-4 ring-amber-400/20"></span>
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Akan Dikerjakan</h2>
            </div>
            <span class="text-[11px] font-bold bg-amber-100/80 text-amber-800 px-2.5 py-0.5 rounded-full border border-amber-200/50 shadow-2xs">
                {{ $todoTasks->count() }}
            </span>
        </div>
        
        <div class="space-y-3 max-h-[580px] overflow-y-auto pr-1.5 custom-scrollbar">
            @forelse($todoTasks as $task)
                @php
                    $isExpired = false;
                    
                    if (!empty($task->deadline)) {
                        // Cek 1: Deadline tugas itu sendiri sudah lewat hari ini
                        $isTaskPast = \Carbon\Carbon::parse($task->deadline)->endOfDay()->isPast();
                        
                        // Cek 2: Deadline tugas melebihi tanggal selesai proyek utama
                        $isProjectPast = !empty($project->tanggal_selesai) && \Carbon\Carbon::parse($task->deadline)->gt(\Carbon\Carbon::parse($project->tanggal_selesai)->endOfDay());
                        
                        $isExpired = $isTaskPast || $isProjectPast;
                    } elseif (!empty($project->tanggal_selesai)) {
                        // Cek 3: Proyek utama sudah lewat meskipun tugas tanpa deadline
                        $isExpired = \Carbon\Carbon::parse($project->tanggal_selesai)->endOfDay()->isPast();
                    }
                @endphp

                <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs space-y-3 transition-all duration-200 hover:shadow-md hover:border-indigo-200 group">
                    
                    <!-- Konten Utama: Judul & Deskripsi + Tombol Hapus Utama -->
                    <div class="flex items-start justify-between gap-2">
                        <div class="space-y-1.5 min-w-0 flex-1">
                            <a href="{{ route('siswa.pjbl.tasks.show', [$project, $task->id]) }}" class="text-xs font-semibold text-slate-800 leading-snug hover:text-indigo-600 transition-colors block break-words">
                                <span class="text-slate-400 font-normal mr-1">{{ $loop->iteration }}.</span>{{ $task->judul_tugas }}
                            </a>

                            @if($task->deskripsi)
                                <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $task->deskripsi }}</p>
                            @endif
                        </div>

                        <!-- Tombol Hapus Tugas -->
                        <form action="{{ route('siswa.pjbl.tasks.destroy', [$project->id, $task->id]) }}" 
                            method="POST" 
                            onsubmit="confirmDeleteTask(event, this)" 
                            class="shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-slate-400 hover:text-rose-600 transition-colors p-1.5 rounded-lg hover:bg-rose-50" 
                                    title="Hapus Tugas">
                                <i class="fa-regular fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Footer Card: Meta & Tombol Aksi -->
                    <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2">
                        
                        <!-- Meta Info: Deadline & Assignee -->
                        <div class="flex items-center gap-2 text-[10px] text-slate-400 min-w-0">
                            @if($task->deadline)
                                <span class="inline-flex items-center gap-1.5 font-medium {{ $isExpired ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-slate-600 bg-slate-50 border-slate-200/60' }} px-2 py-0.5 rounded-md border shrink-0">
                                    <i class="fa-regular fa-clock {{ $isExpired ? 'text-rose-500' : 'text-amber-500' }}"></i>
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300 italic shrink-0">Tanpa Tenggat</span>
                            @endif

                            @if($task->assignedUser)
                                <div class="w-6 h-6 rounded-full bg-slate-100 border border-slate-200 text-slate-600 font-bold text-[9px] flex items-center justify-center shrink-0 shadow-2xs" title="Penanggung Jawab: {{ $task->assignedUser->name }}">
                                    {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="shrink-0">
                            @if($isExpired)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 border border-rose-100" title="Tenggat waktu pengerjaan telah berakhir">
                                    <i class="fa-solid fa-lock text-[8px]"></i>
                                    <span>Kadaluarsa</span>
                                </span>
                            @else
                                <form action="{{ route('siswa.pjbl.tasks.update-status', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 text-[10px] font-bold px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white transition-all shadow-2xs hover:shadow-xs" 
                                            title="Mulai kerjakan tugas ini">
                                        <span>Mulai Kerjakan</span>
                                        <i class="fa-solid fa-arrow-right text-[8px] transition-transform group-hover:translate-x-0.5"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-400 text-xs border-2 border-dashed border-slate-200/80 rounded-xl bg-white/40 space-y-1">
                    <i class="fa-regular fa-folder-open text-base text-slate-300 block mb-1"></i>
                    <p>Tidak ada tugas tersisa</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- KOLOM 2: IN PROGRESS -->
    <div class="bg-indigo-50/40 rounded-2xl p-4 border border-indigo-100/80 flex flex-col h-fit">
        <!-- Header Kolom -->
        <div class="flex items-center justify-between px-1 mb-3.5 shrink-0">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                </span>
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Sedang Dikerjakan</h2>
            </div>
            <span class="text-[11px] font-bold bg-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-full border border-indigo-200/60">
                {{ $inProgressTasks->count() }}
            </span>
        </div>

        <!-- Area List Task -->
        <div class="space-y-3 max-h-[580px] overflow-y-auto pr-1.5 custom-scrollbar">
            @forelse($inProgressTasks as $task)
                @php
                    $isExpired = false;
                    if (!empty($task->deadline)) {
                        $isExpired = \Carbon\Carbon::parse($task->deadline)->endOfDay()->isPast();
                    } elseif (isset($diffInDays) && $diffInDays < 0) {
                        $isExpired = true;
                    }
                @endphp

                <div class="bg-white p-4 rounded-xl border border-indigo-100/80 shadow-sm space-y-3 transition-all duration-200 hover:shadow-md hover:border-indigo-200">
                    
                    <!-- Bagian Atas: Konten Judul & Status -->
                    <div class="space-y-1.5 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <!-- Penomoran ditambahkan di sini -->
                            <a href="{{ route('siswa.pjbl.tasks.show', [$project, $task->id]) }}" class="text-xs font-semibold text-slate-800 leading-snug hover:text-indigo-600 transition-colors block break-words">
                                <span class="text-indigo-600 font-bold mr-1">{{ $loop->iteration }}.</span>{{ $task->judul_tugas }}
                            </a>

                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-100 text-[9px] font-bold text-indigo-600 shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                {{ str_replace('_', ' ', strtoupper($task->status)) }}
                            </div>
                        </div>

                        @if($task->deskripsi)
                            <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $task->deskripsi }}</p>
                        @endif
                    </div>

                    <!-- Bagian Bawah: Meta Info & Aksi Tombol -->
                    <div class="pt-2.5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                        
                        <!-- Info Deadline & User -->
                        <div class="flex items-center gap-2 text-[10px] text-slate-400">
                            @if($task->deadline)
                                <span class="inline-flex items-center gap-1.5 font-medium {{ $isExpired ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-slate-500 bg-slate-50 border-slate-100' }} px-2 py-0.5 rounded-md border">
                                    <i class="fa-regular fa-clock {{ $isExpired ? 'text-rose-500' : 'text-indigo-500' }}"></i>
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300 italic">Tanpa Tenggat</span>
                            @endif

                            @if($task->assignedUser)
                                <div class="w-6 h-6 rounded-full bg-indigo-100 border border-indigo-200 text-indigo-700 font-bold text-[9px] flex items-center justify-center shrink-0 shadow-xs" title="Penanggung Jawab: {{ $task->assignedUser->name }}">
                                    {{ strtoupper(substr($task->assignedUser->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Aksi di Bawah -->
                        <div class="flex items-center gap-2 justify-end">
                            @if($isExpired)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 border border-rose-100" title="Tenggat waktu pengerjaan telah berakhir">
                                    <i class="fa-solid fa-lock text-[8px]"></i>
                                    <span>Kadaluarsa</span>
                                </span>
                            @else
                                <!-- Tombol Kerjakan / Buka Tugas -->
                                @if($task->status === 'todo')
                                    <form action="{{ route('siswa.pjbl.tasks.update-status', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="in_progress">
                                        <button type="submit" class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white transition-colors shadow-xs" title="Mulai kerjakan tugas">
                                            <span>Mulai Kerjakan</span>
                                            <i class="fa-solid fa-play text-[8px]"></i>
                                        </button>
                                    </form>
                                @elseif($task->status === 'in_progress')
                                    <a href="{{ route('siswa.pjbl.tasks.show', [$project, $task->id]) }}" class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 border border-indigo-200/60 transition-colors" title="Buka Detail & Kumpulkan Tugas">
                                        <span>Buka Tugas</span>
                                        <i class="fa-solid fa-arrow-right text-[8px]"></i>
                                    </a>
                                @endif
                                <!-- Tombol Selesai -->
                                <form action="{{ route('siswa.pjbl.tasks.update-status', $task->id) }}" method="POST" class="form-complete-task">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="button" class="btn-selesai inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition-colors shadow-xs" title="Tandai selesai">
                                        <span>Selesai</span>
                                        <i class="fa-solid fa-check text-[9px]"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-400 text-xs border-2 border-dashed border-indigo-200/60 rounded-xl bg-white/40">
                    Tidak ada tugas aktif
                </div>
            @endforelse
        </div>
    </div>

    <!-- KOLOM 3: COMPLETED -->
    <div class="bg-emerald-50/40 rounded-2xl p-4 border border-emerald-100/80 flex flex-col h-fit">
        <div class="flex items-center justify-between px-1 mb-3.5 shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Selesai</h2>
            </div>
            <span class="text-[11px] font-bold bg-emerald-100 text-emerald-700 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                {{ $completedTasks->count() }}
            </span>
        </div>

        <div class="space-y-3 max-h-[580px] overflow-y-auto pr-1.5 custom-scrollbar">
            @forelse($completedTasks as $task)
                @php
                    $isExpired = false;
                    if (!empty($task->deadline)) {
                        $isExpired = \Carbon\Carbon::parse($task->deadline)->endOfDay()->isPast();
                    } elseif (isset($diffInDays) && $diffInDays < 0) {
                        $isExpired = true;
                    }
                @endphp

                <div class="bg-white/90 p-4 rounded-xl border border-slate-200/80 shadow-sm space-y-3 transition-all duration-200 hover:bg-white hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div class="space-y-1 min-w-0 flex-1">
                            <!-- Penomoran disesuaikan dengan styling bold emerald -->
                            <h3 class="text-xs font-semibold text-slate-500 line-through leading-snug break-words">
                                <span class="text-emerald-600 font-bold mr-1 no-underline inline-block">{{ $loop->iteration }}.</span>{{ $task->judul_tugas }}
                            </h3>
                            @if($task->deskripsi)
                                <p class="text-[11px] text-slate-400 line-clamp-2 leading-relaxed line-through">{{ $task->deskripsi }}</p>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-1 shrink-0">
                            <a href="{{ route('siswa.pjbl.tasks.show', [$project, $task->id]) }}" 
                            class="inline-flex items-center justify-center p-2 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-600 transition-colors border border-sky-100" 
                            title="Lihat Pekerjaan">
                                <i class="fa-solid fa-eye text-[11px]"></i>
                            </a>

                            @if(!$isExpired)
                                <form action="{{ route('siswa.pjbl.tasks.update-status', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="todo">
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 transition-colors border border-slate-200/60" 
                                            title="Kembalikan ke Todo">
                                        <i class="fa-solid fa-rotate-left text-[11px]"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Tombol Hapus Tugas (Selesai) -->
                            <form action="{{ route('siswa.pjbl.tasks.destroy', [$project->id, $task->id]) }}" 
                                method="POST" 
                                onsubmit="confirmDeleteTask(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition-colors border border-rose-100" 
                                        title="Hapus Tugas">
                                    <i class="fa-regular fa-trash-can text-[11px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[10px] pt-2.5 border-t border-slate-100 text-slate-400">
                        <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600 bg-emerald-50/80 px-2 py-0.5 rounded-md border border-emerald-100">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Selesai
                        </span>

                        <div class="flex items-center gap-1.5 shrink-0">
                            @if($task->latestSubmission && $task->latestSubmission->user)
                                @php
                                    $user = $task->latestSubmission->user;
                                    $submitterMember = $project->members->firstWhere('user_id', $user->id);

                                    if (!$submitterMember) {
                                        $submitterMember = $project->members->first(function ($member) use ($user) {
                                            return strcasecmp(trim($member->nama_siswa), trim($user->name)) === 0;
                                        });
                                    }
                                @endphp

                                <div class="flex items-center gap-1.5 bg-emerald-50/80 px-2 py-1 rounded-lg border border-emerald-100/80" 
                                    title="Dikumpulkan oleh: {{ $user->name }}">
                                    <div class="w-4 h-4 rounded-full bg-emerald-500 text-white font-bold text-[7px] flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col leading-tight">
                                        <span class="text-[9px] font-semibold text-emerald-800 max-w-[75px] truncate">
                                            {{ $user->name }}
                                        </span>
                                        <span class="text-[7.5px] font-medium text-emerald-600/90 max-w-[75px] truncate">
                                            {{ $submitterMember->peran ?? 'Anggota' }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <span class="text-[9px] text-slate-400 italic">Tanpa pengerja</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-400 text-xs border-2 border-dashed border-emerald-200/60 rounded-xl bg-white/40">
                    Belum ada tugas selesai
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Tambah Task -->
    <div id="modalTambahTask" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-800">Tambah Tugas Baru</h3>
                <button onclick="document.getElementById('modalTambahTask').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('siswa.pjbl.tasks.store', $project->id) }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama / Judul Tugas</label>
                    <input type="text" name="judul_tugas" required placeholder="Contoh: Membuat Desain Wireframe UI" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" required placeholder="Masukkan deskripsi..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none"></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tenggat Waktu (Deadline)</label>
                    <input type="date" 
                        name="deadline" 
                        min="{{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('Y-m-d') }}" 
                        max="{{ \Carbon\Carbon::parse($project->tanggal_selesai)->format('Y-m-d') }}"
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    
                    @if($project->tanggal_mulai && $project->tanggal_selesai)
                        <p class="text-[10px] text-slate-400 mt-1">
                            Batas tanggal: {{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($project->tanggal_selesai)->format('d M Y') }}
                        </p>
                    @endif
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalTambahTask').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition-all">
                        Simpan Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
<!-- CDN SweetAlert2 (Pasang di head atau sebelum script script jika belum ada) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua tombol dengan class .btn-selesai
        const finishButtons = document.querySelectorAll('.btn-selesai');

        finishButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Selesaikan Tugas?',
                    text: "Status tugas ini akan diubah menjadi Selesai (Completed)!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981', // warna emerald-500
                    cancelButtonColor: '#64748b',  // warna slate-500
                    confirmButtonText: 'Ya, Selesaikan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
                        cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
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
<script>
    function confirmDeleteTask(event, form) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus Tugas?',
            text: "Seluruh progres dan riwayat pekerjaan dalam tugas ini akan terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl text-xs font-semibold px-4 py-2',
                cancelButton: 'rounded-xl text-xs font-semibold px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
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