import Alpine from 'alpinejs';

// --- Alpine Global Stores ---

// Theme Store (dark/light mode)
Alpine.store('theme', {
  dark: localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
  toggle() {
    this.dark = !this.dark;
    localStorage.setItem('theme', this.dark ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', this.dark);
  },
  init() {
    document.documentElement.classList.toggle('dark', this.dark);
  },
});

// Sidebar Store
Alpine.store('sidebar', {
  open: window.innerWidth >= 1024,
  mobileOpen: false,
  toggle() {
    if (window.innerWidth < 1024) {
      this.mobileOpen = !this.mobileOpen;
    } else {
      this.open = !this.open;
    }
  },
  close() {
    this.mobileOpen = false;
  },
});

// Notification Store
Alpine.store('notification', {
  show: false,
  message: '',
  type: 'success',
  notify(message, type = 'success') {
    this.message = message;
    this.type = type;
    this.show = true;
    setTimeout(() => { this.show = false; }, 3000);
  },
});

// Reader Settings Store
Alpine.store('readerSettings', {
  fontSize: parseInt(localStorage.getItem('readerFontSize')) || 18,
  fontFamily: localStorage.getItem('readerFontFamily') || 'serif',
  lineHeight: parseFloat(localStorage.getItem('readerLineHeight')) || 1.8,
  theme: localStorage.getItem('readerTheme') || 'auto', // 'auto' | 'light' | 'dark' | 'sepia'

  increaseFontSize() {
    if (this.fontSize < 32) {
      this.fontSize += 2;
      localStorage.setItem('readerFontSize', this.fontSize);
    }
  },
  decreaseFontSize() {
    if (this.fontSize > 12) {
      this.fontSize -= 2;
      localStorage.setItem('readerFontSize', this.fontSize);
    }
  },
  setFontFamily(family) {
    this.fontFamily = family;
    localStorage.setItem('readerFontFamily', family);
  },
  setLineHeight(height) {
    this.lineHeight = height;
    localStorage.setItem('readerLineHeight', height);
  },
  setTheme(theme) {
    this.theme = theme;
    localStorage.setItem('readerTheme', theme);
  },
});

// Start Alpine
Alpine.start();

// --- Lucide Icons Init ---
document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide) {
    window.lucide.createIcons();
  }
});

// Re-initialize Lucide after Alpine updates the DOM
document.addEventListener('alpine:initialized', () => {
  if (window.lucide) {
    window.lucide.createIcons();
  }
});
