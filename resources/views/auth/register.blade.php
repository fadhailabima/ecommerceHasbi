<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
        <p class="text-gray-600">Join us and start shopping today!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="name" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="username" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                type="text" 
                name="username" 
                :value="old('username')" 
                required
                placeholder="Choose a unique username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="email" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="your.email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number (Optional)')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="phone" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                type="text" 
                name="phone" 
                :value="old('phone')"
                placeholder="08123456789" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />

            <x-text-input id="password" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="Minimum 8 characters" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700" />

            <x-text-input id="password_confirmation" 
                class="block mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Re-enter your password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                {{ __('Create Account') }}
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 underline transition">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
