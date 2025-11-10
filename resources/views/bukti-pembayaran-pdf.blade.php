<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran - {{ $payment->order_id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 13px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            /* Ganti dengan path logo Anda jika sudah di-hosting */
            /* background-color: #eee; */
            /* Hapus jika pakai img */
        }

        .company-details {
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .company-details h2 {
            margin: 0;
            font-size: 24px;
            color: #000;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .details-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .details-table td {
            padding: 8px;
            vertical-align: top;
            font-size: 14px;
        }

        .details-table .label {
            font-weight: bold;
            width: 30%;
            color: #555;
        }

        .details-table .value {
            width: 70%;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        .total-section {
            margin-top: 20px;
            width: 100%;
            text-align: right;
        }

        .total-table {
            float: right;
            width: 40%;
        }

        .total-table td {
            padding: 8px;
            font-size: 14px;
        }

        .total-table .total-label {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        .total-table .total-amount {
            font-weight: bold;
            font-size: 18px;
            color: #000;
        }

        .status-paid {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            border: 3px solid #28a745;
            padding: 15px;
            display: inline-block;
            transform: rotate(-5deg);
            opacity: 0.7;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">

        <table class="header-table">
            <tr>
                <td style="width: 20%; vertical-align: top;">
                    {{-- Ganti dengan tag img jika logo Anda ada URL-nya --}}
                    {{-- <img src="https://path.to/logo.png" alt="Logo" class="logo"> --}}

                </td>
                <td style="width: 80%; vertical-align: top;" class="company-details">
                    <h2>Panitia KKN</h2>
                    <p>Universitas [Nama Universitas Anda]</p>
                    <p>Jalan [Alamat Kampus Anda]</p>
                    <p>Email: kkn@univ.ac.id | Web: univ.ac.id</p>
                </td>
            </tr>
        </table>

        <div class="title">Bukti Pembayaran Lunas</div>

        <table class="details-table">
            <tr>
                <td class="label">Diterbitkan untuk:</td>
                <td class="value">
                    <strong>{{ $payment->mahasiswa->nama }}</strong><br>
                    NIM: {{ $payment->mahasiswa->nim }}
                </td>
            </tr>
            <tr>
                <td class="label">Tanggal Pembayaran:</td>
                <td class="value">{{ $payment->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Order ID:</td>
                <td class="value">{{ $payment->order_id }}</td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pendaftaran {{ $payment->jenis_kkn }}</td>
                    <td>1</td>
                    <td style="text-align: right;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="total-section">
            <tr>
                <td style="width: 60%;">
                    @if($payment->status == 'success')
                        <div class="status-paid">LUNAS</div>
                    @endif
                </td>
                <td style="width: 40%;">
                    <table class="total-table">
                        <tr>
                            <td class="total-label">Subtotal</td>
                            <td style="text-align: right;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="total-label">Total Dibayar</td>
                            <td class="total-amount" style="text-align: right;">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            Ini adalah bukti pembayaran yang sah dan diterbitkan oleh sistem secara otomatis.
            <br>
            &copy; {{ date('Y') }} Panitia KKN Universitas [Nama Universitas Anda].
        </div>
    </div>
</body>

</html>