@extends('admin.layouts.app')

@section('title', 'Buat Template Sertifikat Baru - CertiLearn')

@section('content')
<div class="p-6 space-y-6 max-w-5xl mx-auto">

    <!-- Header Navigation -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.certificate-templates.index') }}" 
           class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Buat Template Sertifikat</h1>
            <p class="text-sm text-slate-500">Tambahkan template sertifikat baru beserta indikator kompetensinya.</p>
        </div>
    </div>

    <!-- Alert Error Flash Message -->
    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Form Main Container -->
    <form action="{{ route('admin.certificate-templates.store') }}" method="POST" enctype="multipart/form-data" 
          x-data="templateForm()" class="space-y-6">
        @csrf

        <!-- Card 1: Informasi Utama Template -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-blue-600"></i>
                Informasi Utama Template
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Judul Template -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Template Sertifikat <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           placeholder="Contoh: Sertifikat Kompetensi Web Development PjBL"
                           class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Format Nomor Surat -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Format Nomor Surat</label>
                    <input type="text" name="nomor_surat_format" value="{{ old('nomor_surat_format') }}"
                           placeholder="Contoh: SK/PjBL/{YEAR}/{ID}"
                           class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan tag <code class="bg-slate-100 px-1 rounded">{YEAR}</code> atau <code class="bg-slate-100 px-1 rounded">{ID}</code> jika diperlukan.</p>
                </div>

                <!-- Background Image Sertifikat -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Frame/Background (Gambar)</label>
                    <input type="file" name="background_image" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-200 rounded-xl">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG. Maksimal 10MB.</p>
                    @error('background_image')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi / Catatan</label>
                    <textarea name="description" rows="2" 
                              placeholder="Deskripsi penggunaan template ini..."
                              class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">{{ old('description') }}</textarea>
                </div>

                <!-- Checkbox Status Aktif -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan Template Ini Langsung</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Card 2: Indikator Capaian Kompetensi (Dynamic) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-blue-600"></i>
                        Indikator Capaian Kompetensi
                    </h2>
                    <p class="text-xs text-slate-400">Daftar indikator standar yang akan dimunculkan pada form penilaian guru.</p>
                </div>
                <button type="button" @click="addIndicator()" 
                        class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-semibold rounded-lg transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Tambah Indikator</span>
                </button>
            </div>

            @error('indicators')
                <p class="text-rose-500 text-xs font-medium">{{ $message }}</p>
            @enderror

            <!-- List Dynamic Input Indikator -->
            <div class="space-y-3">
                <template x-for="(indicator, index) in indicators" :key="index">
                    <div class="flex items-center gap-2">
                        <span class="w-6 text-center text-xs font-bold text-slate-400" x-text="index + 1 + '.'"></span>
                        
                        <input type="text" :name="'indicators[' + index + ']'" x-model="indicators[index]"
                               placeholder="Contoh: Mampu mengimplementasikan REST API" required
                               class="flex-1 px-3.5 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        
                        <button type="button" @click="removeIndicator(index)" 
                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                title="Hapus Indikator" :disabled="indicators.length <= 1" :class="{'opacity-30 cursor-not-allowed': indicators.length <= 1}">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.certificate-templates.index') }}" 
               class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow transition">
                Simpan Template
            </button>
        </div>
    </form>

</div>

<script>
    function templateForm() {
        return {
            indicators: @json(array_values(old('indicators', ['']))),
            
            addIndicator() {
                this.indicators.push('');
            },
            
            removeIndicator(index) {
                if (this.indicators.length > 1) {
                    this.indicators.splice(index, 1);
                }
            }
        }
    }
</script>
@endsection