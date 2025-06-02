<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan TechFix</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .summary { margin-top: 20px; padding: 10px; background-color: #f9f9f9; border-radius: 5px; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pesanan TechFix</h1>
        <p>Periode: {{ $periodText }}</p>
<p>Periode: {{ $periodText }}</p>

        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Perangkat</th>
                <th class="text-right">Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->tanggal_pemesanan }}</td>
                <td>{{ $order->nama }}</td>
                <td>{{ $order->jenis_barang }}</td>
                <td class="text-right">Rp {{ number_format($order->harga, 0, ',', '.') }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->payment ? $order->payment->status_pembayaran : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total:</th>
                <th class="text-right">Rp {{ number_format($orders->sum('harga'), 0, ',', '.') }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        <p><strong>Ringkasan:</strong></p>
        <p>Total Pesanan: {{ $orders->count() }}</p>
        <p>Pesanan Sukses: {{ $orders->where('status', 'Selesai')->count() }}</p>
        <p>Pesanan Pending: {{ $orders->where('status', 'Menunggu Konfirmasi Admin')->count() + $orders->where('status', 'Diproses')->count() }}</p>
        <p>Pesanan Ditolak/Gagal: {{ $orders->where('status', 'Ditolak')->count() }}</p>
    </div>

    <div class="footer">
        Dicetak oleh sistem TechFix
    </div>
</body>
</html>
