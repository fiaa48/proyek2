<?php

namespace App\Exports;

use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomeReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
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
        $query = Payment::with(['pesanan', 'user'])
            ->where('status_pembayaran', 'success') // Only successful payments
            ->orderBy('tanggal_pembayaran', 'desc');

        switch ($this->period) {
            case 'day':
                $query->whereDate('tanggal_pembayaran', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('tanggal_pembayaran', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereBetween('tanggal_pembayaran', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
                break;
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('tanggal_pembayaran', [
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
            'ID Pembayaran',
            'Tanggal Pembayaran',
            'ID Pesanan',
            'Nama Pelanggan',
            'Metode Pembayaran',
            'Total Pembayaran',
            'Status',
            'Waktu Pembayaran'
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->id,
            Carbon::parse($payment->tanggal_pembayaran)->format('d/m/Y'),
            $payment->pesanan_id,
            $payment->user->name ?? 'Guest',
            $payment->metode_pembayaran,
            'Rp ' . number_format($payment->total_bayar, 0, ',', '.'),
            ucfirst($payment->status_pembayaran),
            Carbon::parse($payment->created_at)->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row style
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E5E7EB']]
            ],

            // Currency column alignment
            'F' => ['alignment' => ['horizontal' => 'right']],

            // Auto-size columns
            'A' => ['width' => 15],
            'B' => ['width' => 20],
            'C' => ['width' => 15],
            'D' => ['width' => 25],
            'E' => ['width' => 20],
            'F' => ['width' => 20],
            'G' => ['width' => 15],
            'H' => ['width' => 20],
        ];
    }

    public function title(): string
    {
        return 'Laporan Pendapatan';
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
            default:
                return 'Semua Periode';
        }
    }
}