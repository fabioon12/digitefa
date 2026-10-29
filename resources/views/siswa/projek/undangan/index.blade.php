@extends('siswa.layouts.app') 

@section('title', 'Undangan Proyek PjBL')

@section('content')
<!-- Container Full Width dengan Max-Width Extra Large -->
<div class="w-full max-w-[98%] xl:max-w-[1600px] mx-auto py-4 px-2 sm:px-4 space-y-4">
    
    <!-- Hero Header Banner (Dibuat Lebih Ringkas secara Vertikal) -->
    <div class="relative overflow-hidden bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-600 rounded-2xl p-4 sm:p-6 text-white shadow-lg shadow-indigo-500/10">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[11px] text-purple-100 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Permintaan Kolaborasi
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight">Undangan Kelompok Proyek</h1>
                <p class="text-xs text-purple-100/80 max-w-2xl">
                    Kelola dan konfirmasi partisipasi Anda dalam tim proyek PjBL secara langsung.
                </p>
            </div>

            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-xl self-stretch sm:self-auto justify-center">
                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="block text-xl font-black leading-none">{{ $totalUndangan }}</span>
                    <span class="text-[10px] text-purple-200 font-medium">Menunggu Respon</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Cards Grid (3 Kolom pada Layar Lebar agar Pas 1 Halaman) -->
    @if($undanganMasuk->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($undanganMasuk as $undangan)
                <div class="group relative bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden">
                    
                    <div class="h-1 w-full bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500"></div>

                    <div class="p-4 space-y-3">
                        <!-- Peran Badge & Timestamp -->
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-bold text-purple-700 bg-purple-50 border border-purple-200/60">
                                <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Peran: {{ $undangan->peran }}
                            </span>
                            <span class="text-[10px] font-medium text-slate-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $undangan->created_at ? $undangan->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>

                        <!-- Info Judul Proyek -->
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition-colors line-clamp-1">
                                {{ $undangan->project->judul ?? 'Judul Proyek Tidak Ditemukan' }}
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-snug">
                                {{ $undangan->project->deskripsi ?? 'Tidak ada deskripsi rinci untuk proyek ini.' }}
                            </p>
                        </div>

                        <!-- Meta Info Compact (Pembimbing & Kategori) -->
                        <div class="bg-slate-50 rounded-lg p-2.5 space-y-1.5 border border-slate-100 text-[11px]">
                            @php
                                $pembimbingData = is_string($undangan->project->pembimbing) 
                                    ? json_decode($undangan->project->pembimbing, true) 
                                    : $undangan->project->pembimbing;

                                $utamaList = \App\Models\User::whereIn('id', $pembimbingData['utama'] ?? [])->get();
                                $umumList = \App\Models\User::whereIn('id', $pembimbingData['umum'] ?? [])->get();
                                $industriList = \App\Models\User::whereIn('id', $pembimbingData['industri'] ?? [])->get();
                            @endphp

                            <div class="flex flex-col gap-1">
                                <span class="font-medium text-slate-400 text-xs">Tim Pembimbing:</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($utamaList as $user)
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-md font-medium">
                                            Utama: {{ $user->name }}
                                        </span>
                                    @endforeach

                                    @foreach($umumList as $user)
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs rounded-md font-medium">
                                            Umum: {{ $user->name }}
                                        </span>
                                    @endforeach

                                    @foreach($industriList as $user)
                                        <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-xs rounded-md font-medium">
                                            Industri: {{ $user->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-slate-600 border-t border-slate-200/50 pt-1.5">
                                <span class="font-medium text-slate-400">Kategori</span>
                                <span class="font-semibold text-slate-800 line-clamp-1">{{ $undangan->project->kategori ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Ringkasan Anggota Kelompok (Sangat Ringkas & Rapi) -->
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">
                                Anggota Tim ({{ isset($undangan->project->members) ? $undangan->project->members->count() : 0 }})
                            </span>

                            <div class="max-h-28 overflow-y-auto pr-1 space-y-1 scrollbar-thin scrollbar-thumb-slate-200">
                                @if(isset($undangan->project->members) && $undangan->project->members->count() > 0)
                                    @foreach($undangan->project->members as $member)
                                        <div class="flex items-center justify-between px-2 py-1 rounded-md bg-slate-50 border border-slate-100/80 text-[11px]">
                                            <div class="flex items-center gap-1.5 min-w-0">
                                                <div class="w-5 h-5 rounded-full shrink-0 {{ $member->is_leader ? 'bg-amber-500' : 'bg-indigo-500' }} text-white text-[9px] font-bold flex items-center justify-center">
                                                    {{ strtoupper(substr($member->nama_siswa, 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-slate-700 truncate">{{ $member->nama_siswa }}</span>
                                            </div>

                                            <div class="flex items-center gap-1 shrink-0">
                                                @if($member->is_leader)
                                                    <span class="px-1.5 py-0.5 text-[8px] font-bold text-amber-700 bg-amber-100 rounded">Ketua</span>
                                                @endif
                                                
                                                @if($member->status === 'accepted')
                                                    <span class="text-[9px] text-emerald-600 font-bold">✓</span>
                                                @else
                                                    <span class="text-[9px] text-amber-600 font-medium">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-[10px] text-slate-400 italic">Belum ada anggota lain.</p>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Actions Footer -->
                    <div class="p-3 bg-slate-50/50 border-t border-slate-100 flex gap-2">
                        <button type="button" 
                                onclick="jawabUndangan({{ $undangan->id }}, 'accept')"
                                class="flex-1 py-2 px-3 text-[11px] font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-lg transition-all duration-150 flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terima
                        </button>

                        <button type="button" 
                                onclick="jawabUndangan({{ $undangan->id }}, 'reject')"
                                class="py-2 px-3 text-[11px] font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200/60 rounded-lg transition-all duration-150 flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak
                        </button>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <!-- Modern Empty State -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-10 text-center shadow-sm">
            <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-purple-100/80">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800">Tidak Ada Undangan Masuk</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">
                Saat ini Anda belum memiliki permintaan untuk bergabung ke kelompok proyek mana pun.
            </p>
        </div>
    @endif

</div>

<!-- Script Handling AJAX Response -->
<script>
async function jawabUndangan(id, action) {
    const isAccept = action === 'accept';
    const actionText = isAccept ? 'menerima' : 'menolak';

    const confirm = await Swal.fire({
        title: 'Konfirmasi Undangan',
        text: `Apakah Anda yakin ingin ${actionText} undangan proyek ini?`,
        icon: isAccept ? 'question' : 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: isAccept ? '#059669' : '#dc2626',
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl font-bold px-4 py-2 text-xs',
            cancelButton: 'rounded-xl font-bold px-4 py-2 text-xs'
        }
    });

    if (!confirm.isConfirmed) return;

    try {
        const url = `{{ route('siswa.pjbl.invitation.response') }}?id=${id}&action=${action}`;

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (response.ok && result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: result.message,
                timer: 1500,
                showConfirmButton: false,
                customClass: { popup: 'rounded-2xl' }
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: result.message || 'Terjadi kesalahan saat memproses data.',
                customClass: { popup: 'rounded-2xl' }
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: 'Gagal terhubung ke server.',
            customClass: { popup: 'rounded-2xl' }
        });
    }
}
</script>
@endsection