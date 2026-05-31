<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket Reservasi {{ $reservation->code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #2D2B26;
            background-color: #ffffff;
            margin: 0;
            padding: 10px;
            font-size: 13px;
        }
        .ticket {
            border: 2px dashed #d88234;
            border-radius: 12px;
            background-color: #fffbeb;
            padding: 20px;
            max-width: 360px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo-title {
            font-size: 22px;
            font-weight: bold;
            color: #d88234;
            margin: 0;
            letter-spacing: 1px;
        }
        .logo-subtitle {
            font-size: 11px;
            color: #6b7280;
            margin: 2px 0 0 0;
        }
        .code-container {
            text-align: center;
            margin-bottom: 20px;
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .code-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 1.5px;
            margin: 0 0 4px 0;
        }
        .code-value {
            font-size: 24px;
            font-weight: bold;
            color: #d88234;
            margin: 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 6px 0;
            border-bottom: 1px solid #f2e8d5;
            font-size: 12px;
        }
        .info-table td.label {
            color: #6b7280;
            text-align: left;
        }
        .info-table td.value {
            font-weight: bold;
            color: #1f2937;
            text-align: right;
        }
        .qr-container {
            text-align: center;
            margin-top: 15px;
        }
        .qr-box {
            display: inline-block;
            background: #ffffff;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .qr-footer-text {
            font-size: 9px;
            color: #6b7280;
            margin-top: 6px;
            margin-bottom: 0;
        }
        .notes-box {
            margin-top: 15px;
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 10px;
            font-size: 10px;
            color: #1e40af;
        }
        .notes-box p {
            margin: 0 0 4px 0;
            font-weight: bold;
        }
        .notes-box ul {
            margin: 0;
            padding-left: 12px;
        }
        .notes-box li {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1 class="logo-title">AMAPIANO</h1>
            <p class="logo-subtitle">Thematic Resto & Cafe</p>
        </div>
        
        <div class="code-container">
            <p class="code-label">Booking Code</p>
            <p class="code-value">#{{ $reservation->code }}</p>
        </div>
        
        <table class="info-table">
            <tr>
                <td class="label">Ruangan</td>
                <td class="value">
                    @if(strpos(strtolower($reservation->table_id), 'hb-') === 0)
                        Main Hall
                    @elseif(strpos(strtolower($reservation->table_id), 'cg-') === 0)
                        Covent Garden
                    @else
                        Limburg
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Meja</td>
                <td class="value">Table {{ strtoupper($reservation->table_id) }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="value">{{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td class="value">{{ $reservation->time }} WIB</td>
            </tr>
            <tr>
                <td class="label">Nama</td>
                <td class="value">{{ $reservation->fullname }}</td>
            </tr>
            <tr>
                <td class="label">No. HP</td>
                <td class="value">{{ $reservation->phone }}</td>
            </tr>
            @if($reservation->guests)
            <tr>
                <td class="label">Tamu</td>
                <td class="value">{{ $reservation->guests }} Orang</td>
            </tr>
            @endif
        </table>
        
        <div class="qr-container">
            <div class="qr-box">
                <img src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->generate($reservation->code)) !!}" width="120" height="120" alt="QR Code">
            </div>
            <p class="qr-footer-text">Scan QR Code untuk verifikasi kedatangan Anda</p>
        </div>
        
        <div class="notes-box">
            <p>Pengingat Penting:</p>
            <ul>
                <li>Datanglah tepat waktu sesuai jadwal reservasi.</li>
                <li>Tunjukkan tiket PDF ini saat arrival untuk verifikasi.</li>
                <li>Min. order Rp 40.000 (weekday) / Rp 60.000 (weekend).</li>
                <li>Pemesanan menu dilakukan via QR scan di meja Anda.</li>
            </ul>
        </div>
    </div>
</body>
</html>
