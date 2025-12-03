<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#B80C09"> {{-- Red Brand Color --}}

        {{-- Spark Favicon (Red) --}}
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23B80C09'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E">

        <title>{{ $title ?? 'Spark' }}</title>
        
        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles 

        <style>
            body { font-family: 'Tahoma', sans-serif; }
            [x-cloak] { display: none !important; }
            
            /* Liquid Glass Utilities */
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            .glass-dark {
                background: rgba(4, 15, 22, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .glass-red {
                background: rgba(184, 12, 9, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body class="bg-[#FBFBFF] text-[#040F16] antialiased min-h-screen flex flex-col relative selection:bg-[#B80C09] selection:text-white">
        
        {{-- Fixed Background Gradients for Glass Effect --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-[#B80C09]/10 blur-[100px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-[#01BAEF]/10 blur-[100px]"></div>
        </div>

        {{-- HEADER (Red Liquid Glass) --}}
        <header class="glass-red shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                
                {{-- Logo --}}
                <a href="{{ route('idea.index') }}" class="flex items-center gap-2 group transition duration-200">
                    {{-- Lightning Bolt --}}
                    <svg class="w-8 h-8 text-white filter drop-shadow-md group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-2xl font-bold text-white tracking-wide drop-shadow-sm">Spark</span>
                </a>

                {{-- Navigation --}}
                <nav class="flex items-center">
                    @auth
                        <div x-data="{ open: false }" class="relative ml-3">
                            <div>
                                <button @click="open = !open" type="button" class="flex items-center gap-3 text-sm rounded-full focus:outline-none transition hover:opacity-90 bg-white/10 p-1 pr-4 border border-white/20">
                                    <img class="h-8 w-8 rounded-full border border-white/50 object-cover shadow-sm" src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}">
                                    <span class="text-white font-bold text-sm hidden md:block tracking-wide">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            
                            {{-- Dropdown --}}
                            <div x-show="open" 
                                 x-cloak
                                 @click.away="open = false"
                                 x-transition.origin.top.right
                                 class="origin-top-right absolute right-0 mt-3 w-48 rounded-xl shadow-2xl py-1 glass bg-white/90 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                            >
                                <div class="px-4 py-3 border-b border-gray-100/50">
                                    <p class="text-xs text-[#B80C09] font-bold uppercase tracking-wider">Account</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-medium text-[#040F16] hover:bg-[#B80C09]/10 hover:text-[#B80C09] transition">
                                    Profile Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm font-bold text-[#B80C09] hover:bg-[#B80C09]/10 transition">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="space-x-4 flex items-center">
                            <a href="{{ route('login') }}" class="text-white hover:text-white/80 font-bold transition-colors duration-200">Login</a>
                            <a href="{{ route('register') }}" class="bg-white text-[#B80C09] px-5 py-2.5 rounded-xl font-bold transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 border border-white/50">Get Started</a>
                        </div>
                    @endauth
                </nav>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 relative z-10">
            {{ $slot }}
        </main>
        
        {{-- FOOTER --}}
        <footer class="glass-dark text-[#FBFBFF] py-12 mt-16 relative z-10">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="flex justify-center items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-[#B80C09]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-2xl font-bold tracking-tight text-white">Spark</span>
                </div>
                <p class="text-white/60 text-sm font-medium">&copy; {{ date('Y') }} Spark Forum. Designed with <span class="text-[#B80C09]">❤</span>.</p>
            </div>
        </footer>

        @livewireScripts 
    </body>
</html>
