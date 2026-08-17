@extends('layouts.app')

@section('title', 'Detail Pesanan — ' . $order->invoice_no)

@php
    $steps = ['pending', 'diproses', 'dikirim', 'selesai'];
    $currentStep = array_search($order->status, $steps);
@endphp

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('orders.index') }}" class="text-sm text-amber-700 hover:underline">&larr; Kembali ke Pesanan Saya</a>

    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 mt-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="font-display text-xl font-bold text-stone-900">{{ $order->invoice_no }}</h1>
                <p class="text-xs text-stone-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        {{-- Status tracker sederhana --}}
        @if ($order->status !== 'dibatalkan')
            <div class="flex items-center justify-between mb-8">
                @foreach ($steps as $i => $step)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $i <= $currentStep ? 'bg-amber-700 text-white' : 'bg-stone-200 text-stone-400' }}">
                            {{ $i + 1 }}
                        </div>
                        <span class="text-xs mt-2 capitalize">{{ $step }}</span>
                    </div>
                    @if (!$loop->last)
                        <div class="flex-1 h-0.5 {{ $i < $currentStep ? 'bg-amber-700' : 'bg-stone-200' }}"></div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="bg-rose-50 text-rose-700 text-sm rounded-lg px-4 py-3 mb-6">Pesanan ini telah dibatalkan.</div>
        @endif

        <div class="border-t border-stone-100 pt-4 space-y-3">
            @foreach ($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item->product_name }} x{{ $item->qty }}</span>
                    <span class="font-medium">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="border-t border-amber-100 mt-4 pt-4 flex justify-between font-bold">
            <span>Total</span>
            <span class="text-amber-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="mt-6 text-sm text-stone-600 space-y-1">
            <p><span class="font-medium">Penerima:</span> {{ $order->shipping_name }} ({{ $order->shipping_phone }})</p>
            <p><span class="font-medium">Alamat:</span> {{ $order->shipping_address }}</p>
            <p><span class="font-medium">Pembayaran:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
        </div>
    </div>
</div>
@endsection
