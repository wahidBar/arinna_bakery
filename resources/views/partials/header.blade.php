<header class="bb-header relative z-[5] border-b-[1px] border-solid border-[#eee]">

    {{-- Top bar --}}
    <div class="top-header bg-[#3d4750] py-[6px] max-[991px]:hidden">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-[12px]">
                    <div class="inner-top-header flex justify-between">
                        <div class="col-left-bar">
                            <span class="font-Poppins font-light text-[14px] text-[#fff] leading-[28px] tracking-[0.03rem]">
                                Roti & Kue Segar — Dipanggang Langsung dari Dapur Kami
                            </span>
                        </div>
                        <div class="col-right-bar flex">
                            <div class="cols px-[12px]">
                                <a href="{{ route('contact.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] text-[#fff] font-light leading-[28px] tracking-[0.03rem]">Bantuan?</a>
                            </div>
                            <div class="cols px-[12px]">
                                @auth
                                <a href="{{ route('orders.index') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] text-[#fff] font-light leading-[28px] tracking-[0.03rem]">Pesanan Saya</a>
                                @else
                                <a href="{{ route('login') }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[14px] text-[#fff] font-light leading-[28px] tracking-[0.03rem]">Masuk</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom header: Logo + Search + Icons --}}
    <div class="bottom-header py-[20px] max-[991px]:py-[15px]">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-[12px]">
                    <div class="inner-bottom-header flex justify-between items-center relative max-[767px]:flex-col">

                        {{-- Logo --}}
                        <div class="cols bb-logo-detail flex max-[767px]:justify-between z-[2]">
                            <div class="header-logo flex items-center max-[575px]:justify-center">
                                <a href="{{ route('home') }}" class="flex items-center gap-[12px]">
                                    <img src="{{ asset('build/assets/img/logo/logo.png') }}" alt="Arinna Bakery Hidayah" class="w-[64px] h-[64px] max-[991px]:w-[52px] max-[991px]:h-[52px] max-[575px]:w-[46px] max-[575px]:h-[46px] object-contain">
                                    <span class="flex flex-col leading-[1.1]">
                                        <span class="font-Poppins text-[13px] italic font-light text-[#777] tracking-[0.05rem] max-[991px]:text-[11px]">Bakery</span>
                                        <span class="font-quicksand text-[24px] font-bold text-[#3d4750] tracking-[0.03rem] max-[991px]:text-[19px] whitespace-nowrap">
                                            Arinna <span class="text-[#6c7fd8]">Hidayah</span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <a href="javascript:void(0)" class="bb-sidebar-toggle bb-category-toggle hidden max-[991px]:flex max-[991px]:items-center max-[991px]:ml-[20px] max-[991px]:border-[1px] max-[991px]:border-solid max-[991px]:border-[#eee] max-[991px]:w-[40px] max-[991px]:h-[40px] max-[991px]:rounded-[15px] justify-center transition-all duration-[0.3s] ease-in-out">
                                <i class="ri-menu-3-fill text-[22px] text-[#6c7fd8]"></i>
                            </a>
                        </div>

                        {{-- Search --}}
                        <div class="cols flex justify-center absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 max-[991px]:static max-[991px]:translate-x-0 max-[991px]:translate-y-0 max-[991px]:top-auto max-[991px]:left-auto">
                            <div class="header-search w-[600px] max-[1399px]:w-[500px] max-[1199px]:w-[400px] max-[991px]:w-full max-[991px]:min-w-[300px] max-[767px]:py-[15px] max-[480px]:min-w-[auto]">
                                <form class="bb-btn-group-form flex relative max-[991px]:ml-[20px] max-[767px]:m-[0]" action="{{ route('products.index') }}" method="GET">
                                    <input class="form-control bb-search-bar bg-[#fff] block w-full min-h-[45px] h-[48px] py-[10px] px-[20px] max-[991px]:min-h-[40px] max-[991px]:h-[40px] max-[991px]:p-[10px] text-[14px] font-normal leading-[1] text-[#777] rounded-[10px] border-[1px] border-solid border-[#eee] tracking-[0.5px]" placeholder="Cari produk..." type="text" name="q" id="navbar-search">
                                    <button class="submit absolute top-[0] left-[auto] right-[0] flex items-center justify-center w-[45px] h-full bg-transparent text-[#555] text-[16px] rounded-[0] outline-[0] border-[0]" type="submit">
                                        <i class="ri-search-line text-[18px] leading-[12px] text-[#555]"></i>
                                    </button>
                                </form>
                                <div id="navbar-search-results" class="hidden absolute mt-1 w-full max-w-[600px] bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px] shadow-lg max-h-80 overflow-y-auto z-[20]"></div>
                            </div>
                        </div>

                        {{-- Icons --}}
                        <div class="cols bb-icons flex justify-center z-[2]">
                            <div class="bb-flex-justify max-[575px]:flex max-[575px]:justify-between">
                                <div class="bb-header-buttons h-full flex justify-end items-center">

                                    {{-- Account --}}
                                    <div class="bb-acc-drop relative">
                                        <a href="javascript:void(0)" class="bb-header-btn bb-header-user dropdown-toggle bb-user-toggle transition-all duration-[0.3s] ease-in-out relative flex w-[auto] items-center whitespace-nowrap ml-[30px] max-[1199px]:ml-[20px] max-[767px]:ml-[0]" title="Account">
                                            <div class="header-icon relative flex">
                                                <svg class="svg-icon w-[30px] h-[30px] max-[1199px]:w-[25px] max-[1199px]:h-[25px] max-[991px]:w-[22px] max-[991px]:h-[22px]" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                                    <path class="fill-[#6c7fd8]" d="M512.476 648.247c-170.169 0-308.118-136.411-308.118-304.681 0-168.271 137.949-304.681 308.118-304.681 170.169 0 308.119 136.411 308.119 304.681C820.594 511.837 682.645 648.247 512.476 648.247zM935.867 985.115l-26.164 0c-9.648 0-17.779-6.941-19.384-16.35-2.646-15.426-6.277-30.52-11.142-44.95-24.769-87.686-81.337-164.13-159.104-214.266-63.232 35.203-134.235 53.64-207.597 53.64-73.555 0-144.73-18.537-208.084-53.922-78 50.131-134.75 126.68-159.564 214.549-4.893 18.172-11.795 46.4-11.795 46.4-2.136 8.723-10.035 14.9-19.112 14.9L88.133 985.116c-9.415 0-16.693-8.214-15.47-17.452C91.698 824.084 181.099 702.474 305.51 637.615c58.682 40.472 129.996 64.267 206.966 64.267 76.799 0 147.968-23.684 206.584-63.991 124.123 64.932 213.281 186.403 232.277 329.772C952.56 976.901 945.287 985.115 935.867 985.115z" />
                                                </svg>
                                            </div>
                                            <div class="bb-btn-desc flex flex-col ml-[10px] max-[1199px]:hidden">
                                                <span class="bb-btn-title font-Poppins transition-all duration-[0.3s] ease-in-out text-[12px] leading-[1] text-[#3d4750] mb-[4px] tracking-[0.6px] capitalize font-medium whitespace-nowrap">
                                                    @auth {{ auth()->user()->name }} @else Akun @endauth
                                                </span>
                                                <span class="bb-btn-stitle font-Poppins transition-all duration-[0.3s] ease-in-out text-[14px] leading-[16px] font-semibold text-[#3d4750] tracking-[0.03rem] whitespace-nowrap">
                                                    @auth Profil @else Masuk @endauth
                                                </span>
                                            </div>
                                        </a>
                                        <ul class="bb-dropdown-menu min-w-[150px] py-[10px] px-[5px] transition-all duration-[0.3s] ease-in-out mt-[25px] absolute z-[16] text-left opacity-[0] right-[auto] bg-[#fff] border-[1px] border-solid border-[#eee] block rounded-[10px]">
                                            @auth
                                            <li class="py-[4px] px-[15px] m-[0]"><a class="dropdown-item transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] hover:text-[#6c7fd8] leading-[22px] block w-full font-normal tracking-[0.03rem]" href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                                            @if(auth()->user()->isAdmin())
                                            <li class="py-[4px] px-[15px] m-[0]"><a class="dropdown-item transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] hover:text-[#6c7fd8] leading-[22px] block w-full font-normal tracking-[0.03rem]" href="{{ route('admin.dashboard') }}">Admin</a></li>
                                            @endif
                                            <li class="py-[4px] px-[15px] m-[0]">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] text-rose-600 hover:text-rose-700 leading-[22px] block w-full font-normal tracking-[0.03rem] text-left">Keluar</button>
                                                </form>
                                            </li>
                                            @else
                                            <li class="py-[4px] px-[15px] m-[0]"><a class="dropdown-item transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] hover:text-[#6c7fd8] leading-[22px] block w-full font-normal tracking-[0.03rem]" href="{{ route('register') }}">Daftar</a></li>
                                            <li class="py-[4px] px-[15px] m-[0]"><a class="dropdown-item transition-all duration-[0.3s] ease-in-out font-Poppins text-[13px] hover:text-[#6c7fd8] leading-[22px] block w-full font-normal tracking-[0.03rem]" href="{{ route('login') }}">Masuk</a></li>
                                            @endauth
                                        </ul>
                                    </div>

                                    {{-- Cart --}}
                                    @auth
                                    <a href="{{ route('cart.index') }}" class="bb-header-btn bb-cart-toggle transition-all duration-[0.3s] ease-in-out relative flex w-[auto] items-center ml-[30px] max-[1199px]:ml-[20px]" title="Keranjang">
                                        <div class="header-icon relative flex">
                                            <svg class="svg-icon w-[30px] h-[30px] max-[1199px]:w-[25px] max-[1199px]:h-[25px] max-[991px]:w-[22px] max-[991px]:h-[22px]" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                                <path class="fill-[#6c7fd8]" d="M351.552 831.424c-35.328 0-63.968 28.64-63.968 63.968 0 35.328 28.64 63.968 63.968 63.968 35.328 0 63.968-28.64 63.968-63.968C415.52 860.064 386.88 831.424 351.552 831.424zM799.296 831.424c-35.328 0-63.968 28.64-63.968 63.968 0 35.328 28.64 63.968 63.968 63.968 35.328 0 63.968-28.64 63.968-63.968C863.264 860.064 834.624 831.424 799.296 831.424zM862.752 799.456 343.264 799.456c-46.08 0-86.592-36.448-92.224-83.008L196.8 334.592 165.92 156.128c-1.92-15.584-16.128-28.288-29.984-28.288L95.2 127.84c-17.664 0-32-14.336-32-31.968 0-17.664 14.336-32 32-32l40.736 0c46.656 0 87.616 36.448 93.28 83.008l30.784 177.792 54.464 383.488c1.792 14.848 15.232 27.36 28.768 27.36l519.488 0c17.696 0 32 14.304 32 31.968S880.416 799.456 862.752 799.456z" />
                                            </svg>
                                            <span id="cart-badge" class="main-label-note-new absolute -top-1 -right-1 bg-[#6c7fd8] text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                                        </div>
                                        <div class="bb-btn-desc flex flex-col ml-[10px] max-[1199px]:hidden">
                                            <span class="bb-btn-title font-Poppins transition-all duration-[0.3s] ease-in-out text-[12px] leading-[1] text-[#3d4750] mb-[4px] tracking-[0.6px] capitalize font-medium whitespace-nowrap"><b id="cart-count">0</b> item</span>
                                            <span class="bb-btn-stitle font-Poppins transition-all duration-[0.3s] ease-in-out text-[14px] leading-[16px] font-semibold text-[#3d4750] tracking-[0.03rem] whitespace-nowrap">Keranjang</span>
                                        </div>
                                    </a>
                                    @endauth

                                    <a href="javascript:void(0)" class="bb-toggle-menu hidden max-[991px]:flex max-[991px]:ml-[20px]">
                                        <div class="header-icon">
                                            <i class="ri-menu-3-fill text-[22px] text-[#6c7fd8]"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main menu --}}
    <div class="bb-main-menu-desk bg-[#fff] py-[5px] border-t-[1px] border-solid border-[#eee] max-[991px]:hidden">
        <div class="flex flex-wrap justify-between relative items-center mx-auto min-[1400px]:max-w-[1320px] min-[1200px]:max-w-[1140px] min-[992px]:max-w-[960px] min-[768px]:max-w-[720px] min-[576px]:max-w-[540px]">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-[12px]">
                    <div class="bb-inner-menu-desk flex max-[1199px]:relative max-[991px]:justify-between">
                        <a href="javascript:void(0)" class="bb-header-btn bb-sidebar-toggle bb-category-toggle transition-all duration-[0.3s] ease-in-out h-[45px] w-[45px] mr-[30px] p-[8px] flex items-center justify-center bg-[#fff] border-[1px] border-solid border-[#eee] rounded-[10px] relative max-[767px]:m-[0] max-[575px]:hidden">
                            <svg class="svg-icon w-[25px] h-[25px]" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-[#6c7fd8]" d="M384 928H192a96 96 0 0 1-96-96V640a96 96 0 0 1 96-96h192a96 96 0 0 1 96 96v192a96 96 0 0 1-96 96zM192 608a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32V640a32 32 0 0 0-32-32H192zM784 928H640a96 96 0 0 1-96-96V640a96 96 0 0 1 96-96h192a96 96 0 0 1 96 96v144a32 32 0 0 1-64 0V640a32 32 0 0 0-32-32H640a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h144a32 32 0 0 1 0 64zM384 480H192a96 96 0 0 1-96-96V192a96 96 0 0 1 96-96h192a96 96 0 0 1 96 96v192a96 96 0 0 1-96 96zM192 160a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32H192zM832 480H640a96 96 0 0 1-96-96V192a96 96 0 0 1 96-96h192a96 96 0 0 1 96 96v192a96 96 0 0 1-96 96zM640 160a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32H640z"></path>
                            </svg>
                        </a>
                        <button class="navbar-toggler shadow-none hidden" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ri-menu-2-line"></i>
                        </button>
                        <div class="bb-main-menu relative flex flex-[auto] justify-start max-[991px]:hidden" id="navbarSupportedContent">
                            <ul class="navbar-nav flex flex-wrap flex-row ">
                                @foreach (\App\Models\Menu::where('is_active', true)->orderBy('sort_order')->get() as $menu)
                                @php
                                $url = $menu->url;
                                $routeName = '';
                                if ($url === '/') {
                                $routeName = 'home';
                                } else {
                                $path = trim($url, '/');
                                if (Route::has($path . '.index')) {
                                $routeName = $path . '.index';
                                } elseif (Route::has($path)) {
                                $routeName = $path;
                                }
                                }
                                $finalUrl = $routeName ? route($routeName) : url($url);
                                @endphp
                                <li class="nav-item flex items-center font-Poppins text-[15px] text-[#686e7d] font-light leading-[28px] tracking-[0.03rem] mr-[35px]">
                                    <a class="nav-link p-[0] font-Poppins leading-[28px] text-[15px] font-medium text-[#3d4750] tracking-[0.03rem] block" href="{{ $finalUrl }}" @if($menu->open_new_tab) target="_blank" @endif>{{ $menu->label }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile menu overlay --}}
    <div class="bb-mobile-menu-overlay hidden w-full h-screen fixed top-[0] left-[0] bg-[#000000cc] z-[16]"></div>
    <div id="bb-mobile-menu" class="bb-mobile-menu transition-all duration-[0.3s] ease-in-out w-[340px] h-full pt-[15px] px-[20px] pb-[20px] fixed top-[0] right-[auto] left-[0] bg-[#fff] translate-x-[-100%] flex flex-col z-[17] overflow-auto max-[480px]:w-[300px]">
        <div class="bb-menu-title w-full pb-[10px] flex flex-wrap justify-between">
            <span class="menu_title font-Poppins flex items-center text-[16px] text-[#3d4750] font-semibold leading-[26px] tracking-[0.02rem]">Menu</span>
            <button type="button" class="bb-close-menu relative border-[0] text-[30px] leading-[1] text-[#ff0000] bg-transparent">×</button>
        </div>
        <div class="bb-menu-inner">
            <div class="bb-menu-content">
                <ul>
                    @foreach (\App\Models\Menu::where('is_active', true)->orderBy('sort_order')->get() as $menu)
                    @php
                    $url = $menu->url;
                    $routeName = '';
                    if ($url === '/') {
                    $routeName = 'home';
                    } else {
                    $path = trim($url, '/');
                    if (Route::has($path . '.index')) {
                    $routeName = $path . '.index';
                    } elseif (Route::has($path)) {
                    $routeName = $path;
                    }
                    }
                    $finalUrl = $routeName ? route($routeName) : url($url);
                    @endphp
                    <li class="relative">
                        <a href="{{ $finalUrl }}"
                            class="transition-all duration-[0.3s] ease-in-out mb-[12px] p-[12px] block font-Poppins capitalize text-[#686e7d] border-[1px] border-solid border-[#eee] rounded-[10px] text-[15px] font-medium leading-[28px] tracking-[0.03rem]"
                            @if($menu->open_new_tab) target="_blank" @endif>
                            {{ $menu->label }}
                        </a>
                    </li>
                    @endforeach
                    @auth
                    <li class="relative"><a href="{{ route('cart.index') }}" class="transition-all duration-[0.3s] ease-in-out mb-[12px] p-[12px] block font-Poppins capitalize text-[#686e7d] border-[1px] border-solid border-[#eee] rounded-[10px] text-[15px] font-medium leading-[28px] tracking-[0.03rem]">Keranjang</a></li>
                    <li class="relative"><a href="{{ route('orders.index') }}" class="transition-all duration-[0.3s] ease-in-out mb-[12px] p-[12px] block font-Poppins capitalize text-[#686e7d] border-[1px] border-solid border-[#eee] rounded-[10px] text-[15px] font-medium leading-[28px] tracking-[0.03rem]">Pesanan</a></li>
                    @else
                    <li class="relative"><a href="{{ route('login') }}" class="transition-all duration-[0.3s] ease-in-out mb-[12px] p-[12px] block font-Poppins capitalize text-[#686e7d] border-[1px] border-solid border-[#eee] rounded-[10px] text-[15px] font-medium leading-[28px] tracking-[0.03rem]">Masuk</a></li>
                    <li class="relative"><a href="{{ route('register') }}" class="transition-all duration-[0.3s] ease-in-out mb-[12px] p-[12px] block font-Poppins capitalize text-[#686e7d] border-[1px] border-solid border-[#eee] rounded-[10px] text-[15px] font-medium leading-[28px] tracking-[0.03rem]">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>

</header>

{{-- Category Sidebar Modal --}}
<div class="bb-category-sidebar transition-all duration-[0.3s] ease-in-out w-full h-full fixed top-[0] z-[17] hidden">
    <div class="bb-category-overlay hidden w-full h-screen fixed top-[0] left-[0] bg-[#00000080] z-[17]"></div>
    <div class="category-sidebar w-[calc(100%-30px)] max-[1199px]:h-[calc(100vh-60px)] max-w-[1200px] my-[15px] mx-[auto] py-[30px] px-[15px] text-[14px] font-normal transition-all duration-[0.5s] ease-in-out delay-[0s] bg-[#fff] overflow-auto rounded-[30px] z-[18] relative">
        <button type="button" class="bb-category-close transition-all duration-[0.3s] ease-in-out w-[16px] h-[20px] absolute top-[-5px] right-[27px] bg-[#e04e4eb3] rounded-[10px] cursor-pointer hover:bg-[#e04e4e]" title="Close"></button>
        <div class="w-full mx-auto">
            <div class="flex flex-wrap w-full mb-[-24px]">

                @php
                $sidebarCategories = \App\Models\Category::where('is_active', true)->where('type', 'product')->orderBy('sort_order')->get();
                $bgColors = ['#fef1f1', '#e1fcf2', '#f4f1fe', '#fbf9e4'];
                $sidebarProducts = \App\Models\Product::where('is_active', true)->latest()->take(6)->get();
                @endphp

                {{-- TAGS / KEYWORDS --}}
                <div class="w-full px-[12px]">
                    <div class="bb-category-tags mb-[24px]">
                        <div class="sub-title mb-[20px] flex justify-between">
                            <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750] capitalize">Kategori</h4>
                        </div>
                        <div class="bb-tags">
                            <ul class="flex flex-wrap m-[-5px]">
                                @foreach($sidebarCategories as $cat)
                                <li class="transition-all duration-[0.3s] ease-in-out m-[5px] py-[2px] px-[15px] border-[1px] border-solid border-[#eee] rounded-[10px] cursor-pointer hover:border-[#6c7fd8]">
                                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="text-[13px] capitalize font-Poppins text-[#686e7d] font-light leading-[28px] tracking-[0.03rem] hover:text-[#6c7fd8]">{{ $cat->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- EXPLORE CATEGORIES --}}
                <div class="w-full">
                    <div class="flex flex-wrap w-full">
                        <div class="w-full px-[12px]">
                            <div class="sub-title mb-[20px] flex justify-between">
                                <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750] capitalize">Jelajahi Kategori</h4>
                            </div>
                        </div>
                        @foreach($sidebarCategories->take(6) as $index => $cat)
                        @php
                            $bg = $bgColors[$index % 4];
                            $icon = $cat->icon ? asset('storage/' . $cat->icon) : asset('assets/img/category/'.(($index % 4) + 1).'.svg');
                        @endphp
                        <div class="min-[1200px]:w-[16.66%] min-[768px]:w-[33.33%] min-[576px]:w-[50%] w-full px-[12px] mb-[24px]">
                            <div class="bb-category-box p-[30px] rounded-[20px] flex flex-col items-center text-center max-[1399px]:p-[20px]" style="background-color: {{ $bg }};">
                                <div class="category-image mb-[12px]">
                                    <img src="{{ $icon }}" alt="{{ $cat->name }}" class="w-[50px] h-[50px] max-[1399px]:h-[65px] max-[1399px]:w-[65px] max-[1199px]:h-[50px] max-[1199px]:w-[50px] object-contain">
                                </div>
                                <div class="category-sub-contact">
                                    <h5 class="mb-[2px] text-[16px] font-quicksand text-[#3d4750] font-semibold tracking-[0.03rem] leading-[1.2]">
                                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="font-Poppins text-[16px] font-medium leading-[1.2] tracking-[0.03rem] text-[#3d4750] capitalize">{{ $cat->name }}</a>
                                    </h5>
                                    <p class="font-Poppins text-[13px] text-[#686e7d] leading-[25px] font-light tracking-[0.03rem]">{{ $cat->products()->where('is_active', true)->count() }} items</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- RELATED PRODUCTS --}}
                <div class="w-full">
                    <div class="flex flex-wrap w-full">
                        <div class="w-full px-[12px]">
                            <div class="sub-title mb-[20px] flex justify-between">
                                <h4 class="font-quicksand tracking-[0.03rem] leading-[1.2] text-[20px] font-bold text-[#3d4750] capitalize">Produk Terbaru</h4>
                            </div>
                        </div>
                        @foreach($sidebarProducts as $prod)
                        @php
                            $prodImage = $prod->primaryImage ? asset('storage/' . $prod->primaryImage->image_path) : asset('assets/img/new-product/1.jpg');
                            $rating = (float) ($prod->average_rating ?? 0);
                            $hasDiscount = $prod->discount_price && $prod->discount_price < $prod->price;
                            $displayPrice = $hasDiscount ? $prod->discount_price : $prod->price;
                        @endphp
                        <div class="min-[992px]:w-[33.33%] min-[576px]:w-[50%] w-full px-[12px] mb-[24px]">
                            <div class="bb-category-cart p-[15px] overflow-hidden bg-[#f8f8fb] border-[1px] border-solid border-[#eee] rounded-[10px] flex max-[767px]:flex-col h-full">
                                <a href="{{ route('products.show', $prod->slug) }}" class="pro-img mr-[12px] max-[767px]:mb-[15px] max-[767px]:mr-[0] shrink-0">
                                    <img src="{{ $prodImage }}" alt="{{ $prod->name }}" class="w-[80px] h-[80px] object-cover rounded-[10px] border-[1px] border-solid border-[#eee] max-[767px]:w-full max-[767px]:h-auto max-[767px]:aspect-square">
                                </a>
                                <div class="side-contact flex flex-col justify-center w-full">
                                    <h4 class="bb-pro-title text-[15px]">
                                        <a href="{{ route('products.show', $prod->slug) }}" class="transition-all duration-[0.3s] ease-in-out font-Poppins text-[15px] leading-[18px] tracking-[0.03rem] font-medium text-[#3d4750] line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal;">{{ $prod->name }}</a>
                                    </h4>
                                    <span class="bb-pro-rating mt-1">
                                        @if ($rating > 0)
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= round($rating) ? 'ri-star-fill text-[#fea99a]' : 'ri-star-line text-[#777]' }} float-left text-[15px] mr-[3px] leading-[26px]"></i>
                                            @endfor
                                        @endif
                                    </span>
                                    <div class="inner-price mx-[-3px] mt-1">
                                        <span class="new-price px-[3px] text-[15px] text-[#686e7d] font-semibold">Rp{{ number_format($displayPrice, 0, ',', '.') }}</span>
                                        @if($hasDiscount)
                                        <span class="old-price px-[3px] text-[14px] text-[#686e7d] line-through">Rp{{ number_format($prod->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @auth
        fetch("{{ route('cart.count') }}")
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('cart-badge');
                const count = document.getElementById('cart-count');
                if (badge) badge.textContent = data.cart_count;
                if (count) count.textContent = data.cart_count;
            });
        @endauth

        const searchInput = document.getElementById('navbar-search');
        const resultsBox = document.getElementById('navbar-search-results');
        let debounceTimer;

        searchInput?.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const q = this.value.trim();
            if (q.length < 2) {
                resultsBox?.classList.add('hidden');
                return;
            }
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('products.search') }}?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(products => {
                        if (!resultsBox) return;
                        if (products.length === 0) {
                            resultsBox.innerHTML = '<p class="p-4 font-Poppins text-sm text-[#686e7d]">Produk tidak ditemukan.</p>';
                        } else {
                            resultsBox.innerHTML = products.map(p => `
                            <a href="/products/${p.slug}" class="flex items-center gap-3 p-3 hover:bg-[#f8f8fb] border-b border-[#eee] last:border-0 transition-all duration-[0.3s]">
                                <span class="font-Poppins text-sm font-medium text-[#3d4750]">${p.name}</span>
                            </a>
                        `).join('');
                        }
                        resultsBox.classList.remove('hidden');
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!searchInput?.contains(e.target) && !resultsBox?.contains(e.target)) {
                resultsBox?.classList.add('hidden');
            }
        });
    });

    function refreshCartBadge() {
        fetch("{{ route('cart.count') }}")
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('cart-badge');
                const count = document.getElementById('cart-count');
                if (badge) badge.textContent = data.cart_count;
                if (count) count.textContent = data.cart_count;
            });
    }
</script>
@endpush
