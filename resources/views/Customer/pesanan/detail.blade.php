@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg max-w-screen-2xl pb-10">
        <h2 class="text-3xl font-bold mb-8">Daftar Pesanan/Riwayat Pesanan</h2>

        <table class="table-auto w-full border-collapse border border-gray-300 pb-5">
            <thead>
                <tr style="background-color: #EAE6DF;">
                    <th class="border border-gray-300 px-6 py-3">ID Pesanan</th>
                    <th class="border border-gray-300 px-6 py-3">Layanan/Barang</th>
                    <th class="border border-gray-300 px-6 py-3">Deskripsi Kerusakan</th>
                    <th class="border border-gray-300 px-6 py-3">Tanggal Pemesanan</th>
                    <th class="border border-gray-300 px-6 py-3 text-center">Status</th>
                    <th class="border border-gray-300 px-6 py-3">Harga</th>
                    <th class="border border-gray-300 px-6 py-3 text-center">Rating</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($pesanans as $pesanan)
                    <tr>
                        <td class="border border-gray-300 px-6 py-3">{{ $pesanan->id }}</td>
                        <td class="border border-gray-300 px-6 py-3">{{ $pesanan->jenis_barang }}</td>
                        <td class="border border-gray-300 px-6 py-3">{{ $pesanan->keluhan }}</td>
                        <td class="border border-gray-300 px-6 py-3 text-center">
                            {{-- Format tanggal --}}
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') }}
                        <td class="border border-gray-300 px-6 py-3 text-center">
                            <span
                                class="px-3 py-1 rounded
                        {{ $pesanan->status == 'Selesai'
                            ? 'bg-green-100 text-green-800'
                            : ($pesanan->status == 'Dalam Proses Servis'
                                ? 'bg-yellow-100 text-yellow-800'
                                : 'bg-blue-100 text-blue-800') }}">
                                {{ $pesanan->status }}
                            </span>
                        </td>
                        <td class="border px-2 py-2 text-start">
                            Rp {{ number_format($pesanan->harga, 0, ',', '.') }}

                            @if (!is_null($pesanan->payment))
                            <a href="{{ route('invoices.download', $pesanan->payment->id) }}"
                                    class="bg-green-500 text-white text-sm px-3 py-1 rounded hover:bg-green-600 mt-2">
                                    Invoice
                                </a>
                            @elseif (is_null($pesanan->payment) && $pesanan->harga>0)
                            <button onclick="payNow({{ $pesanan->id }})"
                                    class="bg-red-500 text-white text-sm px-3 py-1 rounded hover:bg-red-600 mt-2">
                                    Bayar Sekarang
                                </button>
                            @else
                            
                                
                            @endif
                        </td>
                        <td class="border border-gray-300 px-6 py-3 text-center">
                            @if ($pesanan->status == 'Selesai')
                                @php
                                    $existingReview = \App\Models\Review::where('pesanan_id', $pesanan->id)
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp

                                @if (!$existingReview)
                                    <form action="{{ route('review.store', ['orderId' => $pesanan->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
                                        <input type="number" name="rating" min="1" max="5"
                                            class="w-16 text-center border border-gray-300 rounded" placeholder="★"
                                            required>
                                        <textarea name="komentar" rows="2" class="w-full border border-gray-300 rounded mt-2"
                                            placeholder="Tambahkan komentar" required></textarea>
                                        <button type="submit"
                                            class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Kirim</button>
                                    </form>
                                @else
                                    <div class="text-left">
                                        <p class="text-yellow-500">Rating: {{ $existingReview->rating }} ★</p>
                                        <p class="text-gray-700">Komentar: {{ $existingReview->comment }}</p>
                                    </div>
                                @endif
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        function payNow(orderId) {
            fetch(`/dashboard/pesanan/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pembayaran berhasil!");
                                fetch(`/dashboard/pesanan/success/${orderId}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute('content')
                                        },
                                        body: JSON.stringify({
                                            pesanan_id: orderId,
                                            metode_pembayaran: 'midtrans',
                                            total_bayar: result.gross_amount
                                        })
                                    })
                                    .then(async (res) => {
                                        const text = await res.text();
                                        try {
                                            const data = JSON.parse(text);
                                            console.log('✅ Data pembayaran berhasil disimpan:',
                                            data);
                                            window.location.reload();
                                            // alert("Data pembayaran berhasil disimpan.");
                                            // location.reload();
                                        } catch (e) {
                                            console.error(
                                                '❌ Gagal parse JSON. Mungkin respons HTML:',
                                                text);
                                            alert("Terjadi kesalahan saat menyimpan pembayaran.");
                                        }
                                    })
                                    .catch(error => {
                                        alert("Gagal menyimpan data pembayaran.");
                                        console.error('Error:', error);
                                    });

                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran...");
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                            },
                            onClose: function() {
                                console.log("Popup ditutup.");
                            }
                        });

                    } else {
                        alert("Gagal mendapatkan token pembayaran");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan saat memproses pembayaran.");
                });
        }
    </script>
@endpush
