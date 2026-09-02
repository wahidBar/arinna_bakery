@extends('layouts.admin')

@section('title', 'Detail Pesanan: ' . $order->invoice_no)

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-xl lg:text-2xl font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-file-list-3-line text-[#8C57FF] text-2xl"></i> Invoice #{{ $order->invoice_no }}
                </h1>
                @php
                    $statusClass = match(strtolower($order->status)) {
                        'selesai', 'paid' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                        'diproses', 'dikirim' => 'bg-[#8C57FF]/10 text-[#8C57FF] border-[#8C57FF]/20',
                        'pending' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
                        'dibatalkan' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20',
                        default => 'bg-stone-100 text-stone-600 border-stone-200'
                    };
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold uppercase border {{ $statusClass }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $order->status }}
                </span>
            </div>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-[14px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition self-start sm:self-auto">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT 8-COLS: Order Items & Customer Details --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Items Card --}}
            <div class="materio-card p-6 overflow-hidden">
                <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF] mb-4 flex items-center gap-2">
                    <i class="ri-shopping-bag-line text-[#8C57FF]"></i> Rincian Menu Pesanan
                </h2>

                <div class="overflow-x-auto -mx-6">
                    <table class="w-full text-[14px]">
                        <thead>
                            <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-y border-black/5 dark:border-white/5">
                                <th class="py-3 px-6">Item Produk</th>
                                <th class="py-3 px-4 text-center">Qty</th>
                                <th class="py-3 px-4 text-right">Harga Satuan</th>
                                <th class="py-3 px-6 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 dark:divide-white/5">
                            @foreach ($order->items as $item)
                                <tr class="hover:bg-[#8C57FF]/[0.02] transition">
                                    <td class="py-3.5 px-6 font-semibold text-[14px] text-[#2E263D] dark:text-[#EAEAFF]">
                                        {{ $item->product_name }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-[14px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-[14px] text-stone-500">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-6 text-right font-bold text-[14px] text-[#8C57FF]">
                                        Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Price Total Summary --}}
                <div class="mt-4 pt-4 border-t border-black/5 dark:border-white/5 flex items-center justify-between">
                    <span class="text-[13px] font-bold uppercase tracking-wider text-stone-400">Total Pembayaran</span>
                    <span class="text-2xl font-extrabold text-[#8C57FF]">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Customer & Shipping Details Card --}}
            <div class="materio-card p-6">
                <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF] mb-4 flex items-center gap-2">
                    <i class="ri-user-location-line text-[#8C57FF]"></i> Informasi Pengiriman & Pemesan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-[14px]">
                    {{-- Customer Account Info --}}
                    <div class="p-4 rounded-xl bg-black/[0.02] dark:bg-white/[0.02] border border-black/5 dark:border-white/5 space-y-2">
                        <span class="text-[11px] font-bold uppercase text-stone-400 block tracking-wider">Akun Pemesan</span>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#8C57FF]/10 text-[#8C57FF] font-bold text-sm flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-[#2E263D] dark:text-[#EAEAFF]">{{ $order->user->name ?? 'Pelanggan' }}</p>
                                <p class="text-[12px] text-stone-400">{{ $order->user->email ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Receiver Info --}}
                    <div class="p-4 rounded-xl bg-black/[0.02] dark:bg-white/[0.02] border border-black/5 dark:border-white/5 space-y-1.5">
                        <span class="text-[11px] font-bold uppercase text-stone-400 block tracking-wider">Penerima Paket</span>
                        <p class="font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-1.5">
                            <i class="ri-user-3-line text-[#8C57FF]"></i> {{ $order->shipping_name }}
                        </p>
                        <p class="text-stone-500 flex items-center gap-1.5 text-[13px]">
                            <i class="ri-phone-line text-[#8C57FF]"></i> {{ $order->shipping_phone }}
                        </p>
                    </div>

                    {{-- Address --}}
                    <div class="sm:col-span-2 p-4 rounded-xl bg-black/[0.02] dark:bg-white/[0.02] border border-black/5 dark:border-white/5 space-y-1">
                        <span class="text-[11px] font-bold uppercase text-stone-400 block tracking-wider">Alamat Pengiriman Lengkap</span>
                        <p class="text-[#2E263D] dark:text-[#EAEAFF] leading-relaxed">
                            <i class="ri-map-pin-line text-[#8C57FF] mr-1"></i> {{ $order->shipping_address }}
                        </p>
                    </div>

                    {{-- Notes --}}
                    @if ($order->notes)
                        <div class="sm:col-span-2 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 space-y-1">
                            <span class="text-[11px] font-bold uppercase text-amber-600 block tracking-wider">Catatan Tambahan Customer</span>
                            <p class="text-amber-800 dark:text-amber-300 italic">"{{ $order->notes }}"</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT 4-COLS: Status & Payment Update Widget --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Update Status Card --}}
            <div class="materio-card p-6 space-y-4">
                <h2 class="text-[15px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2 pb-3 border-b border-black/5 dark:border-white/5">
                    <i class="ri-refresh-line text-[#8C57FF]"></i> Update Status Pesanan
                </h2>

                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                            Ubah Status Saat Ini
                        </label>
                        <select name="status"
                                class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                            @foreach (['pending' => 'Pending (Menunggu)', 'diproses' => 'Diproses (Sedang Dibuat)', 'dikirim' => 'Dikirim (Dalam Perjalanan)', 'selesai' => 'Selesai (Pesanan Diterima)', 'dibatalkan' => 'Dibatalkan'] as $statusKey => $statusLabel)
                                <option value="{{ $statusKey }}" {{ $order->status === $statusKey ? 'selected' : '' }}>
                                    {{ $statusLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center justify-center gap-2">
                        <i class="ri-check-line text-base"></i> Simpan Status Baru
                    </button>
                </form>
            </div>

            {{-- Payment Information Card --}}
            <div class="materio-card p-6 space-y-4">
                <h2 class="text-[15px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2 pb-3 border-b border-black/5 dark:border-white/5">
                    <i class="ri-bank-card-line text-[#8C57FF]"></i> Metode Pembayaran
                </h2>

                <div class="space-y-3 text-[14px]">
                    <div class="flex justify-between items-center">
                        <span class="text-stone-400">Metode:</span>
                        <span class="font-bold text-[#2E263D] dark:text-[#EAEAFF] capitalize">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-stone-400">Status Bayar:</span>
                        <span class="px-3 py-0.5 rounded-full text-[11px] font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-500/10 text-emerald-600' : 'bg-amber-500/10 text-amber-600' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
