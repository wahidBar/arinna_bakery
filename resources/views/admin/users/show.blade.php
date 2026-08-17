@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
<div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6 mb-6">
    <h2 class="font-display font-semibold text-lg text-stone-900">{{ $user->name }}</h2>
    <p class="text-sm text-stone-500">{{ $user->email }} &middot; {{ $user->phone ?? '-' }}</p>
    <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-700 capitalize">{{ $user->role }}</span>
</div>

<div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-amber-100 font-semibold text-sm">Histori Pesanan</div>
    <table class="w-full text-sm">
        <thead class="bg-amber-50/60 text-stone-500">
            <tr class="text-left">
                <th class="px-4 py-3">Invoice</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="border-t border-amber-50">
                    <td class="px-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="text-amber-700 font-medium hover:underline">{{ $order->invoice_no }}</a></td>
                    <td class="px-4 py-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                    <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-stone-400">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
