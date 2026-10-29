@extends('siswa.layouts.app')

@section('title', 'Sertifikat & Capaian Proyek - CertiLearn')

@section('content')
<div class="space-y-8">

    <!-- Hero / Banner Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-900 p-8 text-white shadow-xl shadow-indigo-950/20">
        <!-- Background Ambient Glow -->
        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1 text-[11px] font-semibold tracking-wider uppercase backdrop-blur-md border border-white/10 text-blue-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Portfolio Kompetensi Siswa
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Sertifikat Capaian Proyek
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Pantau seluruh hasil penilaian proyek PjBL Anda secara transparan. Sertifikat resmi berstandar dapat diunduh langsung jika Anda telah dinyatakan kompeten.
                </p>
            </div>

            <!-- Stats Ringkas Banner -->
            <div class="flex items-center gap-3 self-start md:self-auto bg-white/5 border border-white/10 backdrop-blur-md p-4 rounded-2xl">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white text-xl shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <div class="text-2xl font-black text-white leading-none">
                        {{ $evaluations->where('status_kompetensi', 'kompeten')->count() }}
                    </div>
                    <div class="text-[11px] text-slate-300 font-medium mt-1">Sertifikat Terbit</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Message -->
    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-exclamation text-sm"></i>
            </div>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Certificates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($evaluations as $eval)
            @php 
                $isKompeten = strtolower($eval->status_kompetensi) === 'kompeten';
            @endphp
            <div class="group relative bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                
                <!-- Accent Border Top -->
                <div class="h-1.5 w-full {{ $isKompeten ? 'bg-gradient-to-r from-emerald-500 to-teal-400' : 'bg-gradient-to-r from-amber-400 to-orange-400' }}"></div>

                <div class="p-6 space-y-5">
                    <!-- Top Info Header -->
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600">
                            <i class="fa-solid fa-layer-group text-[9px]"></i> PjBL Project
                        </span>

                        <!-- Status Badge -->
                        @if($isKompeten)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Kompeten
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Process
                            </span>
                        @endif
                    </div>

                    <!-- Project Title & Description -->
                    <div class="space-y-1.5">
                        <h3 class="font-bold text-slate-800 text-base group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                            {{ $eval->project->name ?? $eval->project->judul ?? 'Proyek Tanpa Judul' }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $eval->project->deskripsi ?? 'Evaluasi akhir pencapaian indikator dan kompetensi proyek siswa.' }}
                        </p>
                    </div>

                    <!-- Performance Score Card -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/80 border border-slate-200/60 flex items-center justify-between">
                        <div class="space-y-0.5">
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Nilai Akhir</span>
                            <div class="text-xs text-slate-600 font-medium">
                                {{ $eval->items->count() }} Indikator Dinilai
                            </div>
                        </div>
                        <div class="text-2xl font-black tracking-tight {{ $isKompeten ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $eval->nilai_akhir }}
                        </div>
                    </div>
                </div>

                <!-- Footer Action Area -->
                <div class="p-6 pt-0">
                    @if($isKompeten)
                        <a href="{{ route('siswa.sertifikat.download', $eval->id) }}" 
                           target="_blank" 
                           class="w-full inline-flex items-center justify-center gap-2.5 px-4 py-3 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl text-xs font-bold transition-all duration-300 shadow-lg shadow-slate-900/10 hover:shadow-blue-600/25 active:scale-[0.98]">
                            <i class="fa-solid fa-file-arrow-down text-sm"></i>
                            <span>Unduh Sertifikat PDF</span>
                        </a>
                    @else
                        <button disabled 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 text-slate-400 rounded-2xl text-xs font-semibold cursor-not-allowed border border-slate-200/60">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span>Sertifikat Belum Tersedia</span>
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-4 border border-slate-100">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <h3 class="font-bold text-slate-800 text-base">Belum Ada Sertifikat</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 leading-relaxed">
                    Catatan evaluasi atau sertifikat capaian proyek Anda belum diterbitkan. Selesaikan proyek PjBL Anda untuk mendapatkan sertifikasi.
                </p>
            </div>
        @endforelse
    </div>

</div>
@endsection