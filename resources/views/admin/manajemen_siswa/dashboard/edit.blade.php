@extends('admin.layouts.app')

@section('title', 'Edit Siswa - CertiLearn')

@section('content')
<div class="space-y-6" x-data="{ imagePreview: '{{ $siswa->image ? asset('storage/' . $siswa->image) : '' }}' }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Edit Data Siswa</h1>
            <p class="text-xs text-slate-400 mt-1">Perbarui informasi profil dan akun siswa di bawah ini.</p>
        </div>
        <a href="{{ route('admin.manajemen-siswa.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200/80 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 transition shadow-sm self-start sm:self-auto">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Card Form -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" 
        x-data="{ imagePreview: '{{ $siswa->image ? Storage::url($siswa->image) : null }}' }">
        
        <form action="{{ route('admin.manajemen-siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Profil & Upload Foto -->
            <div class="border-b border-slate-100 pb-6">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-image text-blue-600"></i>
                    <span>Foto Profil</span>
                </h2>
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="w-20 h-20 rounded-2xl object-cover border-2 border-blue-500 shadow-sm">
                        </template>
                        <template x-if="!imagePreview">
                            <div class="w-20 h-20 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                                <i class="fa-solid fa-user text-2xl"></i>
                            </div>
                        </template>
                    </div>
                    <div>
                        <label for="image" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-xl cursor-pointer transition">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Ubah Foto</span>
                            <input type="file" id="image" name="image" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp" 
                                @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }">
                        </label>
                        <p class="text-[11px] text-slate-400 mt-1.5">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                        @error('image')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Identitas Siswa -->
            <div class="border-b border-slate-100 pb-6 space-y-4">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-blue-600"></i>
                    <span>Identitas Siswa</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $siswa->name) }}" placeholder="Masukkan nama lengkap siswa" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('name') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-xs font-semibold text-slate-700 mb-1">Jenis Kelamin</label>
                        <select name="gender" id="gender"
                            class="w-full px-3.5 py-2.5 bg-white border @error('gender') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $siswa->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $siswa->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIS / NISN -->
                    <div>
                        <label for="nisn" class="block text-xs font-semibold text-slate-700 mb-1">NIS / NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Contoh: 0051234567"
                            class="w-full px-3.5 py-2.5 bg-white border @error('nisn') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('nisn') 
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tingkat Kelas -->
                    <div>
                        <label for="class" class="block text-xs font-semibold text-slate-700 mb-1">Kelas</label>
                        <select name="class" id="class"
                            class="w-full px-3.5 py-2.5 bg-white border @error('class') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">Pilih Tingkat Kelas</option>
                            <option value="X" {{ old('class', $siswa->class) == 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI" {{ old('class', $siswa->class) == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                            <option value="XII" {{ old('class', $siswa->class) == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        </select>
                        @error('class')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Program Keahlian / Jurusan -->
                    <div>
                        <label for="major" class="block text-xs font-semibold text-slate-700 mb-1">Program Keahlian / Jurusan</label>
                        <select name="major" id="major"
                            class="w-full px-3.5 py-2.5 bg-white border @error('major') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">Pilih Program Keahlian</option>
                            <option value="Teknik Grafika" {{ old('major', $siswa->major) == 'Teknik Grafika' ? 'selected' : '' }}>Teknik Grafika</option>
                            <option value="Desain Komunikasi Visual (DKV) / Multimedia" {{ old('major', $siswa->major) == 'Desain Komunikasi Visual (DKV) / Multimedia' ? 'selected' : '' }}>Desain Komunikasi Visual (DKV) / Multimedia</option>
                            <option value="Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)" {{ old('major', $siswa->major) == 'Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)' ? 'selected' : '' }}>Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)</option>
                            <option value="Teknik Komputer dan Jaringan (TKJ)" {{ old('major', $siswa->major) == 'Teknik Komputer dan Jaringan (TKJ)' ? 'selected' : '' }}>Teknik Komputer dan Jaringan (TKJ)</option>
                            <option value="Animasi" {{ old('major', $siswa->major) == 'Animasi' ? 'selected' : '' }}>Animasi</option>
                            <option value="Teknik Mekatronika" {{ old('major', $siswa->major) == 'Teknik Mekatronika' ? 'selected' : '' }}>Teknik Mekatronika</option>
                            <option value="Teknik Logistik / Logistik" {{ old('major', $siswa->major) == 'Teknik Logistik / Logistik' ? 'selected' : '' }}>Teknik Logistik / Logistik</option>
                            <option value="Perhotelan" {{ old('major', $siswa->major) == 'Perhotelan' ? 'selected' : '' }}>Perhotelan</option>
                        </select>
                        @error('major')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Offering -->
                    <div>
                        <label for="offering" class="block text-xs font-semibold text-slate-700 mb-1">Offering / Rombel</label>
                        <select name="offering" id="offering"
                            class="w-full px-3.5 py-2.5 bg-white border @error('offering') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">Pilih Offering (Opsional)</option>
                            <option value="A" {{ old('offering', $siswa->offering) == 'A' ? 'selected' : '' }}>Offering A</option>
                            <option value="B" {{ old('offering', $siswa->offering) == 'B' ? 'selected' : '' }}>Offering B</option>
                            <option value="C" {{ old('offering', $siswa->offering) == 'C' ? 'selected' : '' }}>Offering C</option>
                            <option value="D" {{ old('offering', $siswa->offering) == 'D' ? 'selected' : '' }}>Offering D</option>
                            <option value="E" {{ old('offering', $siswa->offering) == 'E' ? 'selected' : '' }}>Offering E</option>
                            <option value="F" {{ old('offering', $siswa->offering) == 'F' ? 'selected' : '' }}>Offering F</option>
                        </select>
                        @error('offering')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Akun & Keamanan -->
            <div class="space-y-4">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user-lock text-blue-600"></i>
                    <span>Informasi Akun & Akses</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" id="username" value="{{ old('username', $siswa->username) }}" placeholder="Masukkan username unik" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('username') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('username')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $siswa->email) }}" placeholder="contoh@siswa.belajar.id" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('email') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru <span class="text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                            class="w-full px-3.5 py-2.5 bg-white border @error('password') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>

                    <!-- Status Akun -->
                    <div class="sm:col-span-2">
                        <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status Akun <span class="text-rose-500">*</span></label>
                        <select name="status" id="status" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('status') border-rose-500 @else border-slate-200/80 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="approved" {{ old('status', $siswa->status) == 'approved' ? 'selected' : '' }}>Approved (Aktif)</option>
                            <option value="pending" {{ old('status', $siswa->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="rejected" {{ old('status', $siswa->status) == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Opsi Wajib Ubah Password -->
                    <div class="sm:col-span-2 pt-2">
                        <label class="inline-flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="must_change_password" value="1" {{ old('must_change_password', $siswa->must_change_password) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                            <span class="text-xs font-medium text-slate-700">Wajibkan siswa mengganti kata sandi saat login berikutnya</span>
                        </label>
                        @error('must_change_password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.manajemen-siswa.dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-500/20 transition active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    <span>Perbarui Siswa</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection