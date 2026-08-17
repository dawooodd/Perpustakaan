@extends('layouts.app')

@section('title', 'Dashboard')
@section('meta_description', 'Panel kontrol admin perpustakaan digital')

@section('content')

<!-- Welcome Header -->
<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">Selamat Datang, Admin! 👋</h1>
    <p class="text-surface-500 dark:text-surface-400 mt-1">Berikut ringkasan perpustakaan hari ini.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 mb-8">
    <!-- Total Buku -->
    <div class="stat-card group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                <i data-lucide="book-copy" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                <i data-lucide="trending-up" class="w-3 h-3"></i> +12%
            </span>
        </div>
        <div class="text-2xl font-display font-bold text-surface-900 dark:text-white"
             x-data="{ count: 0 }" x-init="let i = setInterval(() => { if(count < 2450) count += 49; else { count = 2450; clearInterval(i); } }, 20)">
            <span x-text="count.toLocaleString()">0</span>
        </div>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Total Buku</p>
        <!-- Mini Sparkline -->
        <div class="flex items-end gap-0.5 mt-3 h-6">
            <div class="flex-1 bg-primary-100 dark:bg-primary-800/40 rounded-sm" style="height:40%"></div>
            <div class="flex-1 bg-primary-100 dark:bg-primary-800/40 rounded-sm" style="height:55%"></div>
            <div class="flex-1 bg-primary-100 dark:bg-primary-800/40 rounded-sm" style="height:45%"></div>
            <div class="flex-1 bg-primary-100 dark:bg-primary-800/40 rounded-sm" style="height:70%"></div>
            <div class="flex-1 bg-primary-100 dark:bg-primary-800/40 rounded-sm" style="height:60%"></div>
            <div class="flex-1 bg-primary-100 dark:bg-primary-800/40 rounded-sm" style="height:80%"></div>
            <div class="flex-1 bg-primary-500 rounded-sm" style="height:100%"></div>
        </div>
    </div>

    <!-- Total Penulis -->
    <div class="stat-card group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                <i data-lucide="pen-tool" class="w-5 h-5 text-violet-600 dark:text-violet-400"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                <i data-lucide="trending-up" class="w-3 h-3"></i> +5%
            </span>
        </div>
        <div class="text-2xl font-display font-bold text-surface-900 dark:text-white"
             x-data="{ count: 0 }" x-init="let i = setInterval(() => { if(count < 186) count += 3; else { count = 186; clearInterval(i); } }, 25)">
            <span x-text="count">0</span>
        </div>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Total Penulis</p>
        <div class="flex items-end gap-0.5 mt-3 h-6">
            <div class="flex-1 bg-violet-100 dark:bg-violet-800/40 rounded-sm" style="height:50%"></div>
            <div class="flex-1 bg-violet-100 dark:bg-violet-800/40 rounded-sm" style="height:65%"></div>
            <div class="flex-1 bg-violet-100 dark:bg-violet-800/40 rounded-sm" style="height:55%"></div>
            <div class="flex-1 bg-violet-100 dark:bg-violet-800/40 rounded-sm" style="height:75%"></div>
            <div class="flex-1 bg-violet-100 dark:bg-violet-800/40 rounded-sm" style="height:85%"></div>
            <div class="flex-1 bg-violet-100 dark:bg-violet-800/40 rounded-sm" style="height:70%"></div>
            <div class="flex-1 bg-violet-500 rounded-sm" style="height:90%"></div>
        </div>
    </div>

    <!-- Total Penerbit -->
    <div class="stat-card group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                <i data-lucide="building-2" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                <i data-lucide="trending-up" class="w-3 h-3"></i> +3%
            </span>
        </div>
        <div class="text-2xl font-display font-bold text-surface-900 dark:text-white"
             x-data="{ count: 0 }" x-init="let i = setInterval(() => { if(count < 42) count += 1; else { count = 42; clearInterval(i); } }, 40)">
            <span x-text="count">0</span>
        </div>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Total Penerbit</p>
        <div class="flex items-end gap-0.5 mt-3 h-6">
            <div class="flex-1 bg-amber-100 dark:bg-amber-800/40 rounded-sm" style="height:60%"></div>
            <div class="flex-1 bg-amber-100 dark:bg-amber-800/40 rounded-sm" style="height:50%"></div>
            <div class="flex-1 bg-amber-100 dark:bg-amber-800/40 rounded-sm" style="height:70%"></div>
            <div class="flex-1 bg-amber-100 dark:bg-amber-800/40 rounded-sm" style="height:65%"></div>
            <div class="flex-1 bg-amber-100 dark:bg-amber-800/40 rounded-sm" style="height:80%"></div>
            <div class="flex-1 bg-amber-100 dark:bg-amber-800/40 rounded-sm" style="height:75%"></div>
            <div class="flex-1 bg-amber-500 rounded-sm" style="height:85%"></div>
        </div>
    </div>

    <!-- Sedang Dibaca -->
    <div class="stat-card group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                <i data-lucide="book-open-check" class="w-5 h-5 text-emerald-600 dark:text-emerald-400"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 dark:text-amber-400">
                <i data-lucide="minus" class="w-3 h-3"></i> -2%
            </span>
        </div>
        <div class="text-2xl font-display font-bold text-surface-900 dark:text-white"
             x-data="{ count: 0 }" x-init="let i = setInterval(() => { if(count < 87) count += 2; else { count = 87; clearInterval(i); } }, 30)">
            <span x-text="count">0</span>
        </div>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Sedang Dibaca</p>
        <div class="flex items-end gap-0.5 mt-3 h-6">
            <div class="flex-1 bg-emerald-100 dark:bg-emerald-800/40 rounded-sm" style="height:80%"></div>
            <div class="flex-1 bg-emerald-100 dark:bg-emerald-800/40 rounded-sm" style="height:70%"></div>
            <div class="flex-1 bg-emerald-100 dark:bg-emerald-800/40 rounded-sm" style="height:90%"></div>
            <div class="flex-1 bg-emerald-100 dark:bg-emerald-800/40 rounded-sm" style="height:60%"></div>
            <div class="flex-1 bg-emerald-100 dark:bg-emerald-800/40 rounded-sm" style="height:50%"></div>
            <div class="flex-1 bg-emerald-100 dark:bg-emerald-800/40 rounded-sm" style="height:65%"></div>
            <div class="flex-1 bg-emerald-500 rounded-sm" style="height:55%"></div>
        </div>
    </div>
</div>

<!-- Charts & Recent Logs Row -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-4 lg:gap-5 mb-8">

    <!-- Borrowing Trends Chart -->
    <div class="card p-6 lg:col-span-3">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-semibold text-surface-900 dark:text-white">Tren Peminjaman</h3>
                <p class="text-sm text-surface-400 dark:text-surface-500 mt-0.5">6 bulan terakhir</p>
            </div>
            <div x-data="{ period: 'bulan' }" class="flex bg-surface-100 dark:bg-surface-700/50 rounded-lg p-0.5">
                <button @click="period = 'minggu'" :class="period === 'minggu' ? 'bg-white dark:bg-surface-600 shadow-sm' : ''" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200">Minggu</button>
                <button @click="period = 'bulan'" :class="period === 'bulan' ? 'bg-white dark:bg-surface-600 shadow-sm' : ''" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200">Bulan</button>
                <button @click="period = 'tahun'" :class="period === 'tahun' ? 'bg-white dark:bg-surface-600 shadow-sm' : ''" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200">Tahun</button>
            </div>
        </div>
        <!-- CSS Chart Area -->
        <div class="relative h-56">
            <!-- Y-axis Labels -->
            <div class="absolute left-0 top-0 bottom-6 flex flex-col justify-between text-[10px] text-surface-400 dark:text-surface-500 w-8">
                <span>200</span><span>150</span><span>100</span><span>50</span><span>0</span>
            </div>
            <!-- Grid Lines -->
            <div class="ml-10 h-[calc(100%-24px)] relative">
                <div class="absolute inset-0 flex flex-col justify-between">
                    <div class="border-t border-surface-100 dark:border-surface-700/50"></div>
                    <div class="border-t border-surface-100 dark:border-surface-700/50"></div>
                    <div class="border-t border-surface-100 dark:border-surface-700/50"></div>
                    <div class="border-t border-surface-100 dark:border-surface-700/50"></div>
                    <div class="border-t border-surface-100 dark:border-surface-700/50"></div>
                </div>
                <!-- Bars -->
                <div class="absolute inset-0 flex items-end justify-between gap-2 px-2">
                    @php $months = [
                        ['label' => 'Mar', 'value' => 45, 'max' => 200],
                        ['label' => 'Apr', 'value' => 72, 'max' => 200],
                        ['label' => 'Mei', 'value' => 95, 'max' => 200],
                        ['label' => 'Jun', 'value' => 130, 'max' => 200],
                        ['label' => 'Jul', 'value' => 110, 'max' => 200],
                        ['label' => 'Agu', 'value' => 168, 'max' => 200],
                    ]; @endphp
                    @foreach($months as $m)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-primary-600 to-primary-400 transition-all duration-500 hover:from-primary-500 hover:to-primary-300 relative group cursor-pointer"
                             style="height: {{ ($m['value'] / $m['max']) * 100 }}%">
                            <!-- Tooltip -->
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-800 dark:bg-surface-700 text-white text-[10px] px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                {{ $m['value'] }} buku
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- X-axis Labels -->
                <div class="absolute -bottom-6 inset-x-0 flex justify-between px-2 text-[10px] text-surface-400 dark:text-surface-500">
                    @foreach($months as $m)
                    <span class="flex-1 text-center">{{ $m['label'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Top Books -->
    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-surface-900 dark:text-white">Buku Terpopuler</h3>
            <button class="text-xs text-primary-600 dark:text-primary-400 font-medium hover:underline">Lihat Semua</button>
        </div>
        <div class="space-y-4">
            @php $topBooks = [
                ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'reads' => 234, 'color' => 'from-sky-500 to-blue-700'],
                ['title' => 'The Pragmatic Programmer', 'author' => 'David Thomas', 'reads' => 198, 'color' => 'from-amber-500 to-orange-700'],
                ['title' => 'Design Patterns', 'author' => 'Gang of Four', 'reads' => 167, 'color' => 'from-emerald-500 to-green-700'],
                ['title' => 'Refactoring', 'author' => 'Martin Fowler', 'reads' => 145, 'color' => 'from-violet-500 to-purple-700'],
                ['title' => 'Domain-Driven Design', 'author' => 'Eric Evans', 'reads' => 112, 'color' => 'from-rose-500 to-pink-700'],
            ]; @endphp
            @foreach($topBooks as $idx => $tb)
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-surface-300 dark:text-surface-600 w-5 text-right">#{{ $idx + 1 }}</span>
                <div class="w-9 h-12 rounded-lg bg-gradient-to-br {{ $tb['color'] }} shrink-0 flex items-center justify-center shadow-sm">
                    <i data-lucide="book-open" class="w-3.5 h-3.5 text-white/60"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-surface-800 dark:text-surface-200 truncate">{{ $tb['title'] }}</p>
                    <p class="text-xs text-surface-400 dark:text-surface-500">{{ $tb['author'] }}</p>
                </div>
                <span class="text-xs font-semibold text-surface-500 dark:text-surface-400">{{ $tb['reads'] }} baca</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Reading Logs -->
<div class="card overflow-hidden">
    <div class="p-6 border-b border-surface-100 dark:border-surface-700/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h3 class="font-semibold text-surface-900 dark:text-white">Riwayat Baca Terkini</h3>
            <p class="text-sm text-surface-400 dark:text-surface-500 mt-0.5">Aktivitas peminjaman dan pengembalian buku</p>
        </div>
        <a href="{{ route('reads.index') }}" class="btn-secondary btn-sm">
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Lihat Semua
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Buku</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $logs = [
                    ['user' => 'Rizqi Maulana', 'initials' => 'RM', 'book' => 'Clean Code', 'date' => '18 Agu 2026, 09:30', 'status' => 'reading', 'color' => 'bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400'],
                    ['user' => 'Siti Nurhaliza', 'initials' => 'SN', 'book' => 'Design Patterns', 'date' => '17 Agu 2026, 14:15', 'status' => 'completed', 'color' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],
                    ['user' => 'Ahmad Fauzi', 'initials' => 'AF', 'book' => 'The Pragmatic Programmer', 'date' => '17 Agu 2026, 11:00', 'status' => 'overdue', 'color' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400'],
                    ['user' => 'Dewi Lestari', 'initials' => 'DL', 'book' => 'Refactoring', 'date' => '16 Agu 2026, 16:45', 'status' => 'reading', 'color' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400'],
                    ['user' => 'Budi Santoso', 'initials' => 'BS', 'book' => 'Head First Java', 'date' => '16 Agu 2026, 08:20', 'status' => 'completed', 'color' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400'],
                ]; @endphp
                @foreach($logs as $log)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar avatar-sm {{ $log['color'] }}">{{ $log['initials'] }}</div>
                            <span class="font-medium text-surface-800 dark:text-surface-200">{{ $log['user'] }}</span>
                        </div>
                    </td>
                    <td class="font-medium">{{ $log['book'] }}</td>
                    <td class="text-surface-400 dark:text-surface-500 text-sm">{{ $log['date'] }}</td>
                    <td>
                        @if($log['status'] === 'reading')
                            <span class="badge-borrowed"><i data-lucide="book-open" class="w-3 h-3"></i> Sedang Dibaca</span>
                        @elseif($log['status'] === 'completed')
                            <span class="badge-available"><i data-lucide="check-circle" class="w-3 h-3"></i> Selesai</span>
                        @else
                            <span class="badge-overdue"><i data-lucide="alert-triangle" class="w-3 h-3"></i> Terlambat</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($log['status'] === 'reading')
                            <button class="btn-sm btn-secondary">
                                <i data-lucide="undo-2" class="w-3.5 h-3.5"></i> Kembalikan
                            </button>
                        @elseif($log['status'] === 'overdue')
                            <button class="btn-sm btn-danger">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> Proses
                            </button>
                        @else
                            <span class="text-xs text-surface-300 dark:text-surface-600">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions Bar (floating) -->
<div class="fixed bottom-20 lg:bottom-6 left-1/2 -translate-x-1/2 z-30 hidden lg:block">
    <div class="bg-surface-900 dark:bg-surface-700 rounded-2xl shadow-float px-2 py-2 flex items-center gap-1">
        <a href="{{ route('books.create') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white/80 hover:bg-white/10 transition-all duration-200 text-sm font-medium">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Buku
        </a>
        <div class="w-px h-6 bg-white/10"></div>
        <a href="{{ route('authors.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white/80 hover:bg-white/10 transition-all duration-200 text-sm font-medium">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Penulis
        </a>
        <div class="w-px h-6 bg-white/10"></div>
        <button class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white/80 hover:bg-white/10 transition-all duration-200 text-sm font-medium">
            <i data-lucide="scan-barcode" class="w-4 h-4"></i> Scan ISBN
        </button>
    </div>
</div>

@endsection
