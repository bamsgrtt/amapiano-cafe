<aside id="sidebar" class="w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300 z-30 hidden md:flex">
    <div class="p-6 flex items-center space-x-3 border-b border-gray-100">
        <div class="w-10 h-10 bg-amapiano-500 rounded-full flex items-center justify-center shadow-lg">
            <i class="fas fa-music text-white"></i>
        </div>
        <div>
            <h1 class="font-display text-xl font-bold text-gray-900">Amapiano</h1>
            <p class="text-xs text-gray-500">Admin Dashboard</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        <a href="#" onclick="switchTab('dashboard')" id="nav-dashboard" class="sidebar-link active flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all group">
            <i class="fas fa-chart-pie w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Dashboard
        </a>
        <a href="#" onclick="switchTab('reservasi')" id="nav-reservasi" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
            <i class="fas fa-calendar-check w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Reservasi
        </a>
        <a href="#" onclick="switchTab('area-meja')" id="nav-area-meja" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
            <i class="fas fa-chair w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Area & Meja
        </a>
        <a href="#" onclick="switchTab('menu-promo')" id="nav-menu-promo" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
            <i class="fas fa-utensils w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Menu & Promo
        </a>
        <a href="#" onclick="switchTab('users')" id="nav-users" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
            <i class="fas fa-users w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Manajemen User
        </a>
        <div class="pt-4 pb-2 px-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan Toko</p>
        </div>
        <a href="#" onclick="switchTab('store-status')" id="nav-store-status" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
            <i class="fas fa-store w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Status Operasional
        </a>
    </nav>

    <div class="p-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
            @csrf
        </form>
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center w-full px-4 py-3 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition-all group">
            <i class="fas fa-sign-out-alt w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
            Logout
        </button>
    </div>
</aside>
