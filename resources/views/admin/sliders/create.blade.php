@extends('layouts.admin')

@section('title', 'Tambah Slider Baru')

@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-image-add-line text-[#8C57FF] text-2xl"></i> Tambah Banner Slider
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Unggah banner hero untuk promosi di beranda depan toko</p>
        </div>
        <a href="{{ route('admin.settings.sliders.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <div class="materio-card p-5 sm:p-6">
        <form method="POST" action="{{ route('admin.settings.sliders.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                    Gambar Banner <span class="text-rose-500">*</span>
                </label>
                <input type="file" name="image" accept="image/*"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[13px] text-stone-500 focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('image') border-rose-400 @enderror"
                       required>
                <p class="text-[12px] text-stone-400 mt-1">Disarankan gambar rasio lebar (misal 1920x800 px, maks 2MB)</p>
                @error('image') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                    Judul Banner <span class="text-stone-400 font-normal">(opsional)</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="contoh: Diskon Spesial Roti Manis Fresh From The Oven"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
            </div>

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                    Subjudul / Deskripsi Singkat <span class="text-stone-400 font-normal">(opsional)</span>
                </label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="contoh: Dibuat segar setiap pagi dengan butter wisman berkualitas"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Tautan / URL Tujuan <span class="text-stone-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="link" value="{{ old('link') }}" placeholder="/products"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-3 cursor-pointer text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF]">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded accent-[#8C57FF]">
                    Status Slider Aktif & Tampil di Beranda
                </label>
            </div>

            <div class="pt-4 border-t border-black/5 dark:border-white/5 flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                    <i class="ri-check-line text-base"></i> Simpan Slider
                </button>
                <a href="{{ route('admin.settings.sliders.index') }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-medium text-stone-500 hover:text-stone-700 dark:hover:text-stone-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
