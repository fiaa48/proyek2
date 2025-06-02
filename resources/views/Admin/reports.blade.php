@extends('layouts.admin')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        @include('admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 ml-64 container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Laporan Pesanan</h1>

            <!-- Filter Periode -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Filter Laporan</h2>
                
                <form id="reportForm" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                            <select name="period" id="period" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="day">Harian</option>
                                <option value="week">Mingguan</option>
                                <option value="month">Bulanan</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        
                        <div id="customDateRange" class="hidden md:col-span-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                    <input type="date" name="start_date" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="button" onclick="exportReport('excel')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </button>
                        <button type="button" onclick="exportReport('pdf')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-file-pdf mr-2"></i> Export PDF
                        </button>
                        <button type="button" onclick="previewReport()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-eye mr-2"></i> Preview
                        </button>
                    </div>
                </form>
            </div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-4 rounded-lg shadow">
        <div class="text-sm">Periode Saat Ini</div>
        <div class="text-xl font-semibold capitalize" id="infoPeriod">-</div>
    </div>
    <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-4 rounded-lg shadow">
        <div class="text-sm">Total Pesanan</div>
        <div class="text-xl font-semibold" id="infoTotal">-</div>
    </div>
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white p-4 rounded-lg shadow">
        <div class="text-sm">Status Terbaru</div>
        <div class="text-xl font-semibold" id="infoStatus">-</div>
    </div>
</div>

            <!-- Preview Table (akan diisi via AJAX) -->
            <div id="previewSection" class="bg-white rounded-lg shadow p-6 hidden">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Preview Laporan</h2>
                    <div class="text-sm text-gray-500" id="reportPeriodText"></div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">ID Pesanan</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Pelanggan</th>
                                <th class="px-4 py-2 border">Perangkat</th>
                                <th class="px-4 py-2 border">Total</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody id="reportData">
                            <!-- Data akan diisi via AJAX -->
                        </tbody>
                        <tfoot id="reportSummary">
                            <!-- Summary akan diisi via AJAX -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tampilkan/menyembunyikan custom date range
        document.getElementById('period').addEventListener('change', function() {
            const customDateRange = document.getElementById('customDateRange');
            if (this.value === 'custom') {
                customDateRange.classList.remove('hidden');
                customDateRange.classList.add('block');
            } else {
                customDateRange.classList.remove('block');
                customDateRange.classList.add('hidden');
            }
        });

        // Fungsi untuk export report
        function exportReport(type) {
            const form = document.getElementById('reportForm');
            const period = form.period.value;
            
            if (period === 'custom' && (!form.start_date.value || !form.end_date.value)) {
                alert('Harap pilih rentang tanggal untuk periode custom');
                return;
            }
            
            const url = type === 'excel' 
                ? "{{ route('admin.reports.export.excel') }}" 
                : "{{ route('admin.reports.export.pdf') }}";
            
            // Buat URL dengan parameter
            const params = new URLSearchParams();
            params.append('period', period);
            if (period === 'custom') {
                params.append('start_date', form.start_date.value);
                params.append('end_date', form.end_date.value);
            }
            
            window.location.href = `${url}?${params.toString()}`;
        }

        // Fungsi untuk preview report
        function previewReport() {
            const form = document.getElementById('reportForm');
            const period = form.period.value;
            
            if (period === 'custom' && (!form.start_date.value || !form.end_date.value)) {
                alert('Harap pilih rentang tanggal untuk periode custom');
                return;
            }
            
            // Tampilkan loading
            const previewSection = document.getElementById('previewSection');
            previewSection.classList.remove('hidden');
            document.getElementById('reportData').innerHTML = '<tr><td colspan="7" class="text-center py-4">Memuat data...</td></tr>';
            
            // Buat URL untuk AJAX
            const params = new URLSearchParams();
            params.append('period', period);
            if (period === 'custom') {
                params.append('start_date', form.start_date.value);
                params.append('end_date', form.end_date.value);
            }
            
            // Ambil data via AJAX
            fetch(`/admin/reports/preview?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update period text
                document.getElementById('reportPeriodText').textContent = data.period_text;
                
                // Update table data
                let html = '';
                data.orders.forEach(order => {
                    html += `
                        <tr>
                            <td class="px-4 py-2 border">${order.id}</td>
                            <td class="px-4 py-2 border">${order.tanggal_pemesanan}</td>
                            <td class="px-4 py-2 border">${order.nama}</td>
                            <td class="px-4 py-2 border">${order.jenis_barang}</td>
                            <td class="px-4 py-2 border text-right">Rp ${new Intl.NumberFormat('id-ID').format(order.harga)}</td>
                            <td class="px-4 py-2 border">${order.status}</td>
                            <td class="px-4 py-2 border">${order.payment ? order.payment.status_pembayaran : '-'}</td>
                        </tr>
                    `;
                });
                document.getElementById('reportData').innerHTML = html;
                
                // Update summary
                document.getElementById('reportSummary').innerHTML = `
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="4" class="px-4 py-2 border text-right">Total:</td>
                        <td class="px-4 py-2 border text-right">Rp ${new Intl.NumberFormat('id-ID').format(data.total)}</td>
                        <td colspan="2" class="px-4 py-2 border"></td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="7" class="px-4 py-2 border text-sm">
                            Total Pesanan: ${data.count} | 
                            Sukses: ${data.success_count} | 
                            Pending: ${data.pending_count} | 
                            Gagal: ${data.failed_count}
                        </td>
                    </tr>
                `;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('reportData').innerHTML = '<tr><td colspan="7" class="text-center py-4 text-red-500">Gagal memuat data</td></tr>';
            });
        }
    </script>
@endsection