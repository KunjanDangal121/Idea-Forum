<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Idea Forum' }}</title>
        
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 text-gray-900 font-sans antialiased">
        <div class="min-h-screen">
            {{-- This is where your IdeasIndex component will appear --}}
            {{ $slot }}
        </div>
    </body>
</html>
