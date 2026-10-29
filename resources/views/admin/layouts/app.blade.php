<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CertiLearn - Platform Sertifikasi Kompetensi')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    
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
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    <!-- Efek loader --> 
    <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 border-4 border-slate-200 border-t-rose-600 rounded-full animate-spin"></div>
            <span class="text-xs font-semibold text-slate-600">Memuat halaman...</span>
        </div>
    </div>

    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-30 hidden lg:hidden transition-opacity"></div>

    <div class="min-h-screen flex">

        @include('admin.layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0">

            <header id="mainHeader" class="bg-white border-b border-slate-100 px-6 py-3.5 flex items-center justify-between sticky top-0 z-30 transition-all duration-300 lg:ml-64">

                <div class="flex items-center gap-3">
                    
                    <button onclick="toggleSidebar()" type="button" aria-label="Toggle Sidebar" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-50 border border-slate-200/80 rounded-xl transition active:scale-95">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>

                </div>

                @include('admin.layouts.partials.notification')

            </header>

            
            <main id="mainContent" class="flex-1 p-6 lg:p-8 overflow-y-auto transition-all duration-300 lg:ml-64">
                @yield('content')
            </main>

        </div>

    </div>

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
</body>
</html>