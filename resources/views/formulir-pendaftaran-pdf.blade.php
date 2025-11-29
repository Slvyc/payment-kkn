<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Formulir Pendaftaran KKN - {{ $mahasiswa->nama }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Unaya.png') }}">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #000;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .info-table td {
            padding: 6px;
            font-size: 13px;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .section-title {
            margin-top: 25px;
            font-size: 16px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .signature {
            width: 100%;
            margin-top: 50px;
            text-align: left;
        }

        .signature td {
            padding-top: 40px;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="title">Formulir Pendaftaran Kuliah Kerja Nyata (KKN)</div>

        {{-- Informasi Mahasiswa --}}
        <div class="section-title">Data Mahasiswa</div>
        <table class="info-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td>{{ session('mahasiswa_data.prodi.nama_prodi') }}</td>
            </tr>
            <tr>
                <td class="label">Nomor HP</td>
                <td>{{ $mahasiswa->no_hp }}</td>
            </tr>
        </table>

        {{-- Informasi Pendaftaran KKN --}}
        <div class="section-title">Data Pendaftaran KKN</div>
        <table class="info-table">
            <tr>
                <td class="label">Jenis KKN</td>
                <td>{{ $payment->jenis_kkn }}</td>
            </tr>
            <tr>
                <td class="label">Order ID</td>
                <td>{{ $payment->order_id }}</td>
            </tr>
            <tr>
                <td class="label">Waktu Pembayaran</td>
                <td>{{ $payment->updated_at->format('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Status Pembayaran</td>
                <td>{{ strtoupper($payment->status) }}</td>
            </tr>
            <tr>
                <td class="label">Biaya Dibayar</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </table>

        {{-- Pernyataan --}}
        <div class="section-title">Pernyataan Mahasiswa</div>
        <p style="margin-top: 10px; line-height: 1.6;">
            Saya yang bertanda tangan di bawah ini menyatakan bahwa data yang saya isi pada formulir pendaftaran KKN
            adalah benar dan dapat dipertanggungjawabkan. Saya bersedia mengikuti seluruh rangkaian kegiatan KKN
            sesuai ketentuan yang berlaku di Universitas Abulyatama.
        </p>

        {{-- Tanda tangan --}}
        <table class="signature">
            <tr>
                <td>
                    Aceh Besar, {{ date('d F Y') }}<br><br>
                    Mahasiswa,<br><br><br><br>
                    ________________________<br>
                    {{ $mahasiswa->nama }}
                </td>
                <td style="width: 30%;"></td>
            </tr>
        </table>

    </div>
</body>

</html>