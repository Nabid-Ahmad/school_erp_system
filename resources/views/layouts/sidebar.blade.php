<!-- Mobile Overlay -->
<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 z-20 sm:hidden" @click="sidebarOpen = false" style="display: none;"></div>

<aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
       class="w-64 bg-purple-600 text-white flex-shrink-0 min-h-screen shadow-2xl z-30 fixed sm:relative sm:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="p-6 border-b border-purple-500/50">
        <h2 class="text-2xl font-black font-sans tracking-tight drop-shadow-md">Bangla Model</h2>
        <span class="text-[10px] uppercase font-bold tracking-widest text-purple-200">Management System</span>
    </div>
    
    <div class="overflow-y-auto h-[calc(100vh-88px)] pb-10">
        <nav class="mt-6 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('dashboard') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>
            
            <!-- Master Data -->
            @canany(['manage classes', 'manage subjects', 'manage teachers', 'manage students'])
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Master Data</p>
            </div>
            @endcanany
            @can('manage classes')
            <a href="{{ route('classes.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('classes.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Classes</span>
            </a>
            @endcan
            @can('manage subjects')
            <a href="{{ route('subjects.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('subjects.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Subjects</span>
            </a>
            @endcan
            @can('manage teachers')
            <a href="{{ route('teachers.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('teachers.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Teachers</span>
            </a>
            @endcan
            @can('manage students')
            <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('students.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Students</span>
            </a>
            @endcan

            <!-- Operations -->
            @canany(['manage attendances', 'manage results', 'manage promotions', 'manage fees', 'manage expenses', 'manage salaries'])
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Operations</p>
            </div>
            @endcanany
            @can('manage attendances')
            <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('attendances.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Attendance</span>
            </a>
            @endcan
            @can('manage results')
            <a href="{{ route('results.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('results.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                <span>Results</span>
            </a>
            @endcan
            @can('manage promotions')
            <a href="{{ route('promotions.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('promotions.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <span>Promotions</span>
            </a>
            @endcan
            @can('manage fees')
            <a href="{{ route('fees.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('fees.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Fees Collected</span>
            </a>
            @endcan
            @can('manage expenses')
            <a href="{{ route('expenses.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('expenses.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                <span>Expenses</span>
            </a>
            @endcan
            @can('manage salaries')
            <a href="{{ route('salaries.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('salaries.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Staff Payroll</span>
            </a>
            @endcan

            <!-- Website CMS -->
            @canany(['manage fees', 'manage galleries', 'manage events'])
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">Website CMS</p>
            </div>
            @endcanany
            @can('manage fees')
            <a href="{{ route('fee-structures.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('fee-structures.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span>Fee Structure</span>
            </a>
            @endcan
            @can('manage galleries')
            <a href="{{ route('galleries.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('galleries.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Gallery</span>
            </a>
            @endcan
            @can('manage events')
            <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('events.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Events</span>
            </a>
            @endcan
            @if(auth()->user()->role === 'admin')
            <div class="px-6 py-2 mt-6 mb-2">
                <p class="text-[10px] font-black uppercase text-purple-300 tracking-widest">System Admin</p>
            </div>
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('users.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>User Management</span>
            </a>
            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-6 py-3 transition-colors hover:bg-purple-700 {{ request()->routeIs('settings.*') ? 'bg-purple-700 border-l-4 border-white font-bold' : 'font-medium opacity-90 hover:opacity-100 border-l-4 border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>School Settings</span>
            </a>
            @endif
        </nav>
        
        <!-- Mobile Logout -->
        <div class="mt-8 border-t border-purple-500/50 pt-6 pb-6 px-6 sm:hidden">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center gap-3 py-2 text-purple-200 hover:text-white transition-colors font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Log Out</span>
                </a>
            </form>
        </div>
    </div>
</aside>
