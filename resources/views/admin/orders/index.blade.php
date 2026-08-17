@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<form method="GET" class="flex gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice..."
           class="border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 w-64">
    <select name="status" class="border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
        <option value="">Semua Status</option>
        @foreach (['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $status)
            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-stone-900 text-white text-sm font-semibold rounded-full px-4 py-2">Cari</button>
</form>

<div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-amber-50/60 text-stone-500">
            <tr class="text-left">
                <th class="px-4 py-3">Invoice</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Item</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr class="border-t border-amber-50">
                    <td class="px-4 py-3 font-medium">{{ $order->invoice_no }}</td>
                    <td class="px-4 py-3">{{ $order->user->name }}</td>
                    <td class="px-4 py-3">{{ $order->items_count }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                    <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-amber-700 font-medium hover:underline">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
