<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>DSWD IPCR Management System</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-50 font-sans text-slate-900">

<div class="min-h-screen flex"
     x-data="{ showLogoutModal:false, loggingOut:false }">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-900 text-white hidden md:flex flex-col shadow-xl z-20">

        <!-- Logo -->
        <div class="p-6 flex items-center gap-3 border-b border-white/20">
           <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center overflow-hidden">
    <img src="{{ asset('images/logo.png') }}"
         class="w-full h-full object-contain"
         alt="DSWD Logo">
</div>

            <div>
                <h1 class="font-bold text-lg leading-tight">DSWD</h1>
                <p class="text-xs text-blue-200">IPCR Management</p>
            </div>
        </div>

        <!-- Navigation -->
            <nav class="flex-1 py-6 px-3 space-y-1">
            <a href="{{ route('dashboards') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ (request()->routeIs('dashboards') || request()->routeIs('home')) ? 'bg-white/10 text-white font-medium' : 'text-blue-100 hover:bg-white hover:text-blue-900' }}"
               @if(request()->routeIs('dashboards') || request()->routeIs('dashboards')) aria-current="page" @endif>
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard Home
            </a>

            <a href="{{ route('ipcrf.list') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('ipcrf.*') ? 'bg-white/10 text-white font-medium' : 'text-blue-100 hover:bg-white hover:text-blue-900' }}"
               @if(request()->routeIs('ipcrf.*')) aria-current="page" @endif>
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Uploaded IPCRF List
            </a>
        </nav>

        <!-- User + Logout -->
        <div class="p-4 border-t border-white/20">

            <div class="flex items-center gap-3 px-4 py-3">
                <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p id="userDisplayName" class="text-sm font-medium truncate">User</p>
                    <p id="userDisplayRole" class="text-xs truncate text-blue-200">Role</p>
                </div>
            </div>

            <!-- Logout Trigger -->
            <button @click="showLogoutModal = true"
                class="w-full flex items-center gap-3 px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-white/10 rounded-lg transition-all">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Sign Out
            </button>

            <!-- Hidden Logout Form -->
            <form x-ref="logoutForm" method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Header -->
        <header class="bg-white border-b h-16 flex items-center justify-between px-6 shadow-sm">
            <h2 class="text-xl font-semibold">@yield('header', 'Dashboard')</h2>
            <button class="relative p-2 text-slate-400 hover:text-red-600">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div x-show="showLogoutModal"
         x-transition
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <div class="bg-white rounded-xl shadow-2xl p-6 w-96 text-center">
            <i data-lucide="log-out" class="w-12 h-12 mx-auto text-red-600 mb-4"></i>
            <h3 class="text-lg font-semibold mb-2">Confirm Logout</h3>
            <p class="text-sm text-gray-500 mb-6">Are you sure you want to sign out?</p>

            <div class="flex gap-3 justify-center">
                <button @click="showLogoutModal=false"
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>

                <button @click="
                    showLogoutModal=false;
                    loggingOut=true;
                    clearUserData();
                    setTimeout(() => $refs.logoutForm.submit(), 1200);
                "
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Logout
                </button>
            </div>
        </div>
    </div>

    <!-- LOGGING OUT ANIMATION -->
    <div x-show="loggingOut"
         x-transition.opacity
         class="fixed inset-0 bg-white flex flex-col items-center justify-center z-50">
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-900 border-t-transparent mb-6"></div>
        <h2 class="text-xl font-semibold text-blue-900">Logging out...</h2>
        <p class="text-gray-500 text-sm">Please wait</p>
    </div>

</div>

<!-- Scripts -->
<script>
    lucide.createIcons();

    function clearUserData() {
        localStorage.removeItem('user');
        localStorage.removeItem('rememberMe');
        sessionStorage.removeItem('user');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const stored = localStorage.getItem('user') || sessionStorage.getItem('user');
        if (stored) {
            try {
                const user = JSON.parse(stored);
                document.getElementById('userDisplayName').textContent = user.name || user.employee_id;
                document.getElementById('userDisplayRole').textContent = user.role || 'Role';
            } catch (e) {}
        }
    });
</script>

</body>
</html>
