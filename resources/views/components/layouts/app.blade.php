<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Idea Forum' }}</title>
        
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- NEW: Livewire Styles (CSS) --}}
        @livewireStyles 
    </head>
    <body class="bg-gray-100 text-gray-900 font-sans antialiased">
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                
                {{-- Logo/Home Link --}}
                <a href="{{ route('idea.index') }}" class="text-xl font-bold text-gray-800">
                    💡 Idea Forum
                </a>

                {{-- Auth Links --}}
                <nav class="space-x-4">
                    @auth
                        {{-- User is Logged In --}}
                        <span class="text-gray-700">Hello, {{ auth()->user()->name }}</span>
                        
                        {{-- Logout Link --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600">Logout</button>
                        </form>
                    @else
                        {{-- User is NOT Logged In --}}
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-500 hover:text-blue-600">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        {{-- The component content (Index page or Show page) will load here --}}
        <main>
            {{ $slot }}
        </main>
        
        {{-- NEW: Livewire Scripts (JavaScript) --}}
        @livewireScripts 
    </body>
</html>
