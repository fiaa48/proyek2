<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Show payment page for an order
     */
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Check if order is already paid
        if ($order->status === 'Paid') {
            return redirect()->route('orders.show', $orderId)
                ->with('warning', 'Order has already been paid');
        }
        
        return view('payments.show', compact('order'));
    }

    /**
     * Process payment for an order
     */
    public function process(Request $request, $orderId)
{
    $order = Pesanan::findOrFail($orderId);

    // Skip if already paid
    if ($order->status === 'Paid') {
        return response()->json(['status' => 'failed', 'message' => 'Already paid'], 400);
    }

    $transactionDetails = [
        'order_id' => $order->id . '-' . now()->timestamp,
        'gross_amount' => $order->harga, // Ganti jika field kamu bukan 'price'
    ];

    $customerDetails = [
        'first_name' => Auth::user()->name,
        'email' => Auth::user()->email,
    ];

    $itemDetails = [[
        'id' => $order->id,
        'price' => $order->harga,
        'quantity' => 1,
        'name' => $order->layanan ?? 'Pesanan #' . $order->id,
    ]];

    $params = [
        'transaction_details' => $transactionDetails,
        'customer_details' => $customerDetails,
        'item_details' => $itemDetails,
    ];

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Payment failed: ' . $e->getMessage(),
        ], 500);
    }
}


    /**
     * Handle Midtrans payment notification
     */
    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification();
        
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = explode('-', $notif->order_id)[0]; // Extract original order ID
        $fraud = $notif->fraud_status;
        $grossAmount = $notif->gross_amount;

        $order = Order::find($orderId);
        
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Verify transaction amount matches order amount
        if ($grossAmount != $order->price) {
            return response()->json(['status' => 'error', 'message' => 'Invalid amount'], 400);
        }

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // Set order status to "challenge"
                    $order->status = 'Challenge';
                    $order->save();
                } else {
                    // Payment successful
                    $order->status = 'Paid';
                    $order->save();
                }
            }
        } elseif ($transaction == 'settlement') {
            // Payment successful
            $order->status = 'Paid';
            $order->save();
        } elseif ($transaction == 'pending') {
            // Payment pending
            $order->status = 'Pending Payment';
            $order->save();
        } elseif ($transaction == 'deny') {
            // Payment denied
            $order->status = 'Denied';
            $order->save();
        } elseif ($transaction == 'expire') {
            // Payment expired
            $order->status = 'Expired';
            $order->save();
        } elseif ($transaction == 'cancel') {
            // Payment canceled
            $order->status = 'Canceled';
            $order->save();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request, $orderId)
{
    try {
        Log::info("📥 Memulai proses penyimpanan pembayaran. Order ID: {$orderId}");
        Log::info("📦 Data yang diterima:", $request->all());

        $payment = Payment::create([
            'pesanan_id' => $orderId,
            'user_id' => Auth::id(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'sukses',
            'tanggal_pembayaran' => Carbon::now(),
        ]);

        Log::info("✅ Pembayaran berhasil disimpan", $payment->toArray());

        return response()->json([
            'message' => 'Pembayaran sukses dicatat',
            'payment' => $payment
        ], 200);
    } catch (\Exception $e) {
        Log::error('❌ Gagal menyimpan pembayaran: ' . $e->getMessage());

        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan pembayaran',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Handle failed payment
     */
    public function failed(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        return view('payments.failed', compact('order'))
            ->with('error', 'Payment failed. Please try again.');
    }
}