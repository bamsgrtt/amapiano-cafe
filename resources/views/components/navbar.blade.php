<style>
    .nav-link {
        position: relative;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #d88234;
        transition: width 0.3s ease;
    }
    .nav-link:hover::after {
        width: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, #d88234 0%, #c96c2b 100%);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #c96c2b 0%, #a75525 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(216, 130, 52, 0.4);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #166534 0%, #15803d 100%);
        transition: all 0.3s ease;
    }
    .btn-secondary:hover {
        background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(22, 101, 52, 0.4);
    }

    .navbar-scrolled {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
</style>

<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Amapiano Cafe" class="h-10 w-auto object-contain rounded-full transition-all duration-300" id="nav-logo-img">
                    
                    <div class="flex flex-col leading-none">
                        <span class="font-display font-bold text-xl tracking-wide text-white transition-colors duration-300" id="nav-logo-text">
                            {{ config('app.name', 'Amapiano Cafe') }}
                        </span>
                        <span class="text-xs font-medium mt-0.5 tracking-wider text-white/80 transition-colors duration-300" id="nav-logo-sub">
                            Taste & Beats of Africa
                        </span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links - Desktop -->
            <div class="hidden md:flex items-center justify-end flex-1">
                <div class="flex items-center">
                    <a href="#beranda" class="nav-link text-white/90 hover:text-white transition-colors text-sm font-medium whitespace-nowrap block mr-6" id="nav-home">Beranda</a>
                    <a href="#tentang" class="nav-link text-white/90 hover:text-white transition-colors text-sm font-medium whitespace-nowrap block mr-6" id="nav-about">Tentang</a>
                    <a href="#galeri" class="nav-link text-white/90 hover:text-white transition-colors text-sm font-medium whitespace-nowrap block mr-6" id="nav-gallery">Galeri</a>
                    <a href="#lokasi" class="nav-link text-white/90 hover:text-white transition-colors text-sm font-medium whitespace-nowrap block mr-6" id="nav-location">Kontak</a>
                </div>

                <div class="flex items-center">
                    <a href="{{ Route::has('reservation') ? route('reservation') : '/reservation' }}" class="btn-primary text-white px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap block mr-4 transition-transform hover:-translate-y-0.5" id="nav-reserve-btn">
                        Reservasi Sekarang
                    </a>
                    <a href="{{ Route::has('login') ? route('login') : '/login' }}" class="btn-primary text-white px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap block mr-4 transition-transform hover:-translate-y-0.5" id="nav-reserve-btn">
                        Login
                    </a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-amapiano-400 hover:bg-white/10 focus:outline-none focus:bg-white/10 focus:text-amapiano-400 transition duration-150 ease-in-out" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path class="hamburger-line hamburger-top" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16"/>
                        <path class="hamburger-line hamburger-mid" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"/>
                        <path class="hamburger-line hamburger-bot" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="sm:hidden hidden bg-white/95 backdrop-blur-lg shadow-xl border-t border-white/20">
        <div class="px-4 py-6 space-y-4">
           <a href="{{ Route::has('welcome') ? route('welcome') . '#beranda' : '/welcome#beranda' }}" class="block text-gray-800 hover:text-amapiano-600 font-medium py-2 border-b border-gray-100 transition-colors" onclick="closeMobileMenu()">Beranda</a>
            <a href="#tentang" class="block text-gray-800 hover:text-amapiano-600 font-medium py-2 border-b border-gray-100 transition-colors" onclick="closeMobileMenu()">Tentang</a>
            <a href="#galeri" class="block text-gray-800 hover:text-amapiano-600 font-medium py-2 border-b border-gray-100 transition-colors" onclick="closeMobileMenu()">Galeri</a>
            <a href="#lokasi" class="block text-gray-800 hover:text-amapiano-600 font-medium py-2 border-b border-gray-100 transition-colors" onclick="closeMobileMenu()">Kontak</a>
            <a href="{{ Route::has('reservation') ? route('reservation') : '/reservation' }}" class="btn-primary text-white px-6 py-3 rounded-full text-sm font-semibold block text-center mt-4" onclick="closeMobileMenu()">Reservasi Sekarang</a>
            <a href="{{ Route::has('login') ? route('login') : '/login' }}" class="btn-secondary text-white px-6 py-3 rounded-full text-sm font-semibold block text-center" onclick="closeMobileMenu()">Login</a>
        </div>
    </div>
</nav>

<script>
 // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        const logoText = document.getElementById('nav-logo-text');
        const logoSub = document.getElementById('nav-logo-sub');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');

        function setNavbarScrolled(scrolled) {
            if (scrolled) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('bg-transparent');
                logoText.classList.remove('text-white');
                logoText.classList.add('text-gray-900');
                logoSub.classList.remove('text-white/80');
                logoSub.classList.add('text-gray-500');

                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('text-white/90');
                    link.classList.add('text-gray-700');
                });
                mobileMenuBtn.classList.remove('text-white');
                mobileMenuBtn.classList.add('text-gray-900');
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('bg-transparent');
                logoText.classList.add('text-white');
                logoText.classList.remove('text-gray-900');
                logoSub.classList.add('text-white/80');
                logoSub.classList.remove('text-gray-500');

                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.add('text-white/90');
                    link.classList.remove('text-gray-700');
                });
                mobileMenuBtn.classList.add('text-white');
                mobileMenuBtn.classList.remove('text-gray-900');
            }
        }

        const isHomePage = window.location.pathname === '/' || window.location.pathname === '';

        if (isHomePage) {
            window.addEventListener('scroll', function() {
                setNavbarScrolled(window.scrollY > 100);
            });
            setNavbarScrolled(window.scrollY > 100);
        } else {
            setNavbarScrolled(true);
        }
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        function closeMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.add('hidden');
        }
        
        // Smooth scroll for anchor links. If the target is not on the current page,
        // navigate to the homepage with the hash so the section can be shown there.
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 80;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                    return;
                }

                // If target not found on this page, redirect to homepage with hash
                // so the home page can handle scrolling to that section.
                // Prevent default so we control navigation.
                e.preventDefault();
                // Use root path '/'. If your home route is different (e.g. '/welcome'),
                // adjust accordingly.
                window.location.href = '/' + href;
            });
        });
</script>