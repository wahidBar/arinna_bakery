@extends('layouts.admin')

@section('title', 'Slider Hero Beranda')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="materio-card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-slideshow-3-line text-[#8C57FF] text-2xl"></i> Slider Hero Beranda
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Kelola banner promosi dan hero carousel pada beranda toko</p>
            </div>
            <a href="{{ route('admin.settings.sliders.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/30 hover:opacity-95 transition">
                <i class="ri-add-line text-lg"></i> Tambah Slider
            </a>
        </div>
    </div>

    {{-- Sliders Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($sliders as $slider)
            <div class="materio-card overflow-hidden flex flex-col justify-between group">
                <div>
                    {{-- Banner Preview --}}
                    <div class="h-44 bg-stone-100 dark:bg-stone-800 relative overflow-hidden">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[11px] font-bold {{ $slider->is_active ? 'bg-emerald-500 text-white shadow-md' : 'bg-stone-700 text-stone-200' }}">
                            {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-mono font-bold bg-black/60 text-white backdrop-blur-sm">
                            Urutan: {{ $slider->sort_order }}
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        <h2 class="font-bold text-[16px] text-[#2E263D] dark:text-[#EAEAFF] truncate">
                            {{ $slider->title ?? '(Tanpa Judul)' }}
                        </h2>
                        @if($slider->subtitle)
                            <p class="text-[13px] text-stone-400 line-clamp-2 leading-relaxed">{{ $slider->subtitle }}</p>
                        @endif
                        @if($slider->link)
                            <p class="text-[12px] font-mono text-[#8C57FF] truncate">
                                <i class="ri-link text-[13px] mr-1"></i> {{ $slider->link }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Action Bar --}}
                <div class="p-4 border-t border-black/5 dark:border-white/5 bg-black/[0.01] dark:bg-white/[0.01] flex items-center justify-between">
                    <a href="{{ route('admin.settings.sliders.edit', $slider) }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-[13px] font-semibold text-[#8C57FF] hover:bg-[#8C57FF]/10 transition">
                        <i class="ri-edit-box-line"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.settings.sliders.destroy', $slider) }}" onsubmit="return confirm('Hapus slider ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-[13px] font-semibold text-rose-500 hover:bg-rose-500/10 transition">
                            <i class="ri-delete-bin-line"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-3 materio-card p-16 text-center text-stone-400 text-[14px]">
                <i class="ri-slideshow-line text-5xl block mb-2 text-stone-300"></i>
                Belum ada banner slider yang ditambahkan.
            </div>
        @endforelse
    </div>

</div>
@endsection
