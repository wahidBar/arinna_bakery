@php
    $settings = \App\Models\SiteSetting::pluck('value', 'key');
@endphp

<footer class="bb-footer">
    <div class="footer-container border-t-[1px] border-solid border-[#eee]">
        <div class="footer-top py-[50px] max-[1199px]:py-[35px]">
            <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
                <div class="flex flex-wrap w-full max-[991px]:mb-[-30px]">

                    {{-- Brand --}}
                    <div class="min-[992px]:w-[25%] max-[991px]:w-full w-full px-[12px] bb-footer-toggle bb-footer-cat">
                        <div class="bb-footer-widget bb-footer-company flex flex-col max-[991px]:mb-[24px]">
                            <a href="{{ route('home') }}" class="mb-[20px]">
                                <span class="font-quicksand text-[22px] font-bold text-[#3d4750] tracking-[0.03rem]">
                                    Arinna <span class="text-[#6c7fd8]">Bakery</span>
                                </span>
                            </a>
                            <p class="bb-footer-detail max-w-[400px] mb-[20px] p-[0] font-Poppins text-[14px] leading-[27px] font-normal text-[#686e7d] inline-block relative">
                                {{ $settings['site_name'] ?? 'Arinna Hidayah Bakery' }} — Bakery & pastry rumahan dengan bahan pilihan, dibuat fresh setiap hari untuk momen spesial Anda.
                            </p>
                            <div class="bb-footer-social flex gap-2">
                                @if (!empty($settings['instagram']))
                                    <a href="{{ $settings['instagram'] }}" target="_blank" class="transition-all duration-[0.3s] ease-in-out w-[30px] h-[30px] rounded-[5px] bg-[#3d4750] hover:bg-[#6c7fd8] flex items-center justify-center">
                                        <i class="ri-instagram-line text-[16px] text-[#fff]"></i>
                                    </a>
                                @endif
                                @if (!empty($settings['facebook']))
                                    <a href="{{ $settings['facebook'] }}" target="_blank" class="transition-all duration-[0.3s] ease-in-out w-[30px] h-[30px] rounded-[5px] bg-[#3d4750] hover:bg-[#6c7fd8] flex items-center justify-center">
                                        <i class="ri-facebook-fill text-[16px] text-[#fff]"></i>
                                    </a>
                                @endif
                                @if (!empty($settings['tiktok']))
                                    <a href="{{ $settings['tiktok'] }}" target="_blank" class="transition-all duration-[0.3s] ease-in-out w-[30px] h-[30px] rounded-[5px] bg-[#3d4750] hover:bg-[#6c7fd8] flex items-center justify-center">
                                        <i class="ri-tiktok-line text-[16px] text-[#fff]"></i>
                                    </a>
                                @endif
                                <a href="javascript:void(0)" class="transition-all duration-[0.3s] ease-in-out w-[30px] h-[30px] rounded-[5px] bg-[#3d4750] hover:bg-[#6c7fd8] flex items-center justify-center">
                                    <i class="ri-twitter-fill text-[16px] text-[#fff]"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div class="min-[992px]:w-[16.66%] max-[991px]:w-full w-full px-[12px] bb-footer-toggle bb-footer-info">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading font-quicksand leading-[1.2] text-[18px] font-bold mb-[20px] text-[#3d4750] tracking-[0] relative block w-full pb-[15px] capitalize border-b-[1px] border-solid border-[#eee] max-[991px]:text-[14px]">Kategori</h4>
                            <div class="bb-footer-links bb-footer-dropdown max-[991px]:mb-[35px]">
                                <ul class="align-items-center">
                                    @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(6)->get() as $cat)
                                        <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]">
                                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">{{ $cat->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Perusahaan --}}
                    <div class="min-[992px]:w-[16.66%] max-[991px]:w-full w-full px-[12px] bb-footer-toggle bb-footer-account">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading font-quicksand leading-[1.2] text-[18px] font-bold mb-[20px] text-[#3d4750] tracking-[0] relative block w-full pb-[15px] capitalize border-b-[1px] border-solid border-[#eee] max-[991px]:text-[14px]">Perusahaan</h4>
                            <div class="bb-footer-links bb-footer-dropdown max-[991px]:mb-[35px]">
                                <ul class="align-items-center">
                                    <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('home') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Tentang Kami</a></li>
                                    <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('blog.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Blog</a></li>
                                    <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('contact.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Kontak Kami</a></li>
                                    <li class="bb-footer-link leading-[1.5] flex items-center"><a href="{{ route('products.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Semua Produk</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Akun --}}
                    <div class="min-[992px]:w-[16.66%] max-[991px]:w-full w-full px-[12px] bb-footer-toggle bb-footer-service">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading font-quicksand leading-[1.2] text-[18px] font-bold mb-[20px] text-[#3d4750] tracking-[0] relative block w-full pb-[15px] capitalize border-b-[1px] border-solid border-[#eee] max-[991px]:text-[14px]">Akun</h4>
                            <div class="bb-footer-links bb-footer-dropdown max-[991px]:mb-[35px]">
                                <ul class="align-items-center">
                                    @auth
                                        <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('orders.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Pesanan Saya</a></li>
                                        <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('cart.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Keranjang</a></li>
                                    @else
                                        <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('login') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Masuk</a></li>
                                        <li class="bb-footer-link leading-[1.5] flex items-center mb-[16px] max-[991px]:mb-[15px]"><a href="{{ route('register') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] mb-[0] inline-block break-all tracking-[0] font-normal">Daftar</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Kontak --}}
                    <div class="min-[992px]:w-[25%] max-[991px]:w-full w-full px-[12px] bb-footer-toggle bb-footer-cont-social">
                        <div class="bb-footer-widget">
                            <h4 class="bb-footer-heading font-quicksand leading-[1.2] text-[18px] font-bold mb-[20px] text-[#3d4750] tracking-[0] relative block w-full pb-[15px] capitalize border-b-[1px] border-solid border-[#eee] max-[991px]:text-[14px]">Kontak</h4>
                            <div class="bb-footer-links bb-footer-dropdown max-[991px]:mb-[35px]">
                                <ul class="align-items-center">
                                    @if(!empty($settings['address']))
                                        <li class="bb-footer-link bb-foo-location flex items-start mb-[16px]">
                                            <span class="mt-[5px] w-[25px] basis-[auto] grow-[0] shrink-[0]"><i class="ri-map-pin-line leading-[0] text-[18px] text-[#6c7fd8]"></i></span>
                                            <p class="m-[0] font-Poppins text-[14px] text-[#686e7d] font-normal leading-[28px] tracking-[0.03rem]">{{ $settings['address'] }}</p>
                                        </li>
                                    @endif
                                    @if(!empty($settings['phone']))
                                        <li class="bb-footer-link bb-foo-call flex items-start mb-[16px]">
                                            <span class="w-[25px] basis-[auto] grow-[0] shrink-[0]"><i class="ri-whatsapp-line leading-[0] text-[18px] text-[#6c7fd8]"></i></span>
                                            <a href="tel:{{ $settings['phone'] }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] inline-block break-all tracking-[0] font-normal">{{ $settings['phone'] }}</a>
                                        </li>
                                    @endif
                                    @if(!empty($settings['email']))
                                        <li class="bb-footer-link bb-foo-mail flex">
                                            <span class="w-[25px] basis-[auto] grow-[0] shrink-[0]"><i class="ri-mail-line leading-[0] text-[18px] text-[#6c7fd8]"></i></span>
                                            <a href="mailto:{{ $settings['email'] }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] leading-[20px] text-[#686e7d] hover:text-[#6c7fd8] inline-block break-all tracking-[0] font-normal">{{ $settings['email'] }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="footer-bottom py-[10px] border-t-[1px] border-solid border-[#eee] max-[991px]:py-[15px]">
            <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
                <div class="flex flex-wrap w-full">
                    <div class="bb-bottom-info w-full flex flex-row items-center justify-between max-[991px]:flex-col px-[12px]">
                        <div class="footer-copy max-[991px]:mb-[10px]">
                            <div class="bb-copy font-Poppins text-[#686e7d] text-[13px] tracking-[1px] text-center font-normal leading-[2]">
                                &copy; {{ date('Y') }} <a class="transition-all duration-[0.3s] ease-in-out font-medium text-[#6c7fd8] hover:text-[#3d4750]" href="{{ route('home') }}">{{ $settings['site_name'] ?? 'Arinna Hidayah Bakery' }}</a>. Semua hak dilindungi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
