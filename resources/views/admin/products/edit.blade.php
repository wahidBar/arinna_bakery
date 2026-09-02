@extends('layouts.admin')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
<div class="space-y-6"
     x-data="{
        existingImages: {{ Js::from($product->images->map(fn($img) => [
            'id' => $img->id,
            'url' => asset('storage/' . $img->image_path),
            'is_primary' => (bool)$img->is_primary,
            'sort_order' => (int)$img->sort_order,
            'is_deleted' => false,
        ])) }},
        newAlbum: [],
        primaryImageId: {{ $product->primaryImage?->id ?? ($product->images->first()?->id ?? 'null') }},
        isUploading: false,
        notification: '',

        showToast(msg) {
            this.notification = msg;
            setTimeout(() => this.notification = '', 3500);
        },

        // Mark / Delete existing image
        async deleteExistingImage(img) {
            if (!confirm('Hapus foto ini dari album galeri?')) return;

            try {
                const res = await fetch(`/admin/products/images/${img.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    this.existingImages = this.existingImages.filter(i => i.id !== img.id);
                    if (this.primaryImageId === img.id && this.existingImages.length > 0) {
                        this.setPrimaryExisting(this.existingImages[0]);
                    }
                    this.showToast(data.message);
                }
            } catch (err) {
                img.is_deleted = true;
            }
        },

        // Set primary cover for existing image
        async setPrimaryExisting(img) {
            this.primaryImageId = img.id;
            this.existingImages.forEach(i => i.is_primary = (i.id === img.id));

            try {
                const res = await fetch(`/admin/products/images/${img.id}/set-primary`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    this.showToast(data.message);
                }
            } catch (err) {}
        },

        // Instant AJAX upload new photos
        async handleNewFiles(fileList) {
            const files = Array.from(fileList).filter(f => f.type.startsWith('image/'));
            if (files.length === 0) return;

            this.isUploading = true;
            for (const file of files) {
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const res = await fetch('{{ route('admin.products.images.store', $product) }}', {
                        method: 'POST',
                        headers: { 'Accept': 'application/json' },
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.existingImages.push({
                            id: data.image.id,
                            url: data.image.url,
                            is_primary: data.image.is_primary,
                            sort_order: data.image.sort_order,
                            is_deleted: false
                        });
                        if (this.existingImages.length === 1) {
                            this.primaryImageId = data.image.id;
                        }
                    }
                } catch (err) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.newAlbum.push({
                            file: file,
                            name: file.name,
                            size: (file.size / 1024).toFixed(1) + ' KB',
                            url: e.target.result
                        });
                    };
                    reader.readAsDataURL(file);
                }
            }
            this.isUploading = false;
            this.showToast('Foto berhasil ditambahkan ke album galeri.');
        },

        // Reorder Up
        async moveImageUp(index) {
            if (index <= 0) return;
            const item = this.existingImages.splice(index, 1)[0];
            this.existingImages.splice(index - 1, 0, item);
            this.saveOrder();
        },

        // Reorder Down
        async moveImageDown(index) {
            if (index >= this.existingImages.length - 1) return;
            const item = this.existingImages.splice(index, 1)[0];
            this.existingImages.splice(index + 1, 0, item);
            this.saveOrder();
        },

        async saveOrder() {
            const orderIds = this.existingImages.map(i => i.id);
            try {
                await fetch('{{ route('admin.products.images.reorder', $product) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order: orderIds })
                });
            } catch (err) {}
        }
     }"
>

    {{-- Dynamic Floating Toast Notification --}}
    <div x-show="notification" x-transition
         class="fixed top-24 right-6 z-50 px-4 py-3 rounded-xl bg-emerald-600 text-white text-[13px] font-bold shadow-xl shadow-emerald-500/30 flex items-center gap-2.5">
        <i class="ri-checkbox-circle-fill text-lg"></i>
        <span x-text="notification"></span>
    </div>

    {{-- Page Header with Quick Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-edit-circle-line text-[#8C57FF] text-2xl"></i> Edit Produk: {{ $product->name }}
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Perbarui rincian produk, harga, stok, dan album galeri foto secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
            <button type="submit" form="product-form"
                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                <i class="ri-save-line text-base"></i> Simpan Perubahan
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="product-form"
          @submit="
            const dt = new DataTransfer();
            newAlbum.forEach(item => dt.items.add(item.file));
            if (newAlbum.length > 0) {
                document.getElementById('real-new-image-input').files = dt.files;
            }
          "
    >
        @csrf
        @method('PUT')

        {{-- Hidden Primary Image & Trackers --}}
        <input type="hidden" name="primary_image_id" :value="primaryImageId">
        <input type="file" name="images[]" id="real-new-image-input" multiple class="hidden">

        {{-- Hidden deleted items for fallback form submission --}}
        <template x-for="img in existingImages.filter(i => i.is_deleted)" :key="img.id">
            <input type="hidden" name="delete_image_ids[]" :value="img.id">
        </template>

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
                            <input type="text" name="name" id="name-input" value="{{ old('name', $product->name) }}"
                                   class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('name') border-rose-400 @enderror"
                                   required>
                            @error('name') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                    Slug URL
                                </label>
                                <input type="text" name="slug" id="slug-input" value="{{ old('slug', $product->slug) }}"
                                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                                @error('slug') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                    SKU / Kode Produk <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                       class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-4 py-2.5 text-[14px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('sku') border-rose-400 @enderror"
                                       required>
                                @error('sku') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Deskripsi Produk</label>
                            <textarea name="description" rows="4"
                                      class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div>
                            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                                Informasi Tambahan / Komposisi Bahan
                            </label>
                            <textarea name="information" rows="3"
                                      class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] resize-none">{{ old('information', $product->information) }}</textarea>
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
                                <p class="text-[13px] text-stone-400">Tambah foto baru, atur urutan posisi, ganti cover, dan hapus foto secara real-time</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span x-show="isUploading" class="text-[13px] font-bold text-[#8C57FF] flex items-center gap-1">
                                <i class="ri-loader-4-line animate-spin"></i> Mengunggah...
                            </span>
                            <span class="text-[13px] font-bold px-3 py-1 rounded-full bg-[#8C57FF]/10 text-[#8C57FF]"
                                  x-text="(existingImages.filter(i => !i.is_deleted).length + newAlbum.length) + ' Foto'"></span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Upload Dropzone --}}
                        <label
                            class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-[#8C57FF]/30 dark:border-[#8C57FF]/20 rounded-2xl py-8 cursor-pointer hover:border-[#8C57FF] hover:bg-[#8C57FF]/5 transition"
                            @dragover.prevent="$el.classList.add('border-[#8C57FF]', 'bg-[#8C57FF]/10')"
                            @dragleave.prevent="$el.classList.remove('border-[#8C57FF]', 'bg-[#8C57FF]/10')"
                            @drop.prevent="
                                $el.classList.remove('border-[#8C57FF]', 'bg-[#8C57FF]/10');
                                handleNewFiles($event.dataTransfer.files);
                            "
                        >
                            <div class="w-12 h-12 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-2xl">
                                <i class="ri-image-add-line"></i>
                            </div>
                            <p class="text-[14px] text-[#2E263D] dark:text-[#EAEAFF] text-center">
                                <span class="font-bold text-[#8C57FF]">Tambah Foto Baru ke Album</span> atau seret & lepas file ke sini
                            </p>
                            <p class="text-[12px] text-stone-400">Bisa memilih lebih dari 1 foto &middot; Foto akan otomatis diunggah langsung ke album</p>
                            <input type="file" accept="image/*" multiple class="hidden" @change="handleNewFiles($event.target.files); $event.target.value = ''">
                        </label>

                        {{-- Dynamic Album Grid: Existing Images --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                            <template x-for="(img, index) in existingImages.filter(i => !i.is_deleted)" :key="img.id">
                                <div class="materio-card overflow-hidden p-3 border-2 transition-all relative group"
                                     :class="primaryImageId === img.id ? 'border-[#8C57FF] bg-[#8C57FF]/[0.02]' : 'border-black/10 dark:border-white/10'">

                                    {{-- Image Preview --}}
                                    <div class="h-36 rounded-lg overflow-hidden bg-stone-100 dark:bg-stone-800 relative">
                                        <img :src="img.url" class="w-full h-full object-cover">

                                        {{-- Primary Cover Badge --}}
                                        <span x-show="primaryImageId === img.id"
                                              class="absolute top-2 left-2 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#8C57FF] text-white shadow-md flex items-center gap-1">
                                            <i class="ri-star-fill"></i> Cover Utama
                                        </span>

                                        {{-- Reorder & Delete Floating Buttons --}}
                                        <div class="absolute top-2 right-2 flex items-center gap-1 opacity-90 group-hover:opacity-100">
                                            <button type="button" @click="moveImageUp(index)" :disabled="index === 0"
                                                    class="w-7 h-7 rounded-lg bg-black/60 hover:bg-black text-white flex items-center justify-center text-xs disabled:opacity-30 disabled:cursor-not-allowed"
                                                    title="Geser ke Kiri/Atas">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </button>
                                            <button type="button" @click="moveImageDown(index)" :disabled="index === existingImages.filter(i => !i.is_deleted).length - 1"
                                                    class="w-7 h-7 rounded-lg bg-black/60 hover:bg-black text-white flex items-center justify-center text-xs disabled:opacity-30 disabled:cursor-not-allowed"
                                                    title="Geser ke Kanan/Bawah">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </button>
                                            <button type="button" @click="deleteExistingImage(img)"
                                                    class="w-7 h-7 rounded-lg bg-rose-500/90 hover:bg-rose-600 text-white flex items-center justify-center text-xs"
                                                    title="Hapus dari Album">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Info & Action Footer --}}
                                    <div class="mt-3 flex items-center justify-between gap-2">
                                        <span class="text-[12px] font-semibold text-[#6B6678] dark:text-[#A5A3AE]">
                                            Foto #<span x-text="index + 1"></span>
                                        </span>

                                        <button type="button" @click="setPrimaryExisting(img)"
                                                class="px-2.5 py-1 rounded-lg text-[12px] font-bold transition flex items-center gap-1 shrink-0"
                                                :class="primaryImageId === img.id ? 'bg-[#8C57FF] text-white shadow-sm' : 'bg-black/5 dark:bg-white/5 hover:bg-[#8C57FF]/10 text-stone-600 dark:text-stone-300 hover:text-[#8C57FF]'">
                                            <i :class="primaryImageId === img.id ? 'ri-star-fill' : 'ri-star-line'"></i>
                                            <span x-text="primaryImageId === img.id ? 'Cover Utama' : 'Jadikan Cover'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            {{-- Pending local new files (if offline / fallback) --}}
                            <template x-for="(item, idx) in newAlbum" :key="idx">
                                <div class="materio-card overflow-hidden p-3 border-2 border-amber-400 bg-amber-500/[0.02] relative group">
                                    <div class="h-36 rounded-lg overflow-hidden bg-stone-100 dark:bg-stone-800 relative">
                                        <img :src="item.url" class="w-full h-full object-cover">
                                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white">
                                            Siap Diunggah
                                        </span>
                                        <button type="button" @click="newAlbum.splice(idx, 1)"
                                                class="absolute top-2 right-2 w-7 h-7 rounded-lg bg-rose-500 text-white flex items-center justify-center text-xs">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2 text-[13px] font-bold truncate text-[#2E263D] dark:text-[#EAEAFF]" x-text="item.name"></div>
                                </div>
                            </template>
                        </div>

                        <div x-show="existingImages.filter(i => !i.is_deleted).length === 0 && newAlbum.length === 0"
                             class="p-8 text-center text-stone-400 text-[13px] border border-dashed border-black/10 dark:border-white/10 rounded-xl">
                            Album galeri saat ini kosong. Silakan unggah minimal 1 foto produk.
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN (4 cols): Kategori, Harga, Stok, Visibilitas --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- CARD: Kategori & Satuan --}}
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
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">Berat / Satuan Porsi</label>
                        <input type="text" name="weight" value="{{ old('weight', $product->weight) }}" placeholder="contoh: 300 gram, 1 box isi 6 pcs"
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
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0"
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
                            <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0"
                                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] text-[14px] font-bold text-emerald-600 dark:text-emerald-400 focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('discount_price') border-rose-400 @enderror">
                        </div>
                        @error('discount_price') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                            Jumlah Stok <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
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
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>

                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Produk Sorotan (Featured)</span>
                                <span class="text-[11px] text-stone-400">Tampil di beranda utama</span>
                            </div>
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>

                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Produk Baru</span>
                                <span class="text-[11px] text-stone-400">Label badge "New"</span>
                            </div>
                            <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>

                        <label class="flex items-center justify-between p-3 rounded-xl border border-black/10 dark:border-white/10 bg-black/[0.02] dark:bg-white/[0.02] cursor-pointer hover:border-[#8C57FF] transition">
                            <div>
                                <span class="text-[13px] font-bold text-[#2E263D] dark:text-[#EAEAFF] block">Flash Sale</span>
                                <span class="text-[11px] text-stone-400">Promo kilat</span>
                            </div>
                            <input type="checkbox" name="is_flashsale" id="is_flashsale" value="1" {{ old('is_flashsale', $product->is_flashsale) ? 'checked' : '' }} class="w-4 h-4 rounded accent-[#8C57FF]">
                        </label>
                    </div>
                </div>

                {{-- CARD: Simpan Aksi --}}
                <div class="materio-card p-6 space-y-3">
                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-bold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center justify-center gap-2">
                        <i class="ri-save-line text-lg"></i> Simpan Perubahan
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