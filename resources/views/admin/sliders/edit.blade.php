@extends('layouts.admin')

@section('title', 'Edit Slider')

@section('content')
<form method="POST" action="{{ route('admin.settings.sliders.update', $slider) }}" enctype="multipart/form-data" class="max-w-lg bg-white rounded-2xl border border-amber-100 shadow-sm p-6 space-y-4">
    @csrf
    @method('PUT')

    <img src="{{ asset('storage/' . $slider->image) }}" class="w-full h-32 object-cover rounded-lg">

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Ganti Gambar (opsional)</label>
        <input type="file" name="image" accept="image/*" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Judul</label>
        <input type="text" name="title" value="{{ old('title', $slider->title) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Subjudul</label>
        <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Link Tujuan</label>
        <input type="text" name="link" value="{{ old('link', $slider->link) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Urutan Tampil</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" class="w-full border border-amber-100 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }}> Aktif
    </label>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition">Simpan Perubahan</button>
        <a href="{{ route('admin.settings.sliders.index') }}" class="text-sm text-stone-500 self-center">Batal</a>
    </div>
</form>
@endsection
