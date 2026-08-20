<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Arinna Hidayah Bakery — Roti & Kue Segar Setiap Hari.">
    <title>@yield('title', 'Arinna Hidayah Bakery')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/img/favicon/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/vendor/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/jquery-range-ui.css') }}">

    {{-- tailwindcss --}}
    <script src="{{ asset('assets/js/vendor/tailwindcss3.4.5.js') }}"></script>

    {{-- Main Style --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
        }

        .font-quicksand {
            font-family: 'Quicksand', ui-serif, serif;
        }

        .font-Poppins {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
        }

        .font-hero {
            font-family: 'Quicksand', 'Poppins', ui-sans-serif, system-ui, sans-serif;
        }
    </style>

    @stack('head')
</head>

<body class="bg-[#fff]">

    <div
        class="bb-loader min-w-full w-full h-screen fixed top-[0] left-[0] flex items-center justify-center bg-[#fff] z-[45]">
        <img src="{{ asset('build/assets/img/logo/arinna_loader.png') }}" alt="loader" class="absolute">
        <span class="loader w-[60px] h-[60px] relative"></span>
    </div>

    @include('partials.header')

    <main class="min-h-screen">
        @if (session('success'))
        <div
            class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] px-[12px] mt-4">
            <div class="w-full px-[12px]">
                <div
                    class="flex items-center gap-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-[10px] px-5 py-3.5">
                    <i class="ri-checkbox-circle-line text-emerald-500 text-[18px]"></i>
                    <span class="font-Poppins text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div
            class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] px-[12px] mt-4">
            <div class="w-full px-[12px]">
                <div
                    class="flex items-center gap-3 bg-rose-50 text-rose-800 border border-rose-200 rounded-[10px] px-5 py-3.5">
                    <i class="ri-error-warning-line text-rose-500 text-[18px]"></i>
                    <span class="font-Poppins text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    <a href="#Top"
        class="back-to-top result-placeholder transition-all duration-[0.3s] ease-in-out w-[38px] h-[38px] hidden fixed right-[15px] bottom-[15px] z-[10] rounded-[20px] cursor-pointer bg-[#fff] text-[#6c7fd8] border-[1px] border-solid border-[#6c7fd8] text-center text-[22px] leading-[1.6]">
        <i class="ri-arrow-up-line text-[20px]"></i>
        <div class="back-to-top-wrap active-progress">
            <svg viewBox="-1 -1 102 102" class="w-[36px] h-[36px] fixed right-[16px] bottom-[16px]">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                    class="fill-transparent stroke-[5px] stroke-[#6c7fd8]"></path>
            </svg>
        </div>
    </a>
    {{-- Plugins --}}
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/aos.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/smoothscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/countdownTimer.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-range-ui.min.js') }}"></script>

    {{-- main-js --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
