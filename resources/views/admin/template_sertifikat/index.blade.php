@extends('admin.layouts.app')

@section('title', 'Template Sertifikat - CertiLearn')

@section('content')
<div class="p-6 space-y-6">

    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Template Sertifikat</h1>
            <p class="text-sm text-slate-500">Kelola master template sertifikat dan indikator kompetensi acuan PjBL.</p>
        </div>
        <a href="{{ route('admin.certificate-templates.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow transition">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Template Baru</span>
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Table List Template -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Template</th>
                        <th class="px-5 py-3.5">Format No. Surat</th>
                        <th class="px-5 py-3.5 text-center">Jumlah Indikator</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($templates as $template)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                                        <i class="fa-solid fa-certificate text-base"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm">{{ $template->title }}</div>
                                        <div class="text-slate-400 text-[11px] line-clamp-1">{{ $template->description ?? 'Tidak ada deskripsi.' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-mono text-slate-500">
                                {{ $template->nomor_surat_format ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $template->indicators_count }} Indikator
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($template->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.certificate-templates.show', $template->id) }}" 
                                       title="Lihat Detail & Indikator"
                                       class="p-2 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.certificate-templates.edit', $template->id) }}" 
                                       title="Edit Template"
                                       class="p-2 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 block text-slate-300"></i>
                                Belum ada template sertifikat yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($templates->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-200/80 bg-slate-50">
                {{ $templates->links() }}
            </div>
        @endif
    </div>

</div>
@endsection