@if ($products->isEmpty())
    <div class="rounded-[28px] border border-dashed border-[#dfe5ff] bg-white py-16 text-center shadow-sm">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#eef1ff] text-2xl text-[#6c7fd8]">
            <i class="ri-cake-3-line"></i>
        </div>
        <p class="text-base font-semibold text-stone-700">Produk tidak ditemukan.</p>
        <p class="mt-2 text-sm text-stone-500">Coba ubah kata kunci atau filter pencarian Anda.</p>
    </div>
@else
    @php
        // Group the paginated products by category name
        $groupedProducts = $products->groupBy(function($item) {
            return $item->category ? $item->category->name : 'Produk Lainnya';
        });
    @endphp

    <div class="rounded-[28px] border border-[#e7ebff] bg-white p-4 shadow-[0_18px_35px_rgba(108,127,216,0.06)] sm:p-5 md:p-8">
        @foreach ($groupedProducts as $categoryName => $categoryProducts)
        <div class="mb-12 last:mb-0 pb-8 border-b border-[#e5e9ff] last:border-0 last:pb-0">
            
            {{-- Category Header (Lampiran 1 style) --}}
            <div class="relative flex justify-center mb-10">
                <div class="bg-[#002159] text-white py-2.5 px-10 md:px-16 rounded-md shadow-md relative z-10 border border-[#1a3869] text-center">
                    {{-- Border accents on corners --}}
                    <div class="absolute -top-[3px] -left-[3px] w-3 h-3 border-t-2 border-l-2 border-[#d4af37]"></div>
                    <div class="absolute -bottom-[3px] -right-[3px] w-3 h-3 border-b-2 border-r-2 border-[#d4af37]"></div>
                    <div class="absolute -top-[3px] -right-[3px] w-3 h-3 border-t-2 border-r-2 border-[#d4af37]"></div>
                    <div class="absolute -bottom-[3px] -left-[3px] w-3 h-3 border-b-2 border-l-2 border-[#d4af37]"></div>
                    
                    <h2 class="font-display text-xl md:text-2xl font-extrabold uppercase tracking-widest m-0">{{ $categoryName }}</h2>
                </div>
                {{-- Horizontal line behind --}}
                <div class="absolute top-1/2 left-0 w-full h-[2px] bg-[#002159] -translate-y-1/2 z-0 hidden md:block"></div>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 md:gap-6 justify-items-center">
                @foreach ($categoryProducts as $product)
                @php
                    $primaryImg = $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : asset('assets/img/new-product/1.jpg');
                    $rating = (float) ($product->average_rating ?? 0);
                    $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
                @endphp
                <div class="bg-[#f0f2f5] rounded-[24px] overflow-hidden relative flex flex-col items-center shadow-sm hover:shadow-md transition group h-full w-full max-w-[260px] border border-[#e5e9ff]">
                    
                    {{-- NEW Badge --}}
                    @if ($product->is_new)
                    <div class="absolute top-3 right-3 z-10">
                        <span class="bg-[#e41e26] text-white text-[9px] md:text-[10px] font-black px-2 py-1 rounded shadow shadow-red-500/30 tracking-wider">NEW</span>
                    </div>
                    @endif
                    
                    {{-- Image --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="w-full relative block overflow-hidden">
                        <img src="{{ $primaryImg }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300 bg-white">
                    </a>
                    
                    {{-- Content --}}
                    <div class="text-center w-full mt-auto p-4 md:p-5">
                        <h3 class="font-extrabold text-stone-900 text-[14px] md:text-[16px] leading-tight mb-1 line-clamp-2 min-h-[36px] md:min-h-[40px] flex items-center justify-center">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-[#6c7fd8] transition-colors">{{ $product->name }}</a>
                        </h3>
                        
                        {{-- Rating --}}
                        <div class="flex items-center justify-center gap-1 mb-1.5">
                            <div class="flex text-[12px] md:text-[13px]">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($rating))
                                        <i class="ri-star-fill text-yellow-400"></i>
                                    @else
                                        <i class="ri-star-line text-stone-300"></i>
                                    @endif
                                @endfor
                            </div>
                            @if ($product->reviews_count > 0)
                                <span class="text-[10px] md:text-xs text-stone-500">({{ $product->reviews_count }})</span>
                            @endif
                        </div>

                        {{-- Price --}}
                        <div class="flex flex-col items-center justify-center gap-0.5">
                            @if ($hasDiscount)
                                <span class="text-[11px] md:text-[12px] text-stone-400 line-through">Rp. {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-[14px] md:text-[15px] font-bold text-[#e41e26]">Rp. {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="text-[13px] md:text-[15px] font-bold text-stone-700 mt-3 md:mt-4">Rp. {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="mt-8 flex justify-center pt-6 border-t border-[#e5e9ff]">
                <nav aria-label="Pagination" class="inline-flex flex-wrap items-center justify-center gap-2 rounded-full border border-[#e3e8ff] bg-[#f5f7ff] px-3 py-2 shadow-sm">
                    @php
                        $current = $products->currentPage();
                        $last = $products->lastPage();
                        $start = max(1, $current - 1);
                        $end = min($last, $current + 1);
                    @endphp

                    @if ($products->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-300">
                            <i class="ri-arrow-left-s-line text-lg"></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-600 transition hover:border-[#c8d1ff] hover:text-[#6c7fd8]">
                            <i class="ri-arrow-left-s-line text-lg"></i>
                        </a>
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $current)
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#002159] text-sm font-semibold text-white shadow-md">{{ $page }}</span>
                        @else
                            <a href="{{ $products->url($page) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-sm font-medium text-stone-600 transition hover:border-[#c8d1ff] hover:text-[#6c7fd8]">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($current < $last)
                        <a href="{{ $products->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-600 transition hover:border-[#c8d1ff] hover:text-[#6c7fd8]">
                            <i class="ri-arrow-right-s-line text-lg"></i>
                        </a>
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-300">
                            <i class="ri-arrow-right-s-line text-lg"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
@endif
