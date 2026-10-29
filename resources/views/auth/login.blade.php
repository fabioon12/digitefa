<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - CertiLearn</title>
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
        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 border border-slate-100">
            
            <!-- SISI KIRI: Branding & Informasi -->
            <div class="bg-gradient-to-br from-blue-50/80 via-slate-50 to-blue-50/30 p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden">
                <!-- Header Brand -->
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 text-white p-2.5 rounded-xl shadow-md flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-blue-600 tracking-tight leading-tight">CertiLearn</h2>
                        <p class="text-xs text-slate-500 font-medium">Sertifikasi Kompetensi</p>
                    </div>
                </div>

                <!-- Teks Utama -->
                <div class="my-10 z-10">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                        Sertifikasi Kompetensi, <br>
                        <span class="text-blue-600">Bukti Nyata Prestasimu.</span>
                    </h1>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-md">
                        Kelola pembelajaran PjBL dan TEFA, nilai kompetensi, dan generate sertifikat secara mudah, transparan, dan terpercaya.
                    </p>
                </div>

                <!-- Ilustrasi Sertifikat SVG -->
                <div class="relative flex justify-center items-end pt-4">
                    <div class="w-64 h-48 bg-white/80 backdrop-blur border border-blue-100 rounded-2xl shadow-lg p-4 relative flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="h-2.5 bg-blue-200 rounded-full w-3/4"></div>
                            <div class="h-2 bg-slate-100 rounded-full w-full"></div>
                            <div class="h-2 bg-slate-100 rounded-full w-5/6"></div>
                            <div class="h-2 bg-slate-100 rounded-full w-4/6"></div>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <div class="h-1.5 bg-slate-200 rounded-full w-12"></div>
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-md">
                                <i class="fa-solid fa-ribbon text-lg"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -left-4 bottom-2 text-blue-200 opacity-60 text-5xl pointer-events-none">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div class="absolute -right-4 bottom-2 text-blue-200 opacity-60 text-5xl pointer-events-none">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                </div>
            </div>

            <!-- SISI KANAN: Form Login -->
            <div class="p-8 sm:p-12 flex flex-col justify-center bg-white" x-data="{ showPassword: false, selectedRole: '{{ old('role', 'siswa') }}' }">
                
                <!-- Header Form -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Masuk ke Akun</h2>
                    <p class="text-xs text-slate-400 mt-1">Pilih peran dan masuk untuk melanjutkan</p>
                </div>

                <!-- ================= ALERT NOTIFIKASI ERROR / SUCCESS ================= -->
                @if ($errors->has('login_error'))
                    <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-600">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-base text-rose-500 mt-0.5"></i>
                        <div>
                            <span class="font-bold block">Gagal Masuk</span>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check text-base text-emerald-500 mt-0.5"></i>
                        <div>
                            <span class="font-bold block">Berhasil</span>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any() && !session('error'))
                    <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-base text-rose-500 mt-0.5"></i>
                        <div>
                            <ul class="list-disc list-inside mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <!-- ==================================================================== -->

                <!-- Form Login Laravel -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Input Hidden Role -->
                    <input type="hidden" name="role" :value="selectedRole">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Masuk Sebagai</label>
                        <!-- Ubah grid-cols-3 menjadi grid-cols-4 untuk menampung 4 pilihan -->
                        <div class="grid grid-cols-4 gap-1.5 p-1.5 bg-slate-100 rounded-2xl">
                            
                            <!-- Role Siswa -->
                            <button type="button" @click="selectedRole = 'siswa'"
                                class="flex items-center justify-center gap-1.5 py-2.5 px-2 rounded-xl text-xs font-semibold transition duration-200"
                                :class="selectedRole === 'siswa' ? 'bg-white text-blue-600 shadow-md shadow-slate-200' : 'text-slate-500 hover:text-slate-800'">
                                <i class="fa-solid fa-graduation-cap text-sm"></i>
                                <span>Siswa</span>
                            </button>

                            <!-- Role Guru -->
                            <button type="button" @click="selectedRole = 'guru'"
                                class="flex items-center justify-center gap-1.5 py-2.5 px-2 rounded-xl text-xs font-semibold transition duration-200"
                                :class="selectedRole === 'guru' ? 'bg-white text-emerald-600 shadow-md shadow-slate-200' : 'text-slate-500 hover:text-slate-800'">
                                <i class="fa-solid fa-chalkboard-user text-sm"></i>
                                <span>Guru</span>
                            </button>

                            <!-- Role Industri (Baru) -->
                            <button type="button" @click="selectedRole = 'industri'"
                                class="flex items-center justify-center gap-1.5 py-2.5 px-2 rounded-xl text-xs font-semibold transition duration-200"
                                :class="selectedRole === 'industri' ? 'bg-white text-amber-600 shadow-md shadow-slate-200' : 'text-slate-500 hover:text-slate-800'">
                                <i class="fa-solid fa-building text-sm"></i>
                                <span>Industri</span>
                            </button>

                            <!-- Role Admin -->
                            <button type="button" @click="selectedRole = 'admin'"
                                class="flex items-center justify-center gap-1.5 py-2.5 px-2 rounded-xl text-xs font-semibold transition duration-200"
                                :class="selectedRole === 'admin' ? 'bg-white text-rose-600 shadow-md shadow-slate-200' : 'text-slate-500 hover:text-slate-800'">
                                <i class="fa-solid fa-user-shield text-sm"></i>
                                <span>Admin</span>
                            </button>

                        </div>
                    </div>

                    <!-- Field Login (Email / NISN / NIP / NPWP / Username) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2" 
                            x-text="selectedRole === 'siswa' ? 'NISN / Email' : (selectedRole === 'guru' ? 'NIP / Email' : (selectedRole === 'industri' ? 'ID Perusahaan / Email' : 'Username / Email'))"></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-user text-sm"></i>
                            </span>
                            <input type="text" name="login" value="{{ old('login') }}" required autofocus
                                :placeholder="selectedRole === 'siswa' ? 'Masukkan NISN atau Email' : (selectedRole === 'guru' ? 'Masukkan NIP atau Email' : (selectedRole === 'industri' ? 'Masukkan ID Perusahaan atau Email' : 'Masukkan Username atau Email'))"
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none transition"
                                :class="{
                                    'focus:border-blue-600': selectedRole === 'siswa',
                                    'focus:border-emerald-600': selectedRole === 'guru',
                                    'focus:border-amber-600': selectedRole === 'industri',
                                    'focus:border-rose-600': selectedRole === 'admin'
                                }">
                        </div>
                        @error('login')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Field Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-xs font-bold text-slate-700">Password</label>
                            <a href="" class="text-xs font-medium text-blue-600 hover:underline">Lupa password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                placeholder="Masukkan password"
                                class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none transition"
                                :class="{
                                    'focus:border-blue-600': selectedRole === 'siswa',
                                    'focus:border-emerald-600': selectedRole === 'guru',
                                    'focus:border-amber-600': selectedRole === 'industri',
                                    'focus:border-rose-600': selectedRole === 'admin'
                                }">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                <i class="fa-regular" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Masuk Dinamis Sesuai Peran -->
                    <button type="submit" 
                        class="w-full py-3.5 font-semibold text-sm rounded-xl shadow-md transition duration-200 text-white"
                        :class="{
                            'bg-blue-600 hover:bg-blue-700 shadow-blue-500/20': selectedRole === 'siswa',
                            'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20': selectedRole === 'guru',
                            'bg-amber-600 hover:bg-amber-700 shadow-amber-500/20': selectedRole === 'industri',
                            'bg-rose-600 hover:bg-rose-700 shadow-rose-500/20': selectedRole === 'admin'
                        }">
                        <span x-text="'Masuk sebagai ' + (selectedRole === 'siswa' ? 'Siswa' : (selectedRole === 'guru' ? 'Guru' : (selectedRole === 'industri' ? 'Mitra Industri' : 'Super Admin')))"></span>
                    </button>

                </form>

                <!-- Footer Pendaftaran -->
                <p class="text-center text-xs text-slate-500 mt-8">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">Daftar Akun</a>
                </p>
            </div>

        </div>
    </div>

    <!-- Footer Copyright -->
    <footer class="text-center py-4 text-xs text-slate-400">
        &copy; {{ date('Y') }} CertiLearn. All rights reserved.
    </footer>

</body>
</html>