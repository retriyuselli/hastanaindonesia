<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'HASTANA - Himpunan Perusahaan Penata Acara Seluruh Indonesia. Organisasi resmi wedding organizer profesional di Indonesia.')">
    <meta name="keywords" content="wedding organizer, pernikahan, HASTANA, wedding planner, Indonesia, sertifikasi">
    <meta name="author" content="HASTANA Indonesia">
    
    <title>@yield('title', 'HASTANA Indonesia - Wedding Organizer Professional')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/hastana.css') }}">
    
    <!-- Compiled application assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }
        
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #111827;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #000000;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-white">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:px-4 focus:py-2">
        Lewati ke konten utama
    </a>

    <!-- Header -->
    @include('layouts.header')
    
    <!-- Main Content -->
    <main id="main-content" class="pt-14 sm:pt-20">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.footer')
    
    <!-- Back to Top Button -->
    <button type="button" id="back-to-top" aria-label="Kembali ke atas" class="fixed bottom-8 right-8 bg-gradient-to-r from-gray-900 to-hastana-red text-white p-3 rounded-full shadow-lg hover:from-black hover:to-red-700 transition-all duration-300 transform hover:scale-110 hidden z-50">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- Scripts -->
    <script>
        // Loading animation
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });
        
        // Back to top button functionality
        const backToTopButton = document.getElementById('back-to-top');
        if (backToTopButton) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('hidden');
                } else {
                    backToTopButton.classList.add('hidden');
                }
            });
            
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    </script>
    
    <x-success-modal />
    <x-error-modal />
    @stack('scripts')
</body>
</html>
