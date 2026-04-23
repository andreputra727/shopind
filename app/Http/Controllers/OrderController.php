<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $items = $cart ? $cart->items()->with('product')->get() : collect();
        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);
        $payment = $request->query('payment', 'saldo');
        return view('order.checkout', compact('items', 'total', 'payment'));
    }

    public function confirm(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($item) => $item->product->price * $item->quantity);
        $payment = $request->input('payment', 'saldo');

        $user = Auth::user();

        if ($payment === 'saldo') {
            if ($user->balance < $total) {
                return redirect()->route('cart.index')->with('error', 'Pesanan gagal! Saldo Anda tidak mencukupi (Sisa Saldo: Rp '.number_format($user->balance, 0, ',', '.').'). Silakan Top Up terlebih dahulu.');
            }
            $user->balance -= $total;
            $user->save();
        }

        $order = Order::create([
            'user_id'     => $user->id,
            'total_price' => $total,
            'status'      => 'success',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('order.riwayat')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function riwayat()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('order.riwayat', compact('orders'));
    }
}