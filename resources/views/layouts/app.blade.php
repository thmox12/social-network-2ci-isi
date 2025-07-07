<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter antialiased bg-slate-50">
        <!-- Toast Notification Container -->
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2" role="region" aria-label="Notifications"></div>
        
        <!-- Loading Overlay -->
        <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden items-center justify-center">
            <div class="bg-white rounded-lg p-6 shadow-xl">
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                    <span class="text-gray-700 font-medium">Processing...</span>
                </div>
            </div>
        </div>

        <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 sticky top-0 z-30">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-8">
                {{ $slot }}
            </main>
        </div>

        <!-- Session Messages as Toast -->
        @if(session('success') || session('error') || session('info'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if(session('success'))
                        showToast('{!! addslashes(session('success')) !!}', 'success');
                    @endif
                    @if(session('error'))
                        showToast('{!! addslashes(session('error')) !!}', 'error');
                    @endif
                    @if(session('info'))
                        showToast('{!! addslashes(session('info')) !!}', 'info');
                    @endif
                });
            </script>
        @endif
    </body>
</html>
