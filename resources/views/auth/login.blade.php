<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back!</h2>
        <p class="text-gray-600">Sign in to your account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Username or Email -->
        <div>
            <x-input-label for="login" :value="__('Username atau Email')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="login" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                type="text" 
                name="login" 
                :value="old('login')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter your username or email" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />

            <x-text-input id="password" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600 hover:text-gray-800">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-800 underline transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                {{ __('Sign In') }}
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 underline transition">
                    Register here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
