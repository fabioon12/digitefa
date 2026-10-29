@extends('admin.layouts.app')

@section('title', 'Verifikasi Akun Industri - CertiLearn')

@section('content')
<div class="p-6 space-y-6" x-data="{ 
    showApproveModal: false, 
    showRejectModal: false, 
    selectedIndustri: {} 
}">

    <!-- HEADER & KETERANGAN -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Verifikasi Akun Industri (DU/DI)</h1>
            <p class="text-xs text-slate-500 mt-1">Tinjau dan lakukan validasi pendaftaran akun perusahaan/mitra industri baru sebelum aktif di sistem.</p>
        </div>
        
        <!-- Badge Total Antrean Dinamis -->
        <div class="inline-flex items-center gap-2 px-3.5 py-2 bg-amber-50 border border-amber-200/80 rounded-2xl">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
            </span>
            <span class="text-xs font-bold text-amber-800">{{ $pendingIndustri->total() }} Pendaftaran Menunggu</span>
        </div>
    </div>

    <!-- STATS SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Menunggu Verifikasi</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $totalPending }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Disetujui Bulan Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $approvedThisMonth }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-building-circle-check"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Ditolak</p>
                <h3 class="text-2xl font-bold text-rose-500 mt-1">{{ $totalRejected }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center">
                <i class="fa-solid fa-building-circle-xmark"></i>
            </div>
        </div>
    </div>

    <!-- CONTAINER TABEL -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        
        <!-- BAR PENCARIAN & FILTER -->
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <form action="{{ route('admin.verifikasi.industri') }}" method="GET" class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, perusahaan, atau email..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-600">
            </form>
            <div class="text-xs text-slate-400">
                Menampilkan data pengajuan akun mitra industri
            </div>
        </div>

        <!-- TABEL ANTREAN VERIFIKASI -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">Perusahaan / Instansi</th>
                        <th class="py-3.5 px-5">Bidang Sektor</th>
                        <th class="py-3.5 px-5">Nama Perwakilan & Jabatan</th>
                        <th class="py-3.5 px-5">Email & Username</th>
                        <th class="py-3.5 px-5">Waktu Pendaftaran</th>
                        <th class="py-3.5 px-5 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($pendingIndustri as $industri)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-5 font-semibold text-slate-900 flex items-center gap-3">
                                @if($industri->image)
                                    <img src="{{ asset('storage/' . $industri->image) }}" class="w-9 h-9 rounded-xl object-cover border border-slate-100">
                                @else
                                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                                        {{ substr($industri->company_name ?? $industri->name, 0, 2) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-slate-800">{{ $industri->company_name ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400 font-normal">Mitra Industri</p>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600 font-medium">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-[11px] font-medium">
                                    {{ $industri->sector ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                <p class="text-slate-800 font-semibold">{{ $industri->name }}</p>
                                <p class="text-[10px] text-slate-400 font-normal">{{ $industri->position ?? '-' }}</p>
                            </td>
                            <td class="py-3.5 px-5">
                                <p class="text-slate-600 font-medium">{{ $industri->email }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">@<!-- -->{{ $industri->username }}</p>
                            </td>
                            <td class="py-3.5 px-5 text-slate-400">{{ $industri->created_at->translatedFormat('d M Y, H:i') }} WIB</td>
                            <td class="py-3.5 px-5 text-center space-x-1.5">
                                <button @click="showApproveModal = true; selectedIndustri = { 
                                    id: {{ $industri->id }}, 
                                    perusahaan: '{{ addslashes($industri->company_name ?? '-') }}', 
                                    nama: '{{ addslashes($industri->name) }}', 
                                    jabatan: '{{ addslashes($industri->position ?? '-') }}', 
                                    email: '{{ $industri->email }}' 
                                }" 
                                    class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-[11px] shadow-sm transition inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-check"></i> Setujui
                                </button>
                                <button @click="showRejectModal = true; selectedIndustri = { 
                                    id: {{ $industri->id }}, 
                                    perusahaan: '{{ addslashes($industri->company_name ?? '-') }}', 
                                    nama: '{{ addslashes($industri->name) }}', 
                                    jabatan: '{{ addslashes($industri->position ?? '-') }}', 
                                    email: '{{ $industri->email }}' 
                                }" 
                                    class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl font-semibold text-[11px] transition inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-xmark"></i> Tolak
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Tidak ada pendaftaran mitra industri yang menunggu verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendingIndustri->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pendingIndustri->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL POPUP: KONFIRMASI SETUJUI -->
    <div x-show="showApproveModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full space-y-4 shadow-xl border border-slate-100" @click.away="showApproveModal = false">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-building-circle-check"></i>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-slate-800 text-base">Setujui Akun Industri?</h3>
                <p class="text-xs text-slate-500 mt-1">Akun perusahaan <span class="font-bold text-slate-800" x-text="selectedIndustri.perusahaan"></span> akan diaktifkan dan dapat mulai berkolaborasi di platform.</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl text-xs space-y-1">
                <div class="flex justify-between"><span class="text-slate-400">Perwakilan:</span> <span class="font-bold text-slate-700" x-text="selectedIndustri.nama"></span></div>
                <div class="flex justify-between"><span class="text-slate-400">Jabatan:</span> <span class="font-semibold text-slate-700" x-text="selectedIndustri.jabatan"></span></div>
                <div class="flex justify-between"><span class="text-slate-400">Email:</span> <span class="font-medium text-slate-700" x-text="selectedIndustri.email"></span></div>
            </div>
            
            <!-- FORM SUBMIT ACC INDUSTRI -->
            <form :action="`/admin/manajemen-industri/verifikasi/${selectedIndustri.id}/approve`" method="POST" class="grid grid-cols-2 gap-2.5 pt-2">
                @csrf
                @method('PATCH')
                <button type="button" @click="showApproveModal = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                <button type="submit" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-md transition">Ya, Setujui</button>
            </form>
        </div>
    </div>

    <!-- MODAL POPUP: KONFIRMASI TOLAK -->
    <div x-show="showRejectModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full space-y-4 shadow-xl border border-slate-100" @click.away="showRejectModal = false">
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-building-circle-xmark"></i>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-slate-800 text-base">Tolak Pendaftaran?</h3>
                <p class="text-xs text-slate-500 mt-1">Pengajuan akun industri <span class="font-bold text-slate-800" x-text="selectedIndustri.perusahaan"></span> atas nama <span class="font-semibold text-slate-700" x-text="selectedIndustri.nama"></span> akan ditolak.</p>
            </div>

            <!-- FORM SUBMIT REJECT INDUSTRI -->
            <form :action="`/admin/manajemen-industri/verifikasi/${selectedIndustri.id}/reject`" method="POST" class="space-y-3">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Alasan Penolakan (Opsional)</label>
                    <textarea name="rejection_reason" rows="2" placeholder="Contoh: Informasi perusahaan tidak sesuai / instansi tidak terverifikasi" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-rose-500"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-2.5 pt-1">
                    <button type="button" @click="showRejectModal = false" class="py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">Batal</button>
                    <button type="submit" class="py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl shadow-md transition">Tolak Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Notifikasi Berhasil --}}
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