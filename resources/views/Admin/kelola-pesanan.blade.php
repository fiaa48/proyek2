@extends('layouts.admin')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        @include('Admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 ml-64 container mx-auto p-6" x-data="{ openDetail: false, selectedOrder: null }">

            <h1 class="text-2xl font-bold mb-4">Kelola Pesanan</h1>

            <!-- Filter -->
            <!-- filepath: c:\xampp\htdocs\proyek2\resources\views\Admin\kelola-pesanan.blade.php -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-2 mb-4">
                <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-col md:flex-row gap-2 w-full">
                    <input type="text" name="search" placeholder="Cari pelanggan..." value="{{ request('search') }}"
                        class="border px-4 py-2 rounded-lg w-full md:w-1/3">
                    <div class="flex flex-col md:flex-row gap-2 w-full justify-end">
                        <select name="status" class="border px-4 py-2 rounded-lg w-full md:w-1/4">
                            <option value="">Semua Status</option>
                            <option value="Menunggu Konfirmasi Admin"
                                {{ request('status') == 'Menunggu Konfirmasi Admin' ? 'selected' : '' }}>Menunggu Konfirmasi
                            </option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
            <!-- Tabel Pesanan -->
<div class="overflow-x-auto rounded-lg shadow border border-gray-300 bg-white">
    <table class="min-w-full text-sm border-collapse border border-gray-300">
        <thead style="background-color: #EAE6DF; color: #4B453C;">
            <tr>
                <th class="px-4 py-3 text-left border border-gray-300">ID</th>
                <th class="px-4 py-3 text-left border border-gray-300">Nama</th>
                <th class="px-4 py-3 text-left border border-gray-300">Perangkat</th>
                <th class="px-4 py-3 text-left border border-gray-300">Tanggal</th>
                <th class="px-4 py-3 text-left border border-gray-300">Total Biaya</th>
                <th class="px-4 py-3 text-left border border-gray-300">Metode Bayar</th>
                <th class="px-4 py-3 text-left border border-gray-300">Pembayaran</th>
                <th class="px-4 py-3 text-left border border-gray-300">Status Pesanan</th>
                <th class="px-4 py-3 text-center border border-gray-300">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanans as $pesanan)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">{{ $pesanan->id }}</td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">{{ $pesanan->nama }}</td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">{{ $pesanan->jenis_barang }}</td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">{{ $pesanan->tanggal_pemesanan }}</td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">{{ $pesanan->metode_pembayaran }}</td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $pesanan->payment != null ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">

                            {{ $pesanan->payment->status_pembayaran ?? 'failed' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300">
                        <form action="{{ route('admin.kelola-pesanan', $pesanan->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <select name="status" class="border rounded px-2 py-1 bg-white text-sm" onchange="this.form.submit()">
                                <option value="Menunggu Konfirmasi Admin" {{ $pesanan->status == 'Menunggu Konfirmasi Admin' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="Diproses" {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ $pesanan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-center border border-gray-300 space-x-1">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm"
                            @click="openDetail = true; selectedOrder = {{ json_encode($pesanan) }}">
                            Detail
                        </button>
                        <a href="{{ route('admin.editHarga', $pesanan->id) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

            <!-- Modal Detail Pesanan -->
            <div x-show="openDetail" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
                x-transition.opacity>
                <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                    <h2 class="text-xl font-bold mb-4">Detail Pesanan</h2>

                    <div class="space-y-2">
                        <p><strong>Nama:</strong> <span x-text="selectedOrder?.nama"></span></p>
                        <p><strong>Perangkat:</strong> <span x-text="selectedOrder?.jenis_barang"></span></p>
                        <p><strong>Tanggal Pesanan:</strong> <span x-text="selectedOrder?.tanggal_pemesanan"></span></p>
                        <p><strong>Total Biaya:</strong> Rp <span x-text="selectedOrder?.harga"></span></p>
                        <p><strong>Status Pembayaran:</strong> <span x-text="selectedOrder?.status_pembayaran"></span></p>
                        <p><strong>Status Pesanan:</strong> <span x-text="selectedOrder?.status"></span></p>
                    </div>

                    <template x-if="selectedOrder?.status == 'menunggu'">
                        <form :action="`/admin/pesanan/${selectedOrder.id}/konfirmasi`" method="POST" class="mt-4">
                            @csrf
                            <div class="mb-2">
                                <label class="block text-sm font-semibold mb-1">Total Biaya (Rp)</label>
                                <input type="number" name="harga" class="w-full border p-2 rounded" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold mb-1">Estimasi Pengerjaan</label>
                                <input type="text" name="estimasi" class="w-full border p-2 rounded"
                                    placeholder="Contoh: 2 hari" required>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" @click="openDetail = false"
                                    class="bg-gray-400 text-white px-4 py-2 rounded">Tutup</button>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Konfirmasi</button>
                            </div>
                        </form>
                    </template>

                    <template x-if="selectedOrder?.status != 'menunggu'">
                        <div class="flex justify-end mt-6">
                            <button type="button" @click="openDetail = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection
