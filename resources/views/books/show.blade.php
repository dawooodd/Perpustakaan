@extends('layouts.public')

@section('title', $book->title)
@section('meta_description', Str::limit($book->description, 160))

@section('content')
<div x-data="{ showAuthModal: false }">

    {{-- Hero Section --}}
    <section class="relative pt-24 pb-16 overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-surface-900 via-surface-800 to-primary-950"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="absolute top-20 right-10 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-10 w-72 h-72 bg-violet-500/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-start gap-10">

                {{-- Book Cover --}}
                <div class="shrink-0 w-48 lg:w-56">
                    <div class="aspect-[3/4] rounded-2xl bg-gradient-to-br from-primary-600 to-violet-700 shadow-2xl shadow-black/30 overflow-hidden relative group">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                                <i data-lucide="book-open" class="w-12 h-12 text-white/30 mb-3"></i>
                                <h4 class="font-display font-bold text-white text-base leading-tight">{{ $book->title }}</h4>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Book Info --}}
                <div class="flex-1 min-w-0">
                    {{-- Breadcrumb --}}
                    <nav class="flex items-center gap-2 text-sm text-white/40 mb-4">
                        <a href="/" class="hover:text-white/70 transition-colors">Beranda</a>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        <a href="{{ route('books.index') }}" class="hover:text-white/70 transition-colors">Katalog</a>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        <span class="text-white/70 truncate max-w-[200px]">{{ $book->title }}</span>
                    </nav>

                    <h1 class="text-3xl lg:text-4xl font-display font-extrabold text-white leading-tight mb-3">
                        {{ $book->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        @if($book->author)
                        <div class="flex items-center gap-2">
                            <div class="avatar avatar-sm bg-white/10 text-white/80 text-xs">{{ substr($book->author->name, 0, 2) }}</div>
                            <span class="text-sm text-white/70">{{ $book->author->name }}</span>
                        </div>
                        @endif
                        @if($book->publisher)
                        <span class="text-white/20">•</span>
                        <span class="text-sm text-white/50">{{ $book->publisher->name }}</span>
                        @endif
                        @if($book->isbn)
                        <span class="text-white/20">•</span>
                        <code class="text-xs text-white/40 bg-white/5 px-2 py-0.5 rounded">ISBN {{ $book->isbn }}</code>
                        @endif
                    </div>

                    {{-- Stats --}}
                    <div class="flex flex-wrap gap-4 mb-6">
                        <div class="flex items-center gap-1.5 text-sm text-white/60">
                            <i data-lucide="heart" class="w-4 h-4 text-rose-400"></i>
                            <span>{{ $likesCount }} Suka</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-sm text-white/60">
                            <i data-lucide="eye" class="w-4 h-4 text-blue-400"></i>
                            <span>{{ $readsCount }} Pembaca</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-sm text-white/60">
                            <i data-lucide="list" class="w-4 h-4 text-emerald-400"></i>
                            <span>{{ $chaptersCount }} Bab</span>
                        </div>
                    </div>

                    {{-- Description --}}
                    <p class="text-sm text-white/50 leading-relaxed mb-8 max-w-2xl">
                        {{ $book->description }}
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap items-center gap-3">
                        @if($readProgress && $readProgress->last_chapter_id)
                            <a href="{{ route('books.read', ['book' => $book->id, 'chapter' => $readProgress->last_chapter_id]) }}"
                               class="btn bg-gradient-to-r from-primary-600 to-primary-500 text-white px-8 py-3 shadow-lg shadow-primary-600/30 hover:shadow-xl hover:shadow-primary-600/40">
                                <i data-lucide="book-open-check" class="w-5 h-5"></i>
                                Lanjut Membaca
                            </a>
                        @elseif($book->chapters->count() > 0)
                            <a href="{{ route('books.read', $book->id) }}"
                               class="btn bg-gradient-to-r from-primary-600 to-primary-500 text-white px-8 py-3 shadow-lg shadow-primary-600/30 hover:shadow-xl hover:shadow-primary-600/40">
                                <i data-lucide="book-open-check" class="w-5 h-5"></i>
                                Mulai Membaca
                            </a>
                        @endif

                        {{-- Like Button --}}
                        <button
                            x-data="{ liked: {{ $isLiked ? 'true' : 'false' }}, count: {{ $likesCount }} }"
                            @click="
                                @guest showAuthModal = true; return; @endguest
                                fetch('/books/{{ $book->id }}/like', {
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                                }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })
                            "
                            class="btn-secondary py-3 group"
                            :class="liked ? 'ring-2 ring-rose-500/30' : ''">
                            <svg :class="liked ? 'text-rose-500 fill-rose-500' : 'text-surface-500'" class="w-5 h-5 transition-all duration-200 heart-btn" :style="liked && 'animation: heartBeat 0.4s ease-in-out'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                            <span x-text="count"></span>
                        </button>

                        {{-- Bookmark Button --}}
                        <button
                            x-data="{ bookmarked: {{ $isBookmarked ? 'true' : 'false' }} }"
                            @click="
                                @guest showAuthModal = true; return; @endguest
                                fetch('/books/{{ $book->id }}/bookmark', {
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                                }).then(r => r.json()).then(d => { bookmarked = d.bookmarked; })
                            "
                            class="btn-secondary py-3"
                            :class="bookmarked ? 'ring-2 ring-amber-500/30' : ''">
                            <svg :class="bookmarked ? 'text-amber-500 fill-amber-500' : 'text-surface-500'" class="w-5 h-5 transition-all duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                            <span x-text="bookmarked ? 'Tersimpan' : 'Bookmark'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Chapter List --}}
    @if($book->chapters->count() > 0)
    <section class="py-12 bg-white dark:bg-surface-800/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-display font-bold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
                <i data-lucide="list-ordered" class="w-5 h-5 text-primary-500"></i>
                Daftar Bab
                <span class="text-sm font-normal text-surface-400">({{ $chaptersCount }})</span>
            </h2>

            <div class="space-y-2">
                @foreach($book->chapters as $chap)
                <a href="{{ route('books.read', ['book' => $book->id, 'chapter' => $chap->id]) }}"
                   class="flex items-center justify-between p-4 rounded-xl border border-surface-200 dark:border-surface-700
                          hover:bg-surface-50 dark:hover:bg-surface-700/30 hover:border-primary-300 dark:hover:border-primary-700
                          transition-all duration-200 group">
                    <div class="flex items-center gap-4">
                        <span class="w-10 h-10 rounded-xl bg-surface-100 dark:bg-surface-700 flex items-center justify-center
                                     text-sm font-bold text-surface-500 dark:text-surface-400
                                     group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30
                                     group-hover:text-primary-600 dark:group-hover:text-primary-400
                                     transition-all duration-200">
                            {{ $chap->chapter_number }}
                        </span>
                        <div>
                            <h4 class="font-semibold text-surface-800 dark:text-surface-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                {{ $chap->title }}
                            </h4>
                        </div>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-surface-300 dark:text-surface-600 group-hover:text-primary-500 transition-colors"></i>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Comments Section --}}
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('components.comment-section', ['book' => $book])
        </div>
    </section>

    {{-- Auth Modal for Guests --}}
    @guest
        @include('components.auth-modal')
    @endguest
</div>
@endsection
