<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PustakaOne') — Katalog Buku</title>
    <meta name="description" content="@yield('meta_description', 'Jelajahi koleksi buku digital terlengkap. Baca buku favoritmu kapan saja, di mana saja.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:wght@300;400;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-50 dark:bg-surface-900 text-surface-800 dark:text-surface-200">

    <!-- Public Navbar -->
    <header x-data="{ scrolled: false, mobileMenu: false }"
            @scroll.window="scrolled = window.scrollY > 50"
            :class="scrolled ? 'bg-white/90 dark:bg-surface-900/90 backdrop-blur-xl shadow-sm border-b border-surface-200/50 dark:border-surface-700/50' : 'bg-transparent'"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-600 to-primary-400 flex items-center justify-center shadow-lg shadow-primary-600/25">
                        <i data-lucide="book-open" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="font-display font-bold text-xl text-surface-900 dark:text-white">Pustaka<span class="text-primary-600 dark:text-primary-400">One</span></span>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="/" class="px-4 py-2 text-sm font-medium text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-primary-400 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700/50 transition-all duration-200">Beranda</a>
                    <a href="{{ route('books.index') }}" class="px-4 py-2 text-sm font-medium text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-primary-400 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700/50 transition-all duration-200">Katalog</a>
                    <a href="{{ route('authors.index') }}" class="px-4 py-2 text-sm font-medium text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-primary-400 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700/50 transition-all duration-200">Penulis</a>
                    <a href="{{ route('publishers.index') }}" class="px-4 py-2 text-sm font-medium text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-primary-400 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700/50 transition-all duration-200">Penerbit</a>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <button @click="$store.theme.toggle()" class="btn-icon text-surface-500 dark:text-surface-400">
                        <i x-show="!$store.theme.dark" data-lucide="moon" class="w-5 h-5"></i>
                        <i x-show="$store.theme.dark" data-lucide="sun" class="w-5 h-5" style="display:none;"></i>
                    </button>

                    @auth
                    <a href="{{ route('user.dashboard') }}" class="btn-secondary btn-sm hidden lg:inline-flex">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        {{ Auth::user()->name }}
                    </a>
                    @endauth

                    @guest
                    <a href="{{ route('login') }}" class="btn-secondary btn-sm hidden lg:inline-flex">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary btn-sm hidden lg:inline-flex">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Daftar
                    </a>
                    @endguest

                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenu = !mobileMenu" class="btn-icon lg:hidden text-surface-600 dark:text-surface-300">
                        <i x-show="!mobileMenu" data-lucide="menu" class="w-5 h-5"></i>
                        <i x-show="mobileMenu" data-lucide="x" class="w-5 h-5" style="display:none;"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                 class="lg:hidden pb-4 border-t border-surface-200 dark:border-surface-700 mt-2 pt-4 space-y-1"
                 style="display:none;">
                <a href="/" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700/50">Beranda</a>
                <a href="{{ route('books.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700/50">Katalog Buku</a>
                <a href="{{ route('authors.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700/50">Penulis</a>
                <a href="{{ route('publishers.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700/50">Penerbit</a>
                <div class="pt-2 space-y-2">
                    @auth
                    <a href="{{ route('user.dashboard') }}" class="btn-secondary w-full text-center">Dashboard Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-ghost w-full text-center text-rose-600">Keluar</button>
                    </form>
                    @endauth
                    @guest
                    <a href="{{ route('login') }}" class="btn-secondary w-full text-center">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary w-full text-center">Daftar</a>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-surface-800 border-t border-surface-200 dark:border-surface-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-600 to-primary-400 flex items-center justify-center">
                            <i data-lucide="book-open" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="font-display font-bold text-lg text-surface-900 dark:text-white">Pustaka<span class="text-primary-600 dark:text-primary-400">One</span></span>
                    </a>
                    <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed">
                        Platform perpustakaan digital modern untuk membaca dan mengelola koleksi buku secara efisien.
                    </p>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 mb-4">Jelajahi</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('books.index') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Katalog Buku</a></li>
                        <li><a href="{{ route('authors.index') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Penulis</a></li>
                        <li><a href="{{ route('publishers.index') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Penerbit</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 mb-4">Manajemen</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('admin.dashboard') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('reads.index') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Riwayat Baca</a></li>
                        <li><a href="{{ route('levels.index') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Level / Kategori</a></li>
                    </ul>
                </div>
                <!-- Newsletter -->
                <div>
                    <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 mb-4">Berlangganan</h4>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-3">Dapatkan info buku terbaru.</p>
                    <form action="#" method="POST" class="flex gap-2">
                        @csrf
                        <input type="email" placeholder="email@contoh.com" required class="flex-1 form-input text-sm py-2.5">
                        <button type="submit" class="btn-primary btn-sm shrink-0">
                            <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-surface-100 dark:border-surface-700/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-surface-400 dark:text-surface-500">&copy; {{ date('Y') }} Ot's Media. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-surface-400 dark:text-surface-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><i data-lucide="github" class="w-4 h-4"></i></a>
                    <a href="#" class="text-surface-400 dark:text-surface-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                    <a href="#" class="text-surface-400 dark:text-surface-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => { if(window.lucide) lucide.createIcons(); });
    </script>

    @stack('scripts')
</body>
</html>
