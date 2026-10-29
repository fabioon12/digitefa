<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - CertiLearn</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col justify-between antialiased">

    <!-- Container Utama -->
    <div class="flex-grow flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 sm:p-10 border border-slate-100 relative overflow-hidden">
            
            <!-- Elemen Dekoratif Background -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-50 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-indigo-50 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 text-center">
                
                <!-- Logo & Icon Header -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl mb-6 shadow-inner">
                    <i class="fa-regular fa-envelope-open text-3xl"></i>
                </div>

                <h1 class="text-2xl font-bold text-slate-900 mb-2">Verifikasi Email Anda</h1>
                
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Terima kasih telah mendaftar! Sebelum memulai, silakan periksa kotak masuk email Anda dan klik tautan verifikasi yang baru saja kami kirimkan.
                </p>

                <!-- Notifikasi Alamat Email Terdaftar -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 mb-6 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-at text-slate-400 text-xs"></i>
                    <span class="text-xs font-semibold text-slate-700 truncate max-w-[240px]">
                        {{ auth()->user()->email ?? 'email@contoh.com' }}
                    </span>
                </div>

                <!-- Alert jika Tautan Verifikasi Baru Berhasil Dikirim -->
                @if (session('status') == 'verification-link-sent' || session('message'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-2xl flex items-start gap-3 text-left">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-base mt-0.5"></i>
                        <div>
                            <p class="font-bold mb-0.5">Tautan Baru Terkirim!</p>
                            <p>Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda gunakan saat mendaftar.</p>
                        </div>
                    </div>
                @endif

                <!-- Form Kirim Ulang Email Verifikasi -->
                <form method="POST" action="{{ route('verification.send') }}" x-data="{ submitting: false }" @submit="submitting = true" class="mb-4">
                    @csrf
                    <button type="submit" 
                        :disabled="submitting"
                        class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-md shadow-blue-200 transition duration-200 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                        
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                Kirim Ulang Email Verifikasi
                            </span>
                        </template>

                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                                Mengirimkan...
                            </span>
                        </template>
                    </button>
                </form>

                <!-- Form Keluar (Logout) -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-slate-400 hover:text-slate-600 font-medium transition duration-200 inline-flex items-center gap-1.5 py-1 px-3 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Keluar / Ganti Akun
                    </button>
                </form>

            </div>

        </div>
    </div>

    <!-- Footer Copyright -->
    <footer class="text-center py-4 text-xs text-slate-400">
        &copy; {{ date('Y') }} CertiLearn. All rights reserved.
    </footer>

</body>
</html>