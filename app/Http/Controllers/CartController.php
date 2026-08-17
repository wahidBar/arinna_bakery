<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $carts = auth()->user()->carts()->with('product.primaryImage')->get();
        $total = $carts->sum('subtotal');

        return view('cart.index', compact('carts', 'total'));
    }

    /**
     * Tambah produk ke keranjang via AJAX. Jika produk+varian sudah ada,
     * qty ditambahkan (bukan bikin baris baru) — lihat unique constraint di migration.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['nullable', 'integer', 'min:1'],
            'variant' => ['nullable', 'string', 'max:100'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $qty = $data['qty'] ?? 1;

        if ($product->stock < $qty) {
            return response()->json(['message' => 'Stok tidak mencukupi.'], 422);
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('variant', $data['variant'] ?? null)
            ->first();

        if ($cart) {
            $cart->increment('qty', $qty);
        } else {
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'qty' => $qty,
                'price_snapshot' => $product->final_price,
                'variant' => $data['variant'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang.',
            'cart_count' => $this->cartCount(),
        ]);
    }

    public function update(Request $request, Cart $cart): JsonResponse
    {
        $this->authorizeCart($cart);

        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        if ($cart->product->stock < $data['qty']) {
            return response()->json(['message' => 'Stok tidak mencukupi.'], 422);
        }

        $cart->update(['qty' => $data['qty']]);

        return response()->json([
            'message' => 'Keranjang diperbarui.',
            'subtotal' => $cart->subtotal,
            'total' => auth()->user()->carts->sum('subtotal'),
        ]);
    }

    public function destroy(Cart $cart): JsonResponse
    {
        $this->authorizeCart($cart);
        $cart->delete();

        return response()->json([
            'message' => 'Produk dihapus dari keranjang.',
            'cart_count' => $this->cartCount(),
            'total' => auth()->user()->carts->sum('subtotal'),
        ]);
    }

    // Dipanggil dari navbar untuk menampilkan jumlah item keranjang secara live
    public function count(): JsonResponse
    {
        return response()->json(['cart_count' => $this->cartCount()]);
    }

    private function cartCount(): int
    {
        return (int) auth()->user()->carts()->sum('qty');
    }

    private function authorizeCart(Cart $cart): void
    {
        abort_if($cart->user_id !== auth()->id(), 403);
    }
}
