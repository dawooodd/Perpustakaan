@extends('layouts.public')

@section('title', 'Daftar Akun')

@section('content')
<section class="min-h-screen flex items-center justify-center py-20">
    <div class="w-full max-w-md px-4">
        <div class="card-glass p-8 lg:p-10 relative overflow-hidden">
            {{-- Decorative blurs --}}
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-primary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-violet-500/10 rounded-full blur-3xl"></div>

            <div class="relative">
                {{-- Logo --}}
                <div class="text-center mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-600 to-primary-400 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-600/25">
                        <i data-lucide="user-plus" class="w-7 h-7 text-white"></i>
                    </div>
                    <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">Buat Akun</h1>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Bergabung dan mulai membaca</p>
                </div>

                {{-- Error Messages --}}
                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/50">
                    @foreach($errors->all() as $error)
                    <p class="text-sm text-rose-600 dark:text-rose-400 flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        {{ $error }}
                    </p>
                    @endforeach
                </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="relative">
                            <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="form-input pl-11" placeholder="Nama lengkap">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="form-label">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="form-input pl-11" placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <div class="relative" x-data="{ showPass: false }">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                            <input id="password" :type="showPass ? 'text' : 'password'" name="password" required
                                   class="form-input pl-11 pr-11" placeholder="Min. 8 karakter">
                            <button type="button" @click="showPass = !showPass"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 btn-icon w-7 h-7 text-surface-400">
                                <i x-show="!showPass" data-lucide="eye" class="w-4 h-4"></i>
                                <i x-show="showPass" data-lucide="eye-off" class="w-4 h-4" style="display:none;"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400"></i>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="form-input pl-11" placeholder="Ketik ulang password">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center py-3">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Daftar
                    </button>
                </form>

                {{-- Login link --}}
                <p class="text-center text-sm text-surface-500 dark:text-surface-400 mt-6">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
