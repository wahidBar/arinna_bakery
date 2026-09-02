@extends('layouts.admin')

@section('title', 'Profil Pengguna: ' . $user->name)

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-user-3-line text-[#8C57FF] text-2xl"></i> Detail Profil Pengguna
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Informasi akun pengguna dan riwayat transaksi pesanan</p>
        </div>
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    {{-- User Profile Card --}}
    <div class="materio-card p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#8C57FF] to-[#9E77FF] text-white font-bold text-2xl flex items-center justify-center shadow-md shadow-[#8C57FF]/30 shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">{{ $user->name }}</h2>
                    <p class="text-[13px] text-stone-400 mt-0.5 flex items-center gap-2">
                        <i class="ri-mail-line"></i> {{ $user->email }}
                        @if($user->phone)
                            <span>&middot;</span>
                            <i class="ri-phone-line"></i> {{ $user->phone }}
                        @endif
                    </p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[11px] font-bold bg-[#8C57FF]/10 text-[#8C57FF]">
                                <i class="ri-shield-star-line"></i> Administrator
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[11px] font-semibold bg-[#16B1FF]/10 text-[#16B1FF]">
                                <i class="ri-user-line"></i> Customer
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[11px] font-semibold {{ $user->is_active ? 'bg-emerald-500/10 text-emerald-600' : 'bg-stone-500/10 text-stone-500' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="px-5 py-2.5 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] hover:bg-[#8C57FF] hover:text-white text-[14px] font-semibold transition flex items-center gap-2">
                    <i class="ri-edit-box-line text-base"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    {{-- Order History Table Card --}}
    <div class="materio-card overflow-hidden">
        <div class="px-6 py-4 border-b border-black/5 dark:border-white/5 flex items-center justify-between">
            <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-history-line text-[#8C57FF]"></i> Riwayat Transaksi Pesanan
            </h2>
            <span class="text-[13px] text-stone-400 font-semibold">{{ $orders->total() }} Pesanan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-b border-black/5 dark:border-white/5">
                        <th class="py-4 px-6">Invoice</th>
                        <th class="py-4 px-4">Total</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-6 text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-[14px] text-[#8C57FF] hover:underline flex items-center gap-1.5">
                                    <i class="ri-file-text-line"></i> {{ $order->invoice_no }}
                                </a>
                            </td>
                            <td class="py-4 px-4 font-bold text-[14px] text-[#2E263D] dark:text-[#EAEAFF]">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase border {{ $statusClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right text-[13px] text-stone-400">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-stone-400 text-[14px]">
                                Pengguna ini belum memiliki riwayat pesanan.
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
