@extends('layouts.app')

@section('title', 'Kelola Penerbit')

@section('content')
<div x-data="{ showModal: false, editMode: false, editId: null, formName: '', showDeleteModal: false, deleteId: null }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Daftar Penerbit</h1>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-0.5">Kelola data penerbit buku</p>
        </div>
        <button @click="showModal = true; editMode = false; formName = ''" class="btn-primary">
            <i data-lucide="building-2" class="w-4 h-4"></i> Tambah Penerbit
        </button>
    </div>

    <!-- Search -->
    <div class="card p-4 mb-6">
        <div class="relative max-w-md">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
            <input type="text" placeholder="Cari nama penerbit..." class="form-input pl-10 py-2.5">
        </div>
    </div>

    <!-- Publisher Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5">
        @php
            $samplePublishers = [
                ['id' => 1, 'name' => 'O\'Reilly Media', 'books' => 45, 'icon' => 'from-red-500 to-rose-600'],
                ['id' => 2, 'name' => 'Addison-Wesley', 'books' => 32, 'icon' => 'from-blue-500 to-indigo-600'],
                ['id' => 3, 'name' => 'Pearson Education', 'books' => 28, 'icon' => 'from-amber-500 to-yellow-600'],
                ['id' => 4, 'name' => 'Gramedia Pustaka', 'books' => 24, 'icon' => 'from-emerald-500 to-green-600'],
                ['id' => 5, 'name' => 'Erlangga', 'books' => 19, 'icon' => 'from-violet-500 to-purple-600'],
                ['id' => 6, 'name' => 'Manning Publications', 'books' => 15, 'icon' => 'from-teal-500 to-cyan-600'],
            ];
        @endphp
        @foreach($samplePublishers as $pub)
        <div class="card-hover p-5 group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $pub['icon'] }} flex items-center justify-center shadow-lg shrink-0">
                    <i data-lucide="building-2" class="w-6 h-6 text-white"></i>
                </div>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button @click="showModal = true; editMode = true; editId = {{ $pub['id'] }}; formName = '{{ $pub['name'] }}'" class="btn-icon text-surface-400 hover:text-primary-600">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <button @click="deleteId = {{ $pub['id'] }}; showDeleteModal = true" class="btn-icon text-surface-400 hover:text-rose-600">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <h3 class="font-semibold text-surface-800 dark:text-surface-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $pub['name'] }}</h3>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1 line-clamp-2">Penerbit buku-buku berkualitas di bidang teknologi dan pendidikan.</p>
            <div class="flex items-center gap-2 mt-4">
                <span class="badge-level"><i data-lucide="book-copy" class="w-3 h-3"></i> {{ $pub['books'] }} Buku</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-surface-400 dark:text-surface-500">Menampilkan <span class="font-medium">6</span> penerbit</p>
        <div class="pagination">
            <button class="page-btn"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
            <button class="page-btn-active">1</button>
            <button class="page-btn"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div x-show="showModal" class="modal-backdrop" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="modal-content max-w-md" @click.away="showModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white" x-text="editMode ? 'Edit Penerbit' : 'Tambah Penerbit'"></h3>
                    <button @click="showModal = false" class="btn-icon text-surface-400 hover:text-surface-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form :action="editMode ? '/publishers/' + editId : '/publishers'" method="POST">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="mb-5">
                        <label class="form-label">Nama Penerbit <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="formName" class="form-input" placeholder="Masukkan nama penerbit..." required>
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
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Hapus Penerbit?</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-6">Data penerbit akan dihapus secara permanen.</p>
                <div class="flex items-center justify-center gap-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">Batal</button>
                    <form :action="'/publishers/' + deleteId" method="POST" class="inline">
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
