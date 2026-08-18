@extends('layouts.public')

@section('title', 'Dashboard')

@section('content')
<section class="pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Welcome Header --}}
        <div class="mb-10">
            <h1 class="text-3xl font-display font-bold text-surface-900 dark:text-white mb-2">
                Halo, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-surface-500 dark:text-surface-400">Lanjutkan petualangan membacamu.</p>
        </div>

        {{-- ═══════════ Riwayat Baca / Reading History ═══════════ --}}
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-display font-bold text-surface-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-primary-500"></i>
                    Riwayat Baca
                </h2>
            </div>

            @if($readingHistory->count() > 0)
            <div class="flex gap-5 overflow-x-auto pb-4 -mx-4 px-4 snap-x snap-mandatory scrollbar-thin">
                @foreach($readingHistory as $read)
                <div class="shrink-0 w-72 snap-start">
                    <div class="card-hover p-5 h-full flex flex-col">
                        <div class="flex gap-4 mb-4">
                            {{-- Mini Cover --}}
                            <div class="w-16 h-22 shrink-0 rounded-xl bg-gradient-to-br from-primary-500 to-violet-600 overflow-hidden shadow-md">
                                @if($read->book->cover_image)
                                    <img src="{{ asset('storage/' . $read->book->cover_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="book-open" class="w-5 h-5 text-white/40"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 truncate mb-1">
                                    {{ $read->book->title }}
                                </h4>
                                <p class="text-xs text-surface-400 dark:text-surface-500 truncate">
                                    {{ $read->book->author?->name ?? 'Tanpa Penulis' }}
                                </p>
                                @if($read->chapter)
                                <p class="text-xs text-primary-600 dark:text-primary-400 mt-1.5 truncate">
                                    Bab {{ $read->chapter->chapter_number }}: {{ $read->chapter->title }}
                                </p>
                                @endif
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mb-3">
                            @php $progress = $read->progress_percent; @endphp
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="text-surface-400 dark:text-surface-500">Progress</span>
                                <span class="font-semibold text-primary-600 dark:text-primary-400">{{ $progress }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-surface-100 dark:bg-surface-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500"
                                     style="width: {{ $progress }}%; background: linear-gradient(90deg, #6366F1, #818CF8);"></div>
                            </div>
                        </div>

                        {{-- Continue Button --}}
                        <a href="{{ route('books.read', ['book' => $read->book->id, 'chapter' => $read->last_chapter_id]) }}"
                           class="btn-primary btn-sm w-full justify-center mt-auto">
                            <i data-lucide="book-open-check" class="w-3.5 h-3.5"></i>
                            Lanjut Membaca
                        </a>

                        {{-- Last read time --}}
                        <p class="text-[10px] text-surface-400 dark:text-surface-500 text-center mt-2">
                            {{ $read->last_read_at?->diffForHumans() ?? 'Baru saja' }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card p-12 text-center">
                <i data-lucide="book-open" class="w-12 h-12 mx-auto text-surface-300 dark:text-surface-600 mb-4"></i>
                <h3 class="font-semibold text-surface-600 dark:text-surface-400 mb-2">Belum ada riwayat baca</h3>
                <p class="text-sm text-surface-400 dark:text-surface-500 mb-4">Mulai jelajahi katalog dan baca buku pertamamu!</p>
                <a href="{{ route('books.index') }}" class="btn-primary btn-sm">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i> Jelajahi Katalog
                </a>
            </div>
            @endif
        </div>

        {{-- ═══════════ Bookmark Saya ═══════════ --}}
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-display font-bold text-surface-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="bookmark" class="w-5 h-5 text-amber-500"></i>
                    Bookmark Saya
                </h2>
                @if($bookmarks->count() > 0)
                <span class="text-sm text-surface-400">{{ $bookmarks->count() }} buku</span>
                @endif
            </div>

            @if($bookmarks->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5">
                @foreach($bookmarks as $bookmark)
                <a href="{{ route('books.show', $bookmark->book->id) }}" class="group cursor-pointer block">
                    {{-- Cover --}}
                    <div class="relative aspect-[3/4] rounded-2xl bg-gradient-to-br from-primary-500 to-violet-700 shadow-card
                                group-hover:shadow-card-hover group-hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        @if($bookmark->book->cover_image)
                            <img src="{{ asset('storage/' . $bookmark->book->cover_image) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                                <i data-lucide="book-open" class="w-8 h-8 text-white/30 mb-2"></i>
                                <h4 class="font-display font-bold text-white text-sm leading-tight">{{ $bookmark->book->title }}</h4>
                            </div>
                        @endif

                        {{-- Bookmark indicator --}}
                        <div class="absolute top-3 right-3">
                            <span class="w-7 h-7 rounded-lg bg-amber-500 flex items-center justify-center shadow-md">
                                <i data-lucide="bookmark" class="w-3.5 h-3.5 text-white fill-white"></i>
                            </span>
                        </div>

                        {{-- Hover overlay --}}
                        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                            <span class="px-4 py-2 rounded-lg bg-white text-surface-800 text-xs font-semibold flex items-center gap-1.5">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat
                            </span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="mt-3 px-1">
                        <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ $bookmark->book->title }}
                        </h4>
                        <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">
                            {{ $bookmark->book->author?->name ?? 'Tanpa Penulis' }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="card p-12 text-center">
                <i data-lucide="bookmark" class="w-12 h-12 mx-auto text-surface-300 dark:text-surface-600 mb-4"></i>
                <h3 class="font-semibold text-surface-600 dark:text-surface-400 mb-2">Belum ada bookmark</h3>
                <p class="text-sm text-surface-400 dark:text-surface-500 mb-4">Tandai buku favoritmu agar mudah ditemukan kembali.</p>
                <a href="{{ route('books.index') }}" class="btn-primary btn-sm">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i> Jelajahi Katalog
                </a>
            </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('books.index') }}" class="btn-secondary">
                <i data-lucide="book-copy" class="w-4 h-4"></i> Katalog Buku
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn-ghost text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
