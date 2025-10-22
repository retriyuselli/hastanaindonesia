<!-- Header -->
<header class="bg-white shadow-lg sticky top-0 z-40">
    <!-- Top Bar (Optional - for contact info) -->
    <div class="bg-hastana-blue text-white py-2 hidden md:block">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>info@hastanaindonesia.org</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        <span>+62 21 1234 5678</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-gray-200 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="hover:text-gray-200 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="hover:text-gray-200 transition-colors">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="hover:text-gray-200 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/hastana-logo.png') }}" alt="HASTANA Indonesia" class="h-12 w-auto">
                        <div class="hidden sm:block">
                            <h1 class="text-xl font-bold text-hastana-blue">HASTANA</h1>
                            <p class="text-xs text-gray-600">Wedding Organizer Indonesia</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <div class="relative group">
                        <button class="nav-link flex items-center">
                            <i class="fas fa-users mr-2"></i>Tentang
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil HASTANA</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visi & Misi</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Struktur Organisasi</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sejarah</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('members') }}" class="nav-link {{ request()->routeIs('members') ? 'active' : '' }}">
                        <i class="fas fa-id-card mr-2"></i>Anggota
                    </a>
                    <a href="{{ route('portfolio') }}" class="nav-link {{ request()->routeIs('portfolio*') ? 'active' : '' }}">
                        <i class="fas fa-camera mr-2"></i>Portfolio
                    </a>
                    <a href="{{ route('events') }}" class="nav-link {{ request()->routeIs('events') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>Event
                    </a>
                    <a href="{{ route('blog') }}" class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper mr-2"></i>Blog
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <i class="fas fa-envelope mr-2"></i>Kontak
                    </a>
                </div>

                <!-- CTA Button & Auth Links -->
                <div class="hidden lg:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-hastana-blue hover:text-hastana-red transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-hastana-red text-white px-6 py-2 rounded-full hover:bg-red-700 transition-colors">
                            <i class="fas fa-user-plus mr-1"></i>Daftar
                        </a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-hastana-blue">
                                <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" alt="Avatar" class="w-8 h-8 rounded-full">
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-edit mr-2"></i>Profil
                                    </a>
                                    <hr class="my-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                    
                    <a href="{{ route('join') }}" class="bg-hastana-blue text-white px-6 py-2 rounded-full hover:bg-blue-800 transition-colors">
                        <i class="fas fa-handshake mr-1"></i>Bergabung
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden text-gray-600 hover:text-hastana-blue transition-colors" data-mobile-menu-toggle>
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="lg:hidden hidden bg-white border-t border-gray-200" data-mobile-menu>
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home mr-3"></i>Beranda
                </a>
                
                <!-- Mobile Dropdown for Tentang -->
                <div class="space-y-2">
                    <button class="mobile-nav-link w-full text-left" onclick="toggleMobileDropdown('tentang')">
                        <i class="fas fa-users mr-3"></i>Tentang
                        <i class="fas fa-chevron-down float-right mt-1"></i>
                    </button>
                    <div id="tentang-dropdown" class="hidden pl-6 space-y-2">
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-hastana-blue">Profil HASTANA</a>
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-hastana-blue">Visi & Misi</a>
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-hastana-blue">Struktur Organisasi</a>
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-hastana-blue">Sejarah</a>
                    </div>
                </div>
                
                <a href="{{ route('members') }}" class="mobile-nav-link {{ request()->routeIs('members') ? 'active' : '' }}">
                    <i class="fas fa-id-card mr-3"></i>Anggota
                </a>
                <a href="{{ route('portfolio') }}" class="mobile-nav-link {{ request()->routeIs('portfolio*') ? 'active' : '' }}">
                    <i class="fas fa-camera mr-3"></i>Portfolio
                </a>
                <a href="{{ route('events') }}" class="mobile-nav-link {{ request()->routeIs('events') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt mr-3"></i>Event
                </a>
                <a href="{{ route('blog') }}" class="mobile-nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper mr-3"></i>Blog
                </a>
                <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <i class="fas fa-envelope mr-3"></i>Kontak
                </a>
                
                <hr class="my-4">
                
                @guest
                    <a href="{{ route('login') }}" class="mobile-nav-link">
                        <i class="fas fa-sign-in-alt mr-3"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="mobile-nav-link">
                        <i class="fas fa-user-plus mr-3"></i>Daftar
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="mobile-nav-link">
                        <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                        <i class="fas fa-user-edit mr-3"></i>Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left">
                            <i class="fas fa-sign-out-alt mr-3"></i>Keluar
                        </button>
                    </form>
                @endguest
                
                <a href="{{ route('join') }}" class="block w-full bg-hastana-blue text-white text-center py-3 rounded-full hover:bg-blue-800 transition-colors mt-4">
                    <i class="fas fa-handshake mr-2"></i>Bergabung
                </a>
            </div>
        </div>
    </nav>
</header>

<style>
/* Navigation Styles */
.nav-link {
    @apply text-gray-700 hover:text-hastana-blue font-medium transition-colors duration-200 flex items-center py-2;
}

.nav-link.active {
    @apply text-hastana-blue font-semibold;
}

.mobile-nav-link {
    @apply block py-3 text-gray-700 hover:text-hastana-blue font-medium transition-colors duration-200;
}

.mobile-nav-link.active {
    @apply text-hastana-blue font-semibold bg-blue-50 px-3 py-3 rounded-md;
}

/* Dropdown Animation */
.group:hover .group-hover\\:opacity-100 {
    animation: fadeInDown 0.2s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
function toggleMobileDropdown(id) {
    const dropdown = document.getElementById(id + '-dropdown');
    const icon = event.target.querySelector('.fa-chevron-down');
    
    dropdown.classList.toggle('hidden');
    
    if (icon) {
        icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
    }
}
</script>