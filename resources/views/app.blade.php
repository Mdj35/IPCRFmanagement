<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DSWD IPCR Management System</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex-shrink-0 hidden md:flex flex-col shadow-xl z-20">
            <div class="p-6 flex items-center gap-3 border-b border-white-800">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 font-bold text-xl shadow-sm">
                    D
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">DSWD</h1>
                    <p class="text-xs text-white-300">IPCR Management</p>
                </div>
            </div>

            <nav class="flex-1 py-6 px-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-medium shadow-inner' : 'text-blue-100 hover:bg-white hover:text-blue-900' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard Home
                </a>
                <a href="{{ route('ipcrf.list') }}" 
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all 
                {{ request()->routeIs('ipcrf.list') 
                        ? 'bg-white/10 text-white font-medium shadow-inner' 
                        : 'text-blue-100 hover:bg-white hover:text-blue-900' }}">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    Uploaded IPCRF List
                </a>

            </nav>

            <div class="p-4 border-t border-white-800">
                <div class="flex items-center gap-3 px-4 py-3 text-white-200">
                    <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ session('user')['name'] ?? 'User' }}</p>
                        <p class="text-xs truncate">{{ session('user')['role'] ?? 'Role' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-white-300 hover:text-white hover:bg-white/10 rounded-lg transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-slate-500 hover:text-slate-700">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-slate-800">
                        @yield('header', 'Encoder Dashboard')
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-2 text-slate-400 hover:text-red-600 transition-colors relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 relative">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
