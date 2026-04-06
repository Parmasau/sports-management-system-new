<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sports Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar { background: linear-gradient(180deg, #2c2c2c 0%, #1a1a1a 100%); }
        .sidebar-item { transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.1); border-left-color: #ff6b6b; transform: translateX(5px); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.5s ease-out; }
    </style>
</head>
<body class="flex">
    <div class="sidebar w-64 min-h-screen fixed left-0 top-0 text-white">
        <div class="p-6">
            <div class="flex items-center space-x-2 mb-8"><i class="fas fa-crown text-3xl text-yellow-400"></i><span class="text-xl font-bold">SportsMS Admin</span></div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item @if(request()->routeIs('admin.dashboard')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span></a>
                <a href="{{ route('admin.users') }}" class="sidebar-item @if(request()->routeIs('admin.users')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-users w-5"></i><span>Users</span></a>
                <a href="{{ route('admin.teams') }}" class="sidebar-item @if(request()->routeIs('admin.teams')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-building w-5"></i><span>Teams</span></a>
                <a href="{{ route('admin.matches') }}" class="sidebar-item @if(request()->routeIs('admin.matches')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-calendar-alt w-5"></i><span>Matches</span></a>
                <a href="{{ route('admin.health') }}" class="sidebar-item @if(request()->routeIs('admin.health')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-heartbeat w-5"></i><span>Health Records</span></a>
                <a href="{{ route('admin.lineups') }}" class="sidebar-item @if(request()->routeIs('admin.lineups')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-list-ol w-5"></i><span>Lineups</span></a>
                <a href="{{ route('admin.reports') }}" class="sidebar-item @if(request()->routeIs('admin.reports')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-chart-bar w-5"></i><span>Reports</span></a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item @if(request()->routeIs('admin.settings')) active @endif flex items-center space-x-3 px-4 py-3 rounded-lg"><i class="fas fa-cog w-5"></i><span>Settings</span></a>
            </nav>
        </div>
    </div>

    <div class="ml-64 flex-1 fade-in">
        <div class="bg-white shadow-lg sticky top-0 z-10">
            <div class="flex justify-between items-center px-8 py-4">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                <div class="flex items-center space-x-3 relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500">Administrator</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=667eea&color=fff&rounded=true" class="w-10 h-10 rounded-full">
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 top-14 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                        <a href="{{ route('admin.settings') }}" class="flex items-center space-x-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user-shield w-4 text-gray-400"></i><span>My Profile</span>
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt w-4"></i><span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>
