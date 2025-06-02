<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Exports\IncomeReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports');
    }

    public function exportExcel(Request $request)
    {
        $period = $request->input('period', 'day');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $fileName = 'laporan-pesanan-';

        switch ($period) {
            case 'day':
                $fileName .= Carbon::today()->format('Y-m-d');
                break;
            case 'week':
                $fileName .= Carbon::now()->startOfWeek()->format('Y-m-d') . '_to_' . Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $fileName .= Carbon::now()->format('Y-m');
                break;
            case 'custom':
                $fileName .= $startDate . '_to_' . $endDate;
                break;
        }

        $fileName .= '.xlsx';

        return Excel::download(new OrdersExport($period, $startDate, $endDate), $fileName);
    }
    public function exportIncomeReport(Request $request)
    {
        $period = $request->input('period', 'month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return (new IncomeReportExport($period, $startDate, $endDate))
            ->download('laporan-pendapatan-' . now()->format('Y-m-d') . '.xlsx');
    }
    public function exportPdf(Request $request)
    {
        $period = $request->input('period', 'day');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = $this->getOrdersByPeriod($period, $startDate, $endDate);

        // Ubah ini jadi string teks periode
        $periodText = $this->getPeriodText($period, $startDate, $endDate);

        $pdf = PDF::loadView('admin.pdf.report', [
            'orders' => $orders,
            'period' => $period,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'periodText' => $periodText // << dikirim ke view
        ]);

        $fileName = 'laporan-pesanan-';

        switch ($period) {
            case 'day':
                $fileName .= Carbon::today()->format('Y-m-d');
                break;
            case 'week':
                $fileName .= Carbon::now()->startOfWeek()->format('Y-m-d') . '_to_' . Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $fileName .= Carbon::now()->format('Y-m');
                break;
            case 'custom':
                $fileName .= $startDate . '_to_' . $endDate;
                break;
        }

        $fileName .= '.pdf';

        return $pdf->download($fileName);
    }


    protected function getOrdersByPeriod($period, $startDate = null, $endDate = null)
    {
        $query = Pesanan::with(['payment', 'user'])
            ->orderBy('created_at', 'desc');

        switch ($period) {
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
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay()
                    ]);
                }
                break;
        }

        return $query->get();
    }
    public function preview(Request $request)
    {
        $period = $request->input('period', 'day');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = $this->getOrdersByPeriod($period, $startDate, $endDate);

        $periodText = $this->getPeriodText($period, $startDate, $endDate);

        return response()->json([
            'orders' => $orders,
            'period_text' => $periodText,
            'total' => $orders->sum('harga'),
            'count' => $orders->count(),
            'success_count' => $orders->where('status', 'Selesai')->count(),
            'pending_count' => $orders->whereIn('status', ['Menunggu Konfirmasi Admin', 'Diproses'])->count(),
            'failed_count' => $orders->where('status', 'Ditolak')->count(),
        ]);
    }

    protected function getPeriodText($period, $startDate = null, $endDate = null)
    {
        switch ($period) {
            case 'day':
                return 'Harian - ' . Carbon::today()->format('d F Y');
            case 'week':
                return 'Mingguan - ' . Carbon::now()->startOfWeek()->format('d F Y') . ' hingga ' . Carbon::now()->endOfWeek()->format('d F Y');
            case 'month':
                return 'Bulanan - ' . Carbon::now()->format('F Y');
            case 'custom':
                return 'Custom - ' . Carbon::parse($startDate)->format('d F Y') . ' hingga ' . Carbon::parse($endDate)->format('d F Y');
            default:
                return 'Semua Periode';
        }
    }
}
