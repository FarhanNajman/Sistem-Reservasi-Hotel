<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $reservation->kode_booking }}</title>
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
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header table {
            width: 100%;
        }
        .header h1 {
            color: #3b82f6;
            margin: 0;
            font-size: 28px;
        }
        .status-lunas {
            color: #166534;
            font-weight: bold;
            font-size: 18px;
        }
        .section-title {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .details-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-table td {
            vertical-align: top;
            width: 50%;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f1f5f9;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #cbd5e1;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            font-size: 16px;
            padding-top: 20px;
            border-bottom: none;
        }
        .total-price {
            color: #3b82f6;
            font-size: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <table>
                <tr>
                    <td>
                        <h1>INVOICE</h1>
                        <p style="margin: 5px 0 0 0; color: #555;">#{{ $reservation->kode_booking }}</p>
                    </td>
                    <td style="text-align: right;">
                        <p style="margin: 0; font-weight: bold;">N★JM Hotel</p>
                        <p style="margin: 0; color: #666;">Jl. Kapalo Koto, Pauh, Padang</p>
                        <br>
                        <p style="margin: 0; font-size: 12px; color: #666;">Status Pembayaran:</p>
                        <div class="status-lunas">LUNAS</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Details -->
        <table class="details-table">
            <tr>
                <td>
                    <div class="section-title">Ditagihkan Kepada:</div>
                    <div style="font-weight: bold; font-size: 16px;">{{ $reservation->nama_tamu }}</div>
                    <div>{{ $reservation->email_tamu }}</div>
                    <div>{{ $reservation->telepon_tamu }}</div>
                </td>
                <td>
                    <div class="section-title">Detail Waktu:</div>
                    <table style="width: 100%;">
                        <tr>
                            <td style="color: #666;">Check-in:</td>
                            <td style="text-align: right; font-weight: bold;">{{ \Carbon\Carbon::parse($reservation->tanggal_check_in)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td style="color: #666;">Check-out:</td>
                            <td style="text-align: right; font-weight: bold;">{{ \Carbon\Carbon::parse($reservation->tanggal_check_out)->format('d M Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Kamar</th>
                    <th class="text-right">Total Tagihan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-weight: bold;">Kamar Tipe {{ $reservation->room->tipe_kamar }}</div>
                        <div style="font-size: 12px; color: #666;">Lantai {{ $reservation->room->lantai }} - No. {{ $reservation->room->nomor_kamar }}</div>
                        @php
                            $checkIn = \Carbon\Carbon::parse($reservation->tanggal_check_in);
                            $checkOut = \Carbon\Carbon::parse($reservation->tanggal_check_out);
                            $hari = $checkIn->diffInDays($checkOut);
                        @endphp
                        <div style="font-size: 12px; color: #666;">Durasi: {{ $hari }} Malam</div>
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                <tr class="total-row">
                    <td class="text-right">TOTAL LUNAS</td>
                    <td class="text-right total-price">Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah mempercayakan pengalaman menginap Anda di N★JM Hotel.</p>
            <p>Invoice ini diterbitkan oleh sistem dan sah sebagai bukti pembayaran.</p>
        </div>
    </div>
</body>
</html>
