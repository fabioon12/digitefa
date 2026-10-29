<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CertiLearn Admin')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <style>
        #nprogress .bar {
            background: #1d27e1 !important; 
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
<body class="bg-slate-50 font-sans text-slate-700 antialiased min-h-screen" 
      x-data="{ sidebarOpen: true, mobileOpen: false }">
    <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-slate-200 border-t-rose-600 rounded-full animate-spin"></div>
            <span class="text-xs font-semibold text-slate-600">Memuat halaman...</span>
        </div>
    </div>
    <div class="min-h-screen flex flex-col">

        <!-- Sidebar Navigation & Backdrop Mobile -->
        @include('guru.layouts.sidebar')

        <!-- Main Content Wrapper -->
        <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" 
             class="flex-1 flex flex-col transition-all duration-300 ease-in-out min-h-screen">
            
            <!-- Header -->
            <header id="mainHeader" class="bg-white border-b border-slate-100 px-6 py-3.5 flex items-center justify-between sticky top-0 z-30 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <!-- Button Toggle Sidebar -->
                    <button @click="window.innerWidth >= 1024 ? sidebarOpen = !sidebarOpen : mobileOpen = !mobileOpen" 
                            type="button" 
                            aria-label="Toggle Sidebar" 
                            class="p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-50 border border-slate-200/80 rounded-xl transition active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                </div>

                @include('guru.layouts.partials.notification')
            </header>

            <!-- Dynamic Page Content -->
            <main class="p-4 sm:p-6 lg:p-8 flex-1">
                @yield('content')
            </main>

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
</html>