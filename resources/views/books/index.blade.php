@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')
<div x-data="{ viewMode: 'table', search: '', showDeleteModal: false, deleteId: null }">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Daftar Buku</h1>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-0.5">Kelola seluruh koleksi buku perpustakaan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('books.create') }}" class="btn-primary">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Buku
            </a>
            <button class="btn-secondary btn-sm">
                <i data-lucide="download" class="w-4 h-4"></i> Export
            </button>
        </div>
    </div>

    <!-- Toolbar: Search + View Toggle + Filters -->
    <div class="card p-4 mb-6">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search -->
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                <input x-model="search" type="text" placeholder="Cari judul, ISBN, penulis..."
                       class="form-input pl-10 py-2.5">
            </div>
            <!-- Filters -->
            <select class="form-select py-2.5 w-full sm:w-40">
                <option value="">Semua Penulis</option>
            </select>
            <select class="form-select py-2.5 w-full sm:w-40">
                <option value="">Semua Penerbit</option>
            </select>
            <!-- View Toggle -->
            <div class="flex bg-surface-100 dark:bg-surface-700/50 rounded-xl p-1 shrink-0">
                <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-white dark:bg-surface-600 shadow-sm' : ''" class="p-2 rounded-lg transition-all duration-200">
                    <i data-lucide="list" class="w-4 h-4"></i>
                </button>
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white dark:bg-surface-600 shadow-sm' : ''" class="p-2 rounded-lg transition-all duration-200">
                    <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Table View -->
    <div x-show="viewMode === 'table'" x-transition>
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-12">#</th>
                            <th>Buku</th>
                            <th>ISBN</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $idx => $book)
                        <tr>
                            <td class="text-surface-400 text-sm">{{ $idx + 1 }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-14 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 shrink-0 flex items-center justify-center shadow-sm">
                                        <i data-lucide="book-open" class="w-4 h-4 text-white/60"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-surface-800 dark:text-surface-200 truncate">{{ $book->title }}</p>
                                        <p class="text-xs text-surface-400 dark:text-surface-500 truncate max-w-[200px]">{{ Str::limit($book->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-xs bg-surface-100 dark:bg-surface-700 px-2 py-0.5 rounded-md">{{ $book->isbn }}</code></td>
                            <td>
                                @if($book->author)
                                    <span class="badge-neutral">{{ $book->author->name }}</span>
                                @else
                                    <span class="text-surface-300 dark:text-surface-600">—</span>
                                @endif
                            </td>
                            <td>
                                @if($book->publisher)
                                    <span class="badge-neutral">{{ $book->publisher->name }}</span>
                                @else
                                    <span class="text-surface-300 dark:text-surface-600">—</span>
                                @endif
                            </td>
                            <td><span class="badge-available"><i data-lucide="check-circle" class="w-3 h-3"></i> Tersedia</span></td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn-icon text-surface-400 hover:text-primary-600">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button @click="deleteId = {{ $book->id }}; showDeleteModal = true" class="btn-icon text-surface-400 hover:text-rose-600">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <i data-lucide="book-x" class="w-12 h-12 mx-auto text-surface-300 dark:text-surface-600 mb-3"></i>
                                <p class="text-surface-400 dark:text-surface-500">Belum ada buku. <a href="{{ route('books.create') }}" class="text-primary-600 dark:text-primary-400 hover:underline">Tambah sekarang</a></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="p-4 border-t border-surface-100 dark:border-surface-700/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-sm text-surface-400 dark:text-surface-500">Menampilkan <span class="font-medium text-surface-600 dark:text-surface-300">{{ count($books) }}</span> buku</p>
                <div class="pagination">
                    <button class="page-btn"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
                    <button class="page-btn-active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid View -->
    <div x-show="viewMode === 'grid'" x-transition style="display:none;">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5">
            @forelse($books as $book)
            <div class="group cursor-pointer">
                <div class="relative aspect-[3/4] rounded-2xl bg-gradient-to-br from-primary-500 to-primary-800 shadow-card group-hover:shadow-card-hover group-hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                        <i data-lucide="book-open" class="w-8 h-8 text-white/30 mb-2"></i>
                        <h4 class="font-display font-bold text-white text-sm leading-tight">{{ $book->title }}</h4>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="badge-available text-[10px]">Tersedia</span>
                    </div>
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-2">
                        <a href="{{ route('books.edit', $book->id) }}" class="px-3 py-2 rounded-lg bg-white text-surface-800 text-xs font-semibold hover:bg-white/90 transition-colors flex items-center gap-1.5">
                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit
                        </a>
                        <button @click="deleteId = {{ $book->id }}; showDeleteModal = true" class="px-3 py-2 rounded-lg bg-rose-500 text-white text-xs font-semibold hover:bg-rose-600 transition-colors flex items-center gap-1.5">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="mt-3 px-1">
                    <h4 class="font-semibold text-sm text-surface-800 dark:text-surface-200 truncate">{{ $book->title }}</h4>
                    <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">{{ $book->author?->name ?? 'Tanpa Penulis' }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <i data-lucide="book-x" class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4"></i>
                <p class="text-surface-500 dark:text-surface-400 mb-4">Belum ada buku tersedia.</p>
                <a href="{{ route('books.create') }}" class="btn-primary">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Buku Pertama
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" class="modal-backdrop" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="modal-content max-w-md" @click.away="showDeleteModal = false">
            <div class="p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-triangle" class="w-7 h-7 text-rose-500"></i>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Hapus Buku?</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-6">Tindakan ini tidak bisa dibatalkan. Data buku akan dihapus secara permanen.</p>
                <div class="flex items-center justify-center gap-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">Batal</button>
                    <form :action="'/books/' + deleteId" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
