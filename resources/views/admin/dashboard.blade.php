<x-layouts.dashboard title="Admin Dashboard">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-20">
                <div class="flex items-center">
                    <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-amapiano-500 mr-4">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 id="page-title" class="font-display text-xl font-bold text-gray-900">Dashboard Overview</h2>
                </div>
                
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex items-center {{ $storeOpen ? 'bg-forest-100' : 'bg-red-100' }} px-3 py-1.5 rounded-full" id="store-status-badge-container">
                        <div id="store-status-badge" class="w-2.5 h-2.5 rounded-full {{ $storeOpen ? 'bg-forest-500' : 'bg-red-500' }} mr-2 animate-pulse"></div>
                        <span id="store-status-text" class="text-xs font-semibold {{ $storeOpen ? 'text-forest-800' : 'text-red-800' }}">{{ $storeOpen ? 'Buka' : 'Tutup' }}</span>
                    </div>
                    <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=d88234&color=fff" alt="Admin" class="w-9 h-9 rounded-full ring-2 ring-amapiano-100">
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Super Admin</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 relative">
                
                <!-- DASHBOARD TAB -->
                <div id="tab-dashboard" class="tab-content fade-in space-y-6">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-amapiano-100 rounded-xl flex items-center justify-center text-amapiano-600">
                                    <i class="fas fa-calendar-check text-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-display font-bold text-gray-900">{{ $totalReservationsMonth }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Total Reservasi Bulan Ini</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                    <i class="fas fa-walking text-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-display font-bold text-gray-900">{{ $checkinsToday }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Check-in Hari Ini</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                                    <i class="fas fa-chair text-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-display font-bold text-gray-900">{{ $occupancyRate }}%</h3>
                            <p class="text-sm text-gray-500 mt-1">Okupansi Meja Hari Ini</p>
                        </div>
                        {{-- Revenue: Daily --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-forest-100 rounded-xl flex items-center justify-center text-forest-600">
                                    <i class="fas fa-money-bill-wave text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold bg-forest-50 text-forest-700 px-2 py-1 rounded-full">Hari Ini</span>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $estimatedRevenue }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Estimasi Pendapatan</p>
                        </div>
                        {{-- Revenue: Weekly --}}
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                                    <i class="fas fa-chart-line text-xl"></i>
                                </div>
                                <span class="text-xs font-semibold bg-amber-50 text-amber-700 px-2 py-1 rounded-full">Minggu Ini</span>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $estimatedRevenueWeek }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Estimasi Pendapatan</p>
                        </div>
                    </div>

                    {{-- Revenue: Monthly (full width row) --}}
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex items-center gap-5">
                        <div class="w-12 h-12 shrink-0 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estimasi Pendapatan</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-display font-bold text-gray-900">{{ $estimatedRevenueMonth }}</span>
                                <span class="text-xs font-semibold bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full">Bulan Ini</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">Weekday Rp 40.000 / Weekend Rp 60.000 per tamu check-in</p>
                        </div>
                    </div>


                    <!-- Charts & Recent -->
                    <div class="grid lg:grid-cols-3 gap-6">
                        <!-- Chart -->
                        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-display text-lg font-bold text-gray-900">Tren Reservasi (7 Hari Terakhir)</h3>
                            </div>
                            <div class="h-72">
                                <canvas id="reservationChart"></canvas>
                            </div>
                        </div>

                        <!-- Area Popularity (Static details mapping to correct terms) -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-display text-lg font-bold text-gray-900 mb-6">Kapasitas Area</h3>
                            <div class="space-y-5">
                                <div>
                                    <div class="flex justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-gray-700">Main Hall (Hoof Barn)</span>
                                        <span class="text-sm font-bold text-amapiano-600">8 Meja</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                                        <div class="bg-amapiano-500 h-2.5 rounded-full" style="width: 80%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-gray-700">The Garden Terrace (Covent Garden)</span>
                                        <span class="text-sm font-bold text-amapiano-600">10 Meja</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                                        <div class="bg-amapiano-500 h-2.5 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-gray-700">Orchestra VIP Suite (Limburg)</span>
                                        <span class="text-sm font-bold text-amapiano-600">7 Meja</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                                        <div class="bg-amapiano-500 h-2.5 rounded-full" style="width: 70%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RESERVASI TAB -->
                <div id="tab-reservasi" class="tab-content hidden fade-in space-y-6">
                    @if(session('success_reservation'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success_reservation') }}
                        </div>
                    @endif
                    @if(session('error_reservation'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            {{ session('error_reservation') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                        <input type="hidden" name="tab" value="reservasi">
                        <div class="relative w-full md:w-96">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode reservasi..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amapiano-500 focus:border-transparent text-sm">
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <button type="submit" class="bg-amapiano-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-amapiano-600 transition-all flex items-center">
                                <i class="fas fa-filter mr-2"></i> Cari & Filter
                            </button>
                        </div>
                    </form>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4">Kode</th>
                                        <th class="px-6 py-4">Nama Tamu</th>
                                        <th class="px-6 py-4">Waktu</th>
                                        <th class="px-6 py-4">Tamu</th>
                                        <th class="px-6 py-4">Area / Meja</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($reservations as $res)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 font-mono font-bold text-gray-700">#{{ $res->code }}</td>
                                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $res->fullname }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($res->date)->translatedFormat('d M Y') }} • {{ $res->time }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $res->guests }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $res->area }} / {{ strtoupper($res->table_id) }}</td>
                                            <td class="px-6 py-4">
                                                @if($res->status === 'checked_in')
                                                    <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Checked In</span>
                                                @elseif($res->status === 'cancelled')
                                                    <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Cancelled</span>
                                                @else
                                                    <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                @if($res->status === 'pending')
                                                    <div class="flex items-center justify-end gap-2">
                                                        <form action="{{ route('admin.reservations.status', $res->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="checked_in">
                                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2.5 py-1 rounded text-xs font-bold transition-all shadow-sm">Check-in</button>
                                                        </form>
                                                        <form action="{{ route('admin.reservations.status', $res->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                            @csrf
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1 rounded text-xs font-bold transition-all shadow-sm">Cancel</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada reservasi ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($reservations->hasPages())
                            <div class="p-4 border-t border-gray-100">
                                {{ $reservations->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- AREA & MEJA TAB -->
                <div id="tab-area-meja" class="tab-content hidden fade-in space-y-6">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Area 1 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <h4 class="font-display text-lg font-bold text-gray-900 mb-2">Main Hall (Hoof Barn)</h4>
                            <p class="text-sm text-gray-500 mb-4">Area barn rustic dengan interior kayu, dekorasi vintage, dan panggung live music.</p>
                            <span class="text-xs font-semibold bg-orange-50 text-orange-600 px-3 py-1 rounded-full">8 Meja Terdaftar</span>
                        </div>
                        <!-- Area 2 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <h4 class="font-display text-lg font-bold text-gray-900 mb-2">The Garden Terrace (Covent Garden)</h4>
                            <p class="text-sm text-gray-500 mb-4">Area outdoor garden asri dengan taman hijau yang memukau dan kincir angin.</p>
                            <span class="text-xs font-semibold bg-orange-50 text-orange-600 px-3 py-1 rounded-full">10 Meja Terdaftar</span>
                        </div>
                        <!-- Area 3 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <h4 class="font-display text-lg font-bold text-gray-900 mb-2">Orchestra VIP Suite (Limburg)</h4>
                            <p class="text-sm text-gray-500 mb-4">Ruang indoor VIP bergaya Eropa klasik yang elegan, tenang, dan privat.</p>
                            <span class="text-xs font-semibold bg-orange-50 text-orange-600 px-3 py-1 rounded-full">7 Meja Terdaftar</span>
                        </div>
                    </div>
                </div>

                                <!-- MENU & PROMO TAB -->
                <div id="tab-menu-promo" class="tab-content hidden fade-in space-y-6">
                    @if(session('success_menu'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success_menu') }}
                        </div>
                    @endif
                    @if(session('success_promo'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success_promo') }}
                        </div>
                    @endif
                    @if(session('success_category'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success_category') }}
                        </div>
                    @endif

                    <!-- Kategori Section -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="font-display text-lg font-bold text-gray-900">Kelola Kategori Menu</h3>
                                <p class="text-sm text-gray-500">Tambahkan atau hapus kategori untuk mengelompokkan menu agar lebih rapi.</p>
                            </div>
                            <button onclick="openModal('modal-add-category')" class="bg-forest-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-forest-600 transition-all flex items-center shadow-md">
                                <i class="fas fa-plus mr-2"></i> Tambah Kategori
                            </button>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            @forelse($categories ?? [] as $category)
                                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 group hover:shadow-md hover:border-amapiano-300 transition-all">
                                    <i class="fas fa-tag text-amapiano-500 mr-2 text-sm"></i>
                                    <span class="font-semibold text-gray-800 mr-3">{{ $category->name }}</span>
                                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Hapus Kategori">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="w-full py-4 text-center border-2 border-dashed border-gray-200 rounded-xl">
                                    <p class="text-sm text-gray-500">Belum ada kategori. Klik tombol di atas untuk menambahkan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Kelola Menu -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="font-display text-lg font-bold text-gray-900">Kelola Menu</h3>
                                    <p class="text-sm text-gray-500">Tambahkan, edit, atau hapus daftar menu yang akan ditampilkan.</p>
                                </div>
                                <button onclick="openMenuModal()" class="bg-amapiano-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-amapiano-600 transition-all flex items-center shadow-md">
                                    <i class="fas fa-plus mr-2"></i> Tambah Menu
                                </button>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                @forelse($menuItems as $item)
                                    <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all">
                                        <div class="h-40 overflow-hidden bg-gray-100">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="p-4">
                                            <div class="flex items-start justify-between gap-3 mb-3">
                                                <span class="px-2.5 py-1 text-xs font-bold uppercase tracking-wide bg-amapiano-100 text-amapiano-700 rounded-full">{{ $item->category }}</span>
                                                <span class="text-amapiano-600 font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            </div>
                                            <h4 class="font-display text-base font-bold text-gray-900">{{ $item->name }}</h4>
                                            <p class="text-gray-500 text-sm mt-2">{{ $item->description }}</p>
                                            <div class="mt-4 flex items-center gap-2">
                                                <button type="button" onclick='openMenuModal({{ json_encode($item) }})' class="text-amapiano-600 text-xs font-semibold uppercase tracking-wide hover:text-amapiano-700">Edit</button>
                                                <form action="{{ route('admin.menu-items.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item menu ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 text-xs font-semibold uppercase tracking-wide hover:text-red-700">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-2 p-6 rounded-2xl border border-dashed border-gray-200 text-center text-gray-500">
                                        Belum ada item menu. Tambahkan menu baru untuk ditampilkan.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Kelola Promo -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="font-display text-lg font-bold text-gray-900">Kelola Promo</h3>
                                    <p class="text-sm text-gray-500">Tambahkan tawaran promosi baru yang muncul di halaman menu.</p>
                                </div>
                                <button onclick="openPromoModal()" class="bg-forest-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-forest-600 transition-all flex items-center shadow-md">
                                    <i class="fas fa-plus mr-2"></i> Tambah Promo
                                </button>
                            </div>

                            <div class="grid gap-4">
                                @forelse($promoItems as $promo)
                                    <div class="rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-all">
                                        <div class="flex items-center justify-between gap-3 mb-3">
                                            <span class="text-xs font-bold uppercase tracking-wide bg-green-100 text-forest-600 px-2.5 py-1 rounded-full">{{ $promo->type }}</span>
                                            <span class="text-sm text-gray-500">S/d {{ $promo->end_date->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <h4 class="font-display text-base font-bold text-gray-900">{{ $promo->title }}</h4>
                                        <p class="text-gray-500 text-sm mt-2">{{ $promo->description }}</p>
                                        @if($promo->menuItems->isNotEmpty())
                                            <div class="mt-3 pt-3 border-t border-gray-100">
                                                <p class="text-xs font-semibold text-gray-600 mb-2">Menu yang dapat promo:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($promo->menuItems as $menuItem)
                                                        <span class="text-xs bg-forest-50 text-forest-700 px-2 py-1 rounded-lg">{{ $menuItem->name }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <div class="mt-4 flex items-center gap-3">
                                            <button type="button" onclick='openPromoModal({{ json_encode($promo->load("menuItems")) }})' class="text-amapiano-600 text-xs font-semibold uppercase tracking-wide hover:text-amapiano-700">Edit</button>
                                            <form action="{{ route('admin.promos.delete', $promo->id) }}" method="POST" onsubmit="return confirm('Hapus promo ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-xs font-semibold uppercase tracking-wide hover:text-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 rounded-2xl border border-dashed border-gray-200 text-center text-gray-500">
                                        Belum ada promo aktif. Tambahkan promo agar pelanggan mendapat informasi terbaru.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- USERS TAB -->
                <div id="tab-users" class="tab-content hidden fade-in space-y-6">
                     @if(session('success_user'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success_user') }}
                        </div>
                     @endif
                     @if($errors->has('error_user'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            {{ $errors->first('error_user') }}
                        </div>
                     @endif
                     <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                            <h3 class="font-display text-lg font-bold text-gray-900">Manajemen Staff & Admin</h3>
                            <button onclick="openModal('modal-add-user')" class="bg-amapiano-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-amapiano-600 transition-all flex items-center">
                                <i class="fas fa-user-plus mr-2"></i> Tambah User
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 font-medium">
                                    <tr>
                                        <th class="px-6 py-4">Nama</th>
                                        <th class="px-6 py-4">Role</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($users as $u)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-amapiano-100 flex items-center justify-center text-amapiano-700 font-bold text-xs mr-3">
                                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                                     </div>
                                                     <div>
                                                         <p class="font-semibold text-gray-900">{{ $u->name }}</p>
                                                         <p class="text-xs text-gray-500">{{ $u->email }}</p>
                                                     </div>
                                                 </div>
                                             </td>
                                             <td class="px-6 py-4">
                                                 <span class="px-2.5 py-1 bg-{{ $u->role === 'admin' ? 'purple' : 'blue' }}-50 text-{{ $u->role === 'admin' ? 'purple' : 'blue' }}-600 rounded-full text-xs font-bold border border-{{ $u->role === 'admin' ? 'purple' : 'blue' }}-100">
                                                     {{ $u->role === 'admin' ? 'Admin' : 'Staff' }}
                                                 </span>
                                             </td>
                                             <td class="px-6 py-4"><span class="text-forest-600 font-bold text-xs">Aktif</span></td>
                                             <td class="px-6 py-4 text-right">
                                                 @if($u->id !== Auth::user()->id)
                                                     <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="inline">
                                                         @csrf
                                                         @method('DELETE')
                                                         <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs"><i class="fas fa-trash-alt mr-1"></i>Hapus</button>
                                                     </form>
                                                 @else
                                                     <span class="text-gray-400 text-xs font-medium">Akun Anda</span>
                                                 @endif
                                             </td>
                                         </tr>
                                     @endforeach
                                 </tbody>
                            </table>
                        </div>
                     </div>
                </div>

                <!-- STORE STATUS TAB -->
                <div id="tab-store-status" class="tab-content hidden fade-in space-y-8">
                    
                    <!-- Status Header Card -->
                    <div class="relative overflow-hidden rounded-3xl shadow-lg border border-gray-100 bg-gradient-to-br {{ $storeOpen ? 'from-forest-50 to-emerald-50 via-white' : 'from-red-50 to-rose-50 via-white' }}">
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-40 h-40 rounded-full {{ $storeOpen ? 'bg-forest-100/50' : 'bg-red-100/50' }} blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-48 h-48 rounded-full {{ $storeOpen ? 'bg-forest-200/30' : 'bg-red-200/30' }} blur-3xl"></div>
                        
                        <div class="relative p-8 lg:p-10">
                            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
                                <!-- Status Icon -->
                                <div class="flex-shrink-0">
                                    <div class="relative">
                                        <div class="absolute inset-0 rounded-full {{ $storeOpen ? 'bg-forest-400' : 'bg-red-400' }} animate-ping opacity-20"></div>
                                        <div class="relative w-24 h-24 rounded-full {{ $storeOpen ? 'bg-gradient-to-br from-forest-400 to-forest-600' : 'bg-gradient-to-br from-red-400 to-red-600' }} flex items-center justify-center shadow-xl">
                                            <i class="fas fa-store text-4xl text-white"></i>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center">
                                            <div class="w-3 h-3 rounded-full {{ $storeOpen ? 'bg-forest-500' : 'bg-red-500' }} animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Info -->
                                <div class="flex-1 text-center lg:text-left">
                                    <div class="inline-flex items-center px-4 py-1.5 rounded-full {{ $storeOpen ? 'bg-forest-100 text-forest-700' : 'bg-red-100 text-red-700' }} mb-4">
                                        <span class="w-2 h-2 rounded-full {{ $storeOpen ? 'bg-forest-500' : 'bg-red-500' }} mr-2 animate-pulse"></span>
                                        <span class="text-sm font-bold">{{ $storeOpen ? 'Cafe Sedang Buka' : 'Cafe Sedang Tutup' }}</span>
                                    </div>
                                    <h2 class="font-display text-3xl lg:text-4xl font-bold text-gray-900 mb-3">Status Operasional</h2>
                                    <p class="text-gray-600 text-lg leading-relaxed max-w-xl mx-auto lg:mx-0">
                                        Kelola jadwal operasional cafe. Reservasi otomatis dinonaktifkan saat cafe dalam status tutup.
                                    </p>
                                </div>

                                <!-- Quick Stats -->
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <div class="bg-white/80 backdrop-blur rounded-2xl px-6 py-4 shadow-sm border border-white/50 text-center">
                                        <p class="text-xs text-gray-500 font-medium mb-1">Jadwal Khusus</p>
                                        <p class="text-2xl font-display font-bold text-gray-900">{{ $storeOperationalDates->count() }}</p>
                                    </div>
                                    <div class="bg-white/80 backdrop-blur rounded-2xl px-6 py-4 shadow-sm border border-white/50 text-center">
                                        <p class="text-xs text-gray-500 font-medium mb-1">Status Hari Ini</p>
                                        <p class="text-2xl font-display font-bold {{ $storeOpen ? 'text-forest-600' : 'text-red-600' }}">{{ $storeOpen ? 'Buka' : 'Tutup' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Cards Grid -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Info Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="h-1.5 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-display text-lg font-bold text-gray-900 mb-2">Pengaturan Jadwal</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            Status operasional ditentukan melalui jadwal tanggal khusus. Tambahkan tanggal untuk menutup atau membuka cafe pada hari tertentu.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Warning Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="h-1.5 bg-gradient-to-r from-amber-400 to-orange-500"></div>
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-amber-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-display text-lg font-bold text-gray-900 mb-2">Mode Maintenance</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            Jika cafe sedang libur atau renovasi, atur jadwal tutup. Reservasi yang sudah dikonfirmasi tetap berlaku dan tidak terpengaruh.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Schedule Form -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-red-500 to-rose-500 p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                                    <i class="fas fa-calendar-plus text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-display text-xl font-bold text-white">Tutup Cafe untuk Rentang Tanggal</h3>
                                    <p class="text-white/80 text-sm mt-1">Pilih tanggal mulai dan selesai untuk menutup cafe secara otomatis</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 lg:p-8">
                            @if(session('success_store_schedule'))
                                <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
                                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                    <p class="text-sm text-green-700 font-medium">{{ session('success_store_schedule') }}</p>
                                </div>
                            @endif
                            @if($errors->has('date') || $errors->has('status'))
                                <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                                    <i class="fas fa-times-circle text-red-500 text-lg"></i>
                                    <p class="text-sm text-red-700 font-medium">{{ $errors->first('date') ?: $errors->first('status') }}</p>
                                </div>
                            @endif

                            <form action="{{ route('admin.store.schedule') }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-700">
                                            <i class="fas fa-calendar-alt text-red-400 mr-2"></i>Tanggal Mulai
                                        </label>
                                        <input type="date" name="start_date" class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-100 focus:border-red-500 outline-none transition-all text-gray-700 font-medium" min="{{ now()->toDateString() }}" required>
                                    </div>
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-700">
                                            <i class="fas fa-calendar-check text-red-400 mr-2"></i>Tanggal Selesai
                                        </label>
                                        <input type="date" name="end_date" class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-red-100 focus:border-red-500 outline-none transition-all text-gray-700 font-medium" min="{{ now()->toDateString() }}" required>
                                    </div>
                                </div>
                                <div class="flex justify-end pt-2">
                                    <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-xl font-bold hover:from-red-600 hover:to-rose-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-lock mr-2"></i>
                                        Tutup Cafe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Schedule Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 lg:p-8 border-b border-gray-100">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-forest-50 flex items-center justify-center">
                                        <i class="fas fa-list-alt text-forest-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-display text-xl font-bold text-gray-900">Jadwal Operasional Khusus</h3>
                                        <p class="text-sm text-gray-500 mt-1">Daftar tanggal dengan pengaturan status khusus</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-xl">
                                    <i class="fas fa-database text-gray-400 text-sm"></i>
                                    <span class="text-sm font-semibold text-gray-600">Total: <span class="text-forest-600">{{ $storeOperationalDates->count() }}</span> jadwal</span>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>Tanggal
                                        </th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-toggle-on text-gray-400 mr-2"></i>Status
                                        </th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                            <i class="fas fa-cog text-gray-400 mr-2"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($storeOperationalDates as $schedule)
                                        <tr class="hover:bg-gray-50 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                                        <i class="fas fa-calendar-day text-gray-500"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900">{{ $schedule->date->translatedFormat('d M Y') }}</p>
                                                        <p class="text-xs text-gray-500 mt-0.5">{{ $schedule->date->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl {{ $schedule->is_open ? 'bg-forest-50 text-forest-700 border border-forest-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                                    <div class="w-2 h-2 rounded-full {{ $schedule->is_open ? 'bg-forest-500' : 'bg-red-500' }} animate-pulse"></div>
                                                    <span class="text-sm font-bold">{{ $schedule->status_label }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-right">
                                                <form action="{{ route('admin.store.schedule.delete', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal operasional tanggal ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-sm font-semibold hover:bg-red-100 hover:text-red-700 transition-all group/delete">
                                                        <i class="fas fa-trash-alt group-hover/delete:scale-110 transition-transform"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-16 text-center">
                                                <div class="max-w-sm mx-auto">
                                                    <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                                        <i class="fas fa-calendar-xmark text-gray-400 text-3xl"></i>
                                                    </div>
                                                    <h4 class="font-display text-lg font-bold text-gray-700 mb-2">Belum ada jadwal</h4>
                                                    <p class="text-sm text-gray-500 leading-relaxed">
                                                        Tambahkan tanggal di atas untuk menutup atau membuka cafe secara khusus pada hari tertentu.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <!-- MODALS -->
    <!-- Modal Add User -->
    <div id="modal-add-user" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-add-user')"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-200 p-6 m-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-display text-lg font-bold text-gray-900">Tambah User Baru</h3>
                <button onclick="closeModal('modal-add-user')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none" placeholder="Nama Lengkap">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none" placeholder="email@amapiano.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none" placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-amapiano-500 text-white py-3 rounded-xl font-bold hover:bg-amapiano-600 transition-colors">Simpan User</button>
            </form>
        </div>
    </div>

    <!-- Modal Add Promo -->
    <div id="modal-add-promo" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-add-promo')"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl relative z-10 transform scale-95 transition-transform duration-200 p-6 m-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6 sticky top-0 bg-white">
                <h3 class="font-display text-lg font-bold text-gray-900" id="promo-modal-title">Buat Promo / Event</h3>
                <button onclick="closeModal('modal-add-promo')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form id="promo-form" action="{{ route('admin.promos.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="POST" id="promo-form-method">
                <input type="hidden" name="promo_id" id="promo-id">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Promo</label>
                    <input type="text" name="title" id="promo-title" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none" placeholder="Contoh: Weekend Special">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mulai</label>
                        <input type="date" name="start" id="promo-start" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Selesai</label>
                        <input type="date" name="end" id="promo-end" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="promo-description" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none" rows="3" placeholder="Deskripsi..."></textarea>
                </div>

                <!-- Menu Items Selection (hidden for events) -->
                <div id="promo-menu-items-section" class="hidden space-y-3">
                    <label class="block text-sm font-semibold text-gray-700">Pilih Menu yang Dapat Promo</label>
                    <p class="text-xs text-gray-500 mb-3">Pilih menu mana saja yang akan mendapat promo ini:</p>
                    <div id="promo-menu-items-list" class="border border-gray-200 rounded-xl max-h-48 overflow-y-auto p-3 space-y-2 bg-gray-50">
                        @forelse($allMenuItems as $item)
                            <label class="flex items-center p-2 hover:bg-white rounded-lg cursor-pointer transition-colors">
                                <input type="checkbox" name="menu_items[]" value="{{ $item->id }}" class="menu-item-checkbox mr-3 w-4 h-4 text-forest-500 rounded">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->category }} • Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada menu. Tambahkan menu terlebih dahulu.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" id="promo-submit-button" class="w-full bg-forest-500 text-white py-3 rounded-xl font-bold hover:bg-forest-600 transition-colors">Publikasikan Promo</button>
            </form>
        </div>
    </div>

    <!-- Modal Add Menu Item -->
    <div id="modal-add-menu-item" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-add-menu-item')"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-200 p-6 m-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-display text-lg font-bold text-gray-900" id="menu-modal-title">Tambah Menu Item</h3>
                <button onclick="closeModal('modal-add-menu-item')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form id="menu-form" action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="POST" id="menu-form-method">
                <input type="hidden" name="menu_item_id" id="menu-item-id">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu</label>
                    <input type="text" name="name" id="menu-name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none" placeholder="Contoh: Nasi Goreng Spesial">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category" id="menu-category" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none">
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        @else
                            <!-- Fallback jika data kategori belum ada di controller -->
                            <option value="Western">Western</option>
                            <option value="Nusantara">Nusantara</option>
                            <option value="Drinks">Drinks</option>
                            <option value="Desserts">Desserts</option>
                        @endif
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                        <input type="number" name="price" id="menu-price" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none" placeholder="48000">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto</label>
                        <input type="file" name="photo" id="menu-photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amapiano-50 file:text-amapiano-700 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="menu-description" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amapiano-500 outline-none" rows="3" placeholder="Deskripsi menu..."></textarea>
                </div>
                <button type="submit" id="menu-submit-button" class="w-full bg-amapiano-500 text-white py-3 rounded-xl font-bold hover:bg-amapiano-600 transition-colors">Simpan Menu</button>
            </form>
        </div>
    </div>

    <!-- Modal Add Category -->
    <div id="modal-add-category" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-add-category')"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-200 p-6 m-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-display text-lg font-bold text-gray-900">Tambah Kategori Baru</h3>
                <button onclick="closeModal('modal-add-category')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none" placeholder="Contoh: Makanan Berat, Minuman, Snack">
                </div>
                <button type="submit" class="w-full bg-forest-500 text-white py-3 rounded-xl font-bold hover:bg-forest-600 transition-colors">Simpan Kategori</button>
            </form>
        </div>
    </div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Tab Switching Logic
        function switchTab(tabId) {
            // Update Sidebar
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('active');
                link.classList.add('text-gray-600');
            });
            const activeLink = document.getElementById('nav-' + tabId);
            if(activeLink) {
                activeLink.classList.add('active');
                activeLink.classList.remove('text-gray-600');
            }

            // Update Content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('tab-' + tabId).classList.remove('hidden');

            // Update Title
            const titles = {
                'dashboard': 'Dashboard Overview',
                'reservasi': 'Manajemen Reservasi',
                'area-meja': 'Area & Meja Cafe',
                'menu-promo': 'Menu & Promo',
                'users': 'Manajemen User',
                'store-status': 'Status Operasional'
            };
            document.getElementById('page-title').textContent = titles[tabId] || 'Dashboard';

            // Mobile close sidebar
            if(window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('hidden');
            }
        }

        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('h-full');
        });

        // Modal Logic
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('div.relative').classList.remove('scale-95');
            modal.querySelector('div.relative').classList.add('scale-100');
            document.body.classList.add('modal-active');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('div.relative').classList.add('scale-95');
            modal.querySelector('div.relative').classList.remove('scale-100');
            document.body.classList.remove('modal-active');
        }

                function resetMenuForm() {
            document.getElementById('menu-modal-title').textContent = 'Tambah Menu Item';
            document.getElementById('menu-form').action = '{{ route('admin.menu-items.store') }}';
            document.getElementById('menu-form-method').value = 'POST';
            document.getElementById('menu-item-id').value = '';
            document.getElementById('menu-name').value = '';
            
            // Reset kategori ke pilihan pertama yang tersedia secara dinamis
            const catSelect = document.getElementById('menu-category');
            if (catSelect && catSelect.options.length > 0) {
                catSelect.selectedIndex = 0;
            }
            
            document.getElementById('menu-price').value = '';
            document.getElementById('menu-description').value = '';
            document.getElementById('menu-photo').value = '';
            document.getElementById('menu-submit-button').textContent = 'Simpan Menu';
        }
        function openMenuModal(item = null) {
            resetMenuForm();

            if (item) {
                document.getElementById('menu-modal-title').textContent = 'Edit Menu Item';
                document.getElementById('menu-form').action = '/admin/menu-items/' + item.id;
                document.getElementById('menu-form-method').value = 'PUT';
                document.getElementById('menu-item-id').value = item.id;
                document.getElementById('menu-name').value = item.name;
                document.getElementById('menu-category').value = item.category;
                document.getElementById('menu-price').value = item.price;
                document.getElementById('menu-description').value = item.description;
                document.getElementById('menu-submit-button').textContent = 'Perbarui Menu';
            }

            const modal = document.getElementById('modal-add-menu-item');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('div.relative').classList.remove('scale-95');
            modal.querySelector('div.relative').classList.add('scale-100');
            document.body.classList.add('modal-active');
        }

                function resetPromoForm() {
            document.getElementById('promo-modal-title').textContent = 'Tambah Promo';
            document.getElementById('promo-form').action = '{{ route('admin.promos.store') }}';
            document.getElementById('promo-form-method').value = 'POST';
            document.getElementById('promo-id').value = '';
            document.getElementById('promo-title').value = '';
            document.getElementById('promo-start').value = '';
            document.getElementById('promo-end').value = '';
            document.getElementById('promo-description').value = '';
            document.querySelectorAll('.menu-item-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('promo-submit-button').textContent = 'Publikasikan Promo';
            
            // Pastikan bagian pilih menu selalu terlihat (karena logika 'tipe' sudah dihapus)
            const menuSection = document.getElementById('promo-menu-items-section');
            if (menuSection) {
                menuSection.classList.remove('hidden');
            }
        }

        function togglePromoMenuItems() {
            const promoType = document.getElementById('promo-type').value;
            const section = document.getElementById('promo-menu-items-section');
            if (promoType === 'Event / Live Music') {
                section.classList.add('hidden');
                document.querySelectorAll('.menu-item-checkbox').forEach(cb => cb.checked = false);
            } else {
                section.classList.remove('hidden');
            }
        }

        function openPromoModal(promo = null) {
            resetPromoForm();

            if (promo) {
                document.getElementById('promo-modal-title').textContent = 'Edit Promo';
                document.getElementById('promo-form').action = '/admin/promos/' + promo.id;
                document.getElementById('promo-form-method').value = 'PUT';
                document.getElementById('promo-id').value = promo.id;
                document.getElementById('promo-title').value = promo.title;
                document.getElementById('promo-start').value = promo.start_date ?? promo.start;
                document.getElementById('promo-end').value = promo.end_date ?? promo.end;
                document.getElementById('promo-description').value = promo.description;
                document.getElementById('promo-submit-button').textContent = 'Perbarui Promo';
                
                // Centang menu yang terkait jika sedang mode edit
                if (promo.menu_items && promo.menu_items.length > 0) {
                    promo.menu_items.forEach(item => {
                        const checkbox = document.querySelector(`input[value="${item.id}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                }
            }

            // Tampilkan Modal
            const modal = document.getElementById('modal-add-promo');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('div.relative').classList.remove('scale-95');
            modal.querySelector('div.relative').classList.add('scale-100');
            document.body.classList.add('modal-active');
        }


        // Initialize Chart with dynamic database values
        document.addEventListener('DOMContentLoaded', function() {
            // Keep tab open if active
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            if (activeTab) {
                switchTab(activeTab);
            }

            const ctx = document.getElementById('reservationChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Reservasi',
                        data: {!! json_encode($chartReservations) !!},
                        borderColor: '#d88234',
                        backgroundColor: 'rgba(216, 130, 52, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#d88234',
                        pointRadius: 4
                    }, {
                        label: 'Check-in',
                        data: {!! json_encode($chartCheckins) !!},
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.0)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        borderDash: [5, 5],
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#22c55e',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8 } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
@endpush
</x-layouts.dashboard>