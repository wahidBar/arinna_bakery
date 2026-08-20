@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
@include('partials.breadcrumb', ['items' => [['label' => 'Checkout']]])
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">Checkout</h1>

    @if ($errors->any())
        <div class="bg-rose-50 text-rose-700 border border-rose-200 rounded-xl px-4 py-3 mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
                <h3 class="font-semibold mb-4">Alamat Pengiriman</h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium block mb-1">Nama Penerima</label>
                        <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}"
                               class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Nomor Telepon</label>
                        <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}"
                               class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Alamat Lengkap</label>
                        <textarea name="shipping_address" rows="3"
                                  class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm" required>{{ old('shipping_address') }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="w-full border border-amber-100 rounded-lg px-3 py-2 text-sm">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
                <h3 class="font-semibold mb-4">Metode Pembayaran</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 border border-amber-100 rounded-lg px-4 py-3 cursor-pointer">
                        <input type="radio" name="payment_method" value="transfer_bank" checked>
                        <span class="text-sm">Transfer Bank</span>
                    </label>
                    <label class="flex items-center gap-3 border border-amber-100 rounded-lg px-4 py-3 cursor-pointer">
                        <input type="radio" name="payment_method" value="cod">
                        <span class="text-sm">Bayar di Tempat (COD)</span>
                    </label>
                    <label class="flex items-center gap-3 border border-amber-100 rounded-lg px-4 py-3 cursor-pointer">
                        <input type="radio" name="payment_method" value="midtrans">
                        <span class="text-sm">Pembayaran Online (Midtrans)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 h-fit">
            <h3 class="font-semibold mb-4">Ringkasan Pesanan</h3>
            <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                @foreach ($carts as $cart)
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-600">{{ $cart->product->name }} x{{ $cart->qty }}</span>
                        <span class="font-medium">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-amber-100 pt-3 flex justify-between font-bold">
                <span>Total</span>
                <span class="text-amber-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <button type="submit" class="w-full bg-amber-700 text-white font-medium rounded-full py-3 mt-6 hover:bg-amber-800">
                Buat Pesanan
            </button>
        </div>
    </form>
</div>
@endsection
