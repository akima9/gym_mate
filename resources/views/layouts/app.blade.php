<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Description --}}
        <meta name="description" content="{{ config('app.description', 'Laravel') }}">
        {{-- Og --}}
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:url" content="{{ config('app.url', 'Laravel') }}">
        <meta property="og:description" content="{{ config('app.description', 'Laravel') }}">
        {{-- TO-DO: 대표 이미지 삽입 --}}
        <meta property="og:image" content="">
        {{-- Robots --}}
        <meta name="robots" content="index,nofollow">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('pusher-cdn')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
