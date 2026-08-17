@extends('layouts.admin')

@section('page-title', 'Edit Artikel')
@section('page-subtitle', 'Website Settings / Blog')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.settings.blogs.index') }}" class="inline-flex items-center gap-1 text-sm text-stone-500 hover:text-[#6c7fd8] mb-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke daftar artikel
    </a>

    <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-6">
        <form action="{{ route('admin.settings.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.blogs._form', ['blog' => $blog, 'categories' => $categories])

            <div class="mt-8 flex items-center gap-3 pt-5 border-t border-amber-100">
                <button type="submit"
                    class="bg-[#b45309] hover:bg-[#92400e] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.settings.blogs.index') }}"
                    class="text-sm font-medium text-stone-500 hover:text-[#6c7fd8] px-5 py-2.5">
                    Batal
                </a>
                <form action="{{ route('admin.settings.blogs.destroy', $blog) }}" method="POST"
                    onsubmit="return confirm('Hapus artikel &quot;{{ $blog->title }}&quot;? Tindakan ini tidak bisa dibatalkan.')"
                    class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-700 px-5 py-2.5">
                        Hapus Artikel
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection