@extends('layouts.app')

@section('title', 'Blog — Arinna Hidayah Bakery')

@section('content')
@include('partials.breadcrumb', ['items' => [['label' => 'Blog & Berita']]])

<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">Blog &amp; Berita</h1>

    <div class="flex gap-2 mb-8 flex-wrap">
        <a href="{{ route('blog.index') }}"
           class="text-xs font-medium px-4 py-2 rounded-full {{ !request('category') ? 'bg-amber-700 text-white' : 'bg-white text-stone-600' }}">
            Semua
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
               class="text-xs font-medium px-4 py-2 rounded-full {{ request('category') === $category->slug ? 'bg-amber-700 text-white' : 'bg-white text-stone-600' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if ($blogs->isEmpty())
        <p class="text-stone-400 text-center py-16">Belum ada artikel.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}" class="bg-white rounded-2xl border border-amber-100 shadow-sm hover:shadow-md transition overflow-hidden">
                    <img src="{{ asset('storage/' . $blog->thumbnail) }}" class="w-full h-44 object-cover">
                    <div class="p-4">
                        <p class="text-xs text-stone-400 mb-2">{{ $blog->published_at?->format('d M Y') }}</p>
                        <h3 class="font-semibold mb-2 line-clamp-2">{{ $blog->title }}</h3>
                        <p class="text-sm text-stone-500 line-clamp-2">{{ $blog->excerpt }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $blogs->links() }}</div>
    @endif
</div>
@endsection
