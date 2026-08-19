@extends('layouts.public')

@section('title', 'PustakaOne')
@section('meta_description', 'Jelajahi ribuan koleksi buku digital. Baca kapan saja, di mana saja.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden bg-surface-50 dark:bg-surface-900">
    <!-- Subtle ambient glow — accent only, not a full background -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-primary-500/[0.06] dark:bg-primary-400/[0.04] rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 w-full">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-50 dark:bg-primary-900/20 border border-primary-200/60 dark:border-primary-700/40 mb-8">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-sm font-medium text-primary-700 dark:text-primary-300">Platform Baca Digital #1</span>
            </div>

            <!-- Heading — clean, no SVG swoosh -->
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-display font-extrabold tracking-tight text-surface-900 dark:text-white leading-[1.1] mb-6">
                Jelajahi Dunia
                <span class="text-primary-600 dark:text-primary-400">Pengetahuan</span>
                <br>Tanpa Batas
            </h1>

            <p class="text-lg sm:text-xl text-surface-500 dark:text-surface-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Ribuan koleksi buku digital tersedia untukmu. Temukan, baca, dan kelola perpustakaanmu secara modern dan efisien.
            </p>

            <!-- Search Bar — solid background with soft shadow -->
            <div class="max-w-3xl mx-auto"
                 x-data="{ query: '', category: '', showFilters: false }">
                <div class="bg-white dark:bg-surface-800 rounded-2xl p-2 border border-surface-200 dark:border-surface-700 shadow-lg shadow-surface-900/5 dark:shadow-black/20">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-surface-400 dark:text-surface-500"></i>
                            <input x-model="query" type="text" placeholder="Cari judul buku, penulis, atau ISBN..."
                                   class="w-full pl-12 pr-4 py-4 bg-surface-50 dark:bg-surface-700/50 text-surface-800 dark:text-surface-200
                                          placeholder:text-surface-400 dark:placeholder:text-surface-500
                                          rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-primary-500/30
                                          text-sm sm:text-base transition-all duration-200">
                        </div>
                        <div class="flex gap-2">
                            <button @click="showFilters = !showFilters"
                                    class="px-4 py-3 rounded-xl bg-surface-100 dark:bg-surface-700 text-surface-500 dark:text-surface-400
                                           hover:bg-surface-200 dark:hover:bg-surface-600 transition-all duration-200 flex items-center gap-2">
                                <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                                <span class="text-sm hidden sm:inline">Filter</span>
                            </button>
                            <button class="px-8 py-3 rounded-xl bg-primary-600 text-white font-semibold
                                           hover:bg-primary-700 transition-all duration-200
                                           shadow-lg shadow-primary-600/25
                                           flex items-center gap-2 text-sm sm:text-base">
                                <i data-lucide="search" class="w-4 h-4"></i>
                                Cari
                            </button>
                        </div>
                    </div>
                    <!-- Filter Dropdown -->
                    <div x-show="showFilters" x-transition class="mt-2 p-4 bg-surface-50 dark:bg-surface-700/30 rounded-xl border border-surface-100 dark:border-surface-700 grid grid-cols-1 sm:grid-cols-3 gap-3" style="display:none;">
                        <select class="bg-white dark:bg-surface-700 border border-surface-200 dark:border-surface-600 text-surface-700 dark:text-surface-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500">
                            <option value="">Semua Kategori</option>
                            <option value="fiksi">Fiksi</option>
                            <option value="nonfiksi">Non-Fiksi</option>
                            <option value="sains">Sains</option>
                            <option value="teknologi">Teknologi</option>
                        </select>
                        <select class="bg-white dark:bg-surface-700 border border-surface-200 dark:border-surface-600 text-surface-700 dark:text-surface-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500">
                            <option value="">Semua Level</option>
                            <option value="pemula">Pemula</option>
                            <option value="menengah">Menengah</option>
                            <option value="lanjut">Lanjut</option>
                        </select>
                        <select class="bg-white dark:bg-surface-700 border border-surface-200 dark:border-surface-600 text-surface-700 dark:text-surface-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500">
                            <option value="">Semua Penerbit</option>
                            <option value="gramedia">Gramedia</option>
                            <option value="erlangga">Erlangga</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Quick Tags -->
            <div class="flex flex-wrap justify-center gap-2 mt-6">
                <span class="text-xs text-surface-400 dark:text-surface-500 mr-1 self-center">Populer:</span>
                <a href="#" class="px-3 py-1 rounded-full text-xs font-medium bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-300 border border-surface-200 dark:border-surface-700 hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Pemrograman</a>
                <a href="#" class="px-3 py-1 rounded-full text-xs font-medium bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-300 border border-surface-200 dark:border-surface-700 hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Novel Fiksi</a>
                <a href="#" class="px-3 py-1 rounded-full text-xs font-medium bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-300 border border-surface-200 dark:border-surface-700 hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Desain UI/UX</a>
                <a href="#" class="px-3 py-1 rounded-full text-xs font-medium bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-300 border border-surface-200 dark:border-surface-700 hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Machine Learning</a>
            </div>
        </div>

        <!-- Stats Bar — clean cards with borders -->
        <div class="max-w-3xl mx-auto mt-16 grid grid-cols-3 gap-4">
            <div class="text-center p-5 rounded-2xl bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 shadow-sm">
                <div class="text-3xl sm:text-4xl font-display font-bold text-surface-900 dark:text-white" x-data="{ count: 0 }" x-init="let interval = setInterval(() => { if(count < 2450) count += 37; else { count = 2450; clearInterval(interval); } }, 20)">
                    <span x-text="count.toLocaleString()">0</span>
                </div>
                <div class="text-sm text-surface-500 dark:text-surface-400 mt-1">Total Buku</div>
            </div>
            <div class="text-center p-5 rounded-2xl bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 shadow-sm">
                <div class="text-3xl sm:text-4xl font-display font-bold text-surface-900 dark:text-white" x-data="{ count: 0 }" x-init="let interval = setInterval(() => { if(count < 186) count += 3; else { count = 186; clearInterval(interval); } }, 25)">
                    <span x-text="count">0</span>
                </div>
                <div class="text-sm text-surface-500 dark:text-surface-400 mt-1">Penulis</div>
            </div>
            <div class="text-center p-5 rounded-2xl bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 shadow-sm">
                <div class="text-3xl sm:text-4xl font-display font-bold text-surface-900 dark:text-white" x-data="{ count: 0 }" x-init="let interval = setInterval(() => { if(count < 1203) count += 18; else { count = 1203; clearInterval(interval); } }, 20)">
                    <span x-text="count.toLocaleString()">0</span>
                </div>
                <div class="text-sm text-surface-500 dark:text-surface-400 mt-1">Pembaca Aktif</div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <i data-lucide="chevrons-down" class="w-6 h-6 text-surface-300 dark:text-surface-600"></i>
    </div>
</section>

<!-- Bento Grid Section -->
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-900/20 mb-4">
                <i data-lucide="sparkles" class="w-4 h-4 text-primary-600 dark:text-primary-400"></i>
                <span class="text-xs font-semibold text-primary-700 dark:text-primary-400 uppercase tracking-wide">Highlights</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-display font-bold text-surface-900 dark:text-white mb-3">Temukan yang Menarik</h2>
            <p class="text-surface-500 dark:text-surface-400 max-w-lg mx-auto">Koleksi pilihan, penulis populer, dan tren membaca terkini.</p>
        </div>

        <!-- Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 auto-rows-[200px] lg:auto-rows-[180px]">

            <!-- Featured Book — Large -->
            <div class="card-hover md:col-span-2 md:row-span-2 relative overflow-hidden group cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600 to-violet-700"></div>
                <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
                <div class="relative h-full p-6 lg:p-8 flex flex-col justify-between">
                    <div>
                        <span class="badge bg-white/20 text-white text-xs backdrop-blur-sm">⭐ Buku Pilihan</span>
                        <h3 class="text-2xl lg:text-3xl font-display font-bold text-white mt-4 leading-tight">Clean Code: A Handbook of Agile Software Craftsmanship</h3>
                        <p class="text-white/60 text-sm mt-2">Robert C. Martin</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="badge-available">Tersedia</span>
                        <button class="px-4 py-2 rounded-xl bg-white text-primary-700 text-sm font-semibold hover:bg-white/90 transition-all duration-200 flex items-center gap-2 group-hover:scale-105 transform">
                            <i data-lucide="book-open-check" class="w-4 h-4"></i> Baca Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Popular Authors -->
            <div class="card-hover p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wide">Penulis Populer</span>
                    <i data-lucide="users" class="w-4 h-4 text-primary-500"></i>
                </div>
                <div class="space-y-2.5 mt-3">
                    <div class="flex items-center gap-2.5">
                        <div class="avatar avatar-sm bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 shrink-0">RC</div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate">Robert C. Martin</p>
                            <p class="text-xs text-surface-400">12 buku</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="avatar avatar-sm bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 shrink-0">MP</div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate">Martin Fowler</p>
                            <p class="text-xs text-surface-400">8 buku</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reading Trends -->
            <div class="card-hover p-5 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wide">Tren Baca</span>
                    <i data-lucide="trending-up" class="w-4 h-4 text-emerald-500"></i>
                </div>
                <div class="flex-1 flex items-end mt-3">
                    <!-- CSS Sparkline -->
                    <div class="flex items-end gap-1 w-full h-16">
                        <div class="flex-1 bg-primary-200 dark:bg-primary-800 rounded-t-sm" style="height:40%"></div>
                        <div class="flex-1 bg-primary-200 dark:bg-primary-800 rounded-t-sm" style="height:55%"></div>
                        <div class="flex-1 bg-primary-200 dark:bg-primary-800 rounded-t-sm" style="height:35%"></div>
                        <div class="flex-1 bg-primary-200 dark:bg-primary-800 rounded-t-sm" style="height:70%"></div>
                        <div class="flex-1 bg-primary-200 dark:bg-primary-800 rounded-t-sm" style="height:60%"></div>
                        <div class="flex-1 bg-primary-200 dark:bg-primary-800 rounded-t-sm" style="height:85%"></div>
                        <div class="flex-1 bg-primary-500 rounded-t-sm" style="height:100%"></div>
                    </div>
                </div>
                <p class="text-xs text-surface-400 mt-2">+24% bulan ini</p>
            </div>

            <!-- New Arrivals -->
            <div class="card-hover p-5 lg:col-span-2 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wide">Baru Ditambahkan</span>
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                </div>
                <div class="flex gap-3 mt-3 overflow-x-auto pb-1">
                    @php
                        $sampleBooks = [
                            ['title' => 'Design Patterns', 'color' => 'from-blue-500 to-cyan-500'],
                            ['title' => 'The Pragmatic Programmer', 'color' => 'from-amber-500 to-orange-500'],
                            ['title' => 'Refactoring', 'color' => 'from-emerald-500 to-teal-500'],
                            ['title' => 'Domain-Driven Design', 'color' => 'from-violet-500 to-purple-500'],
                        ];
                    @endphp
                    @foreach($sampleBooks as $sample)
                    <div class="shrink-0 w-20 group cursor-pointer">
                        <div class="w-20 h-28 rounded-lg bg-gradient-to-br {{ $sample['color'] }} shadow-md group-hover:shadow-lg group-hover:-translate-y-1 transition-all duration-200 flex items-center justify-center p-2">
                            <span class="text-[10px] font-bold text-white text-center leading-tight">{{ $sample['title'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Categories Quick -->
            <div class="card-hover p-5 lg:col-span-2 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wide">Kategori</span>
                    <i data-lucide="tags" class="w-4 h-4 text-primary-500"></i>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                    <span class="badge-level">Pemrograman</span>
                    <span class="badge-level">Desain</span>
                    <span class="badge-neutral">Novel</span>
                    <span class="badge-neutral">Sains</span>
                    <span class="badge-level">Database</span>
                    <span class="badge-neutral">Sejarah</span>
                    <span class="badge-level">AI & ML</span>
                    <span class="badge-neutral">Bisnis</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Book Catalog Preview -->
<section class="py-16 lg:py-24 bg-white dark:bg-surface-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
            <div>
                <h2 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">Koleksi Buku</h2>
                <p class="text-surface-500 dark:text-surface-400 mt-1">Jelajahi koleksi lengkap kami</p>
            </div>
            <a href="{{ route('books.index') }}" class="btn-secondary">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Book Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-6">
            @php
                $bookCovers = [
                    ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'color' => 'from-sky-600 to-blue-800', 'status' => 'available'],
                    ['title' => 'The Pragmatic Programmer', 'author' => 'David Thomas', 'color' => 'from-amber-500 to-orange-700', 'status' => 'borrowed'],
                    ['title' => 'Design Patterns', 'author' => 'Gang of Four', 'color' => 'from-emerald-500 to-green-800', 'status' => 'available'],
                    ['title' => 'Refactoring', 'author' => 'Martin Fowler', 'color' => 'from-violet-500 to-purple-800', 'status' => 'available'],
                    ['title' => 'Head First Java', 'author' => 'Kathy Sierra', 'color' => 'from-rose-500 to-pink-800', 'status' => 'overdue'],
                    ['title' => 'Structure & Interpretation', 'author' => 'Harold Abelson', 'color' => 'from-teal-500 to-cyan-800', 'status' => 'available'],
                    ['title' => 'Code Complete', 'author' => 'Steve McConnell', 'color' => 'from-indigo-500 to-blue-900', 'status' => 'borrowed'],
                    ['title' => 'Mythical Man-Month', 'author' => 'Fred Brooks', 'color' => 'from-slate-500 to-gray-800', 'status' => 'available'],
                    ['title' => 'Domain-Driven Design', 'author' => 'Eric Evans', 'color' => 'from-fuchsia-500 to-purple-900', 'status' => 'available'],
                    ['title' => 'Intro to Algorithms', 'author' => 'Thomas Cormen', 'color' => 'from-red-500 to-rose-900', 'status' => 'available'],
                ];
            @endphp
            @foreach($bookCovers as $book)
            <div class="group cursor-pointer" x-data="{ showDetail: false }">
                <!-- Cover -->
                <div class="relative aspect-[3/4] rounded-2xl bg-gradient-to-br {{ $book['color'] }} shadow-card
                            group-hover:shadow-card-hover group-hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                        <i data-lucide="book-open" class="w-8 h-8 text-white/30 mb-3"></i>
                        <h4 class="font-display font-bold text-white text-sm leading-tight">{{ $book['title'] }}</h4>
                    </div>
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-2">
                        <button class="px-3 py-2 rounded-lg bg-white text-surface-800 text-xs font-semibold hover:bg-white/90 transition-colors flex items-center gap-1.5">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                        </button>
                        <button class="px-3 py-2 rounded-lg bg-primary-600 text-white text-xs font-semibold hover:bg-primary-700 transition-colors flex items-center gap-1.5">
                            <i data-lucide="book-open-check" class="w-3.5 h-3.5"></i> Baca
                        </button>
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @if($book['status'] === 'available')
                            <span class="badge-available text-[10px]"><i data-lucide="check-circle" class="w-3 h-3"></i> Tersedia</span>
                        @elseif($book['status'] === 'borrowed')
                            <span class="badge-borrowed text-[10px]"><i data-lucide="clock" class="w-3 h-3"></i> Dipinjam</span>
                        @else
                            <span class="badge-overdue text-[10px]"><i data-lucide="alert-triangle" class="w-3 h-3"></i> Terlambat</span>
                        @endif
                    </div>
                </div>
                <!-- Info -->
                <div class="mt-3 px-1">
                    <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $book['title'] }}</h4>
                    <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">{{ $book['author'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 lg:py-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="card-glass p-10 lg:p-16 relative overflow-hidden">
            <div class="absolute -top-20 -right-20 w-60 h-60 bg-primary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-violet-500/10 rounded-full blur-3xl"></div>
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-600 to-primary-400 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary-600/25">
                    <i data-lucide="book-heart" class="w-8 h-8 text-white"></i>
                </div>
                <h2 class="text-3xl lg:text-4xl font-display font-bold text-surface-900 dark:text-white mb-4">Siap Mulai Membaca?</h2>
                <p class="text-surface-500 dark:text-surface-400 max-w-lg mx-auto mb-8">
                    Akses ribuan buku digital, kelola daftar bacaanmu, dan temukan rekomendasi buku terbaik yang disesuaikan untukmu.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('books.index') }}" class="btn-primary px-8 py-3">
                        <i data-lucide="book-copy" class="w-5 h-5"></i> Jelajahi Katalog
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary px-8 py-3">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
