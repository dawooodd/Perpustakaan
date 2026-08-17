@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- Page Header -->
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('books.index') }}" class="btn-icon text-surface-400 hover:text-surface-600 dark:hover:text-surface-300">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Edit Buku</h1>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-0.5">Perbarui informasi buku <span class="font-medium text-surface-700 dark:text-surface-300">{{ $book->title }}</span></p>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="card p-6 lg:p-8 space-y-6"
          x-data="{
              coverPreview: null,
              dragOver: false,
              handleFile(e) {
                  const file = e.target.files[0] || (e.dataTransfer && e.dataTransfer.files[0]);
                  if (file && file.type.startsWith('image/')) {
                      const reader = new FileReader();
                      reader.onload = (ev) => { this.coverPreview = ev.target.result; };
                      reader.readAsDataURL(file);
                  }
              }
          }">
        @csrf
        @method('PUT')

        <!-- Cover Upload -->
        <div>
            <label class="form-label">Sampul Buku</label>
            <div class="flex flex-col sm:flex-row gap-4 items-start">
                <div @dragover.prevent="dragOver = true"
                     @dragleave.prevent="dragOver = false"
                     @drop.prevent="dragOver = false; handleFile($event)"
                     :class="dragOver ? 'upload-zone-active' : ''"
                     class="upload-zone flex-1 cursor-pointer relative">
                    <input type="file" name="cover_image" accept="image/*"
                           @change="handleFile($event)"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <i data-lucide="cloud-upload" class="w-10 h-10 text-surface-300 dark:text-surface-600 mx-auto mb-3"></i>
                    <p class="text-sm font-medium text-surface-600 dark:text-surface-400">Ganti sampul buku</p>
                    <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Drag & drop atau klik (PNG, JPG, max 2MB)</p>
                </div>
                <div x-show="coverPreview" class="shrink-0" style="display:none;">
                    <div class="w-28 h-40 rounded-xl overflow-hidden shadow-card-hover border-2 border-primary-200 dark:border-primary-800">
                        <img :src="coverPreview" class="w-full h-full object-cover" alt="Preview">
                    </div>
                </div>
            </div>
        </div>

        <div class="h-px bg-surface-100 dark:bg-surface-700/50"></div>

        <!-- Title & ISBN -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="title" class="form-label">Judul Buku <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                       class="form-input @error('title') !border-rose-400 !ring-rose-400/20 @enderror">
                @error('title')
                    <p class="form-error"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i> {{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="isbn" class="form-label">ISBN <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <i data-lucide="scan-barcode" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                           class="form-input pl-10 @error('isbn') !border-rose-400 !ring-rose-400/20 @enderror">
                </div>
                @error('isbn')
                    <p class="form-error"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i> {{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="form-label">Deskripsi <span class="text-rose-500">*</span></label>
            <textarea name="description" id="description" rows="4"
                      class="form-textarea @error('description') !border-rose-400 !ring-rose-400/20 @enderror">{{ old('description', $book->description) }}</textarea>
            @error('description')
                <p class="form-error"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Author & Publisher -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div x-data="{
                open: false, search: '',
                selected: '{{ old('author_id', $book->author_id) }}',
                selectedName: '{{ $book->author?->name ?? '' }}'
            }">
                <label class="form-label">Penulis <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="form-input text-left flex items-center justify-between @error('author_id') !border-rose-400 @enderror">
                        <span :class="selected ? 'text-surface-800 dark:text-surface-200' : 'text-surface-400'" x-text="selectedName || 'Pilih penulis...'"></span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-surface-400 shrink-0"></i>
                    </button>
                    <input type="hidden" name="author_id" :value="selected">
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 rounded-xl shadow-float z-20 max-h-48 overflow-y-auto"
                         style="display:none;">
                        <div class="p-2 border-b border-surface-100 dark:border-surface-700">
                            <input type="text" x-model="search" placeholder="Cari penulis..." class="w-full px-3 py-2 bg-surface-50 dark:bg-surface-700/50 rounded-lg text-sm border-0 focus:outline-none focus:ring-1 focus:ring-primary-500/30">
                        </div>
                        <div class="p-1">
                            @foreach($authors as $author)
                            <button type="button"
                                    x-show="!search || '{{ strtolower($author->name) }}'.includes(search.toLowerCase())"
                                    @click="selected = '{{ $author->id }}'; selectedName = '{{ $author->name }}'; open = false; search = ''"
                                    class="w-full text-left px-3 py-2 rounded-lg text-sm hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors flex items-center gap-2">
                                <div class="avatar avatar-sm text-[10px]">{{ substr($author->name, 0, 2) }}</div>
                                {{ $author->name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @error('author_id')
                    <p class="form-error"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i> {{ $message }}</p>
                @enderror
            </div>

            <div x-data="{
                open: false, search: '',
                selected: '{{ old('publisher_id', $book->publisher_id) }}',
                selectedName: '{{ $book->publisher?->name ?? '' }}'
            }">
                <label class="form-label">Penerbit <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="form-input text-left flex items-center justify-between @error('publisher_id') !border-rose-400 @enderror">
                        <span :class="selected ? 'text-surface-800 dark:text-surface-200' : 'text-surface-400'" x-text="selectedName || 'Pilih penerbit...'"></span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-surface-400 shrink-0"></i>
                    </button>
                    <input type="hidden" name="publisher_id" :value="selected">
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 rounded-xl shadow-float z-20 max-h-48 overflow-y-auto"
                         style="display:none;">
                        <div class="p-2 border-b border-surface-100 dark:border-surface-700">
                            <input type="text" x-model="search" placeholder="Cari penerbit..." class="w-full px-3 py-2 bg-surface-50 dark:bg-surface-700/50 rounded-lg text-sm border-0 focus:outline-none focus:ring-1 focus:ring-primary-500/30">
                        </div>
                        <div class="p-1">
                            @foreach($publishers as $publisher)
                            <button type="button"
                                    x-show="!search || '{{ strtolower($publisher->name) }}'.includes(search.toLowerCase())"
                                    @click="selected = '{{ $publisher->id }}'; selectedName = '{{ $publisher->name }}'; open = false; search = ''"
                                    class="w-full text-left px-3 py-2 rounded-lg text-sm hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
                                    <i data-lucide="building-2" class="w-3 h-3 text-amber-600 dark:text-amber-400"></i>
                                </div>
                                {{ $publisher->name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @error('publisher_id')
                    <p class="form-error"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i> {{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- E-Book -->
        <div>
            <label for="ebook" class="form-label">File E-Book <span class="text-surface-400">(opsional)</span></label>
            @if($book->ebook)
                <div class="flex items-center gap-2 mb-2 text-sm text-surface-500 dark:text-surface-400">
                    <i data-lucide="file-text" class="w-4 h-4 text-primary-500"></i>
                    <span>File saat ini: {{ basename($book->ebook) }}</span>
                </div>
            @endif
            <input type="file" name="ebook" id="ebook" accept=".pdf,.doc,.docx"
                   class="form-input file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/20 file:text-primary-700 dark:file:text-primary-400 hover:file:bg-primary-100">
        </div>

        <div class="h-px bg-surface-100 dark:bg-surface-700/50"></div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('books.index') }}" class="btn-secondary">
                <i data-lucide="x" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="w-4 h-4"></i> Perbarui Buku
            </button>
        </div>
    </form>
</div>
@endsection
