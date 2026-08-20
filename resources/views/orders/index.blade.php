@extends('layouts.app')

@section('title', 'Pesanan Saya')

@php
    $statusColor = [
        'pending' => 'bg-stone-100 text-stone-600',
        'diproses' => 'bg-blue-100 text-blue-700',
        'dikirim' => 'bg-amber-100 text-amber-700',
        'selesai' => 'bg-emerald-100 text-emerald-700',
        'dibatalkan' => 'bg-rose-100 text-rose-700',
    ];
@endphp

@section('content')
@include('partials.breadcrumb', ['items' => [['label' => 'Pesanan Saya']]])
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">Pesanan Saya</h1>

    @if ($orders->isEmpty())
        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-10 text-center text-stone-400">
            Anda belum pernah membuat pesanan.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block bg-white rounded-2xl border border-amber-100 shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-sm">{{ $order->invoice_no }}</span>
                        <span class="text-xs font-medium px-3 py-1 rounded-full {{ $statusColor[$order->status] ?? '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-stone-400 mb-2">{{ $order->created_at->format('d M Y, H:i') }} &middot; {{ $order->items_count }} item</p>
                    <p class="font-bold text-amber-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
