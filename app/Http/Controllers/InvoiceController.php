<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pesanan;
use PDF;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function show($paymentId)
    {
        $payment = Payment::with(['pesanan', 'user'])
                        ->findOrFail($paymentId);

        return view('Customer.invoices.show', compact('payment'));
    }

    public function download($paymentId)
    {
        $payment = Payment::with(['pesanan', 'user'])
                        ->findOrFail($paymentId);

        $data = [
            'payment' => $payment,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i'),
        ];

        $pdf = PDF::loadView('Customer.invoices.pdf', $data);

        $filename = 'Invoice-' . $payment->pesanan_id . '-' . Carbon::parse($payment->tanggal_pembayaran)->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    public function print($paymentId)
    {
        $payment = Payment::with(['pesanan', 'user'])
                        ->findOrFail($paymentId);

        $data = [
            'payment' => $payment,
            'tanggal_cetak' => Carbon::now()->format('d F Y H:i'),
        ];

        $pdf = PDF::loadView('Customer.invoices.pdf', $data);

        $filename = 'Invoice-' . $payment->pesanan_id . '-' . Carbon::parse($payment->tanggal_pembayaran)->format('Ymd') . '.pdf';

        return $pdf->stream($filename);
    }
}