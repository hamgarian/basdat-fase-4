<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Safety Report PT ERSA Eastern Aviation</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-900">
        <div class="flex min-h-screen items-center justify-center px-4 py-10 sm:py-12 lg:py-0">
            <div class="w-full max-w-3xl rounded-3xl bg-slate-950 border border-slate-800 shadow-2xl px-6 py-8 sm:px-10 sm:py-10">
                <div class="flex flex-col gap-6 sm:gap-7">
                    <!-- Title + subtitle -->
                    <div class="space-y-3 text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-300">
                            Safety Management System
                        </p>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-slate-50">
                            Dashboard Safety Report
                            <span class="block text-base sm:text-lg text-blue-300 mt-1">
                                PT ERSA Eastern Aviation
                            </span>
                        </h1>
                        <p class="mx-auto max-w-2xl text-sm sm:text-base text-slate-300">
                            Sistem pelaporan hazard untuk mencatat, memantau, dan menindaklanjuti kejadian
                            keselamatan di lingkungan operasional PT ERSA Eastern Aviation.
                        </p>
                    </div>

                    <!-- Primary actions -->
                    <div class="flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-4">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow hover:bg-blue-500"
                            >
                                Buka Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow hover:bg-blue-500"
                            >
                                Masuk ke Sistem
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-600 px-6 py-2.5 text-sm font-semibold text-slate-100 hover:bg-slate-800"
                            >
                                Daftar Akun Baru
                            </a>
                        @endauth
                    </div>

                    <!-- Brief feature row -->
                    <div class="grid gap-3 text-xs text-slate-200 sm:grid-cols-3">
                        <div class="rounded-2xl bg-slate-900 border border-slate-800 p-3 flex gap-3">
                            <div class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-xl bg-blue-900/70 text-blue-200 text-xs">
                                ✓
                            </div>
                            <div>
                                <p class="font-semibold text-slate-100">Real‑time monitoring</p>
                                <p class="mt-1 text-slate-400">Status hazard terkini dapat dipantau dari satu sistem terpusat.</p>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-slate-900 border border-slate-800 p-3 flex gap-3">
                            <div class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-xl bg-blue-900/70 text-blue-200 text-xs">
                                ⧉
                            </div>
                            <div>
                                <p class="font-semibold text-slate-100">Data terstruktur</p>
                                <p class="mt-1 text-slate-400">Setiap laporan terhubung ke karyawan, kategori, dan status.</p>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-slate-900 border border-slate-800 p-3 flex gap-3">
                            <div class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-xl bg-blue-900/70 text-blue-200 text-xs">
                                !
                            </div>
                            <div>
                                <p class="font-semibold text-slate-100">Fokus keselamatan</p>
                                <p class="mt-1 text-slate-400">Mendukung budaya pelaporan dan peningkatan keselamatan berkelanjutan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 text-[0.7rem] text-center text-slate-500">
                        © {{ date('Y') }} PT ERSA Eastern Aviation — Safety Management System
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


