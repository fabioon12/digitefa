@extends('admin.layouts.app')

@section('title', 'Dashboard - CertiLearn')

@section('content')
<div class="space-y-6">

    <!-- Page Title & Greeting -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-xs text-slate-400 mt-1">Selamat datang kembali, Super Admin! 👋</p>
    </div>

    <!-- ROW 1: Top 4 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-400">Total Siswa</span>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">3.250</h3>
                </div>
                <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-users text-sm"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-emerald-500 font-semibold">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                <span>12.5%</span>
                <span class="text-slate-400 font-normal">dari bulan lalu</span>
            </div>
        </div>

        <!-- Total Guru -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-400">Total Guru</span>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">180</h3>
                </div>
                <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-user-tie text-sm"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-emerald-500 font-semibold">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                <span>8.3%</span>
                <span class="text-slate-400 font-normal">dari bulan lalu</span>
            </div>
        </div>

        <!-- Sertifikat Terbit -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-400">Sertifikat Terbit</span>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">1.248</h3>
                </div>
                <div class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center shadow-md shadow-purple-500/20">
                    <i class="fa-solid fa-award text-sm"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-emerald-500 font-semibold">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                <span>15.7%</span>
                <span class="text-slate-400 font-normal">dari bulan lalu</span>
            </div>
        </div>

        <!-- Kompetensi Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-400">Kompetensi Aktif</span>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">256</h3>
                </div>
                <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center shadow-md shadow-amber-500/20">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs text-emerald-500 font-semibold">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                <span>10.2%</span>
                <span class="text-slate-400 font-normal">dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- ROW 2: Line Chart & Donut Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Chart: Sertifikat Terbit per Bulan -->
        <div class="lg:col-span-8 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800">Sertifikat Terbit per Bulan</h3>
                <select class="text-xs border border-slate-200 rounded-lg px-2.5 py-1 bg-slate-50 text-slate-600 font-medium focus:outline-none focus:border-blue-600 transition">
                    <option>Tahun 2026</option>
                    <option>Tahun 2025</option>
                </select>
            </div>
            <div class="h-64 w-full">
                <canvas id="lineChartSertifikat"></canvas>
            </div>
        </div>

        <!-- Chart: Perbandingan Pembelajaran (Donut Chart) -->
        <div class="lg:col-span-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-bold text-slate-800">Perbandingan Pembelajaran</h3>
                <select class="text-xs border border-slate-200 rounded-lg px-2.5 py-1 bg-slate-50 text-slate-600 font-medium focus:outline-none focus:border-blue-600 transition">
                    <option>Tahun 2026</option>
                    <option>Tahun 2025</option>
                </select>
            </div>
            
            <div class="relative flex items-center justify-center my-2 h-48">
                <canvas id="donutChartPembelajaran"></canvas>
            </div>

            <div class="space-y-2 text-xs">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> PjBL</span>
                    <span class="font-bold text-slate-700">62% (812)</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> TEFA</span>
                    <span class="font-bold text-slate-700">38% (498)</span>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex justify-between text-xs mt-3">
                <span class="text-slate-400">Total</span>
                <span class="font-bold text-slate-800">1.310 Pembelajaran</span>
            </div>
        </div>
    </div>

    <!-- ROW 3: 3 Column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Sertifikat Terbaru -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800">Sertifikat Terbaru</h3>
                <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Andi+Saputra&background=EBF4FF&color=2563EB" class="w-8 h-8 rounded-full">
                        <div>
                            <p class="font-bold text-slate-800">Andi Saputra</p>
                            <p class="text-[10px] text-slate-400">PjBL - Website E-Commerce</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-semibold">Diterbitkan</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=ECFDF5&color=059669" class="w-8 h-8 rounded-full">
                        <div>
                            <p class="font-bold text-slate-800">Siti Aisyah</p>
                            <p class="text-[10px] text-slate-400">TEFA - Desain Grafis</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-semibold">Diterbitkan</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=FEF3C7&color=D97706" class="w-8 h-8 rounded-full">
                        <div>
                            <p class="font-bold text-slate-800">Budi Santoso</p>
                            <p class="text-[10px] text-slate-400">PjBL - Aplikasi Inventori</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-semibold">Diterbitkan</span>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800">Aktivitas Terbaru</h3>
                <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="space-y-4 text-xs">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-xl text-xs shrink-0"><i class="fa-solid fa-pen-to-square"></i></div>
                    <div>
                        <p class="text-slate-700 font-medium leading-snug">Pak Budi menilai proyek PjBL "Aplikasi Inventori"</p>
                        <span class="text-[10px] text-slate-400 mt-0.5 block">10 menit yang lalu</span>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl text-xs shrink-0"><i class="fa-solid fa-award"></i></div>
                    <div>
                        <p class="text-slate-700 font-medium leading-snug">Sertifikat diterbitkan untuk Siti Aisyah</p>
                        <span class="text-[10px] text-slate-400 mt-0.5 block">1 jam yang lalu</span>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-xl text-xs shrink-0"><i class="fa-solid fa-plus"></i></div>
                    <div>
                        <p class="text-slate-700 font-medium leading-snug">Bu Rina menambahkan kompetensi baru "UI/UX Design"</p>
                        <span class="text-[10px] text-slate-400 mt-0.5 block">3 jam yang lalu</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembelajaran Berjalan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800">Pembelajaran Berjalan</h3>
                <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lihat semua</a>
            </div>
            <div class="space-y-4 text-xs">
                <div>
                    <div class="flex justify-between font-bold text-slate-800 mb-1.5">
                        <span>PjBL - Aplikasi E-Commerce</span>
                        <span class="text-blue-600">75%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full w-[75%] rounded-full"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between font-bold text-slate-800 mb-1.5">
                        <span>TEFA - Produksi Brosur</span>
                        <span class="text-emerald-500">60%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full w-[60%] rounded-full"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between font-bold text-slate-800 mb-1.5">
                        <span>PjBL - Sistem Informasi Sekolah</span>
                        <span class="text-amber-500">40%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full w-[40%] rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ROW 4: Bottom 3 Summary Widgets -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Distribusi Kompetensi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <h3 class="text-sm font-bold text-slate-800 mb-3">Distribusi Kompetensi</h3>
            <div class="h-3 w-full bg-slate-100 rounded-full flex overflow-hidden mb-4">
                <div class="bg-blue-600 w-[45%]" title="Teknis 45%"></div>
                <div class="bg-emerald-500 w-[30%]" title="Digital 30%"></div>
                <div class="bg-amber-500 w-[15%]" title="Soft Skill 15%"></div>
                <div class="bg-purple-600 w-[10%]" title="Lainnya 10%"></div>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs text-slate-600">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Teknis 45%</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Digital 30%</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Soft Skill 15%</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span> Lainnya 10%</span>
            </div>
        </div>

        <!-- Persentase Kelulusan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="relative flex items-center justify-center shrink-0">
                <svg class="w-16 h-16 transform -rotate-90">
                    <circle cx="32" cy="32" r="26" stroke="currentColor" stroke-width="6" class="text-slate-100" fill="transparent" />
                    <circle cx="32" cy="32" r="26" stroke="currentColor" stroke-width="6" class="text-blue-600" fill="transparent" stroke-dasharray="163" stroke-dashoffset="21" stroke-linecap="round" />
                </svg>
                <span class="absolute font-extrabold text-slate-800 text-xs">87%</span>
            </div>
            <div>
                <h4 class="text-xs font-bold text-slate-800">Tingkat Kelulusan Sertifikasi</h4>
                <p class="text-[11px] text-emerald-500 font-semibold mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> 
                    <span>7% dari bulan lalu</span>
                </p>
            </div>
        </div>

        <!-- Sertifikat Menunggu Verifikasi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 font-medium">Sertifikat Menunggu Verifikasi</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1">36</h3>
            </div>
            <a href="#" class="px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold text-xs rounded-xl transition shadow-sm">
                Tinjau Sekarang
            </a>
        </div>
    </div>

</div>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        // --- Inisialisasi Chart.js ---
        const ctxLine = document.getElementById('lineChartSertifikat').getContext('2d');
        const gradient = ctxLine.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Sertifikat',
                    data: [120, 190, 150, 220, 280, 210, 310, 290, 350, 380, 320, 410],
                    borderColor: '#2563eb',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#2563eb',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { size: 11 },
                        bodyFont: { size: 12, weight: 'bold' }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 10 } }
                    },
                    y: {
                        border: { dash: [4, 4] },
                        grid: { color: '#f1f5f9' },
                        ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 100 }
                    }
                }
            }
        });

        const ctxDonut = document.getElementById('donutChartPembelajaran').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['PjBL', 'TEFA'],
                datasets: [{
                    data: [812, 498],
                    backgroundColor: ['#2563eb', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8,
                        bodyFont: { size: 12 }
                    }
                }
            }
        });
    });
</script>
@endsection