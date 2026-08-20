{{--
    partials.admin-sidebar
    Menu navigasi CMS. Item "Website Settings" dibuat collapsible karena
    menaungi 4 sub-modul (Menu, Slider, Blog, Informasi Umum).
--}}
@php
    $isSettingsGroup = request()->routeIs('admin.settings.*');
@endphp

<aside
    x-data="{ open: true, settingsOpen: {{ $isSettingsGroup ? 'true' : 'false' }} }"
    x-cloak
    :class="[open ? 'w-64' : 'w-20', $store.nav.mobileOpen ? 'flex' : 'hidden lg:flex']"
    class="lg:flex-col flex-col fixed inset-y-0 left-0 z-40 lg:static lg:z-auto shrink-0 bg-[#1c1917] text-white transition-all duration-200 min-h-screen lg:sticky lg:top-0"
>
    <div class="flex items-center gap-3 px-4 h-16 border-b border-white/10">
        <div class="w-9 h-9 rounded-full bg-amber-600 flex items-center justify-center font-display font-bold text-white shrink-0">
            <i class="fa-solid fa-wheat-awn text-sm"></i>
        </div>
        <span x-show="open" class="font-display font-semibold tracking-wide whitespace-nowrap">Arinna Hidayah</span>
        <button @click="open = !open" class="ml-auto text-white/60 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1 text-sm">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('admin.dashboard') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/80 hover:bg-white/10' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span x-show="open" class="whitespace-nowrap">Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('admin.users.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/80 hover:bg-white/10' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" /></svg>
            <span x-show="open" class="whitespace-nowrap">Users</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('admin.products.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/80 hover:bg-white/10' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            <span x-show="open" class="whitespace-nowrap">Produk</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('admin.categories.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/80 hover:bg-white/10' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10M4 18h6" /></svg>
            <span x-show="open" class="whitespace-nowrap">Kategori</span>
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('admin.reviews.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/80 hover:bg-white/10' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
            <span x-show="open" class="whitespace-nowrap">Review Produk</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                  {{ request()->routeIs('admin.orders.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/80 hover:bg-white/10' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 2a1 1 0 00-1 1v1H5a2 2 0 00-2 2v13a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2h-3V3a1 1 0 00-1-1H9zm0 4V4h6v2H9zm-2 5h10M7 14h10M7 18h6" /></svg>
            <span x-show="open" class="whitespace-nowrap">Pesanan</span>
        </a>

        {{-- Website Settings group --}}
        <div>
            <button
                @click="settingsOpen = !settingsOpen"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg transition text-white/80 hover:bg-white/10
                       {{ $isSettingsGroup ? 'bg-white/10 text-white font-semibold' : '' }}"
            >
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span x-show="open" class="whitespace-nowrap flex-1 text-left">Website Settings</span>
                <svg x-show="open" :class="settingsOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
            </button>

            <div x-show="settingsOpen && open" x-collapse class="ml-6 mt-1 space-y-1 border-l border-white/10 pl-3">
                <a href="{{ route('admin.settings.menus.index') }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.menus.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/70 hover:bg-white/10' }}">
                    Navbar / Menu
                </a>
                <a href="{{ route('admin.settings.sliders.index') }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.sliders.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/70 hover:bg-white/10' }}">
                    Slider Home
                </a>
                <a href="{{ route('admin.settings.blog-categories.index') }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.blog-categories.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/70 hover:bg-white/10' }}">
                    Kategori Blog
                </a>
                <a href="{{ route('admin.settings.blogs.index') }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.blogs.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/70 hover:bg-white/10' }}">
                    Blog / News
                </a>
                <a href="{{ route('admin.settings.team-members.index') }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.team-members.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/70 hover:bg-white/10' }}">
                    Tim Kami
                </a>
                <a href="{{ route('admin.settings.general.edit') }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.general.*') ? 'bg-[#b45309] text-[#1c1917] font-semibold' : 'text-white/70 hover:bg-white/10' }}">
                    Informasi Umum
                </a>
            </div>
        </div>
    </nav>

    <div class="p-3 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/70 hover:bg-white/10 text-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span x-show="open" class="whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>
