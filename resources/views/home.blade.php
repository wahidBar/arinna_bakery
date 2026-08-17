@extends('layouts.app')

@section('title', 'Arinna Hidayah Bakery — Fresh Baked Everyday')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
<style>
    .font-hero {
        font-family: 'Quicksand', 'Fraunces', ui-serif, serif;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .bb-tab-panel[data-active="false"] {
        display: none;
    }
</style>
@endpush

@section('content')

{{-- ============ HERO ============ --}}
<section class="section-hero mb-[50px] max-[1199px]:mb-[35px] py-[50px] relative bg-[#f8f8fb] overflow-hidden">
    <div class="bb-social-follow absolute left-[20px] bottom-[30px] max-[1250px]:hidden">
        <ul class="inner-links">
            <li class="p-[6px] rotate-[270deg]">
                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[16px] font-medium text-[#777] hover:text-[#6c7fd8] leading-[28px] tracking-[0.03rem] uppercase">Fb</a>
            </li>
            <li class="p-[6px] rotate-[270deg]">
                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[16px] font-medium text-[#777] hover:text-[#6c7fd8] leading-[28px] tracking-[0.03rem] uppercase">Li</a>
            </li>
            <li class="p-[6px] rotate-[270deg]">
                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[16px] font-medium text-[#777] hover:text-[#6c7fd8] leading-[28px] tracking-[0.03rem] uppercase">Dr</a>
            </li>
            <li class="p-[6px] rotate-[270deg]">
                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[16px] font-medium text-[#777] hover:text-[#6c7fd8] leading-[28px] tracking-[0.03rem] uppercase">In</a>
            </li>
        </ul>
    </div>
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full">
            <div class="w-full">
                <div class="hero-slider swiper-container swiper-fade">
                    <div class="swiper-wrapper">
                        @foreach ($sliders as $slider)
                        @php
                        // split "Explore *Healthy* & Fresh Fruits" into parts around *...*
                        preg_match('/^(.*?)\*(.*?)\*(.*)$/', $slider->title, $m);
                        $before = $m[1] ?? $slider->title;
                        $highlight = $m[2] ?? null;
                        $after = $m[3] ?? '';
                        @endphp

                        <div class="swiper-slide" data-swiper-slide-index="{{ $loop->index }}">
                            <div class="flex flex-wrap w-full mb-[-24px]">
                                <div class="min-[992px]:w-[50%] w-full px-[12px] order-2 min-[992px]:order-1 mb-[24px]">
                                    <div class="hero-contact h-full flex flex-col items-start justify-center max-[991px]:items-center">
                                        @if ($slider->subtitle)
                                        <p class="mb-[20px] font-Poppins text-[18px] text-[#777] font-light leading-[28px] tracking-[0.03rem]">
                                            {{ $slider->subtitle }}
                                        </p>
                                        @endif

                                        @if ($loop->first)
                                        <h1 class="mb-[20px] font-quicksand text-[50px] text-[#3d4750] font-bold leading-[1.2]">
                                            {{ $before }}
                                            @if ($highlight)
                                            <span class="relative text-[#6c7fd8]">{{ $highlight }}</span>
                                            @endif
                                            {!! nl2br(e($after)) !!}
                                        </h1>
                                        @else
                                        <h2 class="mb-[20px] font-quicksand text-[50px] text-[#3d4750] font-bold leading-[1.2]">
                                            {{ $before }}
                                            @if ($highlight)
                                            <span class="relative text-[#6c7fd8]">{{ $highlight }}</span>
                                            @endif
                                            {!! nl2br(e($after)) !!}
                                        </h2>
                                        @endif

                                        @if ($slider->link)
                                        <a href="{{ $slider->link }}"
                                            class="bb-btn-1 transition-all duration-[0.3s] ease-in-out font-Poppins py-[8px] px-[20px] text-[14px] text-[#3d4750] bg-transparent rounded-[10px] border-[1px] border-solid border-[#3d4750] hover:bg-[#6c7fd8] hover:border-[#6c7fd8] hover:text-[#fff]">
                                            Shop Now
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="min-[992px]:w-[50%] w-full px-[12px] order-1 min-[992px]:order-2 mb-[24px]">
                                    <div class="hero-image pr-[50px] relative max-[991px]:px-[50px] flex justify-center">
                                        <img src="{{ asset('storage/' . $slider->image) }}"
                                            alt="{{ $slider->subtitle ?? 'hero' }}"
                                            class="w-full pb-[50px] opacity-[1]">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300"
                                            class="animate-shape w-[120%] absolute top-[-50px] right-[-50px] z-[-1]">
                                            <linearGradient id="shape_{{ $slider->id }}" x1="80%" x2="0%" y1="80%" y2="0%"></linearGradient>
                                            <path d="">
                                                <animate repeatCount="indefinite" attributeName="d" dur="15s"
                                                    values="M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7...z; M51,171.3c-6.1-17.7-15.3-17.2-20.7-32...z; M37.5,186c-12.1-10.5-11.8-32.3-7.2-46.7...z">
                                                </animate>
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination swiper-pagination-white swiper-pagination-clickable swiper-pagination-bullets"></div>
                    <div class="swiper-buttons">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bb-scroll-Page absolute right-[-15px] bottom-[75px] rotate-[270deg] max-[575px]:hidden">
        <span class="scroll-bar transition-all duration-[0.3s] ease-in-out relative max-[1250px]:hidden">
            <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[16px] font-medium leading-[28px] tracking-[0.03rem] text-[#686e7d]">Scroll Page</a>
        </span>
    </div>
</section>

{{-- ============ KATEGORI ============ --}}
<section class="section-category overflow-hidden py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full mb-[-24px]">

            <div class="min-[992px]:w-[41.66%] w-full px-[12px] mb-[24px]">
                <div class="bb-category-img relative max-[991px]:hidden">
                    <img src="{{ asset('assets/img/category/ban-cat.png') }}" alt="category" class="w-full rounded-[30px]">
                    <div class="bb-offers py-[5px] px-[15px] absolute top-[20px] right-[20px] bg-[#000] opacity-[0.8] rounded-[15px]">
                        <span class="text-[14px] font-normal text-[#fff]">50% Off</span>
                    </div>
                </div>
            </div>

            <div class="min-[992px]:w-[58.33%] w-full px-[12px] mb-[24px]">
                <div class="bb-category-contact max-[991px]:mt-[-24px]">
                    <div class="category-title mb-[30px] max-[991px]:hidden" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <h2 class="font-quicksand text-[124px] text-[#fff] opacity-[0.15] font-bold leading-[1.2] tracking-[0.03rem] max-[1399px]:text-[95px] max-[1199px]:text-[70px] max-[767px]:text-[42px]">Jelajahi Kategori</h2>
                    </div>

                    @php
                    $bgColors = ['#fef1f1', '#e1fcf2', '#f4f1fe', '#fbf9e4'];
                    $categories = \App\Models\Category::withCount([
                    'products' => fn ($q) => $q->where('is_active', true),
                    ])
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->take(12)
                    ->get();
                    @endphp

                    <div class="bb-category-block owl-carousel ml-[-150px] w-[calc(100%+150px)] pt-[30px] pl-[30px] bg-[#fff] rounded-tl-[30px] relative max-[991px]:ml-[0] max-[991px]:w-full max-[991px]:p-[0]">
                        @foreach($categories as $category)
                        @php
                        $colorIndex = $loop->index % 4;
                        $bg = $bgColors[$colorIndex];
                        @endphp
                        <div class="bb-category-box p-[30px] rounded-[20px] flex flex-col items-center text-center max-[1399px]:p-[20px] category-items-{{ $colorIndex + 1 }}"
                            style="background-color: '{{ $bg }};'"
                            data-aos="flip-left" data-aos-duration="1000" data-aos-delay="{{ ($colorIndex + 1) * 200 }}">
                            <div class="category-image mb-[12px]">
                                <img src="{{ $category->icon ? asset('storage/' . $category->icon) : asset('assets/img/category/'.($colorIndex + 1).'.svg') }}"
                                    alt="{{ $category->name }}"
                                    class="w-[50px] h-[50px] max-[1399px]:h-[65px] max-[1399px]:w-[65px] max-[1199px]:h-[50px] max-[1199px]:w-[50px]">
                            </div>
                            <div class="category-sub-contact">
                                <h5 class="mb-[2px] text-[16px] font-quicksand text-[#3d4750] font-semibold tracking-[0.03rem] leading-[1.2]">
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="font-Poppins text-[16px] font-medium leading-[1.2] tracking-[0.03rem] text-[#3d4750] capitalize">{{ $category->name }}</a>
                                </h5>
                                <p class="font-Poppins text-[13px] text-[#686e7d] leading-[25px] font-light tracking-[0.03rem]">{{ $category->products_count }} items</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============ PRODUK Flash Sale ============ --}}
<section class="section-deal overflow-hidden py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full">

            {{-- Title + Countdown --}}
            <div class="w-full px-[12px]">
                <div class="section-title bb-deal mb-[20px] pb-[20px] z-[5] relative flex justify-between max-[991px]:pb-[0] max-[991px]:flex-col max-[991px]:justify-center max-[991px]:text-center">
                    <div class="section-detail max-[991px]:mb-[12px]">
                        <h2 class="bb-title font-quicksand mb-[0] p-[0] text-[25px] font-bold text-[#3d4750] relative inline capitalize leading-[1] tracking-[0.03rem] max-[767px]:text-[23px]">
                            Diskon Hari <span class="text-[#6c7fd8]">Ini</span>
                        </h2>
                        <p class="font-Poppins max-w-[400px] mt-[10px] text-[14px] text-[#686e7d] leading-[18px] font-light tracking-[0.03rem] max-[991px]:mx-[auto]">
                            Jangan tunggu lagi. Waktu terbaik adalah sekarang.
                        </p>
                    </div>
                    <div id="dealend"
                        class="dealend-timer"
                        data-deadline="{{ $dealEndsAt->toIso8601String() }}">
                    </div>
                </div>
            </div>

            {{-- Product Slider --}}
            <div class="w-full px-[12px]">
                <div class="bb-deal-slider m-[-12px]">
                    <div class="bb-deal-block owl-carousel">
                        @forelse ($flashsaleProducts as $product)
                        <div class="bb-deal-card p-[12px]">
                            <div class="bb-pro-box bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[20px]">
                                <div class="bb-pro-img overflow-hidden relative border-b-[1px] border-solid border-[#eee] z-[4]">

                                    @php
                                    $badgeText = '';
                                    if ($loop->iteration == 1) $badgeText = 'NEW';
                                    elseif ($loop->iteration == 2) $badgeText = 'HOT';
                                    elseif ($loop->iteration == 4) $badgeText = 'SALE';
                                    @endphp
                                    @if ($badgeText)
                                    <span class="flags absolute z-[5] top-[10px] left-[10px] flex flex-col items-center gap-[2px] rounded-[6px] border border-[#eee] bg-white/90 px-[6px] py-[8px] shadow-sm">
                                        @foreach (str_split($badgeText) as $char)
                                        <span class="text-[14px] text-[#777] font-medium uppercase">{{ $char }}</span>
                                        @endforeach
                                    </span>
                                    @endif

                                    @php
                                    $flashSalePrimaryImage = $product->primaryImage
                                    ? asset('storage/' . $product->primaryImage->image_path)
                                    : ($product->images->first()?->image_path ? asset('storage/' . $product->images->first()->image_path) : asset('assets/img/new-product/1.jpg'));

                                    $flashSaleSecondaryImage = $product->secondaryImage
                                    ?? $product->images->where('is_primary', false)->first()
                                    ?? $product->images->skip(1)->first();

                                    $flashSaleHoverImage = $flashSaleSecondaryImage ? asset('storage/' . $flashSaleSecondaryImage->image_path) : $flashSalePrimaryImage;
                                    $flashSaleRating = (float) ($product->average_rating ?? 0);
                                    @endphp

                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <div class="inner-img relative block overflow-hidden pointer-events-none rounded-t-[20px]">
                                            <img class="main-img transition-all duration-[0.3s] ease-in-out w-full aspect-square object-cover bg-[#f8f8f8]"
                                                src="{{ $flashSalePrimaryImage }}"
                                                alt="{{ $product->name }}">
                                            @if ($flashSaleSecondaryImage)
                                            <img class="hover-img transition-all duration-[0.3s] ease-in-out absolute z-[2] top-[0] left-[0] opacity-[0] w-full aspect-square object-cover bg-[#f8f8f8]"
                                                src="{{ $flashSaleHoverImage }}"
                                                alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                    </a>

                                    <ul class="bb-pro-actions transition-all duration-[0.3s] ease-in-out my-[0] mx-[auto] absolute z-[9] left-[0] right-[0] bottom-[0] flex flex-row items-center justify-center opacity-[0]">
                                        <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                                            <a href="javascript:void(0)" title="Wishlist" class="wishlist-toggle w-[35px] h-[35px] flex items-center justify-center" data-id="{{ $product->id }}">
                                                <i class="ri-heart-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                                            </a>
                                        </li>
                                        <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                                            <a href="{{ route('products.show', $product->slug) }}" title="Quick View" class="bb-modal-toggle w-[35px] h-[35px] flex items-center justify-center" data-id="{{ $product->id }}">
                                                <i class="ri-eye-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                                            </a>
                                        </li>
                                        <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                                            <a href="javascript:void(0)" title="Tambah Keranjang" class="add-to-cart w-[35px] h-[35px] flex items-center justify-center" data-id="{{ $product->id }}">
                                                <i class="ri-shopping-bag-4-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bb-pro-contact p-[20px]">
                                    <div class="bb-pro-subtitle mb-[8px] flex flex-wrap justify-between">
                                        <a href="{{ $product->category ? route('products.index', ['category' => $product->category->slug]) : '#' }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] leading-[16px] text-[#777] font-light tracking-[0.03rem]">
                                            {{ $product->category?->name ?? 'Produk' }}
                                        </a>
                                        <span class="bb-pro-rating">
                                            @if ($flashSaleRating > 0)
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= round($flashSaleRating) ? 'ri-star-fill text-[#fea99a]' : 'ri-star-line text-[#777]' }} float-left text-[15px] mr-[3px] leading-[18px]"></i>
                                                @endfor
                                                @endif
                                        </span>
                                    </div>

                                    <h4 class="bb-pro-title mb-[8px] text-[16px] leading-[18px]">
                                        <a href="{{ route('products.show', $product->slug) }}" class="transition-all duration-[0.3s] ease-in-out font-quicksand w-full block whitespace-nowrap overflow-hidden text-ellipsis text-[15px] leading-[18px] text-[#3d4750] font-semibold tracking-[0.03rem]">
                                            {{ $product->name }}
                                        </a>
                                    </h4>

                                    <div class="bb-price flex flex-wrap justify-between">
                                        @php
                                        $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
                                            $displayPrice = $hasDiscount ? $product->discount_price : $product->price;
                                            @endphp
                                            <div class="inner-price mx-[-3px]">
                                                <span class="new-price px-[3px] text-[16px] text-[#686e7d] font-bold">
                                                    Rp{{ number_format($displayPrice, 0, ',', '.') }}
                                                </span>
                                                @if ($hasDiscount)
                                                <span class="old-price px-[3px] text-[14px] text-[#686e7d] line-through">
                                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                                @endif
                                            </div>

                                            @if ($product->stock <= 0)
                                                <span class="item-left px-[3px] text-[14px] text-[#6c7fd8]">Stok Habis</span>
                                                @elseif ($product->stock <= 5)
                                                    <span class="item-left px-[3px] text-[14px] text-[#6c7fd8]">Sisa {{ $product->stock }}</span>
                                                    @elseif ($product->weight)
                                                    <span class="last-items text-[14px] text-[#686e7d]">{{ $product->weight }}</span>
                                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-[20px] text-center w-full text-[#777]">
                            Belum ada produk flash sale saat ini.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



{{-- ============ BANNER PROMO ============ --}}
<section class="section-banner-one overflow-hidden py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">

        <div class="flex flex-wrap w-full mb-[-24px]">

            {{-- Banner Produk Terbaru 1 --}}
            @if(isset($newestProducts[0]))
            @php
            $product = $newestProducts[0];
            @endphp

            <div class="min-[992px]:w-[50%] w-full px-[12px] mb-[24px] aos-init aos-animate"
                data-aos="fade-up"
                data-aos-duration="1000"
                data-aos-delay="400">

                <div class="banner-box p-[30px] rounded-[20px] relative overflow-hidden bg-box-color-one bg-[#fbf2e5]">

                    <div class="inner-banner-box relative z-[1] flex justify-between max-[480px]:flex-col">

                        {{-- Product Image --}}
                        <div class="side-image px-[12px] flex items-center max-[480px]:p-[0] max-[480px]:mb-[12px] max-[480px]:justify-center">

                            @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                alt="{{ $product->name }}"
                                class="max-w-max w-[280px] h-[280px] object-contain max-[1399px]:w-[230px] max-[1399px]:h-[230px] max-[1199px]:w-[140px] max-[1199px]:h-[140px] max-[991px]:w-[280px] max-[991px]:h-[280px] max-[767px]:h-[200px] max-[767px]:w-[200px] max-[575px]:w-full max-[575px]:h-[auto] max-[480px]:w-[calc(100%-70px)]">
                            @else
                            <img src="{{ asset('assets/img/banner-one/one.png') }}"
                                alt="{{ $product->name }}"
                                class="max-w-max w-[280px] h-[280px] object-contain max-[1399px]:w-[230px] max-[1399px]:h-[230px] max-[1199px]:w-[140px] max-[1199px]:h-[140px] max-[991px]:w-[280px] max-[991px]:h-[280px] max-[767px]:h-[200px] max-[767px]:w-[200px] max-[575px]:w-full max-[575px]:h-[auto] max-[480px]:w-[calc(100%-70px)]">
                            @endif

                        </div>

                        {{-- Product Information --}}
                        <div class="inner-contact max-w-[250px] px-[12px] flex flex-col items-start justify-center max-[480px]:p-[0] max-[480px]:max-w-[100%] max-[480px]:text-center max-[480px]:items-center">


                            @if($product->category)
                            <h5 class="font-quicksand mb-[15px] text-[31px] text-[#3d4750] font-bold tracking-[0.03rem] leading-[1.2] max-[991px]:text-[28px] max-[575px]:text-[24px] max-[480px]:mb-[2px] max-[480px]:text-[22px]">

                                {{ $product->category->name }}
                            </h5>

                            @endif

                            <p class="font-Poppins text-[16px] font-light leading-[28px] tracking-[0.03rem] text-[#686e7d] mb-[15px] max-[480px]:mb-[8px] max-[480px]:text-[14px]">
                                {{ $product->name }}
                                <br>
                                {{ $product->description }}
                            </p>

                            <a href="{{ route('products.show', $product->slug) }}"
                                class="bb-btn-1 transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[5px] px-[15px] text-[14px] font-normal text-[#3d4750] bg-transparent rounded-[10px] border-[1px] border-solid border-[#3d4750] hover:bg-[#6c7fd8] hover:border-[#6c7fd8] hover:text-[#fff]">
                                Lihat Produk
                            </a>

                        </div>

                    </div>

                </div>
            </div>
            @endif


            {{-- Banner Produk Terbaru 2 --}}
            @if(isset($newestProducts[1]))
            @php
            $product = $newestProducts[1];
            @endphp

            <div class="min-[992px]:w-[50%] w-full px-[12px] mb-[24px] aos-init aos-animate"
                data-aos="fade-up"
                data-aos-duration="1000"
                data-aos-delay="600">

                <div class="banner-box p-[30px] rounded-[20px] relative overflow-hidden bg-box-color-two bg-[#ffe8ee]">

                    <div class="inner-banner-box relative z-[1] flex justify-between max-[480px]:flex-col">

                        {{-- Product Image --}}
                        <div class="side-image px-[12px] flex items-center max-[480px]:p-[0] max-[480px]:mb-[12px] max-[480px]:justify-center">

                            @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                alt="{{ $product->name }}"
                                class="max-w-max w-[280px] h-[280px] object-contain max-[1399px]:w-[230px] max-[1399px]:h-[230px] max-[1199px]:w-[140px] max-[1199px]:h-[140px] max-[991px]:w-[280px] max-[991px]:h-[280px] max-[767px]:h-[200px] max-[767px]:w-[200px] max-[575px]:w-full max-[575px]:h-[auto] max-[480px]:w-[calc(100%-70px)]">
                            @else
                            <img src="{{ asset('assets/img/banner-one/two.png') }}"
                                alt="{{ $product->name }}"
                                class="max-w-max w-[280px] h-[280px] object-contain max-[1399px]:w-[230px] max-[1399px]:h-[230px] max-[1199px]:w-[140px] max-[1199px]:h-[140px] max-[991px]:w-[280px] max-[991px]:h-[280px] max-[767px]:h-[200px] max-[767px]:w-[200px] max-[575px]:w-full max-[575px]:h-[auto] max-[480px]:w-[calc(100%-70px)]">
                            @endif

                        </div>

                        {{-- Product Information --}}
                        <div class="inner-contact max-w-[250px] px-[12px] flex flex-col items-start justify-center max-[480px]:p-[0] max-[480px]:max-w-[100%] max-[480px]:text-center max-[480px]:items-center">

                            @if($product->category)
                            <h5 class="font-quicksand mb-[15px] text-[31px] text-[#3d4750] font-bold tracking-[0.03rem] leading-[1.2] max-[991px]:text-[28px] max-[575px]:text-[24px] max-[480px]:mb-[2px] max-[480px]:text-[22px]">

                                {{ $product->category->name }}
                            </h5>

                            @endif

                            <p class="font-Poppins text-[16px] font-light leading-[28px] tracking-[0.03rem] text-[#686e7d] mb-[15px] max-[480px]:mb-[8px] max-[480px]:text-[14px]">
                                {{ $product->name }}
                                <br>
                                {{ $product->description }}
                            </p>

                            <a href="{{ route('products.show', $product->slug) }}"
                                class="bb-btn-1 transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[5px] px-[15px] text-[14px] font-normal text-[#3d4750] bg-transparent rounded-[10px] border-[1px] border-solid border-[#3d4750] hover:bg-[#6c7fd8] hover:border-[#6c7fd8] hover:text-[#fff]">
                                Lihat Produk
                            </a>

                        </div>

                    </div>

                </div>
            </div>
            @endif

        </div>
    </div>
</section>

{{-- ============ CTA BANNER PENUH ============ --}}
<section class="my-10 md:my-14">
    <div class="max-w-7xl mx-auto px-4">
        <div
            class="bg-[#3d4750] rounded-[30px] px-8 py-12 md:px-14 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <span class="inline-block text-[#6c7fd8] font-semibold text-sm mb-2">Diskon 25%</span>
                <h3 class="font-hero text-2xl md:text-4xl font-bold text-white leading-tight">Nikmati Roti &amp; Kue
                    Segar Langsung dari Dapur Kami</h3>
            </div>
            <a href="{{ route('products.index') }}"
                class="shrink-0 inline-block bg-[#6c7fd8] hover:bg-white hover:text-[#3d4750] transition-colors text-white px-7 py-3 rounded-full font-semibold text-sm">Belanja
                Sekarang</a>
        </div>
    </div>
</section>

{{-- ============ PRODUK TERBARU ============ --}}
@if($featuredProducts->count())
<section class="section-product-tabs overflow-hidden py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full">
            <div class="w-full px-[12px]">
                <div class="section-title mb-[20px] pb-[20px] z-[5] relative flex justify-between max-[991px]:pb-[0] max-[991px]:flex-col max-[991px]:justify-center max-[991px]:text-center"
                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="section-detail max-[991px]:mb-[12px]">
                        <h2 class="bb-title font-quicksand mb-[0] p-[0] text-[25px] font-bold text-[#3d4750] relative inline capitalize leading-[1] tracking-[0.03rem] max-[767px]:text-[23px]">
                            Produk <span class="text-[#6c7fd8]">Terbaru</span>
                        </h2>
                        <p class="font-Poppins max-w-[400px] mt-[10px] text-[14px] text-[#686e7d] leading-[18px] font-light tracking-[0.03rem] max-[991px]:mx-[auto]">

                            Belanja produk terbaru secara online dan dapatkan gratis ongkos kirim!
                        </p>
                    </div>
                    <div class="bb-pro-tab">
                        <ul class="bb-pro-tab-nav flex flex-wrap mx-[-20px] max-[991px]:justify-center" id="ProductTab">
                            <li class="nav-item relative leading-[28px] active">
                                <a class="nav-link px-[20px] font-Poppins text-[16px] text-[#686e7d] font-medium capitalize leading-[28px] tracking-[0.03rem] block" href="#all">All</a>
                            </li>
                            @foreach($productTabCategories as $category)
                            <li class="nav-item relative leading-[28px]">
                                <a class="nav-link px-[20px] font-Poppins text-[16px] text-[#686e7d] font-medium capitalize leading-[28px] tracking-[0.03rem] block"
                                    href="#{{ $category->slug }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap w-full mb-[-24px]">
            <div class="w-full">
                <div class="tab-content">

                    {{-- Tab: All (pakai $newestProducts) --}}
                    <div class="tab-product-pane" id="all" style="display: block;">
                        <div class="flex flex-wrap w-full">
                            @forelse($newestProducts as $product)
                            @php
                            $badge = '';
                            if ($loop->iteration == 1) $badge = 'NEW';
                            elseif ($loop->iteration == 2) $badge = 'TREND';
                            @endphp
                            <div class="min-[1200px]:w-[25%] min-[768px]:w-[33.33%] w-[50%] max-[480px]:w-full px-[12px] mb-[24px]"
                                data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ (($loop->index % 4) + 1) * 200 }}">
                                <x-product-card :product="$product" :badge="$badge" />
                            </div>
                            @empty
                            <p class="w-full text-center text-[#686e7d] py-[20px]">Belum ada produk.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Tab per kategori --}}
                    @foreach($productTabCategories as $category)
                    <div class="tab-product-pane" id="{{ $category->slug }}" style="display: none;">
                        <div class="flex flex-wrap w-full">
                            @forelse($category->tab_products as $product)
                            <div class="min-[1200px]:w-[25%] min-[768px]:w-[33.33%] w-[50%] max-[480px]:w-full px-[12px] mb-[24px]"
                                data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ (($loop->index % 4) + 1) * 200 }}">
                                <x-product-card :product="$product" />
                            </div>
                            @empty
                            <p class="w-full text-center text-[#686e7d] py-[20px]">Belum ada produk {{ $category->name }}.</p>
                            @endforelse
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============ LAYANAN ============ --}}
<section class="section-services overflow-hidden py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full mb-[-24px]">

            {{-- Produk Berkualitas --}}
            <div class="min-[992px]:w-[25%] min-[768px]:w-[50%] w-full px-[12px] mb-[24px] aos-init aos-animate"
                data-aos="flip-up"
                data-aos-duration="1000"
                data-aos-delay="200">

                <div class="bb-services-box p-[30px] border-[1px] border-solid border-[#eee] rounded-[20px] text-center">

                    <div class="services-img mb-[20px] flex justify-center">
                        <img src="assets/img/services/1.png"
                            alt="Produk Berkualitas"
                            class="w-[50px]">
                    </div>

                    <div class="services-contact">
                        <h4 class="font-quicksand mb-[8px] text-[18px] font-bold text-[#3d4750] leading-[1.2] tracking-[0.03rem]">
                            Produk Berkualitas
                        </h4>

                        <p class="font-Poppins font-light text-[14px] leading-[20px] text-[#686e7d] tracking-[0.03rem]">
                            Dibuat dengan bahan berkualitas untuk menghasilkan rasa yang lezat.
                        </p>
                    </div>

                </div>
            </div>


            {{-- Aneka Pilihan --}}
            <div class="min-[992px]:w-[25%] min-[768px]:w-[50%] w-full px-[12px] mb-[24px] aos-init aos-animate"
                data-aos="flip-up"
                data-aos-duration="1000"
                data-aos-delay="400">

                <div class="bb-services-box p-[30px] border-[1px] border-solid border-[#eee] rounded-[20px] text-center">

                    <div class="services-img mb-[20px] flex justify-center">
                        <img src="assets/img/services/2.png"
                            alt="Aneka Pilihan"
                            class="w-[50px]">
                    </div>

                    <div class="services-contact">
                        <h4 class="font-quicksand mb-[8px] text-[18px] font-bold text-[#3d4750] leading-[1.2] tracking-[0.03rem]">
                            Aneka Pilihan
                        </h4>

                        <p class="font-Poppins font-light text-[14px] leading-[20px] text-[#686e7d] tracking-[0.03rem]">
                            Nikmati beragam pilihan roti, kue, ice cream, dan berbagai hidangan lezat.
                        </p>
                    </div>

                </div>
            </div>


            {{-- Selalu Fresh --}}
            <div class="min-[992px]:w-[25%] min-[768px]:w-[50%] w-full px-[12px] mb-[24px] aos-init aos-animate"
                data-aos="flip-up"
                data-aos-duration="1000"
                data-aos-delay="600">

                <div class="bb-services-box p-[30px] border-[1px] border-solid border-[#eee] rounded-[20px] text-center">

                    <div class="services-img mb-[20px] flex justify-center">
                        <img src="assets/img/services/3.png"
                            alt="Selalu Fresh"
                            class="w-[50px]">
                    </div>

                    <div class="services-contact">
                        <h4 class="font-quicksand mb-[8px] text-[18px] font-bold text-[#3d4750] leading-[1.2] tracking-[0.03rem]">
                            Selalu Fresh
                        </h4>

                        <p class="font-Poppins font-light text-[14px] leading-[20px] text-[#686e7d] tracking-[0.03rem]">
                            Produk dibuat dan disiapkan dengan mengutamakan kesegaran dan kualitas.
                        </p>
                    </div>

                </div>
            </div>


            {{-- Pelayanan Ramah --}}
            <div class="min-[992px]:w-[25%] min-[768px]:w-[50%] w-full px-[12px] mb-[24px] aos-init aos-animate"
                data-aos="flip-up"
                data-aos-duration="1000"
                data-aos-delay="800">

                <div class="bb-services-box p-[30px] border-[1px] border-solid border-[#eee] rounded-[20px] text-center">

                    <div class="services-img mb-[20px] flex justify-center">
                        <img src="assets/img/services/4.png"
                            alt="Pelayanan Ramah"
                            class="w-[50px]">
                    </div>

                    <div class="services-contact">
                        <h4 class="font-quicksand mb-[8px] text-[18px] font-bold text-[#3d4750] leading-[1.2] tracking-[0.03rem]">
                            Pelayanan Ramah
                        </h4>

                        <p class="font-Poppins font-light text-[14px] leading-[20px] text-[#686e7d] tracking-[0.03rem]">
                            Kami siap melayani dengan ramah untuk memberikan pengalaman terbaik.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============ TESTIMONI (statis) ============ --}}
<section class="section-testimonials overflow-hidden py-[100px] max-[1199px]:py-[70px] max-[991px]:p-[0]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full">
            <div class="w-full px-[12px]">
                <div class="bb-testimonials relative aos-init aos-animate"
                    data-aos="fade-up"
                    data-aos-duration="1000"
                    data-aos-delay="400">

                    {{-- Decorative Images --}}
                    <img src="assets/img/testimonials/img-1.png"
                        alt="Roti Arinna Bakery"
                        class="testimonials-img-1 z-[-1] h-[70px] w-[70px] absolute top-[0] left-[25px] rounded-[20px] rotate-[-10deg] max-[1399px]:h-[60px] max-[1399px]:w-[60px] max-[1399px]:left-[10px] max-[1199px]:hidden">

                    <img src="assets/img/testimonials/img-2.png"
                        alt="Kue Arinna Bakery"
                        class="testimonials-img-2 z-[-1] h-[50px] w-[50px] absolute bottom-[0] left-[0] rounded-[15px] rotate-[15deg] blur-[3px] max-[1199px]:hidden">

                    <img src="assets/img/testimonials/img-3.png"
                        alt="Ice Cream Arinna Bakery"
                        class="testimonials-img-3 z-[-1] h-[60px] w-[60px] absolute top-[-50px] right-[500px] rounded-[20px] rotate-[-30deg] blur-[3px] max-[991px]:hidden">

                    <img src="assets/img/testimonials/img-4.png"
                        alt="Kue Tar Arinna Bakery"
                        class="testimonials-img-4 z-[-1] h-[60px] w-[60px] absolute top-[50px] right-[250px] rounded-[20px] rotate-[15deg] max-[1399px]:top-[20px] max-[991px]:hidden">

                    <img src="assets/img/testimonials/img-5.png"
                        alt="Bakery Arinna"
                        class="testimonials-img-5 z-[-1] h-[70px] w-[70px] absolute top-[0] right-[20px] rounded-[20px] blur-[3px] max-[991px]:hidden">

                    <img src="assets/img/testimonials/img-6.png"
                        alt="Produk Arinna Bakery"
                        class="testimonials-img-6 z-[-1] h-[60px] w-[60px] absolute bottom-[30px] right-[100px] rounded-[20px] rotate-[-25deg] max-[1399px]:h-[50px] max-[1399px]:w-[50px] max-[1399px]:right-[50px] max-[1199px]:right-[0] max-[991px]:hidden">

                    <div class="inner-banner rotate-[270deg] absolute top-[0] z-[-1] left-[150px] bottom-[0] max-[1399px]:left-[110px] max-[1199px]:left-[30px] max-[991px]:hidden">
                        <h4 class="font-quicksand text-[#fff] tracking-[0.03rem] opacity-[0.15] text-[42px] font-bold leading-[1.2] max-[1399px]:text-[38px] max-[1199px]:text-[34px]">
                            Testimoni
                        </h4>
                    </div>

                    <div class="owl-carousel testimonials-slider">

                        {{-- TESTIMONIAL 1 --}}
                        <div class="bb-testimonials-inner max-w-[900px] m-[auto] max-[1399px]:max-w-[800px]">
                            <div class="flex flex-wrap mx-[-12px] testimonials-row">

                                <div class="min-[768px]:w-[33.33%] w-full px-[12px] max-[767px]:hidden">
                                    <div class="testimonials-image relative max-[575px]:mb-[20px] max-[575px]:max-w-[200px]">
                                        <img src="assets/img/testimonials/1.jpg"
                                            alt="Siti Rahma"
                                            class="w-full rounded-[30px] block">
                                    </div>
                                </div>

                                <div class="min-[768px]:w-[66.66%] w-full px-[12px]">
                                    <div class="testimonials-contact h-full flex flex-col justify-end">

                                        <div class="user max-[767px]:flex max-[767px]:items-center">
                                            <img src="assets/img/testimonials/1.jpg"
                                                alt="Siti Rahma"
                                                class="w-full hidden rounded-[15px] max-[767px]:max-w-[60px] max-[767px]:mr-[15px] max-[767px]:flex">

                                            <div class="detail">
                                                <h4 class="font-quicksand text-[#3d4750] tracking-[0.03rem] leading-[1.2] mb-[8px] text-[20px] font-bold max-[767px]:mb-[4px] max-[767px]:text-[18px]">
                                                    Siti Rahma
                                                </h4>

                                                <span class="font-Poppins font-normal tracking-[0.02rem] text-[14px] text-[#777]">
                                                    (Pelanggan)
                                                </span>
                                            </div>
                                        </div>

                                        <div class="inner-contact bg-[#fff] mt-[10px] border-[1px] border-solid border-[#eee] p-[20px] rounded-[30px]">
                                            <p class="font-Poppins text-[#686e7d] text-[14px] leading-[25px] tracking-[0.03rem] font-light">
                                                "Roti asin gurihnya enak banget! Rotinya lembut, isiannya terasa, dan rasanya pas. Cocok banget buat sarapan atau teman ngopi. Pasti bakal pesan lagi!"
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                        {{-- TESTIMONIAL 2 --}}
                        <div class="bb-testimonials-inner max-w-[900px] m-[auto] max-[1399px]:max-w-[800px]">
                            <div class="flex flex-wrap mx-[-12px] testimonials-row">

                                <div class="min-[768px]:w-[33.33%] w-full px-[12px] max-[767px]:hidden">
                                    <div class="testimonials-image relative max-[575px]:mb-[20px] max-[575px]:max-w-[200px]">
                                        <img src="assets/img/testimonials/2.jpg"
                                            alt="Dina Putri"
                                            class="w-full rounded-[30px] block">
                                    </div>
                                </div>

                                <div class="min-[768px]:w-[66.66%] w-full px-[12px]">
                                    <div class="testimonials-contact h-full flex flex-col justify-end">

                                        <div class="user max-[767px]:flex max-[767px]:items-center">
                                            <img src="assets/img/testimonials/2.jpg"
                                                alt="Dina Putri"
                                                class="w-full hidden rounded-[15px] max-[767px]:max-w-[60px] max-[767px]:mr-[15px] max-[767px]:flex">

                                            <div class="detail">
                                                <h4 class="font-quicksand text-[#3d4750] tracking-[0.03rem] leading-[1.2] mb-[8px] text-[20px] font-bold max-[767px]:mb-[4px] max-[767px]:text-[18px]">
                                                    Dina Putri
                                                </h4>

                                                <span class="font-Poppins font-normal tracking-[0.02rem] text-[14px] text-[#777]">
                                                    (Pelanggan)
                                                </span>
                                            </div>
                                        </div>

                                        <div class="inner-contact bg-[#fff] mt-[10px] border-[1px] border-solid border-[#eee] p-[20px] rounded-[30px]">
                                            <p class="font-Poppins text-[#686e7d] text-[14px] leading-[25px] tracking-[0.03rem] font-light">
                                                "Kue tarnya cantik dan rasanya juga nggak kalah enak. Teksturnya lembut, manisnya pas, dan cocok banget buat acara ulang tahun atau kumpul keluarga. Recommended!"
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                        {{-- TESTIMONIAL 3 --}}
                        <div class="bb-testimonials-inner max-w-[900px] m-[auto] max-[1399px]:max-w-[800px]">
                            <div class="flex flex-wrap mx-[-12px] testimonials-row">

                                <div class="min-[768px]:w-[33.33%] w-full px-[12px] max-[767px]:hidden">
                                    <div class="testimonials-image relative max-[575px]:mb-[20px] max-[575px]:max-w-[200px]">
                                        <img src="assets/img/testimonials/3.jpg"
                                            alt="Rizky Pratama"
                                            class="w-full rounded-[30px] block">
                                    </div>
                                </div>

                                <div class="min-[768px]:w-[66.66%] w-full px-[12px]">
                                    <div class="testimonials-contact h-full flex flex-col justify-end">

                                        <div class="user max-[767px]:flex max-[767px]:items-center">
                                            <img src="assets/img/testimonials/3.jpg"
                                                alt="Rizky Pratama"
                                                class="w-full hidden rounded-[15px] max-[767px]:max-w-[60px] max-[767px]:mr-[15px] max-[767px]:flex">

                                            <div class="detail">
                                                <h4 class="font-quicksand text-[#3d4750] tracking-[0.03rem] leading-[1.2] mb-[8px] text-[20px] font-bold max-[767px]:mb-[4px] max-[767px]:text-[18px]">
                                                    Rizky Pratama
                                                </h4>

                                                <span class="font-Poppins font-normal tracking-[0.02rem] text-[14px] text-[#777]">
                                                    (Pelanggan)
                                                </span>
                                            </div>
                                        </div>

                                        <div class="inner-contact bg-[#fff] mt-[10px] border-[1px] border-solid border-[#eee] p-[20px] rounded-[30px]">
                                            <p class="font-Poppins text-[#686e7d] text-[14px] leading-[25px] tracking-[0.03rem] font-light">
                                                "Ice cream-nya lembut dan segar, rasanya juga enak banget. Pilihan yang pas buat menikmati waktu santai bersama keluarga. Anak-anak juga suka!"
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ BLOG ============ --}}
@if($latestBlogs->count())
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-6">
            <div>
                <span class="text-[#6c7fd8] font-bold uppercase tracking-widest text-xs">Cerita Kami</span>
                <h2 class="font-hero text-2xl md:text-3xl font-bold text-[#3d4750] mt-1">Artikel Terbaru</h2>
            </div>
            <a href="{{ route('blog.index') }}"
                class="text-[#6c7fd8] font-semibold text-sm hover:text-[#3d4750] transition-colors whitespace-nowrap">Lihat
                Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestBlogs as $blog)
            <a href="{{ route('blog.show', $blog->slug) }}"
                class="relative block rounded-[30px] overflow-hidden h-64 group">
                <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute left-2 right-2 bottom-2 bg-white/90 rounded-[20px] p-4">
                    <span class="text-xs text-[#686e7d]">{{ $blog->published_at?->format('d M Y') }}</span>
                    <h3 class="font-hero font-semibold text-[#3d4750] text-sm mt-1 line-clamp-2">{{ $blog->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ NEWSLETTER ============ --}}
<section class="pb-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-[#3d4750] rounded-[30px] p-8 md:p-10 flex flex-col md:flex-row items-center gap-6">
            <div class="flex-1 text-center md:text-left">
                <h3 class="font-hero text-2xl md:text-3xl font-bold text-white">Dapatkan <span
                        class="text-[#6c7fd8]">Diskon 25%</span> untuk pembelian pertama</h3>
                <p class="mt-2 text-white/70 text-sm">Berlangganan newsletter kami untuk info promo &amp; resep terbaru.
                </p>
            </div>
            <form action="#" method="POST" class="flex gap-2 w-full md:w-auto">
                <input type="email" name="email" placeholder="you@mail.com"
                    class="px-4 py-3 rounded-full border-0 flex-1 md:w-64 text-sm focus:outline-none focus:ring-2 focus:ring-[#6c7fd8]">
                <button
                    class="bg-[#6c7fd8] hover:bg-white hover:text-[#3d4750] transition-colors text-white px-6 py-3 rounded-full font-semibold text-sm shrink-0">Kirim</button>
            </form>
        </div>
    </div>
</section>

{{-- ============ POPUP NEWSLETTER ============ --}}
<div class="bb-popnews-bg hidden fixed top-0 left-0 w-full h-full bg-[#00000080] z-[24]"></div>
<div class="bb-popnews-box w-full max-w-[600px] p-[24px] fixed left-[50%] top-[50%] translate-x-[-50%] translate-y-[-50%] bg-[#fff] hidden z-[25] text-center rounded-[15px] overflow-hidden max-[767px]:w-[90%]">
    <div class="bb-popnews-close transition-all duration-[0.3s] ease-in-out w-[16px] h-[20px] absolute top-[-5px] right-[27px] bg-[#e04e4eb3] rounded-[10px] cursor-pointer hover:bg-[#e04e4e]" title="Tutup"></div>
    <div class="flex flex-wrap mx-[-12px]">
        <div class="min-[768px]:w-[50%] w-full px-[12px]">
            <img src="{{ asset('assets/img/category/ban-cat.png') }}" alt="newsletter" class="w-full rounded-[15px] max-[767px]:hidden">
        </div>
        <div class="min-[768px]:w-[50%] w-full px-[12px]">
            <div class="bb-popnews-box-content h-full flex flex-col items-center justify-center">
                <h2 class="font-quicksand text-[#3d4750] block text-[22px] leading-[33px] font-semibold mt-[0] mx-[auto] mb-[10px] tracking-[0] capitalize">Newsletter.</h2>
                <p class="font-Poppins font-light tracking-[0.03rem] mb-[8px] text-[14px] leading-[22px] text-[#686e7d]">Berlangganan untuk mendapatkan informasi dan pembaruan terbaru dari kami.</p>
                <form class="bb-popnews-form mt-[0]" action="#" method="post">
                    <input type="email" name="newsemail" placeholder="Alamat Email" class="mb-[20px] bg-transparent border-[1px] border-solid border-[#eee] text-[#3d4750] text-[14px] py-[10px] px-[15px] w-full outline-[0] rounded-[10px] font-normal" required="">
                    <button type="button" class="bb-btn-2 transition-all duration-[0.3s] ease-in-out font-Poppins leading-[28px] tracking-[0.03rem] py-[4px] px-[15px] text-[14px] font-normal text-[#fff] bg-[#6c7fd8] rounded-[10px] border-[1px] border-solid border-[#6c7fd8] hover:bg-transparent hover:border-[#3d4750] hover:text-[#3d4750]" name="subscribe">Berlangganan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Crossfade hero slider
    (function() {
        let currentSlide = 0;
        const slides = document.querySelectorAll('#hero-slider .slide');
        const dots = document.querySelectorAll('#hero-slider .hero-dot');
        if (slides.length > 1) {
            setInterval(() => {
                slides[currentSlide].classList.replace('opacity-100', 'opacity-0');
                if (dots[currentSlide]) dots[currentSlide].classList.replace('bg-[#6c7fd8]', 'bg-white/70');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.replace('opacity-0', 'opacity-100');
                if (dots[currentSlide]) dots[currentSlide].classList.replace('bg-white/70', 'bg-[#6c7fd8]');
            }, 4000);
        }
    })();

    // Tab switcher untuk produk unggulan / terbaru
    (function() {
        const tabs = document.getElementById('bb-product-tabs');
        if (!tabs) return;
        tabs.addEventListener('click', (e) => {
            const btn = e.target.closest('.bb-tab-btn');
            if (!btn) return;
            const target = btn.dataset.tab;

            tabs.querySelectorAll('.bb-tab-btn').forEach(b => {
                b.classList.remove('text-[#3d4750]', 'border-[#6c7fd8]');
                b.classList.add('text-[#686e7d]', 'border-transparent');
            });
            btn.classList.remove('text-[#686e7d]', 'border-transparent');
            btn.classList.add('text-[#3d4750]', 'border-[#6c7fd8]');

            document.querySelectorAll('.bb-tab-panel').forEach(panel => {
                panel.setAttribute('data-active', panel.dataset.panel === target ? 'true' : 'false');
            });
        });
    })();

    // Tambah ke keranjang tanpa reload (dipakai oleh x-product-card)
    function quickAddToCart(productId) {
        fetch("{{ route('cart.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: 1
                }),
            })
            .then(res => res.json().then(data => ({
                status: res.status,
                data
            })))
            .then(({
                status,
                data
            }) => {
                if (status === 422) {
                    alert(data.message);
                    return;
                }
                if (status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                if (typeof refreshCartBadge === 'function') refreshCartBadge();
            });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('dealend');
        if (!el) return;

        const deadline = new Date(el.dataset.deadline).getTime();

        function render() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance < 0) {
                el.innerHTML = '<div class="time-block"><div class="time">00</div><span class="dots"></span></div>';
                clearInterval(timer);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            el.innerHTML = `
            <div class="time-block"><div class="time">${days}</div><span class="day">Hari</span></div>
            <div class="time-block"><div class="time">${String(hours).padStart(2, '0')}</div><span class="dots">:</span></div>
            <div class="time-block"><div class="time">${String(minutes).padStart(2, '0')}</div><span class="dots">:</span></div>
            <div class="time-block"><div class="time">${String(seconds).padStart(2, '0')}</div><span class="dots"></span></div>
        `;
        }

        render();
        const timer = setInterval(render, 1000);
    });
</script>
@endpush