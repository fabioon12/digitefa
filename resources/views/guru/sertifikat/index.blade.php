@extends('guru.layouts.app')

@section('title', 'Penerbitan Sertifikat - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ selectedTemplate: '{{ $templates->first()->id ?? 1 }}' }">

    <!-- Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Penerbitan Sertifikat Competency</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pilih template background dan cetak sertifikat bagi siswa yang telah dinyatakan KOMPETEN.</p>
        </div>

        <!-- Pencarian -->
        <form method="GET" action="{{ route('guru.sertifikat.index') }}" class="flex items-center gap-2">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 transition w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Selection Bar Template Background Sertifikat -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-palette text-blue-600"></i> Pilih Desain Template Sertifikat Aktif
            </h3>
            <span class="text-[11px] text-slate-400">Pilihan template akan berlaku saat tombol cetak diklik.</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pt-1">
            @forelse($templates as $tmpl)
                <label @click="selectedTemplate = '{{ $tmpl->id }}'" 
                       class="relative flex flex-col p-3 rounded-xl border-2 cursor-pointer transition-all"
                       :class="selectedTemplate == '{{ $tmpl->id }}' ? 'border-blue-600 bg-blue-50/20 shadow-md' : 'border-slate-200 hover:border-slate-300 bg-slate-50/50'">
                    
                    <input type="radio" name="active_template" value="{{ $tmpl->id }}" class="hidden" x-model="selectedTemplate">
                    
                    <!-- Preview Thumbnail Gambar Template -->
                    <div class="w-full h-24 rounded-lg overflow-hidden border border-slate-200 bg-white mb-2 relative">
                        <img src="{{ asset('storage/' . $tmpl->background_image) }}" alt="{{ $tmpl->title ?? 'Template' }}" class="w-full h-full object-cover">
                        <div x-show="selectedTemplate == '{{ $tmpl->id }}'" class="absolute top-2 right-2 bg-blue-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px]">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </div>

                    <span class="text-xs font-bold text-slate-800 truncate">{{ $tmpl->title ?? 'Template #' . $tmpl->id }}</span>
                    <span class="text-[10px] text-slate-400">Rasio A4 Landscape</span>
                </label>
            @empty
                <div class="col-span-full py-4 text-center text-xs text-slate-400">
                    Belum ada data template sertifikat di database.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tabel Daftar Siswa Terbuka Sertifikat -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm">Daftar Siswa Qualified</h3>
            <span class="text-xs font-semibold px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg">
                Total: {{ $evaluations->total() }} Siswa Kompeten
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Judul Proyek PjBL</th>
                        <th class="py-3.5 px-4 text-center">Nilai Akhir</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi Penerbitan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($evaluations as $index => $eval)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $evaluations->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $eval->student->name ?? 'Siswa' }}</div>
                                <div class="text-[10px] text-slate-400">NISN: {{ $eval->student->nisn ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-600">
                                {{ $eval->project->title ?? $eval->project->nama_proyek ?? 'Proyek PjBL' }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-extrabold text-blue-600">
                                {{ $eval->nilai_akhir }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                    {{ $eval->status_kompetensi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <!-- Tombol Cetak dengan Query Dynamic Selected Template -->
                                <a :href="'{{ route('guru.sertifikat.generate', $eval->id) }}?template_id=' + selectedTemplate" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-sm shadow-emerald-500/20">
                                    <i class="fa-solid fa-file-pdf"></i>
                                    <span>Cetak Sertifikat</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-graduation-cap text-3xl mb-2 text-slate-300"></i>
                                <p class="text-xs">Belum ada data siswa berstatus KOMPETEN yang siap diterbitkan sertifikatnya.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100">
            {{ $evaluations->links() }}
        </div>
    </div>

</div>
@endsection