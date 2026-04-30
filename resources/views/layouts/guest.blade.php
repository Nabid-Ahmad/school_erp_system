<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/banner.png') }}');">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-white tracking-tight">Bangla Model School</h1>
                <p class="text-blue-200 mt-2 text-lg">Excellence in Education since 1995</p>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-3xl border border-white/20">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Member Login</h2>
                    <p class="text-gray-500 text-sm">Please enter your credentials to continue</p>
                </div>
                {{ $slot }}
            </div>

            <footer class="mt-12 text-white/70 text-center text-sm">
                <p>&copy; {{ date('Y') }} Bangla Model School. All rights reserved.</p>
                <div class="flex gap-4 justify-center mt-2">
                    <a href="#" class="hover:text-white">Privacy Policy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white">Terms of Service</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white">Contact Support</a>
                </div>
            </footer>
        </div>
    </body>
</html>
