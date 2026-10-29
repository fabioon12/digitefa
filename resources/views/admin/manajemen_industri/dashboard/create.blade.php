@extends('admin.layouts.app')

@section('title', 'Tambah Industri - CertiLearn')

@section('content')
<div x-data="{ 
    photoPreview: '', 
    showPassword: false,
    password: '',
    passwordConfirmation: '',
    generatePassword() {
        const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
        let res = '';
        for (let i = 0; i < 10; i++) {
            res += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        this.password = res;
        this.passwordConfirmation = res;
    }
}" class="space-y-6 max-w-4xl mx-auto">

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Tambah Industri (DU/DI) Baru</h1>
            <p class="text-xs text-slate-400 mt-1">Isi formulir di bawah ini untuk menambahkan akun mitra industri baru.</p>
        </div>
        <a href="{{ route('admin.manajemen-industri.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-xs font-medium transition shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Alert Error Validation -->
    @if ($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-600 space-y-1">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Terdapat kesalahan pada pengisian form:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.manajemen-industri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- B. FOTO PROFIL / LOGO -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Foto / Logo Perusahaan</h3>
                
                <div class="flex items-center gap-5">
                    <div class="relative w-20 h-20 rounded-2xl border-2 border-slate-100 overflow-hidden bg-slate-50 flex items-center justify-center shrink-0">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            <i class="fa-solid fa-building text-2xl text-slate-300"></i>
                        </template>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Foto / Logo</label>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*"
                            x-ref="photo"
                            @change="
                                const file = $refs.photo.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL(file);
                                }
                            ">
                        <button type="button" @click="$refs.photo.click()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-medium transition">
                            Pilih File Foto
                        </button>
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- INFORMASI PERUSAHAAN & PENANGGUNG JAWAB -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Profil</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- C. NAMA LENGKAP -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Masukkan nama penanggung jawab"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>

                    <!-- G. NAMA PERUSAHAAN -->
                    <div>
                        <label for="company_name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Perusahaan</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" placeholder="Contoh: PT. Technology Nusantara"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>

                    <!-- D. BIDANG SEKTOR -->
                    <div>
                        <label for="sector" class="block text-xs font-semibold text-slate-700 mb-1.5">Bidang Sektor</label>
                        <input type="text" name="sector" id="sector" value="{{ old('sector') }}" placeholder="Contoh: Software & Rekayasa Perangkat Lunak"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>

                    <!-- H. JABATAN / POSISI -->
                    <div>
                        <label for="position" class="block text-xs font-semibold text-slate-700 mb-1.5">Jabatan / Posisi</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}" placeholder="Contoh: Manager HRD / Software Engineer"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>

                    <!-- D. JENIS KELAMIN -->
                    <div>
                        <label for="gender" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- STATUS AKUN -->
                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Akun <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Aktif (Approved)</option>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Nonaktif (Rejected)</option>
                        </select>
                    </div>

                </div>
            </div>

            <hr class="border-slate-100">

            <!-- KREDENSIAL AKUN LOGIN -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kredensial Login</h3>
                    <button type="button" @click="generatePassword()" class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-key"></i>
                        <span>Generate Password</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- E. USERNAME -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required placeholder="Contoh: industri_tekno"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                    </div>

                    <!-- F. EMAIL -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Contoh: hrd@perusahaan.com"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>

                    <!-- I. PASSWORD -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" id="password" x-model="password" required placeholder="Minimal 8 karakter"
                                class="w-full px-3.5 py-2.5 pr-10 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- I. KONFIRMASI PASSWORD -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" x-model="passwordConfirmation" required placeholder="Ulangi password"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                    </div>

                    <div class="sm:col-span-2 mt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="must_change_password" value="1" {{ old('must_change_password') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <span class="text-xs text-slate-600 font-medium">Wajibkan mengganti password pada saat login pertama kali</span>
                        </label>
                    </div>

                </div>
            </div>

            <!-- Submit Button Area -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.manajemen-industri.dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-500/20 transition active:scale-95">
                    Simpan Industri Baru
                </button>
            </div>

        </form>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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