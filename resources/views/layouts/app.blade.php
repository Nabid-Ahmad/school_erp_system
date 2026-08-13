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
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'light-green': '#f0fdf4',
                            'deep-green': '#15803d',
                            'primary': '#2563EB',
                            'success': '#22C55E',
                            'warning': '#EAB308',
                            'danger': '#EF4444',
                        }
                    }
                }
            }
        </script>
        <style>
            /* Modern Input & Dropdown Styling */
            input[type="text"],
            input[type="number"],
            input[type="email"],
            input[type="date"],
            input[type="password"],
            input[type="search"],
            input[type="file"],
            select,
            textarea {
                width: 100% !important;
                border: 1.5px solid #cbd5e1 !important;
                border-radius: 0.75rem !important;
                padding: 0.65rem 1rem !important;
                background-color: #f8fafc !important;
                color: #0f172a !important;
                font-size: 0.875rem !important;
                font-weight: 600 !important;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                outline: none !important;
            }

            input[type="text"]:hover,
            input[type="number"]:hover,
            input[type="email"]:hover,
            input[type="date"]:hover,
            input[type="password"]:hover,
            input[type="search"]:hover,
            select:hover,
            textarea:hover {
                border-color: #94a3b8 !important;
                background-color: #ffffff !important;
            }

            input[type="text"]:focus,
            input[type="number"]:focus,
            input[type="email"]:focus,
            input[type="date"]:focus,
            input[type="password"]:focus,
            input[type="search"]:focus,
            select:focus,
            textarea:focus {
                border-color: #2563eb !important;
                background-color: #ffffff !important;
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.14) !important;
                outline: none !important;
            }

            select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%6b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
                background-position: right 0.75rem center !important;
                background-repeat: no-repeat !important;
                background-size: 1.25em 1.25em !important;
                padding-right: 2.5rem !important;
                cursor: pointer !important;
            }

            label {
                font-size: 0.75rem !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                color: #475569 !important;
                margin-bottom: 0.375rem !important;
                display: block !important;
            }
        </style>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex overflow-hidden" x-data="{ sidebarOpen: false }">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 p-6 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
