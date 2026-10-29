@extends('admin.layouts.app')

@section('title', 'Manajemen Siswa - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ showDeleteModal: false, deleteUrl: '', siswaName: '' }">

    <!-- Header Section -->
    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Siswa</h1>
        <p class="text-xs text-slate-400 mt-1">Kelola data siswa yang terdaftar dalam sistem.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- Filter & Action Header -->
        <div class="p-5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            
            <!-- Form Pencarian Dinamis -->
            <form action="{{ route('admin.manajemen-siswa.dashboard') }}" method="GET" class="relative flex-1 max-w-sm">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request('major'))
                    <input type="hidden" name="major" value="{{ request('major') }}">
                @endif
                @if(request('offering'))
                    <input type="hidden" name="offering" value="{{ request('offering') }}">
                @endif

                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa, NISN, email, kelas..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
            </form>

            <!-- Action Buttons & Dropdown Filters -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 self-end sm:self-auto">
                
                <!-- Dropdown Filter Program Keahlian / Major -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm max-w-[200px] truncate">
                        <i class="fa-solid fa-graduation-cap text-slate-400 text-xs shrink-0"></i>
                        <span class="truncate">
                            {{ request('major') ? request('major') : 'Semua Keahlian' }}
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-auto shrink-0"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-20 text-xs max-h-60 overflow-y-auto">
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => ''])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Semua Keahlian</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Teknik Grafika'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Teknik Grafika</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Desain Komunikasi Visual (DKV) / Multimedia'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Desain Komunikasi Visual (DKV) / Multimedia</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Teknik Komputer dan Jaringan (TKJ)'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Teknik Komputer dan Jaringan (TKJ)</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Animasi'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Animasi</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Teknik Mekatronika'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Teknik Mekatronika</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Teknik Logistik / Logistik'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Teknik Logistik / Logistik</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['major' => 'Perhotelan'])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Perhotelan</a>
                    </div>
                </div>

                <!-- Dropdown Filter Offering -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <i class="fa-solid fa-tag text-slate-400 text-xs"></i>
                        <span>
                            {{ request('offering') ? 'Offering ' . request('offering') : 'Semua Offering' }}
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-20 text-xs">
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => ''])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Semua Offering</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => 'A'])) }}" class="block px-4 py-2 text-indigo-600 hover:bg-slate-50">Offering A</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => 'B'])) }}" class="block px-4 py-2 text-indigo-600 hover:bg-slate-50">Offering B</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => 'C'])) }}" class="block px-4 py-2 text-indigo-600 hover:bg-slate-50">Offering C</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => 'D'])) }}" class="block px-4 py-2 text-indigo-600 hover:bg-slate-50">Offering D</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => 'E'])) }}" class="block px-4 py-2 text-indigo-600 hover:bg-slate-50">Offering E</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['offering' => 'F'])) }}" class="block px-4 py-2 text-indigo-600 hover:bg-slate-50">Offering F</a>
                    </div>
                </div>

                <!-- Dropdown Filter Status -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                        <span>
                            @if(request('status') == 'approved') Status: Aktif
                            @elseif(request('status') == 'rejected') Status: Nonaktif
                            @elseif(request('status') == 'pending') Status: Pending
                            @else Semua Status @endif
                        </span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-20 text-xs">
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['status' => ''])) }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">Semua Status</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['status' => 'approved'])) }}" class="block px-4 py-2 text-emerald-600 hover:bg-slate-50">Aktif</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['status' => 'rejected'])) }}" class="block px-4 py-2 text-slate-500 hover:bg-slate-50">Nonaktif</a>
                        <a href="{{ route('admin.manajemen-siswa.dashboard', array_merge(request()->query(), ['status' => 'pending'])) }}" class="block px-4 py-2 text-amber-600 hover:bg-slate-50">Pending</a>
                    </div>
                </div>

                <!-- Tombol Reset Filter jika ada parameter query -->
                @if(request('status') || request('major') || request('offering') || request('search'))
                    <a href="{{ route('admin.manajemen-siswa.dashboard') }}" class="p-2 text-slate-400 hover:text-red-500 border border-slate-200/80 rounded-xl transition shadow-sm" title="Reset Semua Filter">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                    </a>
                @endif

                <!-- Tombol Tambah Siswa -->
                <a href="{{ route('admin.manajemen-siswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-medium shadow-md shadow-blue-500/20 transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Siswa</span>
                </a>
            </div>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-y border-slate-100 bg-slate-50/50 text-[11px] font-semibold text-slate-400">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-4">Foto</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Username</th>
                        <th class="py-3.5 px-4">NIS</th>
                        <th class="py-3.5 px-4">Kelas</th>
                        <th class="py-3.5 px-4">Offering</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-normal">
                    
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-5 font-medium text-slate-400">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-4">
                                @if($siswa->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($siswa->image))
                                    <img src="{{ asset('storage/' . $siswa->image) }}" class="w-9 h-9 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background=EBF4FF&color=1E40AF" class="w-9 h-9 rounded-full object-cover">
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800">{{ $siswa->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $siswa->gender == 'L' ? 'Laki-laki' : ($siswa->gender == 'P' ? 'Perempuan' : 'Siswa') }}</div>
                            </td>
                            <td class="py-4 px-4 font-medium text-slate-700 font-mono">{{ $siswa->username }}</td>
                            <td class="py-4 px-4 text-slate-500 font-mono">{{ $siswa->nisn ?? '-' }}</td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">
                                    @if ($siswa->class || $siswa->major)
                                        {{ implode(' - ', array_filter([$siswa->class, $siswa->major])) }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($siswa->offering)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        <i class="fa-solid fa-tag text-[9px] mr-1"></i>
                                        {{ $siswa->offering }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px] font-medium">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-slate-500">{{ $siswa->email }}</td>
                            <td class="py-4 px-4">
                                @if($siswa->status === 'approved' || $siswa->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-emerald-50 text-emerald-600">
                                        Aktif
                                    </span>
                                @elseif($siswa->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-amber-50 text-amber-600">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-medium bg-slate-100 text-slate-500">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.manajemen-siswa.edit', $siswa->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-lg transition" title="Edit Data">
                                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                                    </a>
                                    <button type="button" 
                                            @click="showDeleteModal = true; deleteUrl = '{{ route('admin.manajemen-siswa.destroy', $siswa->id) }}'; siswaName = '{{ $siswa->name }}';" 
                                            class="p-1.5 text-red-500 hover:bg-red-50 border border-red-200 rounded-lg transition" 
                                            title="Hapus Data">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-8 text-center text-slate-400">
                                Tidak ada data siswa terdaftar.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Area Dinamis -->
        @if($siswas->hasPages())
            <div class="p-5 border-t border-slate-100">
                {{ $siswas->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div x-show="showDeleteModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full space-y-4 shadow-xl border border-slate-100" @click.away="showDeleteModal = false">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center text-xl mx-auto">
                <i class="fa-regular fa-trash-can"></i>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-slate-800 text-base">Hapus Akun Siswa?</h3>
                <p class="text-xs text-slate-500 mt-1">Apakah Anda yakin ingin menghapus siswa <span class="font-bold text-slate-800" x-text="siswaName"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <form :action="deleteUrl" method="POST" class="grid grid-cols-2 gap-2.5 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                <button type="submit" class="py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-xl shadow-md transition">Hapus</button>
            </form>
        </div>
    </div>

</div>
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