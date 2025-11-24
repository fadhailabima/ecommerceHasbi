<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
                <meta name="description" content="MegaStore - Welcome to Your Ultimate Shopping Destination">
        
        <!-- Favicon -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛒</text></svg>">

        <title>{{ config('app.name', 'MegaStore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100">
            <div>
                <a href="/">
                                            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg p-3">
                            <span class="text-3xl">🏬</span>
                        </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-gray-600 text-sm">
                                <p class="text-sm text-gray-500">© {{ date('Y') }} MegaStore. All rights reserved.</p>
                <p class="text-xs text-gray-400 mt-1">Everything You Need, One Stop 🏬</p>
            </div>
        </div>
    </body>
</html>
