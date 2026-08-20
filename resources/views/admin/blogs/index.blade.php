@extends('layouts.admin')

@section('page-title', 'Blog / News')
@section('page-subtitle', 'Website Settings')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-display text-xl font-semibold text-stone-900">Artikel Blog</h2>
            <p class="text-sm text-stone-400">{{ $blogs->total() }} artikel total</p>
        </div>
        <a href="{{ route('admin.settings.blogs.create') }}"
           class="inline-flex items-center gap-2 bg-[#b45309] hover:bg-[#92400e] text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tulis Artikel
        </a>
    </div>

    <div class="bg-white rounded-xl border border-amber-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-amber-50/60 text-stone-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Artikel</th>
                        <th class="px-5 py-3 text-left">Kategori</th>
                        <th class="px-5 py-3 text-left">Penulis</th>
                        <th class="px-5 py-3 text-left">Komentar</th>
                        <th class="px-5 py-3 text-left">Publish</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-50">
                    @forelse ($blogs as $blog)
                        <tr class="hover:bg-amber-50/50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Storage::url($blog->thumbnail) }}" alt="{{ $blog->title }}"
                                         class="w-14 h-14 rounded-lg object-cover border border-amber-100 shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-medium text-stone-800 truncate max-w-xs">{{ $blog->title }}</p>
                                        <p class="text-xs text-stone-400 truncate max-w-xs">/{{ $blog->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-600">{{ $blog->category?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $blog->author?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-stone-600">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                                    {{ $blog->comments_count }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-stone-600">
                                {{ $blog->published_at?->translatedFormat('d M Y') ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                @if ($blog->is_published)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-stone-100 text-stone-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                                       class="text-xs font-medium text-blue-500 hover:underline">Lihat</a>
                                    <a href="{{ route('admin.settings.blogs.edit', $blog) }}"
                                       class="text-xs font-medium text-[#b45309] hover:underline">Edit</a>
                                    <form action="{{ route('admin.settings.blogs.destroy', $blog) }}" method="POST"
                                          onsubmit="return confirm('Hapus artikel &quot;{{ $blog->title }}&quot;?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-rose-500 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-stone-400">
                                Belum ada artikel. Klik "Tulis Artikel" untuk membuat yang pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($blogs->hasPages())
            <div class="px-5 py-4 border-t border-amber-100">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
@endsection
