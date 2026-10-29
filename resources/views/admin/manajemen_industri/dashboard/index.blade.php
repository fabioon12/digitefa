@extends('admin.layouts.app')

@section('title', 'Manajemen Industri - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ showDeleteModal: false, deleteUrl: '', industriName: '' }">

    <!-- Header Section -->
    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Industri (DU/DI)</h1>
        <p class="text-xs text-slate-400 mt-1">Kelola data mitra perusahaan dan instansi industri yang terdaftar dalam sistem.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Filter & Action Header -->
        <div class="p-5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            
            <!-- Form Pencarian Dinamis -->
            <form action="{{ route('admin.manajemen-industri.dashboard') }}" method="GET" class="relative flex-1 max-w-sm">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perusahaan, bidang, PJ, email, atau telp..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
            </form>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 self-end sm:self-auto">
                
                <!-- Dropdown Filter Status -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                        <span>
                            @if(request('status') == 'approved') Status: Aktif
                            @elseif(request('status') == 'pending') Status: Pending
                            @elseif(request('status') == 'rejected') Status: Ditolak
                            @else Semua Status @endif
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-20 text-xs">
                        <a href="{{ route('admin.manajemen-industri.dashboard', array_merge(request()->except('status'), ['status' => ''])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Semua Status</a>
                        <a href="{{ route('admin.manajemen-industri.dashboard', array_merge(request()->except('status'), ['status' => 'approved'])) }}" class="block px-4 py-2 text-emerald-600 hover:bg-slate-50 font-medium">Aktif</a>
                        <a href="{{ route('admin.manajemen-industri.dashboard', array_merge(request()->except('status'), ['status' => 'pending'])) }}" class="block px-4 py-2 text-amber-600 hover:bg-slate-50 font-medium">Pending</a>
                        <a href="{{ route('admin.manajemen-industri.dashboard', array_merge(request()->except('status'), ['status' => 'rejected'])) }}" class="block px-4 py-2 text-rose-600 hover:bg-slate-50 font-medium">Ditolak</a>
                    </div>
                </div>

                <!-- Tombol Tambah Industri -->
                <a href="{{ route('admin.manajemen-industri.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium shadow-md shadow-blue-500/20 transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Industri</span>
                </a>
            </div>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-slate-100 bg-slate-50/50 text-[11px] font-semibold text-slate-400">
                        <th class="py-3.5 px-5 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Perusahaan / Instansi</th>
                        <th class="py-3.5 px-4">Bidang / Sektor</th>
                        <th class="py-3.5 px-4">Penanggung Jawab (PJ)</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-normal">
                    @forelse($industris as $index => $industri)
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- No -->
                            <td class="py-4 px-5 text-center font-medium text-slate-400">
                                {{ $industris->firstItem() + $index }}
                            </td>

                            <!-- Perusahaan / Logo & Alamat -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if(!empty($industri->image))
                                        <img src="{{ asset('storage/' . $industri->image) }}" alt="Logo {{ $industri->company_name }}" class="w-9 h-9 rounded-lg object-cover border border-slate-100 shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                            {{ substr($industri->company_name ?? $industri->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $industri->company_name ?? '-' }}</div>
                                        @if(!empty($industri->address))
                                            <div class="text-[10px] text-slate-400 font-normal truncate max-w-[200px]" title="{{ $industri->address }}">
                                                <i class="fa-solid fa-location-dot text-[9px] mr-0.5"></i> {{ $industri->address }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Bidang / Sektor -->
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-md font-medium text-[11px]">
                                    {{ $industri->sector ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Penanggung Jawab -->
                            <td class="py-4 px-4">
                                <div class="text-slate-800 font-semibold">{{ $industri->name }}</div>
                                <div class="text-[10px] text-slate-400 font-normal">{{ $industri->position ?? 'Penanggung Jawab' }}</div>
                            </td>

                            <!-- Kontak (Email & Phone) -->
                            <td class="py-4 px-4">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <i class="fa-regular fa-envelope text-[10px] text-slate-400"></i>
                                        <span>{{ $industri->email }}</span>
                                    </div>
                                    @if(!empty($industri->phone))
                                        <div class="flex items-center gap-1.5 text-slate-500 font-mono text-[11px]">
                                            <i class="fa-solid fa-phone text-[9px] text-slate-400"></i>
                                            <span>{{ $industri->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4">
                                @if($industri->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @elseif($industri->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-semibold bg-amber-50 text-amber-600 border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak / Nonaktif
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Optional: Detail Button --}}
                                    @if(Route::has('admin.manajemen-industri.show'))
                                        <a href="{{ route('admin.manajemen-industri.show', $industri->id) }}" class="p-1.5 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-lg transition" title="Detail Industri">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.manajemen-industri.edit', $industri->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Edit Data">
                                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                                    </a>

                                    <button type="button" 
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('admin.manajemen-industri.destroy', $industri->id) }}'; industriName = '{{ addslashes($industri->company_name ?? $industri->name) }}'" 
                                        class="p-1.5 text-rose-500 hover:bg-rose-50 border border-rose-200 rounded-lg transition" 
                                        title="Hapus Data">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-building-circle-xmark text-3xl text-slate-300"></i>
                                    <p class="text-xs font-medium">Tidak ada data industri terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Area Dinamis -->
        @if($industris->hasPages())
            <div class="p-5 border-t border-slate-100">
                {{ $industris->withQueryString()->links() }}
            </div>
        @endif

    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div x-show="showDeleteModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak x-transition>
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full space-y-4 shadow-xl border border-slate-100" @click.away="showDeleteModal = false">
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-xl mx-auto">
                <i class="fa-regular fa-trash-can"></i>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-slate-800 text-base">Hapus Data Industri?</h3>
                <p class="text-xs text-slate-500 mt-1">Apakah Anda yakin ingin menghapus data industri <span class="font-bold text-slate-800" x-text="industriName"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <form :action="deleteUrl" method="POST" class="grid grid-cols-2 gap-2.5 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                <button type="submit" class="py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-rose-500/20 transition">Hapus</button>
            </form>
        </div>
    </div>

</div>

<!-- SweetAlert Notification -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'OK'
    });
</script>
@endif
@endsection