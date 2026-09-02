@extends('layouts.admin')

@section('title', 'Kategori Blog')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="materio-card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                    <i class="ri-folder-5-line text-[#8C57FF] text-2xl"></i> Kategori Blog
                </h1>
                <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Struktur topik artikel, tips bakery, dan berita promosi</p>
            </div>
            <a href="{{ route('admin.settings.blog-categories.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[14px] font-semibold shadow-md shadow-[#8C57FF]/30 hover:opacity-95 transition">
                <i class="ri-add-line text-lg"></i> Tambah Kategori
            </a>
        </div>
    </div>

    {{-- Categories Data Table --}}
    <div class="materio-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="text-left text-[12px] font-bold uppercase tracking-wider text-stone-400 bg-black/[0.02] dark:bg-white/[0.02] border-b border-black/5 dark:border-white/5">
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-4">Slug</th>
                        <th class="py-4 px-4">Induk</th>
                        <th class="py-4 px-4 text-center">Jumlah Artikel</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 dark:divide-white/5">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-[#8C57FF]/[0.03] transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3.5">
                                    @if($category->icon)
                                        <img src="{{ asset('storage/' . $category->icon) }}" class="w-11 h-11 rounded-xl object-cover border border-black/5 dark:border-white/10 shrink-0">
                                    @else
                                        <div class="w-11 h-11 rounded-xl bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center text-xl shrink-0">
                                            <i class="ri-folder-3-line"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-bold text-[15px] text-[#2E263D] dark:text-[#EAEAFF]">{{ $category->name }}</span>
                                        <span class="block text-[12px] text-stone-400 font-mono">Urutan: {{ $category->sort_order }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-mono text-[13px] text-stone-500">
                                {{ $category->slug }}
                            </td>
                            <td class="py-4 px-4">
                                @if($category->parent)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[13px] font-medium bg-black/[0.03] dark:bg-white/[0.05] text-[#2E263D] dark:text-[#EAEAFF]">
                                        <i class="ri-node-tree text-[13px] text-[#8C57FF]"></i>
                                        {{ $category->parent->name }}
                                    </span>
                                @else
                                    <span class="text-stone-400 text-[13px]">— Kategori Utama —</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[12px] font-bold bg-[#8C57FF]/10 text-[#8C57FF]">
                                    {{ $category->blogs_count ?? $category->blogs()->count() }} Artikel
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold {{ $category->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-stone-500/10 text-stone-500' }}">
                                    <span class="w-2 h-2 rounded-full {{ $category->is_active ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.settings.blog-categories.edit', $category) }}"
                                       class="w-9 h-9 rounded-xl flex items-center justify-center text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
                                       title="Edit Kategori">
                                        <i class="ri-edit-box-line text-lg"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.settings.blog-categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="w-9 h-9 rounded-xl flex items-center justify-center text-rose-500 hover:bg-rose-500/10 transition"
                                                title="Hapus Kategori">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-stone-400 text-[14px]">
                                <i class="ri-folder-open-line text-5xl block mb-2 text-stone-300"></i>
                                Belum ada data kategori blog.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-black/5 dark:border-white/5">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
