@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Card statistik --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
        <p class="text-xs text-stone-400 mb-1 font-medium">Total Produk</p>
        <p class="font-display text-2xl font-bold text-stone-900">{{ $stats['total_products'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
        <p class="text-xs text-stone-400 mb-1 font-medium">Total Kategori</p>
        <p class="font-display text-2xl font-bold text-stone-900">{{ $stats['total_categories'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
        <p class="text-xs text-stone-400 mb-1 font-medium">Total Customer</p>
        <p class="font-display text-2xl font-bold text-stone-900">{{ $stats['total_customers'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
        <p class="text-xs text-stone-400 mb-1 font-medium">Pesanan Hari Ini</p>
        <p class="font-display text-2xl font-bold text-stone-900">{{ $stats['orders_today'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
        <p class="text-xs text-stone-400 mb-1 font-medium">Pesanan Bulan Ini</p>
        <p class="font-display text-2xl font-bold text-stone-900">{{ $stats['orders_this_month'] }}</p>
    </div>
</div>

{{-- Card pendapatan --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-amber-700 text-white rounded-2xl shadow-sm p-5">
        <p class="text-xs opacity-80 mb-1 font-medium">Pendapatan Hari Ini</p>
        <p class="font-display text-xl font-bold">Rp {{ number_format($revenue['today'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-amber-800 text-white rounded-2xl shadow-sm p-5">
        <p class="text-xs opacity-80 mb-1 font-medium">Pendapatan Minggu Ini</p>
        <p class="font-display text-xl font-bold">Rp {{ number_format($revenue['this_week'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-stone-900 text-white rounded-2xl shadow-sm p-5">
        <p class="text-xs opacity-80 mb-1 font-medium">Pendapatan Bulan Ini</p>
        <p class="font-display text-xl font-bold">Rp {{ number_format($revenue['this_month'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- Grafik --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
        <h3 class="font-display font-semibold text-stone-900 mb-4">Omzet per Bulan</h3>
        <canvas id="salesChart" height="100"></canvas>
    </div>
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
        <h3 class="font-display font-semibold text-stone-900 mb-4">Produk Terlaris</h3>
        <canvas id="topProductsChart"></canvas>
    </div>
</div>

{{-- Tabel pesanan terbaru --}}
<div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-6">
    <h3 class="font-display font-semibold text-stone-900 mb-4">Pesanan Terbaru</h3>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-stone-400 border-b border-amber-100">
                <th class="pb-2.5 font-semibold">Invoice</th>
                <th class="pb-2.5 font-semibold">Customer</th>
                <th class="pb-2.5 font-semibold">Total</th>
                <th class="pb-2.5 font-semibold">Status</th>
                <th class="pb-2.5 font-semibold">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recentOrders as $order)
                <tr class="border-b border-amber-50">
                    <td class="py-2.5"><a href="{{ route('admin.orders.show', $order) }}" class="text-amber-700 font-medium hover:underline">{{ $order->invoice_no }}</a></td>
                    <td class="py-2.5">{{ $order->user->name }}</td>
                    <td class="py-2.5 font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="py-2.5 capitalize">
                        <span class="inline-block bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $order->status }}</span>
                    </td>
                    <td class="py-2.5 text-stone-500">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($salesChart->keys()) !!},
        datasets: [{
            label: 'Omzet',
            data: {!! json_encode($salesChart->values()) !!},
            borderColor: '#b45309',
            backgroundColor: 'rgba(180,83,9,0.1)',
            tension: 0.3,
            fill: true,
        }],
    },
    options: { plugins: { legend: { display: false } } },
});

new Chart(document.getElementById('topProductsChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($topProducts->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($topProducts->pluck('sold_count')) !!},
            backgroundColor: ['#b45309', '#d97706', '#f59e0b', '#fbbf24', '#fde68a'],
        }],
    },
});
</script>
@endpush
