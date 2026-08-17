@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('blog.index') }}" class="text-sm text-amber-700 hover:underline">&larr; Kembali ke Blog</a>

    <h1 class="font-display text-3xl font-bold text-stone-900 mt-4 mb-2">{{ $blog->title }}</h1>
    <p class="text-sm text-stone-400 mb-6">
        Oleh {{ $blog->author->name }} &middot; {{ $blog->published_at?->format('d M Y') }}
    </p>

    <img src="{{ asset('storage/' . $blog->thumbnail) }}" class="w-full h-72 object-cover rounded-xl mb-8">

    <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed">
        {!! $blog->content !!}
    </div>

    {{-- Share button --}}
    <div class="flex gap-3 mt-8 pt-6 border-t border-amber-100">
        <span class="text-sm text-stone-500 self-center">Bagikan:</span>
        <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . request()->fullUrl()) }}" target="_blank"
           class="text-xs font-medium bg-green-500 text-white px-3 py-1.5 rounded-full">WhatsApp</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank"
           class="text-xs font-medium bg-blue-600 text-white px-3 py-1.5 rounded-full">Facebook</a>
    </div>

    @if ($relatedBlogs->count())
        <div class="mt-12">
            <h2 class="font-display text-lg font-bold text-stone-900 mb-4">Artikel Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($relatedBlogs as $related)
                    <a href="{{ route('blog.show', $related->slug) }}" class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden hover:shadow-md">
                        <img src="{{ asset('storage/' . $related->thumbnail) }}" class="w-full h-28 object-cover">
                        <div class="p-3">
                            <h3 class="text-sm font-semibold line-clamp-2">{{ $related->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
