<x-layouts.app title="Halaman Beranda">
 <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Inter:wght@300;400;500;600;700&display=swap');

        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .font-script { font-family: 'Dancing Script', cursive; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes windmill {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
        .animate-slide-left { animation: slideInLeft 0.8s ease-out forwards; }
        .animate-slide-right { animation: slideInRight 0.8s ease-out forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-windmill { animation: windmill 8s linear infinite; }
        
        .reveal, .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.visible, .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.5) 100%);
        }
        
        .text-shadow {
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
        }
        
        .card-hover {
            transition: all 0.4s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
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
        
        .btn-outline {
            border: 2px solid #d88234;
            color: #d88234;
            background: transparent;
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            background: #d88234;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(216, 130, 52, 0.3);
        }
        
        .gallery-item {
            overflow: hidden;
            border-radius: 12px;
        }
        .gallery-item img {
            transition: transform 0.6s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #d88234;
            border-radius: 4px;
        }
        
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        @media (max-width: 768px) {
            .parallax-bg {
                background-attachment: scroll;
            }
        }

        .opt2 {
            position: relative;
            min-height: 500px;
            background: url('{{ asset('images/rule.png') }}') center/cover no-repeat;
        }

        .opt2-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(10,46,26,0.85) 0%, rgba(26,92,53,0.7) 50%, rgba(10,46,26,0.85) 100%);
        }
        .opt2-content {
            position: relative;
            z-index: 1;
            padding: 60px 40px;
        }

        .logo-dark {
            background: linear-gradient(135deg, #3d2314 0%, #2a1810 100%);
        }
        .logo-dark svg {
            color: #f9eddb;
        }
        
        .footer-section {
            background: linear-gradient(180deg, #f5efe6 0%, #e8ddd0 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #d88234 0%, #c96c2b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
<!-- Hero Section -->
    <section id="beranda" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg.png') }}" alt="Amapiano Thematic Resto & Cafe" class="w-full h-full object-cover">
            <div class="hero-gradient absolute inset-0"></div>
        </div>
        
        <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
            <div class="animate-fade-in-up">
                <p class="font-script text-2xl md:text-3xl text-amapiano-300 mb-4" id="hero-welcome">Selamat Datang di</p>
                <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 text-shadow" id="hero-title">
                    Amapiano
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-2 font-light" id="hero-subtitle">Thematic Resto & Cafe</p>
                <div class="flex items-center justify-center space-x-4 mb-8">
                    <div class="h-px w-16 bg-white/50"></div>
                    <p class="text-white/80 text-sm tracking-widest uppercase" id="hero-tagline">Rich Village • Jember</p>
                    <div class="h-px w-16 bg-white/50"></div>
                </div>
                <p class="text-white/70 text-base md:text-lg max-w-2xl mx-auto mb-10 leading-relaxed" id="hero-desc">
                    Nikmati perpaduan cita rasa Western & Nusantara dalam suasana rustic yang estetik, dikelilingi kincir angin dan taman hijau yang memukau.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ Route::has('reservation') ? route('reservation') : '/reservation' }}" class="btn-primary text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg flex items-center space-x-2" id="hero-reserve-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span id="hero-reserve-text">Reservasi Sekarang</span>
                    </a>
                    <a href="{{ Route::has('menu') ? route('menu') : '/menu' }}" class="border-2 border-white/50 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white/10 transition-all flex items-center space-x-2" id="hero-menu-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span id="hero-view-menu">Lihat Menu</span>
                    </a>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
        </div>
            <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
    </section>

    <!-- Stats Bar -->
    <section class="bg-amapiano-700 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="scroll-reveal">
                    <p class="text-3xl md:text-4xl font-display font-bold text-white" id="stat-hours">10:00-20:00</p>
                    <p class="text-amapiano-200 text-sm mt-2" id="stat-hours-label">Jam Operasional</p>
                </div>
                <div class="scroll-reveal">
                    <p class="text-3xl md:text-4xl font-display font-bold text-white" id="stat-menu">20+</p>
                    <p class="text-amapiano-200 text-sm mt-2" id="stat-menu-label">Menu Pilihan</p>
                </div>
                <div class="scroll-reveal">
                    <p class="text-3xl md:text-4xl font-display font-bold text-white" id="stat-theme">Rustic</p>
                    <p class="text-amapiano-200 text-sm mt-2" id="stat-theme-label">Tema Estetik</p>
                </div>
                <div class="scroll-reveal">
                    <p class="text-3xl md:text-4xl font-display font-bold text-white" id="stat-rating">4.8</p>
                    <p class="text-amapiano-200 text-sm mt-2" id="stat-rating-label">Rating Google</p>
                </div>
            </div>
        </div>
    </section>

        <!-- About Section -->
    <section id="tentang" class="py-20 md:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="reveal">
                    <div class="relative">
                        <img src="{{ asset('images/inter.png') }}" alt="Interior Amapiano" class="rounded-2xl shadow-2xl w-full">
                        <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-amapiano-100 rounded-2xl -z-10 hidden md:block"></div>
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-forest-100 rounded-full -z-10 hidden md:block"></div>
                        <div class="absolute top-4 right-4 animate-windmill opacity-20">
                            <svg class="w-16 h-16 text-amapiano-600" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="8" fill="currentColor"/>
                                <rect x="46" y="10" width="8" height="80" rx="2" fill="currentColor"/>
                                <rect x="10" y="46" width="80" height="8" rx="2" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="reveal">
                    <p class="font-script text-amapiano-500 text-2xl mb-3" id="about-subtitle">Cerita Kami</p>
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-6" id="about-title">
                        Tempat di Mana Rasa Bertemu Estetika
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-5" id="about-desc1">
                        Amapiano Thematic Resto & Cafe hadir di kawasan Rich Village, Jember sebagai destinasi kuliner yang memadukan cita rasa Western dan Nusantara dalam suasana rustic yang memukau.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-8" id="about-desc2">
                        Dengan desain interior bergaya Eropa yang dikelilingi taman hijau dan ikon kincir angin, kami menghadirkan pengalaman dining yang tak terlupakan. Setiap sudut cafe dirancang untuk menjadi latar sempurna bagi momen berharga Anda.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-5 mb-8">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-amapiano-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm" id="feature-hours-title">Buka Setiap Hari</p>
                                <p class="text-gray-500 text-xs" id="feature-hours-desc">10:00 - 20:00 WIB</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-forest-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm" id="feature-location-title">Rich Village</p>
                                <p class="text-gray-500 text-xs" id="feature-location-desc">Jember, Jawa Timur</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-amapiano-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm" id="feature-qr-title">QR Menu</p>
                                <p class="text-gray-500 text-xs" id="feature-qr-desc">Pesan via scan QR</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-forest-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm" id="feature-payment-title">Bayar di Kasir</p>
                                <p class="text-gray-500 text-xs" id="feature-payment-desc">Cash & Digital</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#galeri" class="btn-primary text-white px-8 py-3 rounded-full font-semibold inline-flex items-center space-x-2 shadow-md">
                        <span id="about-cta">Jelajahi Menu Kami</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="galeri" class="py-20 md:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <p class="font-script text-amapiano-500 text-2xl mb-3" id="gallery-subtitle">Suasana Kami</p>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4" id="gallery-title">Galeri Amapiano</h2>
                <p class="text-gray-600 max-w-2xl mx-auto" id="gallery-desc">Setiap sudut Amapiano dirancang untuk menciptakan pengalaman visual yang memukau dan momen yang tak terlupakan.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                <div class="gallery-item col-span-2 row-span-2 reveal">
                    <img src="{{ asset('images/g1.png') }}" alt="Amapiano Exterior" class="w-full h-full object-cover min-h-[300px]">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g2.png') }}" alt="Interior" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g3.png') }}" alt="Outdoor" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g4.png') }}" alt="Decor" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g5.png') }}" alt="Aerial View" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g6.png') }}" alt="Sunset" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g7.png') }}" alt="Pathway" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g8.png') }}" alt="Entrance" class="w-full h-48 object-cover">
                </div>
                <div class="gallery-item reveal">
                    <img src="{{ asset('images/g9.png') }}" alt="Garden" class="w-full h-48 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Rules Section -->
    <section id="aturan" class="m-0 p-0 w-full">
        <div class="opt2 w-full m-0 p-0">
            <div class="opt2-overlay"></div>
            <div class="opt2-content">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-14 reveal">
                        <p class="font-script text-forest-300 text-2xl mb-3" id="rules-subtitle">Peraturan Cafe</p>
                        <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-4" id="rules-title">Aturan & Kebijakan</h2>
                        <p class="text-forest-200 max-w-2xl mx-auto" id="rules-desc">Mohon untuk mematuhi aturan yang berlaku demi kenyamanan bersama.</p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 pb-8">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 reveal">
                            <div class="w-12 h-12 bg-amapiano-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-bold text-white mb-3" id="rule-minorder-title">Minimum Order</h3>
                            <ul class="text-forest-200 text-sm space-y-2">
                                <li>• Weekday: <span class="text-white font-semibold">Rp 40.000</span> (usia 14+)</li>
                                <li>• Weekend/Hari Libur: <span class="text-white font-semibold">Rp 60.000</span></li>
                                <li>• Anak di bawah 14 tahun: <span class="text-white font-semibold">Gratis deposit</span></li>
                            </ul>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 reveal">
                            <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-bold text-white mb-3" id="rule-outside-title">Makanan Luar</h3>
                            <p class="text-forest-200 text-sm">Denda <span class="text-white font-semibold">Rp 100.000/item</span> untuk membawa makanan dan minuman dari luar.</p>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 reveal">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-bold text-white mb-3" id="rule-pet-title">Hewan Peliharaan</h3>
                            <p class="text-forest-200 text-sm">Dilarang membawa hewan peliharaan ke dalam area cafe.</p>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 reveal">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-bold text-white mb-3" id="rule-camera-title">Kamera Profesional</h3>
                            <p class="text-forest-200 text-sm">Biaya <span class="text-white font-semibold">Rp 750.000/kamera</span> maksimal 2 jam untuk kamera profesional/drone.</p>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 reveal">
                            <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-bold text-white mb-3" id="rule-damage-title">Kerusakan Fasilitas</h3>
                            <p class="text-forest-200 text-sm">Kerusakan fasilitas menjadi tanggung jawab pribadi pengunjung.</p>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 reveal">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-bold text-white mb-3" id="rule-reserve-title">Reservasi</h3>
                            <ul class="text-forest-200 text-sm space-y-2">
                                <li>• Wajib reservasi minimal <span class="text-white font-semibold">H-1</span></li>
                                <li>• On the spot tidak dijamin dapat meja</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimoni" class="py-24 bg-amapiano-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-amapiano-300 to-transparent"></div>
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-amapiano-100/60 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-forest-100/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-amapiano-100/30 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16 reveal">
                <span class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm text-amapiano-700 px-5 py-2.5 rounded-full text-sm font-semibold mb-4 border border-amapiano-200/50 shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Ulasan Pelanggan
                </span>
                <h2 class="text-4xl md:text-5xl font-black mb-4 font-display text-gray-900">
                    Apa Kata <span class="gradient-text">Mereka</span>
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto text-base">Pengalaman nyata dari pengunjung yang sudah menikmati suasana dan cita rasa Amapiano.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 reveal">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-3xl p-8 relative border border-amapiano-100/60 shadow-sm card-hover">
                    <div class="absolute -top-3 left-8 text-6xl text-amapiano-200/80 font-serif leading-none">"</div>
                    <div class="flex gap-1 mb-5 mt-2">
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                    </div>
                    <p class="text-gray-600 mb-8 leading-relaxed text-sm">"Tempatnya sangat estetik dan nyaman! Makanan enak-enak, terutama pasta dan kopinya. Cocok banget untuk nongkrong bareng teman atau keluarga. Pelayanannya juga ramah."</p>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <div class="w-11 h-11 bg-gradient-to-br from-amapiano-400 to-amapiano-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">D</div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">Dewi Lestari</h4>
                            <p class="text-xs text-amapiano-500">Jember</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-3xl p-8 relative border border-amapiano-100/60 shadow-sm card-hover">
                    <div class="absolute -top-3 left-8 text-6xl text-forest-200/80 font-serif leading-none">"</div>
                    <div class="flex gap-1 mb-5 mt-2">
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                    </div>
                    <p class="text-gray-600 mb-8 leading-relaxed text-sm">"Suasana rustic-nya bikin betah berlama-lama. Kincir anginnya ikonik banget! Menu nusantaranya juga nggak kalah enak. Recommended place di Jember! 🌿"</p>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <div class="w-11 h-11 bg-gradient-to-br from-forest-400 to-forest-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">B</div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">Budi Santoso</h4>
                            <p class="text-xs text-forest-500">Surabaya</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-3xl p-8 relative border border-amapiano-100/60 shadow-sm card-hover">
                    <div class="absolute -top-3 left-8 text-6xl text-amapiano-200/80 font-serif leading-none">"</div>
                    <div class="flex gap-1 mb-5 mt-2">
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                        <span class="text-amapiano-400 text-lg">★</span>
                    </div>
                    <p class="text-gray-600 mb-8 leading-relaxed text-sm">"Perfect spot untuk foto-foto! Setiap sudutnya instagramable. Makanannya juga delicious, especially the desserts. Pasti bakal balik lagi! 📸"</p>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <div class="w-11 h-11 bg-gradient-to-br from-amapiano-300 to-amapiano-500 rounded-full flex items-center justify-center text-white font-bold shadow-md">R</div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">Rina Wijaya</h4>
                            <p class="text-xs text-amapiano-500">Malang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="lokasi" class="py-20 md:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <p class="font-script text-amapiano-500 text-2xl mb-3" id="location-subtitle">Temukan Kami</p>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4" id="location-title">Lokasi & Kontak</h2>
                <p class="text-gray-600 max-w-2xl mx-auto" id="location-desc">Kunjungi Amapiano Thematic Resto & Cafe di kawasan Rich Village, Jember.</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-10">
                <!-- Map -->
                <div class="reveal">
                    <div class="rounded-2xl overflow-hidden shadow-xl h-[400px]">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31688.58468988349!2d113.6866!3d-8.1735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd695b7e5d3b3b3%3A0x3030c0c0c0c0c0c0!2sJember%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="rounded-2xl">
                        </iframe>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="reveal space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-amapiano-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-bold text-gray-900 mb-1" id="contact-address-title">Alamat</h3>
                                <p class="text-gray-600 text-sm" id="contact-address">Rich Village, Jember, Jawa Timur</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-forest-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-bold text-gray-900 mb-1" id="contact-hours-title">Jam Operasional</h3>
                                <p class="text-gray-600 text-sm" id="contact-hours">Setiap Hari: 10:00 - 20:00 WIB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-bold text-gray-900 mb-1" id="contact-wa-title">WhatsApp</h3>
                                <p class="text-gray-600 text-sm mb-3" id="contact-wa">Reservasi & Pertanyaan</p>
                                <a href="https://wa.me/6281542333979" target="_blank" class="inline-flex items-center space-x-2 bg-green-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    <span id="contact-wa-btn">Chat Sekarang</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-bold text-gray-900 mb-1" id="contact-ig-title">Instagram</h3>
                                <p class="text-gray-600 text-sm mb-2" id="contact-ig-desc">Follow untuk info terbaru</p>
                                <a href="https://instagram.com/amapiano.cafe" target="_blank" class="text-pink-500 font-semibold text-sm hover:text-pink-600 transition-colors" id="contact-ig-link">@amapiano.cafe</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/g6.png') }}" alt="Amapiano Sunset" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-amapiano-900/70"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center reveal">
            <p class="font-script text-amapiano-300 text-2xl mb-4" id="cta-subtitle">Jangan Lewatkan</p>
            <h2 class="font-display text-3xl md:text-5xl font-bold text-white mb-6" id="cta-title">Kunjungi Kami Sekarang</h2>
            <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto" id="cta-desc">Nikmati pengalaman dining yang tak terlupakan di Amapiano Thematic Resto & Cafe. Kami tunggu kehadiran Anda!</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#lokasi" class="btn-primary text-white px-10 py-4 rounded-full text-lg font-semibold shadow-lg" id="cta-reserve-btn">
                    Lihat Lokasi
                </a>
                <a href="https://wa.me/6281542333979" target="_blank" class="bg-green-500 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-green-600 transition-all flex items-center space-x-2 shadow-lg" id="cta-wa-btn">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <span>Chat WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const reveals = document.querySelectorAll(".reveal, .scroll-reveal");
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target);
                    }
                });
            }, { 
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            });
            reveals.forEach(reveal => observer.observe(reveal));
        });
    </script>
    @endpush
</x-layouts.app>
