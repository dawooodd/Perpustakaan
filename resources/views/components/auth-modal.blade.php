{{-- Auth Modal Component --}}
{{-- Usage: Include in page, control with Alpine x-data authModal variable --}}
<div x-show="showAuthModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="auth-modal-overlay"
     style="display:none;"
     @click.self="showAuthModal = false">

    <div x-show="showAuthModal"
         x-transition:enter="transition ease-out duration-300 delay-75"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="auth-modal-content">

        {{-- Icon --}}
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-600 to-primary-400 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-primary-600/25">
            <i data-lucide="lock-keyhole" class="w-7 h-7 text-white"></i>
        </div>

        {{-- Title --}}
        <h3 class="text-xl font-display font-bold text-surface-900 dark:text-white mb-2">
            Login Diperlukan
        </h3>

        {{-- Message --}}
        <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed mb-6">
            Masuk ke akunmu untuk menyimpan progress baca, bookmark, dan berinteraksi dengan pembaca lainnya!
        </p>

        {{-- Actions --}}
        <div class="flex flex-col gap-3">
            <a href="{{ route('login') }}"
               class="btn-primary w-full justify-center py-3">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="btn-secondary w-full justify-center py-3">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Daftar Akun Baru
            </a>
        </div>

        {{-- Dismiss --}}
        <button @click="showAuthModal = false"
                class="mt-4 text-xs text-surface-400 dark:text-surface-500 hover:text-surface-600 dark:hover:text-surface-300 transition-colors">
            Nanti saja
        </button>
    </div>
</div>
