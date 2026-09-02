@extends('layouts.admin')

@section('title', 'Artikel & Berita Blog')

@section('content')
<div class="space-y-6">

    {{-- Page Header & Toolbar --}}
    <div class="materio-card p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-article-line text-[#8C57FF] text-2xl"></i> Artikel Blog & Berita
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Kelola publikasi konten artikel tips, resep bakery, dan event promosi</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" class="flex flex-wrap items-center gap-2.5 flex-1 sm:flex-initial">
                    {{-- Search Input --}}
                    <div class="relative flex-1 sm:w-64">
                        <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..."
                               class="w-full pl-10 pr-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                    </div>

                    {{-- Category Filter --}}
                    <select name="category" class="px-4 py-2.5 text-[14px] rounded-xl border border-black/10 dark:border-white/10 bg-white dark:bg-[#312D4B] focus:outline-none focus:ring-2 focus:ring-[#8C57FF] text-[#2E263D] dark:text-[#EAEAFF]">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-black/5 dark:bg-white/10 hover:bg-[#8C57FF] hover:text-white text-[14px] font-semibold text-[#2E263D] dark:text-[#EAEAFF] transition">
                        Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.settings.blogs.index') }}" class="p-2.5 rounded-xl text-[14px] text-rose-500 hover:bg-rose-500/10" title="Reset Filter">
                            <i class="ri-refresh-line text-lg"></i>
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.settings.blogs.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/30 hover:opacity-95 transition">
                    <i class="ri-add-line text-lg"></i> Tulis Artikel
                </a>
            </div>
        </div>
    </div>

    {{-- Blogs Data Table Card --}}
    <div class="materio-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-b border-black/5 dark:border-white/5">
                        <th class="py-4 px-6">Artikel</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4">Tanggal Publish</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse ($blogs as $blog)
                        <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-12 rounded-xl border border-black/5 dark:border-white/10 overflow-hidden shrink-0 bg-stone-100 dark:bg-stone-800">
                                        @if($blog->thumbnail)
                                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[#8C57FF]">
                                                <i class="ri-image-line text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.settings.blogs.edit', $blog) }}" class="font-bold text-[15px] text-[#2E263D] dark:text-[#EAEAFF] hover:text-[#8C57FF] transition block truncate max-w-sm">
                                            {{ $blog->title }}
                                        </a>
                                        <span class="text-[12px] font-mono text-stone-400 block truncate max-w-sm">/blog/{{ $blog->slug }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[13px] font-medium bg-black/[0.03] dark:bg-white/[0.05] text-[#2E263D] dark:text-[#EAEAFF]">
                                    {{ $blog->category->name ?? '—' }}
                                </span>
                            </td>

                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold {{ $blog->is_published ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-stone-500/10 text-stone-500' }}">
                                    <span class="w-2 h-2 rounded-full {{ $blog->is_published ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>

                            <td class="py-4 px-4 text-[13px] text-stone-400">
                                {{ $blog->published_at ? $blog->published_at->format('d M Y, H:i') : '—' }}
                            </td>

                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.settings.blogs.edit', $blog) }}"
                                       class="w-9 h-9 rounded-xl flex items-center justify-center text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
                                       title="Edit Artikel">
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.settings.blogs.destroy', $blog) }}" onsubmit="return confirm('Hapus artikel {{ addslashes($blog->title) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="w-9 h-9 rounded-xl flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition"
                                                title="Hapus Artikel">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-stone-400 text-[14px]">
                                <i class="ri-article-line text-5xl block mb-2 text-stone-300"></i>
                                Tidak ada artikel yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($blogs->hasPages())
            <div class="px-6 py-4 border-t border-black/5 dark:border-white/5">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
