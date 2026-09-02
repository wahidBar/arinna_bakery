@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="space-y-6"
     x-data="{
        album: [],
        primaryIndex: 0,
        addFiles(fileList) {
            Array.from(fileList).forEach((file) => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.album.push({
                        file: file,
                        name: file.name,
                        size: (file.size / 1024).toFixed(1) + ' KB',
                        url: e.target.result
                    });
                };
                reader.readAsDataURL(file);
            });
        },
        removeImage(index) {
            this.album.splice(index, 1);
            if (this.primaryIndex >= this.album.length) {
                this.primaryIndex = Math.max(0, this.album.length - 1);
            }
        },
        setPrimary(index) {
            this.primaryIndex = index;
        },
        moveUp(index) {
            if (index <= 0) return;
            const item = this.album.splice(index, 1)[0];
            this.album.splice(index - 1, 0, item);
            if (this.primaryIndex === index) this.primaryIndex = index - 1;
            else if (this.primaryIndex === index - 1) this.primaryIndex = index;
        },
        moveDown(index) {
            if (index >= this.album.length - 1) return;
            const item = this.album.splice(index, 1)[0];
            this.album.splice(index + 1, 0, item);
            if (this.primaryIndex === index) this.primaryIndex = index + 1;
            else if (this.primaryIndex === index + 1) this.primaryIndex = index;
        }
     }"
>

    {{-- Page Header with Quick Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-add-circle-line text-[#8C57FF] text-2xl"></i> Tambah Produk Baru
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Lengkapi rincian produk, harga, stok, dan album foto varian bakery baru</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
            <button type="submit" form="product-form"
                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                <i class="ri-save-line text-base"></i> Simpan Produk
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="product-form"
          @submit="
            const dt = new DataTransfer();
            album.forEach(item => dt.items.add(item.file));
            document.getElementById('real-image-input').files = dt.files;
          "
    >
        @csrf

        {{-- Hidden Real File Input & Primary Index --}}
        <input type="file" name="images[]" id="real-image-input" multiple class="hidden">
        <input type="hidden" name="primary_image_index" :value="primaryIndex">

        {{-- 2-Column Materio Form Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT COLUMN (8 cols): Info Dasar & Album Dinamis --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- CARD: Informasi Dasar --}}
                <div class="materio-card p-6 space-y-5">
                    <div class="pb-4 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-xl">
                            <i class="ri-information-line"></i>
                        </div>
                        <div>
                            <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Informasi Produk</h2>
                            <p class="text-[13px] text-stone-400">Nama produk, identitas SKU, deskripsi rasa, dan komposisi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name-input" value="{{ old('name') }}"
                                   placeholder="contoh: Roti Sisir Mentega Spesial"
                                   class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('name') border-rose-400 @enderror"
                                   required>
                            @error('name') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                    Slug URL <span class="text-stone-400 font-normal">(otomatis)</span>
                                </label>
                                <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}"
                                       placeholder="otomatis-dari-nama-produk"
                                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                                <p class="text-[12px] text-stone-400 mt-1">Kosongkan untuk auto-generate dari nama produk</p>
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                    SKU / Kode Produk <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="sku" value="{{ old('sku') }}"
                                       placeholder="contoh: ROT-001"
                                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('sku') border-rose-400 @enderror"
                                       required>
                                @error('sku') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Deskripsi Produk</label>
                            <textarea name="description" rows="4" placeholder="Ceritakan kelezatan, aroma, dan keunikan produk roti ini..."
                                      class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] resize-none">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                Informasi Tambahan / Komposisi Bahan
                            </label>
                            <textarea name="information" rows="3" placeholder="contoh: Tepung terigu jepang, butter wisman impor, dark chocolate 70%..."
                                      class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] resize-none">{{ old('information') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- CARD: DYNAMIC PRODUCT ALBUM CRUD --}}
                <div class="materio-card p-6 space-y-5">
                    <div class="pb-4 border-b border-black/5 dark:border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#16B1FF]/10 text-[#16B1FF] flex items-center justify-center text-xl">
                                <i class="ri-gallery-upload-line"></i>
                            </div>
                            <div>
                                <h2 class="text-[16px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Album Galeri Produk Dinamis</h2>
                                <p class="text-[13px] text-stone-400">Unggah beberapa foto sekaligus, atur posisi, dan tentukan cover utama</p>
                            </div>
                        </div>
                        <span class="text-[13px] font-bold px-3 py-1 rounded-full bg-[#8C57FF]/10 text-[#8C57FF]" x-text="album.length + ' Foto'"></span>
                    </div>

                    <div class="space-y-4">
                        {{-- Upload Dropzone --}}
                        <label
                            class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-[#8C57FF]/30 dark:border-[#8C57FF]/20 rounded-2xl py-8 cursor-pointer hover:border-[#8C57FF] hover:bg-[#8C57FF]/5 transition"
                            @dragover.prevent="$el.classList.add('border-[#8C57FF]', 'bg-[#8C57FF]/10')"
                            @dragleave.prevent="$el.classList.remove('border-[#8C57FF]', 'bg-[#8C57FF]/10')"
                            @drop.prevent="
                                $el.classList.remove('border-[#8C57FF]', 'bg-[#8C57FF]/10');
                                addFiles($event.dataTransfer.files);
                            "
                        >
                            <div class="w-12 h-12 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-2xl">
                                <i class="ri-image-add-line"></i>
                            </div>
                            <p class="text-[14px] text-[#2E263D] dark:text-[#EAEAFF] text-center">
                                <span class="font-bold text-[#8C57FF]">Pilih foto dari komputer</span> atau seret & lepas (drag & drop) ke sini
                            </p>
                            <p class="text-[12px] text-stone-400">Bisa memilih lebih dari 1 foto sekaligus &middot; PNG, JPG, WEBP (maks 2MB per foto)</p>
                            <input type="file" accept="image/*" multiple class="hidden" @change="addFiles($event.target.files); $event.target.value = ''">
                        </label>

                        @error('images') <p class="text-[12px] text-rose-500 font-semibold">{{ $message }}</p> @enderror

                        {{-- Dynamic Album Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-2" x-show="album.length > 0">
                            <template x-for="(item, index) in album" :key="index">
                                <div class="materio-card overflow-hidden p-3 border-2 transition-all relative group"
                                     :class="primaryIndex === index ? 'border-[#8C57FF] bg-[#8C57FF]/[0.02]' : 'border-black/10 dark:border-white/10'">

                                    {{-- Image Preview --}}
                                    <div class="h-36 rounded-lg overflow-hidden bg-stone-100 dark:bg-stone-800 relative">
                                        <img :src="item.url" class="w-full h-full object-cover">

                                        {{-- Primary Cover Badge --}}
                                        <span x-show="primaryIndex === index"
                                              class="absolute top-2 left-2 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#8C57FF] text-white shadow-md flex items-center gap-1">
                                            <i class="ri-star-fill"></i> Cover Utama
                                        </span>

                                        {{-- Reorder & Delete Floating Buttons --}}
                                        <div class="absolute top-2 right-2 flex items-center gap-1 opacity-90 group-hover:opacity-100">
                                            <button type="button" @click="moveUp(index)" :disabled="index === 0"
                                                    class="w-7 h-7 rounded-lg bg-black/60 hover:bg-black text-white flex items-center justify-center text-xs disabled:opacity-30 disabled:cursor-not-allowed"
                                                    title="Geser ke Kiri/Atas">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </button>
                                            <button type="button" @click="moveDown(index)" :disabled="index === album.length - 1"
                                                    class="w-7 h-7 rounded-lg bg-black/60 hover:bg-black text-white flex items-center justify-center text-xs disabled:opacity-30 disabled:cursor-not-allowed"
                                                    title="Geser ke Kanan/Bawah">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </button>
                                            <button type="button" @click="removeImage(index)"
                                                    class="w-7 h-7 rounded-lg bg-rose-500/90 hover:bg-rose-600 text-white flex items-center justify-center text-xs"
                                                    title="Hapus dari Album">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Info & Set Cover Action --}}
                                    <div class="mt-3 flex items-center justify-between gap-2">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] truncate" x-text="item.name"></p>
                                            <p class="text-[11px] text-stone-400" x-text="item.size"></p>
                                        </div>

                                        <button type="button" @click="setPrimary(index)"
                                                class="px-2.5 py-1 rounded-lg text-[12px] font-bold transition flex items-center gap-1 shrink-0"
                                                :class="primaryIndex === index ? 'bg-[#8C57FF] text-white shadow-sm' : 'bg-black/5 dark:bg-white/5 hover:bg-[#8C57FF]/10 text-stone-600 dark:text-stone-300 hover:text-[#8C57FF]'">
                                            <i :class="primaryIndex === index ? 'ri-star-fill' : 'ri-star-line'"></i>
                                            <span x-text="primaryIndex === index ? 'Cover' : 'Jadikan Cover'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div x-show="album.length === 0" class="p-8 text-center text-stone-400 text-[13px] border border-dashed border-black/10 dark:border-white/10 rounded-xl">
                            Belum ada foto yang dipilih. Silakan pilih minimal 1 foto untuk album galeri produk.
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN (4 cols): Harga, Stok, Kategori, Visibilitas --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- CARD: Kategori & Inventaris --}}
                <div class="materio-card p-6 space-y-4">
                    <div class="pb-3 border-b border-black/5 dark:border-white/5 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-lg">
                            <i class="ri-folder-5-line"></i>
                        </div>
                        <h2 class="text-[15px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Kategori & Satuan</h2>
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                            Kategori Produk <span class="text-rose-500">*</span>
                        </label>
                        <select name="category_id"
                                class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('category_id') border-rose-400 @enderror"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Berat / Satuan Porsi</label>
                        <input type="text" name="weight" value="{{ old('weight') }}" placeholder="contoh: 300 gram, 1 box isi 6 pcs"
                               class="w-full px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] text-[14px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                    </div>
                </div>

                {{-- CARD: Harga & Stok --}}
                <div class="materio-card p-6 space-y-4">
                    <div class="pb-3 border-b border-black/5 dark:border-white/5 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-lg">
                            <i class="ri-price-tag-3-line"></i>
                        </div>
                        <h2 class="text-[15px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Harga & Stok</h2>
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                            Harga Normal (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[14px] text-stone-400 font-bold">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" min="0"
                                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] text-[14px] font-bold text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('price') border-rose-400 @enderror"
                                   required>
                        </div>
                        @error('price') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                            Harga Diskon (Rp) <span class="text-stone-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[14px] text-stone-400 font-bold">Rp</span>
                            <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0"
                                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] text-[14px] font-bold text-emerald-600 dark:text-emerald-400 focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('discount_price') border-rose-400 @enderror">
                        </div>
                        @error('discount_price') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                            Jumlah Stok <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 10) }}" min="0"
                               class="w-full px-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] text-[14px] font-bold text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('stock') border-rose-400 @enderror"
                               required>
                        @error('stock') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- CARD: Status & Visibilitas --}}
                <div class="materio-card p-6 space-y-4">
                    <div class="pb-3 border-b border-black/5 dark:border-white/5 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-500 flex items-center justify-center text-lg">
                            <i class="ri-toggle-line"></i>
                        </div>
                        <h2 class="text-[15px] font-bold text-[#2E263D] dark:text-[#EAEAFF]">Status & Visibilitas</h2>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Aktif</span>
                                <span class="text-[11px] text-stone-400">Tampil di katalog etalase toko</span>
                            </div>
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>

                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Produk Sorotan (Featured)</span>
                                <span class="text-[11px] text-stone-400">Tampil di beranda utama</span>
                            </div>
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>

                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Produk Baru</span>
                                <span class="text-[11px] text-stone-400">Label badge "New"</span>
                            </div>
                            <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>

                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Flash Sale</span>
                                <span class="text-[11px] text-stone-400">Promo kilat</span>
                            </div>
                            <input type="checkbox" name="is_flashsale" id="is_flashsale" value="1" {{ old('is_flashsale') ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>
                    </div>
                </div>

                {{-- CARD: Simpan Aksi --}}
                <div class="materio-card p-6 space-y-3">
                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-bold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center justify-center gap-2">
                        <i class="ri-save-line text-lg"></i> Simpan Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="w-full py-2.5 rounded-xl border border-black/10 dark:border-white/10 text-stone-500 hover:text-stone-700 dark:hover:text-stone-300 text-[13px] font-semibold text-center block hover:bg-black/5 dark:hover:bg-white/5 transition">
                        Batal
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const nameInput = document.getElementById('name-input');
    const slugInput = document.getElementById('slug-input');
    let slugTouched = false;

    if (slugInput) {
        slugInput.addEventListener('input', () => slugTouched = true);
    }
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (slugTouched) return;
            slugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        });
    }

    const form = document.getElementById('product-form');
    if (form) {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `<i class="ri-loader-4-line animate-spin text-base"></i> Menyimpan...`;
            }
        });
    }
</script>
@endpush