@extends('siswa.layouts.app')

@section('title', 'Dashboard Pembelajaran TEFA - CertiLearn')

@section('content')

<div class="p-6 max-w-7xl mx-auto space-y-8" x-data="{ activeTab: 'semua' }">

    <!-- 1. WELCOME BANNER TEFA -->
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 rounded-3xl p-8 lg:p-10 text-white shadow-2xl overflow-hidden border border-slate-800/80">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-8">
            <div class="space-y-4 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/10 backdrop-blur-xl border border-white/15 rounded-full text-xs font-semibold tracking-wide text-blue-200 shadow-inner">
                    <i class="fa-solid fa-industry text-blue-400"></i>
                    <span>TEFA Workspace</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-[2.5rem] font-black tracking-tight leading-tight text-white">
                    Selamat Datang Kembali, <br>
                    <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-cyan-300 bg-clip-text text-transparent">
                        {{ $user->name }}!
                    </span> 
                    👋
                </h1>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Kelola proyek TEFA-mu, kembangkan produk nyata, dan raih sertifikat kompetensi bersama guru dan industri.
                </p>
            </div>

            <!-- Kanan: Ilustrasi Kartu Mini & Badge TEFA -->
            <div class="hidden xl:flex items-end gap-3.5 shrink-0 select-none">
                <div class="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-xl flex flex-col items-center text-center space-y-1.5 -translate-y-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/30 text-blue-300 flex items-center justify-center text-base shadow-inner">
                        <i class="fa-solid fa-gears"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-200 tracking-wider">Production</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-xl flex flex-col items-center text-center space-y-1.5">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/30 text-indigo-200 flex items-center justify-center text-xl shadow-inner">
                        <i class="fa-solid fa-industry"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-200 tracking-wider">Factory</span>
                </div>

                <div class="text-right pb-2 pl-3 border-l border-white/10">
                    <span class="px-3 py-1 bg-blue-600 text-white rounded-xl text-[10px] font-black tracking-widest shadow-lg uppercase inline-block">TEFA</span>
                    <span class="text-[10px] text-slate-400 block mt-1.5 font-medium">Learn • Create • Produce</span>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-transparent"></div>
    </div>

    <!-- 2. METRIC / STATS CARDS -->

    <!-- 3. FILTER TAB & PENCARIAN -->
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm" x-data="{ search: '' }">
        <!-- Tab Filter Berdasarkan Status Database -->
        <div class="flex flex-wrap items-center gap-2">
            <button @click="activeTab = 'semua'" 
                :class="activeTab === 'semua' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                class="px-4 py-2 rounded-xl text-xs transition-all">
                Semua Proyek ({{ $proyeks->count() }})
            </button>

            <button @click="activeTab = 'pending'" 
                :class="activeTab === 'pending' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                class="px-4 py-2 rounded-xl text-xs transition-all">
                Menunggu Pembimbing ({{ $proyeks->where('status', 'pending')->count() }})
            </button>

            <button @click="activeTab = 'approved'" 
                :class="activeTab === 'approved' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                class="px-4 py-2 rounded-xl text-xs transition-all">
                Disetujui ({{ $proyeks->where('status', 'approved')->count() }})
            </button>

            <button @click="activeTab = 'rejected'" 
                :class="activeTab === 'rejected' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                class="px-4 py-2 rounded-xl text-xs transition-all">
                Ditolak / Revisi ({{ $proyeks->where('status', 'rejected')->count() }})
            </button>
        </div>

        <!-- Kolom Pencarian (Opsional terhubung ke Alpine jika ingin difilter real-time) -->
        <div class="flex items-center gap-2">
            <form action="{{ route('siswa.tefa') }}" method="GET" class="flex items-center gap-2">
                <div class="relative flex-1 sm:w-64">
                    <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari proyek TEFA..." 
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition">
                </div>
                <button type="submit" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition">
                    <span>Cari</span>
                </button>
                @if(request('search'))
                    <a href="{{ route('siswa.tefa') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition" title="Reset Pencarian">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- 4. MAIN CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI (Daftar Kartu Proyek TEFA dengan Filter Alpine.js) -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($proyeks as $proyek)
            <div x-show="activeTab === 'semua' || activeTab === '{{ $proyek->status }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between space-y-5 hover:shadow-md transition-all">
                
                <!-- Header Kartu Proyek -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <!-- Kategori / Badge Atas -->
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                            {{ $proyek->kategori }}
                        </span>

                        <!-- Badge Status Dinamis (Pending / Menunggu Pembimbing, Approved, dll) -->
                        @if($proyek->status === 'pending')
                            <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/60 rounded-full text-[10px] font-extrabold flex items-center gap-1.5 shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Pembimbing
                            </span>
                        @elseif($proyek->status === 'approved')
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-[10px] font-extrabold">
                                Disetujui
                            </span>
                        @else
                            <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200/60 rounded-full text-[10px] font-extrabold">
                                {{ ucfirst($proyek->status) }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-base font-black text-slate-800 mt-1 line-clamp-1">{{ $proyek->judul }}</h3>
                        <p class="text-slate-500 text-xs mt-1 line-clamp-2 leading-relaxed">{{ $proyek->deskripsi }}</p>
                    </div>
                </div>

                <!-- Footer Kartu: Deadline & Daftar Pembimbing Bertumpuk -->
                <div class="pt-4 border-t border-slate-100 space-y-4">
                    
                    <!-- Baris Deadline & Sisa Waktu -->
                    <div class="flex items-center justify-between text-[11px] text-slate-500 bg-slate-50/70 p-2.5 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-slate-400"></i>
                            <span>Deadline: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d M Y') }}</strong></span>
                        </div>
                        <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded-lg text-[10px] font-bold">
                            <i class="fa-solid fa-hourglass-half mr-1"></i> Aktif
                        </span>
                    </div>

                    <!-- Bagian Pembimbing (Inisial Bertumpuk) & Tim -->
                    <div class="grid grid-cols-2 gap-2 text-[11px] items-center">
                        <!-- Pembimbing Inisial -->
                        <div class="space-y-1">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">PEMBIMBING:</span>
                            <div class="flex -space-x-2 overflow-hidden py-0.5">
                                @php
                                    $colors = ['bg-indigo-600', 'bg-slate-400', 'bg-emerald-600', 'bg-purple-600'];
                                @endphp
                                @forelse($proyek->mentors as $index => $mentor)
                                    <div class="inline-flex h-7 w-7 items-center justify-center rounded-full {{ $colors[$index % count($colors)] }} text-white text-[10px] font-black ring-2 ring-white shadow-xs" title="{{ $mentor->name }}">
                                        {{ strtoupper(substr($mentor->name, 0, 2)) }}
                                    </div>
                                @empty
                                    <span class="text-xs text-slate-400 italic">Belum ada</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tim Inisial -->
                        <div class="space-y-1 text-right">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">TIM:</span>
                            <div class="flex -space-x-2 overflow-hidden py-0.5 justify-end">
                                @foreach($proyek->members->take(3) as $member)
                                    <div class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-500 text-white text-[10px] font-black ring-2 ring-white shadow-xs" title="{{ $member->nama_siswa }}">
                                        {{ strtoupper(substr($member->nama_siswa, 0, 2)) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Baris Tombol Aksi Bawah (Menunggu ACC / Hapus) -->
                    <div class="flex items-center gap-2 pt-2">
                        @if($proyek->status === 'pending')
                            <div class="flex-1 py-2.5 px-4 bg-slate-100 text-slate-500 text-xs font-bold rounded-2xl text-center flex items-center justify-center gap-2 cursor-not-allowed">
                                <i class="fa-solid fa-lock text-[11px]"></i>
                                <span>Menunggu ACC Pembimbing</span>
                            </div>
                            <!-- Tombol Hapus / Batalkan Pengajuan -->
                            <button type="button" class="w-10 h-10 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 flex items-center justify-center transition shadow-2xs" title="Batalkan/Hapus Pengajuan">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        @else
                            <a href="#" class="flex-1 py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-2xl text-center shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2">
                                <span>Lanjutkan Proyek</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @endif
                    </div>

                </div>

            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl mx-auto flex items-center justify-center text-lg mb-3">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h4 class="text-xs font-bold text-slate-700">Belum Ada Proyek</h4>
                <p class="text-[11px] text-slate-400 mt-1">Anda belum mengajukan atau tergabung dalam proyek TEFA apapun.</p>
            </div>
            @endforelse
        </div>

        <!-- KOLOM KANAN (Tugas Mendatang) -->
    </div>

    <!-- 5. BANNER BAWAH: IDE PROYEK TEFA BARU -->
    <div class="relative bg-gradient-to-r from-blue-50 via-indigo-50/50 to-blue-100/60 rounded-3xl p-8 border border-blue-100/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden">
        <div class="space-y-2 relative z-10 max-w-xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-bold">
                <i class="fa-solid fa-lightbulb"></i>
                <span>Inovasi Baru</span>
            </div>
            <h3 class="text-xl font-black text-slate-800">Punya ide proyek TEFA baru?</h3>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Tampilkan produk atau jasa yang ingin Anda kembangkan dan ajak guru atau industri untuk menjadi mentor.
            </p>
        </div>
        <div class="relative z-10 shrink-0">
            <a href="{{route('siswa.tefa.create')}}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-blue-500/25 transition active:scale-[0.98]">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Ajukan Proyek TEFA</span>
            </a>
        </div>
    </div>

</div>
@endsection