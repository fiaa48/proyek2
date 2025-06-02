<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Pesanan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $period;
    protected $startDate;
    protected $endDate;

    public function __construct($period, $startDate = null, $endDate = null)
    {
        $this->period = $period;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Pesanan::with(['payment', 'user'])
            ->orderBy('created_at', 'desc');

        switch ($this->period) {
            case 'day':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                break;
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($this->startDate)->startOfDay(),
                        Carbon::parse($this->endDate)->endOfDay()
                    ]);
                }
                break;
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Tanggal Pesanan',
            'Nama Pelanggan',
            'Jenis Perangkat',
            'Deskripsi Kerusakan',
            'Total Biaya',
            'Status Pesanan',
            'Status Pembayaran',
            'Metode Pembayaran'
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->tanggal_pemesanan,
            $order->nama,
            $order->jenis_barang,
            $order->deskripsi_kerusakan,
            $order->harga,
            $order->status,
            $order->payment ? $order->payment->status_pembayaran : '-',
            $order->metode_pembayaran ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate
            'A1:I1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DDDDDD']]],

            // Styling an entire column
            'F' => ['alignment' => ['horizontal' => 'right']],
        ];
    }

    public function getPeriodText()
    {
        switch ($this->period) {
            case 'day':
                return 'Harian - ' . Carbon::today()->format('d F Y');
            case 'week':
                return 'Mingguan - ' . Carbon::now()->startOfWeek()->format('d F Y') . ' hingga ' . Carbon::now()->endOfWeek()->format('d F Y');
            case 'month':
                return 'Bulanan - ' . Carbon::now()->format('F Y');
            case 'custom':
                return 'Custom - ' . Carbon::parse($this->startDate)->format('d F Y') . ' hingga ' . Carbon::parse($this->endDate)->format('d F Y');
        }
    }
}