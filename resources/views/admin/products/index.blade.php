@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
               class="border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 w-64">
        <select name="category" class="border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-stone-900 text-white text-sm font-semibold rounded-full px-4 py-2">Cari</button>
    </form>

    <a href="{{ route('admin.products.create') }}" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-5 py-2.5 hover:bg-amber-800 shadow-sm transition">
        + Tambah Produk
    </a>
</div>

<div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-amber-50/60 text-stone-500">
            <tr class="text-left">
                <th class="px-4 py-3">Gambar</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3">Stok</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border-t border-amber-50">
                    <td class="px-4 py-3">
                        <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : asset('images/placeholder.jpg') }}"
                             class="w-12 h-12 rounded-lg object-cover">
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                    <td class="px-4 py-3">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $product->stock }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded-full {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-amber-700 font-medium hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-600 font-medium hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
