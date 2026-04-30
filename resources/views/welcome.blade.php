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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
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

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center gap-3 group cursor-pointer">
                        @if(isset($schoolSettings['school_logo']))
                            <img src="{{ asset('storage/'.$schoolSettings['school_logo']) }}" class="w-12 h-12 rounded-xl object-contain bg-white/50 p-1">
                        @else
                            <div class="w-12 h-12 bg-deep-green rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg group-hover:rotate-12 transition-transform">
                                {{ substr($schoolSettings['school_name'] ?? 'B', 0, 1) }}
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-xl font-black text-deep-green tracking-tight leading-none uppercase">{{ $schoolSettings['school_name'] ?? 'Bangla Model' }}</span>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-green-500 font-bold">Nature & Knowledge</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-8 text-sm font-bold uppercase tracking-wider">
                        <a href="#" class="text-deep-green hover:opacity-70 transition">Home</a>
                        <a href="#admission" class="text-gray-500 hover:text-deep-green transition">Admission</a>
                        <a href="#gallery" class="text-gray-500 hover:text-deep-green transition">Gallery</a>
                        <a href="#events" class="text-gray-500 hover:text-deep-green transition">Events</a>
                        <a href="#contact" class="text-gray-500 hover:text-deep-green transition">Contact Us</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-deep-green text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-800 transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="bg-deep-green text-white px-6 py-2 rounded-full shadow-lg hover:bg-green-800 transition">Staff Login</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-40 pb-20 lg:pt-56 lg:pb-40 overflow-hidden bg-gradient-to-b from-green-100 to-light-green">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="reveal active">
                        <span class="inline-block px-5 py-2 bg-deep-green/10 text-deep-green text-xs font-black rounded-full mb-8 uppercase tracking-[0.3em]">Igniting Minds Since 1995</span>
                        <h1 class="text-6xl lg:text-8xl font-black text-deep-green leading-[0.95] mb-8 font-['Playfair_Display']">
                            Building <span class="italic text-green-400">Tomorrow's</span> Leaders, Today.
                        </h1>
                        <p class="text-lg text-green-700/70 mb-12 leading-relaxed max-w-lg">
                            We don’t just teach subjects; we inspire curiosity, foster creativity, and build character. Join our community where every child is a star.
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
        <section id="admission" class="py-32 bg-gray-50/50 relative overflow-hidden">
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
        <section id="gallery" class="py-32 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20 reveal">
                    <h2 class="text-5xl font-black text-deep-green mb-4 font-['Playfair_Display'] italic">Our Gallery</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Capturing the vibrant life and activities of our students through the lens.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($galleries as $gallery)
                    <div class="reveal overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition group">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-80 object-cover group-hover:scale-110 transition duration-500" alt="{{ $gallery->title }}">
                        <div class="p-6 bg-white">
                            <h3 class="font-bold text-lg text-deep-green">{{ $gallery->title }}</h3>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center text-gray-400">Our memories are being uploaded...</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Swiper.js CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- Events Section -->
        <section id="events" class="py-32 bg-light-green overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-16 reveal">
                    <div>
                        <h2 class="text-5xl font-black text-deep-green font-['Playfair_Display'] italic">Our Events</h2>
                        <p class="text-green-700/60 mt-4">Witness the joy and learning in our campus life.</p>
                    </div>
                    <div class="flex gap-4">
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
                                        <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $event->title }}">
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
        <section id="contact" class="py-32 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-deep-green rounded-[4rem] p-12 lg:p-24 text-white reveal overflow-hidden relative">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/leaf.png')]"></div>
                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-20">
                        <div>
                            <h2 class="text-5xl font-black mb-8 font-['Playfair_Display'] italic">Contact Us</h2>
                            <p class="text-green-100 text-lg mb-12">Have questions? We're here to help you navigate your child's educational journey.</p>
                            <div class="space-y-6">
                                <div class="flex gap-4 items-center">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">📍</div>
                                    <span class="font-bold">{{ $schoolSettings['school_address'] ?? '123 School Road, Dhaka, Bangladesh' }}</span>
                                </div>
                                <div class="flex gap-4 items-center">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">📞</div>
                                    <span class="font-bold">{{ $schoolSettings['school_phone'] ?? '+880 1711 223 344' }}</span>
                                </div>
                                <div class="flex gap-4 items-center">
                                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center">✉️</div>
                                    <span class="font-bold">{{ $schoolSettings['school_email'] ?? 'info@banglamodel.edu.bd' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-10 rounded-[2.5rem] text-navy shadow-2xl">
                            @if(session('success'))
                                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 font-bold text-sm">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 font-bold text-sm">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Your Name</label>
                                    <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-deep-green text-green-900 font-bold" placeholder="Ex: Rahul Khan">
                                </div>
                                <div>
                                    <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Email</label>
                                    <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-deep-green text-green-900 font-bold" placeholder="name@email.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Subject</label>
                                    <input type="text" name="subject" required class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-deep-green text-green-900 font-bold" placeholder="How can we help?">
                                </div>
                                <div>
                                    <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-2">Message</label>
                                    <textarea name="message" rows="4" required class="w-full bg-gray-50 border-none rounded-xl p-4 focus:ring-2 focus:ring-deep-green text-green-900 font-bold" placeholder="Write your message here..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-deep-green text-white font-black py-5 rounded-2xl shadow-xl hover:-translate-y-1 transition">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="relative bg-deep-green text-white pt-40 pb-20 overflow-hidden">
            <!-- Decorative Wave Top -->
            <div class="absolute top-0 left-0 w-full overflow-hidden leading-none rotate-180">
                <svg class="relative block w-full h-24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-white"></path>
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-16 mb-24">
                    <!-- School Identity -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            @if(isset($schoolSettings['school_logo']))
                                <img src="{{ asset('storage/'.$schoolSettings['school_logo']) }}" class="w-16 h-16 rounded-[2rem] object-contain bg-white p-2">
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

                <!-- Centered Bottom Bar -->
                <div class="text-center pt-16 border-t border-white/10">
                    <p class="text-[10px] font-black uppercase tracking-[0.5em] text-green-100/30">
                        &copy; {{ date('Y') }} {{ $schoolSettings['school_name'] ?? 'Bangla Model School' }} • Nature & Knowledge
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
