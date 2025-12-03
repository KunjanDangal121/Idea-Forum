<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- NEW: Spark Favicon (Lightning Bolt) --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2301BAEF'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E">

    <title>{{ config('app.name', 'Spark') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Tahoma', sans-serif; }
    </style>
</head>
    <body class="font-sans antialiased">
        {{ $slot }}
    </body>
</html>
