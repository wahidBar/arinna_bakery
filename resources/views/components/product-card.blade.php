@props(['product', 'badge' => null])

<div class="group overflow-hidden rounded-[22px] border border-[#edf1ff] bg-white shadow-[0_18px_35px_rgba(108,127,216,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_35px_rgba(108,127,216,0.14)]">

    {{-- IMAGE + BADGE + HOVER ACTIONS --}}
    <div class="bb-pro-img relative overflow-hidden border-b border-[#edf1ff]">

        {{-- Badge (vertical, konsisten dengan section Flash Sale) --}}
        @php
        $cardBadgeText = $badge
        ?? ($product->is_new ? 'NEW' : ($product->is_featured ? 'HOT' : null));
        @endphp
        @if ($cardBadgeText)
        <span class="flags absolute left-2.5 top-2.5 z-10 flex flex-col items-center gap-[2px] rounded-[6px] border border-[#dfe5ff] bg-white/90 px-[6px] py-[8px] shadow-sm">
            @foreach (str_split($cardBadgeText) as $char)
            <span class="text-[14px] text-[#777] font-medium uppercase">{{ $char }}</span>
            @endforeach
        </span>
        @endif

        @php
        $cardPrimaryImage = $product->primaryImage
        ? asset('storage/' . $product->primaryImage->image_path)
        : ($product->images->first()?->image_path ? asset('storage/' . $product->images->first()->image_path) : asset('images/placeholder.jpg'));

        $cardSecondaryImage = $product->secondaryImage
        ?? $product->images->where('is_primary', false)->first()
        ?? $product->images->skip(1)->first();
        @endphp

        <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden rounded-t-[22px]">
            <img
                src="{{ $cardPrimaryImage }}"
                alt="{{ $product->name }}"
                class="main-img aspect-square w-full bg-[#f7f8ff] object-cover transition duration-500 ease-in-out group-hover:scale-[1.02]">
            @if ($cardSecondaryImage)
            <img
                src="{{ asset('storage/' . $cardSecondaryImage->image_path) }}"
                alt="{{ $product->name }}"
                class="hover-img absolute inset-0 z-[2] aspect-square w-full bg-[#f7f8ff] object-cover opacity-0 transition duration-500 ease-in-out group-hover:opacity-100">
            @endif
        </a>

        {{-- Hover action icons (tidak berubah) --}}
        <ul class="absolute inset-x-0 bottom-3 z-20 flex items-center justify-center gap-2 opacity-0 translate-y-2 transition duration-300 ease-in-out group-hover:translate-y-0 group-hover:opacity-100">
            <li class="relative group/btn">
                <button type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#e7ebff] bg-white text-stone-500 shadow-md transition hover:bg-[#6c7fd8] hover:text-white">
                    <i class="ri-heart-line text-[16px]"></i>
                </button>
                <span class="pointer-events-none absolute bottom-[calc(100%+8px)] left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-stone-900 px-2.5 py-1 text-[11px] font-medium text-white opacity-0 transition group-hover/btn:opacity-100">
                    Wishlist
                </span>
            </li>
            <li class="relative group/btn">
                <a href="{{ route('products.show', $product->slug) }}"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#e7ebff] bg-white text-stone-500 shadow-md transition hover:bg-[#6c7fd8] hover:text-white">
                    <i class="ri-eye-line text-[16px]"></i>
                </a>

                <span class="pointer-events-none absolute bottom-[calc(100%+8px)] left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-stone-900 px-2.5 py-1 text-[11px] font-medium text-white opacity-0 transition group-hover/btn:opacity-100">
                    Quick View
                </span>
            </li>
            <li class="relative group/btn">
                <button type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#e7ebff] bg-white text-stone-500 shadow-md transition hover:bg-[#6c7fd8] hover:text-white">
                    <i class="ri-repeat-line text-[16px]"></i>
                </button>
                <span class="pointer-events-none absolute bottom-[calc(100%+8px)] left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-stone-900 px-2.5 py-1 text-[11px] font-medium text-white opacity-0 transition group-hover/btn:opacity-100">
                    Compare
                </span>
            </li>
            <li class="relative group/btn">
                <button type="button" onclick="quickAddToCart('{{ $product->id }}')"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#e7ebff] bg-white text-stone-500 shadow-md transition hover:bg-[#6c7fd8] hover:text-white">
                    <i class="ri-shopping-bag-4-line text-[16px]"></i>
                </button>
                <span class="pointer-events-none absolute bottom-[calc(100%+8px)] left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-stone-900 px-2.5 py-1 text-[11px] font-medium text-white opacity-0 transition group-hover/btn:opacity-100">
                    Tambah Keranjang
                </span>
            </li>
        </ul>
    </div>

    {{-- CONTENT (tidak berubah) --}}
    <div class="p-4">
        <div class="mb-1.5 flex items-center justify-between">
            <a href="{{ route('products.show', $product->slug) }}" class="text-[13px] font-light tracking-wide text-stone-500 transition hover:text-[#6c7fd8]">
                {{ $product->category->name ?? '' }}
            </a>
            @php
            $cardRating = (float) ($product->reviews_avg_rating ?? $product->average_rating ?? 0);
            @endphp
            @if ($cardRating > 0)
            <span class="flex items-center gap-1">
                <i class="ri-star-fill text-[12px] text-[#f0b84e]"></i>
                <span class="text-[12px] font-medium text-stone-600">{{ number_format($cardRating, 1) }}</span>
            </span>
            @endif
        </div>

        <a href="{{ route('products.show', $product->slug) }}">
            <h3 class="mb-2 line-clamp-1 font-display text-sm font-semibold text-stone-900 transition hover:text-[#6c7fd8]">
                {{ $product->name }}
            </h3>
        </a>

        <div class="mb-1 flex items-center justify-between">
            <div class="flex items-baseline gap-2">
                @if ($product->discount_price)
                <span class="text-base font-bold text-[#6c7fd8]">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                <span class="text-xs text-stone-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                <span class="text-base font-bold text-[#6c7fd8]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>
            @if ($product->weight ?? false)
            <span class="text-xs text-stone-400">{{ $product->weight }}</span>
            @endif
        </div>
    </div>
</div>