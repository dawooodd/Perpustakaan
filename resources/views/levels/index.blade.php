@extends('layouts.app')

@section('title', 'Level / Kategori')

@section('content')
<div x-data="{ showModal: false, editMode: false, editId: null, formName: '', showDeleteModal: false, deleteId: null }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Level & Kategori</h1>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-0.5">Kelola tingkatan dan klasifikasi buku</p>
        </div>
        <button @click="showModal = true; editMode = false; formName = ''" class="btn-primary">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Level
        </button>
    </div>

    <!-- Level List -->
    <div class="card overflow-hidden">
        @php
            $sampleLevels = [
                ['id' => 1, 'name' => 'Pemula', 'books' => 45, 'icon' => 'sprout', 'color' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400'],
                ['id' => 2, 'name' => 'Menengah', 'books' => 78, 'icon' => 'flame', 'color' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400'],
                ['id' => 3, 'name' => 'Lanjut', 'books' => 56, 'icon' => 'rocket', 'color' => 'bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400'],
                ['id' => 4, 'name' => 'Ahli', 'books' => 23, 'icon' => 'crown', 'color' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400'],
                ['id' => 5, 'name' => 'Umum', 'books' => 120, 'icon' => 'globe', 'color' => 'bg-sky-50 dark:bg-sky-900/20 text-sky-600 dark:text-sky-400'],
            ];
        @endphp
        @foreach($sampleLevels as $idx => $level)
        <div class="flex items-center gap-4 px-6 py-4 group hover:bg-surface-50/50 dark:hover:bg-surface-700/20 transition-colors
                    {{ $idx > 0 ? 'border-t border-surface-100 dark:border-surface-700/50' : '' }}">
            <!-- Drag Handle -->
            <div class="text-surface-300 dark:text-surface-600 cursor-grab active:cursor-grabbing">
                <i data-lucide="grip-vertical" class="w-4 h-4"></i>
            </div>

            <!-- Icon -->
            <div class="w-10 h-10 rounded-xl {{ $level['color'] }} flex items-center justify-center shrink-0">
                <i data-lucide="{{ $level['icon'] }}" class="w-5 h-5"></i>
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-surface-800 dark:text-surface-200">{{ $level['name'] }}</h3>
                <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">Tingkat {{ strtolower($level['name']) }} untuk klasifikasi buku</p>
            </div>

            <!-- Book Count -->
            <span class="badge-neutral shrink-0">
                <i data-lucide="book-copy" class="w-3 h-3"></i> {{ $level['books'] }}
            </span>

            <!-- Actions -->
            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shrink-0">
                <button @click="showModal = true; editMode = true; editId = {{ $level['id'] }}; formName = '{{ $level['name'] }}'"
                        class="btn-icon text-surface-400 hover:text-primary-600">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </button>
                <button @click="deleteId = {{ $level['id'] }}; showDeleteModal = true"
                        class="btn-icon text-surface-400 hover:text-rose-600">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add/Edit Modal -->
    <div x-show="showModal" class="modal-backdrop" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="modal-content max-w-md" @click.away="showModal = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white" x-text="editMode ? 'Edit Level' : 'Tambah Level'"></h3>
                    <button @click="showModal = false" class="btn-icon text-surface-400 hover:text-surface-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form :action="editMode ? '/levels/' + editId : '/levels'" method="POST">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="mb-5">
                        <label class="form-label">Nama Level <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="formName" class="form-input" placeholder="Contoh: Pemula, Menengah, Lanjut..." required>
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
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Hapus Level?</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-6">Data level akan dihapus secara permanen.</p>
                <div class="flex items-center justify-center gap-3">
                    <button @click="showDeleteModal = false" class="btn-secondary">Batal</button>
                    <form :action="'/levels/' + deleteId" method="POST" class="inline">
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
