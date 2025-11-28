<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard - Safety Management System</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased bg-slate-900 text-slate-100 overflow-x-hidden">
        <div class="min-h-screen flex w-full max-w-full">
            <!-- Mobile Menu Overlay -->
            <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>
            
            <!-- Left Sidebar -->
            <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-slate-950 border-r border-slate-800 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
                <!-- Logo -->
                <div class="p-6 border-b border-slate-800">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-10 w-auto" />
                        <div>
                            <span class="text-lg font-semibold text-slate-50 block">Safety Dashboard</span>
                            <p class="text-xs text-slate-400">PT ERSA Eastern Aviation</p>
                        </div>
                    </div>
                </div>

                <!-- Register Button -->
                <div class="p-4 border-b border-slate-800">
                    <button onclick="showReportTypeSelector()" class="w-full flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Laporan Baru
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ $action === 'overview' ? 'bg-blue-600/20 text-blue-300 border border-blue-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-slate-100' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-sm font-medium">Overview</span>
                    </a>
                    <!-- Data Management Link -->
                    <a href="{{ route('dashboard', ['action' => 'safety-reports', 'section' => 'hazard-reports']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ $action === 'safety-reports' ? 'bg-blue-600/20 text-blue-300 border border-blue-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-slate-100' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Data Management</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium">Settings</span>
                    </a>
                </nav>

                <!-- Logout -->
                <div class="p-4 border-t border-slate-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:ml-0 w-full min-w-0">
                <!-- Top Header -->
                <header class="bg-slate-950 border-b border-slate-800 px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                    <div class="flex items-center justify-between gap-2 sm:gap-4 w-full">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-button" class="lg:hidden p-2 text-slate-400 hover:text-slate-200 flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="flex items-center gap-2 sm:gap-4">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-xs sm:text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-medium text-slate-100">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-400">{{ Auth::user()->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Content -->
                <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
                    @if (session('success'))
                        <div class="mb-4 rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $action = $action ?? 'overview';
                    @endphp

                    <!-- Overview Section (only shown when action=overview) -->
                    @if($action === 'overview')
                    <!-- Quick Actions -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 mb-4 sm:mb-6">
                        <button onclick="showCreateForm('hazard-report')" class="bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-blue-500/30 rounded-xl p-4 text-left transition-all">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">New Report</p>
                                    <p class="text-xs text-blue-100">Hazard Report</p>
                                </div>
                            </div>
                        </button>

                        <button onclick="showCreateForm('incident')" class="bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 border border-red-500/30 rounded-xl p-4 text-left transition-all">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">New Incident</p>
                                    <p class="text-xs text-red-100">Report Incident</p>
                                </div>
                            </div>
                        </button>

                        <button onclick="showCreateForm('audit')" class="bg-gradient-to-br from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 border border-yellow-500/30 rounded-xl p-4 text-left transition-all">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">New Audit</p>
                                    <p class="text-xs text-yellow-100">Create Audit</p>
                                </div>
                            </div>
                        </button>

                        <a href="{{ route('dashboard', ['action' => 'safety-reports']) }}" class="bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 border border-purple-500/30 rounded-xl p-4 text-left transition-all">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">Data Management</p>
                                    <p class="text-xs text-purple-100">View All Data</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Statistics Overview - Compact Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
                        <!-- Hazard Reports Status -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">Hazard Reports</h3>
                                <div class="h-8 w-8 rounded-lg bg-blue-600/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-400">Total</span>
                                    <span class="text-lg font-bold text-slate-100">{{ number_format($totalReports) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                        <span class="text-xs text-slate-400">Open</span>
                                    </div>
                                    <span class="text-sm font-semibold text-amber-300">{{ number_format($openReports) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <span class="text-xs text-slate-400">Investigated</span>
                                    </div>
                                    <span class="text-sm font-semibold text-blue-300">{{ number_format($investigatedReports) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                        <span class="text-xs text-slate-400">Closed</span>
                                    </div>
                                    <span class="text-sm font-semibold text-emerald-300">{{ number_format($closedReports) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- System Resources -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">System Resources</h3>
                                <div class="h-8 w-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-400">Employees</span>
                                    <span class="text-sm font-semibold text-slate-100">{{ number_format($totalKaryawan) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-400">Aircraft</span>
                                    <span class="text-sm font-semibold text-slate-100">{{ number_format($activePesawat) }}/<span class="text-slate-400">{{ number_format($totalPesawat) }}</span></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-400">Pilots</span>
                                    <span class="text-sm font-semibold text-slate-100">{{ number_format($activePilots) }}/<span class="text-slate-400">{{ number_format($totalPilots) }}</span></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-400">Clients</span>
                                    <span class="text-sm font-semibold text-slate-100">{{ number_format($totalClients) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Overview -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">Data Overview</h3>
                                <div class="h-8 w-8 rounded-lg bg-cyan-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Incidents</p>
                                    <p class="text-lg font-bold text-red-300">{{ number_format($totalIncidents) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Investigations</p>
                                    <p class="text-lg font-bold text-orange-300">{{ number_format($totalInvestigations) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Audits</p>
                                    <p class="text-lg font-bold text-yellow-300">{{ number_format($totalAudits) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Temuan</p>
                                    <p class="text-lg font-bold text-teal-300">{{ number_format($totalTemuan) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Manuals</p>
                                    <p class="text-lg font-bold text-violet-300">{{ number_format($totalLibraryManuals) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Flights</p>
                                    <p class="text-lg font-bold text-cyan-300">{{ number_format($totalPenerbangan) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6 w-full">
                        <!-- Monthly Trend Chart -->
                        <div class="lg:col-span-2 bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0 mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">Monthly Reports Trend</h3>
                                <select class="text-xs bg-slate-900 border border-slate-700 text-slate-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                                    <option>Last 6 months</option>
                                    <option>Last year</option>
                                </select>
                            </div>
                            <div class="h-48 sm:h-64">
                                <canvas id="monthlyTrendChart"></canvas>
                            </div>
                        </div>

                        <!-- Status Distribution -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <h3 class="text-sm font-semibold text-slate-200 mb-4">Status Distribution</h3>
                            <div class="h-48 sm:h-64 flex items-center justify-center">
                                <canvas id="statusChart"></canvas>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                        <span class="text-slate-300">Open</span>
                                    </div>
                                    <span class="text-slate-400">{{ $openReports }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                        <span class="text-slate-300">Investigated</span>
                                    </div>
                                    <span class="text-slate-400">{{ $investigatedReports }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                        <span class="text-slate-300">Closed</span>
                                    </div>
                                    <span class="text-slate-400">{{ $closedReports }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6 w-full">
                        <!-- Daily Reports -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0 mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">Reports This Week</h3>
                                <select class="text-xs bg-slate-900 border border-slate-700 text-slate-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                                    <option>This week</option>
                                    <option>Last week</option>
                                </select>
                            </div>
                            <div class="h-40 sm:h-48">
                                <canvas id="dailyChart"></canvas>
                            </div>
                        </div>

                        <!-- Reports by Category -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">Reports By Category</h3>
                            </div>
                            <div class="space-y-3">
                                @foreach($reportsByCategory as $category)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                            <span class="text-sm text-slate-300">{{ $category->kategori }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-slate-100">{{ $category->count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Recent Reports -->
                        <div class="bg-blue-600 rounded-xl p-4 sm:p-5">
                            <h3 class="text-sm font-semibold text-white mb-4">Reports This Month</h3>
                            <p class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ number_format($totalReports) }}</p>
                            <p class="text-xs text-blue-100 mb-4">Total hazard reports</p>
                            <div class="h-28 sm:h-32">
                                <canvas id="monthlyBarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity & Performance Metrics Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6 w-full">
                        <!-- Recent Activity -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-slate-200">Recent Activity</h3>
                                <a href="{{ route('dashboard', ['action' => 'safety-reports']) }}" class="text-xs text-blue-400 hover:text-blue-300">
                                    View All →
                                </a>
                            </div>
                            <div id="recent-activity-scroll" class="space-y-3 max-h-96 overflow-y-auto scrollbar-hide">
                                <!-- Recent Hazard Reports -->
                                @if($recentReports->count() > 0)
                                    <div class="pb-3 border-b border-slate-800">
                                        <p class="text-xs font-semibold text-slate-400 mb-2">Hazard Reports</p>
                                        @foreach($recentReports->take(3) as $report)
                                            <div class="flex items-center justify-between py-1.5">
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    <div class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></div>
                                                    <span class="text-xs text-slate-300 truncate">{{ $report->kategori ?? 'N/A' }}</span>
                                                </div>
                                                <span class="text-xs text-slate-400 ml-2">{{ $report->tanggal_laporan?->format('d M') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Recent Incidents -->
                                @if($recentIncidents->count() > 0)
                                    <div class="pb-3 border-b border-slate-800">
                                        <p class="text-xs font-semibold text-slate-400 mb-2">Incidents</p>
                                        @foreach($recentIncidents->take(3) as $incident)
                                            <div class="flex items-center justify-between py-1.5">
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    <div class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></div>
                                                    <span class="text-xs text-slate-300 truncate">{{ $incident->kategori_insiden ?? 'N/A' }}</span>
                                                </div>
                                                <span class="text-xs text-slate-400 ml-2">#{{ $incident->id_incident }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Recent Investigations -->
                                @if($recentInvestigations->count() > 0)
                                    <div class="pb-3 border-b border-slate-800">
                                        <p class="text-xs font-semibold text-slate-400 mb-2">Investigations</p>
                                        @foreach($recentInvestigations->take(3) as $investigation)
                                            <div class="flex items-center justify-between py-1.5">
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    <div class="w-2 h-2 rounded-full bg-orange-500 flex-shrink-0"></div>
                                                    <span class="text-xs text-slate-300 truncate">Hazard #{{ $investigation->hazardReport->id_hazard ?? 'N/A' }}</span>
                                                </div>
                                                <span class="text-xs text-slate-400 ml-2">{{ $investigation->tanggal_mulai?->format('d M') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Recent Audits -->
                                @if($recentAudits->count() > 0)
                                    <div class="pb-3 border-b border-slate-800">
                                        <p class="text-xs font-semibold text-slate-400 mb-2">Audits</p>
                                        @foreach($recentAudits->take(3) as $audit)
                                            <div class="flex items-center justify-between py-1.5">
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    <div class="w-2 h-2 rounded-full bg-yellow-500 flex-shrink-0"></div>
                                                    <span class="text-xs text-slate-300 truncate">{{ Str::limit($audit->judul ?? 'N/A', 30) }}</span>
                                                </div>
                                                <span class="text-xs text-slate-400 ml-2">{{ $audit->tanggal_pelaksanaan?->format('d M') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Recent Penerbangan -->
                                @if($recentPenerbangan->count() > 0)
                                    <div>
                                        <p class="text-xs font-semibold text-slate-400 mb-2">Penerbangan</p>
                                        @foreach($recentPenerbangan->take(3) as $p)
                                            <div class="flex items-center justify-between py-1.5">
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    <div class="w-2 h-2 rounded-full bg-cyan-500 flex-shrink-0"></div>
                                                    <span class="text-xs text-slate-300 truncate">{{ $p->pesawat->registrasi ?? 'N/A' }}</span>
                                                </div>
                                                <span class="text-xs text-slate-400 ml-2">{{ $p->tanggal_penerbangan?->format('d M') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                            <h3 class="text-sm font-semibold text-slate-200 mb-4">Performance Metrics</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-slate-900/50 rounded-lg">
                                    <div>
                                        <p class="text-xs text-slate-400 mb-1">Reports This Week</p>
                                        <p class="text-lg font-bold text-slate-100">{{ number_format($recentHazardReports) }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>

                                @if($mostActiveReporter)
                                    <div class="flex items-center justify-between p-3 bg-slate-900/50 rounded-lg">
                                        <div>
                                            <p class="text-xs text-slate-400 mb-1">Most Active Reporter</p>
                                            <p class="text-sm font-semibold text-slate-100 truncate">{{ $mostActiveReporter->karyawan->nama_karyawan ?? 'N/A' }}</p>
                                            <p class="text-xs text-slate-400 mt-1">{{ $mostActiveReporter->count }} reports</p>
                                        </div>
                                        <div class="h-12 w-12 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3 bg-slate-900/50 rounded-lg">
                                        <p class="text-xs text-slate-400 mb-1">Total Flights</p>
                                        <p class="text-lg font-bold text-slate-100">{{ number_format($totalPenerbangan) }}</p>
                                    </div>
                                    <div class="p-3 bg-slate-900/50 rounded-lg">
                                        <p class="text-xs text-slate-400 mb-1">Flight Movements</p>
                                        <p class="text-lg font-bold text-slate-100">{{ number_format($totalFlightMovements) }}</p>
                                    </div>
                                </div>

                                <div class="p-3 bg-gradient-to-r from-blue-600/20 to-purple-600/20 border border-blue-500/30 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs text-blue-300 mb-1">System Health</p>
                                            <p class="text-sm font-semibold text-blue-200">
                                                @php
                                                    $healthScore = 0;
                                                    if($totalReports > 0) {
                                                        $closedPercentage = ($closedReports / $totalReports) * 100;
                                                        $healthScore = min(100, max(0, $closedPercentage));
                                                    }
                                                @endphp
                                                {{ number_format($healthScore, 1) }}%
                                            </p>
                                            <p class="text-xs text-blue-300/70 mt-1">Based on closed reports</p>
                                        </div>
                                        <div class="h-12 w-12 rounded-lg bg-blue-500/30 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hazard Reports Table -->
                    <div class="bg-slate-950 border border-slate-800 rounded-xl p-3 sm:p-4 lg:p-5 mb-4 sm:mb-6 w-full overflow-hidden">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm sm:text-base font-semibold text-slate-200">Hazard Reports</h3>
                            <button onclick="showCreateForm('hazard-report')" class="text-xs sm:text-sm text-blue-400 hover:text-blue-300">
                                + Tambah Baru
                            </button>
                        </div>
                        <div class="w-full overflow-x-auto -mx-3 sm:-mx-4 lg:-mx-5">
                            <div class="inline-block w-full align-middle">
                                <table class="w-full divide-y divide-slate-800">
                                    <thead class="bg-slate-900">
                                        <tr>
                                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal</th>
                                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</th>
                                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Pelapor</th>
                                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Status</th>
                                            <th class="px-3 sm:px-4 py-2 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800 bg-slate-950">
                                        @forelse($recentReports as $report)
                                            @php
                                                $statusColors = [
                                                    'Open' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
                                                    'Investigated' => 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
                                                    'Closed' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
                                                ];
                                            @endphp
                                            <tr class="hover:bg-slate-900/50 transition-colors">
                                                <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm text-slate-200 cursor-pointer hover:text-blue-400 transition-colors" onclick="showPreview('Tanggal Laporan', '{{ $report->tanggal_laporan?->format('d M Y') }}', '{{ $report->tanggal_laporan?->format('d F Y') }}')">
                                                    {{ $report->tanggal_laporan?->format('d M Y') }}
                                                </td>
                                                <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-slate-100 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Kategori', '{{ $report->kategori }}', '{{ $report->kategori }}')" title="{{ $report->kategori }}">
                                                    {{ Str::limit($report->kategori ?? 'N/A', 20) }}
                                                </td>
                                                <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm text-slate-300 cursor-pointer hover:text-blue-400 transition-colors truncate" onclick="showPreview('Pelapor', '{{ $report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A' }}', '{{ $report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A' }}')" title="{{ $report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A' }}">
                                                    {{ Str::limit($report->karyawan->nama_karyawan ?? $report->nama_pelapor ?? 'N/A', 25) }}
                                                </td>
                                                <td class="px-3 sm:px-4 py-2 whitespace-nowrap">
                                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusColors[$report->status] ?? 'bg-slate-700 text-slate-300 border border-slate-600' }}">
                                                        {{ $report->status }}
                                                    </span>
                                                </td>
                                                <td class="px-3 sm:px-4 py-2 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                                    <div class="flex items-center justify-end gap-1 sm:gap-2">
                                                        <button onclick="event.stopPropagation(); showEditForm('hazard-report', {{ $report->id_hazard }})" class="rounded-md border border-blue-500/50 px-2 py-1 text-blue-400 hover:bg-blue-500/10 hover:border-blue-400 transition-colors text-xs">
                                                            Edit
                                                        </button>
                                                        <button onclick="event.stopPropagation(); showDeleteConfirm('hazard-report', {{ $report->id_hazard }})" class="rounded-md border border-red-500/50 px-2 py-1 text-red-400 hover:bg-red-500/10 hover:border-red-400 transition-colors text-xs">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-3 sm:px-4 py-6 text-center text-xs sm:text-sm text-slate-400">
                                                    Belum ada laporan hazard.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4 px-3 sm:px-4">
                            {{ $recentReports->links() }}
                        </div>
                    </div>
                    @endif
                    <!-- End Overview Section -->

                    <!-- Safety Reports Section (shown when action=safety-reports) -->
                    @if($action === 'safety-reports')
                        @php
                            $section = $section ?? 'hazard-reports';
                            $sections = [
                                'hazard-reports' => 'Hazard Reports',
                                'incidents' => 'Incidents',
                                'investigations' => 'Investigations',
                                'audits' => 'Audits',
                                'temuan' => 'Temuan',
                                'library-manuals' => 'Library Manuals',
                                'penerbangan' => 'Penerbangan',
                                'flight-movements' => 'Flight Movements',
                                'pesawat' => 'Pesawat',
                                'pilots' => 'Pilots',
                                'clients' => 'Clients',
                            ];
                        @endphp
                        
                        <div class="w-full">
                            <!-- Tabs Navigation -->
                            <div class="mb-6 border-b border-slate-800">
                                <!-- Mobile: Scrollable tabs -->
                                <div class="flex gap-1 overflow-x-auto pb-2 scrollbar-hide -mx-4 px-4 md:hidden" style="scrollbar-width: none; -ms-overflow-style: none;">
                                    <style>
                                        .scrollbar-hide::-webkit-scrollbar {
                                            display: none;
                                        }
                                    </style>
                                    @foreach($sections as $key => $label)
                                        <a href="{{ route('dashboard', ['action' => 'safety-reports', 'section' => $key]) }}" 
                                           class="flex-shrink-0 px-2.5 py-1.5 text-xs font-medium rounded-lg transition-all whitespace-nowrap {{ $section === $key ? 'bg-blue-600/20 text-blue-300 border-b-2 border-blue-500' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                                            {{ $label }}
                                        </a>
                                    @endforeach
                                </div>
                                <!-- Desktop: Normal tabs -->
                                <div class="hidden md:flex md:flex-wrap md:gap-2">
                                    @foreach($sections as $key => $label)
                                        <a href="{{ route('dashboard', ['action' => 'safety-reports', 'section' => $key]) }}" 
                                           class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors {{ $section === $key ? 'bg-blue-600/20 text-blue-300 border-b-2 border-blue-500' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800' }}">
                                            {{ $label }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tab Content -->
                            <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5">
                                @if($section === 'hazard-reports')
                                    @include('dashboard.sections.hazard-reports')
                                @elseif($section === 'incidents')
                                    @include('dashboard.sections.incidents')
                                @elseif($section === 'investigations')
                                    @include('dashboard.sections.investigations')
                                @elseif($section === 'audits')
                                    @include('dashboard.sections.audits')
                                @elseif($section === 'temuan')
                                    @include('dashboard.sections.temuan')
                                @elseif($section === 'library-manuals')
                                    @include('dashboard.sections.library-manuals')
                                @elseif($section === 'penerbangan')
                                    @include('dashboard.sections.penerbangan')
                                @elseif($section === 'flight-movements')
                                    @include('dashboard.sections.flight-movements')
                                @elseif($section === 'pesawat')
                                    @include('dashboard.sections.pesawat')
                                @elseif($section === 'pilots')
                                    @include('dashboard.sections.pilots')
                                @elseif($section === 'clients')
                                    @include('dashboard.sections.clients')
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- End Safety Reports Section -->

                    <!-- Create/Edit Form removed - now using modals -->
                    @if(false)
                        <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 sm:p-5 mb-4 sm:mb-6 w-full">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm sm:text-base font-semibold text-slate-200">
                                    {{ $action === 'create' ? 'Tambah Laporan Hazard' : 'Perbarui Laporan Hazard' }}
                                </h3>
                                <a href="{{ route('dashboard') }}" class="text-xs sm:text-sm text-slate-400 hover:text-slate-200">
                                    ✕ Tutup
                                </a>
                            </div>
                            <form method="POST" action="{{ $action === 'create' ? route('dashboard.reports.store') : ($hazardReport ? route('dashboard.reports.update', $hazardReport) : route('dashboard')) }}" class="space-y-4">
                                @csrf
                                @if($action === 'edit')
                                    @method('PUT')
                                @endif

                                <div>
                                    <label for="id_karyawan" class="block text-sm font-medium text-slate-200 mb-1">Karyawan</label>
                                    <select id="id_karyawan" name="id_karyawan" class="w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($karyawan as $item)
                                            <option value="{{ $item->id_karyawan }}" data-nama="{{ $item->nama_karyawan }}" @selected(old('id_karyawan', $hazardReport?->id_karyawan ?? '') == $item->id_karyawan)>
                                                {{ $item->nama_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_karyawan')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nama_pelapor" class="block text-sm font-medium text-slate-200 mb-1">
                                        Nama Pelapor
                                        <span class="text-xs font-normal text-slate-400">(otomatis dari karyawan)</span>
                                    </label>
                                    <input id="nama_pelapor" name="nama_pelapor" type="text" value="{{ old('nama_pelapor', $hazardReport?->nama_pelapor ?? '') }}" class="w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Nama pelapor" />
                                    @error('nama_pelapor')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="tanggal_laporan" class="block text-sm font-medium text-slate-200 mb-1">Tanggal Laporan</label>
                                        <input id="tanggal_laporan" name="tanggal_laporan" type="date" value="{{ old('tanggal_laporan', $hazardReport && $hazardReport->tanggal_laporan ? $hazardReport->tanggal_laporan->format('Y-m-d') : '') }}" class="w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" required />
                                        @error('tanggal_laporan')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="kategori" class="block text-sm font-medium text-slate-200 mb-1">Kategori</label>
                                        <select id="kategori" name="kategori" class="w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach(['FOD', 'Maintenance', 'Wildlife', 'Ground Handling', 'Documentation'] as $kategori)
                                                <option value="{{ $kategori }}" @selected(old('kategori', $hazardReport?->kategori ?? '') === $kategori)>
                                                    {{ $kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="deskripsi" class="block text-sm font-medium text-slate-200 mb-1">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('deskripsi', $hazardReport?->deskripsi ?? '') }}</textarea>
                                    @error('deskripsi')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($action === 'edit')
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-slate-200 mb-1">Status</label>
                                        <select id="status" name="status" class="w-full rounded-md border-slate-700 bg-slate-900 text-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            @foreach(['Open', 'Investigated', 'Closed'] as $status)
                                                <option value="{{ $status }}" @selected(old('status', $hazardReport?->status ?? '') === $status)>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @else
                                    <div>
                                        <span class="block text-sm font-medium text-slate-200 mb-1">Status</span>
                                        <div class="inline-flex items-center gap-2 rounded-md bg-amber-500/20 border border-amber-500/30 px-3 py-2 text-sm text-amber-300">
                                            <span class="font-semibold uppercase">Open</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200">
                                        Batal
                                    </a>
                                    <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        {{ $action === 'create' ? 'Simpan Laporan' : 'Simpan Perubahan' }}
                                    </button>
                                </div>
                            </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const select = document.getElementById('id_karyawan');
                                    const input = document.getElementById('nama_pelapor');
                                    if (select && input) {
                                        select.addEventListener('change', () => {
                                            const option = select.options[select.selectedIndex];
                                            if (option && option.dataset.nama && !input.value.trim()) {
                                                input.value = option.dataset.nama;
                                            }
                                        });
                                    }
                                });
                            </script>
                        </div>
                    @endif
                </main>
            </div>
        </div>

        <script>
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }

            mobileMenuButton?.addEventListener('click', openSidebar);
            overlay?.addEventListener('click', closeSidebar);

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                    closeSidebar();
                }
            });

            // Close sidebar on window resize if > lg
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });

            // Prevent page scroll when scrolling in Recent Activity container
            const recentActivityScroll = document.getElementById('recent-activity-scroll');
            if (recentActivityScroll) {
                let lastScrollTop = recentActivityScroll.scrollTop;
                
                const handleWheel = (e) => {
                    const element = recentActivityScroll;
                    const currentScrollTop = element.scrollTop;
                    const { scrollHeight, clientHeight } = element;
                    const deltaY = e.deltaY;
                    
                    // Check current scroll state
                    const isAtTop = currentScrollTop <= 0;
                    const isAtBottom = currentScrollTop >= scrollHeight - clientHeight - 1;
                    
                    // Determine scroll direction
                    const scrollingDown = deltaY > 0;
                    const scrollingUp = deltaY < 0;
                    
                    // If we're scrolling and NOT at the boundary in that direction, consume the event
                    if ((scrollingDown && !isAtBottom) || (scrollingUp && !isAtTop)) {
                        e.stopPropagation();
                        // Allow the element to scroll naturally
                        return;
                    }
                    
                    // If we're at a boundary and trying to scroll past it, prevent default
                    // but allow propagation so parent can scroll
                    if ((scrollingDown && isAtBottom) || (scrollingUp && isAtTop)) {
                        // Don't prevent default - let parent handle it
                        // But stop immediate propagation to avoid double handling
                        e.stopImmediatePropagation();
                    }
                };
                
                // Use capture phase to catch event early
                recentActivityScroll.addEventListener('wheel', handleWheel, { 
                    passive: false, 
                    capture: true 
                });
                
                // Track scroll position to detect actual scrolling
                recentActivityScroll.addEventListener('scroll', () => {
                    lastScrollTop = recentActivityScroll.scrollTop;
                }, { passive: true });
            }

            @if($action === 'overview')
            // Monthly Trend Chart
            const monthlyCtx = document.getElementById('monthlyTrendChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($monthlyTrend->map(fn($item) => \Carbon\Carbon::parse($item->month)->format('M Y'))) !!},
                        datasets: [{
                            label: 'Reports',
                            data: {!! json_encode($monthlyTrend->pluck('count')) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', titleColor: '#e2e8f0', bodyColor: '#e2e8f0' }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148, 163, 184, 0.1)' } },
                            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
                        }
                    }
                });
            }

            // Status Distribution Chart
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                new Chart(statusCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Open', 'Investigated', 'Closed'],
                        datasets: [{
                            data: [{{ $openReports }}, {{ $investigatedReports }}, {{ $closedReports }}],
                            backgroundColor: ['rgb(245, 158, 11)', 'rgb(59, 130, 246)', 'rgb(16, 185, 129)'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', titleColor: '#e2e8f0', bodyColor: '#e2e8f0' }
                        }
                    }
                });
            }

            // Daily Chart
            const dailyCtx = document.getElementById('dailyChart');
            if (dailyCtx) {
                new Chart(dailyCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($dailyReports->map(fn($item) => \Carbon\Carbon::parse($item->date)->format('d M'))) !!},
                        datasets: [{
                            label: 'Reports',
                            data: {!! json_encode($dailyReports->pluck('count')) !!},
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', titleColor: '#e2e8f0', bodyColor: '#e2e8f0' }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148, 163, 184, 0.1)' } },
                            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
                        }
                    }
                });
            }

            // Monthly Bar Chart (in blue card)
            const monthlyBarCtx = document.getElementById('monthlyBarChart');
            if (monthlyBarCtx) {
                new Chart(monthlyBarCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($dailyReports->map(fn($item) => \Carbon\Carbon::parse($item->date)->format('d M'))) !!},
                        datasets: [{
                            data: {!! json_encode($dailyReports->pluck('count')) !!},
                            backgroundColor: 'rgba(255, 255, 255, 0.3)',
                            borderColor: 'rgba(255, 255, 255, 0.5)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', titleColor: '#e2e8f0', bodyColor: '#e2e8f0' }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: 'rgba(255, 255, 255, 0.7)', display: false }, grid: { display: false } },
                            x: { ticks: { color: 'rgba(255, 255, 255, 0.7)' }, grid: { display: false } }
                        }
                    }
                });
            }
            @endif

            // ========== MODAL MANAGEMENT ==========
            let currentModal = null;
            let currentEditId = null;

            // Report Type Selector Functions
            window.showReportTypeSelector = function() {
                const modal = document.getElementById('report-type-selector');
                if (modal) {
                    modal.style.display = 'flex';
                    modal.style.zIndex = '9998';
                    document.body.style.overflow = 'hidden';
                }
            };

            window.closeReportTypeSelector = function() {
                const modal = document.getElementById('report-type-selector');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            };

            window.selectReportType = function(type) {
                closeReportTypeSelector();
                // Small delay to ensure selector is closed before opening create form
                setTimeout(() => {
                    showCreateForm(type);
                }, 100);
            };

            window.showCreateForm = function(type) {
                currentModal = type;
                currentEditId = null;
                const modal = document.getElementById(`modal-${type}`);
                console.log('Opening modal:', type, modal);
                if (modal) {
                    modal.style.display = 'flex';
                    modal.style.zIndex = '9999';
                    document.body.style.overflow = 'hidden';
                    // Reset form
                    const form = modal.querySelector('form');
                    if (form) {
                        form.reset();
                        form.action = getCreateRoute(type);
                        // Set POST method
                        let methodInput = form.querySelector('input[name="_method"]');
                        if (!methodInput) {
                            methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            form.appendChild(methodInput);
                        }
                        methodInput.value = 'POST';
                    }
                    
                    // Update modal title
                    const title = modal.querySelector('h3');
                    if (title) {
                        title.textContent = title.textContent.replace('Edit', 'Tambah');
                    }
                    
                    // Show/hide status field for hazard-report
                    if (type === 'hazard-report') {
                        const statusField = document.getElementById('status-field-hazard-report');
                        if (statusField) statusField.classList.add('hidden');
                    }
                }
            };

            window.showEditForm = async function(type, id) {
                currentModal = type;
                currentEditId = id;
                const modal = document.getElementById(`modal-${type}`);
                console.log('Opening edit modal:', type, id, modal);
                if (modal) {
                    modal.style.display = 'flex';
                    modal.style.zIndex = '9999';
                    document.body.style.overflow = 'hidden';
                    const form = modal.querySelector('form');
                    if (form) {
                        form.action = getUpdateRoute(type, id);
                        let methodInput = form.querySelector('input[name="_method"]');
                        if (!methodInput) {
                            methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            form.appendChild(methodInput);
                        }
                        methodInput.value = 'PUT';
                    }
                    
                    // Update modal title
                    const title = modal.querySelector('h3');
                    if (title) {
                        title.textContent = title.textContent.replace('Tambah', 'Edit');
                    }
                    
                    // Load data via fetch
                    try {
                        const typeMap = {
                            'hazard-report': 'hazard-reports',
                            'incident': 'incidents',
                            'investigation': 'investigations',
                            'audit': 'audits',
                            'temuan': 'temuan',
                            'library-manual': 'library-manuals',
                            'penerbangan': 'penerbangan',
                            'flight-movement': 'flight-movements',
                            'pesawat': 'pesawat',
                            'pilot': 'pilots',
                            'client': 'clients',
                        };
                        const apiType = typeMap[type] || type;
                        const response = await fetch(`/dashboard/${apiType}/${id}/edit-data`);
                        if (response.ok) {
                            const data = await response.json();
                            populateForm(modal, data, type);
                        }
                    } catch (error) {
                        console.error('Error loading data:', error);
                    }
                }
            };

            window.showDeleteConfirm = function(type, id) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = getDeleteRoute(type, id);
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);
                    
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            };
            
            // Helper to get section from URL
            function getCurrentSection() {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('section') || 'hazard-reports';
            }

            window.closeModal = function(type) {
                const modal = document.getElementById(`modal-${type}`);
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            };

            function populateForm(modal, data, type) {
                const form = modal.querySelector('form');
                if (!form) return;
                
                // Populate fields
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = data[key];
                        } else if (input.tagName === 'SELECT') {
                            input.value = data[key];
                        } else if (input.type === 'date') {
                            // Format date for date input
                            if (data[key]) {
                                const date = new Date(data[key]);
                                input.value = date.toISOString().split('T')[0];
                            }
                        } else {
                            input.value = data[key] || '';
                        }
                    }
                });
                
                // Show status field for hazard-report in edit mode
                if (type === 'hazard-report') {
                    const statusField = document.getElementById('status-field-hazard-report');
                    if (statusField) statusField.classList.remove('hidden');
                }
            }

            function getCreateRoute(type) {
                const routes = {
                    'hazard-report': '/dashboard/hazard-reports',
                    'incident': '/dashboard/incidents',
                    'investigation': '/dashboard/investigations',
                    'audit': '/dashboard/audits',
                    'temuan': '/dashboard/temuan',
                    'library-manual': '/dashboard/library-manuals',
                    'penerbangan': '/dashboard/penerbangan',
                    'flight-movement': '/dashboard/flight-movements',
                    'pesawat': '/dashboard/pesawat',
                    'pilot': '/dashboard/pilots',
                    'client': '/dashboard/clients',
                };
                return routes[type] || '#';
            }

            function getUpdateRoute(type, id) {
                const routes = {
                    'hazard-report': `/dashboard/hazard-reports/${id}`,
                    'incident': `/dashboard/incidents/${id}`,
                    'investigation': `/dashboard/investigations/${id}`,
                    'audit': `/dashboard/audits/${id}`,
                    'temuan': `/dashboard/temuan/${id}`,
                    'library-manual': `/dashboard/library-manuals/${id}`,
                    'penerbangan': `/dashboard/penerbangan/${id}`,
                    'flight-movement': `/dashboard/flight-movements/${id}`,
                    'pesawat': `/dashboard/pesawat/${id}`,
                    'pilot': `/dashboard/pilots/${id}`,
                    'client': `/dashboard/clients/${id}`,
                };
                return routes[type] || '#';
            }

            function getDeleteRoute(type, id) {
                return getUpdateRoute(type, id);
            }

            // Close modal on outside click
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('modal-overlay')) {
                    const modal = e.target.closest('.modal-container');
                    if (modal) {
                        modal.style.display = 'none';
                        document.body.style.overflow = '';
                    }
                }
            });

            // Preview Modal Functions
            window.showPreview = function(title, content, fullText) {
                const modal = document.getElementById('preview-modal');
                const titleEl = document.getElementById('preview-title');
                const contentEl = document.getElementById('preview-content');
                
                if (modal && titleEl && contentEl) {
                    titleEl.textContent = title;
                    // Use fullText if provided, otherwise use content
                    const displayText = fullText || content;
                    contentEl.innerHTML = `
                        <div class="p-4 bg-slate-900 rounded-lg border border-slate-800">
                            <div class="text-sm text-slate-300 whitespace-pre-wrap">${displayText}</div>
                        </div>
                    `;
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            };

            window.closePreviewModal = function() {
                const modal = document.getElementById('preview-modal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            };

            // Close preview modal on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closePreviewModal();
                }
            });
        </script>

        <!-- Preview Modal -->
        <div id="preview-modal" class="fixed inset-0 z-[10000] flex items-center justify-center" style="display: none;" onclick="if(event.target === this) closePreviewModal()">
            <div class="absolute inset-0 bg-black/75" onclick="closePreviewModal()"></div>
            <div class="relative z-10 w-full max-w-2xl p-4">
                <div class="bg-slate-950 border border-slate-800 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto pointer-events-auto">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-100" id="preview-title">Preview</h3>
                            <button onclick="closePreviewModal()" class="text-slate-400 hover:text-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div id="preview-content" class="space-y-3 text-slate-300">
                            <!-- Content will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Type Selection Modal -->
        <div id="report-type-selector" class="fixed inset-0 z-[9998] flex items-center justify-center" style="display: none;" onclick="if(event.target === this) closeReportTypeSelector()">
            <div class="absolute inset-0 bg-black/75" onclick="closeReportTypeSelector()"></div>
            <div class="relative z-10 w-full max-w-4xl p-4">
                <div class="bg-slate-950 border border-slate-800 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto pointer-events-auto">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-slate-100">Pilih Jenis Laporan</h3>
                            <button onclick="closeReportTypeSelector()" class="text-slate-400 hover:text-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <!-- Hazard Report -->
                            <button onclick="selectReportType('hazard-report')" class="bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 border border-blue-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Hazard Report</p>
                                        <p class="text-xs text-blue-100">Laporan Bahaya</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Incident -->
                            <button onclick="selectReportType('incident')" class="bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 border border-red-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Incident</p>
                                        <p class="text-xs text-red-100">Laporan Insiden</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Investigation -->
                            <button onclick="selectReportType('investigation')" class="bg-gradient-to-br from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 border border-orange-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Investigation</p>
                                        <p class="text-xs text-orange-100">Investigasi</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Audit -->
                            <button onclick="selectReportType('audit')" class="bg-gradient-to-br from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 border border-yellow-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Audit</p>
                                        <p class="text-xs text-yellow-100">Laporan Audit</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Temuan -->
                            <button onclick="selectReportType('temuan')" class="bg-gradient-to-br from-lime-600 to-lime-700 hover:from-lime-700 hover:to-lime-800 border border-lime-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Temuan</p>
                                        <p class="text-xs text-lime-100">Temuan Audit</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Library Manual -->
                            <button onclick="selectReportType('library-manual')" class="bg-gradient-to-br from-violet-600 to-violet-700 hover:from-violet-700 hover:to-violet-800 border border-violet-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Library Manual</p>
                                        <p class="text-xs text-violet-100">Manual Perpustakaan</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Penerbangan -->
                            <button onclick="selectReportType('penerbangan')" class="bg-gradient-to-br from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 border border-cyan-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Penerbangan</p>
                                        <p class="text-xs text-cyan-100">Data Penerbangan</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Flight Movement -->
                            <button onclick="selectReportType('flight-movement')" class="bg-gradient-to-br from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 border border-teal-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Flight Movement</p>
                                        <p class="text-xs text-teal-100">Perpindahan Penerbangan</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Pesawat -->
                            <button onclick="selectReportType('pesawat')" class="bg-gradient-to-br from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 border border-indigo-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Pesawat</p>
                                        <p class="text-xs text-indigo-100">Data Pesawat</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Pilot -->
                            <button onclick="selectReportType('pilot')" class="bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 border border-purple-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Pilot</p>
                                        <p class="text-xs text-purple-100">Data Pilot</p>
                                    </div>
                                </div>
                            </button>

                            <!-- Client -->
                            <button onclick="selectReportType('client')" class="bg-gradient-to-br from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 border border-pink-500/30 rounded-xl p-4 text-left transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Client</p>
                                        <p class="text-xs text-pink-100">Data Klien</p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals - Always available for CRUD operations -->
        @include('dashboard.modals.hazard-report')
        @include('dashboard.modals.incident')
        @include('dashboard.modals.investigation')
        @include('dashboard.modals.audit')
        @include('dashboard.modals.temuan')
        @include('dashboard.modals.library-manual')
        @include('dashboard.modals.penerbangan')
        @include('dashboard.modals.flight-movement')
        @include('dashboard.modals.pesawat')
        @include('dashboard.modals.pilot')
        @include('dashboard.modals.client')
    </body>
</html>
