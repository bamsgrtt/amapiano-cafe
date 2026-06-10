<x-layouts.app title="Halaman Beranda">

@push('styles')
<style>
    .font-display { font-family: 'Playfair Display', serif; }
    
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideInScale { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }
    @keyframes tablePop { 0% { transform: scale(1); } 50% { transform: scale(1.15); } 100% { transform: scale(1); } }
    @keyframes checkmark { 0% { transform: scale(0); } 50% { transform: scale(1.3); } 100% { transform: scale(1); } }
    @keyframes confettiFall { 0% { transform: translateY(-100%) rotate(0deg); opacity: 1; } 100% { transform: translateY(100vh) rotate(720deg); opacity: 0; } }
    @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5); } 50% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); } }
    @keyframes countdownPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
    @keyframes shimmer { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
    
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-slide-in-scale { animation: slideInScale 0.5s ease-out forwards; }
    .animate-table-pop { animation: tablePop 0.4s ease-out; }
    
    .step-circle {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .room-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .room-card:hover { transform: translateY(-4px); }
    .room-card.selected {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(216, 130, 52, 0.25);
    }
    
    .table-seat {
        transition: all 0.3s ease;
    }
    .table-seat.available:hover { transform: scale(1.12); z-index: 10; }
    .table-seat.selected { animation: tablePop 0.4s ease-out; }
    
    .confetti-piece {
        position: fixed;
        width: 10px;
        height: 10px;
        border-radius: 2px;
        animation: confettiFall 2.5s ease-out forwards;
        pointer-events: none;
        z-index: 9999;
    }
    
    .progress-line { transition: all 0.6s ease; }
    
    .btn-primary {
        background: linear-gradient(135deg, #d88234 0%, #c96c2b 100%);
        transition: all 0.3s ease;
    }
    .btn-primary:hover { background: linear-gradient(135deg, #c96c2b 0%, #a75525 100%); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(216, 130, 52, 0.4); }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }
    
    .table-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 800;
        color: white;
        font-size: 11px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.4);
        pointer-events: none;
    }
    
    .floor-plan-bg {
        background: linear-gradient(145deg, #f8f4ec 0%, #ede5d5 50%, #e8dcc8 100%);
        position: relative;
        overflow: hidden;
    }
    
    .ticket-border {
        border: 2px dashed #d88234;
        position: relative;
    }
    
    .shimmer-text {
        background: linear-gradient(90deg, #d88234, #e09a50, #d88234);
        background-size: 200% auto;
        animation: shimmer 3s linear infinite;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .countdown-bar {
        transition: width 1s linear;
    }
    
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #d88234; border-radius: 4px; }
    
    .step-content { transition: all 0.5s ease; }
</style>
@endpush



<div id="booking-section" class="py-12 bg-gray-50/50">
    <!-- Success / Ticket Modal -->
    

    <div class="max-w-4xl mx-auto px-4 py-6 md:py-10">
        
        <!-- Header -->
        <div class="text-center mb-8 animate-fade-in-up">
            <div class="flex items-center justify-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-amapiano-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                <div>
                    <h1 class="font-display text-xl font-bold text-gray-900">Amapiano</h1>
                    <p class="text-xs text-gray-500">Thematic Resto & Cafe</p>
                </div>
            </div>
            <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900">Reservasi Meja Online</h2>
            <p class="text-gray-500 text-sm mt-1">Pilih tanggal, ruangan, meja favorit Anda</p>
        </div>

        @if(!($storeOpen ?? true))
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 text-center border border-red-100 max-w-xl mx-auto animate-fade-in-up">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold text-gray-950 mb-3">Reservasi Online Ditutup</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    Mohon maaf, saat ini sistem reservasi online Amapiano Cafe sedang ditutup sementara oleh pengelola. Silakan hubungi layanan pelanggan kami melalui WhatsApp untuk info operasional langsung.
                </p>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl text-sm transition-all shadow-md">
                    <i class="fab fa-whatsapp text-lg mr-2"></i> Hubungi Customer Service
                </a>
            </div>
        @else
            <!-- STEP PROGRESS INDICATOR -->
        <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-center max-w-xl mx-auto">
                <!-- Step 1 -->
                <div class="flex flex-col items-center">
                    <div id="step-circle-1" class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs border-2 bg-amapiano-500 border-amapiano-500 text-white shadow-lg">
                        <span id="step-num-1">1</span>
                    </div>
                    <p id="step-text-1" class="text-xs font-medium mt-1.5 text-amapiano-600">Tanggal & Waktu</p>
                </div>
                
                <!-- Line -->
                <div class="flex-1 mx-2 mb-6">
                    <div id="line-1" class="h-1 rounded-full bg-gray-200 progress-line"></div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex flex-col items-center">
                    <div id="step-circle-2" class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs border-2 bg-gray-100 border-gray-300 text-gray-400">
                        <span id="step-num-2">2</span>
                    </div>
                    <p id="step-text-2" class="text-xs font-medium mt-1.5 text-gray-400">Pilih Ruangan</p>
                </div>
                
                <!-- Line -->
                <div class="flex-1 mx-2 mb-6">
                    <div id="line-2" class="h-1 rounded-full bg-gray-200 progress-line"></div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div id="step-circle-3" class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs border-2 bg-gray-100 border-gray-300 text-gray-400">
                        <span id="step-num-3">3</span>
                    </div>
                    <p id="step-text-3" class="text-xs font-medium mt-1.5 text-gray-400">Pilih Meja</p>
                </div>
                
                <!-- Line -->
                <div class="flex-1 mx-2 mb-6">
                    <div id="line-3" class="h-1 rounded-full bg-gray-200 progress-line"></div>
                </div>
                
                <!-- Step 4 -->
                <div class="flex flex-col items-center">
                    <div id="step-circle-4" class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs border-2 bg-gray-100 border-gray-300 text-gray-400">
                        <span id="step-num-4">4</span>
                    </div>
                    <p id="step-text-4" class="text-xs font-medium mt-1.5 text-gray-400">Data Pemesan</p>
                </div>
                
                <!-- Line -->
                <div class="flex-1 mx-2 mb-6">
                    <div id="line-4" class="h-1 rounded-full bg-gray-200 progress-line"></div>
                </div>
                
                <!-- Step 5 -->
                <div class="flex flex-col items-center">
                    <div id="step-circle-5" class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs border-2 bg-gray-100 border-gray-300 text-gray-400">
                        <span id="step-num-5">5</span>
                    </div>
                    <p id="step-text-5" class="text-xs font-medium mt-1.5 text-gray-400">Selesai</p>
                </div>
            </div>
        </div>

        <!-- ============ STEP 1: Pilih Tanggal & Waktu ============ -->
        <div id="content-step-1" class="step-content">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 bg-amapiano-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold text-gray-900">Langkah 1: Tanggal & Waktu</h3>
                        <p class="text-xs text-gray-500">Tentukan jadwal kunjungan Anda</p>
                    </div>
                </div>
                
                <div class="grid sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" id="input-date" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none transition-all bg-white" min="">
                        <p class="text-xs text-red-500 mt-1 hidden" id="date-error">Reservasi minimal hari ini</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Waktu Kedatangan <span class="text-red-500">*</span></label>
                        <select id="input-time" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none transition-all bg-white">
                            <option value="">Pilih waktu</option>
                            <option value="10:00">10:00 WIB</option>
                            <option value="11:00">11:00 WIB</option>
                            <option value="12:00">12:00 WIB</option>
                            <option value="13:00">13:00 WIB</option>
                            <option value="14:00">14:00 WIB</option>
                            <option value="15:00">15:00 WIB</option>
                            <option value="16:00">16:00 WIB</option>
                            <option value="17:00">17:00 WIB</option>
                            <option value="18:00">18:00 WIB</option>
                            <option value="19:00">19:00 WIB</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jumlah Tamu <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-3">
                            <button onclick="changeGuests(-1)" class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-amapiano-50 transition-all text-gray-600">−</button>
                            <div class="flex-1 text-center">
                                <span id="guest-count" class="text-2xl font-display font-bold text-amapiano-600">2</span>
                                <p class="text-xs text-gray-500">orang</p>
                            </div>
                            <button onclick="changeGuests(1)" class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-amapiano-50 transition-all text-gray-600">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Info Min. Order</label>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-amber-700" id="min-order-info">Pilih tanggal untuk melihat info</p>
                        </div>
                    </div>
                </div>
                
                <button onclick="goToStep(2)" class="btn-primary text-white w-full py-3 rounded-xl font-semibold text-sm">
                    Lanjutkan →
                </button>
            </div>
        </div>

        <!-- ============ STEP 2: Pilih Ruangan ============ -->
        <div id="content-step-2" class="step-content hidden">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-amapiano-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-bold text-gray-900">Langkah 2: Pilih Ruangan</h3>
                            <p class="text-xs text-gray-500">Pilih ruangan favorit Anda</p>
                        </div>
                    </div>
                    <button onclick="goToStep(1)" class="text-xs text-gray-400 hover:text-amapiano-600 transition-colors flex items-center space-x-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span>Kembali</span>
                    </button>
                </div>
                
                <div class="grid sm:grid-cols-3 gap-4 mb-6">
                    <!-- Hoof Barn -->
                    <div class="room-card rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer" onclick="selectRoom('hoof-barn')" id="room-hoof-barn">
                        <div class="relative h-36 overflow-hidden">
                            <img src="{{ asset('images/reservasi dan no wa.png') }}" alt="Hoof Barn" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-2 left-2 right-2">
                                <span class="bg-amber-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">🏠 Rustic</span>
                            </div>
                            <div class="absolute top-2 right-2 room-check-mark hidden">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <h4 class="font-display text-sm font-bold text-gray-900">Hoof Barn</h4>
                            <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2">Suasana barn rustic dengan interior kayu dan dekorasi vintage</p>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                <span class="text-[10px] text-green-600 font-semibold" id="hoof-barn-available">8 meja tersedia</span>
                                <span class="text-[10px] text-red-500 font-semibold" id="hoof-barn-occupied">3 terisi</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Covent Garden -->
                    <div class="room-card rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer" onclick="selectRoom('covent-garden')" id="room-covent-garden">
                        <div class="relative h-36 overflow-hidden">
                            <img src="{{ asset('images/cg.png') }}" alt="Covent Garden" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-2 left-2 right-2">
                                <span class="bg-green-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">🌿 Outdoor</span>
                            </div>
                            <div class="absolute top-2 right-2 room-check-mark hidden">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <h4 class="font-display text-sm font-bold text-gray-900">Covent Garden</h4>
                            <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2">Area outdoor garden asri dengan taman hijau dan kincir angin</p>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                <span class="text-[10px] text-green-600 font-semibold" id="covent-garden-available">10 meja tersedia</span>
                                <span class="text-[10px] text-red-500 font-semibold" id="covent-garden-occupied">4 terisi</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Limburg -->
                    <div class="room-card rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer" onclick="selectRoom('limburg')" id="room-limburg">
                        <div class="relative h-36 overflow-hidden">
                            <img src="{{ asset('images/limb.png') }}" alt="Limburg" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-2 left-2 right-2">
                                <span class="bg-purple-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">🏛️ Indoor</span>
                            </div>
                            <div class="absolute top-2 right-2 room-check-mark hidden">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <h4 class="font-display text-sm font-bold text-gray-900">Limburg</h4>
                            <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2">Ruang indoor bergaya Eropa yang elegan dan privat</p>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                <span class="text-[10px] text-green-600 font-semibold" id="limburg-available">7 meja tersedia</span>
                                <span class="text-[10px] text-red-500 font-semibold" id="limburg-occupied">3 terisi</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="selected-room-summary" class="hidden mb-4 bg-amapiano-50 rounded-lg p-3 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-amapiano-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <p class="text-xs text-gray-700">Ruangan terpilih: <span id="selected-room-label" class="font-bold text-amapiano-600">-</span></p>
                </div>
                
                <button onclick="goToStep(3)" class="btn-primary text-white w-full py-3 rounded-xl font-semibold text-sm disabled:opacity-50 disabled:cursor-not-allowed" id="btn-step2" disabled>
                    Lanjutkan Pilih Meja →
                </button>
            </div>
        </div>

        <!-- ============ STEP 3: Pilih Meja ============ -->
        <div id="content-step-3" class="step-content hidden">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-amapiano-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-bold text-gray-900">Langkah 3: Pilih Meja</h3>
                            <p class="text-xs text-gray-500" id="floorplan-room-name">-</p>
                        </div>
                    </div>
                    <button onclick="goToStep(2)" class="text-xs text-gray-400 hover:text-amapiano-600 transition-colors">← Kembali</button>
                </div>
                
                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-4 mb-4 bg-gray-50 rounded-lg p-2">
                    <div class="flex items-center space-x-1.5">
                        <div class="w-3.5 h-3.5 rounded bg-green-500 border border-green-600"></div>
                        <span class="text-[10px] text-gray-600 font-medium">Tersedia</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <div class="w-3.5 h-3.5 rounded bg-red-400 border border-red-500 opacity-60"></div>
                        <span class="text-[10px] text-gray-600 font-medium">Terisi</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <div class="w-3.5 h-3.5 rounded bg-amapiano-500 border border-amapiano-600"></div>
                        <span class="text-[10px] text-gray-600 font-medium">Pilihan Anda</span>
                    </div>
                </div>
                
                <!-- Floor Plan -->
                <div class="floor-plan-bg rounded-xl border border-gray-200 p-3 relative mb-4" id="floor-plan-wrapper" style="min-height: 350px;">
                    <div id="floor-plan-label" class="absolute top-2 left-1/2 transform -translate-x-1/2 text-[9px] font-bold text-gray-400 uppercase tracking-widest">MAIN AREA</div>
                    <div id="floor-plan-entrance" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 bg-gray-300/80 px-4 py-1 rounded-t text-[10px] text-gray-600 font-semibold z-20"> ENTRANCE</div>
                    <div id="tables-render-area" class="relative w-full" style="min-height: 310px;"></div>
                </div>
                
                <!-- Selected Table Info -->
                <div id="selected-table-info" class="hidden mb-4 bg-amapiano-50 rounded-lg p-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-amapiano-500 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600"><span id="selected-tbl-name" class="font-bold text-amapiano-600">-</span></p>
                            <p class="text-[10px] text-gray-500" id="selected-tbl-detail">-</p>
                        </div>
                    </div>
                    <button onclick="clearTableSelection()" class="text-[10px] text-red-500 hover:text-red-600 font-medium">Hapus</button>
                </div>
                
                <button onclick="goToStep(4)" class="btn-primary text-white w-full py-3 rounded-xl font-semibold text-sm disabled:opacity-50 disabled:cursor-not-allowed" id="btn-step3" disabled>
                    Lanjutkan Isi Data →
                </button>
            </div>
        </div>

        <!-- ============ STEP 4: Data Pemesan ============ -->
        <div id="content-step-4" class="step-content hidden">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-amapiano-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amapiano-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-bold text-gray-900">Langkah 4: Data Pemesan</h3>
                            <p class="text-xs text-gray-500">Lengkapi data untuk konfirmasi</p>
                        </div>
                    </div>
                    <button onclick="goToStep(3)" class="text-xs text-gray-400 hover:text-amapiano-600 transition-colors">← Kembali</button>
                </div>
                
                <!-- Booking Summary -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-xs font-semibold text-gray-700 mb-2">Ringkasan Reservasi</p>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="flex justify-between"><span class="text-gray-500">Ruangan</span><span class="font-semibold text-gray-900" id="summary-room">-</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Meja</span><span class="font-semibold text-gray-900" id="summary-table">-</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-semibold text-gray-900" id="summary-date">-</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Waktu</span><span class="font-semibold text-gray-900" id="summary-time">-</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tamu</span><span class="font-semibold text-gray-900" id="summary-guests">-</span></div>
                    </div>
                </div>
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="input-name" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="tel" id="input-phone" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Email (opsional)</label>
                        <input type="email" id="input-email" placeholder="email@contoh.com" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Khusus (opsional)</label>
                        <textarea id="input-notes" rows="2" placeholder="Contoh: meja dekat jendela, ada anak kecil, dll." class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm outline-none transition-all resize-none"></textarea>
                    </div>
                </div>
                
                <!-- Rules Acknowledgment -->
                <div class="bg-gray-50 rounded-xl p-3 mb-6">
                    <label class="flex items-start space-x-2 cursor-pointer">
                        <input type="checkbox" id="rules-check" class="mt-0.5 w-4 h-4 text-amapiano-500 border-gray-300 rounded focus:ring-amapiano-500">
                        <div class="text-[11px] text-gray-600">
                            <p class="font-semibold text-gray-800">Saya menyetujui aturan cafe:</p>
                            <ul class="mt-0.5 space-y-0.5 text-[10px]">
                                <li>• Min. order: Rp 40.000 (weekday) / Rp 60.000 (weekend) per orang usia 14+</li>
                                <li>• Denda Rp 100.000/item untuk bawa makanan/minuman luar</li>
                                <li>• Dilarang membawa hewan peliharaan</li>
                                <li>• Reservasi berlaku 2 jam dari waktu yang dipilih</li>
                            </ul>
                        </div>
                    </label>
                </div>
                
                <button onclick="confirmBooking()" class="btn-primary text-white w-full py-3 rounded-xl font-semibold text-sm disabled:opacity-50 disabled:cursor-not-allowed" id="btn-step4" disabled>
                    ✓ Konfirmasi Reservasi
                </button>
            </div>
        </div>

        <!-- ============ STEP 5: Selesai (Tiket) ============ -->
        <div id="content-step-5" class="step-content hidden">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-center relative mb-6">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-2xl font-bold text-white">Reservasi Berhasil! 🎉</h3>
                    <p class="text-green-100 text-sm mt-1">Meja Anda telah berhasil dipesan</p>
                </div>
                
                <!-- Booking Ticket -->
                <div id="reservation-ticket" class="ticket-border rounded-xl p-5 bg-amber-50 relative mb-4">
                    <!-- Ticket Punch Holes (Left & Right) -->
                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full z-10"></div>
                    <div class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full z-10"></div>
                    <div class="text-center mb-4">
                        <p class="text-xs text-gray-500 uppercase tracking-widest">Booking Code</p>
                        <p class="font-display text-3xl font-bold shimmer-text" id="ticket-booking-code">#AMP-000</p>
                    </div>
                    
                    <div class="space-y-2 text-sm mb-4">
                        <div class="flex justify-between py-1 border-b border-amber-200">
                            <span class="text-gray-500">Ruangan</span>
                            <span class="font-bold text-gray-900" id="ticket-room">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-amber-200">
                            <span class="text-gray-500">Meja</span>
                            <span class="font-bold text-gray-900" id="ticket-table">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-amber-200">
                            <span class="text-gray-500">Tanggal</span>
                            <span class="font-bold text-gray-900" id="ticket-date">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-amber-200">
                            <span class="text-gray-500">Waktu</span>
                            <span class="font-bold text-gray-900" id="ticket-time">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-amber-200">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-bold text-gray-900" id="ticket-name">-</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-500">No. HP</span>
                            <span class="font-bold text-gray-900" id="ticket-phone">-</span>
                        </div>
                    </div>
                    
                    <!-- QR Code -->
                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-2">Scan QR Code untuk verifikasi</p>
                        <div class="inline-block bg-white p-3 rounded-xl shadow-md">
                            <img alt="QR Code" id="qr-code" class="w-32 h-32">
                        </div>
                    </div>
                </div>
                
                <!-- Rules Reminder -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-4">
                    <p class="text-blue-800 text-xs font-semibold mb-1">Pengingat:</p>
                    <ul class="text-blue-700 text-xs space-y-0.5">
                        <li>• Datang sesuai waktu reservasi</li>
                        <li>• Tunjukkan booking code saat arrival</li>
                        <li>• Min. order Rp 40.000 (weekday) / Rp 60.000 (weekend)</li>
                        <li>• Menu dipesan via QR di meja</li>
                    </ul>
                </div>
                
                <div class="flex gap-3">
                    <button id="btn-download" onclick="downloadTicket()" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-xl font-semibold text-sm flex items-center justify-center space-x-2 transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Struk</span>
                    </button>
                    <button onclick="resetAll()" class="flex-1 btn-primary text-white py-3 rounded-xl font-semibold text-sm shadow-md">
                        Reservasi Baru
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

@push('scripts')
    <script>
        // ==================== STATE ====================
        let currentStep = 1;
        let guestCount = 2;
        let selectedRoom = null;
        let selectedTableId = null;
        
        // ==================== ROOM DATA ====================
        const rooms = {
            'hoof-barn': {
                name: 'Hoof Barn',
                theme: '🏠 Rustic Barn',
                totalTables: 8,
                tables: [
                    { id: 'HB-1', name: 'HB-1', capacity: 2, x: 8, y: 18, shape: 'round', size: 44, area: 'Dekat Jendela', occupied: false },
                    { id: 'HB-2', name: 'HB-2', capacity: 4, x: 28, y: 14, shape: 'rect', size: 56, area: 'Tengah', occupied: false },
                    { id: 'HB-3', name: 'HB-3', capacity: 4, x: 50, y: 18, shape: 'rect', size: 56, area: 'Tengah', occupied: true },
                    { id: 'HB-4', name: 'HB-4', capacity: 6, x: 72, y: 14, shape: 'rect', size: 70, area: 'Dekat Dinding', occupied: false },
                    { id: 'HB-5', name: 'HB-5', capacity: 2, x: 12, y: 48, shape: 'round', size: 44, area: 'Tengah', occupied: true },
                    { id: 'HB-6', name: 'HB-6', capacity: 4, x: 35, y: 44, shape: 'rect', size: 56, area: 'Tengah', occupied: false },
                    { id: 'HB-7', name: 'HB-7', capacity: 4, x: 60, y: 48, shape: 'rect', size: 56, area: 'Dekat Dinding', occupied: false },
                    { id: 'HB-8', name: 'HB-8', capacity: 6, x: 45, y: 74, shape: 'rect', size: 70, area: 'Tengah', occupied: true },
                ]
            },
            'covent-garden': {
                name: 'Covent Garden',
                theme: '🌿 Outdoor Garden',
                totalTables: 10,
                tables: [
                    { id: 'CG-1', name: 'CG-1', capacity: 2, x: 6, y: 14, shape: 'round', size: 44, area: 'Area Garden', occupied: false },
                    { id: 'CG-2', name: 'CG-2', capacity: 4, x: 22, y: 10, shape: 'rect', size: 56, area: 'Area Garden', occupied: false },
                    { id: 'CG-3', name: 'CG-3', capacity: 4, x: 42, y: 14, shape: 'rect', size: 56, area: 'Area Garden', occupied: true },
                    { id: 'CG-4', name: 'CG-4', capacity: 6, x: 64, y: 10, shape: 'rect', size: 70, area: 'Area Garden', occupied: false },
                    { id: 'CG-5', name: 'CG-5', capacity: 2, x: 86, y: 16, shape: 'round', size: 44, area: 'Area Garden', occupied: false },
                    { id: 'CG-6', name: 'CG-6', capacity: 4, x: 10, y: 40, shape: 'rect', size: 56, area: 'Dekat Kincir', occupied: false },
                    { id: 'CG-7', name: 'CG-7', capacity: 4, x: 32, y: 36, shape: 'round', size: 52, area: 'Dekat Kincir', occupied: true },
                    { id: 'CG-8', name: 'CG-8', capacity: 6, x: 55, y: 40, shape: 'rect', size: 70, area: 'Dekat Kincir', occupied: false },
                    { id: 'CG-9', name: 'CG-9', capacity: 4, x: 78, y: 36, shape: 'rect', size: 56, area: 'Area Garden', occupied: false },
                    { id: 'CG-10', name: 'CG-10', capacity: 8, x: 44, y: 70, shape: 'rect', size: 84, area: 'Tengah', occupied: true },
                ]
            },
            'limburg': {
                name: 'Limburg',
                theme: '🏛️ European Indoor',
                totalTables: 7,
                tables: [
                    { id: 'LB-1', name: 'LB-1', capacity: 2, x: 10, y: 18, shape: 'round', size: 44, area: 'Dekat Jendela', occupied: false },
                    { id: 'LB-2', name: 'LB-2', capacity: 4, x: 30, y: 14, shape: 'rect', size: 56, area: 'Tengah', occupied: true },
                    { id: 'LB-3', name: 'LB-3', capacity: 4, x: 52, y: 18, shape: 'rect', size: 56, area: 'Tengah', occupied: false },
                    { id: 'LB-4', name: 'LB-4', capacity: 2, x: 76, y: 14, shape: 'round', size: 44, area: 'Dekat Dinding', occupied: false },
                    { id: 'LB-5', name: 'LB-5', capacity: 6, x: 18, y: 44, shape: 'rect', size: 70, area: 'Tengah', occupied: false },
                    { id: 'LB-6', name: 'LB-6', capacity: 4, x: 48, y: 42, shape: 'round', size: 52, area: 'Tengah', occupied: true },
                    { id: 'LB-7', name: 'LB-7', capacity: 4, x: 72, y: 44, shape: 'rect', size: 56, area: 'Dekat Dinding', occupied: false },
                ]
            }
        };
        
        // ==================== INIT ====================
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const todayStr = `${year}-${month}-${day}`;

        const maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 7);
        const maxYear = maxDate.getFullYear();
        const maxMonth = String(maxDate.getMonth() + 1).padStart(2, '0');
        const maxDay = String(maxDate.getDate()).padStart(2, '0');
        const maxDateStr = `${maxYear}-${maxMonth}-${maxDay}`;

        const closedDates = @json($closedDates ?? []);

        document.getElementById('input-date').min = todayStr;
        document.getElementById('input-date').max = maxDateStr;
        
        document.getElementById('input-date').addEventListener('change', () => {
            if (!validateSelectedDate()) return;
            updateMinOrderInfo();
            updateRoomAvailability();
        });
        document.getElementById('input-time').addEventListener('change', updateRoomAvailability);
        
        // ==================== GUEST COUNT ====================
        function changeGuests(d) {
            guestCount = Math.max(1, Math.min(20, guestCount + d));
            document.getElementById('guest-count').textContent = guestCount;
        }
        
        // ==================== MIN ORDER INFO ====================
        function updateMinOrderInfo() {
            const val = document.getElementById('input-date').value;
            const info = document.getElementById('min-order-info');
            if (!val) { info.textContent = 'Pilih tanggal untuk melihat info'; return; }
            const d = new Date(val);
            const isWeekend = d.getDay() === 0 || d.getDay() === 6;
            info.innerHTML = isWeekend 
                ? 'Weekend/Hari Libur: <strong>Rp 60.000/orang</strong> (usia 14+)<br>Anak <14 th: Gratis'
                : 'Weekday: <strong>Rp 40.000/orang</strong> (usia 14+)<br>Anak <14 th: Gratis';
        }

        function isClosedDate(date) {
            return closedDates.includes(date);
        }

        function validateSelectedDate() {
            const date = document.getElementById('input-date').value;
            const errorEl = document.getElementById('date-error');

            if (!date) {
                errorEl.classList.add('hidden');
                return true;
            }

            if (isClosedDate(date)) {
                errorEl.textContent = 'Tanggal terpilih ditutup dan tidak dapat dipesan.';
                errorEl.classList.remove('hidden');
                return false;
            }

            errorEl.classList.add('hidden');
            return true;
        }
        
        // ==================== STEP NAVIGATION ====================
        function goToStep(step) {
            // Validate before moving forward
            if (step > currentStep) {
                if (currentStep === 1) {
                    const date = document.getElementById('input-date').value;
                    const time = document.getElementById('input-time').value;
                    if (!date || !time) { alert('Mohon isi tanggal dan waktu'); return; }
                    
                    const now = new Date();
                    const nowYear = now.getFullYear();
                    const nowMonth = String(now.getMonth() + 1).padStart(2, '0');
                    const nowDay = String(now.getDate()).padStart(2, '0');
                    const nowTodayStr = `${nowYear}-${nowMonth}-${nowDay}`;

                    if (date < nowTodayStr) {
                        document.getElementById('date-error').textContent = 'Reservasi minimal hari ini';
                        document.getElementById('date-error').classList.remove('hidden');
                        return;
                    }
                    if (isClosedDate(date)) {
                        document.getElementById('date-error').textContent = 'Tanggal ini ditutup dan tidak dapat dipesan.';
                        document.getElementById('date-error').classList.remove('hidden');
                        return;
                    }
                    document.getElementById('date-error').classList.add('hidden');
                    updateRoomAvailability();
                }
                if (currentStep === 2 && !selectedRoom) { alert('Mohon pilih ruangan'); return; }
                if (currentStep === 3 && !selectedTableId) { alert('Mohon pilih meja'); return; }
            }
            
            // Hide all
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            
            // Show target
            const target = document.getElementById('content-step-' + step);
            target.classList.remove('hidden');
            target.style.opacity = '0'; target.style.transform = 'translateY(15px)';
            requestAnimationFrame(() => {
                target.style.transition = 'all 0.4s ease';
                target.style.opacity = '1'; target.style.transform = 'translateY(0)';
            });
            
            updateStepIndicators(step);
            
            if (step === 3) renderFloorPlan();
            if (step === 4) updateSummary();
            if (step === 5) {
                // Step 5 doesn't need special handling - just scroll
            }
            
            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function updateStepIndicators(step) {
            for (let i = 1; i <= 5; i++) {
                const circle = document.getElementById('step-circle-' + i);
                const num = document.getElementById('step-num-' + i);
                const text = document.getElementById('step-text-' + i);
                
                circle.className = 'step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs border-2';
                
                if (i < step) {
                    circle.classList.add('bg-green-500', 'border-green-500', 'text-white', 'shadow-lg');
                    num.innerHTML = '✓';
                    text.className = 'text-xs font-medium mt-1.5 text-green-600';
                } else if (i === step) {
                    circle.classList.add('bg-amapiano-500', 'border-amapiano-500', 'text-white', 'shadow-lg');
                    num.innerHTML = i;
                    text.className = 'text-xs font-medium mt-1.5 text-amapiano-600';
                } else {
                    circle.classList.add('bg-gray-100', 'border-gray-300', 'text-gray-400');
                    num.innerHTML = i;
                    text.className = 'text-xs font-medium mt-1.5 text-gray-400';
                }
            }
            
            for (let i = 1; i <= 4; i++) {
                const line = document.getElementById('line-' + i);
                line.className = 'h-1 rounded-full progress-line ' + (step > i ? 'bg-green-500' : 'bg-gray-200');
            }
        }
        
        // ==================== ROOM AVAILABILITY ====================
        function updateRoomAvailability() {
            const date = document.getElementById('input-date').value;
            const time = document.getElementById('input-time').value;

            if (!date || !time) return;

            fetch(`/reservations/booked?date=${date}&time=${time}`)
            .then(response => response.json())
            .then(bookedTableIds => {
                Object.keys(rooms).forEach(roomKey => {
                    const room = rooms[roomKey];
                    let occupiedCount = 0;
                    room.tables.forEach((t) => {
                        t.occupied = bookedTableIds.includes(t.id.toLowerCase());
                        if (t.occupied) occupiedCount++;
                    });
                    const avail = room.totalTables - occupiedCount;
                    document.getElementById(roomKey + '-available').textContent = avail + ' meja tersedia';
                    document.getElementById(roomKey + '-occupied').textContent = occupiedCount + ' terisi';
                });
            })
            .catch(err => {
                console.error("Error loading table availability:", err);
            });
        }
        
        // ==================== ROOM SELECTION ====================
        function selectRoom(roomId) {
            selectedRoom = roomId;
            selectedTableId = null;
            
            Object.keys(rooms).forEach(id => {
                const card = document.getElementById('room-' + id);
                const check = card.querySelector('.room-check-mark');
                if (id === roomId) {
                    card.classList.add('selected');
                    card.style.borderColor = '#d88234';
                    check.classList.remove('hidden');
                } else {
                    card.classList.remove('selected');
                    card.style.borderColor = '#e5e7eb';
                    check.classList.add('hidden');
                }
            });
            
            document.getElementById('selected-room-summary').classList.remove('hidden');
            document.getElementById('selected-room-label').textContent = rooms[roomId].name + ' (' + rooms[roomId].theme + ')';
            document.getElementById('btn-step2').disabled = false;
        }
        
        // ==================== FLOOR PLAN ====================
        function renderFloorPlan() {
            const room = rooms[selectedRoom];
            const area = document.getElementById('tables-render-area');
            area.innerHTML = '';
            
            document.getElementById('floorplan-room-name').textContent = room.name + ' — ' + room.theme;
            document.getElementById('floor-plan-label').textContent = room.name.toUpperCase() + ' AREA';
            
            // Add windmill decoration for Covent Garden
            if (selectedRoom === 'covent-garden') {
                const windmill = document.createElement('div');
                windmill.innerHTML = '<svg class="w-12 h-12 text-gray-400/20" viewBox="0 0 100 100"><circle cx="50" cy="50" r="8" fill="currentColor"/><rect x="46" y="10" width="8" height="80" rx="2" fill="currentColor"/><rect x="10" y="46" width="80" height="8" rx="2" fill="currentColor"/></svg>';
                windmill.style.cssText = 'position:absolute; top:8px; right:12px; pointer-events:none;';
                area.appendChild(windmill);
            }
            
            room.tables.forEach(table => {
                const el = document.createElement('div');
                const half = table.size / 2;
                el.className = `table-seat absolute flex items-center justify-center ${table.occupied ? 'bg-red-400/70 border-red-500 cursor-not-allowed' : 'bg-green-500 border-green-600 cursor-pointer'} ${table.shape === 'round' ? 'rounded-full' : 'rounded-lg'} border-2`;
                el.style.cssText = `left:${table.x}%; top:${table.y}%; width:${table.size}px; height:${table.size}px;`;
                el.dataset.tableId = table.id;
                
                const lbl = document.createElement('span');
                lbl.className = 'table-label';
                lbl.textContent = table.name;
                lbl.style.fontSize = table.size < 48 ? '9px' : '11px';
                el.appendChild(lbl);
                
                const cap = document.createElement('span');
                cap.style.cssText = 'position:absolute; bottom:-14px; left:50%; transform:translateX(-50%); font-size:8px; color:#6b7280; font-weight:600; white-space:nowrap; pointer-events:none;';
                cap.textContent = '👤' + table.capacity;
                el.appendChild(cap);
                
                if (!table.occupied) {
                    el.onclick = () => pickTable(table.id);
                    el.onmouseenter = (e) => showTableTooltip(table, e);
                    el.onmouseleave = hideTableTooltip;
                }
                
                area.appendChild(el);
            });
            
            document.getElementById('selected-table-info').classList.add('hidden');
            document.getElementById('btn-step3').disabled = true;
            selectedTableId = null;
        }
        
        function pickTable(tableId) {
            selectedTableId = tableId;
            const room = rooms[selectedRoom];
            
            document.querySelectorAll('.table-seat').forEach(el => {
                const tid = el.dataset.tableId;
                el.classList.remove('selected', 'bg-amapiano-500', 'border-amapiano-600');
                const tbl = room.tables.find(t => t.id === tid);
                if (tbl && !tbl.occupied) {
                    if (tid === tableId) {
                        el.classList.add('selected', 'bg-amapiano-500', 'border-amapiano-600');
                    } else {
                        el.classList.add('bg-green-500', 'border-green-600');
                        el.classList.remove('bg-red-400/70', 'border-red-500');
                    }
                }
            });
            
            const table = room.tables.find(t => t.id === tableId);
            document.getElementById('selected-table-info').classList.remove('hidden');
            document.getElementById('selected-tbl-name').textContent = table.name;
            document.getElementById('selected-tbl-detail').textContent = `Kapasitas: ${table.capacity} orang • ${table.area}`;
            document.getElementById('btn-step3').disabled = false;
            
            hideTableTooltip();
        }
        
        function clearTableSelection() {
            selectedTableId = null;
            renderFloorPlan();
        }
        
        // ==================== TABLE TOOLTIP ====================
        let tooltipEl = null;
        function showTableTooltip(table, event) {
            if (tooltipEl) tooltipEl.remove();
            
            tooltipEl = document.createElement('div');
            tooltipEl.style.cssText = 'position:absolute; background:white; border-radius:10px; padding:10px 14px; box-shadow:0 8px 30px rgba(0,0,0,0.15); z-index:50; font-size:11px; pointer-events:none; min-width:160px;';
            
            const status = table.occupied 
                ? '<span class="text-red-500 font-semibold">Terisi</span>' 
                : '<span class="text-green-500 font-semibold">Tersedia ✓</span>';
            
            tooltipEl.innerHTML = `
                <p class="font-display font-bold text-gray-900 text-sm">${table.name}</p>
                <p class="text-gray-500 mt-0.5">👤 ${table.capacity} orang • ${table.area}</p>
                <p class="mt-1">Status: ${status}</p>
            `;
            
            const wrapper = document.getElementById('floor-plan-wrapper');
            const rect = wrapper.getBoundingClientRect();
            let left = event.clientX - rect.left + 12;
            let top = event.clientY - rect.top - 10;
            if (left + 170 > rect.width) left = event.clientX - rect.left - 175;
            if (top + 80 > rect.height) top = rect.height - 85;
            if (top < 5) top = 5;
            
            tooltipEl.style.left = left + 'px';
            tooltipEl.style.top = top + 'px';
            wrapper.appendChild(tooltipEl);
        }
        
        function hideTableTooltip() {
            if (tooltipEl) { tooltipEl.remove(); tooltipEl = null; }
        }
        
        // ==================== SUMMARY ====================
        function updateSummary() {
            const room = rooms[selectedRoom];
            const table = room.tables.find(t => t.id === selectedTableId);
            const date = document.getElementById('input-date').value;
            const time = document.getElementById('input-time').value;
            const dateObj = new Date(date);
            const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            
            document.getElementById('summary-room').textContent = room.name;
            document.getElementById('summary-table').textContent = table.name;
            document.getElementById('summary-date').textContent = dateObj.toLocaleDateString('id-ID', opts);
            document.getElementById('summary-time').textContent = time + ' WIB';
            document.getElementById('summary-guests').textContent = guestCount + ' orang';
        }
        
        // ==================== CONFIRM BOOKING ====================
        function confirmBooking() {
            const name = document.getElementById('input-name').value.trim();
            const phone = document.getElementById('input-phone').value.trim();
            const rules = document.getElementById('rules-check').checked;
            
            if (!name || !phone) { alert('Mohon isi nama dan nomor HP'); return; }
            if (!rules) { alert('Mohon centang persetujuan aturan'); return; }
            
            const room = rooms[selectedRoom];
            const table = room.tables.find(t => t.id === selectedTableId);
            const date = document.getElementById('input-date').value;
            const time = document.getElementById('input-time').value;
            const email = document.getElementById('input-email').value;
            const notes = document.getElementById('input-notes').value;
            const dateObj = new Date(date);
            const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

            let areaVal = 'Main Hall';
            if (selectedRoom === 'covent-garden') areaVal = 'Terrace';
            if (selectedRoom === 'limburg') areaVal = 'VIP Lounge';

            const payload = {
                fullname: name,
                phone: phone,
                date: date,
                time: time,
                area: areaVal,
                table_id: selectedTableId.toLowerCase(),
                guests: guestCount,
                notes: notes
            };

            const btn = document.getElementById('btn-step4');
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Memproses...';

            fetch('/reservations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Fill ticket
                    document.getElementById('ticket-booking-code').textContent = '#' + data.reservation.code;
                    document.getElementById('ticket-room').textContent = room.name;
                    document.getElementById('ticket-table').textContent = data.reservation.table_name;
                    document.getElementById('ticket-date').textContent = dateObj.toLocaleDateString('id-ID', opts);
                    document.getElementById('ticket-time').textContent = time + ' WIB';
                    document.getElementById('ticket-name').textContent = name;
                    document.getElementById('ticket-phone').textContent = phone;
                    
                    // Set QR Code source using the backend-generated base64 SVG
                    document.getElementById('qr-code').src = 'data:image/svg+xml;base64,' + data.reservation.qr_code;
                    
                    // Navigate to step 5 instead of showing modal
                    goToStep(5);
                    createConfetti();
                } else {
                    alert('Gagal membuat reservasi: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(err => {
                console.error(err);
                alert(err.message || 'Terjadi kesalahan saat menghubungi server. Silakan coba lagi.');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = originalText;
            });
        }
        

        
        // ==================== CONFETTI ====================
        function createConfetti() {
            const colors = ['#d88234', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#3b82f6'];
            for (let i = 0; i < 60; i++) {
                const piece = document.createElement('div');
                piece.className = 'confetti-piece';
                piece.style.left = Math.random() * 100 + 'vw';
                piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                piece.style.animationDelay = Math.random() * 1.5 + 's';
                piece.style.animationDuration = (Math.random() * 2 + 2) + 's';
                piece.style.width = (Math.random() * 8 + 5) + 'px';
                piece.style.height = (Math.random() * 8 + 5) + 'px';
                document.body.appendChild(piece);
                setTimeout(() => piece.remove(), 4000);
            }
        }
        
        // ==================== RESET ====================
        function resetAll() {
            document.getElementById('success-modal').classList.add('hidden');
            document.getElementById('input-date').value = '';
            document.getElementById('input-time').value = '';
            document.getElementById('input-name').value = '';
            document.getElementById('input-phone').value = '';
            document.getElementById('input-email').value = '';
            document.getElementById('input-notes').value = '';
            document.getElementById('rules-check').checked = false;
            guestCount = 2;
            document.getElementById('guest-count').textContent = '2';
            selectedRoom = null;
            selectedTableId = null;
            
            Object.keys(rooms).forEach(id => {
                const card = document.getElementById('room-' + id);
                card.classList.remove('selected');
                card.style.borderColor = '#e5e7eb';
                card.querySelector('.room-check-mark').classList.add('hidden');
            });
            
            document.getElementById('selected-room-summary').classList.add('hidden');
            document.getElementById('btn-step2').disabled = true;
            document.getElementById('btn-step3').disabled = true;
            document.getElementById('btn-step4').disabled = true;
            document.getElementById('selected-table-info').classList.add('hidden');
            document.getElementById('date-error').classList.add('hidden');
            document.getElementById('min-order-info').textContent = 'Pilih tanggal untuk melihat info';
            
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('content-step-1').classList.remove('hidden');
            currentStep = 1;
            updateStepIndicators(1);
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        // Enable/disable step 4 button
        document.getElementById('input-name').addEventListener('input', checkStep4);
        document.getElementById('input-phone').addEventListener('input', checkStep4);
        document.getElementById('rules-check').addEventListener('change', checkStep4);
        
        function checkStep4() {
            const name = document.getElementById('input-name').value.trim();
            const phone = document.getElementById('input-phone').value.trim();
            const rules = document.getElementById('rules-check').checked;
            document.getElementById('btn-step4').disabled = !(name && phone && rules);
        }
        
        
        // ==================== CLOSE MODAL & DOWNLOAD TICKET ====================
        function closeModal() {
            document.getElementById('success-modal').classList.add('hidden');
        }

        function downloadTicket() {
            const code = document.getElementById('ticket-booking-code').textContent.replace('#', '');
            window.location.href = `/reservations/${code}/download`;
        }

        // Close tooltip on click outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.table-seat') && tooltipEl) {
                hideTableTooltip();
            }
        });
    </script>
@endpush

</div>



</x-layouts.app>

