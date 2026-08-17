@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.categories.create') }}" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-5 py-2.5 hover:bg-amber-800 shadow-sm transition">
        + Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-amber-50/60 text-stone-500">
            <tr class="text-left">
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Induk</th>
                <th class="px-4 py-3">Jumlah Produk</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="border-t border-amber-50">
                    <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                    <td class="px-4 py-3">{{ $category->parent->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $category->products_count }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-1 rounded-full {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-amber-700 font-medium hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
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

<div class="mt-6">{{ $categories->links() }}</div>
@endsection
