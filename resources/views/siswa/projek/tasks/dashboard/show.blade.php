@extends('siswa.layouts.app')

@section('title', 'Tasks Proyek PjBL - CertiLearn')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('siswa.pjbl.tasks.index', $task->project_id) }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Board Task
        </a>
        
        <span class="px-3 py-1 rounded-full text-xs font-bold border flex items-center gap-1.5 
            {{ $task->status === 'completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($task->status === 'in_progress' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-slate-50 text-slate-600 border-slate-200') }}">
            <span class="w-2 h-2 rounded-full {{ $task->status === 'completed' ? 'bg-emerald-500' : ($task->status === 'in_progress' ? 'bg-amber-500 animate-pulse' : 'bg-slate-400') }}"></span>
            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
        </span>
    </div>

    <!-- Alert Success & Error Notification -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                <span>Terjadi kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside pl-2 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Workspace Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Kolom Kiri: Detail Deskripsi, Form Tambah Progres & Riwayat (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Information Box -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h1 class="text-xl font-bold text-slate-800">{{ $task->judul_tugas }}</h1>
                
                <div class="text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    <h4 class="font-bold text-slate-700 mb-1">Instruksi / Catatan Task:</h4>
                    <p class="text-slate-500 whitespace-pre-line">{{ $task->deskripsi ?? 'Belum ada deskripsi instruksi tambahan untuk tugas ini.' }}</p>
                </div>
            </div>

            <!-- Form Submisi Progres Baru -->
            @if($task->status !== 'completed')
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-indigo-500"></i> Tambah Progres Lembar Kerja
                    </h2>

                    <form action="{{ route('siswa.pjbl.tasks.progress.store', ['projectId' => $project->id, 'taskId' => $task->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Catatan Progress / Hasil Kerja <span class="text-rose-500">*</span></label>
                            <textarea name="catatan" rows="4" required placeholder="Tuliskan catatan progress, hasil analisa, atau rangkuman pengerjaan di sini..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none">{{ old('catatan') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Link Lampiran (Google Drive / GitHub / Figma)</label>
                            <input type="url" name="link_lampiran" value="{{ old('link_lampiran') }}" placeholder="https://..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Upload File Berkas (Opsional, Maks 10MB)</label>
                            <input type="file" name="file_berkas" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        </div>

                        <div class="pt-2 flex items-center justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Tambah Progres</span>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span>Tugas ini telah ditandai selesai. Pengisian progres baru telah dikunci.</span>
                </div>
            @endif

            <!-- Riwayat Progres yang Sudah Diunggah -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-indigo-500"></i> Riwayat & Hasil Pekerjaan
                    </span>
                    <span class="text-xs font-semibold text-slate-400">
                        {{ $task->progresses ? $task->progresses->count() : 0 }} Entri
                    </span>
                </h2>

                <div class="space-y-4 pt-2">
                    @forelse($task->progresses ?? [] as $progress)
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 space-y-3 group">
                            <!-- Header Progres: Pengunggah, Waktu, & Tombol Hapus -->
                            <div class="flex items-center justify-between border-b border-slate-200/60 pb-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 font-bold text-[9px] flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($progress->user->name ?? 'User', 0, 2)) }}
                                    </div>
                                    <span class="text-xs font-semibold text-slate-700">{{ $progress->user->name ?? 'Siswa' }}</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] text-slate-400">
                                        {{ \Carbon\Carbon::parse($progress->created_at)->diffForHumans() }}
                                    </span>

                                    <form action="{{ route('siswa.pjbl.tasks.progress.destroy', [$project->id, $task->id, $progress->id]) }}" 
                                        method="POST" 
                                        onsubmit="confirmDelete(event, this)"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors p-1 rounded-md hover:bg-rose-50" title="Hapus">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Catatan Progres Siswa -->
                            <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $progress->catatan }}</p>

                            <!-- Lampiran File / Link -->
                            @if($progress->link_lampiran || $progress->file_berkas)
                                <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-slate-100">
                                    @if($progress->link_lampiran)
                                        <a href="{{ $progress->link_lampiran }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-[11px] font-semibold transition-colors">
                                            <i class="fa-solid fa-link text-[10px]"></i>
                                            <span>Buka Link Lampiran</span>
                                        </a>
                                    @endif

                                    @if($progress->file_berkas)
                                        <a href="{{ asset('storage/' . $progress->file_berkas) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 text-[11px] font-semibold transition-colors">
                                            <i class="fa-solid fa-paperclip text-[10px]"></i>
                                            <span>Unduh Berkas</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Catatan / Ulasan Guru & Mentor -->
                            @if(!empty($progress->catatan_guru) && count($progress->catatan_guru) > 0)
                                <div class="mt-3 pt-3 border-t border-indigo-100/80 space-y-2">
                                    <span class="block text-[10px] font-bold text-indigo-700 uppercase tracking-wider flex items-center gap-1">
                                        <i class="fa-solid fa-comment-dots text-indigo-500"></i> Catatan Pembimbing:
                                    </span>
                                    
                                    <div class="space-y-2">
                                        @foreach($progress->catatan_guru as $guruId => $dataCatatan)
                                            <div class="p-2.5 bg-indigo-50/60 border border-indigo-100 rounded-xl text-xs space-y-1">
                                                <div class="flex items-center justify-between text-[10px]">
                                                    <span class="font-bold text-indigo-800 flex items-center gap-1">
                                                        <i class="fa-solid fa-user-tie text-[9px] text-indigo-600"></i>
                                                        {{ $dataCatatan['nama_guru'] ?? 'Mentor' }}
                                                    </span>
                                                    <span class="text-slate-400 text-[9px]">
                                                        {{ $dataCatatan['updated_at'] ?? '' }}
                                                    </span>
                                                </div>
                                                <p class="text-slate-700 leading-relaxed italic">
                                                    "{{ $dataCatatan['catatan'] }}"
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs border-2 border-dashed border-slate-200 rounded-xl">
                            Belum ada progres yang ditambahkan untuk tugas ini.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Panel Meta & Selesaikan Task (1/3) -->
        <div class="space-y-6">

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Tugas</h3>

                <div class="space-y-3">
                    <div class="flex items-center gap-2.5 text-xs">
                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400">Tenggat Waktu</span>
                            <span class="font-bold text-slate-700">
                                {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : 'Tanpa Tenggat' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 text-xs">
                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[10px] text-slate-400 font-medium">Guru Pembimbing / Mentor</span>
                            
                            @php
                                $guruUtama = $task->project->nama_guru_utama ?? [];
                                $guruUmum = $task->project->nama_guru_umum ?? [];
                                $semuaPembimbing = array_merge($guruUtama, $guruUmum);
                            @endphp

                            @if(!empty($semuaPembimbing))
                                <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                    <!-- Guru Utama Badge -->
                                    @foreach($guruUtama as $guru)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md" title="Pembimbing Utama">
                                            <i class="fa-solid fa-user-tie text-[10px] text-indigo-500"></i>
                                            {{ $guru }}
                                        </span>
                                    @endforeach

                                    <!-- Guru Umum Badge -->
                                    @foreach($guruUmum as $guru)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-700 bg-slate-100 border border-slate-200/80 px-2 py-0.5 rounded-md" title="Pembimbing Umum">
                                            <i class="fa-regular fa-user text-[10px] text-slate-500"></i>
                                            {{ $guru }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs font-semibold text-slate-400 italic block">
                                    Belum Ditentukan
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    @if($task->status !== 'completed')
                        <form id="form-complete-{{ $task->id }}" action="{{ route('siswa.pjbl.tasks.update-status', $task->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            
                            <button type="button" 
                                    onclick="confirmComplete({{ $task->id }})" 
                                    class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Tandai Task Selesai</span>
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check-double text-emerald-500"></i>
                            <span>Tugas Telah Selesai</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmComplete(taskId) {
        Swal.fire({
            title: 'Selesaikan Tugas?',
            text: "Status tugas akan diubah menjadi selesai!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669', // Warna hijau emerald
            cancelButtonColor: '#64748b',  // Warna slate
            confirmButtonText: 'Ya, Selesaikan!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
                cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form berdasarkan ID task yang dikirim
                document.getElementById('form-complete-' + taskId).submit();
            }
        });
    }
</script>
<script>
    function confirmDelete(event, form) {
        event.preventDefault(); // Hentikan submit form bawaan

        Swal.fire({
            title: 'Hapus Progres?',
            text: "Data progres yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // Warna merah (rose-600)
            cancelButtonColor: '#64748b',  // Warna abu-abu (slate-500)
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
@endsection