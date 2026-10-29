@extends('guru.layouts.app')

@section('title', 'Profil Saya - CertiLearn')

@section('content')
<div x-data="{ activeTab: 'info', photoPreview: null, showPassword: false }" class="max-w-6xl mx-auto space-y-6">

    <!-- Flash Message Success -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 1. Header Banner & Identity Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- Cover Decorative Background -->
        <div class="h-32 bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 relative">
            <div class="absolute inset-0 bg-black/5"></div>
        </div>

        <div class="px-6 pb-6 pt-0 relative">
            <div class="flex flex-col sm:flex-row items-center sm:items-end justify-between gap-4 -mt-12 sm:-mt-10 mb-4">
                
                <!-- Avatar & Identity Info -->
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 text-center sm:text-left">
                    <div class="relative w-24 h-24 rounded-2xl border-4 border-white bg-slate-100 shadow-md overflow-hidden shrink-0">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            @if(auth()->user()->image && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->image))
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff&size=200" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @endif
                        </template>
                    </div>

                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h2>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-xs text-slate-500 font-medium">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 rounded-lg text-slate-600">
                                <i class="fa-solid fa-book-bookmark text-blue-600"></i>
                                {{ auth()->user()->subject ? 'Guru ' . auth()->user()->subject : 'Pengajar' }}
                            </span>
                            @if(auth()->user()->nip)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 rounded-lg text-slate-600 font-mono">
                                    <i class="fa-solid fa-id-card text-slate-400"></i>
                                    NIP: {{ auth()->user()->nip }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs Trigger -->
                <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl w-full sm:w-auto">
                    <button @click="activeTab = 'info'" 
                        :class="activeTab === 'info' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 sm:flex-none px-4 py-2 rounded-lg text-xs font-bold transition">
                        <i class="fa-solid fa-user-gear mr-1.5"></i> Profil Saya
                    </button>
                    <button @click="activeTab = 'edit'" 
                        :class="activeTab === 'edit' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 sm:flex-none px-4 py-2 rounded-lg text-xs font-bold transition">
                        <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TAB CONTENT 1: Ringkasan & Informasi Profil -->
    <div x-show="activeTab === 'info'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Info Card Utama -->
        <div class="md:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-6">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Akademik & Pribadi</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3.5 bg-slate-50/70 border border-slate-100 rounded-xl space-y-1">
                        <span class="text-[11px] font-medium text-slate-400">Nama Lengkap</span>
                        <p class="text-xs font-bold text-slate-700">{{ auth()->user()->name }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50/70 border border-slate-100 rounded-xl space-y-1">
                        <span class="text-[11px] font-medium text-slate-400">Mata Pelajaran</span>
                        <p class="text-xs font-bold text-slate-700">{{ auth()->user()->subject ?? 'Belum Diatur' }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50/70 border border-slate-100 rounded-xl space-y-1">
                        <span class="text-[11px] font-medium text-slate-400">NIP / NUPTK</span>
                        <p class="text-xs font-bold text-slate-700 font-mono">{{ auth()->user()->nip ?? '-' }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50/70 border border-slate-100 rounded-xl space-y-1">
                        <span class="text-[11px] font-medium text-slate-400">Jenis Kelamin</span>
                        <p class="text-xs font-bold text-slate-700">
                            @if(auth()->user()->gender == 'L') Laki-laki
                            @elseif(auth()->user()->gender == 'P') Perempuan
                            @else -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Akun</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3.5 bg-slate-50/70 border border-slate-100 rounded-xl space-y-1">
                        <span class="text-[11px] font-medium text-slate-400">Username</span>
                        <p class="text-xs font-bold text-slate-700 font-mono">{{ auth()->user()->username }}</p>
                    </div>

                    <div class="p-3.5 bg-slate-50/70 border border-slate-100 rounded-xl space-y-1">
                        <span class="text-[11px] font-medium text-slate-400">Alamat Email</span>
                        <p class="text-xs font-bold text-slate-700">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Ringkas -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Akun</h3>
                
                <div class="flex items-center justify-between p-3 bg-emerald-50/60 border border-emerald-100 rounded-xl">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-emerald-700">Akun Aktif</span>
                    </div>
                    <i class="fa-solid fa-shield-check text-emerald-600"></i>
                </div>

                <div class="text-[11px] text-slate-500 space-y-2">
                    <div class="flex items-center justify-between">
                        <span>Role:</span>
                        <span class="font-bold text-slate-700 uppercase">{{ auth()->user()->role }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Terdaftar Sejak:</span>
                        <span class="font-bold text-slate-700">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TAB CONTENT 2: Form Edit Profil Guru -->
    <div x-show="activeTab === 'edit'" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section foto -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ubah Foto Profil</h3>
                
                <div class="flex items-center gap-5">
                    <div class="relative w-20 h-20 rounded-2xl border-2 border-slate-100 overflow-hidden bg-slate-50 flex items-center justify-center shrink-0">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            @if(auth()->user()->image && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->image))
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-user text-2xl text-slate-300"></i>
                            @endif
                        </template>
                    </div>

                    <div>
                        <input type="file" name="image" id="profile_image" class="hidden" accept="image/*"
                            x-ref="photo"
                            @change="
                                const file = $refs.photo.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL(file);
                                }
                            ">
                        <button type="button" @click="$refs.photo.click()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                            <i class="fa-solid fa-upload mr-1.5"></i> Pilih Foto Baru
                        </button>
                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks 2MB)</p>
                        @error('image')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section Input Data -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Pribadi & Pengajaran</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('name') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIP / NUPTK</label>
                        <input type="text" name="nip" value="{{ old('nip', auth()->user()->nip) }}" placeholder="Contoh: 198501012010011001"
                            class="w-full px-3.5 py-2.5 bg-white border @error('nip') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 font-mono focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('nip') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Mata Pelajaran</label>
                        <input type="text" name="subject" value="{{ old('subject', auth()->user()->subject) }}" placeholder="Contoh: Matematika / Bahasa Indonesia"
                            class="w-full px-3.5 py-2.5 bg-white border @error('subject') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin</label>
                        <select name="gender" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('gender', auth()->user()->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', auth()->user()->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section Kredensial & Password -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kredensial & Keamanan</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('username') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 font-mono focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                            class="w-full px-3.5 py-2.5 bg-white border @error('email') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-600 transition shadow-sm">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password Baru (Opsional)</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Kosongkan jika tidak diganti"
                                class="w-full px-3.5 py-2.5 pr-10 bg-white border @error('password') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 font-mono focus:outline-none focus:border-blue-600 transition shadow-sm">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 font-mono focus:outline-none focus:border-blue-600 transition shadow-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" @click="activeTab = 'info'" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-500/20 transition active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection