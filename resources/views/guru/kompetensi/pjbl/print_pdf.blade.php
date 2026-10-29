<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
        }

        /* Container Sertifikat Seukuran A4 Landscape */
        .certificate-page {
            position: relative;
            width: 297mm;
            height: 210mm;
            /* Mengambil gambar background dari template */
            background-image: url('{{ public_path("storage/" . $template->background_image) }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        /* Teks Nomor Surat */
        .nomor-surat {
            position: absolute;
            top: 130px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 13px;
            color: #475569;
        }

        /* Nama Siswa */
        .nama-siswa {
            position: absolute;
            top: 180px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
        }

        /* Deskripsi / Status */
        .keterangan {
            position: absolute;
            top: 235px;
            left: 15%;
            right: 15%;
            text-align: center;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Tabel Indikator Capaian Siswa */
        .table-container {
            position: absolute;
            top: 320px;
            left: 12%;
            right: 12%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 11px;
        }

        th {
            background-color: #f1f5f9;
            text-align: left;
            font-weight: bold;
        }

        .text-center { text-align: center; }
        .status-kompeten { color: #16a34a; font-weight: bold; }
        .status-belum { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>

    <div class="certificate-page">
        <!-- 1. Nomor Surat -->
        <div class="nomor-surat">
            No: {{ $nomorSurat }}
        </div>

        <!-- 2. Nama Siswa -->
        <div class="nama-siswa">
            {{ $evaluation->student->name }}
        </div>

        <!-- 3. Keterangan Proyek & Nilai Akhir -->
        <div class="keterangan">
            Telah menyelesaikan proyek <strong>{{ $evaluation->project->name ?? 'PjBL' }}</strong> 
            dengan Nilai Akhir <strong>{{ $evaluation->nilai_akhir }}</strong> 
            dan dinyatakan <strong>{{ strtoupper($evaluation->status_kompetensi) }}</strong>.
        </div>

        <!-- 4. Tabel Indikator Capaian Siswa -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th>Indikator Capaian Kompetensi</th>
                        <th style="width: 20%;" class="text-center">Status Capaian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluation->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->indikator }}</td>
                            <td class="text-center">
                                <span class="status-kompeten">✔ Terpenuhi</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>