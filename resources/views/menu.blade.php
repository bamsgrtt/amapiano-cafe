<x-layouts.app title="Halaman Beranda">
    

@push('styles')
    <!-- Konfigurasi Runtime Tailwind (JavaScript) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'amapiano': {
                            50: '#fdf8f0',
                            100: '#f9eddb',
                            200: '#f2d8b3',
                            300: '#e9bc80',
                            400: '#e09a50',
                            500: '#d88234',
                            600: '#c96c2b',
                            700: '#a75525',
                            800: '#874624',
                            900: '#6f3b20',
                        },
                        'forest': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Inter', 'sans-serif'],
                        'script': ['Dancing Script', 'cursive'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS Styles -->
    <style>
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
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .card-hover {
            transition: all 0.4s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
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
        
        .menu-tab {
            transition: all 0.3s ease;
        }
        .menu-tab:hover {
            transform: translateY(-2px);
        }
        .menu-tab.active {
            background: #d88234;
            color: white;
            box-shadow: 0 4px 15px rgba(216, 130, 52, 0.4);
        }
        
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background: #d88234;
            color: white;
        }
        .step-indicator.completed {
            background: #166534;
            color: white;
        }
        
        .floating-wa {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 50;
            animation: float 3s ease-in-out infinite;
        }
        
        .wa-pulse::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            background: #25D366;
            animation: pulse-ring 1.5s ease-out infinite;
            z-index: -1;
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.4); opacity: 0; }
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
        
        .input-focus:focus {
            border-color: #d88234;
            box-shadow: 0 0 0 3px rgba(216, 130, 52, 0.15);
        }
        
        .reservation-card {
            background: linear-gradient(145deg, #ffffff 0%, #fdf8f0 100%);
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
    </style>
@endpush

    <!-- Menu Section -->
    <section id="menu" class="py-20 md:py-28 bg-amapiano-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 scroll-reveal">
                <p class="font-script text-amapiano-500 text-2xl mb-2" id="menu-subtitle">Cita Rasa Istimewa</p>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mb-4" id="menu-title">Menu Pilihan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto" id="menu-desc">Perpaduan sempurna antara cita rasa Western dan Nusantara yang disajikan dengan penuh cinta dan kreativitas.</p>
            </div>
            
                        <!-- TABS KATEGORI DINAMIS -->
            <div class="flex justify-center mb-12 scroll-reveal">
                <div class="inline-flex bg-white rounded-full p-1.5 shadow-md flex-wrap justify-center gap-1">
                    @foreach($categories as $category)
                        @php
                            // Membuat ID yang aman (huruf kecil, spasi diganti strip)
                            // Contoh: "Makanan Berat" menjadi "makanan-berat"
                            $categoryId = strtolower(str_replace(' ', '-', $category->name));
                        @endphp
                        <button 
                            class="menu-tab {{ $loop->first ? 'active' : 'text-gray-600' }} px-6 py-2.5 rounded-full text-sm font-semibold transition-all" 
                            onclick="switchMenuTab('{{ $categoryId }}')" 
                            id="tab-{{ $categoryId }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- KONTEN MENU PER KATEGORI -->
            @foreach($categories as $category)
                @php
                    $categoryId = strtolower(str_replace(' ', '-', $category->name));
                    // Filter menu items yang kategorinya cocok dengan kategori saat ini
                    $itemsInCategory = $menuItems->where('category', $category->name);
                @endphp
                
                <div id="menu-{{ $categoryId }}" class="menu-content {{ $loop->first ? '' : 'hidden' }} grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($itemsInCategory as $item)
                        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-md {{ $item->promos->isNotEmpty() ? 'ring-1 ring-amapiano-200 border border-amapiano-100' : '' }}">
                            <div class="h-48 overflow-hidden bg-gray-100">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                @if($item->promos->isNotEmpty())
                                    <div class="mb-4 flex flex-col gap-2">
                                        <span class="inline-flex items-center rounded-full bg-gradient-to-r from-amapiano-500 to-forest-500 px-3 py-1 text-[11px] uppercase tracking-[0.24em] font-bold text-white shadow-lg">Promo</span>
                                        <div class="rounded-2xl bg-amapiano-50 border border-amapiano-100 px-4 py-3">
                                            <p class="text-xs uppercase tracking-[0.2em] text-amapiano-700 font-semibold">Promo Berlaku</p>
                                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $item->promos->pluck('title')->join(' • ') }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-display text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                                    <span class="text-amapiano-600 font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-gray-500 text-sm">{{ $item->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 p-8 rounded-3xl border border-dashed border-gray-200 text-center text-gray-500">
                            Belum ada menu di kategori <strong>{{ $category->name }}</strong>. Admin dapat menambahkannya melalui dashboard.
                        </div>
                    @endforelse
                </div>
            @endforeach

            <!-- QR Menu Notice -->
            <div class="mt-16 bg-white rounded-2xl p-8 shadow-md scroll-reveal">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-20 h-20 bg-amapiano-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-10 h-10 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="font-display text-xl font-bold text-gray-900 mb-1" id="qr-menu-title">Scan QR untuk Menu Lengkap</h3>
                        <p class="text-gray-500 text-sm" id="qr-menu-desc">Di meja tersedia QR code untuk melihat menu lengkap dan memesan secara digital. Sistem pembayaran dilakukan di kasir.</p>
                    </div>
                    <div class="bg-gray-100 rounded-xl p-4 flex-shrink-0">
                        <svg class="w-24 h-24 text-gray-400" viewBox="0 0 100 100">
                            <rect x="5" y="5" width="25" height="25" rx="3" fill="currentColor" opacity="0.3"/>
                            <rect x="70" y="5" width="25" height="25" rx="3" fill="currentColor" opacity="0.3"/>
                            <rect x="5" y="70" width="25" height="25" rx="3" fill="currentColor" opacity="0.3"/>
                            <rect x="35" y="35" width="30" height="30" rx="3" fill="currentColor" opacity="0.3"/>
                            <rect x="10" y="10" width="15" height="15" rx="2" fill="currentColor"/>
                            <rect x="75" y="10" width="15" height="15" rx="2" fill="currentColor"/>
                            <rect x="10" y="75" width="15" height="15" rx="2" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('scripts')
    <script>
        // Scroll reveal animation
        function handleScrollReveal() {
            const elements = document.querySelectorAll('.scroll-reveal');
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('visible');
                }
            });
        }
        
        window.addEventListener('scroll', handleScrollReveal);
        window.addEventListener('load', handleScrollReveal);
        
        // Menu tab switching
        function switchMenuTab(tab) {
            // Hide all menu contents
            document.querySelectorAll('.menu-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.menu-tab').forEach(t => {
                t.classList.remove('active');
                t.classList.add('text-gray-600');
            });
            
            // Show selected menu
            document.getElementById('menu-' + tab).classList.remove('hidden');
            
            // Add active class to clicked tab
            document.getElementById('tab-' + tab).classList.add('active');
            document.getElementById('tab-' + tab).classList.remove('text-gray-600');
            
            // Re-trigger scroll reveal for newly visible items
            setTimeout(handleScrollReveal, 100);
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            handleScrollReveal();
        });
    </script>
@endpush

</x-layouts.app>