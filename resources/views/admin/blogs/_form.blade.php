{{--
    admin.blogs._form
    Dipakai oleh create.blade.php & edit.blade.php.
    Variabel yang diharapkan: $blog (null saat create), $categories
--}}
@php
    $isEdit = isset($blog);
@endphp

<div x-data="{
        title: {{ json_encode(old('title', $blog->title ?? '')) }},
        slug: {{ json_encode(old('slug', $blog->slug ?? '')) }},
        slugTouched: {{ $isEdit ? 'true' : 'false' }},
        thumbPreview: {{ json_encode($isEdit ? Storage::url($blog->thumbnail) : null) }},
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1.5">Judul Artikel</label>
            <input type="text" name="title" x-model="title" @input="onTitleInput"
                   class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm"
                   placeholder="Contoh: 5 Tips Memilih Roti Segar" required>
            @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1.5">Slug</label>
            <input type="text" name="slug" x-model="slug" @input="slugTouched = true"
                   class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm font-mono"
                   placeholder="auto-generate-dari-judul">
            <p class="mt-1 text-xs text-stone-400">Kosongkan untuk auto-generate dari judul.</p>
            @error('slug') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Kategori & Tanggal Publish --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1.5">Kategori Blog</label>
            <select name="category_id" class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
                <option value="">— Tanpa kategori —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (int) old('category_id', $blog->category_id ?? 0) === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1.5">Jadwal Publish</label>
            <input type="datetime-local" name="published_at"
                   value="{{ old('published_at', optional($blog->published_at ?? null)->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">
            <p class="mt-1 text-xs text-stone-400">Kosongkan untuk publish langsung saat disimpan.</p>
            @error('published_at') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Thumbnail --}}
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">Thumbnail</label>
        <div class="flex items-center gap-4">
            <div class="w-28 h-28 rounded-lg border border-dashed border-amber-200 bg-amber-50 flex items-center justify-center overflow-hidden shrink-0">
                <template x-if="thumbPreview">
                    <img :src="thumbPreview" class="w-full h-full object-cover">
                </template>
                <template x-if="!thumbPreview">
                    <svg class="w-8 h-8 text-amber-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4V6z" /></svg>
                </template>
            </div>
            <div class="flex-1">
                <input type="file" name="thumbnail" accept="image/*" @change="onThumbChange"
                       class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#b45309] file:text-white file:text-sm hover:file:bg-[#92400e]">
                <p class="mt-1 text-xs text-stone-400">JPG/PNG, maks 2MB. {{ $isEdit ? 'Kosongkan jika tidak ingin mengganti.' : '' }}</p>
                @error('thumbnail') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">Ringkasan (Excerpt)</label>
        <textarea name="excerpt" rows="2" maxlength="500"
                  class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm"
                  placeholder="Ringkasan singkat yang tampil di daftar artikel...">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
        @error('excerpt') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
    </div>

    {{-- Konten (rich text — TinyMCE) --}}
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">Isi Artikel</label>
        <textarea name="content" id="blog-content" rows="12"
                  class="w-full rounded-lg border-amber-200 focus:border-[#b45309] focus:ring-[#b45309] text-sm">{{ old('content', $blog->content ?? '') }}</textarea>
        @error('content') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
    </div>

    {{-- Status publish --}}
    <label class="inline-flex items-center gap-2 cursor-pointer">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1"
               {{ old('is_published', $blog->is_published ?? true) ? 'checked' : '' }}
               class="rounded border-amber-200 text-[#b45309] focus:ring-[#b45309]">
        <span class="text-sm text-stone-700">Publikasikan artikel ini</span>
    </label>
</div>

@push('scripts')
    {{-- TinyMCE untuk editor rich text isi artikel --}}
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
