<x-layouts.dashboard title="Staff Dashboard">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300 z-30 hidden md:flex">
            <div class="p-6 flex items-center space-x-3 border-b border-gray-100">
                <div class="w-10 h-10 bg-amapiano-500 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-music text-white"></i>
                </div>
                <div>
                    <h1 class="font-display text-xl font-bold text-gray-900">Amapiano</h1>
                    <p class="text-xs text-gray-500">Staff Dashboard</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="#" onclick="switchTab('validation')" id="nav-validation" class="sidebar-link active flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all group">
                    <i class="fas fa-qrcode w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                    Validasi Reservasi
                </a>
                <a href="#" onclick="switchTab('reservations')" id="nav-reservations" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
                    <i class="fas fa-list-ul w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                    Daftar Reservasi Hari Ini
                </a>
                <a href="#" onclick="switchTab('dashboard')" id="nav-dashboard" class="sidebar-link flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 transition-all group">
                    <i class="fas fa-chart-pie w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                    Ringkasan
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
                    <h2 id="page-title" class="font-display text-xl font-bold text-gray-900">Validasi Reservasi</h2>
                </div>
                
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex items-center bg-forest-100 px-3 py-1.5 rounded-full">
                        <div class="w-2.5 h-2.5 rounded-full bg-forest-500 mr-2 animate-pulse"></div>
                        <span class="text-xs font-semibold text-forest-800">Cafe Buka</span>
                    </div>
                    <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=16a34a&color=fff" alt="Staff" class="w-9 h-9 rounded-full ring-2 ring-forest-100">
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->role === 'admin' ? 'Super Admin' : 'Front Desk Staff' }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 relative">
                
                <!-- VALIDATION TAB (Primary) -->
                <div id="tab-validation" class="tab-content fade-in space-y-6">
                    <div class="grid lg:grid-cols-3 gap-6">
                        <!-- Input Section -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                                <div class="w-16 h-16 mx-auto bg-amapiano-100 rounded-full flex items-center justify-center text-amapiano-600 mb-4">
                                    <i class="fas fa-qrcode text-3xl"></i>
                                </div>
                                <h3 class="font-display text-xl font-bold text-gray-900 mb-2">Validasi Kode Reservasi</h3>
                                <p class="text-gray-500 text-sm mb-8">Masukkan kode reservasi pelanggan untuk melakukan verifikasi check-in.</p>
                                
                                <div class="max-w-md mx-auto relative">
                                    <input type="text" id="res-code-input" class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amapiano-200 focus:border-amapiano-500 outline-none text-center bg-gray-50 transition-all font-mono font-bold text-xl uppercase tracking-widest" placeholder="AMP-XXXX" maxlength="8">
                                    <button onclick="validateReservation()" class="absolute right-2 top-2 bottom-2 bg-amapiano-500 hover:bg-amapiano-600 text-white px-6 rounded-lg font-bold transition-all shadow-md flex items-center">
                                        <i class="fas fa-search mr-2"></i> Cari
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400 mt-3">Contoh kode valid hari ini: <span class="font-mono text-amapiano-500 cursor-pointer hover:underline" onclick="fillInput('AMP-8292')">AMP-8292</span>, <span class="font-mono text-red-500 cursor-pointer hover:underline" onclick="fillInput('AMP-ERROR')">AMP-ERROR</span></p>
                            </div>

                            <!-- Result Section (Hidden by default) -->
                            <div id="validation-result" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hidden transition-all">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex items-center">
                                        <div id="result-icon" class="w-12 h-12 rounded-full flex items-center justify-center mr-4"></div>
                                        <div>
                                            <h4 id="result-title" class="font-display text-lg font-bold text-gray-900">...</h4>
                                            <p id="result-subtitle" class="text-sm text-gray-500">...</p>
                                        </div>
                                    </div>
                                    <span id="result-badge" class="px-3 py-1 rounded-full text-xs font-bold border">...</span>
                                </div>

                                <div id="valid-content" class="hidden space-y-4">
                                    <div class="bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500 text-xs">Nama Pelanggan</p>
                                            <p id="res-name" class="font-semibold text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs">Nomor Telepon</p>
                                            <p id="res-phone" class="font-semibold text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs">Tanggal & Waktu</p>
                                            <p id="res-datetime" class="font-semibold text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs">Area & Meja</p>
                                            <p id="res-location" class="font-semibold text-gray-900">-</p>
                                        </div>
                                    </div>
                                    <div id="late-warning" class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 flex items-center gap-3 hidden">
                                        <i class="fas fa-clock text-yellow-500"></i>
                                        <p class="text-yellow-700 text-xs font-medium">Reservasi ini sudah melewati batas waktu 15 menit. Pastikan meja masih tersedia.</p>
                                    </div>
                                    <button id="checkin-btn" onclick="processCheckIn()" class="w-full bg-forest-500 hover:bg-forest-600 text-white py-3.5 rounded-xl font-bold transition-all shadow-md flex items-center justify-center">
                                        <i class="fas fa-check-circle mr-2"></i> Konfirmasi Check-In
                                    </button>
                                </div>

                                <div id="invalid-content" class="hidden text-center py-4">
                                    <p id="invalid-msg" class="text-gray-600 mb-4">-</p>
                                    <button onclick="resetValidation()" class="text-amapiano-600 font-semibold text-sm hover:underline">Coba Kode Lain</button>
                                </div>

                                <div id="used-content" class="hidden text-center py-4 bg-red-50 rounded-xl border border-red-100">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-500 mx-auto mb-3">
                                        <i class="fas fa-exclamation-triangle text-xl"></i>
                                    </div>
                                    <p class="text-red-700 font-bold mb-1">Kode Sudah Digunakan!</p>
                                    <p id="used-by-msg" class="text-red-600 text-sm mb-4">Reservasi ini telah di-check-in sebelumnya.</p>
                                    <p id="used-time" class="text-gray-500 text-xs">Status: Checked In</p>
                                </div>
                            </div>
                        </div>

                        <!-- Side Panel: Recent Activity -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full">
                                <h3 class="font-display text-lg font-bold text-gray-900 mb-4">Check-In Terakhir Hari Ini</h3>
                                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2" id="recent-checkins">
                                    @forelse($recentCheckins as $chk)
                                        <div class="flex items-center justify-between p-3 bg-forest-50 rounded-xl border border-forest-100">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-forest-100 flex items-center justify-center text-forest-600 mr-3 text-xs font-bold">
                                                    {{ strtoupper(substr($chk->fullname, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-sm text-gray-800">{{ $chk->fullname }}</p>
                                                    <p class="text-xs text-gray-500">{{ $chk->area }} / {{ strtoupper($chk->table_id) }}</p>
                                                </div>
                                            </div>
                                            <span class="text-xs text-forest-600 font-bold">{{ \Carbon\Carbon::parse($chk->checked_in_at)->timezone('Asia/Jakarta')->format('H:i') }}</span>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-400 text-center py-6">Belum ada check-in hari ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RESERVATIONS LIST TAB -->
                <div id="tab-reservations" class="tab-content hidden fade-in space-y-6">
                    <form action="{{ route('staff.dashboard') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                        <input type="hidden" name="tab" value="reservations">
                        <div class="relative w-full md:w-96">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode reservasi..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amapiano-500 focus:border-transparent text-sm">
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <select name="status" class="bg-white border border-gray-200 text-gray-600 text-sm rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amapiano-500">
                                <option {{ request('status') === 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                                <option {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option {{ request('status') === 'Checked In' ? 'selected' : '' }}>Checked In</option>
                                <option {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="bg-amapiano-500 text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-amapiano-600 transition-all flex items-center">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                        </div>
                    </form>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-display font-bold text-gray-900">Daftar Semua Reservasi</h3>
                            <span class="text-sm text-gray-500">Total: {{ count($reservations) }} Reservasi</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 font-medium">
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
                                        <tr class="hover:bg-gray-50 transition-colors {{ $res->status === 'pending' ? 'bg-yellow-50/20' : '' }}">
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
                                                    <button onclick="fillInput('{{ $res->code }}')" class="bg-forest-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-forest-600 transition-colors">Check-In</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada reservasi untuk hari ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- DASHBOARD TAB -->
                <div id="tab-dashboard" class="tab-content hidden fade-in space-y-6">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                            <div class="w-10 h-10 bg-amapiano-100 rounded-lg flex items-center justify-center text-amapiano-600 mb-3">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $totalToday }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Total Reservasi Hari Ini</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                            <div class="w-10 h-10 bg-forest-100 rounded-lg flex items-center justify-center text-forest-600 mb-3">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $checkedInToday }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Checked In</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-3">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $pendingToday }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Menunggu Kedatangan</p>
                        </div>
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600 mb-3">
                                <i class="fas fa-ban"></i>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $cancelledToday }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Dibatalkan/Terlambat</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-display text-lg font-bold text-gray-900 mb-4">Status Keterisian Area</h3>
                            <div class="space-y-4">
                                @foreach($areaOccupancy as $name => $occ)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full {{ $occ['occupied'] > 0 ? 'bg-orange-500' : 'bg-green-500' }} mr-3"></div>
                                            <span class="font-semibold text-sm text-gray-700">{{ $name }}</span>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $occ['occupied'] }}/{{ $occ['total'] }} Meja Terisi</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-display text-lg font-bold text-gray-900 mb-4">Antrean Reservasi Mendatang</h3>
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                                @forelse($nextHourBookings as $nxt)
                                    <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                                        <div>
                                            <p class="font-semibold text-sm text-gray-800">{{ $nxt->fullname }}</p>
                                            <p class="text-xs text-gray-500">{{ $nxt->code }} • {{ $nxt->guests }} Tamu</p>
                                        </div>
                                        <span class="text-sm font-bold text-amapiano-600">{{ $nxt->time }}</span>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 text-center py-6">Tidak ada reservasi mendatang hari ini.</p>
                                </author>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Modal: Check-In Success -->
    <div id="modal-checkin-success" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-checkin-success')"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm relative z-10 transform scale-95 transition-transform duration-200 p-6 m-4 text-center">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center text-green-600 mb-6" style="box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); animation: pulse-green 2s infinite;" id="success-pulse-icon">
                <i class="fas fa-check text-4xl"></i>
            </div>
            <h3 class="font-display text-2xl font-bold text-gray-900 mb-2">Check-In Berhasil!</h3>
            <p class="text-gray-500 text-sm mb-6">Status reservasi telah diperbarui menjadi <span class="font-bold text-forest-600">"Checked In"</span>. Pelanggan dapat menikmati makanannya.</p>
            <button onclick="closeModal('modal-checkin-success'); resetValidation();" class="w-full bg-forest-500 text-white py-3 rounded-xl font-bold hover:bg-forest-600 transition-colors">Selesai</button>
        </div>
    </div>

    <script>
        // Tab Switching Logic
        function switchTab(tabId) {
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('active');
                link.classList.add('text-gray-600');
            });
            const activeLink = document.getElementById('nav-' + tabId);
            if(activeLink) {
                activeLink.classList.add('active');
                activeLink.classList.remove('text-gray-600');
            }

            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('tab-' + tabId).classList.remove('hidden');

            const titles = {
                'validation': 'Validasi Reservasi',
                'reservations': 'Daftar Reservasi Hari Ini',
                'dashboard': 'Ringkasan Harian'
            };
            document.getElementById('page-title').textContent = titles[tabId] || 'Staff Dashboard';

            if(window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('hidden');
            }
        }

        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('h-full');
        });

        // Validation Logic (Real AJAX)
        function fillInput(code) {
            document.getElementById('res-code-input').value = code;
            switchTab('validation');
            validateReservation();
        }

        let currentValidatedCode = '';

        function validateReservation() {
            const code = document.getElementById('res-code-input').value.toUpperCase().trim();
            const resultContainer = document.getElementById('validation-result');
            const resultIcon = document.getElementById('result-icon');
            const resultTitle = document.getElementById('result-title');
            const resultSubtitle = document.getElementById('result-subtitle');
            const resultBadge = document.getElementById('result-badge');
            
            const validContent = document.getElementById('valid-content');
            const invalidContent = document.getElementById('invalid-content');
            const usedContent = document.getElementById('used-content');
            const checkinBtn = document.getElementById('checkin-btn');

            // Reset UI
            resultContainer.classList.remove('hidden');
            validContent.classList.add('hidden');
            invalidContent.classList.add('hidden');
            usedContent.classList.add('hidden');
            resultContainer.classList.remove('animate-shake');

            if(code === '') {
                resultContainer.classList.add('hidden');
                return;
            }

            // Real Fetch Call to AJAX Endpoint
            fetch('{{ route('staff.validate') }}?code=' + encodeURIComponent(code))
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    currentValidatedCode = data.reservation.code;
                    // Valid Case
                    resultIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-green-100 text-green-600';
                    resultIcon.innerHTML = '<i class="fas fa-user-check text-xl"></i>';
                    resultTitle.textContent = 'Reservasi Valid';
                    resultSubtitle.textContent = 'Data pelanggan ditemukan dan siap untuk check-in.';
                    resultBadge.className = 'px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200';
                    resultBadge.textContent = 'VALID';

                    // Populate Data
                    document.getElementById('res-name').textContent = data.reservation.fullname;
                    document.getElementById('res-phone').textContent = data.reservation.phone;
                    document.getElementById('res-datetime').textContent = data.reservation.datetime;
                    document.getElementById('res-location').textContent = data.reservation.location;
                    
                    // Late Warning logic
                    if(data.late) {
                        document.getElementById('late-warning').classList.remove('hidden');
                        checkinBtn.textContent = 'Tetap Check-In (Terlambat)';
                        checkinBtn.classList.replace('bg-forest-500', 'bg-yellow-500');
                        checkinBtn.classList.replace('hover:bg-forest-600', 'hover:bg-yellow-600');
                    } else {
                        document.getElementById('late-warning').classList.add('hidden');
                        checkinBtn.textContent = 'Konfirmasi Check-In';
                        checkinBtn.classList.replace('bg-yellow-500', 'bg-forest-500');
                        checkinBtn.classList.replace('hover:bg-yellow-600', 'hover:bg-forest-600');
                    }

                    validContent.classList.remove('hidden');
                } else {
                    if (data.status === 'used') {
                        // Already Used
                        resultIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-red-100 text-red-600';
                        resultIcon.innerHTML = '<i class="fas fa-exclamation-triangle text-xl"></i>';
                        resultTitle.textContent = 'Kode Sudah Digunakan';
                        resultSubtitle.textContent = 'Reservasi ini telah di-check-in sebelumnya.';
                        resultBadge.className = 'px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200';
                        resultBadge.textContent = 'USED';
                        
                        usedContent.classList.remove('hidden');
                        document.getElementById('used-by-msg').textContent = 'Check-in dilakukan pada ' + data.checked_in_at + '.';
                        resultContainer.classList.add('animate-shake');
                    } else {
                        // Invalid / Not Found
                        resultIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-red-100 text-red-600';
                        resultIcon.innerHTML = '<i class="fas fa-times text-xl"></i>';
                        resultTitle.textContent = 'Reservasi Tidak Ditemukan';
                        resultSubtitle.textContent = data.message;
                        resultBadge.className = 'px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200';
                        resultBadge.textContent = 'INVALID';
                        
                        invalidContent.classList.remove('hidden');
                        document.getElementById('invalid-msg').textContent = data.message;
                        resultContainer.classList.add('animate-shake');
                    }
                }
            })
            .catch(error => {
                console.error('Error validating reservation:', error);
            });
        }

        function processCheckIn() {
            if (!currentValidatedCode) return;

            fetch('{{ route('staff.checkin') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: currentValidatedCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openModal('modal-checkin-success');
                    
                    // Add to recent list
                    const list = document.getElementById('recent-checkins');
                    const emptyMsg = list.querySelector('.text-center');
                    if (emptyMsg) {
                        emptyMsg.remove();
                    }

                    const newItem = document.createElement('div');
                    newItem.className = 'flex items-center justify-between p-3 bg-forest-50 rounded-xl border border-forest-100 fade-in';
                    newItem.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-forest-100 flex items-center justify-center text-forest-600 mr-3 text-xs font-bold">${data.reservation.initials}</div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">${data.reservation.fullname}</p>
                                <p class="text-xs text-gray-500">${data.reservation.location}</p>
                            </div>
                        </div>
                        <span class="text-xs text-forest-600 font-bold">${data.reservation.time}</span>
                    `;
                    list.insertBefore(newItem, list.firstChild);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error confirming check-in:', error);
            });
        }

        function resetValidation() {
            document.getElementById('validation-result').classList.add('hidden');
            document.getElementById('res-code-input').value = '';
            document.getElementById('res-code-input').focus();
            currentValidatedCode = '';
        }

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

        // Enter key support
        document.getElementById('res-code-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                validateReservation();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Keep tab open if active
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            if (activeTab) {
                switchTab(activeTab);
            }
        });
    </script>
</x-layouts.dashboard>
