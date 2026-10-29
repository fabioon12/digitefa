<div x-show="currentStep === 1" class="space-y-6">
    <div class="border-b border-slate-100 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[11px] font-extrabold uppercase tracking-wider mb-2">
            <i class="fa-solid fa-circle-info"></i> Tahap 1 dari 6
        </div>
        <h3 class="text-base font-black text-slate-800">Informasi Proyek</h3>
        <p class="text-xs text-slate-400 mt-0.5">Detail umum mengenai tema, latar belakang, dan anggota tim proyek TEFA Anda.</p>
    </div>

    <!-- Pilihan Tipe Pengerjaan -->
    <div class="space-y-2">
        <label class="text-xs font-bold text-slate-700 tracking-wide">Tipe Pengerjaan <span class="text-rose-500">*</span></label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all duration-300 group"
                :class="tipe === 'individu' ? 'border-blue-600 bg-blue-50/50 shadow-md shadow-blue-500/5' : 'border-slate-200 hover:border-slate-300 bg-white'">
                <input type="radio" name="tipe" value="individu" x-model="tipe" class="hidden">
                <div class="flex items-center gap-3.5 w-full">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                        :class="tipe === 'individu' ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-xs font-black text-slate-800 block">Individu (Mandiri)</span>
                        <span class="text-[10px] text-slate-400 block mt-0.5">Mengerjakan proyek mandiri</span>
                    </div>
                </div>
            </label>

            <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all duration-300 group"
                :class="tipe === 'kelompok' ? 'border-blue-600 bg-blue-50/50 shadow-md shadow-blue-500/5' : 'border-slate-200 hover:border-slate-300 bg-white'">
                <input type="radio" name="tipe" value="kelompok" x-model="tipe" class="hidden">
                <div class="flex items-center gap-3.5 w-full">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                        :class="tipe === 'kelompok' ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'">
                        <i class="fa-solid fa-users text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-xs font-black text-slate-800 block">Kelompok (Tim)</span>
                        <span class="text-[10px] text-slate-400 block mt-0.5">Mengerjakan bersama rekan tim</span>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <!-- KONDISIONAL: Anggota Kelompok (Menggunakan variabel $siswas dari controller) -->
    <div x-show="tipe === 'kelompok'" 
         x-transition:enter="transition ease-out duration-300"
         class="p-5 rounded-3xl border border-indigo-100 bg-gradient-to-b from-slate-50/80 to-indigo-50/30 space-y-4 shadow-inner" style="display: none;">
        
        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-xs shadow-md shadow-indigo-500/20">
                    <i class="fa-solid fa-user-group text-[11px]"></i>
                </div>
                <div>
                    <h4 class="text-xs font-black text-slate-800">Daftar Anggota Kelompok</h4>
                    <p class="text-[10px] text-slate-400">Tambahkan rekan siswa yang tergabung di dalam tim.</p>
                </div>
            </div>
            <button type="button" @click="members.push({ siswa_id: '', peran: '' })" 
                class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Anggota
            </button>
        </div>

        <!-- Container Utama Daftar Anggota Kelompok -->
        <div class="space-y-3">
            <template x-for="(member, index) in members" :key="index">
                <div class="bg-white p-4 rounded-2xl border transition-all space-y-3 shadow-sm relative"
                    :class="member.is_leader ? 'border-amber-400 bg-amber-50/20 shadow-md' : 'border-slate-200/80'">
                    
                    <!-- Header Kartu Anggota (Nomor, Label Leader, & Tombol Aksi) -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full text-[10px] font-black flex items-center justify-center"
                                :class="member.is_leader ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600'" 
                                x-text="index + 1"></span>
                            <span class="text-xs font-extrabold" :class="member.is_leader ? 'text-amber-700' : 'text-slate-700'" 
                                x-text="member.is_leader ? 'Ketua Kelompok (Leader)' : 'Anggota Tim ' + (index + 1)"></span>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Tombol Jadikan Leader -->
                            <button type="button" 
                                @click="members.forEach((m, i) => m.is_leader = (i === index))"
                                class="text-[11px] font-bold px-2.5 py-1 rounded-lg transition flex items-center gap-1"
                                :class="member.is_leader ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-600 hover:bg-amber-100'">
                                <i class="fa-solid fa-crown text-[10px]"></i> 
                                <span x-text="member.is_leader ? 'Leader Utama' : 'Jadikan Leader'"></span>
                            </button>

                            <!-- Input Hidden untuk mengirim status is_leader ke Controller Laravel -->
                            <input type="hidden" :name="'anggota['+index+'][is_leader]'" :value="member.is_leader ? 1 : 0">

                            <!-- Tombol Hapus Anggota (jika lebih dari 1) -->
                            <button type="button" @click="members.splice(index, 1)" x-show="members.length > 1" 
                                class="w-7 h-7 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center text-xs transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Input Data Siswa & Peran/Jobdesk -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                        
                        <!-- Kolom Kiri: Pilih Siswa (Searchable Select) -->
                        <div class="space-y-1.5" x-data="{ open: false, search: '' }">
                            <label class="text-[11px] font-bold text-slate-500 block">Pilih Siswa <span class="text-rose-500">*</span></label>
                            
                            <div class="relative">
                                <!-- Input Tersembunyi untuk ID Siswa -->
                                <input type="hidden" :name="'anggota['+index+'][siswa_id]'" x-model="member.siswa_id">

                                <!-- Kotak Pilihan -->
                                <div @click="open = !open" 
                                    class="w-full px-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 cursor-pointer flex items-center justify-between focus:outline-none focus:border-blue-500 transition min-h-[46px]">
                                    <span class="truncate pr-2" x-text="member.siswa_nama || '-- Cari & Pilih Siswa --'" :class="member.siswa_nama ? 'text-slate-800 font-bold' : 'text-slate-400'"></span>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''"></i>
                                </div>

                                <!-- Dropdown Panel Pencarian -->
                                <div x-show="open" 
                                    @click.away="open = false"
                                    class="absolute z-30 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden p-2 space-y-2" 
                                    style="display: none;">
                                    
                                    <div class="relative">
                                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                        <input type="text" x-model="search" placeholder="Ketik nama siswa..." 
                                            class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                                    </div>

                                    <div class="max-h-48 overflow-y-auto space-y-1">
                                        @foreach($siswas as $siswa)
                                            <div x-show="search === '' || '{{ strtolower($siswa->name) }}'.includes(search.toLowerCase())"
                                                @click="
                                                    member.siswa_id = '{{ $siswa->id }}';
                                                    member.siswa_nama = '{{ $siswa->name }} ({{ $siswa->major ?? '-' }})';
                                                    open = false;
                                                    search = '';
                                                "
                                                class="px-3 py-2 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl cursor-pointer transition flex items-center justify-between">
                                                <span class="font-medium">{{ $siswa->name }}</span>
                                                <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $siswa->major ?? '-' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Peran / Jobdesk (Tanpa required HTML agar tidak error is not focusable) -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-slate-500 block">Peran / Jobdesk <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="text" :name="'anggota['+index+'][peran]'" x-model="member.peran" placeholder="Cth: Frontend Developer"
                                    class="w-full px-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-500 transition min-h-[46px]">
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Judul Proyek -->
    <div class="space-y-1.5">
        <label class="text-xs font-bold text-slate-700 tracking-wide">Judul Proyek <span class="text-rose-500">*</span></label>
        <input type="text" name="judul" x-model="judul" required placeholder="Contoh: Sistem Smart Garden Berbasis IoT"
            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 transition shadow-sm">
    </div>

    <!-- Deskripsi Proyek -->
    <div class="space-y-1.5">
        <label class="text-xs font-bold text-slate-700 tracking-wide">Deskripsi Proyek <span class="text-rose-500">*</span></label>
        <textarea name="deskripsi" x-model="deskripsi" rows="4" required placeholder="Jelaskan latar belakang dan tujuan proyek..."
            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 transition shadow-sm resize-none"></textarea>
    </div>
</div>