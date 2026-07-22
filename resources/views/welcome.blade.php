<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bangla Model School | Excellence in Nature & Education</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,600,800|playfair-display:700" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
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
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s ease-out;
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }
            .bg-light-green { background-color: #f0fdf4; } /* Green 50 */
            .bg-deep-green { background-color: #15803d; } /* Green 700 */
            .text-deep-green { color: #166534; } /* Green 800 */
            .border-green { border-color: #22c55e; } /* Green 500 */
        </style>
    </head>
    <body class="antialiased bg-light-green text-green-900 font-['Outfit']">
        
        <!-- Navigation Bar -->
        <nav class="fixed w-full z-50 bg-white/70 backdrop-blur-xl border-b border-green/10 transition-all duration-300">
            <!-- Global Notification Toast -->
            @if(session('success') || session('error'))
            <div id="toast" class="absolute top-24 left-1/2 -translate-x-1/2 z-[60] min-w-[320px] animate-bounce">
                <div class="{{ session('success') ? 'bg-deep-green' : 'bg-red-600' }} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4">
                    <div class="bg-white/20 p-2 rounded-xl">
                        @if(session('success'))
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @endif
                    </div>
                    <p class="font-bold text-sm">{{ session('success') ?? session('error') }}</p>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast');
                    if(toast) {
                        toast.style.transition = 'all 0.5s ease-out';
                        toast.style.opacity = '0';
                        toast.style.transform = 'translate(-50%, -20px)';
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 5000);
            </script>
            @endif

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
                <div class="flex justify-between h-20 items-center">
                    <a href="#" class="flex items-center gap-3 group cursor-pointer">
                        @if(isset($schoolSettings['school_logo']))
                            <img src="{{ filter_var($schoolSettings['school_logo'] ?? '', FILTER_VALIDATE_URL) ? $schoolSettings['school_logo'] : asset('storage/'.($schoolSettings['school_logo'] ?? '')) }}" class="w-12 h-12 rounded-xl object-contain bg-white/50 p-1">
                        @else
                            <div class="w-12 h-12 bg-deep-green rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg group-hover:rotate-12 transition-transform">
                                {{ substr($schoolSettings['school_name'] ?? 'B', 0, 1) }}
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-xl font-black text-deep-green tracking-tight leading-none uppercase">{{ $schoolSettings['school_name'] ?? 'Bangla Model' }}</span>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-green-500 font-bold">Nature & Knowledge</span>
                        </div>
                    </a>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center gap-8 text-sm font-bold uppercase tracking-wider">
                        <a href="#" class="text-deep-green hover:opacity-70 transition">Home</a>
                        <a href="#admission" class="text-gray-500 hover:text-deep-green transition">Admission</a>
                        <a href="#gallery" class="text-gray-500 hover:text-deep-green transition">Gallery</a>
                        <a href="#events" class="text-gray-500 hover:text-deep-green transition">Events</a>
                        <a href="#contact" class="text-gray-500 hover:text-deep-green transition">Contact Us</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-deep-green text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-800 transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="bg-deep-green text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-800 transition">Login</a>
                            @endauth
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="lg:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-deep-green focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div x-show="mobileMenuOpen" x-transition style="display: none;" class="lg:hidden absolute top-20 left-0 w-full bg-white shadow-xl border-t border-green-100 flex flex-col px-6 py-4 space-y-4 font-bold text-sm uppercase tracking-wider z-50">
                    <a href="#" @click="mobileMenuOpen = false" class="block text-deep-green hover:opacity-70 transition">Home</a>
                    <a href="#admission" @click="mobileMenuOpen = false" class="block text-gray-500 hover:text-deep-green transition">Admission</a>
                    <a href="#gallery" @click="mobileMenuOpen = false" class="block text-gray-500 hover:text-deep-green transition">Gallery</a>
                    <a href="#events" @click="mobileMenuOpen = false" class="block text-gray-500 hover:text-deep-green transition">Events</a>
                    <a href="#contact" @click="mobileMenuOpen = false" class="block text-gray-500 hover:text-deep-green transition">Contact Us</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block bg-deep-green text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-800 transition text-center mt-2">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block bg-deep-green text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-800 transition text-center mt-2">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden bg-gradient-to-b from-green-100 to-light-green">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="reveal active">
                        <span class="inline-block px-5 py-2 bg-deep-green/10 text-deep-green text-xs font-black rounded-full mb-8 uppercase tracking-[0.3em]">Igniting Minds Since 1995</span>
                        <h1 class="text-6xl lg:text-[7.5rem] font-black text-deep-green leading-[0.95] mb-8 font-['Playfair_Display']">
                            Nurturing <span class="italic text-green-400">Excellence</span>, Inspiring Tomorrow.
                        </h1>
                        <p class="text-lg text-green-800/80 mb-12 leading-relaxed max-w-lg font-medium">
                            We transcend traditional education to cultivate a dynamic environment where curiosity thrives, character is forged, and every student is empowered to reach their boundless potential. Discover the foundation for your child's brilliant future.
                        </p>
                        <div class="flex flex-wrap gap-6">
                            <a href="#contact" class="bg-deep-green text-white px-10 py-5 rounded-2xl font-bold text-lg hover:-translate-y-1 transition shadow-2xl">
                                Join Our Family
                            </a>
                            <div class="flex items-center gap-4 group cursor-pointer">
                                <div class="w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center text-deep-green group-hover:scale-110 transition">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6V4z"/></svg>
                                </div>
                                <span class="font-bold text-green-600">Explore Campus</span>
                            </div>
                        </div>
                    </div>
                    <div class="relative reveal active delay-500">
                        <div class="animate-float">
                            <img src="{{ asset('images/banner.png') }}" class="relative z-10 rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(21,128,61,0.2)] border-[12px] border-white object-cover aspect-[4/3]" alt="Campus">
                        </div>
                        <div class="absolute -bottom-10 -left-10 z-20 bg-white p-6 rounded-3xl shadow-2xl flex items-center gap-4 animate-bounce duration-[3000ms]">
                            <div class="w-12 h-12 bg-deep-green rounded-full flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-bold uppercase">Admission 2026</div>
                                <div class="text-sm font-black text-deep-green">Seats are Limited!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admission Section -->
        <section id="admission" class="py-20 bg-gray-50/50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <!-- Left: Admission Details -->
                    <div class="reveal">
                        <h2 class="text-5xl font-black text-deep-green mb-8 font-['Playfair_Display'] italic leading-tight">Admission Information <br> & Guidelines</h2>
                        <p class="text-gray-500 text-lg mb-12 font-medium">Join the Bangla Model School family. We ensure a transparent and straightforward admission process for every student.</p>
                        
                        <div class="space-y-10">
                            <!-- Process -->
                            <div class="flex gap-6 group">
                                <div class="w-16 h-16 bg-green-100 rounded-3xl flex items-center justify-center text-3xl group-hover:bg-deep-green group-hover:text-white transition-all">📝</div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 mb-2 tracking-tight">Simple Application Process</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">Collect forms from our office and submit with accurate details. We handle the rest.</p>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="flex gap-6 group">
                                <div class="w-16 h-16 bg-blue-100 rounded-3xl flex items-center justify-center text-3xl group-hover:bg-blue-600 group-hover:text-white transition-all">📁</div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 mb-2 tracking-tight">Required Documents</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">Birth certificate, 4 passport size photos, and parent's NID photocopy are mandatory.</p>
                                </div>
                            </div>

                            <!-- Timing -->
                            <div class="flex gap-6 group">
                                <div class="w-16 h-16 bg-orange-100 rounded-3xl flex items-center justify-center text-3xl group-hover:bg-orange-500 group-hover:text-white transition-all">⏰</div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 mb-2 tracking-tight">School Timing</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">Morning: 08:00 AM - 12:00 PM | Day: 12:30 PM - 04:30 PM</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-14">
                            <a href="#contact" class="inline-flex items-center gap-4 bg-deep-green text-white px-10 py-5 rounded-2xl font-black shadow-2xl shadow-green-900/20 hover:scale-105 transition-all">
                                <span>Inquire Now</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Admission Image -->
                    <div class="relative reveal" style="transition-delay: 300ms;">
                        <div class="relative z-10 rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(21,128,61,0.3)] border-[12px] border-white">
                            <img src="{{ asset('images/admission_banner.png') }}" class="w-full h-full object-cover" alt="Student Admission">
                        </div>
                        <!-- Abstract Elements -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-green-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-deep-green/10 rounded-full blur-[100px]"></div>
                        
                        <!-- Floating Stat -->
                        <div class="absolute bottom-10 -right-10 z-20 bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-50 animate-bounce duration-[4000ms]">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center text-white text-xl">✨</div>
                                <div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Available Seats</p>
                                    <p class="text-xl font-black text-deep-green">Admission Open 2026</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="py-20 bg-[#f0fdf4]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20 reveal">
                    <h2 class="text-5xl font-black text-deep-green mb-4 font-['Playfair_Display'] italic">Our Gallery</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Capturing the vibrant life and activities of our students through the lens.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($galleries as $gallery)
                    <div class="reveal flex flex-col overflow-hidden rounded-3xl bg-white shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-gray-100">
                        <div class="relative overflow-hidden h-72">
                            <img src="{{ filter_var($gallery->image, FILTER_VALIDATE_URL) ? $gallery->image : asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out" alt="{{ $gallery->title }}">
                            <div class="absolute inset-0 bg-deep-green/0 group-hover:bg-deep-green/10 transition-colors duration-300"></div>
                        </div>
                        <div class="p-6 relative bg-white transition-colors duration-300">
                            <div class="w-12 h-1 bg-gray-200 group-hover:bg-deep-green transition-colors duration-300 mb-4 rounded-full"></div>
                            <h3 class="font-black text-xl text-gray-800 group-hover:text-deep-green transition-colors duration-300 pr-8">{{ $gallery->title }}</h3>
                            
                            <!-- Arrow icon -->
                            <div class="absolute bottom-6 right-6 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 text-deep-green">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center text-gray-400 font-bold">Our memories are being uploaded...</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Swiper.js CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- Events Section -->
        <section id="events" class="py-20 bg-light-green overflow-hidden border-t border-green-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20 reveal relative">
                    <h2 class="text-5xl font-black text-deep-green font-['Playfair_Display'] italic mb-4">Our Events</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Witness the joy and learning in our campus life.</p>
                    
                    <div class="hidden md:flex gap-4 absolute right-0 bottom-0">
                        <button class="swiper-prev w-12 h-12 rounded-full border-2 border-deep-green flex items-center justify-center text-deep-green hover:bg-deep-green hover:text-white transition cursor-pointer">
                            &larr;
                        </button>
                        <button class="swiper-next w-12 h-12 rounded-full border-2 border-deep-green flex items-center justify-center text-deep-green hover:bg-deep-green hover:text-white transition cursor-pointer">
                            &rarr;
                        </button>
                    </div>
                </div>
                
                <div class="swiper eventSwiper">
                    <div class="swiper-wrapper">
                        @forelse($events as $event)
                        <div class="swiper-slide">
                            <div class="reveal overflow-hidden rounded-[2.5rem] shadow-xl hover:shadow-2xl transition group bg-white h-full flex flex-col">
                                <div class="relative overflow-hidden h-72">
                                    @if($event->image)
                                        <img src="{{ filter_var($event->image, FILTER_VALIDATE_URL) ? $event->image : asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $event->title }}">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold">Bangla Model Event</div>
                                    @endif
                                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-2xl shadow-lg text-center">
                                        <div class="text-xl font-black text-deep-green leading-none">{{ $event->date->format('d') }}</div>
                                        <div class="text-[10px] uppercase font-bold text-green-600 mt-1">{{ $event->date->format('M') }}</div>
                                    </div>
                                </div>
                                <div class="p-8 flex-1">
                                    <h3 class="font-black text-xl text-deep-green mb-4">{{ $event->title }}</h3>
                                    <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">{{ $event->description }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide py-12 text-center text-gray-400">Events are being scheduled...</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <script>
            // Initialize Swiper
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.eventSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.swiper-next',
                        prevEl: '.swiper-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 }
                    },
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                });
            });
        </script>

        <!-- Contact Us Section -->
        <section id="contact" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gradient-to-br from-deep-green to-green-900 rounded-[4rem] p-8 lg:p-16 text-white reveal overflow-hidden relative shadow-2xl">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/leaf.png')] mix-blend-overlay"></div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-green-500/20 rounded-full blur-3xl"></div>

                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                        <div>
                            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-md">Get in Touch</span>
                            <h2 class="text-4xl lg:text-5xl font-black mb-6 font-['Playfair_Display'] italic leading-tight">We'd Love to <br>Hear From You</h2>
                            <p class="text-green-100/80 text-base mb-8 max-w-md leading-relaxed">Have questions? We're here to help you navigate your child's educational journey with care and excellence.</p>
                            
                            <div class="space-y-4">
                                <div class="group flex gap-5 items-center p-3 -ml-3 rounded-2xl hover:bg-white/5 transition-all duration-300 cursor-pointer">
                                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-xl group-hover:bg-white group-hover:scale-110 group-hover:text-deep-green group-hover:shadow-xl group-hover:shadow-white/20 transition-all duration-300">📍</div>
                                    <div>
                                        <p class="text-xs font-black text-green-200/50 uppercase tracking-widest mb-1">Visit Us</p>
                                        <span class="font-bold text-base text-white group-hover:text-green-200 transition-colors">{{ $schoolSettings['school_address'] ?? '123 School Road, Dhaka' }}</span>
                                    </div>
                                </div>
                                <div class="group flex gap-5 items-center p-3 -ml-3 rounded-2xl hover:bg-white/5 transition-all duration-300 cursor-pointer">
                                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-xl group-hover:bg-white group-hover:scale-110 group-hover:text-deep-green group-hover:shadow-xl group-hover:shadow-white/20 transition-all duration-300">📞</div>
                                    <div>
                                        <p class="text-xs font-black text-green-200/50 uppercase tracking-widest mb-1">Call Us</p>
                                        <span class="font-bold text-base text-white group-hover:text-green-200 transition-colors">{{ $schoolSettings['school_phone'] ?? '+880 1711 223 344' }}</span>
                                    </div>
                                </div>
                                <div class="group flex gap-5 items-center p-3 -ml-3 rounded-2xl hover:bg-white/5 transition-all duration-300 cursor-pointer">
                                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-xl group-hover:bg-white group-hover:scale-110 group-hover:text-deep-green group-hover:shadow-xl group-hover:shadow-white/20 transition-all duration-300">✉️</div>
                                    <div>
                                        <p class="text-xs font-black text-green-200/50 uppercase tracking-widest mb-1">Email Us</p>
                                        <span class="font-bold text-base text-white group-hover:text-green-200 transition-colors">{{ $schoolSettings['school_email'] ?? 'info@banglamodel.edu.bd' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-8 lg:p-10 rounded-[2.5rem] text-navy shadow-2xl shadow-black/20 relative">
                            <!-- Decorative dot on form -->
                            <div class="absolute -top-4 -right-4 w-10 h-10 bg-yellow-400 rounded-full shadow-lg"></div>

                            <h3 class="text-2xl font-black mb-6 text-deep-green">Send us a Message</h3>

                            @if(session('success'))
                                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 font-bold text-sm">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 font-bold text-sm">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                                @csrf
                                <div class="relative group">
                                    <input type="text" id="name" name="name" required class="block px-4 pb-3 pt-6 w-full text-sm text-gray-900 bg-gray-50/80 rounded-xl border border-gray-100 appearance-none focus:outline-none focus:ring-2 focus:ring-deep-green focus:bg-white peer shadow-sm transition-all font-bold" placeholder=" ">
                                    <label for="name" class="absolute text-[10px] font-black text-gray-400 uppercase tracking-widest duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-deep-green pointer-events-none">Your Name</label>
                                </div>
                                <div class="relative group">
                                    <input type="email" id="email" name="email" required class="block px-4 pb-3 pt-6 w-full text-sm text-gray-900 bg-gray-50/80 rounded-xl border border-gray-100 appearance-none focus:outline-none focus:ring-2 focus:ring-deep-green focus:bg-white peer shadow-sm transition-all font-bold" placeholder=" ">
                                    <label for="email" class="absolute text-[10px] font-black text-gray-400 uppercase tracking-widest duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-deep-green pointer-events-none">Email Address</label>
                                </div>
                                <div class="relative group">
                                    <input type="text" id="subject" name="subject" required class="block px-4 pb-3 pt-6 w-full text-sm text-gray-900 bg-gray-50/80 rounded-xl border border-gray-100 appearance-none focus:outline-none focus:ring-2 focus:ring-deep-green focus:bg-white peer shadow-sm transition-all font-bold" placeholder=" ">
                                    <label for="subject" class="absolute text-[10px] font-black text-gray-400 uppercase tracking-widest duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-deep-green pointer-events-none">Subject</label>
                                </div>
                                <div class="relative group">
                                    <textarea id="message" name="message" rows="3" required class="block px-4 pb-3 pt-6 w-full text-sm text-gray-900 bg-gray-50/80 rounded-xl border border-gray-100 appearance-none focus:outline-none focus:ring-2 focus:ring-deep-green focus:bg-white peer shadow-sm transition-all font-bold resize-none" placeholder=" "></textarea>
                                    <label for="message" class="absolute text-[10px] font-black text-gray-400 uppercase tracking-widest duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-deep-green pointer-events-none">Message</label>
                                </div>
                                <button type="submit" class="w-full bg-gradient-to-r from-deep-green to-green-700 text-white font-black py-4 rounded-xl shadow-xl shadow-green-900/20 hover:shadow-green-900/40 hover:-translate-y-1 transition-all duration-300 mt-4">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="relative bg-deep-green text-white pt-40 pb-8 overflow-hidden">
            <!-- Decorative Wave Top -->
            <div class="absolute top-0 left-0 w-full overflow-hidden leading-none rotate-180">
                <svg class="relative block w-full h-24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-white"></path>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-16 mb-12">
                    <!-- School Identity -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            @if(isset($schoolSettings['school_logo']))
                                <img src="{{ filter_var($schoolSettings['school_logo'] ?? '', FILTER_VALIDATE_URL) ? $schoolSettings['school_logo'] : asset('storage/'.($schoolSettings['school_logo'] ?? '')) }}" class="w-16 h-16 rounded-[2rem] object-contain bg-white p-2">
                            @else
                                <div class="w-16 h-16 bg-white rounded-[2rem] flex items-center justify-center text-deep-green font-black text-3xl shadow-2xl">
                                    {{ substr($schoolSettings['school_name'] ?? 'B', 0, 1) }}
                                </div>
                            @endif
                            <h2 class="text-2xl font-black tracking-tighter uppercase leading-none">
                                {{ $schoolSettings['school_name'] ?? 'Bangla Model' }}<br>
                                <span class="text-xs text-green-400 tracking-[0.3em]">School</span>
                            </h2>
                        </div>
                        <p class="text-green-100/60 font-medium leading-relaxed italic">
                            "Nurturing the seeds of knowledge in the garden of nature."
                        </p>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white hover:text-deep-green transition-all">fb</a>
                            <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white hover:text-deep-green transition-all">in</a>
                            <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white hover:text-deep-green transition-all">yt</a>
                        </div>
                    </div>

                    <!-- Links Card 1 -->
                    <div class="bg-white/5 backdrop-blur-lg p-8 rounded-[3rem] border border-white/10">
                        <h4 class="text-green-400 font-black uppercase text-[10px] tracking-widest mb-6">Discovery</h4>
                        <ul class="space-y-4 font-bold">
                            <li><a href="#" class="hover:text-green-400 transition">Admission Info</a></li>
                            <li><a href="#gallery" class="hover:text-green-400 transition">Our Gallery</a></li>
                            <li><a href="#events" class="hover:text-green-400 transition">School Events</a></li>
                            <li><a href="#admission" class="hover:text-green-400 transition">Class Timing</a></li>
                        </ul>
                    </div>

                    <!-- Links Card 2 -->
                    <div class="bg-white/5 backdrop-blur-lg p-8 rounded-[3rem] border border-white/10">
                        <h4 class="text-green-400 font-black uppercase text-[10px] tracking-widest mb-6">Staff Area</h4>
                        <ul class="space-y-4 font-bold">
                            <li><a href="{{ route('login') }}" class="hover:text-green-400 transition">Admin Login</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-green-400 transition">Teacher Portal</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-green-400 transition">Office Staff</a></li>
                            <li><a href="#contact" class="hover:text-green-400 transition">Help Center</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="space-y-8">
                        <h4 class="text-white font-black uppercase text-[10px] tracking-widest">Connect</h4>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <span class="text-2xl opacity-50">📍</span>
                                <p class="text-green-100 font-bold text-sm">{{ $schoolSettings['school_address'] ?? 'Dhaka, Bangladesh' }}</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="text-2xl opacity-50">📞</span>
                                <p class="text-green-100 font-bold text-sm">{{ $schoolSettings['school_phone'] ?? '+880 1711 223 344' }}</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="text-2xl opacity-50">✉️</span>
                                <p class="text-green-100 font-bold text-sm">{{ $schoolSettings['school_email'] ?? 'info@school.edu' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-white/20 gap-4">
                    <p class="text-sm font-bold text-green-100">
                        &copy; {{ date('Y') }} {{ $schoolSettings['school_name'] ?? 'Bangla Model School' }}. All rights reserved.
                    </p>
                    <p class="text-sm font-bold text-green-100">
                        Developed by <span class="text-white">Nabid Ahmad</span>
                    </p>
                </div>
            </div>
        </footer>

        <script>
            function reveal() {
                var reveals = document.querySelectorAll(".reveal");
                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementVisible = 150;
                    if (elementTop < windowHeight - elementVisible) {
                        reveals[i].classList.add("active");
                    }
                }
            }
            window.addEventListener("scroll", reveal);
            window.onload = reveal;
        </script>
    </body>
</html>
