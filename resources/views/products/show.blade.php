@extends('layouts.app')

@section('title', $product->name . ' — Arinna Hidayah Bakery')

@section('content')
<section class="section-breadcrumb mb-[50px] max-[1199px]:mb-[35px] border-b-[1px] border-solid border-[#eee] bg-[#f8f8fb]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full">
            <div class="w-full px-[12px]">
                <div class="flex flex-wrap w-full bb-breadcrumb-inner m-[0] py-[20px] items-center">
                    <div class="min-[768px]:w-[50%] min-[576px]:w-full w-full px-[12px]">
                        <h2 class="bb-breadcrumb-title font-quicksand tracking-[0.03rem] leading-[1.2] text-[16px] font-bold text-[#3d4750] max-[767px]:text-center max-[767px]:mb-[10px]">
                            {{ $product->name }}
                        </h2>
                    </div>
                    <div class="min-[768px]:w-[50%] min-[576px]:w-full w-full px-[12px]">
                        <ul class="bb-breadcrumb-list mx-[-5px] flex justify-end max-[767px]:justify-center">
                            <li class="bb-breadcrumb-item text-[14px] font-normal px-[5px]">
                                <a href="{{ route('home') }}" class="font-Poppins text-[14px] leading-[28px] tracking-[0.03rem] font-semibold text-[#686e7d]">Home</a>
                            </li>
                            <li class="text-[14px] font-normal px-[5px]"><i class="ri-arrow-right-double-fill text-[14px] font-semibold leading-[28px]"></i></li>
                            <li class="bb-breadcrumb-item font-Poppins text-[#686e7d] text-[14px] leading-[28px] font-normal tracking-[0.03rem] px-[5px] active">
                                {{ $product->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-product py-[50px] max-[1199px]:py-[35px]">
    <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
        <div class="flex flex-wrap w-full">
            <div class="w-full">
                <div class="bb-single-pro mb-[24px]">
                    <div class="flex flex-wrap w-full">

                        {{-- ===================== GALLERY (slick slider, seperti lampiran 2) ===================== --}}
                        <div class="min-[992px]:w-[41.66%] w-full px-[12px] mb-[24px]">
                            <div class="single-pro-slider sticky top-[0] p-[15px] border-[1px] border-solid border-[#eee] rounded-[24px] max-[991px]:max-w-[500px] max-[991px]:m-auto">

                                <div class="single-product-cover">
                                    @forelse ($product->images as $image)
                                        <div class="single-slide zoom-image-hover rounded-tl-[15px] rounded-tr-[15px]">
                                            <div class="aspect-square w-full overflow-hidden rounded-tl-[15px] rounded-tr-[15px]">
                                                <img class="img-responsive rounded-tl-[15px] rounded-tr-[15px] w-full h-full object-cover"
                                                     src="{{ asset('storage/' . $image->image_path) }}"
                                                     alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                    @empty
                                        <div class="single-slide rounded-tl-[15px] rounded-tr-[15px]">
                                            <div class="aspect-square w-full overflow-hidden rounded-tl-[15px] rounded-tr-[15px]">
                                                <img class="img-responsive rounded-tl-[15px] rounded-tr-[15px] w-full h-full object-cover"
                                                     src="{{ asset('images/placeholder.jpg') }}"
                                                     alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                                @if ($product->images->count() > 1)
                                    <div class="single-nav-thumb w-full overflow-hidden mx-[-8px]">
                                        @foreach ($product->images as $image)
                                            <div class="single-slide px-[10px] block">
                                                <div class="w-[70px] h-[70px] overflow-hidden rounded-[15px]">
                                                    <img class="img-responsive border-[1px] border-solid border-transparent transition-all duration-[0.3s] ease delay-[0s] cursor-pointer rounded-[15px] w-full h-full object-cover"
                                                         src="{{ asset('storage/' . $image->image_path) }}"
                                                         alt="{{ $product->name }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ===================== INFO PRODUK ===================== --}}
                        <div class="min-[992px]:w-[58.33%] w-full px-[12px] mb-[24px]">
                            <div class="bb-single-pro-contact">
                                <div class="bb-sub-title mb-[20px]">
                                    <h4 class="font-quicksand text-[22px] tracking-[0.03rem] font-bold leading-[1.2] text-[#3d4750]">{{ $product->name }}</h4>
                                </div>

                                <div class="bb-single-rating mb-[12px]">
                                    <span class="bb-pro-rating mr-[10px]">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="ri-star-{{ $i <= round($product->average_rating) ? 'fill' : 'line' }} float-left text-[15px] mr-[3px] {{ $i <= round($product->average_rating) ? 'text-[#fea99a]' : 'text-[#777]' }}"></i>
                                        @endfor
                                    </span>
                                    <span class="bb-read-review">
                                        |&nbsp;&nbsp;<a href="#reviews" class="font-Poppins text-[15px] font-light leading-[28px] tracking-[0.03rem] text-[#6c7fd8]">{{ $product->reviews_count }} ulasan</a>
                                    </span>
                                </div>

                                <p class="font-Poppins text-[15px] font-light leading-[28px] tracking-[0.03rem] text-[#686e7d]">
                                    {{ $product->description ? Str::limit(strip_tags($product->description), 220) : 'Deskripsi produk belum tersedia untuk saat ini.' }}
                                </p>

                                <div class="bb-single-price-wrap flex justify-between py-[10px] gap-[20px] flex-wrap">
                                    <div class="bb-single-price py-[15px]">
                                        <div class="price mb-[8px]">
                                            <h5 class="font-quicksand leading-[1.2] tracking-[0.03rem] text-[20px] font-extrabold text-[#3d4750]">
                                                @if ($product->discount_price)
                                                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                                    <span class="text-[#3d4750] text-[20px]">-{{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%</span>
                                                @else
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="mrp">
                                            <p class="font-Poppins text-[16px] font-light text-[#686e7d] leading-[28px] tracking-[0.03rem]">
                                                Harga Normal :
                                                @if ($product->discount_price)
                                                    <span class="text-[15px] line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-[15px]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="bb-single-price py-[15px]">
                                        <div class="sku mb-[8px]">
                                            <h5 class="font-quicksand text-[18px] font-extrabold leading-[1.2] tracking-[0.03rem] text-[#3d4750]">
                                                SKU: {{ $product->sku ?? 'N/A' }}
                                            </h5>
                                        </div>
                                        <div class="stock">
                                            <span class="text-[18px] {{ $product->stock > 0 ? 'text-[#6c7fd8]' : 'text-[#ef4444]' }}">
                                                {{ $product->stock > 0 ? 'Stok tersedia' : 'Stok habis' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bb-single-list mb-[30px]">
                                    <ul class="my-[-8px] pl-[18px]">
                                        <li class="my-[8px] font-Poppins text-[14px] font-light leading-[28px] tracking-[0.03rem] text-[#777] list-disc">
                                            <span class="font-Poppins text-[#777] text-[14px]">Kategori :</span> {{ $product->category->name ?? 'Umum' }}
                                        </li>
                                        <li class="my-[8px] font-Poppins text-[14px] font-light leading-[28px] tracking-[0.03rem] text-[#777] list-disc">
                                            <span class="font-Poppins text-[#777] text-[14px]">Berat :</span> {{ $product->weight ?: 'Belum ditentukan' }}
                                        </li>
                                        <li class="my-[8px] font-Poppins text-[14px] font-light leading-[28px] tracking-[0.03rem] text-[#777] list-disc">
                                            <span class="font-Poppins text-[#777] text-[14px]">Stok :</span> {{ $product->stock }} pcs
                                        </li>
                                        <li class="my-[8px] font-Poppins text-[14px] font-light leading-[28px] tracking-[0.03rem] text-[#777] list-disc">
                                            <span class="font-Poppins text-[#777] text-[14px]">Rating :</span> {{ number_format($product->average_rating, 1) }}/5
                                        </li>
                                    </ul>
                                </div>

                                {{-- Qty + tombol aksi (Tambah keranjang / Beli sekarang), + wishlist & quick view seperti lampiran 2 --}}
                                <form id="add-to-cart-form" class="bb-single-qty flex flex-wrap m-[-2px] items-center">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="qty-plus-minus m-[2px] w-[120px] h-[48px] py-[7px] border-[1px] border-solid border-[#eee] overflow-hidden relative flex items-center justify-between bg-[#fff] rounded-[10px]">
                                        <input class="qty-input text-[#777] float-left text-[14px] h-auto m-[0] p-[0] text-center w-[32px] outline-[0] font-normal leading-[35px] rounded-[10px]"
                                               type="number" name="qty" id="qty-input" value="1" min="1" max="{{ $product->stock }}">
                                    </div>

                                    <div class="buttons m-[2px] flex gap-[8px] flex-wrap">
                                        <button type="button" onclick="addToCart(false)"
                                                class="bb-btn-2 transition-all duration-[0.3s] ease-in-out h-[48px] flex font-Poppins leading-[28px] tracking-[0.03rem] py-[10px] px-[25px] text-[14px] font-normal text-[#fff] bg-[#6c7fd8] rounded-[10px] border-[1px] border-solid border-[#6c7fd8] hover:bg-transparent hover:border-[#3d4750] hover:text-[#3d4750] disabled:opacity-50 disabled:cursor-not-allowed"
                                                @if($product->stock < 1) disabled @endif>
                                            Tambah ke Keranjang
                                        </button>
                                        <button type="button" onclick="addToCart(true)"
                                                class="bb-btn-2 transition-all duration-[0.3s] ease-in-out h-[48px] flex font-Poppins leading-[28px] tracking-[0.03rem] py-[10px] px-[25px] text-[14px] font-normal text-[#3d4750] bg-transparent rounded-[10px] border-[1px] border-solid border-[#3d4750] hover:bg-[#3d4750] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed"
                                                @if($product->stock < 1) disabled @endif>
                                            Beli Sekarang
                                        </button>
                                    </div>

                                    <ul class="bb-pro-actions my-[2px] flex">
                                        <li class="bb-btn-group">
                                            <button type="button" title="Wishlist"
                                                    class="bb-wishlist-toggle transition-all duration-[0.3s] ease-in-out w-[48px] h-[48px] mx-[2px] flex items-center justify-center text-[#fff] bg-[#fff] hover:bg-[#6c7fd8] border-[1px] border-solid border-[#eee] rounded-[10px]">
                                                <i class="ri-heart-line text-[18px] leading-[10px] text-[#777]"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== ACCORDION: Detail / Info / Reviews ===================== --}}
                <div class="w-full px-[12px]">
                    <div class="bey-single-accordion border-[1px] border-solid border-[#eee] p-[15px] rounded-[20px]" x-data="{ openTab: 'detail' }">
                        <div class="bb-accordion style-1 mb-[-24px]">
                            <div class="bb-accordion-item overflow-hidden mb-[24px]">
                                <h4 @click="openTab = 'detail'" :class="openTab === 'detail' ? 'active-arrow' : ''" class="accordion-head m-[0] py-[1rem] px-[1.25rem] text-[#4b5966] text-[16px] leading-[20px] font-medium relative rounded-[15px] border-[1px] border-solid border-[#eee] font-Poppins cursor-pointer tracking-[0] max-[767px]:text-[15px]">
                                    Product Detail
                                </h4>
                                <div x-show="openTab === 'detail'" class="accordion-body p-[1.25rem]">
                                    <div class="bb-details">
                                        <p class="mb-[12px] font-Poppins text-[#686e7d] leading-[28px] tracking-[0.03rem] font-light">
                                            {{ $product->description ?: 'Deskripsi produk belum tersedia untuk saat ini.' }}
                                        </p>
                                        <div class="details-info">
                                            <ul class="list-disc pl-[20px] mb-[0]">
                                                <li class="py-[5px] text-[15px] text-[#686e7d] font-Poppins leading-[28px] font-light">Kategori produk: {{ $product->category->name ?? 'Umum' }}</li>
                                                <li class="py-[5px] text-[15px] text-[#686e7d] font-Poppins leading-[28px] font-light">Stok tersedia: {{ $product->stock }} unit</li>
                                                <li class="py-[5px] text-[15px] text-[#686e7d] font-Poppins leading-[28px] font-light">Berat: {{ $product->weight ?: 'Belum ditentukan' }}</li>
                                                <li class="py-[5px] text-[15px] text-[#686e7d] font-Poppins leading-[28px] font-light">Rating rata-rata: {{ number_format($product->average_rating, 1) }}/5</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bb-accordion-item overflow-hidden mb-[24px]">
                                <h4 @click="openTab = 'info'" :class="openTab === 'info' ? 'active-arrow' : ''" class="accordion-head m-[0] py-[1rem] px-[1.25rem] text-[#4b5966] text-[16px] leading-[20px] font-medium relative rounded-[15px] border-[1px] border-solid border-[#eee] font-Poppins cursor-pointer tracking-[0] max-[767px]:text-[15px]">
                                    Information
                                </h4>
                                <div x-show="openTab === 'info'" x-cloak class="accordion-body p-[1.25rem] hidden">
                                    <div class="information">
                                        <ul class="list-disc pl-[20px]">
                                            <li class="font-Poppins text-[15px] font-light tracking-[0.03rem] leading-[28px] text-[#686e7d] py-[5px]"><span class="inline-flex min-w-[130px] font-medium">Kategori</span> {{ $product->category->name ?? 'Umum' }}</li>
                                            <li class="font-Poppins text-[15px] font-light tracking-[0.03rem] leading-[28px] text-[#686e7d] py-[5px]"><span class="inline-flex min-w-[130px] font-medium">Berat</span> {{ $product->weight ?: 'Belum ditentukan' }}</li>
                                            <li class="font-Poppins text-[15px] font-light tracking-[0.03rem] leading-[28px] text-[#686e7d] py-[5px]"><span class="inline-flex min-w-[130px] font-medium">Harga</span> Rp {{ number_format($product->price, 0, ',', '.') }}</li>
                                            <li class="font-Poppins text-[15px] font-light tracking-[0.03rem] leading-[28px] text-[#686e7d] py-[5px]"><span class="inline-flex min-w-[130px] font-medium">Stok</span> {{ $product->stock }}</li>
                                            <li class="font-Poppins text-[15px] font-light tracking-[0.03rem] leading-[28px] text-[#686e7d] py-[5px]"><span class="inline-flex min-w-[130px] font-medium">Rating</span> {{ number_format($product->average_rating, 1) }}/5</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div id="reviews" class="bb-accordion-item overflow-hidden mb-[24px]">
                                <h4 @click="openTab = 'reviews'" :class="openTab === 'reviews' ? 'active-arrow' : ''" class="accordion-head m-[0] py-[1rem] px-[1.25rem] text-[#4b5966] text-[16px] leading-[20px] font-medium relative rounded-[15px] border-[1px] border-solid border-[#eee] font-Poppins cursor-pointer tracking-[0] max-[767px]:text-[15px]">
                                    Reviews
                                </h4>
                                <div x-show="openTab === 'reviews'" x-cloak class="accordion-body p-[1.25rem] hidden">
                                    <div class="bb-reviews">
                                        @forelse ($reviews as $review)
                                            <div class="reviews-bb-box flex mb-[24px] max-[575px]:flex-col">
                                                <div class="inner-image mr-[12px] max-[575px]:mr-[0] max-[575px]:mb-[12px]">
                                                    <img src="{{ $review->user && $review->user->profile_image ? asset('storage/' . $review->user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name ?? 'User') . '&background=F1C27D&color=3d4750' }}" alt="{{ $review->user->name ?? 'User' }}" class="w-[50px] h-[50px] max-w-[50px] rounded-[10px] object-cover">
                                                </div>
                                                <div class="inner-contact">
                                                    <h4 class="font-quicksand leading-[1.2] tracking-[0.03rem] mb-[5px] text-[16px] font-bold text-[#3d4750]">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                                    <div class="bb-pro-rating flex">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="ri-star-{{ $i <= $review->rating ? 'fill' : 'line' }} float-left text-[15px] mr-[3px] {{ $i <= $review->rating ? 'text-[#fea99a]' : 'text-[#777]' }}"></i>
                                                        @endfor
                                                    </div>
                                                    @if ($review->comment)
                                                        <p class="font-Poppins text-[14px] leading-[26px] font-light tracking-[0.03rem] text-[#686e7d]">{{ $review->comment }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="font-Poppins text-[14px] leading-[26px] font-light tracking-[0.03rem] text-[#686e7d]">Belum ada ulasan untuk produk ini.</p>
                                        @endforelse
                                    </div>

                                    @auth
                                        @if ($canReview)
                                            <div class="bb-reviews-form mt-[24px]">
                                                <h3 class="font-quicksand tracking-[0.03rem] leading-[1.2] mb-[8px] text-[20px] font-bold text-[#3d4750]">Tulis Ulasan</h3>

                                                <form method="POST" action="{{ route('products.reviews.store', $product) }}" enctype="multipart/form-data" class="space-y-4">
                                                    @csrf
                                                    <div class="input-box">
                                                        <select name="order_item_id" class="w-full h-[50px] border-[1px] border-solid border-[#eee] pl-[20px] outline-[0] text-[14px] font-normal text-[#777] rounded-[20px] p-[10px]" required>
                                                            <option value="">Pilih pesanan yang mau diulas</option>
                                                            @foreach (auth()->user()->orders()->where('status', 'selesai')->with('items')->get() as $order)
                                                                @foreach ($order->items->where('product_id', $product->id) as $item)
                                                                    <option value="{{ $item->id }}">{{ $order->invoice_no }} — {{ $order->created_at->format('d M Y') }}</option>
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="input-box">
                                                        <select name="rating" class="w-full h-[50px] border-[1px] border-solid border-[#eee] pl-[20px] outline-[0] text-[14px] font-normal text-[#777] rounded-[20px] p-[10px]" required>
                                                            <option value="">Pilih rating</option>
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <option value="{{ $i }}">{{ $i }} Bintang</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="input-box">
                                                        <textarea name="comment" placeholder="Bagikan pengalaman Anda..." class="w-full h-[100px] border-[1px] border-solid border-[#eee] py-[20px] pl-[20px] pr-[10px] outline-[0] text-[14px] font-normal text-[#777] rounded-[20px] p-[10px]"></textarea>
                                                    </div>

                                                    <div class="input-box">
                                                        <input type="file" name="photo" accept="image/*" class="w-full text-sm text-[#777]">
                                                    </div>

                                                    <div class="input-button">
                                                        <button type="submit" class="bb-btn-2 transition-all duration-[0.3s] ease-in-out h-[40px] inline-flex font-Poppins leading-[28px] tracking-[0.03rem] py-[4px] px-[15px] text-[14px] font-normal text-[#fff] bg-[#6c7fd8] rounded-[10px] border-[1px] border-solid border-[#6c7fd8] hover:bg-transparent hover:border-[#3d4750] hover:text-[#3d4750]">
                                                            Kirim Ulasan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($relatedProducts->count())
    <section class="section-related-product py-[50px] max-[1199px]:py-[35px]">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-[12px]">
                    <div class="section-title mb-[20px] pb-[20px] z-[5] relative flex flex-col items-center text-center max-[991px]:pb-[0]">
                        <div class="section-detail max-[991px]:mb-[12px]">
                            <h2 class="bb-title font-quicksand mb-[0] p-[0] text-[25px] font-bold text-[#3d4750] relative inline capitalize leading-[1] tracking-[0.03rem] max-[767px]:text-[23px]">
                                Related <span class="text-[#6c7fd8]">Product</span>
                            </h2>
                            <p class="font-Poppins max-w-[400px] mt-[10px] text-[14px] text-[#686e7d] leading-[18px] font-light tracking-[0.03rem] max-[991px]:mx-[auto]">
                                Browse the collection of top products.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-full px-[12px]">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                        @foreach ($relatedProducts as $related)
                            <x-product-card :product="$related" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection

{{-- Slick CSS/JS untuk single-product-cover & single-nav-thumb sudah dipanggil di layout utama, tidak perlu di-include ulang di sini --}}

@push('scripts')
<script>
    function stepQty(delta) {
        const input = document.getElementById('qty-input');
        const current = parseInt(input.value || '1', 10);
        const max = parseInt(input.max || '999', 10);
        input.value = Math.min(Math.max(current + delta, 1), max);
    }

    function addToCart(redirectToCheckout) {
        const qty = document.getElementById('qty-input').value;

        fetch("{{ route('cart.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                product_id: {{ $product->id }},
                qty: qty,
            }),
        })
        .then((res) => res.json().then((data) => ({ status: res.status, data })))
        .then(({ status, data }) => {
            if (status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            if (status === 422) {
                alert(data.message || 'Terjadi kesalahan.');
                return;
            }
            refreshCartBadge();
            if (redirectToCheckout) {
                window.location.href = "{{ route('checkout.index') }}";
                return;
            }
            alert('Produk ditambahkan ke keranjang!');
        })
        .catch(() => alert('Terjadi kesalahan saat menambahkan produk ke keranjang.'));
    }
</script>
@endpush
