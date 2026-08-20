@extends('layouts.app')

@section('title', 'Katalog Produk — Arinna Hidayah Bakery')

@push('head')
<style>
    .font-catalog-header {
        font-family: 'Times New Roman', serif;
    }
</style>
@endpush

@section('content')

{{-- Cover / Header --}}
<div class="relative bg-[#e9ebf2] min-h-[500px] flex flex-col justify-center items-center py-20 bg-cover bg-center overflow-hidden">
    <div class="absolute inset-0 opacity-[0.05] grayscale" style="background-image: url('{{ asset('assets/img/category/ban-cat.png') }}'); background-size: cover; background-position: center;"></div>

    <div class="relative z-10 text-center flex flex-col items-center mt-10">
        <div class="mb-4 bg-white p-4 rounded-full shadow-lg">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" class="w-20 md:w-24">
        </div>
        <h2 class="font-catalog-header text-4xl md:text-5xl font-bold text-stone-900 mb-2 italic">Katalog</h2>
        <h1 class="font-display text-6xl md:text-8xl font-black text-[#002159] uppercase mb-6 tracking-wide">PRODUK</h1>
        <div class="bg-[#002159] text-white px-8 md:px-12 py-3 rounded-lg text-lg md:text-2xl font-bold tracking-wide">
            Arinna Hidayah Bakery
        </div>
    </div>
</div>

@include('partials.breadcrumb', ['items' => [['label' => 'Katalog Produk']]])

<div class="mx-auto max-w-7xl px-4 py-8 md:py-10">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">

        {{-- Sidebar Filter --}}
        <aside class="lg:sticky lg:top-24 lg:self-start">
            <form id="filter-form" method="GET" action="{{ route('products.index') }}" class="overflow-hidden rounded-[28px] border border-[#e4e8ff] bg-white p-5 shadow-[0_24px_50px_rgba(108,127,216,0.08)] z-10 relative">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="font-display text-lg font-semibold text-stone-900">Filter</h3>
                    <span class="rounded-full bg-[#eef1ff] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#6c7fd8]">Cek</span>
                </div>

                <div class="space-y-6">
                    <div>
                        <h4 class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-500">Kategori</h4>
                        <div class="max-h-56 space-y-2.5 overflow-y-auto pr-1">
                            @foreach ($categories as $category)
                            <label class="flex cursor-pointer items-center gap-2.5 rounded-xl px-2.5 py-2 text-sm text-stone-600 transition hover:bg-[#f3f6ff]">
                                <input type="checkbox" name="category_arr[]" value="{{ $category->slug }}" class="filter-category h-4 w-4 rounded border-[#ccd6ff] text-[#6c7fd8] focus:ring-[#cdd8ff]"
                                    {{ in_array($category->slug, explode(',', request('category', ''))) ? 'checked' : '' }}>
                                <span>{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-500">Rentang Harga</h4>
                        <div class="grid grid-cols-2 gap-2.5">
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                class="w-full rounded-full border border-[#e6ebff] bg-[#f7f8ff] px-3 py-2.5 text-sm text-stone-700 shadow-inner outline-none transition focus:border-[#9aaaf5] focus:ring-2 focus:ring-[#e3e8ff]">
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                class="w-full rounded-full border border-[#e6ebff] bg-[#f7f8ff] px-3 py-2.5 text-sm text-stone-700 shadow-inner outline-none transition focus:border-[#9aaaf5] focus:ring-2 focus:ring-[#e3e8ff]">
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#e7ebff] bg-[#f6f7ff] p-3">
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-stone-600">
                            <input type="checkbox" name="discount_only" value="1" class="h-4 w-4 rounded border-[#ccd6ff] text-[#6c7fd8] focus:ring-[#dfe7ff]" {{ request('discount_only') ? 'checked' : '' }}>
                            Hanya produk diskon
                        </label>
                    </div>

                    <input type="hidden" name="category" id="category-hidden">

                    <button type="submit" class="w-full rounded-full bg-gradient-to-r from-[#6c7fd8] to-[#8295ef] px-4 py-3 text-sm font-semibold text-white shadow-[0_12px_30px_rgba(108,127,216,0.28)] transition hover:from-[#5d6fd1] hover:to-[#7287eb]">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </aside>

        {{-- Content Area --}}
        <div>
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between bg-white p-4 rounded-[28px] border border-[#e7ebff] shadow-sm">
                <div class="relative w-full sm:max-w-md">
                    <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-stone-400"></i>
                    <input type="text" id="live-search" placeholder="Cari produk favoritmu..." value="{{ request('q') }}"
                        class="w-full rounded-full border border-[#e5e9ff] bg-[#f8f8fb] px-4 py-3 pl-10 text-sm text-stone-700 outline-none transition focus:border-[#9aaaf5]">
                </div>

                <div class="flex items-center gap-2 rounded-full border border-[#e5e9ff] bg-white px-2 py-2">
                    <label for="sort-select" class="pl-2 text-xs font-semibold uppercase tracking-[0.1em] text-stone-500">Urutkan:</label>
                    <select id="sort-select" name="sort" class="rounded-full border-0 bg-transparent px-2 py-1 text-sm font-medium text-stone-700 outline-none focus:ring-0 cursor-pointer">
                        <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Termurah</option>
                        <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Termahal</option>
                        <option value="terlaris" {{ request('sort') === 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                    </select>
                </div>
            </div>

            <div id="product-grid">
                @include('products.partials.grid', ['products' => $products])
            </div>
        </div>

        {{-- ============ POPUP BLOG (Pop-News) ============ --}}
        <div class="bb-popnews-bg hidden fixed top-0 left-0 w-full h-full bg-[#00000080] z-[24]"></div>
        <div class="bb-popnews-box w-full max-w-[600px] p-[24px] fixed left-[50%] top-[50%] bg-[#fff] hidden z-[25] text-center rounded-[15px] overflow-hidden max-[767px]:w-[90%]">
            <div class="bb-popnews-close transition-all duration-[0.3s] ease-in-out w-[16px] h-[20px] absolute top-[-5px] right-[27px] bg-[#e04e4eb3] rounded-[10px] cursor-pointer hover:bg-[#e04e4e]" title="Close"></div>
            <div class="flex flex-wrap mx-[-12px]">
                <div class="min-[768px]:w-[50%] w-full px-[12px]">
                    @if(isset($randomBlog) && $randomBlog->thumbnail)
                    <img src="{{ asset('storage/' . $randomBlog->thumbnail) }}" alt="{{ $randomBlog->title }}" class="w-full h-full object-cover rounded-[15px] max-[767px]:hidden min-h-[250px]">
                    @else
                    <img src="{{ asset('assets/img/newsletter/newsletter.jpg') }}" alt="newsletter" class="w-full h-full object-cover rounded-[15px] max-[767px]:hidden min-h-[250px]">
                    @endif
                </div>
                <div class="min-[768px]:w-[50%] w-full px-[12px]">
                    <div class="bb-popnews-box-content h-full flex flex-col items-center justify-center p-2">
                        <h2 class="font-quicksand text-[#3d4750] block text-[20px] leading-[28px] font-bold mt-[0] mx-[auto] mb-[10px] tracking-[0] capitalize line-clamp-2">
                            {{ $randomBlog ? $randomBlog->title : '#FreshBreadLovers' }}
                        </h2>
                        <p class="font-Poppins font-light tracking-[0.03rem] mb-[15px] text-[13px] leading-[20px] text-[#686e7d] line-clamp-4">
                            {{ $randomBlog ? $randomBlog->excerpt : 'Kami menghadirkan hidangan berkualitas dan selalu fresh untuk melengkapi setiap momen spesial Anda.' }}
                        </p>
                        @if(isset($randomBlog))
                        <a href="{{ route('blog.show', $randomBlog->slug) }}" class="bb-btn-2 transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[6px] px-[20px] text-[13px] font-medium text-[#fff] bg-[#6c7fd8] rounded-[10px] border-[1px] border-solid border-[#6c7fd8] hover:bg-transparent hover:border-[#3d4750] hover:text-[#3d4750]">
                            Baca Selengkapnya
                        </a>
                        @else
                        <a href="{{ route('blog.index') }}" class="bb-btn-2 transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[6px] px-[20px] text-[13px] font-medium text-[#fff] bg-[#6c7fd8] rounded-[10px] border-[1px] border-solid border-[#6c7fd8] hover:bg-transparent hover:border-[#3d4750] hover:text-[#3d4750]">
                            Lihat Blog
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @endsection

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Modal logic removed since it was converted to a static banner
            });

            // Gabungkan checkbox kategori jadi 1 query string sebelum submit form
            document.getElementById('filter-form').addEventListener('submit', function() {
                const checked = Array.from(document.querySelectorAll('.filter-category:checked')).map(el => el.value);
                document.getElementById('category-hidden').value = checked.join(',');
                document.getElementById('sort-select').setAttribute('name', 'sort');
            });

            // Live Search & Sort
            function reloadGrid() {
                const params = new URLSearchParams(window.location.search);
                const q = document.getElementById('live-search').value;
                const sort = document.getElementById('sort-select').value;
                const checked = Array.from(document.querySelectorAll('.filter-category:checked')).map(el => el.value);

                if (q) params.set('q', q);
                else params.delete('q');
                params.set('sort', sort);
                if (checked.length > 0) params.set('category', checked.join(','));
                else params.delete('category');

                fetch(`{{ route('products.index') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                    })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('product-grid').innerHTML = html;
                        window.history.pushState({}, '', `{{ route('products.index') }}?${params.toString()}`);
                    });
            }

            let searchDebounce;
            document.getElementById('live-search').addEventListener('input', function() {
                clearTimeout(searchDebounce);
                searchDebounce = setTimeout(reloadGrid, 400);
            });
            document.getElementById('sort-select').addEventListener('change', reloadGrid);
            // Re-bind change for filter-form checkboxes if we want live reloading for them too
            document.querySelectorAll('.filter-category').forEach(el => {
                el.addEventListener('change', reloadGrid);
            });
        </script>
        @endpush