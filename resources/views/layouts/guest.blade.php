<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'School ERP') }} - Portal Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary': '#2563EB',
                            'primary-hover': '#1d4ed8',
                        }
                    }
                }
            }
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden !important;
                font-family: 'Figtree', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-950 h-screen w-screen overflow-hidden relative"
          style="background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.72) 0%, rgba(30, 58, 138, 0.82) 100%), url('{{ asset('images/banner.png') }}'); background-size: cover; background-position: center;">
        
        <!-- Full Page Ambient Radial Overlay -->
        <div class="absolute inset-0 bg-radial from-blue-500/10 via-transparent to-black/50 pointer-events-none"></div>

        <div class="h-screen w-screen grid grid-cols-1 lg:grid-cols-12 relative z-10 overflow-hidden">
            
            <!-- Left Side: Branding & Visuals (7 Cols on LG) -->
            <div class="hidden lg:flex lg:col-span-7 h-full flex-col justify-between p-10 xl:p-14 text-white relative">
                
                <!-- Ambient Accent Glow Orbs -->
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Top Header -->
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white shadow-xl">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-white">Bangla Model School</h2>
                        <p class="text-xs font-semibold text-blue-300">Excellence in Education since 1995</p>
                    </div>
                </div>

                <!-- Hero Content -->
                <div class="relative z-10 max-w-xl space-y-5 my-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/15 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        Academic ERP Portal
                    </div>

                    <h1 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight drop-shadow-md">
                        Empowering Education Through Innovation.
                    </h1>

                    <p class="text-slate-300 text-sm xl:text-base leading-relaxed font-medium">
                        Seamlessly manage student records, faculty profiles, fee collections, attendance, and exam results with an all-in-one smart school system.
                    </p>

                    <!-- Feature Pills -->
                    <div class="pt-2 flex flex-wrap gap-2.5 text-xs font-bold text-slate-300">
                        <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/15 backdrop-blur-md flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Secure Access
                        </div>
                        <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/15 backdrop-blur-md flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Real-Time Analytics
                        </div>
                        <div class="px-3.5 py-2 rounded-xl bg-white/10 border border-white/15 backdrop-blur-md flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Automated Payroll
                        </div>
                    </div>
                </div>

                <!-- Footer Quote -->
                <div class="relative z-10 border-t border-white/15 pt-4 text-xs text-slate-400 flex justify-between items-center">
                    <p>&copy; {{ date('Y') }} Bangla Model School. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Support</a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Floating Login Card directly over Full Campus Background (5 Cols on LG) -->
            <div class="col-span-1 lg:col-span-5 h-full flex flex-col justify-between p-6 sm:p-8 lg:p-10 relative overflow-hidden">
                
                <!-- Mobile Logo Header -->
                <div class="lg:hidden flex items-center gap-3 relative z-10">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-white">Bangla Model School</h2>
                        <p class="text-[10px] font-bold text-blue-300">School ERP System</p>
                    </div>
                </div>

                <!-- High-Contrast Floating Card Container directly over Campus Image -->
                <div class="my-auto max-w-sm w-full mx-auto relative z-10 bg-white/95 backdrop-blur-xl rounded-[2.25rem] shadow-2xl p-7 sm:p-9 border border-white/80 text-slate-900">
                    {{ $slot }}
                </div>

                <!-- Right Side Bottom Footer -->
                <div class="text-center text-xs font-semibold text-slate-300/80 relative z-10">
                    <p>Powered by Smart School ERP Solution</p>
                </div>
            </div>

        </div>
    </body>
</html>
