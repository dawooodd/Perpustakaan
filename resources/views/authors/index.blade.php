@extends('layouts.app')

@section('title', 'Kelola Penulis')

@section('content')
<div x-data="{ showModal: false, editMode: false, editId: null, formName: '', showDeleteModal: false, deleteId: null }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Daftar Penulis</h1>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-0.5">Kelola data penulis perpustakaan</p>
        </div>
        <button @click="showModal = true; editMode = false; formName = ''" class="btn-primary">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Penulis
        </button>
    </div>

    <!-- Search -->
    <div class="card p-4 mb-6">
        <div class="relative max-w-md">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
            <input type="text" placeholder="Cari nama penulis..." class="form-input pl-10 py-2.5">
        </div>
    </div>

    <!-- Author Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5">
        @php
            $sampleAuthors = [
                ['id' => 1, 'name' => 'Robert C. Martin', 'books' => 12, 'color' => 'from-sky-500 to-blue-600'],
                ['id' => 2, 'name' => 'Martin Fowler', 'books' => 8, 'color' => 'from-emerald-500 to-teal-600'],
                ['id' => 3, 'name' => 'Eric Evans', 'books' => 5, 'color' => 'from-violet-500 to-purple-600'],
                ['id' => 4, 'name' => 'Kent Beck', 'books' => 6, 'color' => 'from-amber-500 to-orange-600'],
                ['id' => 5, 'name' => 'Kathy Sierra', 'books' => 4, 'color' => 'from-rose-500 to-pink-600'],
                ['id' => 6, 'name' => 'Gang of Four', 'books' => 3, 'color' => 'from-indigo-500 to-blue-700'],
                ['id' => 7, 'name' => 'Steve McConnell', 'books' => 7, 'color' => 'from-teal-500 to-cyan-600'],
                ['id' => 8, 'name' => 'David Thomas', 'books' => 5, 'color' => 'from-fuchsia-500 to-purple-700'],
            ];
        @endphp
        @foreach($sampleAuthors as $author)
        <div class="card-hover p-5 group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $author['color'] }} flex items-center justify-center shadow-lg text-white font-bold text-lg shrink-0">
                    {{ strtoupper(substr($author['name'], 0, 1)) }}{{ strtoupper(substr(explode(' ', $author['name'])[count(explode(' ', $author['name']))-1], 0, 1)) }}
                </div>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button @click="showModal = true; editMode = true; editId = {{ $author['id'] }}; formName = '{{ $author['name'] }}'" class="btn-icon text-surface-400 hover:text-primary-600">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <button @click="deleteId = {{ $author['id'] }}; showDeleteModal = true" class="btn-icon text-surface-400 hover:text-rose-600">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <h3 class="font-semibold text-surface-800 dark:text-surface-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $author['name'] }}</h3>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1 line-clamp-2">Penulis buku-buku populer dalam bidang pengembangan perangkat lunak dan rekayasa perangkat lunak.</p>
            <div class="flex items-center gap-2 mt-4">
                <span class="badge-level"><i data-lucide="book-copy" class="w-3 h-3"></i> {{ $author['books'] }} Buku</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-surface-400 dark:text-surface-500">Menampilkan <span class="font-medium">8</span> penulis</p>
        <div class="pagination">
            <button class="page-btn"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
            <button class="page-btn-active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div x-show="showModal" class="modal-backdrop" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="modal-content max-w-md" @click.away="showModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white" x-text="editMode ? 'Edit Penulis' : 'Tambah Penulis'"></h3>
                    <button @click="showModal = false" class="btn-icon text-surface-400 hover:text-surface-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form :action="editMode ? '/authors/' + editId : '/authors'" method="POST">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="mb-5">
                        <label class="form-label">Nama Penulis <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="formName" class="form-input" placeholder="Masukkan nama penulis..." required>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" @click="showModal = false" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span x-text="editMode ? 'Perbarui' : 'Simpan'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" class="modal-backdrop" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="modal-content max-w-md" @click.away="showDeleteModal = false">
            <div class="p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-triangle" class="w-7 h-7 text-rose-500"></i>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Hapus Penulis?</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-6">Semua buku yang terkait dengan penulis ini akan kehilangan referensinya.</p>
                <div class="flex items-center justify-center gap-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">Batal</button>
                    <form :action="'/authors/' + deleteId" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger"><i data-lucide="trash-2" class="w-4 h-4"></i> Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
