<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/hastana-logo-white.png') }}" alt="HASTANA Indonesia" class="h-12 w-auto">
                    <div>
                        <h3 class="text-xl font-bold">HASTANA</h3>
                        <p class="text-sm text-gray-400">Wedding Organizer Indonesia</p>
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Himpunan Perusahaan Penata Acara Seluruh Indonesia - Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-youtube text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-tiktok text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white">Navigasi Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Beranda</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Tentang Kami</a></li>
                    <li><a href="{{ route('members') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Anggota</a></li>
                    <li><a href="{{ route('portfolio') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Portfolio</a></li>
                    <li><a href="{{ route('events') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Event</a></li>
                    <li><a href="{{ route('blog') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Kontak</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white">Layanan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Sertifikasi WO</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Pelatihan Professional</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Direktori Anggota</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Event Networking</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Konsultasi Bisnis</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Media Partnership</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white">Hubungi Kami</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-hastana-red mt-1"></i>
                        <div>
                            <p class="text-gray-300 text-sm">Jl. Wedding Avenue No. 123</p>
                            <p class="text-gray-300 text-sm">Jakarta Pusat, DKI Jakarta 10110</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-hastana-red"></i>
                        <a href="tel:+622112345678" class="text-gray-300 hover:text-white text-sm transition-colors">
                            +62 21 1234 5678
                        </a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-hastana-red"></i>
                        <a href="mailto:info@hastanaindonesia.org" class="text-gray-300 hover:text-white text-sm transition-colors">
                            info@hastanaindonesia.org
                        </a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-globe text-hastana-red"></i>
                        <a href="https://www.hastanaindonesia.org" class="text-gray-300 hover:text-white text-sm transition-colors">
                            www.hastanaindonesia.org
                        </a>
                    </div>
                </div>

                <!-- Newsletter Signup -->
                <div class="mt-6">
                    <h5 class="text-sm font-semibold text-white mb-2">Newsletter</h5>
                    <form class="flex">
                        <input type="email" placeholder="Email Anda" class="flex-1 px-3 py-2 text-sm bg-gray-800 text-white border border-gray-700 rounded-l-md focus:outline-none focus:border-hastana-blue">
                        <button type="submit" class="px-4 py-2 bg-hastana-red hover:bg-red-700 text-white text-sm rounded-r-md transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-800">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                
                <!-- Copyright -->
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} HASTANA Indonesia. All rights reserved.
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Himpunan Perusahaan Penata Acara Seluruh Indonesia
                    </p>
                </div>

                <!-- Legal Links -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('terms') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Syarat & Ketentuan
                    </a>
                    <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Kebijakan Privasi
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Sitemap
                    </a>
                </div>

                <!-- Back to Top -->
                <button onclick="scrollToTop()" class="bg-hastana-blue hover:bg-blue-800 text-white p-2 rounded-full transition-colors" title="Kembali ke atas">
                    <i class="fas fa-arrow-up text-sm"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Member Logos Section (Optional) -->
    <div class="bg-gray-800 py-8">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h4 class="text-lg font-semibold text-white">Didukung Oleh</h4>
                <p class="text-gray-400 text-sm">Anggota dan Partner Terpercaya</p>
            </div>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-6 items-center opacity-60 hover:opacity-100 transition-opacity">
                <!-- Partner logos would go here -->
                <div class="bg-white rounded-lg p-4 aspect-square flex items-center justify-center">
                    <span class="text-gray-400 text-xs text-center">Partner Logo</span>
                </div>
                <div class="bg-white rounded-lg p-4 aspect-square flex items-center justify-center">
                    <span class="text-gray-400 text-xs text-center">Partner Logo</span>
                </div>
                <div class="bg-white rounded-lg p-4 aspect-square flex items-center justify-center">
                    <span class="text-gray-400 text-xs text-center">Partner Logo</span>
                </div>
                <div class="bg-white rounded-lg p-4 aspect-square flex items-center justify-center">
                    <span class="text-gray-400 text-xs text-center">Partner Logo</span>
                </div>
                <div class="bg-white rounded-lg p-4 aspect-square flex items-center justify-center">
                    <span class="text-gray-400 text-xs text-center">Partner Logo</span>
                </div>
                <div class="bg-white rounded-lg p-4 aspect-square flex items-center justify-center">
                    <span class="text-gray-400 text-xs text-center">Partner Logo</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/hide back to top button
window.addEventListener('scroll', function() {
    const backToTop = document.querySelector('button[onclick="scrollToTop()"]');
    if (window.pageYOffset > 300) {
        backToTop.classList.remove('opacity-0');
        backToTop.classList.add('opacity-100');
    } else {
        backToTop.classList.remove('opacity-100');
        backToTop.classList.add('opacity-0');
    }
});
</script>