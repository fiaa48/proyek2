@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Invoice #{{ $payment->pesanan_id }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('invoices.download', $payment->id) }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Download PDF
            </a>
            <a href="{{ route('invoices.print', $payment->id) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Print Invoice
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <h3 class="font-bold text-lg mb-2">TechFix</h3>
                <p>Jl. Terusan blok Sukadedel</p>
                <p>Indramayu, Indonesia</p>
                <p>Telp: (+62)87727377749</p>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-2">Invoice</h3>
                <p><strong>No. Invoice:</strong> INV-{{ $payment->pesanan_id }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d M Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $payment->status_pembayaran === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($payment->status_pembayaran) }}
                    </span>
                </p>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-2">Pelanggan</h3>
                <p><strong>Nama:</strong> {{ $payment->user->name ?? 'Guest' }}</p>
                <p><strong>ID Pelanggan:</strong> {{ $payment->user_id ?? '-' }}</p>
                <p><strong>Pesanan ID:</strong> {{ $payment->pesanan_id }}</p>
            </div>
        </div>

        <div class="border-t border-b border-gray-200 py-4 my-4">
            <h3 class="font-bold text-lg mb-2">Detail Pesanan</h3>
            <p><strong>Perangkat:</strong> {{ $payment->pesanan->jenis_barang ?? '-' }}</p>
            <p><strong>Deskripsi:</strong> {{ $payment->pesanan->deskripsi_kerusakan ?? '-' }}</p>
        </div>

        <div class="mb-6">
            <h3 class="font-bold text-lg mb-2">Rincian Pembayaran</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p><strong>Metode Pembayaran:</strong></p>
                        <p>{{ ucfirst($payment->metode_pembayaran) }}</p>
                    </div>
                    <div>
                        <p><strong>Total Pembayaran:</strong></p>
                        <p class="text-xl font-bold">Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p><strong>Tanggal Pembayaran:</strong></p>
                        <p>{{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p><strong>Waktu Transaksi:</strong></p>
                        <p>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <p class="text-yellow-700">Terima kasih telah menggunakan layanan TechFix. Invoice ini merupakan bukti pembayaran yang sah.</p>
        </div>
    </div>
</div>
@endsection
