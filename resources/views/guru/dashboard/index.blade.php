@extends('guru.layouts.app')

@section('title', 'Dashboard Guru - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ selectedPeriode: '{{ $periode }}' }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <span>Portal Guru</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-slate-600 font-semibold">Overview</span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Dashboard Ringkasan Pembelajaran & TEFA</h1>
        </div>

        <div class="flex items-center gap-2">
            <select x-model="selectedPeriode" @change="window.location.href = '?periode=' + selectedPeriode" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 shadow-xs focus:outline-none focus:border-blue-600 transition">
                <option value="2025/2026">Tahun Ajaran 2025/2026 (Ganjil)</option>
                <option value="2024/2025">Tahun Ajaran 2024/2025 (Genap)</option>
            </select>
            <a href="/Guru/Kompetensi" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-500/20 transition active:scale-95">
                <i class="fa-solid fa-user-check text-xs"></i>
                <span>Penilaian Kompetensi</span>
            </a>
        </div>
    </div>

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Bimbingan Siswa -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Bimbingan Siswa</p>
                <h3 class="text-lg font-extrabold text-slate-800 mt-0.5">{{ number_format($totalSiswa) }} Siswa</h3>
                <p class="text-[10px] text-emerald-600 font-semibold mt-1">
                    <i class="fa-solid fa-circle-check mr-1"></i>{{ $totalKelas }} Kelas Aktif
                </p>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Card 2: Project PjBL Berjalan -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Project PjBL Berjalan</p>
                <h3 class="text-lg font-extrabold text-blue-600 mt-0.5">{{ number_format($proyekBerjalanCount) }} Proyek</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1">
                    {{ $proyekOnTrack }} On-Track • {{ $proyekDeadlineNear }} Mendekati Deadline
                </p>
            </div>
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
        </div>

        <!-- Card 3: Proyek TEFA -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Proyek Kategori TEFA</p>
                <h3 class="text-lg font-extrabold text-amber-600 mt-0.5">{{ number_format($orderTefaCount) }} Proyek</h3>
                <p class="text-[10px] text-amber-600 font-semibold mt-1">
                    <i class="fa-solid fa-clock mr-1"></i>{{ $orderDalamProduksi }} Berstatus Disetujui
                </p>
            </div>
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-industry"></i>
            </div>
        </div>

        <!-- Card 4: Perlu Penilaian -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Perlu Penilaian (K)</p>
                <h3 class="text-lg font-extrabold text-rose-600 mt-0.5">{{ number_format($perluPenilaianCount) }} Siswa</h3>
                <p class="text-[10px] text-rose-600 font-semibold mt-1">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>Belum Dievaluasi
                </p>
            </div>
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-clipboard-question"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Area: 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column Left (2/3): Activity & Quick Access -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Banner Pintas Aksi Cepat -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-5 text-white shadow-md relative overflow-hidden">
                <div class="relative z-10 space-y-2">
                    <span class="px-2.5 py-0.5 bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] font-bold rounded-md uppercase tracking-wider">Pusat Kendali Mentor / Evaluator</span>
                    <h2 class="text-lg font-extrabold tracking-tight">Siap Memverifikasi Kelayakan Kompetensi Siswa?</h2>
                    <p class="text-slate-300 text-xs max-w-lg leading-relaxed">
                        Terdapat <strong class="text-white underline">{{ $perluPenilaianCount }} siswa</strong> bimbingan yang perlu peninjauan evaluasi proyek & penilaian kriteria kompetensi.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-2">
                        <a href="{{route('guru.kompetensi.pjbl.index')}}" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl transition shadow-xs">
                            Review Penentuan Kompetensi
                        </a>
                        <a href="/Guru/PJBL" class="px-3.5 py-2 bg-white/10 hover:bg-white/20 text-slate-200 text-xs font-semibold rounded-xl transition backdrop-blur-xs">
                            Pantau Proyek PjBL
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table Status Produksi & Proyek Aktif -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Aktivitas Proyek PjBL & Shift TEFA Utama</h2>
                        <p class="text-[10px] text-slate-400">Progres pengerjaan berdasarkan tugas (tasks) proyek</p>
                    </div>
                    <a href="/Guru/TEFA" class="text-xs text-blue-600 hover:underline font-semibold">Lihat Semua Proyek &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-[10px] border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-4">Nama Proyek</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Tipe / Kelas</th>
                                <th class="py-3 px-4">Progres Task</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($aktivitasProyek as $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-slate-800">{{ $item['nama_proyek'] }}</div>
                                        <div class="text-[10px] text-slate-400 line-clamp-1">{{ $item['keterangan'] ?? 'Tidak ada deskripsi' }}</div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 {{ $item['kategori'] === 'TEFA' ? 'bg-purple-50 text-purple-700' : 'bg-blue-50 text-blue-700' }} font-bold rounded text-[9px]">
                                            {{ $item['kategori'] }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="font-semibold text-slate-800">{{ $item['shift_atau_tim'] }}</span>
                                        <div class="text-[9px] text-slate-400">{{ $item['kelas'] }}</div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="w-32 bg-slate-100 rounded-full h-2 mb-1 overflow-hidden">
                                            <div class="h-2 rounded-full {{ $item['progres'] == 100 ? 'bg-emerald-500' : ($item['progres'] >= 50 ? 'bg-blue-600' : 'bg-amber-500') }}" style="width: {{ $item['progres'] }}%"></div>
                                        </div>
                                        <span class="text-[9px] font-bold {{ $item['progres'] == 100 ? 'text-emerald-600' : ($item['progres'] >= 50 ? 'text-blue-600' : 'text-amber-600') }}">
                                            {{ $item['progres'] }}% ({{ $item['status_teks'] }})
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="/Guru/Projects/{{ $item['id'] }}" class="px-2.5 py-1 inline-block {{ $item['is_ready_qc'] ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} rounded-lg text-[10px] font-semibold transition">
                                            {{ $item['is_ready_qc'] ? 'QC Now' : 'Detail' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                        Belum ada aktivitas proyek PjBL atau TEFA aktif saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Column Right (1/3): Summary & Timeline Widget -->
        <div class="space-y-6">

            <!-- Antrean Lisensi Sertifikat -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Antrean Lisensi Sertifikat</h3>
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded text-[10px] font-bold">{{ number_format($totalSertifikatReady) }} Ready</span>
                </div>

                <div class="space-y-3">
                    @forelse($antreanSertifikat as $sertifikat)
                        <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-slate-800">{{ $sertifikat->jurusan }}</p>
                                <p class="text-[10px] text-slate-400">{{ $sertifikat->total_siswa }} Siswa Kompeten</p>
                            </div>
                            <a href="/Guru/Sertifikat?jurusan={{ urlencode($sertifikat->jurusan) }}" class="text-blue-600 hover:text-blue-700 font-bold text-[11px]">
                                Cetak <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-center text-xs text-slate-400 py-3">Tidak ada antrean cetak sertifikat.</p>
                    @endforelse
                </div>
            </div>



        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        @if (session('success') || session('login_success'))
            Swal.fire({
                title: "Selamat Datang Kembali!",
                text: "Senang melihatmu lagi, {{ Auth::user()->username }}. !",
                icon: "success",
                showConfirmButton: true,
                confirmButtonText: "Ok",
                confirmButtonColor: "#22C55E",
                timer: 5000,
                timerProgressBar: true,
                background: '#ffffff',
                iconColor: '#22C55E',
                customClass: {
                    title: 'font-black text-slate-800 text-2xl',
                    popup: 'rounded-[40px] p-10',
                    confirmButton: 'rounded-2xl px-10 py-4 font-bold shadow-xl shadow-green-200 transition-transform hover:scale-105'
                }
            });
        @endif

    });
</script>
@endsection