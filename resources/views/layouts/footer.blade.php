<!-- Footer -->
<footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    {{-- <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-red-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-gem text-white text-xl"></i>
                    </div> --}}
                    <!-- Logo Section -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-4 logo-container cursor-pointer group">
                        <!-- Logo Image -->
                        <div class="relative">
                            <img src="{{ asset('images/Logo Hastana Indonesia Putih.png') }}" alt="HASTANA Indonesia"
                                class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-110">
                            <!-- Subtle glow effect on hover -->
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-red-600 rounded-full opacity-0 group-hover:opacity-20 blur transition-opacity duration-300">
                            </div>
                        </div>

                        <!-- Logo Text -->
                        {{-- <div class="flex flex-col">
                        <h1 class="text-xl font-bold text-hastana-black leading-tight">
                            HASTANA
                        </h1>
                        <span class="text-xs text-gray-600 font-medium tracking-wide -mt-1">
                            INDONESIA
                        </span>
                    </div> --}}
                    </a>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed mb-6">
                    Himpunan Perusahaan Penata Acara Seluruh Indonesia - Organisasi resmi yang menaungi wedding
                    organizer profesional di Indonesia.
                </p>
                <div class="flex space-x-3">
                    {{-- <a href="https://www.facebook.com/hastanaindonesia" target="_blank" 
                        class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                        <i class="fab fa-facebook-f text-white text-xs"></i>
                    </a> --}}
                    <a href="https://www.instagram.com/hastana_indonesia" target="_blank"
                        class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors">
                        <i class="fab fa-instagram text-white text-xs"></i>
                    </a>
                    {{-- <a href="https://twitter.com/hastanaindonesia" target="_blank"
                        class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                        <i class="fab fa-twitter text-white text-xs"></i>
                    </a>
                    <a href="https://www.youtube.com/@hastanaindonesia" target="_blank"
                        class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
                        <i class="fab fa-youtube text-white text-xs"></i>
                    </a> --}}
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-base font-semibold mb-4">Menu Utama</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('events') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Event</a></li>
                    <li><a href="{{ route('blog') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="{{ route('about') }}" class="text-sm text-gray-300 hover:text-white transition-colors">About</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Hubungi Kami</a></li>
                    <li><a href="{{ route('gallery') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Gallery</a></li>
                    <li><a href="{{ route('members') }}" class="text-sm text-gray-300 hover:text-white transition-colors">Daftar Anggota WO</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="text-base font-semibold mb-4">Layanan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Sertifikasi WO</a>
                    </li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Pelatihan Profesional</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Networking Event</a>
                    </li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Konsultasi Bisnis</a>
                    </li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Directory WO</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Quality Assurance</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-base font-semibold mb-4">Kontak Kami</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-map-marker-alt text-red-500 mt-1 text-xs"></i>
                        <div>
                            <p class="text-sm text-gray-300">
                                Ruko Kelapa Hijau, Jl. Brojomulyo No.13-14 13-14, Gejayan, Condongcatur, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281<br>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone text-blue-500 text-xs"></i>
                        <p class="text-sm text-gray-300">+62 811-3130-612</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-green-500 text-xs"></i>
                        <p class="text-sm text-gray-300">info@hastanaindonesia.id</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-globe text-purple-500 text-xs"></i>
                        <p class="text-sm text-gray-300">www.hastanaindonesia.id</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-xs mb-3 md:mb-0">
                    <p>&copy; {{ date('Y') }} HASTANA Indonesia. All rights reserved.</p>
                </div>
                <div class="flex space-x-4 text-xs">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>

        <!-- Certification Badges -->
        <div class="mt-6 pt-6 border-t border-gray-700">
            <div class="flex justify-center items-center">
                <div class="text-center">
                    <p class="text-gray-400 text-xs">
                        <i class="fas fa-code text-blue-500 mr-1 text-xs"></i>
                        Developed by <span class="text-white font-semibold">PT. Makna Kreatif Indonesia</span>
                    </p>        
                    <p class="text-gray-500 text-xs mt-1">Makna Wedding & Event Planner</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp Button -->
<div class="fixed bottom-6 left-6 z-50">
    <a href="https://wa.me/628113130612?text=Halo%20Kak,%20saya%20ingin%20berkonsultasi%20tentang%20HASTANA%20INDONESIA"
        target="_blank"
        class="group bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 flex items-center justify-center">
        <i class="fab fa-whatsapp text-2xl"></i>

        <!-- Tooltip -->
        <div
            class="absolute left-full ml-3 bg-gray-800 text-white px-3 py-2 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            Chat via WhatsApp
            <div
                class="absolute top-1/2 -left-1 transform -translate-y-1/2 w-0 h-0 border-r-4 border-r-gray-800 border-t-2 border-b-2 border-t-transparent border-b-transparent">
            </div>
        </div>

        <!-- Pulse Animation -->
        <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-20"></div>
    </a>
</div>

<style>
    @keyframes pulse-whatsapp {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
    }

    .whatsapp-float {
        animation: pulse-whatsapp 2s infinite;
    }
</style>
