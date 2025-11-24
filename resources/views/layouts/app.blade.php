<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
                <meta name="description" content="HasbiStore - Your Premium Shopping Destination. Find everything you need in one place.">
        <meta name="author" content="HasbiStore">
        
        <!-- Favicon -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛒</text></svg>">

        <title>{{ config('app.name', 'HasbiStore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Loading State Styles -->
        <style>
            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            }
            .loading-overlay.active {
                display: flex;
            }
            .spinner {
                border: 4px solid #f3f4f6;
                border-top: 4px solid #6366f1;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="text-center">
                <div class="spinner mx-auto mb-4"></div>
                <p class="text-gray-600 font-semibold">Loading...</p>
            </div>
        </div>

        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-900 px-6 py-4 rounded-lg shadow-md animate-fade-in">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">✅</span>
                            <div>
                                <p class="font-semibold">Success!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-900 px-6 py-4 rounded-lg shadow-md animate-fade-in">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">❌</span>
                            <div>
                                <p class="font-semibold">Error!</p>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 text-yellow-900 px-6 py-4 rounded-lg shadow-md animate-fade-in">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">⚠️</span>
                            <div>
                                <p class="font-semibold">Warning!</p>
                                <p class="text-sm">{{ session('warning') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-gray-600 text-sm">
                        <p>&copy; {{ date('Y') }} HasbiStore. All rights reserved.</p>
                        <p class="mt-2">Built with ❤️ using Laravel & Tailwind CSS</p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Loading Script -->
        <script>
            // Show loading on form submit
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form');
                const loadingOverlay = document.getElementById('loadingOverlay');
                
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        if (loadingOverlay) {
                            loadingOverlay.classList.add('active');
                        }
                    });
                });

                // Auto-hide flash messages after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.animate-fade-in');
                    alerts.forEach(alert => {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);
            });
        </script>
    </body>
</html>
