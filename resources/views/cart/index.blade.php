@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">Keranjang Belanja</h1>

    @if ($carts->isEmpty())
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-10 text-center">
        <p class="text-stone-400 mb-4">Keranjang Anda masih kosong.</p>
        <a href="{{ route('products.index') }}" class="bg-amber-700 text-white text-sm font-medium rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition">
            Mulai Belanja
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4" id="cart-items">
            @foreach ($carts as $cart)
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-4 flex items-center gap-4" data-cart-id="{{ $cart->id }}">
                <img
                    src="{{ $cart->product->primaryImage ? asset('storage/' . $cart->product->primaryImage->image_path) : asset('images/placeholder.jpg') }}"
                    class="w-20 h-20 rounded-lg object-cover">

                <div class="flex-1">
                    <a href="{{ route('products.show', $cart->product->slug) }}" class="font-medium text-sm hover:text-[#6c7fd8]">
                        {{ $cart->product->name }}
                    </a>
                    @if ($cart->variant)
                    <p class="text-xs text-stone-400">Varian: {{ $cart->variant }}</p>
                    @endif
                    <p class="text-sm text-amber-700 font-semibold mt-1">Rp {{ number_format($cart->price_snapshot, 0, ',', '.') }}</p>
                </div>

                <div class="flex items-center border border-amber-100 rounded-full">
                    <button onclick="updateQty({{ $cart->id }}, -1)" class="px-3 py-1 text-stone-500">-</button>
                    <span class="w-8 text-center text-sm cart-qty">{{ $cart->qty }}</span>
                    <button onclick="updateQty({{ $cart->id }}, 1)" class="px-3 py-1 text-stone-500">+</button>
                </div>

                <p class="w-28 text-right font-semibold text-sm cart-subtotal">
                    Rp {{ number_format($cart->subtotal, 0, ',', '.') }}
                </p>

                <button onclick="removeCart({{ $cart->id }})" class="text-rose-500 hover:text-rose-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 h-fit">
            <h3 class="font-semibold mb-4">Ringkasan Belanja</h3>
            <div class="flex justify-between text-sm mb-2">
                <span>Total</span>
                <span id="cart-total" class="font-bold text-amber-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="block text-center bg-amber-700 text-white font-medium rounded-full py-3 mt-4 hover:bg-amber-800">
                Lanjut ke Checkout
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function updateQty(cartId, delta) {
        const row = document.querySelector(`[data-cart-id="${cartId}"]`);
        const qtyEl = row.querySelector('.cart-qty');
        const newQty = Math.max(1, parseInt(qtyEl.textContent) + delta);

        fetch(`/cart/${cartId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    qty: newQty
                }),
            })
            .then(res => res.json().then(data => ({
                status: res.status,
                data
            })))
            .then(({
                status,
                data
            }) => {
                if (status === 422) {
                    alert(data.message);
                    return;
                }

                qtyEl.textContent = newQty;
                row.querySelector('.cart-subtotal').textContent = 'Rp ' + data.subtotal.toLocaleString('id-ID');
                document.getElementById('cart-total').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                refreshCartBadge();
            });
    }

    function removeCart(cartId) {
        if (!confirm('Hapus produk ini dari keranjang?')) return;

        fetch(`/cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(res => res.json())
            .then(data => {
                document.querySelector(`[data-cart-id="${cartId}"]`).remove();
                document.getElementById('cart-total').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                refreshCartBadge();

                if (data.total === 0) window.location.reload();
            });
    }
</script>
@endpush