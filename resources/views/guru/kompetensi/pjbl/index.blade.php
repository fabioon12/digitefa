@extends('guru.layouts.app')

@section('title', 'Penentuan Kompetensi Proyek PjBL')

@section('content')
<div class="p-6 space-y-6 bg-slate-50/50 min-h-screen">

    <!-- 1. Hero / Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-8 text-white shadow-xl shadow-slate-200/50">
        <!-- Background Decorative Circles -->
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-10 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-500/20 border border-indigo-400/30 rounded-full text-indigo-200 text-xs font-semibold backdrop-blur-md">
                    <i class="fa-solid fa-award text-amber-400"></i>
                    <span>Penilaian Akhir PjBL</span>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Penentuan Kompetensi Proyek
                </h1>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Evaluasi hasil akhir dan tentukan tingkat kompetensi bagi siswa yang telah menyelesaikan tahap 100% proyek PjBL.
                </p>
            </div>

            <!-- Header Quick Action / Badge Info -->
            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                <div class="px-4 py-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-300">
                        <i class="fa-solid fa-list-check text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-300 tracking-wider">Total Antrean</p>
                        <p class="text-lg font-extrabold text-white">{{ $students->count() }} <span class="text-xs font-normal text-slate-300">Siswa</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Metric Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <!-- Card 1: Perlu Dinilai -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group">
        <div class="space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Penilaian</span>
            <!-- Menampilkan variabel dinamis -->
            <h3 class="text-2xl font-black text-slate-800">{{ $totalBelumDinilai }}</h3>
            <p class="text-xs text-amber-600 font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                Menunggu Evaluasi
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
    </div>

    <!-- Card 2: Tuntas Kompeten -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group">
        <div class="space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tuntas Kompeten</span>
            <!-- Menampilkan variabel dinamis -->
            <h3 class="text-2xl font-black text-slate-800">{{ $totalKompeten }}</h3>
            <p class="text-xs text-emerald-600 font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-[10px]"></i>
                Memenuhi Capaian
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-user-check"></i>
        </div>
    </div>

    <!-- Card 3: Belum Kompeten -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between group sm:col-span-2 lg:col-span-1">
        <div class="space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Belum Kompeten</span>
            <!-- Menampilkan variabel dinamis -->
            <h3 class="text-2xl font-black text-slate-800">{{ $totalBelumKompeten }}</h3>
            <p class="text-xs text-rose-500 font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                Perlu Remedial / Perbaikan
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-user-xmark"></i>
        </div>
    </div>
</div>

    <!-- 4. Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="kompetensiTable">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-6 w-14 text-center">NO</th>
                        <th class="py-4 px-6">SISWA</th>
                        <th class="py-4 px-6">PROJEK SELESAI</th>
                        <th class="py-4 px-6">TANGGAL SELESAI</th>
                        <th class="py-4 px-6 text-center">STATUS KOMPETENSI</th>
                        <th class="py-4 px-6 text-center">NILAI</th>
                        <th class="py-4 px-6 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                @forelse($students as $index => $student)
                    @php
                        $project = $student->projects->first();

                        // Cari evaluasi proyek khusus milik siswa ini
                        $eval = $project ? $project->evaluations->where('student_id', $student->id)->first() : null;

                        // Ambil data status dan nilai jika evaluasi sudah dilakukan
                        $status = $eval ? $eval->status_kompetensi : 'belum_dinilai';
                        $nilai  = $eval ? $eval->nilai_akhir : null;

                        // Avatar initial & background color generator
                        $initial  = strtoupper(substr($student->name, 0, 1));
                        $bgColors = ['bg-blue-500', 'bg-indigo-500', 'bg-purple-500', 'bg-emerald-500', 'bg-teal-500', 'bg-amber-500'];
                        $randomBg = $bgColors[$index % count($bgColors)];
                    @endphp

                    <tr class="hover:bg-slate-50/80 transition duration-150 student-row" data-status="{{ $status }}">
                        <td class="py-4 px-6 text-center text-slate-400 font-semibold">{{ $loop->iteration }}</td>
                        
                        <!-- Siswa Info dengan Avatar -->
                        <td class="py-4 px-6 search-student">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl {{ $randomBg }} text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-sm">
                                    {{ $initial }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm leading-tight">{{ $student->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-normal mt-0.5 flex items-center gap-1.5">
                                        <span>NISN: <strong class="text-slate-600 font-medium">{{ $student->nisn ?? '-' }}</strong></span>
                                        <span>•</span>
                                        <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded-md font-medium text-[10px]">{{ $student->class ?? $student->kelas ?? 'Tanpa Kelas' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Projek Info -->
                        <td class="py-4 px-6 search-project max-w-xs">
                            <div class="font-semibold text-slate-700 truncate" title="{{ $project?->judul ?? $project?->title }}">
                                {{ $project?->judul ?? $project?->title ?? 'Belum Mengunggah Proyek' }}
                            </div>
                            @if($project?->kategori ?? $project?->category)
                                <span class="text-[10px] text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded-md inline-block mt-1">
                                    {{ $project->kategori ?? $project->category }}
                                </span>
                            @endif
                        </td>

                        <!-- Tanggal Selesai -->
                        <td class="py-4 px-6 text-slate-500">
                            @if($project?->tanggal_selesai ?? $project?->updated_at)
                                <div class="flex items-center gap-1.5 text-xs">
                                    <i class="fa-regular fa-calendar-check text-slate-400"></i>
                                    <span>{{ \Carbon\Carbon::parse($project->tanggal_selesai ?? $project->updated_at)->translatedFormat('d M Y') }}</span>
                                </div>
                            @else
                                <span class="text-slate-400 italic text-xs">-</span>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-6 text-center">
                            @if($status === 'kompeten')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[11px] font-bold border border-emerald-200/60 shadow-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Kompeten
                                </span>
                            @elseif($status === 'belum_kompeten')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 rounded-full text-[11px] font-bold border border-rose-200/60 shadow-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Belum Kompeten
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[11px] font-bold border border-amber-200/60 shadow-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Belum Dinilai
                                </span>
                            @endif
                        </td>

                        <!-- Nilai -->
                        <td class="py-4 px-6 text-center">
                            @if($nilai !== null)
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 font-bold rounded-lg text-xs inline-block min-w-[32px] border border-indigo-100">
                                    {{ $nilai }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-400 font-semibold rounded-lg text-xs inline-block min-w-[32px]">
                                    -
                                </span>
                            @endif
                        </td>

                        <!-- Button Action -->
                        <td class="py-4 px-6 text-right">
                            @if($project)
                                @if($eval)
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Tombol Edit Nilai -->
                                        <a href="{{ route('guru.kompetensi.pjbl.create', ['project' => $project->id, 'student' => $student->id]) }}" 
                                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition duration-200"
                                        title="Edit Nilai">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>

                                    </div>
                                @else
                                    <!-- Tombol Beri Nilai (Jika belum dinilai) -->
                                    <a href="{{ route('guru.kompetensi.pjbl.create', ['project' => $project->id, 'student' => $student->id]) }}" 
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm hover:shadow-indigo-200 rounded-xl text-xs font-bold transition duration-200">
                                        <i class="fa-solid fa-plus text-[11px]"></i>
                                        <span>Beri Nilai</span>
                                    </a>
                                @endif
                            @else
                                <!-- Proyek Kosong -->
                                <button disabled class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold cursor-not-allowed">
                                    <i class="fa-solid fa-ban text-[11px]"></i>
                                    <span>Proyek Kosong</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr id="emptyDataRow">
                        <td colspan="7" class="py-16 text-center">
                            <div class="max-w-xs mx-auto space-y-3">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 text-xl">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Belum Ada Data Siswa</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Belum ada siswa yang mengajukan penilaian proyek PjBL.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse

                    <!-- Empty Filter State (Akan muncul jika pencarian/filter kosong) -->
                    <tr id="noMatchRow" class="hidden">
                        <td colspan="7" class="py-16 text-center">
                            <div class="max-w-xs mx-auto space-y-3">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto text-slate-400 text-xl">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Tidak Ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Tidak ada hasil yang cocok dengan kriteria pencarian Anda.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearch');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('.student-row');
        const noMatchRow = document.getElementById('noMatchRow');

        function filterTable() {
            const query = searchInput.value.toLowerCase().trim();
            const selectedStatus = statusFilter.value;
            let visibleCount = 0;

            // Toggle clear search button
            if (query.length > 0) {
                clearSearchBtn?.classList.remove('hidden');
            } else {
                clearSearchBtn?.classList.add('hidden');
            }

            rows.forEach(row => {
                const studentName = row.querySelector('.search-student')?.textContent.toLowerCase() || '';
                const projectTitle = row.querySelector('.search-project')?.textContent.toLowerCase() || '';
                const rowStatus = row.getAttribute('data-status');

                const matchesSearch = studentName.includes(query) || projectTitle.includes(query);
                const matchesStatus = (selectedStatus === 'all') || (rowStatus === selectedStatus);

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show empty search message if no row matches
            if (visibleCount === 0 && rows.length > 0) {
                noMatchRow?.classList.remove('hidden');
            } else {
                noMatchRow?.classList.add('hidden');
            }
        }

        searchInput?.addEventListener('keyup', filterTable);
        statusFilter?.addEventListener('change', filterTable);

        clearSearchBtn?.addEventListener('click', function() {
            searchInput.value = '';
            filterTable();
            searchInput.focus();
        });
    });
</script>
@endpush