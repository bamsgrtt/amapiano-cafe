<x-layouts.app title="Register - Amapiano Cafe">
    <div class="flex items-center justify-center min-h-[70vh] py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg bg-white/80 backdrop-blur-md rounded-3xl border border-[#E6E0D5] p-8 shadow-xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-50 text-orange-600 mb-4">
                    <i class="fa-regular fa-id-card text-xl"></i>
                </div>
                <h2 class="text-3xl font-serif text-[#2B231D] tracking-tight">Create Account</h2>
                <p class="text-sm text-[#7A7067] mt-2 font-light">
                    Join Amapiano Cafe for faster reservations and exclusive offers.
                </p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ Route::has('register') ? route('register') : '#' }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-[11px] font-semibold text-[#7A7067] uppercase tracking-wider">Full Name</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-[#7A7067]">
                            <i class="fa-regular fa-user"></i>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="w-full pl-10 pr-4 py-3 bg-[#FAF8F5] border border-[#E6E0D5] rounded-xl text-sm text-[#2B231D] focus-glow transition duration-200 placeholder-gray-400"
                            placeholder="E.g., Alexander Carter" />
                    </div>
                    @error('name')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-[11px] font-semibold text-[#7A7067] uppercase tracking-wider">Email Address</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-[#7A7067]">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full pl-10 pr-4 py-3 bg-[#FAF8F5] border border-[#E6E0D5] rounded-xl text-sm text-[#2B231D] focus-glow transition duration-200 placeholder-gray-400"
                            placeholder="you@example.com" />
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-[11px] font-semibold text-[#7A7067] uppercase tracking-wider">Password</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-[#7A7067]">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full pl-10 pr-4 py-3 bg-[#FAF8F5] border border-[#E6E0D5] rounded-xl text-sm text-[#2B231D] focus-glow transition duration-200 placeholder-gray-400"
                                placeholder="••••••••" />
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-[11px] font-semibold text-[#7A7067] uppercase tracking-wider">Confirm Password</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-[#7A7067]">
                                <i class="fa-solid fa-lock text-xs opacity-70"></i>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full pl-10 pr-4 py-3 bg-[#FAF8F5] border border-[#E6E0D5] rounded-xl text-sm text-[#2B231D] focus-glow transition duration-200 placeholder-gray-400"
                                placeholder="••••••••" />
                        </div>
                        @error('password_confirmation')
                            <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-4 py-3.5 px-4 rounded-xl bg-[#2B231D] hover:bg-[#40352C] text-white font-semibold text-sm tracking-wide uppercase shadow-lg shadow-gray-900/20 active:scale-[0.99] transition-all duration-200">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center text-sm text-[#7A7067]">
                Already have an account? 
                <a href="{{ Route::has('login') ? route('login') : '/login' }}" class="font-semibold text-[#D4AF37] hover:text-[#C09E30] transition-colors">
                    Sign in here
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
