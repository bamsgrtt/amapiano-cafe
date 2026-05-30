<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between w-full h-16">
           
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center space-x-3">
        <!-- Panggil Gambar Logo -->
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Amapiano Cafe" class="h-10 w-auto object-contain rounded-full">
        
        <!-- Teks di Samping Gambar -->
        <div class="flex flex-col leading-none">
            <span class="font-bold text-xl text-gray-800 tracking-wide">
                {{ config('app.name', 'Amapiano Cafe') }}
            </span>
            <span class="text-xs  font-medium mt-0.5 tracking-wider">
                Taste & Beats of Africa
            </span>
        </div>
    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-5 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="/" class="inline-flex items-center px-1 pt-1  border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Beranda
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1  border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Menu
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Gallery
                    </a>
                     <a href="#" class="inline-flex items-center px-3 py-2 border-2 rounded-full border-transparent text-sm font-medium leading-5 text-white bg-orange-500 hover:bg-transparent hover:text-gray-700 hover:border-orange-600 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Reservasi Sekarang
                    </a>
                     <a href="{{ Route::has('login') ? route('login') : '/login' }}" class="inline-flex items-center px-3 py-2 border-2 rounded-full border-transparent text-sm font-medium leading-5 text-white bg-orange-500 hover:bg-transparent hover:text-gray-700 hover:border-orange-600 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Login
                    </a>
                </div>
            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
