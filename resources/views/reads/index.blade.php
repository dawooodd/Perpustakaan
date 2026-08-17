@extends('layouts.app')

@section('title', 'Riwayat Baca')

@section('content')
<div x-data="{ activeTab: 'reading', scannerOpen: false }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Riwayat Baca / Peminjaman</h1>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-0.5">Kelola status baca dan peminjaman buku</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="scannerOpen = !scannerOpen" class="btn-secondary">
                <i data-lucide="scan-barcode" class="w-4 h-4"></i> Scan ISBN
            </button>
            <button class="btn-primary">
                <i data-lucide="plus" class="w-4 h-4"></i> Catat Peminjaman
            </button>
        </div>
    </div>

    <!-- Overdue Banner -->
    <div class="overdue-banner mb-6 animate-slide-up">
        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
            <i data-lucide="alert-triangle" class="w-5 h-5"></i>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-sm">3 buku melewati batas waktu!</p>
            <p class="text-white/70 text-xs mt-0.5">Segera proses pengembalian untuk menghindari denda.</p>
        </div>
        <button class="px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-sm font-medium transition-colors">
            Lihat Detail
        </button>
    </div>

    <!-- ISBN Scanner (collapsible) -->
    <div x-show="scannerOpen" x-transition class="card p-5 mb-6" style="display:none;">
        <div class="flex items-center gap-3 mb-3">
            <i data-lucide="scan-barcode" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
            <h3 class="font-semibold text-surface-800 dark:text-surface-200">Scanner ISBN</h3>
        </div>
        <div class="flex gap-3">
            <div class="relative flex-1">
                <i data-lucide="camera" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                <input type="text" placeholder="Masukkan atau scan kode ISBN buku..." class="form-input pl-10" autofocus>
            </div>
            <button class="btn-primary shrink-0">
                <i data-lucide="search" class="w-4 h-4"></i> Cari
            </button>
        </div>
        <p class="text-xs text-surface-400 dark:text-surface-500 mt-2">
            <i data-lucide="info" class="w-3 h-3 inline"></i>
            Arahkan barcode ke kamera atau ketik manual kode ISBN.
        </p>
    </div>

    <!-- Tabs -->
    <div class="flex items-center gap-1 bg-surface-100 dark:bg-surface-800 rounded-xl p-1 mb-6 w-fit">
        <button @click="activeTab = 'reading'" :class="activeTab === 'reading' ? 'tab-btn-active' : 'tab-btn'">
            <i data-lucide="book-open" class="w-4 h-4 inline -mt-0.5"></i>
            Sedang Dibaca
            <span class="ml-1 px-1.5 py-0.5 rounded-md text-[10px]" :class="activeTab === 'reading' ? 'bg-white/20' : 'bg-surface-200 dark:bg-surface-600'">12</span>
        </button>
        <button @click="activeTab = 'completed'" :class="activeTab === 'completed' ? 'tab-btn-active' : 'tab-btn'">
            <i data-lucide="check-circle" class="w-4 h-4 inline -mt-0.5"></i>
            Selesai
            <span class="ml-1 px-1.5 py-0.5 rounded-md text-[10px]" :class="activeTab === 'completed' ? 'bg-white/20' : 'bg-surface-200 dark:bg-surface-600'">85</span>
        </button>
        <button @click="activeTab = 'overdue'" :class="activeTab === 'overdue' ? 'tab-btn-active' : 'tab-btn'">
            <i data-lucide="alert-triangle" class="w-4 h-4 inline -mt-0.5"></i>
            Terlambat
            <span class="ml-1 px-1.5 py-0.5 rounded-md text-[10px]" :class="activeTab === 'overdue' ? 'bg-white/20' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400'">3</span>
        </button>
    </div>

    <!-- Filters Row -->
    <div class="card p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                <input type="text" placeholder="Cari pengguna, buku..." class="form-input pl-10 py-2.5">
            </div>
            <input type="date" class="form-input py-2.5 w-full sm:w-44">
            <input type="date" class="form-input py-2.5 w-full sm:w-44">
        </div>
    </div>

    @php
        $readingData = [
            ['user' => 'Rizqi Maulana', 'initials' => 'RM', 'book' => 'Clean Code', 'isbn' => '978-0-13-235088-4', 'borrow' => '10 Agu 2026', 'due' => '24 Agu 2026', 'color' => 'from-sky-500 to-blue-600', 'avatar_color' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400'],
            ['user' => 'Dewi Lestari', 'initials' => 'DL', 'book' => 'Refactoring', 'isbn' => '978-0-20-148567-7', 'borrow' => '12 Agu 2026', 'due' => '26 Agu 2026', 'color' => 'from-violet-500 to-purple-600', 'avatar_color' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400'],
            ['user' => 'Siti Nurhaliza', 'initials' => 'SN', 'book' => 'Design Patterns', 'isbn' => '978-0-20-163361-0', 'borrow' => '14 Agu 2026', 'due' => '28 Agu 2026', 'color' => 'from-emerald-500 to-teal-600', 'avatar_color' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],
        ];
        $completedData = [
            ['user' => 'Ahmad Fauzi', 'initials' => 'AF', 'book' => 'Head First Java', 'isbn' => '978-0-59-600920-5', 'borrow' => '01 Agu 2026', 'returned' => '10 Agu 2026', 'color' => 'from-rose-500 to-pink-600', 'avatar_color' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400'],
            ['user' => 'Budi Santoso', 'initials' => 'BS', 'book' => 'Code Complete', 'isbn' => '978-0-73-561967-8', 'borrow' => '28 Jul 2026', 'returned' => '08 Agu 2026', 'color' => 'from-indigo-500 to-blue-700', 'avatar_color' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400'],
        ];
        $overdueData = [
            ['user' => 'Andi Prasetyo', 'initials' => 'AP', 'book' => 'The Pragmatic Programmer', 'isbn' => '978-0-13-595705-9', 'borrow' => '20 Jul 2026', 'due' => '03 Agu 2026', 'days_late' => 15, 'color' => 'from-amber-500 to-orange-600', 'avatar_color' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'],
            ['user' => 'Fitri Handayani', 'initials' => 'FH', 'book' => 'Mythical Man-Month', 'isbn' => '978-0-20-183595-3', 'borrow' => '25 Jul 2026', 'due' => '08 Agu 2026', 'days_late' => 10, 'color' => 'from-slate-500 to-gray-700', 'avatar_color' => 'bg-slate-100 dark:bg-slate-900/30 text-slate-600 dark:text-slate-400'],
            ['user' => 'Yusuf Hidayat', 'initials' => 'YH', 'book' => 'Intro to Algorithms', 'isbn' => '978-0-26-204630-5', 'borrow' => '01 Agu 2026', 'due' => '15 Agu 2026', 'days_late' => 3, 'color' => 'from-red-500 to-rose-700', 'avatar_color' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'],
        ];
    @endphp

    <!-- Tab: Sedang Dibaca -->
    <div x-show="activeTab === 'reading'" x-transition>
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Buku</th>
                            <th>ISBN</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Waktu</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readingData as $row)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm {{ $row['avatar_color'] }}">{{ $row['initials'] }}</div>
                                    <span class="font-medium">{{ $row['user'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-11 rounded-lg bg-gradient-to-br {{ $row['color'] }} shrink-0 flex items-center justify-center shadow-sm">
                                        <i data-lucide="book-open" class="w-3 h-3 text-white/60"></i>
                                    </div>
                                    <span class="font-medium">{{ $row['book'] }}</span>
                                </div>
                            </td>
                            <td><code class="text-xs bg-surface-100 dark:bg-surface-700 px-2 py-0.5 rounded-md">{{ $row['isbn'] }}</code></td>
                            <td class="text-sm text-surface-500">{{ $row['borrow'] }}</td>
                            <td class="text-sm text-surface-500">{{ $row['due'] }}</td>
                            <td><span class="badge-borrowed"><i data-lucide="book-open" class="w-3 h-3"></i> Sedang Dibaca</span></td>
                            <td class="text-right">
                                <button class="btn-sm btn-secondary">
                                    <i data-lucide="undo-2" class="w-3.5 h-3.5"></i> Kembalikan
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab: Selesai -->
    <div x-show="activeTab === 'completed'" x-transition style="display:none;">
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Buku</th>
                            <th>ISBN</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedData as $row)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm {{ $row['avatar_color'] }}">{{ $row['initials'] }}</div>
                                    <span class="font-medium">{{ $row['user'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-11 rounded-lg bg-gradient-to-br {{ $row['color'] }} shrink-0 flex items-center justify-center shadow-sm">
                                        <i data-lucide="book-open" class="w-3 h-3 text-white/60"></i>
                                    </div>
                                    <span class="font-medium">{{ $row['book'] }}</span>
                                </div>
                            </td>
                            <td><code class="text-xs bg-surface-100 dark:bg-surface-700 px-2 py-0.5 rounded-md">{{ $row['isbn'] }}</code></td>
                            <td class="text-sm text-surface-500">{{ $row['borrow'] }}</td>
                            <td class="text-sm text-surface-500">{{ $row['returned'] }}</td>
                            <td><span class="badge-available"><i data-lucide="check-circle" class="w-3 h-3"></i> Selesai</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab: Terlambat -->
    <div x-show="activeTab === 'overdue'" x-transition style="display:none;">
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Buku</th>
                            <th>ISBN</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Waktu</th>
                            <th>Keterlambatan</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overdueData as $row)
                        <tr class="bg-rose-50/30 dark:bg-rose-900/5">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm {{ $row['avatar_color'] }}">{{ $row['initials'] }}</div>
                                    <span class="font-medium">{{ $row['user'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-11 rounded-lg bg-gradient-to-br {{ $row['color'] }} shrink-0 flex items-center justify-center shadow-sm">
                                        <i data-lucide="book-open" class="w-3 h-3 text-white/60"></i>
                                    </div>
                                    <span class="font-medium">{{ $row['book'] }}</span>
                                </div>
                            </td>
                            <td><code class="text-xs bg-surface-100 dark:bg-surface-700 px-2 py-0.5 rounded-md">{{ $row['isbn'] }}</code></td>
                            <td class="text-sm text-surface-500">{{ $row['borrow'] }}</td>
                            <td class="text-sm text-rose-500 font-medium">{{ $row['due'] }}</td>
                            <td>
                                <span class="badge-overdue">
                                    <i data-lucide="clock" class="w-3 h-3"></i> {{ $row['days_late'] }} hari terlambat
                                </span>
                            </td>
                            <td class="text-right">
                                <button class="btn-sm btn-danger">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> Proses
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-between">
        <p class="text-sm text-surface-400 dark:text-surface-500">Halaman 1 dari 5</p>
        <div class="pagination">
            <button class="page-btn"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
            <button class="page-btn-active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">...</button>
            <button class="page-btn">5</button>
            <button class="page-btn"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
        </div>
    </div>
</div>
@endsection
