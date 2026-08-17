<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        $total = $carts->sum('subtotal');

        return view('checkout.index', compact('carts', 'total'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        // Validasi ulang stok sebelum checkout, mencegah race condition dasar
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->qty) {
                return back()->with('error', "Stok {$cart->product->name} tidak mencukupi.");
            }
        }

        $order = DB::transaction(function () use ($request, $carts) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_no' => Order::generateInvoiceNo(),
                'total_price' => $carts->sum('subtotal'),
                'status' => 'pending',
                'payment_method' => $request->validated('payment_method'),
                'payment_status' => 'unpaid',
                'shipping_address' => $request->validated('shipping_address'),
                'shipping_name' => $request->validated('shipping_name'),
                'shipping_phone' => $request->validated('shipping_phone'),
                'notes' => $request->validated('notes'),
            ]);

            foreach ($carts as $cart) {
                $order->items()->create([
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name,
                    'qty' => $cart->qty,
                    'price' => $cart->price_snapshot,
                ]);

                // Kurangi stok & tambah sold_count
                $cart->product->decrement('stock', $cart->qty);
                $cart->product->increment('sold_count', $cart->qty);
            }

            // Kosongkan keranjang setelah order dibuat
            auth()->user()->carts()->delete();

            return $order;
        });

        // TODO modul selanjutnya: kirim Notification/Mail "Order Diterima" ke customer

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Invoice: ' . $order->invoice_no);
    }
}
