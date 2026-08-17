@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header/Cover -->
    <div class="relative rounded-2xl bg-gradient-to-r from-primary-600 to-indigo-700 h-48 sm:h-56 shadow-lg mb-16">
        <!-- Floating Avatar -->
        <div class="absolute -bottom-12 left-6 sm:left-10 flex items-end gap-5">
            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-4 border-white dark:border-surface-900 bg-surface-100 dark:bg-surface-800 flex items-center justify-center text-4xl sm:text-5xl font-bold text-primary-600 dark:text-primary-400 shadow-lg">
                AD
            </div>
            <div class="pb-2 hidden sm:block">
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Admin Utama</h1>
                <p class="text-surface-500 dark:text-surface-400 text-sm mt-0.5">Administrator Sistem</p>
            </div>
        </div>
        <!-- Quick Action -->
        <div class="absolute top-4 right-4">
            <button class="btn-secondary bg-white/20 hover:bg-white/30 border-none text-white backdrop-blur-md">
                <i data-lucide="camera" class="w-4 h-4"></i> <span class="hidden sm:inline">Ubah Foto</span>
            </button>
        </div>
    </div>

    <!-- Mobile Title (Visible only on small screens) -->
    <div class="px-6 mb-8 sm:hidden">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Admin Utama</h1>
        <p class="text-surface-500 dark:text-surface-400 text-sm mt-0.5">Administrator Sistem</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="font-semibold text-surface-900 dark:text-white mb-4">Informasi Akun</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-surface-400 dark:text-surface-500 text-xs mb-1">Email</p>
                        <p class="font-medium text-surface-800 dark:text-surface-200">admin@perpustakaan.com</p>
                    </div>
                    <div>
                        <p class="text-surface-400 dark:text-surface-500 text-xs mb-1">Telepon</p>
                        <p class="font-medium text-surface-800 dark:text-surface-200">+62 812 3456 7890</p>
                    </div>
                    <div>
                        <p class="text-surface-400 dark:text-surface-500 text-xs mb-1">Status</p>
                        <span class="badge-available"><i data-lucide="check-circle" class="w-3 h-3"></i> Aktif</span>
                    </div>
                    <div>
                        <p class="text-surface-400 dark:text-surface-500 text-xs mb-1">Bergabung Sejak</p>
                        <p class="font-medium text-surface-800 dark:text-surface-200">12 Jan 2024</p>
                    </div>
                </div>
            </div>

            <!-- Security Stats -->
            <div class="card p-6 bg-gradient-to-br from-surface-50 to-surface-100 dark:from-surface-800 dark:to-surface-800/80">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-surface-900 dark:text-white text-sm">Keamanan Akun</h4>
                        <p class="text-xs text-surface-500">Terlindungi</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-surface-600 dark:text-surface-400">Autentikasi 2 Faktor</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-surface-600 dark:text-surface-400">Login Terakhir</span>
                        <span class="text-surface-800 dark:text-surface-200 font-medium">Hari ini, 08:30</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Settings -->
            <div class="card p-6 sm:p-8">
                <h3 class="font-semibold text-surface-900 dark:text-white text-lg mb-6">Pengaturan Profil</h3>
                
                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" value="Admin Utama">
                        </div>
                        <div>
                            <label class="form-label">Username</label>
                            <input type="text" class="form-input" value="admin">
                        </div>
                    </div>
                    
                    <div>
                        <label class="form-label">Alamat Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                            <input type="email" class="form-input pl-10" value="admin@perpustakaan.com">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Nomor Telepon</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                            <input type="text" class="form-input pl-10" value="+62 812 3456 7890">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-primary">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Settings -->
            <div class="card p-6 sm:p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="font-semibold text-surface-900 dark:text-white text-lg">Ubah Password</h3>
                        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Pastikan akun Anda menggunakan password yang kuat.</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center shrink-0">
                        <i data-lucide="key" class="w-5 h-5 text-surface-500 dark:text-surface-400"></i>
                    </div>
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-input" placeholder="••••••••">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-input" placeholder="Minimal 8 karakter">
                        </div>
                        <div>
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-input" placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-secondary text-surface-900 dark:text-white hover:border-surface-300 dark:hover:border-surface-600">
                            <i data-lucide="lock" class="w-4 h-4"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
