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
        
        /* Mobile Navigation Active State */
        .mobile-menu-item.active {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(220, 38, 38, 0.1));
            color: var(--hastana-blue);
            border-left: 4px solid var(--hastana-blue);
            font-weight: 600;
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
                    <!-- Logo Icon -->
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-700 to-red-600 rounded-full flex items-center justify-center shadow-lg logo-ring">
                            <div class="w-8 h-8 border-2 border-white rounded-full flex items-center justify-center">
                                <i class="fas fa-gem text-white text-sm"></i>
                            </div>
                        </div>
                        <!-- Subtle ring animation -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-red-600 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Logo Text -->
                    <div class="flex flex-col">
                        <h1 class="text-xl font-bold text-hastana-black leading-tight">
                            HASTANA
                        </h1>
                        <span class="text-xs text-gray-600 font-medium tracking-wide -mt-1">
                            INDONESIA
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }} text-gray-700 font-medium px-2 py-1">
                        Home
                    </a>
                    <a href="{{ route('portfolio') }}" class="nav-link {{ Request::routeIs('portfolio*') ? 'active' : '' }} text-gray-700 font-medium px-2 py-1">
                        Portfolio WO
                    </a>
                    <a href="{{ route('members') }}" class="nav-link {{ Request::routeIs('members') ? 'active' : '' }} text-gray-700 font-medium px-2 py-1">
                        Daftar Anggota WO
                    </a>
                    <a href="{{ route('events') }}" class="nav-link {{ Request::routeIs('events') ? 'active' : '' }} text-gray-700 font-medium px-2 py-1">
                        Event
                    </a>
                    <a href="{{ route('blog') }}" class="nav-link {{ Request::routeIs('blog') ? 'active' : '' }} text-gray-700 font-medium px-2 py-1">
                        Blog
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link {{ Request::routeIs('contact') ? 'active' : '' }} text-gray-700 font-medium px-2 py-1">
                        Kontak
                    </a>
                </nav>

                <!-- CTA Button & Mobile Menu -->
                <div class="flex items-center space-x-4">
                    <!-- CTA Button (Desktop) -->
                    <a href="{{ route('join') }}" class="hidden sm:inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-700 to-red-600 text-white font-semibold rounded-full hover:from-blue-800 hover:to-red-700 transition-smooth shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus mr-2 text-sm"></i>
                        Bergabung
                    </a>

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
                <a href="{{ route('portfolio') }}" class="mobile-menu-item {{ Request::routeIs('portfolio*') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-briefcase mr-3 text-sm w-5"></i>
                    <span class="font-medium">Portfolio WO</span>
                </a>
                <a href="{{ route('members') }}" class="mobile-menu-item {{ Request::routeIs('members') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-users mr-3 text-sm w-5"></i>
                    <span class="font-medium">Daftar Anggota WO</span>
                </a>
                <a href="{{ route('events') }}" class="mobile-menu-item {{ Request::routeIs('events') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-calendar-alt mr-3 text-sm w-5"></i>
                    <span class="font-medium">Event</span>
                </a>
                <a href="{{ route('blog') }}" class="mobile-menu-item {{ Request::routeIs('blog') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth border-b border-gray-100">
                    <i class="fas fa-blog mr-3 text-sm w-5"></i>
                    <span class="font-medium">Blog</span>
                </a>
                <a href="{{ route('contact') }}" class="mobile-menu-item {{ Request::routeIs('contact') ? 'active' : '' }} flex items-center py-4 px-4 text-gray-700 hover:text-hastana-blue hover:bg-blue-50 rounded-lg transition-smooth">
                    <i class="fas fa-envelope mr-3 text-sm w-5"></i>
                    <span class="font-medium">Kontak</span>
                </a>
                
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

    <!-- Demo Content -->
    <main class="pt-20">
        <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-bold text-hastana-black mb-6">
                    Himpunan Perusahaan Penata Acara
                    <span class="gradient-text">Seluruh Indonesia</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Organisasi resmi yang menaungi para wedding organizer terbaik di Indonesia. 
                    Bergabunglah dengan komunitas profesional yang berkomitmen memberikan layanan berkualitas tinggi.
                </p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-smooth">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-700 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-certificate text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-hastana-black mb-2">Sertifikasi Resmi</h3>
                        <p class="text-gray-600">Wedding organizer bersertifikat dengan standar internasional</p>
                    </div>
                    
                    <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-smooth">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-hastana-black mb-2">Jaringan Profesional</h3>
                        <p class="text-gray-600">Terhubung dengan wedding organizer terbaik se-Indonesia</p>
                    </div>
                    
                    <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-smooth">
                        <div class="w-16 h-16 bg-gradient-to-br from-gray-700 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-hastana-black mb-2">Kualitas Terjamin</h3>
                        <p class="text-gray-600">Standar pelayanan premium untuk acara pernikahan impian</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
