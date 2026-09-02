{{--
    partials.admin-sidebar
    Materio Vertical Navigation Sidebar
--}}
@php
    $isSettingsGroup = request()->routeIs('admin.settings.*');
@endphp

<aside
    x-data="{
        settingsOpen: {{ $isSettingsGroup ? 'true' : 'false' }}
    }"
    :class="[
        $store.nav.sidebarCollapsed ? 'w-[68px]' : 'w-[230px]',
        $store.nav.mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
    ]"
    class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-[#312D4B] border-r border-black/5 dark:border-white/5 transition-all duration-300 ease-in-out flex flex-col h-screen select-none shadow-xl lg:shadow-none"
>
    {{-- Brand Header --}}
    <div class="flex items-center justify-between px-4 h-[60px] shrink-0 border-b border-black/5 dark:border-white/5">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0 group">
            {{-- Arinna Bakery Logo --}}
            <div class="w-8 h-8 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <img src="{{ asset('build/assets/img/logo/logo.png') }}" alt="Arinna Bakery" class="w-full h-full object-contain">
            </div>
            <div x-show="!$store.nav.sidebarCollapsed" class="min-w-0 transition-opacity">
                <span class="block font-bold text-[15px] leading-tight tracking-tight text-[#2E263D] dark:text-[#EAEAFF] truncate">Arinna Bakery</span>
                <span class="block text-[10px] font-semibold uppercase tracking-wider text-[#8C57FF]">HIDAYAH SUMENEP</span>
            </div>
        </a>

        {{-- Collapse toggle desktop --}}
        <button
            @click="$store.nav.toggleCollapse()"
            class="hidden lg:flex w-8 h-8 items-center justify-center rounded-lg text-[#2E263D]/60 dark:text-[#EAEAFF]/60 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10 transition"
            title="Toggle Sidebar"
        >
            <i class="ri-radio-button-line text-lg" :class="$store.nav.sidebarCollapsed ? 'ri-record-circle-line text-[#8C57FF]' : 'ri-radio-button-line'"></i>
        </button>

        {{-- Close mobile button --}}
        <button
            @click="$store.nav.mobileOpen = false"
            class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg text-[#2E263D]/60 dark:text-[#EAEAFF]/60 hover:text-rose-500 hover:bg-rose-500/10"
        >
            <i class="ri-close-line text-xl"></i>
        </button>
    </div>

    {{-- Nav Links (Scrollable Area) --}}
    <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5 text-[13px] font-medium">

        {{-- Section: DASHBOARDS --}}
        <div x-show="!$store.nav.sidebarCollapsed" class="px-3 pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6B6678]/70 dark:text-[#A5A3AE]/70">
            Dashboards
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.dashboard')
                     ? 'bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white shadow-md shadow-[#8C57FF]/35 font-semibold'
                     : 'text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]' }}"
           :title="$store.nav.sidebarCollapsed ? 'Dashboard' : ''"
        >
            <i class="ri-home-smile-line text-[18px] shrink-0"></i>
            <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1">Dashboard</span>
            <span x-show="!$store.nav.sidebarCollapsed" class="px-1.5 py-0.5 text-[10px] font-bold rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'bg-[#8C57FF]/10 text-[#8C57FF]' }}">
                Pro
            </span>
        </a>

        {{-- Section: APPS & COMMERCE --}}
        <div x-show="!$store.nav.sidebarCollapsed" class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6B6678]/70 dark:text-[#A5A3AE]/70">
            Apps &amp; eCommerce
        </div>

        {{-- Orders --}}
        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.orders.*')
                     ? 'bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white shadow-md shadow-[#8C57FF]/35 font-semibold'
                     : 'text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]' }}"
           :title="$store.nav.sidebarCollapsed ? 'Pesanan' : ''"
        >
            <i class="ri-shopping-cart-2-line text-[18px] shrink-0"></i>
            <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1">Pesanan</span>
        </a>

        {{-- Products --}}
        <a href="{{ route('admin.products.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.products.*')
                     ? 'bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white shadow-md shadow-[#8C57FF]/35 font-semibold'
                     : 'text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]' }}"
           :title="$store.nav.sidebarCollapsed ? 'Produk' : ''"
        >
            <i class="ri-cake-3-line text-[18px] shrink-0"></i>
            <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1">Produk</span>
        </a>

        {{-- Categories --}}
        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.categories.*')
                     ? 'bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white shadow-md shadow-[#8C57FF]/35 font-semibold'
                     : 'text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]' }}"
           :title="$store.nav.sidebarCollapsed ? 'Kategori Produk' : ''"
        >
            <i class="ri-folder-5-line text-[18px] shrink-0"></i>
            <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1">Kategori</span>
        </a>

        {{-- Reviews --}}
        <a href="{{ route('admin.reviews.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.reviews.*')
                     ? 'bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white shadow-md shadow-[#8C57FF]/35 font-semibold'
                     : 'text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]' }}"
           :title="$store.nav.sidebarCollapsed ? 'Review Produk' : ''"
        >
            <i class="ri-star-smile-line text-[18px] shrink-0"></i>
            <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1">Review Produk</span>
        </a>

        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.users.*')
                     ? 'bg-gradient-to-r from-[#8C57FF] to-[#9E77FF] text-white shadow-md shadow-[#8C57FF]/35 font-semibold'
                     : 'text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]' }}"
           :title="$store.nav.sidebarCollapsed ? 'Pengguna' : ''"
        >
            <i class="ri-user-3-line text-[18px] shrink-0"></i>
            <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1">Pengguna</span>
        </a>

        {{-- Section: WEBSITE CMS --}}
        <div x-show="!$store.nav.sidebarCollapsed" class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-wider text-[#6B6678]/70 dark:text-[#A5A3AE]/70">
            Website CMS
        </div>

        {{-- Collapsible Website Settings --}}
        <div>
            <button
                @click="settingsOpen = !settingsOpen"
                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg transition-all duration-150 text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 dark:hover:bg-[#8C57FF]/15 hover:text-[#8C57FF] dark:hover:text-[#8C57FF]
                       {{ $isSettingsGroup ? 'bg-[#8C57FF]/10 text-[#8C57FF] font-semibold' : '' }}"
                :title="$store.nav.sidebarCollapsed ? 'Website Settings' : ''"
            >
                <i class="ri-settings-4-line text-[18px] shrink-0"></i>
                <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap flex-1 text-left">Website Settings</span>
                <i x-show="!$store.nav.sidebarCollapsed" class="ri-arrow-right-s-line text-base transition-transform duration-200" :class="settingsOpen ? 'rotate-90 text-[#8C57FF]' : ''"></i>
            </button>

            <div x-show="settingsOpen && !$store.nav.sidebarCollapsed" x-collapse class="ml-3 pl-3 mt-0.5 space-y-0.5 border-l-2 border-[#8C57FF]/20">
                <a href="{{ route('admin.settings.menus.index') }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[12px] transition
                          {{ request()->routeIs('admin.settings.menus.*') ? 'bg-[#8C57FF] text-white font-semibold shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10' }}">
                    <i class="ri-circle-fill text-[5px]"></i>
                    <span>Navbar / Menu</span>
                </a>
                <a href="{{ route('admin.settings.sliders.index') }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[12px] transition
                          {{ request()->routeIs('admin.settings.sliders.*') ? 'bg-[#8C57FF] text-white font-semibold shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10' }}">
                    <i class="ri-circle-fill text-[5px]"></i>
                    <span>Slider Home</span>
                </a>
                <a href="{{ route('admin.settings.blog-categories.index') }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[12px] transition
                          {{ request()->routeIs('admin.settings.blog-categories.*') ? 'bg-[#8C57FF] text-white font-semibold shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10' }}">
                    <i class="ri-circle-fill text-[5px]"></i>
                    <span>Kategori Blog</span>
                </a>
                <a href="{{ route('admin.settings.blogs.index') }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[12px] transition
                          {{ request()->routeIs('admin.settings.blogs.*') ? 'bg-[#8C57FF] text-white font-semibold shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10' }}">
                    <i class="ri-circle-fill text-[5px]"></i>
                    <span>Blog / News</span>
                </a>
                <a href="{{ route('admin.settings.team-members.index') }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[12px] transition
                          {{ request()->routeIs('admin.settings.team-members.*') ? 'bg-[#8C57FF] text-white font-semibold shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10' }}">
                    <i class="ri-circle-fill text-[5px]"></i>
                    <span>Tim Kami</span>
                </a>
                <a href="{{ route('admin.settings.general.edit') }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-md text-[12px] transition
                          {{ request()->routeIs('admin.settings.general.*') ? 'bg-[#8C57FF] text-white font-semibold shadow-sm' : 'text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:text-[#8C57FF] hover:bg-[#8C57FF]/10' }}">
                    <i class="ri-circle-fill text-[5px]"></i>
                    <span>Informasi Umum</span>
                </a>
            </div>
        </div>

    </nav>

    {{-- Bottom Pinned User / Logout Action --}}
    <div class="p-3 border-t border-black/5 dark:border-white/5 bg-black/[0.02] dark:bg-white/[0.02] shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 transition text-[13px] font-medium"
                    :title="$store.nav.sidebarCollapsed ? 'Logout' : ''"
            >
                <i class="ri-logout-box-r-line text-[18px] shrink-0"></i>
                <span x-show="!$store.nav.sidebarCollapsed" class="whitespace-nowrap">Keluar (Logout)</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Backdrop Overlay --}}
<div
    x-show="$store.nav.mobileOpen"
    x-transition.opacity.duration.300ms
    @click="$store.nav.mobileOpen = false"
    class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm lg:hidden"
></div>
