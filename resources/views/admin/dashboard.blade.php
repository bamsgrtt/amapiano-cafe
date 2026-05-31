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
                <a href="#" onclick="switchTab('promo-event')" id="nav-promo-event" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
                    <i class="fas fa-gift w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                    Promo & Event
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

                <!-- PROMO & EVENT TAB -->
                <div id="tab-promo-event" class="tab-content hidden fade-in space-y-6">
                    @if(session('success_promo'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success_promo') }}
                        </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <h3 class="font-display text-lg font-bold text-gray-900">Promo & Event Aktif</h3>
                        <button onclick="openModal('modal-add-promo')" class="bg-forest-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-forest-600 transition-all flex items-center shadow-md">
                            <i class="fas fa-plus mr-2"></i> Buat Promo Baru
                        </button>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($promos as $promo)
                            @if($promo['type'] === 'Event / Live Music')
                                <div class="bg-gradient-to-br from-amapiano-500 to-amapiano-700 rounded-2xl p-6 text-white relative overflow-hidden shadow-lg">
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-10 -translate-y-10"></div>
                                    <div class="relative z-10">
                                        <span class="bg-white/20 text-white text-xs font-bold px-2 py-1 rounded-lg backdrop-blur-sm">LIVE MUSIC</span>
                                        <h4 class="font-display text-xl font-bold mt-3 mb-1">{{ $promo['title'] }}</h4>
                                        <p class="text-amapiano-100 text-sm mb-4">{{ $promo['description'] }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-semibold bg-white/10 px-3 py-1 rounded-full"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($promo['start'])->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($promo['end'])->translatedFormat('d M') }}</span>
                                            <form action="{{ route('admin.promos.delete', $promo['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus promo/event ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white/70 hover:text-white text-xs font-semibold underline"><i class="fas fa-trash-alt mr-1"></i>Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all relative">
                                    <div class="flex justify-between items-start">
                                        <span class="bg-forest-100 text-forest-700 text-xs font-bold px-2 py-1 rounded-lg">{{ strtoupper($promo['type']) }}</span>
                                    </div>
                                    <h4 class="font-display text-lg font-bold text-gray-900 mt-3">{{ $promo['title'] }}</h4>
                                    <p class="text-gray-500 text-sm mt-1 mb-4">{{ $promo['description'] }}</p>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-400">Berlaku s/d {{ \Carbon\Carbon::parse($promo['end'])->translatedFormat('d M Y') }}</span>
                                        <div class="flex items-center gap-3">
                                            <span class="font-bold text-forest-600 mr-2">{{ $promo['status'] }}</span>
                                            <form action="{{ route('admin.promos.delete', $promo['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus promo/event ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold"><i class="fas fa-trash-alt mr-1"></i>Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
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
                <div id="tab-store-status" class="tab-content hidden fade-in space-y-6">
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-6 {{ $storeOpen ? 'bg-forest-100' : 'bg-red-100' }}" id="status-icon-container">
                                <i class="fas fa-store text-4xl {{ $storeOpen ? 'text-forest-500' : 'text-red-500' }}" id="status-icon"></i>
                            </div>
                            <h3 class="font-display text-2xl font-bold text-gray-900 mb-2">Status Operasional Cafe</h3>
                            <p class="text-gray-500 mb-8">Kontrol ketersediaan reservasi secara otomatis. Saat ditutup, pelanggan tidak dapat melakukan reservasi baru.</p>
                            
                            <div class="flex items-center justify-center gap-4 mb-8">
                                <span class="font-bold text-gray-500">Tutup</span>
                                <div class="relative inline-block w-14 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="store-toggle" class="toggle-checkbox absolute block w-7 h-7 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer transition-all duration-300 left-0 checked:left-7 checked:border-forest-500" {{ $storeOpen ? 'checked' : '' }}/>
                                    <label for="store-toggle" class="toggle-label block overflow-hidden h-7 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300 checked:bg-forest-500"></label>
                                </div>
                                <span class="font-bold text-gray-500">Buka</span>
                            </div>

                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-left flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-amber-500 mt-1"></i>
                                <div>
                                    <p class="text-sm font-bold text-amber-800">Mode Maintenance</p>
                                    <p class="text-xs text-amber-700 mt-1">Jika cafe sedang libur atau renovasi, matikan status operasional. Reservasi yang sudah ada tetap berlaku.</p>
                                </div>
                            </div>
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
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-200 p-6 m-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-display text-lg font-bold text-gray-900">Buat Promo / Event</h3>
                <button onclick="closeModal('modal-add-promo')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form action="{{ route('admin.promos.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Promo</label>
                    <input type="text" name="title" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none" placeholder="Contoh: Weekend Special">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe</label>
                    <select name="type" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none">
                        <option value="Diskon">Diskon</option>
                        <option value="Event / Live Music">Event / Live Music</option>
                        <option value="Buy 1 Get 1">Buy 1 Get 1</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mulai</label>
                        <input type="date" name="start" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Selesai</label>
                        <input type="date" name="end" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-forest-500 outline-none" rows="3" placeholder="Deskripsi..."></textarea>
                </div>
                <button type="submit" class="w-full bg-forest-500 text-white py-3 rounded-xl font-bold hover:bg-forest-600 transition-colors">Publikasikan Promo</button>
            </form>
        </div>
    </div>

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
                'promo-event': 'Promo & Event',
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

        // Store Status Toggle (AJAX)
        const storeToggle = document.getElementById('store-toggle');
        const statusBadgeContainer = document.getElementById('store-status-badge-container');
        const statusBadge = document.getElementById('store-status-badge');
        const statusText = document.getElementById('store-status-text');
        const statusIconContainer = document.getElementById('status-icon-container');
        const statusIcon = document.getElementById('status-icon');

        storeToggle.addEventListener('change', function() {
            const isOpen = this.checked;
            fetch('{{ route('admin.store.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ open: isOpen })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    if(isOpen) {
                        statusBadgeContainer.className = 'hidden md:flex items-center bg-forest-100 px-3 py-1.5 rounded-full';
                        statusBadge.className = 'w-2.5 h-2.5 rounded-full bg-forest-500 mr-2 animate-pulse';
                        statusText.textContent = 'Buka';
                        statusText.className = 'text-xs font-semibold text-forest-800';
                        statusIconContainer.className = 'w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-6 bg-forest-100';
                        statusIcon.className = 'fas fa-store text-4xl text-forest-500';
                    } else {
                        statusBadgeContainer.className = 'hidden md:flex items-center bg-red-100 px-3 py-1.5 rounded-full';
                        statusBadge.className = 'w-2.5 h-2.5 rounded-full bg-red-500 mr-2 animate-pulse';
                        statusText.textContent = 'Tutup';
                        statusText.className = 'text-xs font-semibold text-red-800';
                        statusIconContainer.className = 'w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-6 bg-red-100';
                        statusIcon.className = 'fas fa-store text-4xl text-red-500';
                    }
                }
            });
        });

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
</x-layouts.dashboard>
