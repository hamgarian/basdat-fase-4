<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Safety Management System | PT ERSA Eastern Aviation</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-900 text-slate-100">
        <div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-12 lg:py-0">
            <div class="w-full max-w-md rounded-3xl bg-slate-950 border border-slate-800 shadow-2xl px-5 py-6 sm:px-6 sm:py-7">
                <div class="mb-6 flex flex-col items-center gap-2 text-center">
                    <a href="/" class="inline-flex items-center justify-center">
                        <x-application-logo class="h-12 w-auto" />
                    </a>
                    <div class="text-xs text-slate-400">
                        Safety Management System • PT ERSA Eastern Aviation
                    </div>
            </div>

                <div>
                {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
