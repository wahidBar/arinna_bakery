@php
$p = $product ?? null;

// Gambar utama & hover — sesuaikan relasi primaryImage kamu
$img = $p?->primaryImage?->image_path
? asset('storage/' . $p->primaryImage->image_path)
: asset('assets/img/new-product/1.jpg');

$hoverImg = $p?->secondaryImage?->image_path
? asset('storage/' . $p->secondaryImage->image_path)
: $img;

$title = $p->name ?? 'Produk';
$price = $p->price ?? 0;
$discount = $p->discount_price ?? null;
$slug = $p->slug ?? null;
$id = $p->id ?? 0;
$category = $p?->category?->name;
$weight = $p->weight ?? null;
$stock = $p->stock ?? 0;

$isNew = (bool) ($p->is_new ?? false);
$isFeatured = (bool) ($p->is_featured ?? false);
$isOutOfStock = $stock <= 0;
    $isLowStock=!$isOutOfStock && $stock <=5;

    // Harga jual final: pakai discount_price kalau ada & lebih murah dari price
    $hasDiscount=$discount && $discount < $price;
    $displayPrice=$hasDiscount ? $discount : $price;
    @endphp

    <div class="bb-pro-box bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[20px]">
    <div class="bb-pro-img overflow-hidden relative border-b-[1px] border-solid border-[#eee] z-[4]">
        @if($isNew)
        <span class="flags transition-all duration-[0.3s] ease-in-out absolute z-[5] top-[10px] left-[10px]">
            <span class="font-Poppins text-[13px] text-[#777] font-bold uppercase tracking-widest">NEW</span>
        </span>
        @elseif($isFeatured)
        <span class="flags transition-all duration-[0.3s] ease-in-out absolute z-[5] top-[10px] left-[10px]">
            <span class="font-Poppins text-[13px] text-[#777] font-bold uppercase tracking-widest">HOT</span>
        </span>
        @endif

        <a href="{{ $slug ? route('products.show', $slug) : 'javascript:void(0)' }}">
            <div class="inner-img relative block overflow-hidden pointer-events-none rounded-t-[20px]">
                <img class="main-img transition-all duration-[0.3s] ease-in-out w-full aspect-square object-cover bg-[#f8f8f8]" src="{{ $img }}" alt="{{ $title }}">
                <img class="hover-img transition-all duration-[0.3s] ease-in-out absolute z-[2] top-[0] left-[0] opacity-[0] w-full aspect-square object-cover bg-[#f8f8f8]" src="{{ $hoverImg }}" alt="{{ $title }}">
            </div>
        </a>

        <ul class="bb-pro-actions transition-all duration-[0.3s] ease-in-out my-[0] mx-[auto] absolute z-[9] left-[0] right-[0] bottom-[0] flex flex-row items-center justify-center opacity-[0]">
            <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                <a href="javascript:void(0)" title="Wishlist" onclick="addToWishlist('{{ $id }}')" class="w-[35px] h-[35px] flex items-center justify-center">
                    <i class="ri-heart-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                </a>
            </li>
            <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                <a href="{{ $slug ? route('products.show', $slug) : 'javascript:void(0)' }}" title="Quick View" class="bb-modal-toggle w-[35px] h-[35px] flex items-center justify-center">
                    <i class="ri-eye-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                </a>
            </li>
            <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                <a href="{{ route('compare.index') }}" title="Compare" class="w-[35px] h-[35px] flex items-center justify-center">
                    <i class="ri-repeat-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                </a>
            </li>
            <li class="bb-btn-group transition-all duration-[0.3s] ease-in-out w-[35px] h-[35px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px]">
                <a href="javascript:void(0)" title="Add To Cart" onclick="quickAddToCart('{{ $id }}')" class="w-[35px] h-[35px] flex items-center justify-center">
                    <i class="ri-shopping-bag-4-line transition-all duration-[0.3s] ease-in-out text-[18px] text-[#777] leading-[10px]"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="bb-pro-contact p-[20px]">
        <div class="bb-pro-subtitle mb-[8px] flex flex-wrap justify-between">
            <a href="{{ $category ? route('products.index', ['category' => $p->category->slug]) : '#' }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] leading-[16px] text-[#777] font-light tracking-[0.03rem]">{{ $category ?? '-' }}</a>
            <span class="bb-pro-rating">
                <i class="ri-star-fill float-left text-[15px] mr-[3px] leading-[18px] text-[#fea99a]"></i>
                <i class="ri-star-fill float-left text-[15px] mr-[3px] leading-[18px] text-[#fea99a]"></i>
                <i class="ri-star-fill float-left text-[15px] mr-[3px] leading-[18px] text-[#fea99a]"></i>
                <i class="ri-star-fill float-left text-[15px] mr-[3px] leading-[18px] text-[#fea99a]"></i>
                <i class="ri-star-line float-left text-[15px] mr-[3px] leading-[18px] text-[#777]"></i>
            </span>
        </div>
        <h4 class="bb-pro-title mb-[8px] text-[16px] leading-[18px]">
            <a href="{{ $slug ? route('products.show', $slug) : 'javascript:void(0)' }}" class="transition-all duration-[0.3s] ease-in-out font-quicksand w-full block whitespace-nowrap overflow-hidden text-ellipsis text-[15px] leading-[18px] text-[#3d4750] font-semibold tracking-[0.03rem]">{{ $title }}</a>
        </h4>
        <div class="bb-price flex flex-wrap justify-between">
            <div class="inner-price mx-[-3px]">
                <span class="new-price px-[3px] text-[16px] text-[#686e7d] font-bold">Rp {{ number_format($displayPrice, 0, ',', '.') }}</span>
                @if($hasDiscount)
                <span class="old-price px-[3px] text-[14px] text-[#686e7d] line-through">Rp {{ number_format($price, 0, ',', '.') }}</span>
                @endif
            </div>

            @if($isOutOfStock)
            <span class="item-left px-[3px] text-[14px] text-[#6c7fd8]">Out Of Stock</span>
            @elseif($isLowStock)
            <span class="item-left px-[3px] text-[14px] text-[#6c7fd8]">{{ $stock }} Left</span>
            @elseif($weight)
            <span class="last-items text-[14px] text-[#686e7d]">{{ $weight }}</span>
            @endif
        </div>
    </div>
    </div>