@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
        <h2 class="font-display font-semibold text-stone-900 mb-4">{{ $order->invoice_no }}</h2>

        <table class="w-full text-sm mb-4">
            <thead class="text-stone-400 text-left border-b border-amber-100">
                <tr><th class="pb-2">Produk</th><th class="pb-2">Qty</th><th class="pb-2">Harga</th><th class="pb-2">Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr class="border-b border-stone-50">
                        <td class="py-2">{{ $item->product_name }}</td>
                        <td class="py-2">{{ $item->qty }}</td>
                        <td class="py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="py-2">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between font-bold border-t border-amber-100 pt-3">
            <span>Total</span>
            <span class="text-amber-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="mt-6 text-sm text-stone-600 space-y-1">
            <p><span class="font-medium">Customer:</span> {{ $order->user->name }} ({{ $order->user->email }})</p>
            <p><span class="font-medium">Penerima:</span> {{ $order->shipping_name }} — {{ $order->shipping_phone }}</p>
            <p><span class="font-medium">Alamat:</span> {{ $order->shipping_address }}</p>
            <p><span class="font-medium">Pembayaran:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }} ({{ $order->payment_status }})</p>
            @if ($order->notes)
                <p><span class="font-medium">Catatan:</span> {{ $order->notes }}</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 h-fit">
        <h3 class="font-display font-semibold text-stone-900 mb-4">Update Status</h3>
        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
            @csrf @method('PATCH')
            <select name="status" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 mb-4">
                @foreach (['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full bg-amber-700 text-white text-sm font-medium rounded-lg py-2.5 hover:bg-amber-800">
                Simpan Status
            </button>
        </form>
    </div>
</div>
@endsection
