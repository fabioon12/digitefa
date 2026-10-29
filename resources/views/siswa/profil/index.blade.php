@extends('siswa.layouts.app')

@section('title', 'Profil Saya - CertiLearn')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Profil</h1>
            <p class="text-xs sm:text-sm text-slate-500">Kelola informasi data diri dan keamanan akun Anda</p>
        </div>
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Update Profil -->
    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" 
          x-data="{ 
              photoPreview: '{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=2563eb&color=fff' }}' 
          }">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
            
            <!-- Banner & Profile Header -->
            <div class="h-28 sm:h-32 bg-gradient-to-r from-blue-600 to-indigo-600 relative"></div>
            <div class="px-6 pb-6 relative flex flex-col sm:flex-row items-center sm:items-end gap-4 -mt-10 sm:-mt-12">
                <div class="relative group">
                    <img :src="photoPreview" alt="Foto Profil" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-md bg-white">
                    <label for="image" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-xl shadow-md cursor-pointer hover:bg-blue-700 transition">
                        <i class="fa-solid fa-camera text-xs"></i>
                        <input type="file" id="image" name="image" class="hidden" accept="image/*"
                               @change="const file = $event.target.files[0]; if (file) { photoPreview = URL.createObjectURL(file) }">
                    </label>
                </div>

                <div class="text-center sm:text-left flex-grow">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                    <div class="flex items-center justify-center sm:justify-start gap-2 mt-1">
                        <!-- Role Read-Only Badge -->
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                            {{ Auth::user()->role === 'siswa' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ Auth::user()->role === 'guru' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ Auth::user()->role === 'industri' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ Auth::user()->role === 'admin' ? 'bg-rose-100 text-rose-700' : '' }}">
                            <i class="fa-solid fa-lock text-[9px] mr-1 opacity-60"></i> {{ Auth::user()->role }}
                        </span>
                        <span class="text-xs text-slate-400">• {{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100 space-y-6">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Informasi Utama</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 transition">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                        <select name="gender" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 transition">
                            <option value="L" {{ old('gender', Auth::user()->gender) === 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('gender', Auth::user()->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Detail Berdasarkan Role -->
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">
                        Data Peran: <span class="text-blue-600">{{ ucfirst(Auth::user()->role) }}</span>
                    </h3>

                    @if (Auth::user()->role === 'siswa')
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">NISN</label>
                                <input type="text" name="nisn" value="{{ old('nisn', Auth::user()->nisn) }}" required
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Kelas</label>
                                <input type="text" name="class" value="{{ old('class', Auth::user()->class) }}" required
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Jurusan</label>
                                <input type="text" name="major" value="{{ old('major', Auth::user()->major) }}" required
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                            </div>
                        </div>
                    @elseif (Auth::user()->role === 'guru')
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', Auth::user()->nip) }}" required
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                        </div>
                    @elseif (Auth::user()->role === 'industri')
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Nama Perusahaan</label>
                                <input type="text" name="company_name" value="{{ old('company_name', Auth::user()->company_name) }}" required
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Sektor</label>
                                <input type="text" name="sector" value="{{ old('sector', Auth::user()->sector) }}" required
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Jabatan</label>
                                <input type="text" name="position" value="{{ old('position', Auth::user()->position) }}" required
                                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Ganti Password -->
                <div class="pt-4 border-t border-slate-100" x-data="{ changePassword: false, showNewPass: false, showConfirmPass: false }">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Ubah Kata Sandi</h3>
                            <p class="text-[11px] text-slate-400">Biarkan kosong jika tidak ingin mengganti password</p>
                        </div>
                        <button type="button" @click="changePassword = !changePassword" class="text-xs text-blue-600 font-semibold hover:underline">
                            <span x-text="changePassword ? 'Batal' : 'Ubah Password'"></span>
                        </button>
                    </div>

                    <div x-show="changePassword" x-cloak class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password Baru -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Password Baru</label>
                            <div class="relative">
                                <input :type="showNewPass ? 'text' : 'password'" 
                                    name="password" 
                                    placeholder="Password baru"
                                    class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                                
                                <button type="button" 
                                        @click="showNewPass = !showNewPass" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition focus:outline-none">
                                    <i class="fa-solid" :class="showNewPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input :type="showConfirmPass ? 'text' : 'password'" 
                                    name="password_confirmation" 
                                    placeholder="Ulangi password baru"
                                    class="w-full px-4 py-2.5 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600">
                                
                                <button type="button" 
                                        @click="showConfirmPass = !showConfirmPass" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition focus:outline-none">
                                    <i class="fa-solid" :class="showConfirmPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-xs shadow-md shadow-blue-500/20 transition">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>

</div>
@endsection