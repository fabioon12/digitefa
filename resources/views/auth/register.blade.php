<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - CertiLearn</title>
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
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 text-white p-2.5 rounded-xl shadow-md flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-blue-600 tracking-tight leading-tight">CertiLearn</h2>
                        <p class="text-xs text-slate-500 font-medium">Sertifikasi Kompetensi</p>
                    </div>
                </div>

                <div class="my-8 z-10">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                        Bergabung Sekarang, <br>
                        <span class="text-blue-600">Raih Sertifikasimu.</span>
                    </h1>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-md">
                        Daftarkan diri Anda untuk mulai mencatat portofolio pembelajaran PjBL, TEFA, dan klaim sertifikat kompetensi resmi Anda.
                    </p>
                </div>

                <div class="relative flex justify-center items-end pt-2">
                    <div class="w-64 h-48 bg-white/80 backdrop-blur border border-blue-100 rounded-2xl shadow-lg p-5 relative flex flex-col justify-between">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                            <div>
                                <div class="h-3 bg-slate-200 rounded-full w-24 mb-1"></div>
                                <div class="h-2 bg-blue-200 rounded-full w-16"></div>
                            </div>
                        </div>
                        <div class="space-y-2 my-2">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                                <div class="h-2 bg-slate-100 rounded-full w-3/4"></div>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                                <div class="h-2 bg-slate-100 rounded-full w-1/2"></div>
                            </div>
                        </div>
                        <div class="w-full py-1.5 bg-blue-600 rounded-lg flex items-center justify-center text-white text-[10px] font-semibold">
                            Akun Terverifikasi
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

            <!-- SISI KANAN: Form Register -->
            <div class="p-8 sm:p-12 flex flex-col justify-center bg-white" 
                x-data="{ 
                    role: '{{ old('role', 'siswa') }}', 
                    gender: '{{ old('gender', 'L') }}',
                    showPassword: false, 
                    showConfirmPassword: false,
                    photoPreview: null,
                    isDragging: false,
                    switchRole(newRole) {
                        this.role = newRole;
                        if(newRole === 'siswa') {
                            if (this.$refs.nip) this.$refs.nip.value = '';
                            if (this.$refs.company_name) this.$refs.company_name.value = '';
                            if (this.$refs.sector) this.$refs.sector.value = '';
                            if (this.$refs.position) this.$refs.position.value = '';
                        } else if(newRole === 'guru') {
                            if (this.$refs.nisn) this.$refs.nisn.value = '';
                            if (this.$refs.class) this.$refs.class.value = '';
                            if (this.$refs.major) this.$refs.major.value = '';
                            if (this.$refs.company_name) this.$refs.company_name.value = '';
                            if (this.$refs.sector) this.$refs.sector.value = '';
                            if (this.$refs.position) this.$refs.position.value = '';
                        } else if(newRole === 'industri') {
                            if (this.$refs.nisn) this.$refs.nisn.value = '';
                            if (this.$refs.class) this.$refs.class.value = '';
                            if (this.$refs.major) this.$refs.major.value = '';
                            if (this.$refs.nip) this.$refs.nip.value = '';
                        }
                    },
                    handleFileSelect(file) {
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => { this.photoPreview = e.target.result; };
                            reader.readAsDataURL(file);
                        }
                    },
                    previewImage(event) {
                        this.handleFileSelect(event.target.files[0]);
                    },
                    handleDrop(event) {
                        this.isDragging = false;
                        const file = event.dataTransfer.files[0];
                        if (file) {
                            this.$refs.fileInput.files = event.dataTransfer.files;
                            this.handleFileSelect(file);
                        }
                    }
                }">
                
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Buat Akun Baru</h2>
                    <p class="text-xs text-slate-400 mt-1">Pilih status pendaftaran dan isi data Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- A. ROLE -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Daftar Sebagai</label>
                        <div class="grid grid-cols-3 gap-1.5 p-1.5 bg-slate-100 rounded-2xl">
                            <button type="button" @click="switchRole('siswa')"
                                :class="role === 'siswa' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                class="py-2.5 text-[11px] font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-user-graduate"></i> Siswa
                            </button>
                            <button type="button" @click="switchRole('guru')"
                                :class="role === 'guru' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                class="py-2.5 text-[11px] font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-chalkboard-user"></i> Guru
                            </button>
                            <button type="button" @click="switchRole('industri')"
                                :class="role === 'industri' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                                class="py-2.5 text-[11px] font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-building"></i> Industri
                            </button>
                        </div>
                        <input type="hidden" name="role" :value="role">
                        @error('role')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- B. FOTO PROFIL -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <div class="relative w-16 h-16 rounded-full bg-slate-100 border-2 border-dashed transition flex items-center justify-center overflow-hidden flex-shrink-0 group"
                                :class="isDragging ? 'border-blue-600 bg-blue-50' : 'border-slate-300'"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover rounded-full">
                                </template>
                                <template x-if="!photoPreview">
                                    <i class="fa-solid fa-camera text-slate-400 text-xl group-hover:text-blue-600 transition"></i>
                                </template>
                            </div>

                            <div class="flex-grow">
                                <input type="file" name="image" id="image" x-ref="fileInput" accept="image/jpeg,image/png,image/webp" @change="previewImage" class="hidden">
                                <label for="image" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl cursor-pointer transition">
                                    <i class="fa-solid fa-upload"></i>
                                    <span x-text="photoPreview ? 'Ganti Foto' : 'Pilih Foto Profil'"></span>
                                </label>
                                <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- C. NAMA LENGKAP -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-id-card text-sm"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('name') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- D. JENIS KELAMIN -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="gender = 'L'"
                                :class="gender === 'L' ? 'bg-blue-50 border-blue-600 text-blue-600 font-bold' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100'"
                                class="py-2.5 px-4 text-xs rounded-xl border transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-mars text-sm"></i> Laki-laki
                            </button>
                            <button type="button" @click="gender = 'P'"
                                :class="gender === 'P' ? 'bg-blue-50 border-blue-600 text-blue-600 font-bold' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100'"
                                class="py-2.5 px-4 text-xs rounded-xl border transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-venus text-sm"></i> Perempuan
                            </button>
                        </div>
                        <input type="hidden" name="gender" :value="gender">
                        @error('gender')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- E. USERNAME -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-user text-sm"></i>
                            </span>
                            <input type="text" name="username" value="{{ old('username') }}" required autocomplete="username"
                                placeholder="Masukkan username"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('username') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                        </div>
                        @error('username')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- F. EMAIL -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="Masukkan alamat email"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('email') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- FIELD KHUSUS SISWA -->
                    <div x-show="role === 'siswa'" x-transition class="space-y-4" x-data="{ selectedMajor: '{{ old('major') }}' }">
                        <!-- NISN -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">NISN</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-hashtag text-sm"></i>
                                </span>
                                <input type="text" inputmode="numeric" name="nisn" x-ref="nisn" value="{{ old('nisn') }}" :required="role === 'siswa'"
                                    placeholder="Masukkan NISN"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('nisn') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            </div>
                            @error('nisn')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelas & Jurusan (Grid 2 Kolom) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Kelas Dropdown -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kelas</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                        <i class="fa-solid fa-school text-sm"></i>
                                    </span>
                                    <select name="class" x-ref="class" :required="role === 'siswa'"
                                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('class') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                                        <option value="" disabled {{ old('class') ? '' : 'selected' }}>Pilih Kelas</option>
                                        <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>X</option>
                                        <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>XI</option>
                                        <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>XII</option>
                                    </select>
                                </div>
                                @error('class')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jurusan Dropdown -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jurusan</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                        <i class="fa-solid fa-book-open text-sm"></i>
                                    </span>
                                    <select name="major" x-ref="major" x-model="selectedMajor" :required="role === 'siswa'"
                                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('major') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                                        <option value="" disabled {{ old('major') ? '' : 'selected' }}>Program Keahlian</option>
                                        <option value="Teknik Grafika">Teknik Grafika</option>
                                        <option value="Desain Komunikasi Visual (DKV) / Multimedia">Desain Komunikasi Visual (DKV) / Multimedia</option>
                                        <option value="Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)">Perancangan Perangkat Lunak dan Gim (PPLG) / Rekayasa Perangkat Lunak (RPL)</option>
                                        <option value="Teknik Komputer dan Jaringan (TKJ)">Teknik Komputer dan Jaringan (TKJ)</option>
                                        <option value="Animasi">Animasi</option>
                                        <option value="Teknik Mekatronika">Teknik Mekatronika</option>
                                        <option value="Teknik Logistik / Logistik">Teknik Logistik / Logistik</option>
                                        <option value="Perhotelan">Perhotelan</option>
                                    </select>
                                </div>
                                @error('major')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Offering Dropdown -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Offering 
                                <span x-show="!selectedMajor" class="text-[10px] font-normal text-slate-400">(Pilih jurusan terlebih dahulu)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-layer-group text-sm"></i>
                                </span>
                                <select name="offering" x-ref="offering" :required="role === 'siswa'" :disabled="!selectedMajor"
                                    :class="!selectedMajor ? 'bg-slate-100 cursor-not-allowed opacity-60' : 'bg-slate-50'"
                                    class="w-full pl-10 pr-4 py-2.5 border @error('offering') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                                    <option value="" disabled {{ old('offering') ? '' : 'selected' }}>
                                        <span x-text="selectedMajor ? 'Pilih Offering' : 'Kunci - Pilih Jurusan Dahulu'"></span>
                                    </option>
                                    <option value="A" {{ old('offering') == 'A' ? 'selected' : '' }}>Offering A</option>
                                    <option value="B" {{ old('offering') == 'B' ? 'selected' : '' }}>Offering B</option>
                                    <option value="C" {{ old('offering') == 'C' ? 'selected' : '' }}>Offering C</option>
                                    <option value="D" {{ old('offering') == 'D' ? 'selected' : '' }}>Offering D</option>
                                    <option value="E" {{ old('offering') == 'E' ? 'selected' : '' }}>Offering E</option>
                                    <option value="F" {{ old('offering') == 'F' ? 'selected' : '' }}>Offering F</option>
                                </select>
                            </div>
                            @error('offering')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- FIELD KHUSUS GURU -->
                    <div x-show="role === 'guru'" x-transition class="space-y-4">
                        <!-- NIP -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">NIP</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-id-badge text-sm"></i>
                                </span>
                                <input type="text" inputmode="numeric" name="nip" x-ref="nip" value="{{ old('nip') }}" :required="role === 'guru'"
                                    placeholder="Masukkan NIP Guru"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('nip') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            </div>
                            @error('nip')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mata Pelajaran -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Mata Pelajaran</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-book text-sm"></i>
                                </span>
                                <input type="text" name="subject" value="{{ old('subject') }}" x-ref="subject" :required="role === 'guru'"
                                    placeholder="Contoh: Pemrograman Web"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('subject') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            </div>
                            @error('subject')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- FIELD KHUSUS INDUSTRI -->
                    <div x-show="role === 'industri'" x-transition class="space-y-4">
                        <!-- NAMA PERUSAHAAN -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Perusahaan / Instansi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-building text-sm"></i>
                                </span>
                                <input type="text" name="company_name" x-ref="company_name" value="{{ old('company_name') }}" :required="role === 'industri'"
                                    placeholder="Contoh: PT. Teknologi Bangsaku"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('company_name') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            </div>
                            @error('company_name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- BIDANG SEKTOR -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Bidang Sektor</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-briefcase text-sm"></i>
                                </span>
                                <input type="text" name="sector" x-ref="sector" value="{{ old('sector') }}" :required="role === 'industri'"
                                    placeholder="Contoh: Teknologi Informasi / Manufaktur / Otomotif"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('sector') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            </div>
                            @error('sector')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- JABATAN / POSISI -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Jabatan / Posisi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="fa-solid fa-user-tie text-sm"></i>
                                </span>
                                <input type="text" name="position" x-ref="position" value="{{ old('position') }}" :required="role === 'industri'"
                                    placeholder="Contoh: HRD / Assessor"
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('position') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            </div>
                            @error('position')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- I. PASSWORD -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                placeholder="Buat password"
                                class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border @error('password') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                <i class="fa-regular" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- J. KONFIRMASI PASSWORD -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-shield-halved text-sm"></i>
                            </span>
                            <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi password"
                                class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                <i class="fa-regular" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- TOMBOL REGISTER -->
                    <button type="submit" class="w-full mt-2 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-md transition duration-200">
                        Daftar Akun
                    </button>
                </form>

                <p class="text-center text-xs text-slate-500 mt-6">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:underline">Masuk di sini</a>
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