<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $payment->pesanan_id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&display=swap');

        body {
            font-family: 'Roboto Mono', monospace;
            line-height: 1.4;
            color: #000;
            background-color: #fff;
            font-size: 12px;
        }
        .container {
            height: 100%;
            width:100%;
            margin: 0 auto;
            padding: 15px;
            border: 1px dashed #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        .logo {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .address {
            font-size: 10px;
            margin-bottom: 5px;
        }
        .invoice-info {
            margin: 10px 0;
            font-size: 11px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .double-divider {
            border-top: 2px double #000;
            margin: 10px 0;
        }
        .customer-info {
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .table th {
            text-align: left;
            padding: 3px 0;
            border-bottom: 1px dashed #000;
        }
        .table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin: 10px 0;
            font-size: 14px;
        }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        .status {
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Libre Barcode 128', cursive;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">TECHFIX</div>
            <div class="address">
                Jl. Terusan Blok Sukadedel, Indramayu<br>
                Telp: (+62)87727377749
            </div>
            <div class="divider"></div>
            <div class="invoice-info">
                <div><span class="info-label">No. Nota:</span> INV-{{ $payment->pesanan_id }}</div>
                <div><span class="info-label">Tanggal:</span> {{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d/m/Y H:i') }}</div>
                <div><span class="info-label">Kasir:</span> Admin</div>
            </div>
        </div>

        <div class="customer-info">
            <div><span class="info-label">Pelanggan:</span> {{ $payment->user->name ?? 'Guest' }}</div>
            <div><span class="info-label">Pesanan ID:</span> {{ $payment->pesanan_id }}</div>
            <div><span class="info-label">Perangkat:</span> {{ $payment->pesanan->jenis_barang ?? '-' }}</div>
            <div><span class="info-label">Status:</span>
                <span class="status status-{{ $payment->status_pembayaran }}">
                    {{ ucfirst($payment->status_pembayaran) }}
                </span>
            </div>
        </div>

        <div class="divider"></div>

        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Perbaikan {{ $payment->pesanan->jenis_barang ?? 'Perangkat' }}</td>
                    <td class="text-right">Rp{{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="double-divider"></div>

        <div class="total">
            TOTAL: Rp{{ number_format($payment->total_bayar, 0, ',', '.') }}
        </div>

        <div class="divider"></div>

        <div class="payment-info">
            <div><span class="info-label">Pembayaran:</span> {{ ucfirst($payment->metode_pembayaran) }}</div>
            <div><span class="info-label">Referensi:</span> PAY-{{ $payment->id }}</div>
        </div>

        <div class="barcode">
            *INV-{{ $payment->pesanan_id }}*
        </div>

        <div class="footer">
            Terima kasih telah mempercayakan<br>
            perbaikan kepada TechFix<br>
            Barang yang sudah dibeli tidak dapat dikembalikan<br>
            {{ $tanggal_cetak }}
        </div>
    </div>
</body>
</html>
