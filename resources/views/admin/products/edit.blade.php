@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-4xl">

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Edit Produk</h1>
            <p class="text-sm text-stone-500 mt-0.5">{{ $product->name }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-stone-500 hover:text-stone-700 flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-4 py-3 text-sm">
        <p class="font-semibold mb-1">Periksa kembali isian berikut:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="product-form">
        @csrf
        @method('PUT')

        <div class="space-y-5 pb-28">

            {{-- SECTION: Informasi Dasar --}}
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm">
                <div class="px-6 py-4 border-b border-amber-50">
                    <h2 class="text-sm font-bold text-stone-800">Informasi Dasar</h2>
                    <p class="text-xs text-stone-400 mt-0.5">Nama, kategori, dan identitas produk.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Nama Produk <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('name') border-rose-300 @enderror"
                            required>
                        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">
                                Slug
                                <span class="text-stone-400 font-normal">(URL produk)</span>
                            </label>
                            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                                class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">SKU <span class="text-rose-500">*</span></label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('sku') border-rose-300 @enderror"
                                required>
                            @error('sku') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select name="category_id"
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('category_id') border-rose-300 @enderror"
                            required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- SECTION: Harga & Stok --}}
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm">
                <div class="px-6 py-4 border-b border-amber-50">
                    <h2 class="text-sm font-bold text-stone-800">Harga & Stok</h2>
                    <p class="text-xs text-stone-400 mt-0.5">Atur harga jual dan ketersediaan produk.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">Harga Normal <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-stone-400 pointer-events-none select-none">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0"
                                    class="w-full border border-amber-100 rounded-xl pl-10 pr-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none @error('price') border-rose-300 @enderror"
                                    required>
                            </div>
                            @error('price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">
                                Harga Diskon
                                <span class="text-stone-400 font-normal">(opsional)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-stone-400">Rp</span>
                                <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0"
                                    class="w-full border border-amber-100 rounded-xl pl-9 pr-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('discount_price') border-rose-300 @enderror">
                            </div>
                            @error('discount_price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">Stok <span class="text-rose-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                                class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('stock') border-rose-300 @enderror"
                                required>
                            @error('stock') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Berat / Satuan</label>
                        <input type="text" name="weight" value="{{ old('weight', $product->weight) }}" placeholder="contoh: 250 gram, 1 pack"
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    </div>
                </div>
            </div>

            {{-- SECTION: Deskripsi --}}
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm">
                <div class="px-6 py-4 border-b border-amber-50">
                    <h2 class="text-sm font-bold text-stone-800">Deskripsi Produk</h2>
                    <p class="text-xs text-stone-400 mt-0.5">Jelaskan produk secara singkat dan menarik.</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">
                            Informasi Tambahan
                            <span class="text-stone-400 font-normal">(komposisi / varian)</span>
                        </label>
                        <textarea name="information" rows="3"
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ old('information', $product->information) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SECTION: Media --}}
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm">
                <div class="px-6 py-4 border-b border-amber-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-stone-800">Foto Produk</h2>
                        <p class="text-xs text-stone-400 mt-0.5">Kelola foto yang sudah ada, atau tambahkan foto baru.</p>
                    </div>
                    <span class="text-xs font-medium text-stone-400">{{ $product->images->count() }} foto</span>
                </div>

                <div class="p-6">
                    {{-- Gambar existing --}}
                    @if ($product->images->count())
                    <div class="grid grid-cols-4 gap-3 mb-5">
                        @foreach ($product->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                class="w-full h-24 object-cover rounded-lg border-2 {{ $image->is_primary ? 'border-amber-600' : 'border-transparent' }}">

                            @if ($image->is_primary)
                            <span class="absolute top-1.5 left-1.5 text-[10px] font-semibold bg-amber-600 text-white px-2 py-0.5 rounded-full">★ Utama</span>
                            @endif

                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent rounded-b-lg p-1.5 flex items-center justify-between opacity-0 group-hover:opacity-100 transition">
                                <label class="flex items-center gap-1 text-[11px] text-white cursor-pointer">
                                    <input type="radio" name="primary_image_id" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }} class="accent-amber-500">
                                    Utama
                                </label>
                                <label class="flex items-center gap-1 text-[11px] text-rose-300 cursor-pointer">
                                    <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}" class="accent-rose-500">
                                    Hapus
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-stone-400 mb-5">Belum ada foto untuk produk ini.</p>
                    @endif

                    {{-- Upload baru --}}
                    <label for="image-input"
                        id="dropzone"
                        class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-amber-200 rounded-xl py-8 cursor-pointer hover:border-amber-400 hover:bg-amber-50/50 transition">
                        <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-stone-600"><span class="font-semibold text-amber-700">Tambah foto baru</span> — klik atau drag & drop</p>
                        <p class="text-xs text-stone-400">PNG, JPG, WEBP — opsional</p>
                    </label>
                    <input type="file" name="images[]" id="image-input" accept="image/*" multiple class="hidden">
                    @error('images') <p class="text-xs text-rose-600 mt-2">{{ $message }}</p> @enderror

                    <div id="image-preview" class="grid grid-cols-4 gap-3 mt-4"></div>
                </div>
            </div>

            {{-- SECTION: Status --}}
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm">
                <div class="px-6 py-4 border-b border-amber-50">
                    <h2 class="text-sm font-bold text-stone-800">Status Produk</h2>
                    <p class="text-xs text-stone-400 mt-0.5">Atur visibilitas dan label produk di toko.</p>
                </div>
                <div class="p-6 grid grid-cols-4 gap-4">
                    <label class="flex items-center justify-between gap-3 border border-amber-100 rounded-xl px-4 py-3 cursor-pointer hover:bg-amber-50/40 transition">
                        <div>
                            <span class="text-sm font-semibold text-stone-700 block">Aktif</span>
                            <span class="text-xs text-stone-400">Tampil di toko</span>
                        </div>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded accent-amber-600">
                    </label>

                    <label class="flex items-center justify-between gap-3 border border-amber-100 rounded-xl px-4 py-3 cursor-pointer hover:bg-amber-50/40 transition">
                        <div>
                            <span class="text-sm font-semibold text-stone-700 block">Featured</span>
                            <span class="text-xs text-stone-400">Tampil di beranda</span>
                        </div>
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 rounded accent-amber-600">
                    </label>

                    <label class="flex items-center justify-between gap-3 border border-amber-100 rounded-xl px-4 py-3 cursor-pointer hover:bg-amber-50/40 transition">
                        <div>
                            <span class="text-sm font-semibold text-stone-700 block">Produk Baru</span>
                            <span class="text-xs text-stone-400">Beri label "New"</span>
                        </div>
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new ?? false) ? 'checked' : '' }} class="w-5 h-5 rounded accent-amber-600">
                    </label>

                    <label class="flex items-center justify-between gap-3 border border-amber-100 rounded-xl px-4 py-3 cursor-pointer hover:bg-amber-50/40 transition">
                        <div>
                            <span class="text-sm font-semibold text-stone-700 block">Flash Sale</span>
                            <span class="text-xs text-stone-400">Tampil di deal hari ini</span>
                        </div>
                        <input type="checkbox" name="is_flashsale" id="is_flashsale" value="1"
                            {{ old('is_flashsale', $product->is_flashsale ?? false) ? 'checked' : '' }}
                            class="w-5 h-5 rounded accent-amber-600">
                    </label>
                </div>
                <div id="flashsale-date-wrapper" class="p-6 pt-0 {{ old('is_flashsale', $product->is_flashsale ?? false) ? '' : 'hidden' }}">
                    <label class="text-sm font-semibold text-stone-700 block mb-1.5">Berakhir Pada</label>
                    <input type="datetime-local" name="flashsale_ends_at"
                        value="{{ old('flashsale_ends_at', optional($product->flashsale_ends_at ?? null)->format('Y-m-d\TH:i')) }}"
                        class="w-full max-w-xs border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('flashsale_ends_at') border-rose-300 @enderror">
                    @error('flashsale_ends_at') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-stone-400 mt-1">Kosongkan jika flash sale tidak punya batas waktu.</p>
                </div>
            </div>

        </div>

        {{-- Sticky action bar --}}
        <div class="fixed bottom-0 left-0 right-0 lg:left-64 bg-white/95 backdrop-blur border-t border-amber-100 px-6 py-4 flex items-center justify-between z-20">
            <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-stone-500 hover:text-stone-700">Batal</a>
            <div class="flex items-center gap-3">
                <span class="text-xs text-stone-400">Perubahan disimpan langsung setelah klik simpan.</span>
                <button type="submit"
                    class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Preview gambar baru + drag & drop
    const imageInput = document.getElementById('image-input');
    const dropzone = document.getElementById('dropzone');
    const preview = document.getElementById('image-preview');

    function renderPreview(files) {
        preview.innerHTML = '';
        Array.from(files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative';
                wrapper.innerHTML = `
                    <img src="${evt.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-emerald-400">
                    <span class="absolute top-1.5 left-1.5 text-[10px] font-semibold bg-emerald-600 text-white px-2 py-0.5 rounded-full">Baru</span>
                `;
                preview.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    imageInput.addEventListener('change', (e) => renderPreview(e.target.files));

    ['dragover', 'dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => e.preventDefault());
    });
    dropzone.addEventListener('dragover', () => dropzone.classList.add('border-amber-400', 'bg-amber-50/50'));
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-amber-400', 'bg-amber-50/50'));
    dropzone.addEventListener('drop', (e) => {
        dropzone.classList.remove('border-amber-400', 'bg-amber-50/50');
        imageInput.files = e.dataTransfer.files;
        renderPreview(e.dataTransfer.files);
    });

    // Konfirmasi kalau ada gambar yang ditandai hapus
    document.getElementById('product-form').addEventListener('submit', function(e) {
        const checkedDeletes = document.querySelectorAll('input[name="delete_image_ids[]"]:checked');
        if (checkedDeletes.length > 0) {
            const ok = confirm(`${checkedDeletes.length} foto akan dihapus permanen. Lanjutkan?`);
            if (!ok) {
                e.preventDefault();
                return;
            }
        }
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Menyimpan...
        `;
    });
</script>
@endpush