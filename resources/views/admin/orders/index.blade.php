@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="space-y-6">

    {{-- Page Header & Toolbar Card --}}
    <div class="materio-card p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-shopping-bag-3-line text-[#8C57FF] text-2xl"></i> Manajemen Pesanan
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Pantau status transaksi, pembayaran, dan pengiriman pesanan pelanggan</p>
            </div>

            <form method="GET" class="flex flex-wrap items-center gap-2.5">
                {{-- Search Invoice --}}
                <div class="relative w-full sm:w-64">
                    <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice atau nama..."
                           class="w-full pl-10 pr-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                </div>

                {{-- Status Filter --}}
                <select name="status" class="px-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                    <option value="">Semua Status</option>
                    @foreach (['pending' => 'Pending (Menunggu)', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-black/5 dark:bg-white/10 hover:bg-[#8C57FF] hover:text-white text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] transition">
                    Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.orders.index') }}" class="p-2.5 rounded-xl text-[14px] text-rose-500 hover:bg-rose-500/10" title="Reset Filter">
                        <i class="ri-refresh-line text-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Orders Data Table Card --}}
    <div class="materio-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-b border-black/5 dark:border-white/5">
                        <th class="py-4 px-6">Invoice</th>
                        <th class="py-4 px-4">Customer</th>
                        <th class="py-4 px-4 text-center">Items</th>
                        <th class="py-4 px-4">Total</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4">Tanggal</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                            {{-- Invoice --}}
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-[14px] text-[#8C57FF] hover:underline flex items-center gap-1.5">
                                    <i class="ri-file-text-line"></i> {{ $order->invoice_no }}
                                </a>
                            </td>

                            {{-- Customer --}}
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#8C57FF]/10 text-[#8C57FF] font-bold text-[13px] flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] truncate max-w-[160px]">
                                            {{ $order->user->name ?? 'Pelanggan' }}
                                        </p>
                                        <p class="text-[12px] text-stone-400 truncate max-w-[160px]">{{ $order->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Items Count --}}
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[28px] px-2.5 py-1 rounded-full text-[13px] font-bold bg-black/[0.04] dark:bg-white/[0.05] text-[#2E263D] dark:text-[#EAEAFF]">
                                    {{ $order->items_count }} item
                                </span>
                            </td>

                            {{-- Total --}}
                            <td class="py-4 px-4">
                                <span class="font-bold text-[14px] text-[#2E263D] dark:text-[#EAEAFF]">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="py-4 px-4">
                                @php
                                    $statusClass = match(strtolower($order->status)) {
                                        'selesai', 'paid' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                                        'diproses', 'dikirim' => 'bg-[#8C57FF]/10 text-[#8C57FF] border-[#8C57FF]/20',
                                        'pending' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
                                        'dibatalkan' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20',
                                        default => 'bg-stone-100 text-stone-600 border-stone-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase border {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $order->status }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="py-4 px-4 text-[13px] text-stone-400">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-[13px] font-semibold text-[#8C57FF] hover:bg-[#8C57FF]/10 transition">
                                    <i class="ri-eye-line text-base"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-stone-400 text-[14px]">
                                <i class="ri-shopping-cart-line text-5xl block mb-2 text-stone-300"></i>
                                Tidak ada data pesanan yang sesuai filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-black/5 dark:border-white/5">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
