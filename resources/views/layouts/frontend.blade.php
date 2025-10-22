<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'HASTANA - Himpunan Perusahaan Penata Acara Seluruh Indonesia. Organisasi resmi wedding organizer profesional di Indonesia.')">
    <meta name="keywords" content="wedding organizer, pernikahan, HASTANA, wedding planner, Indonesia, sertifikasi, @yield('keywords')">
    <meta name="author" content="HASTANA Indonesia">
    
    <!-- SEO Meta Tags -->
    <meta property="og:title" content="@yield('title', 'HASTANA Indonesia - Wedding Organizer Professional')">
    <meta property="og:description" content="@yield('description', 'Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/hastana-logo.png') }}">
    
    <title>@yield('title', 'HASTANA Indonesia - Wedding Organizer Professional')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/hastana.css') }}">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* HASTANA Brand Colors */
        :root {
            --hastana-blue: #1e40af;
            --hastana-red: #dc2626;
            --hastana-black: #1a1a1a;
            --hastana-gray: #6b7280;
            --hastana-light-gray: #f3f4f6;
        }
        
        .text-hastana-blue { color: var(--hastana-blue); }
        .text-hastana-red { color: var(--hastana-red); }
        .bg-hastana-blue { background-color: var(--hastana-blue); }
        .bg-hastana-red { background-color: var(--hastana-red); }
        .border-hastana-blue { border-color: var(--hastana-blue); }
        
        /* Loading Animation */
        .page-loading {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .page-loaded .page-loading {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Focus States */
        a:focus, button:focus {
            outline: 2px solid var(--hastana-blue);
            outline-offset: 2px;
            border-radius: 4px;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased page-loading">
    <!-- Skip to Content (Accessibility) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-hastana-blue text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Main Content -->
    <main id="main-content" class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Page Loaded Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loaded class for animations
            setTimeout(() => {
                document.body.classList.add('page-loaded');
            }, 100);
            
            // Mobile menu toggle (if exists)
            const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');
            
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle hamburger icon
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-bars');
                        icon.classList.toggle('fa-times');
                    }
                });
            }
            
            // Smooth scroll for anchor links
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
                });
            });
        });
    </script>
</body>
</html>