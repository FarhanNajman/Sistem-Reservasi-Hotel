<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hunian Bulanan - N★JM Hotel</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            border-bottom: 2px solid #d4af37;
            padding-bottom: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .header h1 {
            color: #1e1e2d;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #1e1e2d;
            text-transform: uppercase;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th {
            background-color: #1e1e2d;
            color: #fff;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #333;
        }
        .table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .total-row {
            font-weight: bold;
            background-color: #f1f5f9 !important;
        }
        .total-row td {
            border-top: 2px solid #1e1e2d;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>N★JM Hotel</h1>
            <p>Jl. Kapalo Koto, Pauh, Padang</p>
            <p>Telp: (0751) 123456 | Email: info@najmhotel.com</p>
        </div>

        <div class="title">
            Laporan Tingkat Hunian Bulanan
        </div>

        <p style="margin-bottom: 20px;">
            <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}<br>
            <strong>Dicetak Oleh:</strong> {{ Auth::user()->username }}
        </p>

        <!-- Tabel Data -->
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">No.</th>
                    <th style="width: 60%;">Bulan</th>
                    <th style="width: 30%; text-align: center;">Total Kamar Terpesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanData as $index => $data)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $data['bulan'] }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $data['total'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px;">Belum ada data hunian yang valid.</td>
                    </tr>
                @endforelse

                @if(count($laporanData) > 0)
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right; padding-right: 20px;">TOTAL KESELURUHAN KAMAR TERPESAN</td>
                        <td style="text-align: center; color: #1e1e2d;">{{ $totalSemua }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh sistem reservasi N★JM Hotel.</p>
        </div>
    </div>
</body>
</html>
