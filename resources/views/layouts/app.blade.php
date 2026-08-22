<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — PustakaOne</title>
    <meta name="description" content="@yield('meta_description', 'Sistem Manajemen Perpustakaan Digital Modern')">

    <!-- OpenGraph Meta Tags untuk Social Media (LinkedIn, WA, FB, Twitter) -->
    <meta property="og:title" content="@yield('title', 'PustakaOne') — Sistem Manajemen Perpustakaan">
    <meta property="og:description" content="@yield('meta_description', 'Kelola perpustakaan digital Anda dengan mudah, cepat, dan modern.')">
    <meta property="og:image" content="{{ asset('img/og-banner.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-50 dark:bg-surface-900 text-surface-800 dark:text-surface-200">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="$store.sidebar.mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$store.sidebar.close()"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
         style="display:none;">
    </div>

    <!-- Sidebar -->
    <aside :class="[
               $store.sidebar.mobileOpen ? 'translate-x-0' : '-translate-x-full',
               $store.sidebar.open ? 'lg:w-64' : 'lg:w-20'
           ]"
           class="fixed top-0 left-0 z-50 h-full bg-white dark:bg-surface-800
                  border-r border-surface-200 dark:border-surface-700
                  transition-all duration-300 ease-in-out
                  w-64 lg:translate-x-0 flex flex-col">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 px-5 h-16 border-b border-surface-100 dark:border-surface-700/50 shrink-0 hover:bg-surface-50 dark:hover:bg-surface-700/20 transition-colors">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-600 to-primary-400 flex items-center justify-center shrink-0">
                <i data-lucide="book-open" class="w-5 h-5 text-white"></i>
            </div>
            <span :class="$store.sidebar.open ? 'lg:opacity-100' : 'lg:opacity-0 lg:w-0'"
                  class="font-display font-bold text-lg text-surface-800 dark:text-white transition-all duration-300 whitespace-nowrap overflow-hidden">
                Pustaka<span class="text-primary-600 dark:text-primary-400">One</span>
            </span>
        </a>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <div :class="$store.sidebar.open ? '' : 'lg:sr-only'" class="px-3 mb-3 text-[10px] font-bold uppercase tracking-widest text-surface-400 dark:text-surface-500">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : 'nav-item' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ route('books.index') }}"
               class="{{ request()->routeIs('books.*') ? 'nav-item-active' : 'nav-item' }}">
                <i data-lucide="book-copy" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Buku</span>
            </a>

            <a href="{{ route('authors.index') }}"
               class="{{ request()->routeIs('authors.*') ? 'nav-item-active' : 'nav-item' }}">
                <i data-lucide="pen-tool" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Penulis</span>
            </a>

            <a href="{{ route('publishers.index') }}"
               class="{{ request()->routeIs('publishers.*') ? 'nav-item-active' : 'nav-item' }}">
                <i data-lucide="building-2" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Penerbit</span>
            </a>

            <a href="{{ route('levels.index') }}"
               class="{{ request()->routeIs('levels.*') ? 'nav-item-active' : 'nav-item' }}">
                <i data-lucide="layers" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Level / Kategori</span>
            </a>

            <div :class="$store.sidebar.open ? '' : 'lg:sr-only'" class="px-3 mt-6 mb-3 text-[10px] font-bold uppercase tracking-widest text-surface-400 dark:text-surface-500">Transaksi</div>

            <a href="{{ route('reads.index') }}"
               class="{{ request()->routeIs('reads.*') ? 'nav-item-active' : 'nav-item' }}">
                <i data-lucide="scroll-text" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Riwayat Baca</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="shrink-0 border-t border-surface-100 dark:border-surface-700/50 p-3">
            <a href="{{ url('/') }}" class="nav-item">
                <i data-lucide="globe" class="w-5 h-5 shrink-0"></i>
                <span :class="$store.sidebar.open ? 'lg:block' : 'lg:hidden'" class="whitespace-nowrap">Lihat Katalog</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div :class="$store.sidebar.open ? 'lg:ml-64' : 'lg:ml-20'" class="transition-all duration-300 min-h-screen flex flex-col">

        <!-- Top Bar -->
        <header class="sticky top-0 z-30 h-16 bg-white/80 dark:bg-surface-800/80 backdrop-blur-xl
                       border-b border-surface-200 dark:border-surface-700 flex items-center justify-between px-4 lg:px-6">

            <!-- Left: Hamburger + Breadcrumb -->
            <div class="flex items-center gap-3">
                <button @click="$store.sidebar.toggle()" class="btn-icon text-surface-500 dark:text-surface-400">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <nav class="hidden sm:flex items-center gap-1.5 text-sm">
                    <span class="text-surface-400 dark:text-surface-500">Admin</span>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-surface-300 dark:text-surface-600"></i>
                    <span class="font-medium text-surface-700 dark:text-surface-300">@yield('title', 'Dashboard')</span>
                </nav>
            </div>

            <!-- Right: Search, Theme Toggle, Notifications, Profile -->
            <div class="flex items-center gap-2">
                <!-- Search -->
                <div class="hidden md:block relative" x-data="{ searchOpen: false }">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                        <input type="text" placeholder="Cari buku, penulis..."
                               class="w-64 pl-10 pr-4 py-2 rounded-xl bg-surface-100 dark:bg-surface-700/50
                                      border-0 text-sm placeholder:text-surface-400 dark:placeholder:text-surface-500
                                      focus:outline-none focus:ring-2 focus:ring-primary-500/30 transition-all duration-200">
                    </div>
                </div>

                <!-- Theme Toggle -->
                <button @click="$store.theme.toggle()" class="btn-icon text-surface-500 dark:text-surface-400">
                    <i x-show="!$store.theme.dark" data-lucide="moon" class="w-5 h-5"></i>
                    <i x-show="$store.theme.dark" data-lucide="sun" class="w-5 h-5" style="display:none;"></i>
                </button>

                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="btn-icon text-surface-500 dark:text-surface-400 relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-rose-500 rounded-full"></span>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="dropdown-menu w-80" style="display:none;">
                        <div class="px-4 py-3 border-b border-surface-100 dark:border-surface-700">
                            <p class="font-semibold text-sm">Notifikasi</p>
                        </div>
                        <div class="p-4 text-sm text-surface-500 dark:text-surface-400 text-center">
                            <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                            Belum ada notifikasi baru
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 ml-2 focus:outline-none">
                        <div class="avatar avatar-sm uppercase">
                            {{ auth()->check() ? substr(auth()->user()->name, 0, 2) : 'GU' }}
                        </div>
                        <span class="hidden md:block text-sm font-medium text-surface-700 dark:text-surface-300">
                            {{ auth()->user()->name ?? 'Guest' }}
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-surface-400 hidden md:block"></i>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-surface-800 rounded-md shadow-lg py-1 border border-surface-100 dark:border-surface-700 z-50" 
                         style="display:none;">
                        
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700">
                            <i data-lucide="user" class="w-4 h-4"></i> Lihat Profil
                        </a>
                        
                        <div class="border-t border-surface-100 dark:border-surface-700 my-1"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-rose-600 dark:text-rose-400 hover:bg-surface-100 dark:hover:bg-surface-700">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar / Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 lg:p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="px-6 py-4 text-center text-xs text-surface-400 dark:text-surface-500 border-t border-surface-100 dark:border-surface-700/50">
            &copy; {{ date('Y') }} Ot's Media. All rights reserved.
        </footer>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-surface-800
                border-t border-surface-200 dark:border-surface-700
                flex items-center justify-around py-2 lg:hidden safe-area-pb">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('admin.dashboard') ? 'text-primary-600 dark:text-primary-400' : 'text-surface-400' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="text-[10px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('books.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('books.*') ? 'text-primary-600 dark:text-primary-400' : 'text-surface-400' }}">
            <i data-lucide="book-copy" class="w-5 h-5"></i>
            <span class="text-[10px] font-medium">Buku</span>
        </a>
        <a href="{{ route('reads.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('reads.*') ? 'text-primary-600 dark:text-primary-400' : 'text-surface-400' }}">
            <i data-lucide="scroll-text" class="w-5 h-5"></i>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <button @click="$store.sidebar.toggle()" class="flex flex-col items-center gap-0.5 px-3 py-1 text-surface-400">
            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
            <span class="text-[10px] font-medium">Lainnya</span>
        </button>
    </nav>

    <!-- Notification Toast -->
    <div x-show="$store.notification.show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-4 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-4 opacity-0"
         class="fixed bottom-20 lg:bottom-6 right-6 z-[60] max-w-sm"
         style="display:none;">
        <div :class="{
                 'bg-emerald-500': $store.notification.type === 'success',
                 'bg-rose-500': $store.notification.type === 'error',
                 'bg-amber-500': $store.notification.type === 'warning'
             }"
             class="text-white px-5 py-3 rounded-xl shadow-float flex items-center gap-3">
            <i x-show="$store.notification.type === 'success'" data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
            <i x-show="$store.notification.type === 'error'" data-lucide="x-circle" class="w-5 h-5 shrink-0"></i>
            <span class="text-sm font-medium" x-text="$store.notification.message"></span>
        </div>
    </div>

    <!-- Re-init Lucide after Alpine renders -->
    <script>
        document.addEventListener('DOMContentLoaded', () => { if(window.lucide) lucide.createIcons(); });
    </script>
</body>
</html>
