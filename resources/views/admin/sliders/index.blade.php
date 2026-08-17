@extends('layouts.admin')

@section('title', 'Kelola Slider Home')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.settings.sliders.create') }}" class="bg-amber-700 text-white text-sm font-semibold rounded-full px-5 py-2.5 hover:bg-amber-800 shadow-sm transition">
        + Tambah Slider
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach ($sliders as $slider)
        <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
            <img src="{{ asset('storage/' . $slider->image) }}" class="w-full h-40 object-cover">
            <div class="p-4">
                <p class="font-medium text-sm mb-1">{{ $slider->title ?: '(Tanpa judul)' }}</p>
                <span class="text-xs px-2 py-1 rounded-full {{ $slider->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                    {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <div class="flex gap-3 mt-3">
                    <a href="{{ route('admin.settings.sliders.edit', $slider) }}" class="text-xs text-amber-700 font-medium hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.settings.sliders.destroy', $slider) }}" onsubmit="return confirm('Hapus slider ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-rose-600 font-medium hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
