{{--
    partials.admin-topbar
    Materio Detached / Floating Card Navbar
--}}
<header
    x-data="{
        profileOpen: false,
        notifOpen: false,
        searchModal: false,
        scrolled: false,
        onScroll() { this.scrolled = window.scrollY > 10 }
    }"
    x-init="onScroll()"
    @scroll.window.passive="onScroll()"
    class="sticky top-0 z-30 px-4 lg:px-6 pt-3 pb-2 transition-all duration-300">
    <div
        :class="scrolled
            ? 'shadow-[0_6px_22px_0_rgba(46,38,61,0.14)] dark:shadow-[0_6px_22px_0_rgba(15,20,34,0.5)] border-black/10 dark:border-white/10 bg-white/95 dark:bg-[#312D4B]/95'
            : 'shadow-sm border-black/5 dark:border-white/5 bg-white/85 dark:bg-[#312D4B]/85'"
        class="materio-card backdrop-blur-md px-3.5 lg:px-4 h-14 flex items-center justify-between gap-4 border rounded-xl transition-all duration-200">

        {{-- Left: Mobile Hamburger & Search --}}
        <div class="flex items-center gap-2.5">
            {{-- Mobile hamburger --}}
            <button
                @click="$store.nav.mobileOpen = !$store.nav.mobileOpen"
                class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition"
            >
                <i class="ri-menu-2-line text-lg"></i>
            </button>

            {{-- Quick Search input trigger --}}
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-black/[0.03] dark:bg-white/[0.04] border border-transparent hover:border-black/10 dark:hover:border-white/10 focus-within:border-[#8C57FF]/50 focus-within:bg-white dark:focus-within:bg-[#28243D] text-[#2E263D]/70 dark:text-[#EAEAFF]/70 transition-all cursor-pointer w-[180px] lg:w-[240px]"
                 @click="searchModal = true"
            >
                <i class="ri-search-line text-[#8C57FF] text-base"></i>
                <span class="text-[12px] text-stone-400 dark:text-stone-500 select-none">Search ⌘K</span>
                <kbd class="hidden md:inline-block text-[10px] uppercase font-mono px-1.5 py-0.5 rounded bg-black/5 dark:bg-white/10 text-stone-400 ml-auto">Ctrl+K</kbd>
            </div>
        </div>

        {{-- Right: Actions & User Menu --}}
        <div class="flex items-center gap-1 sm:gap-1.5">

            {{-- Language / Translation Icon --}}
            <button
                type="button"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition"
                title="Bahasa: Indonesia"
            >
                <i class="ri-translate-2 text-base"></i>
            </button>

            {{-- Theme Switcher (Dark / Light) --}}
            <button
                @click="$store.theme.toggle()"
                type="button"
                class="w-8 h-8 flex items-center justify-center rounded-lg text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition"
                :title="$store.theme.isDark ? 'Ganti ke Mode Terang' : 'Ganti ke Mode Gelap'"
            >
                <i class="text-base transition-transform duration-200" :class="$store.theme.isDark ? 'ri-sun-line text-amber-400' : 'ri-moon-clear-line text-[#8C57FF]'"></i>
            </button>

            {{-- Shortcuts / Store Link --}}
            <a href="{{ route('home') }}" target="_blank"
               class="w-8 h-8 flex items-center justify-center rounded-lg text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition"
               title="Kunjungi Toko / Website"
            >
                <i class="ri-star-line text-base"></i>
            </a>

            {{-- Notification Dropdown --}}
            <div class="relative" @click.outside="notifOpen = false">
                <button
                    @click="notifOpen = !notifOpen"
                    class="relative w-8 h-8 flex items-center justify-center rounded-lg text-[#2E263D]/70 dark:text-[#EAEAFF]/70 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition"
                >
                    <i class="ri-notification-2-line text-base"></i>
                    <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-rose-500 rounded-full ring-2 ring-white dark:ring-[#312D4B] animate-pulse"></span>
                </button>

                <div
                    x-show="notifOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-[#312D4B] rounded-2xl shadow-xl border border-black/10 dark:border-white/10 py-3 z-50 overflow-hidden"
                >
                    <div class="px-4 pb-2 border-b border-black/5 dark:border-white/5 flex items-center justify-between">
                        <span class="font-bold text-sm">Notifikasi</span>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-[#8C57FF]/10 text-[#8C57FF]">3 Baru</span>
                    </div>
                    <div class="divide-y divide-black/5 dark:divide-white/5 max-h-64 overflow-y-auto">
                        <a href="{{ route('admin.orders.index') }}" class="flex items-start gap-3 p-3 hover:bg-[#8C57FF]/5 transition">
                            <div class="w-8 h-8 rounded-full bg-[#8C57FF]/10 text-[#8C57FF] flex items-center justify-center shrink-0">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-[#2E263D] dark:text-[#EAEAFF]">Pesanan Masuk Baru</p>
                                <p class="text-[11px] text-stone-500 truncate">Customer membuat pesanan roti baru</p>
                                <span class="text-[10px] text-stone-400">Hari ini</span>
                            </div>
                        </a>
                        <a href="{{ route('admin.reviews.index') }}" class="flex items-start gap-3 p-3 hover:bg-[#8C57FF]/5 transition">
                            <div class="w-8 h-8 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center shrink-0">
                                <i class="ri-star-line"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-[#2E263D] dark:text-[#EAEAFF]">Ulasan Produk Baru</p>
                                <p class="text-[11px] text-stone-500 truncate">Menunggu persetujuan admin</p>
                                <span class="text-[10px] text-stone-400">Kemarin</span>
                            </div>
                        </a>
                    </div>
                    <div class="pt-2 px-3 text-center border-t border-black/5 dark:border-white/5">
                        <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-[#8C57FF] hover:underline">
                            Lihat Semua Pesanan &rarr;
                        </a>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="h-6 w-px bg-black/10 dark:bg-white/10 mx-1"></div>

            {{-- Profile Dropdown --}}
            <div class="relative" @click.outside="profileOpen = false">
                <button
                    @click="profileOpen = !profileOpen"
                    class="flex items-center gap-2 p-1 rounded-xl hover:bg-[#8C57FF]/10 transition"
                >
                    <div class="relative">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#8C57FF] to-[#9E77FF] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-white dark:ring-[#312D4B]"></span>
                    </div>
                    <div class="hidden md:block text-left">
                        <span class="block text-[12px] font-bold text-[#2E263D] dark:text-[#EAEAFF] leading-tight truncate max-w-[100px]">
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </span>
                        <span class="block text-[10px] text-stone-400 capitalize">{{ auth()->user()->role ?? 'Admin' }}</span>
                    </div>
                    <i class="ri-arrow-down-s-line text-xs text-stone-400 hidden sm:block"></i>
                </button>

                <div
                    x-show="profileOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-[#312D4B] rounded-2xl shadow-xl border border-black/10 dark:border-white/10 py-2 z-50 overflow-hidden"
                >
                    <div class="px-4 py-2.5 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#8C57FF] to-[#9E77FF] text-white flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-xs truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-stone-400 truncate">{{ auth()->user()->email ?? 'admin@arinnabakery.com' }}</p>
                        </div>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-xs text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                            <i class="ri-dashboard-line text-base text-[#8C57FF]"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.settings.general.edit') }}" class="flex items-center gap-3 px-4 py-2 text-xs text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                            <i class="ri-settings-3-line text-base text-[#8C57FF]"></i> Pengaturan Website
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2 text-xs text-[#2E263D]/80 dark:text-[#EAEAFF]/80 hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                            <i class="ri-external-link-line text-base text-[#8C57FF]"></i> Kunjungi Toko
                        </a>
                    </div>

                    <div class="border-t border-black/5 dark:border-white/5 pt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-left text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 transition">
                                <i class="ri-logout-box-r-line text-base"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Quick Modal (⌘K) --}}
    <div
        x-show="searchModal"
        x-transition.opacity
        @keydown.window.prevent.cmd.k="searchModal = !searchModal"
        @keydown.window.prevent.ctrl.k="searchModal = !searchModal"
        @keydown.escape.window="searchModal = false"
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-start justify-center pt-20 px-4"
        style="display: none;"
    >
        <div
            @click.outside="searchModal = false"
            class="w-full max-w-lg bg-white dark:bg-[#312D4B] rounded-2xl shadow-2xl border border-black/10 dark:border-white/10 overflow-hidden"
        >
            <div class="p-4 border-b border-black/5 dark:border-white/5 flex items-center gap-3">
                <i class="ri-search-line text-[#8C57FF] text-xl"></i>
                <input
                    type="text"
                    placeholder="Ketik untuk mencari modul, pesanan, atau produk..."
                    class="w-full bg-transparent border-none focus:outline-none text-sm text-[#2E263D] dark:text-[#EAEAFF] placeholder-stone-400"
                    autofocus
                >
                <button @click="searchModal = false" class="text-stone-400 hover:text-stone-600 text-sm">ESC</button>
            </div>
            <div class="p-3 text-xs space-y-1">
                <p class="px-3 py-1 font-semibold uppercase text-[10px] text-stone-400">Navigasi Cepat</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                    <i class="ri-home-smile-line text-base"></i> Dashboard
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                    <i class="ri-shopping-cart-2-line text-base"></i> Daftar Pesanan
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                    <i class="ri-cake-3-line text-base"></i> Daftar Produk
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                    <i class="ri-user-3-line text-base"></i> Kelola Pengguna
                </a>
                <a href="{{ route('admin.settings.general.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-[#8C57FF]/10 hover:text-[#8C57FF] transition">
                    <i class="ri-settings-4-line text-base"></i> Pengaturan Website
                </a>
            </div>
        </div>
    </div>
</header>