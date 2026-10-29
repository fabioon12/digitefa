@extends('admin.layouts.app')

@section('title', 'Verifikasi Keaslian Sertifikat - CertiLearn')

@section('content')
<div class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 py-10 flex flex-col items-center justify-center" 
     x-data="{ 
         certCode: '{{ request('code') }}', 
         isSearching: false 
     }">

    <!-- Hero Title -->
    <div class="text-center space-y-2 mb-8 max-w-lg">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-600 border border-blue-100/80">
            <i class="fa-solid fa-shield-halved text-[10px]"></i> Verifikasi Keaslian Sertifikat
        </span>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">Cek Legalitas Sertifikat Digital</h1>
        <p class="text-xs text-slate-500 leading-relaxed">Masukkan kode sertifikat atau scan QR Code yang tertera pada dokumen untuk memastikan validitasnya.</p>
    </div>

    <!-- Search Form -->
    <div class="w-full max-w-xl bg-white p-2.5 rounded-2xl border border-slate-200/80 shadow-lg shadow-slate-100/50 mb-8">
        <form action="" method="GET" @submit="isSearching = true" class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="code" x-model="certCode" required placeholder="Contoh: CERT/2026/RPL/0089" 
                    class="w-full pl-9 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-xs font-mono font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-blue-600 transition">
            </div>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-500/20 transition active:scale-95 flex items-center justify-center gap-2">
                <span x-show="!isSearching" class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                    <span>Verifikasi</span>
                </span>
                <span x-show="isSearching" class="flex items-center gap-2" x-cloak>
                    <i class="fa-solid fa-spinner animate-spin text-xs"></i>
                    <span>Memeriksa...</span>
                </span>
            </button>
        </form>
    </div>

    <!-- Results Area -->
    @if(isset($certificate))
        @if($certificate)
            <!-- Result: VALID / FOUND -->
            <div class="w-full max-w-2xl bg-white rounded-2xl border border-emerald-100 shadow-md p-6 sm:p-8 space-y-6">
                <div class="flex items-center gap-4 pb-5 border-b border-slate-100">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl flex-shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 uppercase tracking-wider">
                            Sertifikat Terverifikasi Legal
                        </div>
                        <h2 class="text-sm font-bold text-slate-800 font-mono mt-0.5">{{ $certificate->certificate_number }}</h2>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-semibold">Nama Pemilik</span>
                        <p class="font-bold text-slate-800 text-sm">{{ $certificate->student_name }}</p>
                        <p class="text-[10px] text-slate-500">NISN: {{ $certificate->nisn }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-semibold">Skema Kompetensi</span>
                        <p class="font-bold text-slate-800 text-sm">{{ $certificate->scheme_name }}</p>
                        <p class="text-[10px] text-slate-500">{{ $certificate->major }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-semibold">Lembaga Penerbit</span>
                        <p class="font-semibold text-slate-700">{{ $certificate->issuer_name }}</p>
                        <p class="text-[10px] text-blue-600 font-medium">LSP-P1 / BNSP Verified</p>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-semibold">Tanggal Terbit</span>
                        <p class="font-semibold text-slate-700">{{ $certificate->issue_date->format('d F Y') }}</p>
                        <p class="text-[10px] text-emerald-600 font-medium">Status: {{ ucfirst($certificate->status) }}</p>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between border-t border-slate-100 text-xs">
                    <span class="text-[11px] text-slate-400">Verifikasi digital otomatis oleh CertiLearn Engine.</span>
                    <a href="{{ route('verify.download', $certificate->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition">
                        <i class="fa-solid fa-download text-xs"></i>
                        <span>Unduh Dokumen</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Result: NOT FOUND -->
            <div class="w-full max-w-2xl bg-white rounded-2xl border border-red-100 shadow-md p-6 sm:p-8 text-center space-y-4">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 text-xl mx-auto">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Sertifikat Tidak Ditemukan</h2>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        Nomor sertifikat <span class="font-mono font-bold text-slate-700">{{ request('code') }}</span> tidak terdaftar dalam basis data sistem kami. Periksa kembali penulisan kode.
                    </p>
                </div>
            </div>
        @endif
    @endif

</div>
@endsection