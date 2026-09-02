<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('build/assets/img/logo/logo.png') }}" type="image/png">
    <title>@yield('title', 'Dashboard') — Materio Admin Arinna Bakery</title>

    {{-- Materio Theme Initialization (prevents flash of wrong theme) --}}
    <script>
        (function() {
            try {
                let mode = localStorage.getItem('mui-mode') || localStorage.getItem('appearance') || 'light';
                if (mode === 'system') {
                    mode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                const html = document.documentElement;
                if (mode === 'dark') {
                    html.classList.add('dark');
                    html.classList.remove('light');
                    html.setAttribute('data-theme', 'dark');
                } else {
                    html.classList.add('light');
                    html.classList.remove('dark');
                    html.setAttribute('data-theme', 'light');
                }
                localStorage.setItem('appearance', mode);
                localStorage.setItem('mui-mode', mode);
                document.cookie = `appearance=${mode};path=/;max-age=31536000;SameSite=Lax`;
            } catch(e) {}
        })();
    </script>

    <!-- Google Fonts (Public Sans & Inter for authentic Materio typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Remix Icon (Materio Official Icons) & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.ts'])

    {{-- Alpine.js & Collapse Plugin --}}
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/plugins/collapse/cdn.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('nav', {
                mobileOpen: false,
                sidebarCollapsed: localStorage.getItem('mui-sidebar-collapsed') === 'true',
                toggleCollapse() {
                    this.sidebarCollapsed = !this.sidebarCollapsed;
                    localStorage.setItem('mui-sidebar-collapsed', this.sidebarCollapsed);
                }
            });
            Alpine.store('theme', {
                isDark: document.documentElement.classList.contains('dark'),
                toggle() {
                    this.isDark = !this.isDark;
                    const mode = this.isDark ? 'dark' : 'light';
                    const html = document.documentElement;
                    if (this.isDark) {
                        html.classList.add('dark');
                        html.classList.remove('light');
                        html.setAttribute('data-theme', 'dark');
                    } else {
                        html.classList.add('light');
                        html.classList.remove('dark');
                        html.setAttribute('data-theme', 'light');
                    }
                    localStorage.setItem('mui-mode', mode);
                    localStorage.setItem('appearance', mode);
                    document.cookie = `appearance=${mode};path=/;max-age=31536000;SameSite=Lax`;
                }
            });
        });
    </script>

    <style>
        :root {
            --mui-primary: #8C57FF;
            --mui-primary-hover: #7E4EE6;
            --mui-primary-light: rgba(140, 87, 255, 0.12);
            --mui-primary-rgb: 140, 87, 255;
            --mui-success: #56CA00;
            --mui-info: #16B1FF;
            --mui-warning: #FFB400;
            --mui-error: #FF4C51;
            --mui-secondary: #8A8D93;
            --mui-bg-light: #F4F5FA;
            --mui-card-light: #FFFFFF;
            --mui-text-primary-light: #2E263D;
            --mui-text-secondary-light: #6B6678;
            --mui-border-light: rgba(46, 38, 61, 0.12);
        }

        .dark {
            --mui-bg-dark: #28243D;
            --mui-card-dark: #312D4B;
            --mui-text-primary-dark: #EAEAFF;
            --mui-text-secondary-dark: #A5A3AE;
            --mui-border-dark: rgba(234, 234, 255, 0.12);
        }

        body {
            font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Materio Card Shadows */
        .materio-card {
            background-color: var(--mui-card-light);
            border: 1px solid var(--mui-border-light);
            border-radius: 0.75rem;
            box-shadow: 0 2px 10px 0 rgba(46, 38, 61, 0.08), 0 1px 4px 0 rgba(46, 38, 61, 0.04);
            transition: all 0.2s ease;
        }
        .dark .materio-card {
            background-color: var(--mui-card-dark);
            border-color: var(--mui-border-dark);
            box-shadow: 0 4px 18px 0 rgba(15, 20, 34, 0.4);
        }

        /* Custom Materio Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(140, 87, 255, 0.2);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(140, 87, 255, 0.4);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F4F5FA] dark:bg-[#28243D] text-[#2E263D] dark:text-[#EAEAFF] antialiased min-h-screen flex flex-col text-[13px] leading-normal transition-colors duration-200" x-data x-cloak>

    <div class="min-h-screen flex flex-col">
        {{-- Materio Sidebar Navigation (Fixed on Left) --}}
        @include('partials.admin-sidebar')

        {{-- Main Layout Content Wrapper (Offset with padding-left for sidebar) --}}
        <div class="flex-1 flex flex-col min-w-0 transition-[padding-left] duration-300"
             :class="$store.nav.sidebarCollapsed ? 'lg:pl-[68px]' : 'lg:pl-[230px]'">

            {{-- Materio Detached Topbar --}}
            @include('partials.admin-topbar')

            {{-- Main Page Content --}}
            <main class="flex-1 px-4 lg:px-5 pb-10 pt-1 max-w-[1600px] w-full mx-auto">
                {{-- Global Session Alerts --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="mb-6 flex items-center justify-between gap-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 dark:bg-emerald-500/15 px-4 py-3.5 text-[14px] text-emerald-600 dark:text-emerald-400 backdrop-blur-sm shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                <i class="ri-checkbox-circle-fill text-lg text-emerald-500"></i>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-500/70 hover:text-emerald-600 p-1 rounded-lg">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show"
                         class="mb-6 flex items-center justify-between gap-3 rounded-xl border border-rose-500/20 bg-rose-500/10 dark:bg-rose-500/15 px-4 py-3.5 text-[14px] text-rose-600 dark:text-rose-400 backdrop-blur-sm shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-rose-500/20 flex items-center justify-center shrink-0">
                                <i class="ri-error-warning-fill text-lg text-rose-500"></i>
                            </div>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-500/70 hover:text-rose-600 p-1 rounded-lg">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-rose-500/20 bg-rose-500/10 dark:bg-rose-500/15 p-4 text-[14px] text-rose-600 dark:text-rose-400 shadow-sm">
                        <div class="flex items-center gap-2 font-semibold mb-2">
                            <i class="ri-alert-fill text-lg text-rose-500"></i>
                            <span>Harap periksa kembali formulir berikut:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-[13px] opacity-90 pl-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="mt-auto px-5 py-3 border-t border-black/5 dark:border-white/5 text-[12px] text-stone-400 dark:text-stone-500 flex flex-col sm:flex-row items-center justify-between gap-2 max-w-[1600px] w-full mx-auto">
                <div>
                    &copy; {{ date('Y') }} <span class="font-semibold text-[#8C57FF]">Arinna Hidayah Bakery</span> &middot; Materio Admin UI
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-[#8C57FF] transition flex items-center gap-1">
                        <i class="ri-external-link-line"></i> Kunjungi Toko
                    </a>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
