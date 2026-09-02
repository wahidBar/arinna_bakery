@extends('layouts.admin')

@section('title', 'Dashboard Analytics')

@section('content')
<div class="space-y-6">

    {{-- TOP ROW: Congratulations Hero Banner + Top Mini Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        {{-- Congratulations Welcome Card --}}
        <div class="md:col-span-8 materio-card relative overflow-hidden p-6 sm:p-8 flex flex-col justify-between">
            <div class="relative z-10 max-w-lg space-y-3.5">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-[12px] font-bold bg-[#8C57FF]/10 text-[#8C57FF] dark:bg-[#8C57FF]/20">
                    <i class="ri-sparkling-fill"></i> Bakery Executive Dashboard
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-[#2E263D] dark:text-[#EAEAFF] leading-tight">
                    Selamat Datang, <span class="text-[#8C57FF]">{{ auth()->user()->name ?? 'Admin' }}</span>! 🎉
                </h1>
                <p class="text-[14px] text-[#6B6678] dark:text-[#A5A3AE] leading-relaxed">
                    Operasional toko Arinna Bakery berjalan optimal hari ini. Terdapat <span class="font-bold text-[#8C57FF]">{{ $stats['orders_today'] }} pesanan baru</span> yang siap diproses dan dikirim ke pelanggan.
                </p>
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.orders.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 hover:shadow-lg transition">
                        <i class="ri-shopping-bag-3-line text-lg"></i> Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.products.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-[#8C57FF]/30 text-[#8C57FF] hover:bg-[#8C57FF]/10 text-[14px] font-semibold transition">
                        <i class="ri-add-line text-lg"></i> Tambah Produk
                    </a>
                </div>
            </div>

            {{-- Decorative Bakery Art / Trophy --}}
            <div class="absolute -bottom-2 right-4 sm:right-8 opacity-20 sm:opacity-90 pointer-events-none">
                <div class="w-36 h-36 sm:w-48 sm:h-48 relative flex items-center justify-center">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-[#8C57FF]/20 to-amber-500/20 blur-xl"></div>
                    <i class="ri-cake-3-line text-8xl sm:text-9xl text-[#8C57FF]/40 dark:text-[#8C57FF]/30"></i>
                </div>
            </div>
        </div>

        {{-- Mini Stat Cards (Revenue & Transactions) --}}
        <div class="md:col-span-4 flex flex-col gap-6">
            {{-- Revenue Today Card --}}
            <div class="materio-card p-6 flex-1 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-2xl">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[12px] font-bold px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                        <i class="ri-arrow-up-line"></i> Hari Ini
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-[13px] font-medium text-[#6B6678] dark:text-[#A5A3AE]">Pendapatan Hari Ini</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-[#2E263D] dark:text-[#EAEAFF] mt-1">
                        Rp {{ number_format($revenue['today'], 0, ',', '.') }}
                    </h3>
                    <p class="text-[12px] text-stone-400 mt-1">Total omzet terverifikasi hari ini</p>
                </div>
            </div>

            {{-- Transactions Today Card --}}
            <div class="materio-card p-6 flex-1 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-[#16B1FF]/10 text-[#16B1FF] flex items-center justify-center text-2xl">
                        <i class="ri-shopping-cart-2-line"></i>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[12px] font-bold px-3 py-1 rounded-full bg-[#16B1FF]/10 text-[#16B1FF]">
                        <i class="ri-time-line"></i> Bulan Ini
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-[13px] font-medium text-[#6B6678] dark:text-[#A5A3AE]">Pesanan Masuk</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-[#2E263D] dark:text-[#EAEAFF] mt-1">
                        {{ number_format($stats['orders_this_month']) }} <span class="text-[15px] font-normal text-stone-400">Order</span>
                    </h3>
                    <p class="text-[12px] text-stone-400 mt-1">{{ $stats['orders_today'] }} pesanan baru masuk hari ini</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 4 KEY METRICS CARDS ROW --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Products --}}
        <div class="materio-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-2xl shrink-0">
                <i class="ri-cake-3-line"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-medium text-[#6B6678] dark:text-[#A5A3AE]">Total Produk</p>
                <h4 class="text-2xl font-bold text-[#2E263D] dark:text-[#EAEAFF] mt-0.5">{{ $stats['total_products'] }}</h4>
                <a href="{{ route('admin.products.index') }}" class="text-[12px] font-semibold text-[#8C57FF] hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        {{-- Total Categories --}}
        <div class="materio-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-folder-5-line"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-medium text-[#6B6678] dark:text-[#A5A3AE]">Total Kategori</p>
                <h4 class="text-2xl font-bold text-[#2E263D] dark:text-[#EAEAFF] mt-0.5">{{ $stats['total_categories'] }}</h4>
                <a href="{{ route('admin.categories.index') }}" class="text-[12px] font-semibold text-amber-600 dark:text-amber-400 hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        {{-- Total Customers --}}
        <div class="materio-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#16B1FF]/10 text-[#16B1FF] flex items-center justify-center text-2xl shrink-0">
                <i class="ri-group-line"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-medium text-[#6B6678] dark:text-[#A5A3AE]">Total Customer</p>
                <h4 class="text-2xl font-bold text-[#2E263D] dark:text-[#EAEAFF] mt-0.5">{{ $stats['total_customers'] }}</h4>
                <a href="{{ route('admin.users.index') }}" class="text-[12px] font-semibold text-[#16B1FF] hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        {{-- Orders Today --}}
        <div class="materio-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-shopping-cart-line"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-medium text-[#6B6678] dark:text-[#A5A3AE]">Pesanan Hari Ini</p>
                <h4 class="text-2xl font-bold text-[#2E263D] dark:text-[#EAEAFF] mt-0.5">{{ $stats['orders_today'] }}</h4>
                <a href="{{ route('admin.orders.index') }}" class="text-[12px] font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">Lihat &rarr;</a>
            </div>
        </div>
    </div>

    {{-- CHARTS & REVENUE BREAKDOWN ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Monthly Sales Chart (8-col) --}}
        <div class="lg:col-span-8 materio-card p-6 flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                <div>
                    <h2 class="font-bold text-[17px] text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                        <i class="ri-line-chart-line text-[#8C57FF]"></i> Analisis Omzet Penjualan
                    </h2>
                    <p class="text-[13px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Tren omzet pendapatan per bulan (12 bulan terakhir)</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-[12px] font-semibold px-3 py-1 rounded-lg bg-[#8C57FF]/10 text-[#8C57FF]">
                        <span class="w-2 h-2 rounded-full bg-[#8C57FF]"></span> Omzet Lunas
                    </span>
                </div>
            </div>

            <div class="w-full relative h-[300px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Revenue Summary Card (4-col) --}}
        <div class="lg:col-span-4 materio-card p-6 flex flex-col justify-between space-y-5">
            <div>
                <h2 class="font-bold text-[17px] text-[#2E263D] dark:text-[#EAEAFF]">Ringkasan Pendapatan</h2>
                <p class="text-[13px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Total omzet terverifikasi periode berjalan</p>
            </div>

            <div class="space-y-4">
                {{-- Bulan Ini --}}
                <div class="flex items-center gap-4 p-3.5 rounded-xl bg-black/[0.02] dark:bg-white/[0.03]">
                    <div class="w-11 h-11 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-2xl shrink-0">
                        <i class="ri-calendar-event-line"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-medium text-stone-500">Pendapatan Bulan Ini</p>
                        <p class="text-[17px] font-bold text-[#2E263D] dark:text-[#EAEAFF] truncate">
                            Rp {{ number_format($revenue['this_month'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Minggu Ini --}}
                <div class="flex items-center gap-4 p-3.5 rounded-xl bg-black/[0.02] dark:bg-white/[0.03]">
                    <div class="w-11 h-11 rounded-xl bg-[#16B1FF]/10 text-[#16B1FF] flex items-center justify-center text-2xl shrink-0">
                        <i class="ri-pie-chart-line"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-medium text-stone-500">Pendapatan Minggu Ini</p>
                        <p class="text-[17px] font-bold text-[#2E263D] dark:text-[#EAEAFF] truncate">
                            Rp {{ number_format($revenue['this_week'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Hari Ini --}}
                <div class="flex items-center gap-4 p-3.5 rounded-xl bg-black/[0.02] dark:bg-white/[0.03]">
                    <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-2xl shrink-0">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] font-medium text-stone-500">Pendapatan Hari Ini</p>
                        <p class="text-[17px] font-bold text-[#2E263D] dark:text-[#EAEAFF] truncate">
                            Rp {{ number_format($revenue['today'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}"
               class="w-full py-2.5 rounded-xl bg-[#8C57FF]/10 hover:bg-[#8C57FF] text-[#8C57FF] hover:text-white font-semibold text-[13px] transition text-center flex items-center justify-center gap-2">
                <i class="ri-file-list-3-line text-base"></i> Laporan Lengkap Pesanan
            </a>
        </div>
    </div>

    {{-- BOTTOM ROW: Top Products & Recent Orders Table --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Top Selling Products (4-col) --}}
        <div class="lg:col-span-4 materio-card p-6 flex flex-col justify-between">
            <div>
                <h2 class="font-bold text-[17px] text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-trophy-line text-amber-500"></i> Produk Terlaris
                </h2>
                <p class="text-[13px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Top 5 produk paling banyak terjual</p>
            </div>

            <div class="my-4 space-y-3">
                @forelse ($topProducts as $index => $product)
                    <div class="flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-black/[0.02] dark:hover:bg-white/[0.02] transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg {{ $index === 0 ? 'bg-amber-500/20 text-amber-500 font-bold' : ($index === 1 ? 'bg-stone-300/30 text-stone-600 font-semibold' : ($index === 2 ? 'bg-amber-700/20 text-amber-700 font-semibold' : 'bg-black/5 dark:bg-white/5 text-stone-400')) }} flex items-center justify-center text-[13px] shrink-0">
                                #{{ $index + 1 }}
                            </div>
                            <span class="text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] truncate">{{ $product->name }}</span>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[12px] font-bold bg-[#8C57FF]/10 text-[#8C57FF] shrink-0">
                            {{ $product->sold_count }} terjual
                        </span>
                    </div>
                @empty
                    <p class="text-center text-[13px] text-stone-400 py-8">Belum ada data produk terjual.</p>
                @endforelse
            </div>

            <a href="{{ route('admin.products.index') }}" class="text-[13px] font-semibold text-[#8C57FF] hover:underline text-center block pt-2">
                Lihat Semua Katalog &rarr;
            </a>
        </div>

        {{-- Recent Orders Data Table (8-col) --}}
        <div class="lg:col-span-8 materio-card p-6 overflow-hidden">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-[17px] text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                        <i class="ri-history-line text-[#8C57FF]"></i> Pesanan Terbaru
                    </h2>
                    <p class="text-[13px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Transaksi pesanan pelanggan terbaru</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-[13px] font-semibold text-[#8C57FF] hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto -mx-6">
                <table class="w-full text-[14px]">
                    <thead>
                        <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-y border-black/5 dark:border-white/5">
                            <th class="py-3 px-6">Invoice</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-6 text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                                <td class="py-3.5 px-6">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-[14px] text-[#8C57FF] hover:underline flex items-center gap-1.5">
                                        <i class="ri-file-text-line"></i> {{ $order->invoice_no }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-[#8C57FF]/10 text-[#8C57FF] font-bold text-[13px] flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                                        </div>
                                        <span class="text-[14px] font-medium text-[#2E263D] dark:text-[#EAEAFF] truncate max-w-[150px]">
                                            {{ $order->user->name ?? 'Pelanggan' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[14px] text-[#2E263D] dark:text-[#EAEAFF]">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @php
                                        $statusClass = match(strtolower($order->status)) {
                                            'selesai', 'paid' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                                             'diproses', 'dikirim' => 'bg-[#8C57FF]/10 text-[#8C57FF] border-[#8C57FF]/20',
                                            'pending' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
                                            'dibatalkan' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20',
                                            default => 'bg-stone-100 text-stone-600 border-stone-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase border {{ $statusClass }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right text-[13px] text-stone-400">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-[13px] text-stone-400">
                                    Belum ada pesanan terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    const labels = {!! json_encode($salesChart->keys()) !!};
    const dataValues = {!! json_encode($salesChart->values()) !!};

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(140, 87, 255, 0.35)');
    gradient.addColorStop(1, 'rgba(140, 87, 255, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Omzet (Rp)',
                data: dataValues,
                borderColor: '#8C57FF',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8C57FF',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(49, 45, 75, 0.95)',
                    titleFont: { family: 'Public Sans', size: 13, weight: 'bold' },
                    bodyFont: { family: 'Public Sans', size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return ' Omzet: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(140, 87, 255, 0.06)',
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#A5A3AE',
                        font: { family: 'Public Sans', size: 12 },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'Jt';
                            if (value >= 1000) return 'Rp ' + (value / 1000) + 'k';
                            return 'Rp ' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#A5A3AE',
                        font: { family: 'Public Sans', size: 12 }
                    }
                }
            }
        },
    });
});
</script>
@endpush
