@extends('layouts.admin')

@section('title', 'Katalog Produk')

@section('content')
<div class="space-y-6">

    {{-- Page Header & Toolbar Card --}}
    <div class="materio-card p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-cake-3-line text-[#8C57FF] text-2xl"></i> Katalog & Stok Produk
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Kelola seluruh varian menu roti, kue kering, pastry, dan ketersediaan stok toko</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" class="flex flex-wrap items-center gap-2.5 flex-1 sm:flex-initial">
                    {{-- Search Input --}}
                    <div class="relative flex-1 sm:w-64">
                        <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk / SKU..."
                               class="w-full pl-10 pr-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                    </div>

                    {{-- Category Filter --}}
                    <select name="category" class="px-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-black/5 dark:bg-white/10 hover:bg-[#8C57FF] hover:text-white text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] transition">
                        Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.products.index') }}" class="p-2.5 rounded-xl text-[14px] text-rose-500 hover:bg-rose-500/10" title="Reset Filter">
                            <i class="ri-refresh-line text-lg"></i>
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/30 hover:opacity-95 transition">
                    <i class="ri-add-line text-lg"></i> Tambah Produk
                </a>
            </div>
        </div>
    </div>

    {{-- Products Data Table Card --}}
    <div class="materio-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-b border-black/5 dark:border-white/5">
                        <th class="py-4 px-6">Produk</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4">Harga</th>
                        <th class="py-4 px-4 text-center">Stok</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse ($products as $product)
                        <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                            {{-- Product Image + Name + SKU --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl border border-black/5 dark:border-white/10 overflow-hidden shrink-0 bg-stone-100 dark:bg-stone-800">
                                        <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : asset('images/placeholder.jpg') }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="font-bold text-[15px] text-[#2E263D] dark:text-[#EAEAFF] hover:text-[#8C57FF] transition block truncate max-w-sm">
                                            {{ $product->name }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[12px] font-mono text-stone-400">SKU: {{ $product->sku }}</span>
                                            @if($product->is_featured)
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-500">Featured</span>
                                            @endif
                                            @if($product->is_flashsale)
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-500">Sale</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[13px] font-medium bg-black/[0.03] dark:bg-white/[0.05] text-[#2E263D] dark:text-[#EAEAFF]">
                                    <i class="ri-folder-line text-[13px] text-[#8C57FF]"></i>
                                    {{ $product->category->name ?? '—' }}
                                </span>
                            </td>

                            {{-- Price & Discount --}}
                            <td class="py-4 px-4">
                                <div class="font-bold text-[14px] text-[#2E263D] dark:text-[#EAEAFF]">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                @if($product->discount_price && $product->discount_price < $product->price)
                                    <div class="text-[12px] text-emerald-600 dark:text-emerald-400 font-semibold line-through">
                                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>

                            {{-- Stock --}}
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[32px] px-2.5 py-1 rounded-full text-[13px] font-bold {{ $product->stock > 5 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($product->stock > 0 ? 'bg-amber-500/10 text-amber-600' : 'bg-rose-500/10 text-rose-600') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold {{ $product->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-stone-500/10 text-stone-500' }}">
                                    <span class="w-2 h-2 rounded-full {{ $product->is_active ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="w-9 h-9 rounded-xl flex items-center justify-center text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
                                       title="Edit Produk"
                                    >
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="w-9 h-9 rounded-xl flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition"
                                                title="Hapus Produk"
                                        >
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-stone-400 text-[14px]">
                                <i class="ri-inbox-line text-5xl block mb-2 text-stone-300"></i>
                                Tidak ada data produk yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-black/5 dark:border-white/5">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
