@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-4xl">

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Tambah Produk</h1>
            <p class="text-sm text-stone-500 mt-0.5">Lengkapi detail produk baru untuk ditampilkan di toko.</p>
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

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="product-form">
        @csrf

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
                        <input type="text" name="name" id="name-input" value="{{ old('name') }}"
                            placeholder="contoh: Roti Sobek Coklat Keju"
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
                            <div class="relative">
                                <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}"
                                    placeholder="otomatis dari nama produk"
                                    class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                            </div>
                            <p class="text-xs text-stone-400 mt-1">Kosongkan agar dibuat otomatis dari nama produk.</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">SKU <span class="text-rose-500">*</span></label>
                            <input type="text" name="sku" value="{{ old('sku') }}"
                                placeholder="contoh: RTS-001"
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
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-stone-400">Rp</span>
                                <input type="number" name="price" value="{{ old('price') }}" min="0"
                                    class="w-full border border-amber-100 rounded-xl pl-9 pr-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('price') border-rose-300 @enderror"
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
                                <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0"
                                    class="w-full border border-amber-100 rounded-xl pl-9 pr-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('discount_price') border-rose-300 @enderror">
                            </div>
                            @error('discount_price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-stone-700 block mb-1.5">Stok <span class="text-rose-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                                class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 @error('stock') border-rose-300 @enderror"
                                required>
                            @error('stock') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">Berat / Satuan</label>
                        <input type="text" name="weight" value="{{ old('weight') }}" placeholder="contoh: 250 gram, 1 pack"
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
                        <textarea name="description" rows="4" placeholder="Ceritakan tentang produk ini..."
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-stone-700 block mb-1.5">
                            Informasi Tambahan
                            <span class="text-stone-400 font-normal">(komposisi / varian)</span>
                        </label>
                        <textarea name="information" rows="3" placeholder="contoh: Tepung terigu, gula, mentega, coklat..."
                            class="w-full border border-amber-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ old('information') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SECTION: Media --}}
            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm">
                <div class="px-6 py-4 border-b border-amber-50">
                    <h2 class="text-sm font-bold text-stone-800">Foto Produk</h2>
                    <p class="text-xs text-stone-400 mt-0.5">Unggah 1 atau lebih foto. Klik salah satu untuk jadikan foto utama.</p>
                </div>
                <div class="p-6">
                    <label for="image-input"
                        id="dropzone"
                        class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-amber-200 rounded-xl py-10 cursor-pointer hover:border-amber-400 hover:bg-amber-50/50 transition">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-stone-600"><span class="font-semibold text-amber-700">Klik untuk unggah</span> atau drag & drop</p>
                        <p class="text-xs text-stone-400">PNG, JPG, WEBP — bisa pilih lebih dari satu file</p>
                    </label>
                    <input type="file" name="images[]" id="image-input" accept="image/*" multiple class="hidden">
                    @error('images') <p class="text-xs text-rose-600 mt-2">{{ $message }}</p> @enderror

                    <div id="image-preview" class="grid grid-cols-4 gap-3 mt-4"></div>
                    <input type="hidden" name="primary_image_index" id="primary-image-index" value="0">
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
                <span class="text-xs text-stone-400" id="save-hint">Pastikan semua data sudah benar sebelum menyimpan.</span>
                <button type="submit"
                    class="bg-amber-700 text-white text-sm font-semibold rounded-full px-6 py-2.5 hover:bg-amber-800 shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Produk
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug dari nama produk (hanya jika slug belum diisi manual)
    const nameInput = document.getElementById('name-input');
    const slugInput = document.getElementById('slug-input');
    let slugTouched = false;

    slugInput.addEventListener('input', () => slugTouched = true);

    nameInput.addEventListener('input', function() {
        if (slugTouched) return;
        slugInput.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });

    // Preview gambar + drag & drop + pilih gambar utama
    const imageInput = document.getElementById('image-input');
    const dropzone = document.getElementById('dropzone');
    const preview = document.getElementById('image-preview');
    const primaryIndexInput = document.getElementById('primary-image-index');

    function renderPreview(files) {
        preview.innerHTML = '';
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative cursor-pointer group';
                wrapper.innerHTML = `
                    <img src="${evt.target.result}"
                         class="w-full h-24 object-cover rounded-lg border-2 transition ${index === 0 ? 'border-amber-600' : 'border-transparent group-hover:border-amber-200'}">
                    <span class="absolute top-1.5 left-1.5 text-[10px] font-semibold bg-amber-600 text-white px-2 py-0.5 rounded-full ${index === 0 ? '' : 'hidden'} primary-badge">
                        ★ Utama
                    </span>
                `;
                wrapper.addEventListener('click', () => {
                    primaryIndexInput.value = index;
                    preview.querySelectorAll('img').forEach(img => img.classList.remove('border-amber-600'));
                    preview.querySelectorAll('.primary-badge').forEach(b => b.classList.add('hidden'));
                    wrapper.querySelector('img').classList.add('border-amber-600');
                    wrapper.querySelector('.primary-badge').classList.remove('hidden');
                });
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

    // Cegah submit ganda
    document.getElementById('product-form').addEventListener('submit', function(e) {
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