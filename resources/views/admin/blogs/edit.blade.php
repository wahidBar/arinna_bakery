@extends('layouts.admin')

@section('title', 'Edit Artikel: ' . $blog->title)

@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[18px] font-bold text-[#2E263D] dark:text-[#EAEAFF] flex items-center gap-2">
                <i class="ri-edit-box-line text-[#8C57FF] text-2xl"></i> Edit Artikel Blog
            </h1>
            <p class="text-[12px] text-[#6B6678] dark:text-[#A5A3AE] mt-0.5">Perbarui konten artikel: <span class="font-semibold text-[#8C57FF]">{{ $blog->title }}</span></p>
        </div>
        <a href="{{ route('admin.settings.blogs.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[13px] font-medium border border-black/10 dark:border-white/10 hover:bg-black/5 dark:hover:bg-white/5 text-[#2E263D] dark:text-[#EAEAFF] transition">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <div class="materio-card p-5 sm:p-6">
        <form action="{{ route('admin.settings.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.blogs._form', ['blog' => $blog, 'categories' => $categories])

            <div class="mt-8 flex items-center gap-3 pt-5 border-t border-black/5 dark:border-white/5">
                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white text-[13px] font-semibold shadow-md shadow-[#8C57FF]/35 hover:opacity-95 transition flex items-center gap-2">
                    <i class="ri-check-line text-base"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.settings.blogs.index') }}"
                   class="px-4 py-2 rounded-lg text-[13px] font-medium text-stone-500 hover:text-stone-700 dark:hover:text-stone-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection