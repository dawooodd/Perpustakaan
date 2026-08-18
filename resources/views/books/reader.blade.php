@extends('layouts.reader')

@section('title', ($chapter ? $chapter->title . ' — ' : '') . $book->title)
@section('meta_description', Str::limit($book->description, 160))

@section('content')
<div x-data="readerApp()" x-init="init()"
     :class="{
         'sepia-mode': $store.readerSettings.theme === 'sepia',
         'dark': $store.readerSettings.theme === 'dark' || ($store.readerSettings.theme === 'auto' && $store.theme.dark),
     }"
     class="min-h-screen transition-colors duration-300">

    {{-- ═══════════ Reading Progress Bar ═══════════ --}}
    <div class="reader-progress-bar" :style="'width: ' + scrollProgress + '%'"></div>

    {{-- ═══════════ Top Toolbar ═══════════ --}}
    <header class="reader-toolbar">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between">
            {{-- Left: Back + Title --}}
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('books.show', $book->id) }}"
                   class="btn-icon shrink-0 text-surface-500 dark:text-surface-400 hover:text-surface-800 dark:hover:text-white">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div class="min-w-0">
                    <h1 class="text-sm font-semibold text-surface-800 dark:text-surface-200 truncate">{{ $book->title }}</h1>
                    @if($chapter)
                    <p class="text-xs text-surface-400 dark:text-surface-500 truncate">Bab {{ $chapter->chapter_number }}: {{ $chapter->title }}</p>
                    @endif
                </div>
            </div>

            {{-- Right: Settings + Chapters --}}
            <div class="flex items-center gap-1">
                {{-- Chapter Drawer Toggle --}}
                <button @click="drawerOpen = !drawerOpen" class="btn-icon text-surface-500 dark:text-surface-400">
                    <i data-lucide="list" class="w-5 h-5"></i>
                </button>

                {{-- Settings Toggle --}}
                <div class="relative" x-data="{ settingsOpen: false }">
                    <button @click="settingsOpen = !settingsOpen" class="btn-icon text-surface-500 dark:text-surface-400">
                        <i data-lucide="settings-2" class="w-5 h-5"></i>
                    </button>

                    {{-- Settings Panel --}}
                    <div x-show="settingsOpen" @click.away="settingsOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="settings-panel" style="display:none;">

                        <h4 class="text-xs font-bold uppercase tracking-wider text-surface-400 dark:text-surface-500 mb-4">Pengaturan Baca</h4>

                        {{-- Theme Switcher --}}
                        <div class="mb-5">
                            <label class="text-xs font-medium text-surface-600 dark:text-surface-300 mb-2 block">Tema</label>
                            <div class="flex gap-2">
                                <button @click="$store.readerSettings.setTheme('light')"
                                        :class="$store.readerSettings.theme === 'light' ? 'ring-2 ring-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'bg-surface-100 dark:bg-surface-700'"
                                        class="flex-1 py-2 rounded-xl text-xs font-medium transition-all duration-200">
                                    <i data-lucide="sun" class="w-4 h-4 mx-auto mb-1"></i> Terang
                                </button>
                                <button @click="$store.readerSettings.setTheme('dark')"
                                        :class="$store.readerSettings.theme === 'dark' ? 'ring-2 ring-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'bg-surface-100 dark:bg-surface-700'"
                                        class="flex-1 py-2 rounded-xl text-xs font-medium transition-all duration-200">
                                    <i data-lucide="moon" class="w-4 h-4 mx-auto mb-1"></i> Gelap
                                </button>
                                <button @click="$store.readerSettings.setTheme('sepia')"
                                        :class="$store.readerSettings.theme === 'sepia' ? 'ring-2 ring-primary-500 bg-amber-50 dark:bg-amber-900/20' : 'bg-surface-100 dark:bg-surface-700'"
                                        class="flex-1 py-2 rounded-xl text-xs font-medium transition-all duration-200">
                                    <i data-lucide="coffee" class="w-4 h-4 mx-auto mb-1"></i> Sepia
                                </button>
                            </div>
                        </div>

                        {{-- Font Size --}}
                        <div class="mb-5">
                            <label class="text-xs font-medium text-surface-600 dark:text-surface-300 mb-2 block">Ukuran Font</label>
                            <div class="flex items-center gap-3">
                                <button @click="$store.readerSettings.decreaseFontSize()"
                                        class="w-9 h-9 rounded-xl bg-surface-100 dark:bg-surface-700 flex items-center justify-center hover:bg-surface-200 dark:hover:bg-surface-600 transition-colors">
                                    <i data-lucide="minus" class="w-4 h-4"></i>
                                </button>
                                <span class="flex-1 text-center text-sm font-semibold" x-text="$store.readerSettings.fontSize + 'px'"></span>
                                <button @click="$store.readerSettings.increaseFontSize()"
                                        class="w-9 h-9 rounded-xl bg-surface-100 dark:bg-surface-700 flex items-center justify-center hover:bg-surface-200 dark:hover:bg-surface-600 transition-colors">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Font Family --}}
                        <div class="mb-5">
                            <label class="text-xs font-medium text-surface-600 dark:text-surface-300 mb-2 block">Jenis Font</label>
                            <div class="flex gap-2">
                                <button @click="$store.readerSettings.setFontFamily('serif')"
                                        :class="$store.readerSettings.fontFamily === 'serif' ? 'ring-2 ring-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'bg-surface-100 dark:bg-surface-700'"
                                        class="flex-1 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 font-serif">
                                    Serif
                                </button>
                                <button @click="$store.readerSettings.setFontFamily('sans')"
                                        :class="$store.readerSettings.fontFamily === 'sans' ? 'ring-2 ring-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'bg-surface-100 dark:bg-surface-700'"
                                        class="flex-1 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 font-sans">
                                    Sans
                                </button>
                            </div>
                        </div>

                        {{-- Line Height --}}
                        <div>
                            <label class="text-xs font-medium text-surface-600 dark:text-surface-300 mb-2 block">Tinggi Baris</label>
                            <input type="range" min="1.4" max="2.4" step="0.1"
                                   :value="$store.readerSettings.lineHeight"
                                   @input="$store.readerSettings.setLineHeight(parseFloat($event.target.value))"
                                   class="w-full h-1.5 bg-surface-200 dark:bg-surface-600 rounded-full appearance-none cursor-pointer
                                          [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4
                                          [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary-500
                                          [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer">
                            <div class="flex justify-between text-[10px] text-surface-400 mt-1">
                                <span>Rapat</span>
                                <span x-text="$store.readerSettings.lineHeight + 'x'"></span>
                                <span>Lebar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ═══════════ Chapter Drawer Overlay ═══════════ --}}
    <div x-show="drawerOpen" @click="drawerOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50"
         style="display:none;"></div>

    {{-- Chapter Drawer --}}
    <aside :class="drawerOpen ? 'translate-x-0' : '-translate-x-full'"
           class="chapter-drawer overflow-y-auto">
        <div class="p-5 border-b border-surface-200 dark:border-surface-700 flex items-center justify-between">
            <h3 class="font-display font-bold text-surface-900 dark:text-white">Daftar Bab</h3>
            <button @click="drawerOpen = false" class="btn-icon text-surface-400">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-3 space-y-1">
            @foreach($book->chapters as $chap)
            <a href="{{ route('books.read', ['book' => $book->id, 'chapter' => $chap->id]) }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ $chapter && $chapter->id === $chap->id
                          ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 font-semibold'
                          : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-700/50' }}">
                <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold shrink-0
                       {{ $chapter && $chapter->id === $chap->id
                           ? 'bg-primary-600 text-white'
                           : 'bg-surface-100 dark:bg-surface-700 text-surface-500' }}">
                    {{ $chap->chapter_number }}
                </span>
                <span class="truncate">{{ $chap->title }}</span>
            </a>
            @endforeach
        </div>
    </aside>

    {{-- ═══════════ Main Content Area ═══════════ --}}
    <main class="reader-body pb-32"
          :class="$store.readerSettings.fontFamily === 'serif' ? 'font-serif-mode' : 'font-sans-mode'"
          :style="'font-size: ' + $store.readerSettings.fontSize + 'px; line-height: ' + $store.readerSettings.lineHeight">

        @if($chapter)
            {{-- Chapter Header --}}
            <div class="text-center mb-12 pt-4">
                <span class="badge-level text-xs mb-3 inline-block">Bab {{ $chapter->chapter_number }}</span>
                <h2 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">
                    {{ $chapter->title }}
                </h2>
            </div>

            {{-- Chapter Content --}}
            <article class="reader-content">
                {!! nl2br(e($chapter->content)) !!}
            </article>

            {{-- Chapter Navigation --}}
            <div class="mt-16 pt-8 border-t border-surface-200 dark:border-surface-700 flex items-center justify-between gap-4">
                @php
                    $prevChapter = $chapter->previous;
                    $nextChapter = $chapter->next;
                @endphp

                @if($prevChapter)
                <a href="{{ route('books.read', ['book' => $book->id, 'chapter' => $prevChapter->id]) }}"
                   class="btn-secondary flex-1 max-w-xs py-3 justify-start">
                    <i data-lucide="chevron-left" class="w-4 h-4 shrink-0"></i>
                    <div class="min-w-0 text-left">
                        <div class="text-[10px] text-surface-400 uppercase tracking-wide">Sebelumnya</div>
                        <div class="text-sm font-semibold truncate">{{ $prevChapter->title }}</div>
                    </div>
                </a>
                @else
                <div></div>
                @endif

                @if($nextChapter)
                <a href="{{ route('books.read', ['book' => $book->id, 'chapter' => $nextChapter->id]) }}"
                   class="btn-primary flex-1 max-w-xs py-3 justify-end text-right">
                    <div class="min-w-0">
                        <div class="text-[10px] text-white/60 uppercase tracking-wide">Selanjutnya</div>
                        <div class="text-sm font-semibold truncate">{{ $nextChapter->title }}</div>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 shrink-0"></i>
                </a>
                @else
                <div class="text-center flex-1">
                    <div class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 text-sm font-semibold">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Selesai! Kamu telah membaca semua bab.
                    </div>
                </div>
                @endif
            </div>
        @elseif($book->content)
            {{-- Inline Book Content (no chapters) --}}
            <article class="reader-content">
                {!! nl2br(e($book->content)) !!}
            </article>
        @endif

        {{-- Comments Section --}}
        <div class="mt-16 pt-8 border-t border-surface-200 dark:border-surface-700">
            @include('components.comment-section', ['book' => $book])
        </div>
    </main>

    {{-- ═══════════ Bottom Action Bar ═══════════ --}}
    <div class="reader-bottom-bar">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-center gap-2">
            {{-- Like --}}
            <button
                x-data="{ liked: {{ $isLiked ? 'true' : 'false' }}, count: {{ $likesCount }} }"
                @click="
                    @guest showAuthModal = true; return; @endguest
                    fetch('/books/{{ $book->id }}/like', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                    }).then(r => r.json()).then(d => { liked = d.liked; count = d.count; })
                "
                class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-200 hover:bg-surface-100 dark:hover:bg-surface-800"
                :class="liked ? 'text-rose-500' : 'text-surface-400 dark:text-surface-500'">
                <svg :class="liked && 'fill-rose-500 heart-btn liked'" class="w-5 h-5 transition-all" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                <span class="text-sm font-medium" x-text="count"></span>
            </button>

            <div class="w-px h-6 bg-surface-200 dark:bg-surface-700"></div>

            {{-- Bookmark --}}
            <button
                x-data="{ bookmarked: {{ $isBookmarked ? 'true' : 'false' }} }"
                @click="
                    @guest showAuthModal = true; return; @endguest
                    fetch('/books/{{ $book->id }}/bookmark', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                    }).then(r => r.json()).then(d => { bookmarked = d.bookmarked; })
                "
                class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-200 hover:bg-surface-100 dark:hover:bg-surface-800"
                :class="bookmarked ? 'text-amber-500' : 'text-surface-400 dark:text-surface-500'">
                <svg :class="bookmarked && 'fill-amber-500 bookmark-btn bookmarked'" class="w-5 h-5 transition-all" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                <span class="text-sm font-medium" x-text="bookmarked ? 'Tersimpan' : 'Simpan'"></span>
            </button>

            <div class="w-px h-6 bg-surface-200 dark:bg-surface-700"></div>

            {{-- Share --}}
            <button @click="navigator.share ? navigator.share({title: '{{ $book->title }}', url: window.location.href}) : navigator.clipboard.writeText(window.location.href).then(() => $store.notification.notify('Link disalin!'))"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-surface-400 dark:text-surface-500 hover:bg-surface-100 dark:hover:bg-surface-800 transition-all duration-200">
                <i data-lucide="share-2" class="w-5 h-5"></i>
                <span class="text-sm font-medium">Bagikan</span>
            </button>

            <div class="w-px h-6 bg-surface-200 dark:bg-surface-700"></div>

            {{-- Comments Shortcut --}}
            <button @click="document.querySelector('#comments-section')?.scrollIntoView({behavior:'smooth'})"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-surface-400 dark:text-surface-500 hover:bg-surface-100 dark:hover:bg-surface-800 transition-all duration-200">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                <span class="text-sm font-medium hidden sm:inline">Komentar</span>
            </button>
        </div>
    </div>

    {{-- Auth Modal for Guests --}}
    @guest
        @include('components.auth-modal')
    @endguest

    {{-- Notification Toast --}}
    <div x-show="$store.notification.show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-4 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-4 opacity-0"
         class="fixed bottom-20 right-6 z-[60] max-w-sm"
         style="display:none;">
        <div class="bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-float flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
            <span class="text-sm font-medium" x-text="$store.notification.message"></span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function readerApp() {
    return {
        scrollProgress: 0,
        drawerOpen: false,
        showAuthModal: false,

        init() {
            // Track scroll progress
            window.addEventListener('scroll', () => {
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                this.scrollProgress = docHeight > 0 ? (window.scrollY / docHeight) * 100 : 0;
            });

            @auth
            // Auto-save reading progress on chapter load
            this.saveProgress();
            @endauth

            // Re-init Lucide icons
            this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });
        },

        @auth
        saveProgress() {
            const chapterId = {{ $chapter ? $chapter->id : 'null' }};
            if (!chapterId) return;

            fetch('{{ route("reader.progress") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    book_id: {{ $book->id }},
                    chapter_id: chapterId,
                    last_page: 0,
                }),
            }).catch(e => console.error('Progress save failed:', e));
        },
        @endauth
    };
}
</script>
@endpush
