{{--
    admin.blogs._form
    Materio Rich Blog Form Partial
--}}
@php
    $isEdit = isset($blog);
@endphp

<div x-data="{
        title: {{ json_encode(old('title', $blog->title ?? '')) }},
        slug: {{ json_encode(old('slug', $blog->slug ?? '')) }},
        slugTouched: {{ $isEdit ? 'true' : 'false' }},
        thumbPreview: {{ json_encode($isEdit && $blog->thumbnail ? Storage::url($blog->thumbnail) : null) }},
        slugify(value) {
            return value.toString().toLowerCase().trim()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        },
        onTitleInput() {
            if (!this.slugTouched) this.slug = this.slugify(this.title);
        },
        onThumbChange(e) {
            const file = e.target.files[0];
            if (file) this.thumbPreview = URL.createObjectURL(file);
        },
     }"
     class="space-y-6"
>
    {{-- Judul & Slug --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                Judul Artikel <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" x-model="title" @input="onTitleInput"
                   class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] @error('title') border-rose-400 @enderror"
                   placeholder="Contoh: Rahasia Roti Lembut dan Tahan Lama" required>
            @error('title') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                Slug URL <span class="text-stone-400 font-normal">(otomatis)</span>
            </label>
            <input type="text" name="slug" x-model="slug" @input="slugTouched = true"
                   class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                   placeholder="auto-generate-dari-judul">
            <p class="text-[11px] text-stone-400 mt-1">Kosongkan untuk auto-generate otomatis dari judul</p>
            @error('slug') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Kategori & Tanggal Publish --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                Kategori Blog
            </label>
            <select name="category_id" class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
                <option value="">— Tanpa Kategori —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (int) old('category_id', $blog->category_id ?? 0) === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                Jadwal Publish
            </label>
            <input type="datetime-local" name="published_at"
                   value="{{ old('published_at', optional($blog->published_at ?? null)->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">
            <p class="text-[11px] text-stone-400 mt-1">Kosongkan untuk publish langsung saat disimpan</p>
            @error('published_at') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Thumbnail --}}
    <div>
        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
            Gambar Thumbnail Artikel
        </label>
        <div class="flex items-center gap-4">
            <div class="w-32 h-24 rounded-2xl border border-dashed border-[#8C57FF]/30 dark:border-[#8C57FF]/20 bg-[#8C57FF]/5 flex items-center justify-center overflow-hidden shrink-0">
                <template x-if="thumbPreview">
                    <img :src="thumbPreview" class="w-full h-full object-cover">
                </template>
                <template x-if="!thumbPreview">
                    <i class="ri-image-add-line text-3xl text-[#8C57FF]/40"></i>
                </template>
            </div>
            <div class="flex-1">
                <input type="file" name="thumbnail" accept="image/*" @change="onThumbChange"
                       class="w-full text-[13px] text-stone-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#8C57FF]/10 file:text-[#8C57FF] file:font-semibold hover:file:bg-[#8C57FF]/20 cursor-pointer">
                <p class="text-[12px] text-stone-400 mt-1">JPG/PNG/WEBP, maks 2MB. {{ $isEdit ? 'Kosongkan jika tidak ingin mengganti.' : '' }}</p>
                @error('thumbnail') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Ringkasan & Instagram Link --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                Ringkasan (Excerpt)
            </label>
            <textarea name="excerpt" rows="2" maxlength="500"
                      class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] resize-none"
                      placeholder="Ringkasan singkat yang tampil pada daftar artikel di website...">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
            @error('excerpt') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
                Link Embed Instagram <span class="text-stone-400 font-normal">(opsional)</span>
            </label>
            <input type="url" name="instagram_link" value="{{ old('instagram_link', $blog->instagram_link ?? '') }}"
                   class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] font-mono text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]"
                   placeholder="https://www.instagram.com/reel/...">
            <p class="text-[11px] text-stone-400 mt-1">Sematkan video Reel Instagram terkait artikel</p>
            @error('instagram_link') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Konten (TinyMCE) --}}
    <div>
        <label class="text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] block mb-1.5">
            Isi Konten Artikel <span class="text-rose-500">*</span>
        </label>
        <textarea name="content" id="blog-content" rows="12"
                  class="w-full rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] px-3.5 py-2 text-[13px] text-[#2E263D] dark:text-[#EAEAFF] focus:outline-none focus:ring-2 focus:ring-[#8C57FF]">{{ old('content', $blog->content ?? '') }}</textarea>
        @error('content') <p class="text-[12px] text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Status Publish --}}
    <div class="pt-2">
        <label class="inline-flex items-center gap-3 cursor-pointer text-[13px] font-semibold text-[#2E263D] dark:text-[#EAEAFF]">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1"
                   {{ old('is_published', $blog->is_published ?? true) ? 'checked' : '' }}
                   class="w-4 h-4 rounded accent-[#8C57FF]">
            <span>Publikasikan artikel ini secara aktif di website</span>
        </label>
    </div>
</div>

@push('scripts')
    {{-- TinyMCE rich editor --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#blog-content',
            height: 400,
            menubar: false,
            plugins: 'lists link image table code wordcount',
            toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link image | code',
            skin: 'oxide',
            content_css: 'default',
        });
    </script>
@endpush
