@extends('siswa.layouts.app')

@section('title', 'Pengajuan Proyek Baru - CertiLearn')

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-6" x-data="projectForm()">
    
    <!-- Header Halaman -->
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 rounded-3xl p-8 lg:p-10 text-white shadow-2xl overflow-hidden border border-slate-800/80">
        <!-- Efek Glow Dekoratif di Background -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-8">
            
            <!-- Sisi Kiri: Breadcrumb, Judul, & Deskripsi -->
            <div class="space-y-3 max-w-xl">
                <nav class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/10 backdrop-blur-xl border border-white/15 rounded-full text-xs font-semibold tracking-wide text-blue-200 shadow-inner">
                    <span>Proyek TEFA</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-blue-400"></i>
                    <span>Pengajuan Proyek</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-blue-400"></i>
                    <span class="text-white font-bold">Baru</span>
                </nav>

                <h1 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight text-white">
                    Pengajuan Proyek Baru 
                    <span class="inline-block animate-bounce ml-1">🚀</span>
                </h1>

                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Lengkapi formulir bertahap di bawah ini untuk mewujudkan ide, inovasi, dan karya produk TEFA Anda menjadi nyata.
                </p>
            </div>

            <!-- Sisi Kanan: Ilustrasi Ikon Modern yang Mendukung -->
            <div class="hidden xl:flex items-end gap-3.5 shrink-0 select-none">
                
                <!-- Kartu Mini Ikon 1 (Dokumen Proposal) -->
                <div class="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-xl flex flex-col items-center text-center space-y-1.5 -translate-y-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/30 text-blue-300 flex items-center justify-center text-base shadow-inner">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-200 tracking-wider">Proposal</span>
                </div>

                <!-- Kartu Mini Ikon 2 (Bola Lampu / Ide Kreatif) -->
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-xl flex flex-col items-center text-center space-y-1.5">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/30 text-amber-300 flex items-center justify-center text-xl shadow-inner">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-200 tracking-wider">Inovasi</span>
                </div>

                <!-- Badge Identitas Form di Ujung Kanan -->
                <div class="text-right pb-2 pl-3 border-l border-white/10">
                    <span class="px-3 py-1 bg-blue-600 text-white rounded-xl text-[10px] font-black tracking-widest shadow-lg uppercase inline-block">WIZARD</span>
                    <span class="text-[10px] text-slate-400 block mt-1.5 font-medium">Multi-Step Form</span>
                </div>

            </div>

        </div>
        
        <!-- Garis Aksen Bawah -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-transparent"></div>
    </div>

    <!-- Layout Utama: Kiri (Step Indicator), Kanan (Form & Tips) -->
    <form action="{{route('siswa.tefa.store')}}" @submit.prevent="submitForm" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        @csrf

        <!-- SISI KIRI: Indikator Tahapan (Steps 1 - 6) -->
        <div class="lg:col-span-1 bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-2 h-fit">
            <template x-for="step in 6" :key="step">
                <button type="button" 
                    @click="if (step <= maxStepReached) currentStep = step"
                    :disabled="step > maxStepReached"
                    class="w-full flex items-center justify-between p-3 rounded-2xl transition-all text-left"
                    :class="{
                        'bg-blue-50 text-blue-600 font-bold border border-blue-100': currentStep === step,
                        'text-slate-500 hover:bg-slate-50': currentStep !== step && step <= maxStepReached,
                        'opacity-50 cursor-not-allowed text-slate-300 bg-slate-50/50': step > maxStepReached
                    }">
                    
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-bold"
                            :class="currentStep === step ? 'bg-blue-600 text-white shadow-md' : (step <= maxStepReached ? 'bg-slate-100 text-slate-600' : 'bg-slate-100 text-slate-300')">
                            <span x-text="step"></span>
                        </div>
                        <div class="text-xs">
                            <p class="font-bold" x-text="getStepTitle(step)"></p>
                            <p class="text-[10px] font-normal" :class="step <= maxStepReached ? 'text-slate-400' : 'text-slate-300'" x-text="getStepDesc(step)"></p>
                        </div>
                    </div>

                    <!-- Icon Gembok Jika Terkunci -->
                    <div x-show="step > maxStepReached" class="text-slate-300 text-xs pr-1">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </button>
            </template>
        </div>

        <!-- SISI KANAN: Konten Form per Tahap & Tips Samping -->
        <div class="lg:col-span-3 grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- Bagian Form Utama (2 Kolom) -->
            <div class="xl:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                
                <!-- STEP 1: Informasi Proyek (Tipe, Judul, Deskripsi) -->
                @include('siswa.tefa.step-create.step1')

                <!-- STEP 2: Mata Pelajaran / Kompetensi Utama -->
                @include('siswa.tefa.step-create.step2')

                <!-- STEP 3: Tim Pembimbing -->
                @include('siswa.tefa.step-create.step3')

                <!-- STEP 4: Timeline -->
                @include('siswa.tefa.step-create.step4')

                <!-- STEP 5: Dokumen Proposal -->
                @include('siswa.tefa.step-create.step5')

                <!-- STEP 6: Review -->
                @include('siswa.tefa.step-create.step6')

                <!-- Tombol Navigasi Step (Sebelumnya / Selanjutnya) -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <button type="button" @click="if(currentStep > 1) currentStep--" x-show="currentStep > 1"
                        class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold transition hover:bg-slate-200">
                        Sebelumnya
                    </button>
                    <div></div>
                    
                    <!-- Ganti dengan memanggil fungsi nextStep() -->
                    <button type="button" 
                        @click="nextStep()" 
                        x-show="currentStep < 6"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition">
                        Selanjutnya
                    </button>

                    <button type="submit" x-show="currentStep === 6" style="display: none;"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-500/20 transition">
                        Kirim Pengajuan Proyek
                    </button>
                </div>

            </div>

            <!-- SISI KANAN: Tips Pengajuan -->
            <div class="space-y-6">
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                    <h4 class="text-xs font-black text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i> Tips Pengajuan Proyek
                    </h4>
                    <ul class="text-[11px] text-slate-500 space-y-2">
                        <li>✓ Gunakan judul yang jelas dan spesifik</li>
                        <li>✓ Jelaskan latar belakang dan tujuan proyek</li>
                        <li>✓ Lampirkan proposal atau dokumen pendukung</li>
                    </ul>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Script Alpine.js untuk Pengaturan Step -->

<script>
    function projectForm() {
        return {
            currentStep: 1,
            maxStepReached: 1,
            tipe: 'individu',
            kategori: '',
            judul: '',
            deskripsi: '',
            tanggal_mulai: '',
            tanggal_selesai: '',
            proposalName: 'Belum diunggah',
            pembimbingUtamaText: 'Belum dipilih',
            pembimbingPendampingText: 'Tidak ada',
            members: [
                { siswa_id: '', siswa_nama: '', peran: '', is_leader: true }
            ],
            nextStep() {
                // Validasi Step 1: Informasi Proyek
                if (this.currentStep === 1) {
                    if (!this.judul.trim() || !this.deskripsi.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Harap isi Judul dan Deskripsi Proyek terlebih dahulu!',
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }
                    // Jika tipe kelompok, validasi anggota
                    if (this.tipe === 'kelompok') {
                        for (let i = 0; i < this.members.length; i++) {
                            if (!this.members[i].siswa_id || !this.members[i].peran.trim()) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Anggota Belum Lengkap',
                                    text: `Harap lengkapi Siswa dan Peran pada Anggota ke-${i + 1}!`,
                                    confirmButtonColor: '#2563eb'
                                });
                                return;
                            }
                        }
                    }
                }

                if (this.currentStep === 2) {
                    if (!this.kategori.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Harap isi Mata Pelajaran / Kompetensi Utama!',
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }
                }

                if (this.currentStep === 3) {
                    const pembimbingUtamaInput = document.querySelector('input[name="pembimbing_utama[]"]');
                    if (!pembimbingUtamaInput || !pembimbingUtamaInput.value) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pembimbing Belum Dipilih',
                            text: 'Harap pilih Pembimbing Utama / Produktif terlebih dahulu!',
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }
                }
                if (this.currentStep === 4) {
                    if (!this.tanggal_mulai || !this.tanggal_selesai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Jadwal Belum Lengkap',
                            text: 'Harap isi Tanggal Mulai dan Tanggal Selesai (Deadline) proyek!',
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }
                    if (this.tanggal_selesai < this.tanggal_mulai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal Tidak Valid',
                            text: 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai!',
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }
                }

                // Validasi Step 5: Dokumen Proposal
                if (this.currentStep === 5) {
                    const proposalInput = document.querySelector('input[name="proposal"]');
                    if (!proposalInput || !proposalInput.files.length) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Proposal Belum Diunggah',
                            text: 'Harap unggah dokumen proposal berformat PDF terlebih dahulu!',
                            confirmButtonColor: '#2563eb'
                        });
                        return;
                    }
                }

                // Jika lolos validasi, pindah ke step berikutnya
                if (this.currentStep < 6) {
                    this.currentStep++;
                    this.maxStepReached = Math.max(this.maxStepReached, this.currentStep);
                }
            },
            submitForm(event) {
                let form = event.target;
                let formData = new FormData(form);

                Swal.fire({
                    title: 'Sedang Mengirim...',
                    text: 'Mohon tunggu sebentar, data dan proposal sedang diproses.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 201 && res.body.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.body.message || 'Proyek berhasil diajukan!',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#2563eb',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = res.body.redirect;
                        });
                    } else {
                        let errorMsg = res.body.message || 'Terjadi kesalahan saat menyimpan data.';
                        if (res.body.errors) {
                            errorMsg = Object.values(res.body.errors)[0][0];
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Pengajuan!',
                            text: errorMsg,
                            confirmButtonColor: '#2563eb'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan pada jaringan atau server.',
                        confirmButtonColor: '#2563eb'
                    });
                    console.error('Error:', error);
                });
            },
            updateMemberName(index, event) {
                const selectedOption = event.target.selectedOptions[0];
                this.members[index].siswa_nama = selectedOption ? selectedOption.text : '';
            },
            updatePembimbingUtamaCustom(text) {
                this.pembimbingUtamaText = text;
            },
            updatePembimbingPendampingCustom(text) {
                this.pembimbingPendampingText = text;
            },

            // Fungsi pendukung lainnya...
            updateProposalName(event) {
                const file = event.target.files[0];
                this.proposalName = file ? file.name : 'Belum diunggah';
            },

            getStepTitle(step) {
                const titles = ['Informasi Proyek', 'Mata Pelajaran', 'Tim Pembimbing', 'Timeline', 'Dokumen', 'Review'];
                return titles[step - 1];
            },
            getStepDesc(step) {
                const descs = ['Detail umum', 'Kompetensi utama', 'Guru & mentor', 'Jadwal', 'Proposal', 'Periksa data'];
                return descs[step - 1];
            }
        }
    }
</script>

@endsection