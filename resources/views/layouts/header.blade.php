<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HASTANA Indonesia - Himpunan Perusahaan Penata Acara Seluruh Indonesia</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Custom Tailwind Configuration */
        :root {
            --hastana-black: #1a1a1a;
            --hastana-blue: #1e40af;
            --hastana-red: #dc2626;
            --hastana-blue-light: #3b82f6;
            --hastana-red-light: #ef4444;
        }
        
        .font-poppins { font-family: 'Poppins', sans-serif; }
        
        /* Custom Colors */
        .bg-hastana-black { background-color: var(--hastana-black); }
        .bg-hastana-blue { background-color: var(--hastana-blue); }
        .bg-hastana-red { background-color: var(--hastana-red); }
        .text-hastana-black { color: var(--hastana-black); }
        .text-hastana-blue { color: var(--hastana-blue); }
        .text-hastana-red { color: var(--hastana-red); }
        .border-hastana-blue { border-color: var(--hastana-blue); }
        .border-hastana-red { border-color: var(--hastana-red); }
        
        /* Subtle background pattern */
        .pattern-bg {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(30, 64, 175, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(220, 38, 38, 0.03) 0%, transparent 50%),
                linear-gradient(135deg, rgba(26, 26, 26, 0.02) 0%, transparent 100%);
        }
        
        /* Ring pattern overlay */
        .ring-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='15' fill='none' stroke='%23e5e7eb' stroke-width='0.5' opacity='0.1'/%3E%3Ccircle cx='30' cy='30' r='8' fill='none' stroke='%23e5e7eb' stroke-width='0.3' opacity='0.1'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-position: 0 0, 30px 30px;
        }
        
        /* Smooth transitions */
        .transition-smooth { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--hastana-blue), var(--hastana-red));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: var(--hastana-blue);
            transform: translateY(-1px);
        }
        
        /* Logo animation */
        .logo-container:hover .logo-ring {
            transform: rotate(360deg);
            transition: transform 0.8s ease-in-out;
        }
        
        /* Mobile menu animation - improved */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            visibility: hidden;
        }
        
        .mobile-menu.active {
            max-height: 600px;
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }
        
        /* Debug mobile menu - remove this in production */
        @media (max-width: 1023px) {
            .mobile-menu {
                display: block !important;
            }
        }
        
        /* Menu item stagger animation */
        .mobile-menu-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.3s ease;
        }
        
        .mobile-menu.active .mobile-menu-item {
            opacity: 1;
            transform: translateX(0);
        }
        
        .mobile-menu.active .mobile-menu-item:nth-child(1) { transition-delay: 0.1s; }
        .mobile-menu.active .mobile-menu-item:nth-child(2) { transition-delay: 0.15s; }
        .mobile-menu.active .mobile-menu-item:nth-child(3) { transition-delay: 0.2s; }
        .mobile-menu.active .mobile-menu-item:nth-child(4) { transition-delay: 0.25s; }
        .mobile-menu.active .mobile-menu-item:nth-child(5) { transition-delay: 0.3s; }
        .mobile-menu.active .mobile-menu-item:nth-child(6) { transition-delay: 0.35s; }
        .mobile-menu.active .mobile-menu-item:nth-child(7) { transition-delay: 0.4s; }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, var(--hastana-blue), var(--hastana-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Backdrop blur */
        .backdrop-blur-custom {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        /* Navigation Active State */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--hastana-blue);
        }
        
        .nav-link.active {
            color: var(--hastana-blue);
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background: linear-gradient(135deg, var(--hastana-blue), var(--hastana-red));
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }
        
        .nav-link.active::before {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--hastana-blue), var(--hastana-red));
            border-radius: 1px;
            opacity: 0.7;
        }
        
        @keyframes pulse-dot {
            0%, 100% { 
                opacity: 1; 
                transform: translateX(-50%) scale(1); 
            }
            50% { 
                opacity: 0.7; 
                transform: translateX(-50%) scale(1.2); 
            }
        }
        
        /* Dropdown Menu Styles */
        .dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            min-width: 220px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.05);
            opacity: 0;
            visibility: hidden;
            transform: translateX(-50%) translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            backdrop-filter: blur(10px);
            margin-top: 8px;
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s ease;
            border-radius: 8px;
            margin: 4px;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(220, 38, 38, 0.05));
            color: var(--hastana-blue);
            transform: translateX(4px);
        }
        
        .dropdown-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }
        
        .dropdown-arrow {
            transition: transform 0.3s ease;
        }
        
        .dropdown:hover .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        /* Mobile Dropdown Styles */
        .mobile-dropdown-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(249, 250, 251, 0.8);
            border-radius: 8px;
            margin-top: 8px;
        }
        
        .mobile-dropdown-menu.active {
            max-height: 200px;
        }
        
        .mobile-dropdown-item {
            padding: 10px 20px 10px 40px;
            color: #6b7280;
            border-left: 2px solid transparent;
            transition: all 0.2s ease;
        }
        
        .mobile-dropdown-item:hover {
            background: rgba(30, 64, 175, 0.1);
            color: var(--hastana-blue);
            border-left-color: var(--hastana-blue);
        }

        /* Mobile Navigation Active State */
        .mobile-menu-item.active {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(220, 38, 38, 0.05));
            color: var(--hastana-blue);
            border-left: 4px solid var(--hastana-blue);
        }
        
        .mobile-menu-item.active i {
            color: var(--hastana-blue);
        }
    </style>
</head>

<body class="font-poppins bg-white">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-custom border-b border-gray-100 shadow-sm">
        <!-- Background Pattern Overlay -->
        <div class="absolute inset-0 pattern-bg ring-pattern opacity-30"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo Section -->
                <a href="{{ route('home') }}" class="flex items-center space-x-4 logo-container cursor-pointer group">
                    <!-- Logo Image -->
                    <div class="relative">
                        <img src="{{ asset('images/hastana_logo.png') }}" 
                             alt="HASTANA Indonesia" 
                             class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-110">
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-red-600 rounded-full opacity-0 group-hover:opacity-20 blur transition-opacity duration-300"></div>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }} text-gray-700 text-sm font-medium px-2 py-1">
                        Home
                    </a>
                    <a href="{{ route('events') }}" class="nav-link {{ Request::routeIs('events') ? 'active' : '' }} text-gray-700 text-sm font-medium px-2 py-1">
                        Event
                    </a>
                    <a href="{{ route('blog') }}" class="nav-link {{ Request::routeIs('blog') ? 'active' : '' }} text-gray-700 text-sm font-medium px-2 py-1">
                        Blog
                    </a>
                    <a href="{{ route('about') }}" class="nav-link {{ Request::routeIs('about') ? 'active' : '' }} text-gray-700 text-sm font-medium px-2 py-1">
                        About
                    </a>
                    <!-- Kontak Dropdown -->
                    <div class="dropdown">
                        <a href="{{ route('contact') }}" class="nav-link {{ Request::routeIs('contact') || Request::routeIs('portfolio*') || Request::routeIs('members') ? 'active' : '' }} text-gray-700 text-sm font-medium px-2 py-1 flex items-center">
                            Kontak
                            <i class="fas fa-chevron-down ml-1 text-xs dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('contact') }}" class="dropdown-item text-sm">
                                <i class="fas fa-envelope text-xs"></i>
                                Hubungi Kami
                            </a>
                            <a href="{{ route('gallery') }}" class="dropdown-item text-sm">
                                <i class="fas fa-images text-xs"></i>
                                Gallery
                            </a>
                            {{-- <a href="{{ route('portfolio') }}" class="dropdown-item text-sm">
                                <i class="fas fa-briefcase text-xs"></i>
                                Portfolio WO
                            </a> --}}
                            <a href="{{ route('members') }}" class="dropdown-item text-sm">
                                <i class="fas fa-users text-xs"></i>
                                Daftar Anggota WO
                            </a>
                        </div>
                    </div>

                    <!-- Login Link for Guest (Desktop) -->
                    @guest
                        <a href="{{ route('login') }}" class="nav-link {{ Request::routeIs('login') ? 'active' : '' }} text-gray-700 text-sm font-medium px-4 py-2 hover:text-hastana-blue transition-smooth">
                            <i class="fas fa-sign-in-alt mr-1 text-xs"></i>
                            Login
                        </a>
                    @endguest
                </nav>

                <!-- CTA Button & Mobile Menu -->
                <div class="flex items-center space-x-4">
                    <!-- CTA Button (Desktop) -->
                    @guest
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-700 to-red-600 text-white text-sm font-semibold rounded-full hover:from-blue-800 hover:to-red-700 transition-smooth shadow-md hover:shadow-lg">
                            <i class="fas fa-user-plus mr-1.5 text-xs"></i>
                            Gabung Sekarang
                        </a>
                    @else
                        <!-- User Avatar with Dropdown (Desktop Only) -->
                        <div class="hidden sm:block dropdown">
                            <a href="#" class="flex items-center hover:opacity-90 transition-smooth">
                                <div class="w-10 h-10 rounded-full overflow-hidden {{ auth()->user()->avatar ? '' : 'bg-gradient-to-r from-blue-600 to-red-600 flex items-center justify-center text-white font-bold' }} ring-2 ring-blue-500 shadow-lg hover:ring-blue-600 transition-all">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                            </a>
                            <div class="dropdown-menu">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="dropdown-item text-sm">
                                    <i class="fas fa-tachometer-alt text-xs"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="dropdown-item text-sm">
                                    <i class="fas fa-user-circle text-xs"></i>
                                    Profil Saya
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ url('/admin') }}" class="dropdown-item text-sm">
                                    <i class="fas fa-cog text-xs"></i>
                                    Admin Panel
                                </a>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt text-xs"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    <!-- Mobile Menu Button -->
                    <button 
                        id="mobile-menu-button"
                        class="lg:hidden p-2 rounded-lg text-gray-700 hover:text-hastana-blue hover:bg-gray-50 transition-smooth" 
                        onclick="toggleMobileMenu()"
                        aria-label="Toggle mobile menu"
                        aria-expanded="false"
                        type="button">
                        <i class="fas fa-bars text-xl" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden mobile-menu bg-white border-t border-gray-200 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 py-6 space-y-1">
                <a href="{{ route('home') }}" class="mobile-menu-item {{ Request::routeIs('home') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-home mr-3 text-sm w-5"></i>
                    <span class="font-medium">Home</span>
                </a>
                <a href="{{ route('events') }}" class="mobile-menu-item {{ Request::routeIs('events') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-calendar-alt mr-3 text-sm w-5"></i>
                    <span class="font-medium">Event</span>
                </a>
                <a href="{{ route('blog') }}" class="mobile-menu-item {{ Request::routeIs('blog') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-blog mr-3 text-sm w-5"></i>
                    <span class="font-medium">Blog</span>
                </a>
                
                <!-- Mobile Kontak Dropdown -->
                <div class="border-b border-gray-100">
                    <button class="mobile-menu-item {{ Request::routeIs('contact') || Request::routeIs('portfolio*') || Request::routeIs('members') ? 'active' : '' }} w-full flex items-center justify-between py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth" onclick="toggleMobileDropdown('kontak')">
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-sm w-5"></i>
                            <span class="font-medium">Kontak</span>
                        </div>
                        <i class="fas fa-chevron-down text-sm transition-transform duration-300" id="kontak-arrow"></i>
                    </button>
                    <div class="mobile-dropdown-menu" id="kontak-dropdown">
                        <a href="{{ route('contact') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                            <i class="fas fa-envelope mr-2 text-xs w-4"></i>
                            Hubungi Kami
                        </a>
                        <a href="{{ route('gallery') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                            <i class="fas fa-images mr-2 text-xs w-4"></i>
                            Gallery
                        </a>
                        {{-- <a href="{{ route('portfolio') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                            <i class="fas fa-briefcase mr-2 text-xs w-4"></i>
                            Portfolio WO
                        </a> --}}
                        <a href="{{ route('members') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                            <i class="fas fa-users mr-2 text-xs w-4"></i>
                            Daftar Anggota WO
                        </a>
                    </div>
                </div>
                
                <!-- Mobile Authentication Dropdown -->
                <div class="border-b border-gray-100">
                    @auth
                        <!-- User Logged In (Mobile) -->
                        <button class="mobile-menu-item w-full flex items-center justify-between py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth" onclick="toggleMobileDropdown('akun')">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full overflow-hidden {{ auth()->user()->avatar ? '' : 'bg-gradient-to-r from-blue-600 to-red-600 flex items-center justify-center text-white font-semibold text-sm' }} mr-3 ring-2 ring-gray-200">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-sm">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-[150px]">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-300" id="akun-arrow"></i>
                        </button>
                        <div class="mobile-dropdown-menu" id="akun-dropdown">
                            <a href="{{ route('dashboard') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                                <i class="fas fa-tachometer-alt mr-2 text-xs w-4"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                                <i class="fas fa-user-circle mr-2 text-xs w-4"></i>
                                Profil Saya
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                                <i class="fas fa-cog mr-2 text-xs w-4"></i>
                                Admin Panel
                            </a>
                            @endif
                            <a href="#" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                                <i class="fas fa-ticket-alt mr-2 text-xs w-4"></i>
                                Event Saya
                            </a>
                            <div class="border-t border-gray-200 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="mobile-dropdown-item w-full text-left flex items-center text-sm hover:bg-red-50 text-red-600 transition-smooth rounded">
                                    <i class="fas fa-sign-out-alt mr-2 text-xs w-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Guest User (Mobile) -->
                        <button class="mobile-menu-item {{ Request::routeIs('login') || Request::routeIs('register') ? 'active' : '' }} w-full flex items-center justify-between py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth" onclick="toggleMobileDropdown('akun')">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-3 text-sm w-5"></i>
                                <span class="font-medium">Akun</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-300" id="akun-arrow"></i>
                        </button>
                        <div class="mobile-dropdown-menu" id="akun-dropdown">
                            <a href="{{ route('login') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                                <i class="fas fa-sign-in-alt mr-2 text-xs w-4"></i>
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="mobile-dropdown-item flex items-center text-sm hover:bg-blue-50 transition-smooth rounded">
                                <i class="fas fa-user-plus mr-2 text-xs w-4"></i>
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
                
                <!-- Mobile CTA -->
                <div class="mobile-menu-item pt-6 border-t border-gray-200 mt-4">
                    <a href="{{ route('join') }}" class="flex items-center justify-center w-full py-4 bg-gradient-to-r from-blue-700 to-red-600 text-white font-semibold rounded-xl transition-smooth hover:from-blue-800 hover:to-red-700 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus mr-2 text-sm"></i>
                        <span>Bergabung dengan HASTANA</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Mobile menu toggle with improved functionality (backup function)
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const menuButton = document.getElementById('mobile-menu-button');
            const body = document.body;
            
            console.log('toggleMobileMenu function called'); // Debug log
            
            if (!mobileMenu || !menuIcon) {
                console.error('Mobile menu elements not found in toggle function'); // Debug log
                return;
            }
            
            if (mobileMenu.classList.contains('active')) {
                // Close menu
                mobileMenu.classList.remove('active');
                menuIcon.className = 'fas fa-bars text-xl';
                if (menuButton) menuButton.setAttribute('aria-expanded', 'false');
                body.style.overflow = 'auto';
                console.log('Menu closed via toggle function'); // Debug log
            } else {
                // Open menu
                mobileMenu.classList.add('active');
                menuIcon.className = 'fas fa-times text-xl';
                if (menuButton) menuButton.setAttribute('aria-expanded', 'true');
                body.style.overflow = 'hidden';
                console.log('Menu opened via toggle function'); // Debug log
            }
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = event.target.closest('button');
            const header = document.querySelector('header');
            
            // Check if click is outside header and menu is open
            if (!header.contains(event.target) && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                document.getElementById('menu-icon').className = 'fas fa-bars text-xl';
                document.body.style.overflow = 'auto';
                console.log('Menu closed by outside click'); // Debug log
            }
        });

        // Close mobile menu when window is resized to desktop
        window.addEventListener('resize', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (window.innerWidth >= 1024 && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                document.getElementById('menu-icon').className = 'fas fa-bars text-xl';
                document.body.style.overflow = 'auto';
                console.log('Menu closed due to resize'); // Debug log
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('shadow-lg');
                header.classList.remove('shadow-sm');
            } else {
                header.classList.remove('shadow-lg');
                header.classList.add('shadow-sm');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                
                // Close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    document.getElementById('menu-icon').className = 'fas fa-bars text-xl';
                    document.body.style.overflow = 'auto';
                    console.log('Menu closed after link click'); // Debug log
                }
            });
        });

        // Mobile dropdown toggle function
        function toggleMobileDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId + '-dropdown');
            const arrow = document.getElementById(dropdownId + '-arrow');
            
            if (!dropdown || !arrow) {
                console.error('Dropdown elements not found:', dropdownId);
                return;
            }
            
            const isActive = dropdown.classList.contains('active');
            
            // Close all other dropdowns first
            const allDropdowns = document.querySelectorAll('.mobile-dropdown-menu');
            const allArrows = document.querySelectorAll('[id$="-arrow"]');
            
            allDropdowns.forEach(dd => dd.classList.remove('active'));
            allArrows.forEach(arr => arr.style.transform = 'rotate(0deg)');
            
            // Toggle current dropdown
            if (!isActive) {
                dropdown.classList.add('active');
                arrow.style.transform = 'rotate(180deg)';
                console.log('Mobile dropdown opened:', dropdownId);
            } else {
                dropdown.classList.remove('active');
                arrow.style.transform = 'rotate(0deg)';
                console.log('Mobile dropdown closed:', dropdownId);
            }
        }

        // Ensure mobile menu button is clickable
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            
            console.log('DOM loaded, setting up mobile menu'); // Debug log
            console.log('Menu button:', menuButton); // Debug log
            console.log('Mobile menu:', mobileMenu); // Debug log
            
            if (menuButton && mobileMenu && menuIcon) {
                // Remove inline onclick and add proper event listener
                menuButton.removeAttribute('onclick');
                
                menuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('Menu button clicked'); // Debug log
                    
                    const isActive = mobileMenu.classList.contains('active');
                    
                    if (isActive) {
                        // Close menu
                        mobileMenu.classList.remove('active');
                        menuIcon.className = 'fas fa-bars text-xl';
                        menuButton.setAttribute('aria-expanded', 'false');
                        document.body.style.overflow = 'auto';
                        console.log('Menu closed'); // Debug log
                    } else {
                        // Open menu
                        mobileMenu.classList.add('active');
                        menuIcon.className = 'fas fa-times text-xl';
                        menuButton.setAttribute('aria-expanded', 'true');
                        document.body.style.overflow = 'hidden';
                        console.log('Menu opened'); // Debug log
                    }
                });
                
                // Add touch event for mobile devices
                menuButton.addEventListener('touchend', function(e) {
                    e.preventDefault();
                    menuButton.click();
                });
                
                console.log('Mobile menu event listeners added successfully'); // Debug log
            } else {
                console.error('Mobile menu elements not found'); // Debug log
            }
        });
    </script>
</body>
</html>
