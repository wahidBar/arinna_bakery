@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-folder-add-line text-[#8C57FF] text-2xl"></i> Tambah Kategori Produk
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Buat kelompok kategori baru untuk katalog produk etalase</p>
        </div>
        <a href="{{ route('admin.categories.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <div class="materio-card p-5 sm:p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                    Nama Kategori <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="contoh: Roti Manis, Cake & Tart"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('name') border-rose-400 @enderror"
                       required>
                @error('name') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Slug URL <span class="text-stone-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="kosongkan untuk otomatis"
                           class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                </div>

                <div>
                    <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                        Sub-kategori dari <span class="text-stone-400 font-normal">(opsional)</span>
                    </label>
                    <select name="parent_id"
                            class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                        <option value="">-- Kategori Utama (Tanpa Induk) --</option>
                        @foreach ($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                    Icon / Foto Kategori <span class="text-stone-400 font-normal">(opsional)</span>
                </label>
                <input type="file" name="icon" accept="image/*"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2 text-[13px] text-stone-500 focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
            </div>

            <div>
                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-3 cursor-pointer text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF]">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded accent-[#8C57FF]">
                    Kategori Aktif & Tampil di Katalog Toko
                </label>
            </div>

            <div class="pt-4 border-t border-black/5 dark:border-white/5 flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                    <i class="ri-check-line text-base"></i> Simpan Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-medium text-stone-500 hover:text-stone-700 dark:hover:text-stone-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
