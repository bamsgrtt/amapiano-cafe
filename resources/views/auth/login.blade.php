<x-layouts.app title="Login - Amapiano Cafe">
    <div class="flex items-center justify-center min-h-[70vh] py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white/80 backdrop-blur-md rounded-3xl border border-[#E6E0D5] p-8 shadow-xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-50 text-orange-600 mb-4">
                    <i class="fa-solid fa-right-to-bracket text-xl"></i>
                </div>
                <h2 class="text-3xl font-serif text-[#2B231D] tracking-tight">Welcome Back</h2>
                <p class="text-sm text-[#7A7067] mt-2 font-light">
                    Sign in to your account to manage your reservations.
                </p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ Route::has('login') ? route('login') : '#' }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-[11px] font-semibold text-[#7A7067] uppercase tracking-wider">Email Address</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-[#7A7067]">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 bg-[#FAF8F5] border border-[#E6E0D5] rounded-xl text-sm text-[#2B231D] focus-glow transition duration-200 placeholder-gray-400"
                            placeholder="you@example.com" />
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-[11px] font-semibold text-[#7A7067] uppercase tracking-wider">Password</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-[#7A7067]">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full pl-10 pr-4 py-3 bg-[#FAF8F5] border border-[#E6E0D5] rounded-xl text-sm text-[#2B231D] focus-glow transition duration-200 placeholder-gray-400"
                            placeholder="••••••••" />
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#C5A880] shadow-sm focus:ring-[#C5A880]" name="remember">
                        <span class="ml-2 text-sm text-[#7A7067]">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-[#C5A880] hover:text-[#A68A61] transition-colors" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-[#D4AF37] to-[#F5A623] hover:from-[#C09E30] hover:to-[#E59518] text-white font-semibold text-sm tracking-wide uppercase shadow-lg shadow-amber-500/20 hover:shadow-amber-500/35 active:scale-[0.99] transition-all duration-200">
                    Sign In
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center text-sm text-[#7A7067]">
                Don't have an account? 
                <a href="{{ Route::has('register') ? route('register') : '/register' }}" class="font-semibold text-[#2B231D] hover:text-[#C5A880] transition-colors">
                    Create one now
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
