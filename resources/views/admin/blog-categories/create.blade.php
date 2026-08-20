@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<form method="POST" action="{{ route('admin.settings.blog-categories.store') }}" enctype="multipart/form-data" class="max-w-lg bg-white rounded-2xl border border-amber-100 shadow-sm p-6 space-y-4">
    @csrf

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" required>
        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Slug (kosongkan untuk auto)</label>
        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Sub-kategori dari (opsional)</label>
        <select name="parent_id" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            <option value="">-- Kategori Utama --</option>
            @foreach ($parentCategories as $parent)
                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Icon (opsional)</label>
        <input type="file" name="icon" accept="image/*" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Urutan Tampil</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked> Aktif</label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition">Simpan</button>
        <a href="{{ route('admin.settings.blog-categories.index') }}" class="text-sm text-stone-500 self-center">Batal</a>
    </div>
</form>
@endsection
