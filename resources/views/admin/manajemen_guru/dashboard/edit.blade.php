@extends('admin.layouts.app')

@section('title', 'Edit Guru - CertiLearn')

@section('content')
<div x-data="{ 
    photoPreview: '{{ $guru->image ? asset('storage/' . $guru->image) : '' }}', 
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
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Edit Data Guru</h1>
            <p class="text-xs text-slate-400 mt-1">Perbarui informasi profil dan kredensial akun guru.</p>
        </div>
        <a href="{{ route('admin.manajemen-guru.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-xs font-medium transition shadow-sm">
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
        <form action="{{ route('admin.manajemen-guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Foto Profil -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Profil</h3>
                
                <div class="flex items-center gap-5">
                    <div class="relative w-20 h-20 rounded-full border-2 border-slate-100 overflow-hidden bg-slate-50 flex items-center justify-center shrink-0">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            @if($guru->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($guru->image))
                                <img src="{{ asset('storage/' . $guru->image) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-user text-2xl text-slate-300"></i>
                            @endif
                        </template>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ubah Foto Profil</label>
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
                            Pilih Foto Baru
                        </button>
                        <p class="text-[10px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah foto (Maks 2MB)</p>
                        @error('image')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Data Pribadi & Akademik -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Pribadi & Akademik</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $guru->name) }}" required placeholder="Contoh: Budi Santoso, S.Pd."
                            class="w-full px-3.5 py-2.5 bg-white border @error('name') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIP / NUPTK -->
                    <div>
                        <label for="nip" class="block text-xs font-semibold text-slate-700 mb-1.5">NIP / NUPTK</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}" placeholder="Contoh: 198501012010011001"
                            class="w-full px-3.5 py-2.5 bg-white border @error('nip') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                        @error('nip')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Mata Pelajaran -->
                    <div>
                        <label for="subject" class="block text-xs font-semibold text-slate-700 mb-1.5">Mata Pelajaran</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject', $guru->subject) }}" placeholder="Contoh: Pemrograman Web / Matematika"
                            class="w-full px-3.5 py-2.5 bg-white border @error('subject') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('subject')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="w-full px-3.5 py-2.5 bg-white border @error('gender') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('gender', $guru->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $guru->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: Kredensial Akun & Reset Password -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kredensial Akun</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Biarkan kolom password kosong jika tidak ingin mengganti password.</p>
                    </div>
                    <button type="button" @click="generatePassword()" class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-key"></i>
                        <span>Generate Password Baru</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" id="username" value="{{ old('username', $guru->username) }}" required placeholder="Contoh: budisantoso"
                            class="w-full px-3.5 py-2.5 bg-white border @error('username') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                        @error('username')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $guru->email) }}" required placeholder="Contoh: budi@sekolah.sch.id"
                            class="w-full px-3.5 py-2.5 bg-white border @error('email') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru (Opsional) -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Password Baru (Opsional)</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" id="password" x-model="password" placeholder="Minimal 8 karakter"
                                class="w-full px-3.5 py-2.5 pr-10 bg-white border @error('password') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" x-model="passwordConfirmation" placeholder="Ulangi password baru"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition shadow-sm font-mono">
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Akun <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required class="w-full px-3.5 py-2.5 bg-white border @error('status') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="approved" {{ old('status', $guru->status) == 'approved' ? 'selected' : '' }}>Aktif (Approved)</option>
                            <option value="pending" {{ old('status', $guru->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ old('status', $guru->status) == 'rejected' ? 'selected' : '' }}>Nonaktif (Rejected)</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2 mt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="must_change_password" value="1" {{ old('must_change_password', $guru->must_change_password) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <span class="text-xs text-slate-600 font-medium">Wajibkan guru mengganti password pada saat login berikutnya</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button Area -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.manajemen-guru.dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-500/20 transition active:scale-95">
                    Perbarui Data Guru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection