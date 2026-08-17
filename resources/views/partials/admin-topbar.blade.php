{{--
    partials.admin-topbar
    Menampilkan judul halaman (@yield/section 'page-title'), breadcrumb opsional,
    dan dropdown profil admin + notifikasi pesanan baru.
--}}
<header x-data="{ profileOpen: false }" class="sticky top-0 z-30 bg-white border-b border-amber-100">
    <div class="flex items-center h-16 px-4 lg:px-6 gap-4">
        {{-- Mobile hamburger --}}
        <button @click="$store.nav.mobileOpen = !$store.nav.mobileOpen" class="lg:hidden text-stone-500">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div>
            <h1 class="font-display text-lg font-semibold text-stone-900">@yield('page-title', 'Dashboard')</h1>
            @hasSection('page-subtitle')
            <p class="text-xs text-stone-400">@yield('page-subtitle')</p>
            @endif
        </div>

        <div class="ml-auto flex items-center gap-4">
            <button class="relative w-9 h-9 flex items-center justify-center rounded-full text-stone-400 hover:bg-amber-50 hover:text-[#6c7fd8] transition">
                <i class="fa-solid fa-bell"></i>
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 rounded-full text-[10px] text-white flex items-center justify-center ring-2 ring-white">3</span>
            </button>

            <div class="relative" @click.outside="profileOpen = false">
                <button @click="profileOpen = !profileOpen" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-stone-900 text-white flex items-center justify-center text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="hidden sm:block text-sm font-semibold text-stone-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-stone-400"></i>
                </button>

                <div x-show="profileOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-amber-100 py-1.5 text-sm overflow-hidden">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-stone-600 hover:bg-amber-50 hover:text-amber-800 transition">
                        <i class="fa-solid fa-user w-4 text-stone-400"></i> Profil Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 text-left px-4 py-2.5 text-rose-600 hover:bg-rose-50 transition">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Overlay saat sidebar mobile terbuka --}}
    <div
        x-show="$store.nav.mobileOpen"
        x-transition.opacity
        @click="$store.nav.mobileOpen = false"
        class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>
</header>