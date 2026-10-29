<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CertiLearn - Portal Pembelajaran')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine JS untuk interaksi UI -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Kustomisasi Font & Tailwind Config -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    <style>
        /* Custom warna loading bar (opsional, ganti warna rose-600) */
        #nprogress .bar {
            background: #1d27e1 !important; /* warna rose-600 */
            height: 3px !important;
        }
        #nprogress .peg {
            box-shadow: 0 0 10px #1d27e1, 0 0 5px #1d27e1 !important;
        }
        #nprogress .spinner-icon {
            border-top-color: #1d27e1 !important;
            border-left-color: #1d27e1 !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
    <!-- Efek loader --> 
    <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-slate-200 border-t-rose-600 rounded-full animate-spin"></div>
            <span class="text-xs font-semibold text-slate-600">Memuat halaman...</span>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        @include('siswa.layouts.sidebar')

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            <header class="sticky top-0 z-30 flex items-center justify-between w-full px-4 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200/60 sm:px-6 lg:px-8">
                
                <div class="flex items-center gap-4">
                    <button @click="if (window.innerWidth >= 1024) { sidebarCollapsed = !sidebarCollapsed } else { sidebarOpen = !sidebarOpen }" 
                            class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition focus:outline-none"
                            title="Toggle Sidebar">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Kanan: Notifikasi & Profil -->
                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    @include('siswa.layouts.partials.notifications')

                    <!-- Divider -->
                    <div class="hidden sm:block w-px h-6 bg-slate-200"></div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-slate-700">{{ Auth::user()->username }}</p>
                                <p class="text-[10px] text-slate-400">
                                    {{ Auth::user()->class->name ?? Auth::user()->class ?? '-' }} | {{ Auth::user()->major->name ?? Auth::user()->major ?? '-' }}
                                </p>
                            </div>
                            
                            <!-- Dynamic Profile Image -->
                            @if (Auth::user()->image)
                                <img src="{{ asset('storage/' . Auth::user()->image) }}" 
                                    alt="{{ Auth::user()->username }}" 
                                    class="w-9 h-9 rounded-full border-2 border-blue-100 object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username) }}&background=2563eb&color=fff" 
                                    alt="{{ Auth::user()->username }}" 
                                    class="w-9 h-9 rounded-full border-2 border-blue-100 object-cover">
                            @endif

                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
                            <a href="{{ route('siswa.profile.edit') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                                <i class="fa-regular fa-user mr-2"></i> Profil Saya
                            </a>
                            <div class="h-px bg-slate-100 my-2"></div>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-semibold"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="w-full grow p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto px-6 py-4 border-t border-slate-200/60 text-center lg:text-left text-[10px] text-slate-400">
                &copy; {{ date('Y') }} CertiLearn - Sistem Manajemen PjBL, TEFA & Sertifikasi. SMK Bisa!
            </footer>
        </div>
    </div>
</body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('page-loader');

            function startLoading() {
                if (typeof NProgress !== 'undefined') NProgress.start();
                if (loader) loader.classList.remove('opacity-0', 'pointer-events-none');
            }

            function stopLoading() {
                if (typeof NProgress !== 'undefined') NProgress.done();
                if (loader) loader.classList.add('opacity-0', 'pointer-events-none');
            }

            document.addEventListener('click', function (e) {
                const link = e.target.closest('a');
                if (link) {
                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');

                    if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank') {
                        startLoading();
                    }
                }
            });

            document.addEventListener('submit', function (e) {
                if (!e.defaultPrevented) {
                    startLoading();
                }
            });

            window.addEventListener('pageshow', function () {
                stopLoading();
            });
        });
    </script>
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

@if(session('error'))
<script>
    Swal.fire({
        title: 'Gagal!',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'OK'
    });
</script>
@endif

@if(session('warning'))
<script>
    Swal.fire({
        title: 'Peringatan!',
        text: "{{ session('warning') }}",
        icon: 'warning',
        confirmButtonColor: '#d97706',
        confirmButtonText: 'OK'
    });
</script>
@endif

@if(session('info'))
<script>
    Swal.fire({
        title: 'Informasi',
        text: "{{ session('info') }}",
        icon: 'info',
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'OK'
    });
</script>
@endif

{{-- Notifikasi Error Validasi Form --}}
@if($errors->any())
<script>
    Swal.fire({
        title: 'Terjadi Kesalahan!',
        html: '{!! implode("<br>", $errors->all()) !!}',
        icon: 'error',
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'OK'
    });
</script>
@endif
</html>