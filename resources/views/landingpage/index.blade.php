<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiTefa - Teaching Factory & Kolaborasi Industri</title>
    <!-- Tailwind CSS CDN & FontAwesome Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="bg-purple-600 text-white p-2 rounded-lg flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-industry text-xl"></i>
                </div>
                <span class="text-xl font-bold text-slate-900 tracking-tight">DigiTefa</span>
            </div>

            <!-- Menu Navigation -->
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="#beranda" class="text-purple-600 border-b-2 border-purple-600 pb-1 font-bold">Beranda</a>
                <a href="#pilar" class="text-slate-600 hover:text-purple-600 transition">Pilar TEFA</a>
                <a href="#fitur" class="text-slate-600 hover:text-purple-600 transition">Keunggulan</a>
                <a href="#alur" class="text-slate-600 hover:text-purple-600 transition">Alur Produksi</a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded-lg shadow-sm transition">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="relative overflow-hidden bg-gradient-to-br from-purple-50/60 via-slate-50 to-white py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left Side (Teks & Tombol) -->
            <div class="lg:col-span-6 z-10">
                <!-- Badge Platform -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-purple-100/80 text-purple-700 rounded-full text-xs font-bold mb-6">
                    <i class="fa-solid fa-briefcase text-xs"></i>
                    <span>Standar Operasional Industri Nyata</span>
                </div>

                <!-- Judul Utama -->
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 leading-[1.15] tracking-tight mb-6">
                    Membangun <span class="text-purple-600">Kedisiplinan Kerja</span> & <span class="text-indigo-600">Kolaborasi Tim</span> Lewat Teaching Factory
                </h1>

                <!-- Deskripsi -->
                <p class="text-slate-600 text-base sm:text-lg mb-8 leading-relaxed">
                    DigiTefa mentransformasi sekolah kejuruan menjadi ekosistem produksi profesional. Satukan ritme kerja disiplin ala industri dengan sinergi kelompok yang solid dalam satu platform terpadu.
                </p>

                <!-- Tombol Aksi -->
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold text-sm rounded-xl shadow-md hover:shadow-lg transition flex items-center gap-2">
                        Mulai Kolaborasi <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="#pilar" class="px-6 py-3.5 bg-purple-50/50 hover:bg-purple-100/60 border border-purple-200 text-purple-700 font-semibold text-sm rounded-xl transition flex items-center gap-2">
                        Pelajari Sistem <i class="fa-solid fa-compass text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Hero Right Side (Elemen UI Interactive / Highlight Kolaborasi & Kedisiplinan) -->
            <div class="lg:col-span-6 relative flex justify-center items-center">
                
                <!-- Background Shape Effect -->
                <div class="absolute w-[450px] h-[450px] bg-purple-200/40 rounded-full blur-3xl -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>

                <div class="relative w-full max-w-lg space-y-4">
                    
                    <!-- Card 1: Simulasi Kedisiplinan Industri -->
                    <div class="bg-white p-5 rounded-2xl shadow-xl border border-slate-100 relative z-10">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">Disiplin Waktu & SOP</h4>
                                    <p class="text-[11px] text-slate-400">Unit Produksi Mekatronika & Software</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold rounded-full border border-emerald-200">Tepat Waktu</span>
                        </div>
                        <div class="space-y-2 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl">
                            <div class="flex justify-between"><span>Absensi & Standar Shift Kerja:</span> <strong class="text-slate-800">100% Disiplin</strong></div>
                            <div class="flex justify-between"><span>Patuh Tenggat Proyek (Deadline):</span> <strong class="text-emerald-600">Sesuai Target Industri</strong></div>
                        </div>
                    </div>

                    <!-- Card 2: Kolaborasi Tim & Pembagian Peran -->
                    <div class="bg-white p-5 rounded-2xl shadow-xl border border-slate-100 relative z-20 translate-x-4 sm:translate-x-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-users-gear"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">Sinergi Tim & Jobdesk</h4>
                                    <p class="text-[11px] text-slate-400">Kelompok Proyek Industri</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-[10px] font-extrabold rounded-full border border-purple-200">Kolaborasi Aktif</span>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-purple-600 text-white font-bold text-xs flex items-center justify-center ring-2 ring-white">KT</div>
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center ring-2 ring-white">DV</div>
                                <div class="w-8 h-8 rounded-full bg-slate-800 text-white font-bold text-xs flex items-center justify-center ring-2 ring-white">QA</div>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Ketua, Developer & QC Berkoordinasi</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- PILAR UTAMA TEFA: DISIPLIN & KOLABORASI -->
    <section id="pilar" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-purple-600 font-bold text-xs uppercase tracking-wider">Fokus Utama TEFA</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Dua Fondasi Utama Menuju <span class="text-purple-600">Standar Industri</span></h2>
                <p class="text-slate-500 text-sm mt-3">Membentuk mental kerja profesional melalui pembiasaan kedisiplinan tinggi dan kerja sama tim yang terstruktur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Pilar 1: Kedisiplinan -->
                <div class="p-8 rounded-3xl bg-gradient-to-br from-slate-50 to-purple-50/30 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-purple-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-md">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">1. Budaya Kedisiplinan Industri</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Di Teaching Factory, siswa tidak sekadar belajar teori, melainkan dididik untuk mematuhi Standar Operasional Prosedur (SOP), menghargai tenggat waktu produksi, dan memiliki etos kerja yang akuntabel layaknya pegawai perusahaan profesional.
                        </p>
                    </div>
                    <ul class="space-y-2.5 text-xs font-semibold text-slate-700 border-t border-slate-200/60 pt-6">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-purple-600"></i> Kepatuhan mutlak pada SOP & target pengerjaan</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-purple-600"></i> Pengawasan mutu produk secara ketat (Quality Control)</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-purple-600"></i> Pertanggungjawaban hasil kerja secara individu maupun tim</li>
                    </ul>
                </div>

                <!-- Pilar 2: Kolaborasi -->
                <div class="p-8 rounded-3xl bg-gradient-to-br from-slate-50 to-indigo-50/30 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-md">
                            <i class="fa-solid fa-people-group"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">2. Kolaborasi & Pembagian Peran</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Pekerjaan besar di industri diselesaikan secara tim. DigiTefa melatih siswa untuk berkoordinasi dalam kelompok, membagi tugas berdasarkan peran spesifik (Ketua Tim, Pengembang, Keuangan, hingga Pemasaran), dan menyelesaikan konflik proyek bersama.
                        </p>
                    </div>
                    <ul class="space-y-2.5 text-xs font-semibold text-slate-700 border-t border-slate-200/60 pt-6">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-600"></i> Struktur organisasi tim proyek yang jelas</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-600"></i> Komunikasi terpusat dan transparan antar anggota</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-600"></i> Sinergi bimbingan dari Guru Produktif dan Mentor Industri</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR PENDukung PLATFORM -->
    <section id="fitur" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-purple-600 font-bold text-xs uppercase tracking-wider">Fitur Pendukung</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Fasilitas Digital untuk <span class="text-purple-600">Produksi & Monitoring</span></h2>
                <p class="text-slate-500 text-sm mt-3">Memudahkan guru memantau progres kelompok dan kedisiplinan siswa secara real-time.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-200/60 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-diagram-project"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Manajemen Unit Proyek</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Kelola proposal, tahapan pengerjaan, hingga verifikasi proyek Teaching Factory secara terpadu.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-200/60 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-clipboard-user"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Evaluasi Disiplin & Tugas</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Penilaian performa kerja harian, kedisiplinan kehadiran, dan tanggung jawab peran individu dalam tim.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-200/60 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Kolaborasi Multi-Mentor</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Sistem pembimbingan terstruktur yang melibatkan Guru Utama, Guru Umum, dan Praktisi Industri.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR TEFA SECTION -->
    <section id="alur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-purple-600 font-bold text-xs uppercase tracking-wider">Alur Pembelajaran</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Langkah Kerja <span class="text-purple-600">Teaching Factory</span></h2>
                <p class="text-slate-500 text-sm mt-3">Dari pembentukan kelompok hingga menghasilkan produk dan layanan berkualitas tinggi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <!-- Step 1 -->
                <div class="flex flex-col items-center p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl mb-4 relative font-bold">
                        <i class="fa-solid fa-users"></i>
                        <span class="absolute -bottom-1 bg-purple-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">1</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Bentuk Tim & Peran</h4>
                    <p class="text-slate-500 text-xs mt-2 leading-relaxed">Siswa membentuk kelompok kerja dan membagi peran industri sesuai spesifikasi.</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl mb-4 relative font-bold">
                        <i class="fa-solid fa-file-signature"></i>
                        <span class="absolute -bottom-1 bg-purple-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">2</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Verifikasi Proposal</h4>
                    <p class="text-slate-500 text-xs mt-2 leading-relaxed">Guru dan mentor industri meninjau, memberi catatan revisi, dan menyetujui proyek.</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl mb-4 relative font-bold">
                        <i class="fa-solid fa-gears"></i>
                        <span class="absolute -bottom-1 bg-purple-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">3</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Proses Produksi Disiplin</h4>
                    <p class="text-slate-500 text-xs mt-2 leading-relaxed">Tim mengeksekusi proyek dengan menerapkan kedisiplinan kerja dan koordinasi rutin.</p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl mb-4 relative font-bold">
                        <i class="fa-solid fa-award"></i>
                        <span class="absolute -bottom-1 bg-purple-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">4</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Evaluasi & Sertifikasi</h4>
                    <p class="text-slate-500 text-xs mt-2 leading-relaxed">Penilaian akhir kualitas produk, kolaborasi tim, dan penerbitan sertifikat kompetensi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA BANNER SECTION -->
    <section class="py-10 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-gradient-to-r from-purple-900 to-indigo-800 rounded-2xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="flex items-center gap-6">
                    <i class="fa-solid fa-medal text-amber-400 text-5xl hidden sm:block"></i>
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Siap Wujudkan Budaya Kerja Industri di Sekolah Anda?</h3>
                        <p class="text-purple-100 text-sm max-w-xl">Tingkatkan kedisiplinan dan kolaborasi siswa melalui ekosistem Teaching Factory yang modern dan terstruktur.</p>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="whitespace-nowrap px-6 py-3 bg-white text-purple-900 font-semibold rounded-lg hover:bg-purple-50 transition shadow">
                    Bergabung Sekarang <i class="fa-solid fa-arrow-right text-xs ml-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-12 text-sm">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Col 1: Brand Info -->
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-2 text-white">
                    <div class="bg-purple-600 p-2 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-industry text-lg"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight">DigiTefa</span>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                    Platform manajemen Teaching Factory (TEFA) untuk menanamkan kedisiplinan kerja industri dan memperkuat kolaborasi tim bagi siswa SMK.
                </p>
            </div>

            <!-- Col 2: Navigation -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-xs uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#beranda" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#pilar" class="hover:text-white transition">Pilar TEFA</a></li>
                    <li><a href="#fitur" class="hover:text-white transition">Keunggulan</a></li>
                    <li><a href="#alur" class="hover:text-white transition">Alur Produksi</a></li>
                </ul>
            </div>

            <!-- Col 3: Auth / Legal -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-xs uppercase tracking-wider">Akun</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk Portal</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar Akun Baru</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                </ul>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-6 border-t border-slate-800 mt-12 pt-6 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} DigiTefa. All rights reserved.
        </div>
    </footer>

</body>
</html>