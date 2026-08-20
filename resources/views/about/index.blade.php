@extends('layouts.app')

@section('title', 'Tentang Kami — Arinna Hidayah Bakery')

@section('content')
@include('partials.breadcrumb', ['items' => [['label' => 'Tentang Kami']]])

{{-- ============================================================
     HERO SECTION — Full-width banner + tim foto + headline
     ============================================================ --}}
<section class="relative bg-[#1a2236] overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0">
        <img src="{{ asset('build/assets/img/hero/about.png') }}"
             alt="Arinna Hidayah Bakery"
             class="w-full h-full object-cover object-center opacity-60">
        <div class="absolute inset-0 bg-gradient-to-r from-[#1a2236]/90 via-[#1a2236]/50 to-transparent"></div>
    </div>

    <div class="relative mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px] px-[12px] py-[70px] max-[767px]:py-[50px]">
        <div class="max-w-[520px]">
            {{-- Label --}}
            <p class="font-Poppins text-[14px] font-semibold text-[#6c7fd8] mb-[12px] tracking-[0.08rem] uppercase"
               data-aos="fade-up" data-aos-duration="800">
                Tentang Kami
            </p>

            {{-- Title --}}
            <h1 class="font-quicksand text-[48px] max-[991px]:text-[38px] max-[767px]:text-[30px] font-bold text-white leading-[1.15] mb-[6px]"
                data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                Arinna Hidayah<br>
                <span class="text-[#f5c842]">Bakery</span>
            </h1>

            {{-- Blue underline bars --}}
            <div class="flex gap-[5px] mb-[22px]" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">
                <span class="w-[32px] h-[4px] rounded-full bg-[#6c7fd8]"></span>
                <span class="w-[12px] h-[4px] rounded-full bg-[#6c7fd8] opacity-60"></span>
                <span class="w-[6px] h-[4px] rounded-full bg-[#6c7fd8] opacity-30"></span>
            </div>

            {{-- Tagline --}}
            <p class="font-Poppins text-[18px] max-[767px]:text-[15px] text-white/90 font-light leading-[1.6]"
               data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                Menyajikan kelezatan setiap hari,<br>
                menebar kebahagiaan untuk semua.
            </p>
        </div>
    </div>
</section>

{{-- ============================================================
     CERITA KAMI + VISI MISI — 2-column cards
     ============================================================ --}}
<section class="py-[50px] max-[1199px]:py-[35px] bg-white">
    <div class="mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px] px-[12px]">
        <div class="flex flex-wrap gap-y-[24px] mx-[-12px]">

            {{-- LEFT: Cerita Kami --}}
            <div class="min-[992px]:w-[50%] w-full px-[12px]" data-aos="fade-up" data-aos-duration="800">
                <div class="h-full rounded-[20px] border border-[#eee] bg-white shadow-sm overflow-hidden">
                    <div class="flex flex-wrap h-full">
                        {{-- Text left --}}
                        <div class="min-[576px]:w-[55%] w-full p-[24px] flex flex-col justify-between">
                            <div>
                                <h3 class="font-quicksand text-[18px] font-bold text-[#6c7fd8] mb-[16px] tracking-[0.03rem]">
                                    Cerita Kami
                                </h3>
                                <p class="font-Poppins text-[13px] text-[#686e7d] font-light leading-[24px] mb-[14px]">
                                    Arinna Hidayah Bakery berawal dari kecintaan pada roti dan kue berkualitas yang dibuat dengan bahan terbaik dan proses yang higienis.
                                </p>
                                <p class="font-Poppins text-[13px] text-[#686e7d] font-light leading-[24px]">
                                    Kami hadir untuk memberikan pilihan roti dan kue yang lezat, sehat, dan terjangkau bagi seluruh masyarakat.
                                </p>
                            </div>
                        </div>
                        {{-- Image right --}}
                        <div class="min-[576px]:w-[45%] w-full">
                            <img src="{{ asset('build/assets/img/hero/about.png') }}"
                                 alt="Cerita Arinna Hidayah Bakery"
                                 class="w-full h-full object-cover min-h-[180px]">
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Visi & Misi --}}
            <div class="min-[992px]:w-[50%] w-full px-[12px]" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">
                <div class="h-full rounded-[20px] border border-[#eee] bg-white shadow-sm p-[24px]">

                    {{-- Visi --}}
                    <div class="mb-[20px]">
                        <div class="flex items-center gap-[10px] mb-[10px]">
                            <div class="w-[36px] h-[36px] rounded-full bg-[#fef3c7] flex items-center justify-center shrink-0">
                                <i class="ri-eye-line text-[#f5c842] text-[18px]"></i>
                            </div>
                            <h3 class="font-quicksand text-[17px] font-bold text-[#3d4750]">Visi</h3>
                        </div>
                        <p class="font-Poppins text-[13px] text-[#686e7d] font-light leading-[22px] pl-[46px]">
                            Menjadi bakery pilihan utama yang dikenal dengan kualitas, inovasi, dan pelayanan terbaik.
                        </p>
                    </div>

                    <hr class="border-[#f3f4f6] mb-[20px]">

                    {{-- Misi --}}
                    <div>
                        <h3 class="font-quicksand text-[17px] font-bold text-[#3d4750] mb-[12px]">Misi</h3>
                        <ul class="space-y-[10px]">
                            @foreach([
                                'Menggunakan bahan baku berkualitas tinggi.',
                                'Menghasilkan produk yang lezat dan aman.',
                                'Memberikan pelayanan yang ramah dan memuaskan.',
                                'Berkontribusi pada pemberdayaan UMKM dan masyarakat lokal.',
                            ] as $misi)
                            <li class="flex items-start gap-[10px]">
                                <span class="w-[20px] h-[20px] rounded-full border-2 border-[#6c7fd8] flex items-center justify-center shrink-0 mt-[1px]">
                                    <i class="ri-check-line text-[#6c7fd8] text-[11px]"></i>
                                </span>
                                <span class="font-Poppins text-[13px] text-[#686e7d] font-light leading-[22px]">{{ $misi }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     KENAPA PILIH KAMI — 4 icon cards
     ============================================================ --}}
<section class="py-[50px] max-[1199px]:py-[35px] bg-[#f8f9fc]">
    <div class="mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px] px-[12px]">

        {{-- Section title --}}
        <div class="text-center mb-[36px]" data-aos="fade-up" data-aos-duration="800">
            <h2 class="font-quicksand text-[22px] font-bold text-[#3d4750] tracking-[0.03rem]">
                Kenapa Memilih <span class="text-[#6c7fd8]">Arinna Hidayah Bakery?</span>
            </h2>
        </div>

        {{-- Cards --}}
        <div class="flex flex-wrap mx-[-12px]">

            @php
            $keunggulan = [
                ['icon' => 'ri-bread-line',        'title' => 'Produk Berkualitas',  'desc' => 'Roti dan kue dibuat setiap hari dengan resep terbaik.'],
                ['icon' => 'ri-leaf-line',          'title' => 'Bahan Pilihan',       'desc' => 'Kami pilih bahan terbaik untuk rasa yang maksimal.'],
                ['icon' => 'ri-price-tag-3-line',   'title' => 'Harga Bersahabat',   'desc' => 'Kualitas tinggi dengan harga yang terjangkau.'],
                ['icon' => 'ri-heart-3-line',        'title' => 'Pelayanan Terbaik',  'desc' => 'Kami melayani dengan sepenuh hati untuk kepuasan Anda.'],
            ];
            @endphp

            @foreach($keunggulan as $i => $item)
            <div class="min-[992px]:w-[25%] min-[576px]:w-[50%] w-full px-[12px] mb-[24px]"
                 data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $i * 100 }}">
                <div class="bg-white rounded-[20px] border border-[#eee] shadow-sm p-[28px] text-center h-full flex flex-col items-center">
                    <div class="w-[60px] h-[60px] rounded-full bg-[#eef0fb] flex items-center justify-center mb-[16px]">
                        <i class="{{ $item['icon'] }} text-[#6c7fd8] text-[26px]"></i>
                    </div>
                    <h4 class="font-quicksand text-[16px] font-bold text-[#3d4750] mb-[8px] leading-[1.3]">{{ $item['title'] }}</h4>
                    <p class="font-Poppins text-[13px] text-[#686e7d] font-light leading-[22px]">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ============================================================
     STATISTIK + FOTO TOKO — 2 column
     ============================================================ --}}
<section class="py-[50px] max-[1199px]:py-[35px] bg-white">
    <div class="mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px] px-[12px]">
        <div class="flex flex-wrap items-center mx-[-12px]">

            {{-- LEFT: Foto toko --}}
            <div class="min-[992px]:w-[50%] w-full px-[12px] mb-[30px] min-[992px]:mb-[0]"
                 data-aos="fade-right" data-aos-duration="800">
                <div class="relative rounded-[24px] overflow-hidden shadow-md">
                    <img src="{{ asset('build/assets/img/banner-one/one.png') }}"
                         alt="Toko Arinna Hidayah Bakery"
                         class="w-full object-cover aspect-[4/3]">
                    {{-- Floating badge --}}
                    <div class="absolute bottom-[20px] left-[20px] bg-white/95 backdrop-blur-sm rounded-[14px] px-[16px] py-[10px] shadow-lg flex items-center gap-[10px]">
                        <div class="w-[36px] h-[36px] rounded-full bg-[#fef3c7] flex items-center justify-center">
                            <i class="ri-heart-3-fill text-[#f5c842] text-[16px]"></i>
                        </div>
                        <div>
                            <p class="font-Poppins text-[10px] text-[#686e7d] mb-[1px]">Baked with Love</p>
                            <p class="font-quicksand text-[12px] font-bold text-[#3d4750]">Made for You ♡</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Statistik grid --}}
            <div class="min-[992px]:w-[50%] w-full px-[12px]"
                 data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
                <div class="grid grid-cols-2 gap-[16px]">

                    @php
                    $stats = [
                        ['icon' => 'ri-store-2-line',       'value' => '10+',   'label' => 'Tahun Pengalaman'],
                        ['icon' => 'ri-bread-line',          'value' => '100+',  'label' => 'Varian Produk'],
                        ['icon' => 'ri-group-line',          'value' => '50K+',  'label' => 'Pelanggan Puas'],
                        ['icon' => 'ri-map-pin-2-line',      'value' => '5+',    'label' => 'Outlet Terpercaya'],
                    ];
                    @endphp

                    @foreach($stats as $i => $stat)
                    <div class="rounded-[18px] border border-[#eee] bg-[#f8f9fc] p-[22px] flex flex-col items-center text-center"
                         data-aos="zoom-in" data-aos-duration="600" data-aos-delay="{{ $i * 80 }}">
                        <div class="w-[48px] h-[48px] rounded-full bg-white shadow-sm flex items-center justify-center mb-[10px]">
                            <i class="{{ $stat['icon'] }} text-[#6c7fd8] text-[22px]"></i>
                        </div>
                        <h3 class="font-quicksand text-[28px] font-bold text-[#3d4750] leading-[1.1] mb-[4px]">
                            {{ $stat['value'] }}
                        </h3>
                        <p class="font-Poppins text-[12px] text-[#686e7d] font-light">{{ $stat['label'] }}</p>
                    </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     QUOTE PENUTUP
     ============================================================ --}}
<section class="py-[40px] max-[1199px]:py-[28px] bg-[#f8f9fc]">
    <div class="mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px] px-[12px]">
        <div class="bg-white rounded-[20px] border border-[#eee] shadow-sm px-[36px] py-[30px] flex items-start gap-[20px] max-[767px]:px-[20px]"
             data-aos="fade-up" data-aos-duration="800">
            <i class="ri-double-quotes-l text-[#6c7fd8] text-[48px] leading-[1] shrink-0 max-[767px]:text-[36px]"></i>
            <p class="font-Poppins text-[15px] text-[#3d4750] font-light leading-[1.8] max-[767px]:text-[13px]">
                Kami percaya, setiap roti dan kue yang kami buat<br>
                adalah wujud cinta untuk Anda dan keluarga.
            </p>
        </div>
    </div>
</section>

{{-- ============================================================
     TIM KAMI — Owl Carousel
     ============================================================ --}}
@if($teamMembers->isNotEmpty())
<section class="section-team py-[50px] max-[1199px]:py-[35px] bg-white">
    <div class="mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px] px-[12px]">

        <div class="text-center mb-[32px]" data-aos="fade-up" data-aos-duration="800">
            <h2 class="bb-title font-quicksand text-[22px] font-bold text-[#3d4750] tracking-[0.03rem]">
                Tim <span class="text-[#6c7fd8]">Kami</span>
            </h2>
            <p class="font-Poppins text-[13px] text-[#686e7d] font-light mt-[8px]">
                Kenali orang-orang hebat di balik produk kami.
            </p>
        </div>

        <div class="bb-team owl-carousel">
            @foreach($teamMembers as $index => $member)
            <div class="bb-team-box" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $index * 100 }}">
                <div class="bb-team-img mb-[20px] relative overflow-hidden rounded-[20px]">
                    {{-- Hover socials --}}
                    <div class="bb-team-socials transition-all duration-[0.3s] ease-in-out bg-[#fff] rounded-tl-[20px] rounded-bl-[20px] absolute right-[-38px]">
                        <div class="inner-shape relative"></div>
                        <ul class="mb-[0] py-[20px] px-[10px]">
                            @if($member->facebook)
                            <li class="bb-social-link leading-[28px] pb-[10px]">
                                <a href="{{ $member->facebook }}" target="_blank" rel="noopener">
                                    <i class="ri-facebook-fill text-[16px] hover:text-[#6c7fd8]"></i>
                                </a>
                            </li>
                            @endif
                            @if($member->instagram)
                            <li class="bb-social-link leading-[28px] pb-[10px]">
                                <a href="{{ $member->instagram }}" target="_blank" rel="noopener">
                                    <i class="ri-instagram-line text-[16px] hover:text-[#6c7fd8]"></i>
                                </a>
                            </li>
                            @endif
                            @if($member->linkedin)
                            <li class="bb-social-link leading-[28px]">
                                <a href="{{ $member->linkedin }}" target="_blank" rel="noopener">
                                    <i class="ri-linkedin-fill text-[16px] hover:text-[#6c7fd8]"></i>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    {{-- Photo --}}
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}"
                             alt="{{ $member->name }}"
                             class="w-full rounded-[20px] aspect-square object-cover">
                    @else
                        <div class="w-full rounded-[20px] bg-[#eef0fb] flex items-center justify-center"
                             style="padding-top: 100%; position: relative;">
                            <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 font-quicksand font-bold text-[64px] text-[#6c7fd8]">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="bb-team-contact text-center">
                    <h5 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[17px] font-bold text-[#3d4750]">
                        {{ $member->name }}
                    </h5>
                    <p class="font-Poppins font-light leading-[28px] tracking-[0.03rem] text-[14px] text-[#686e7d]">
                        {{ $member->role }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection
