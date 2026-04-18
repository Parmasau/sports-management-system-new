<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sports Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .sidebar { background: linear-gradient(180deg, #2c2c2c 0%, #1a1a1a 100%); }
        .sidebar-item { transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.1); border-left-color: #ff6b6b; transform: translateX(5px); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.5s ease-out; }
        
        /* Profile dropdown styles */
        .profile-dropdown {
            position: relative;
            cursor: pointer;
        }
        .profile-dropdown-menu {
            position: absolute;
            bottom: 100%;
            left: 0;
            background: rgba(44, 44, 44, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            width: 220px;
            margin-bottom: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            z-index: 50;
        }
        .profile-dropdown:hover .profile-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .profile-dropdown-menu-item {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            border-radius: 8px;
            margin: 4px 8px;
            color: #fff;
        }
        .profile-dropdown-menu-item:hover {
            background: rgba(255, 107, 107, 0.2);
        }
        .profile-dropdown-menu-item i {
            width: 20px;
            color: #ff6b6b;
        }
        .profile-dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 8px;
        }
    </style>
</head>
<body class="flex">
    <!-- Sidebar -->
    <div class="sidebar w-64 min-h-screen fixed left-0 top-0 text-white flex flex-col">
        <div class="p-6">
            <div class="flex items-center space-x-2 mb-8">
                <i class="fas fa-crown text-3xl text-yellow-400"></i>
                <span class="text-xl font-bold">SportsMS Admin</span>
            </div>
            
            <!-- Navigation Links -->
            <nav class="space-y-2 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users w-5"></i><span>Users</span>
                </a>
                <a href="{{ route('admin.players') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.players*') ? 'active' : '' }}">
                    <i class="fas fa-futbol w-5"></i><span>Players</span>
                </a>
                <a href="{{ route('admin.teams') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.teams') ? 'active' : '' }}">
                    <i class="fas fa-building w-5"></i><span>Teams</span>
                </a>
                <a href="{{ route('admin.matches') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.matches') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-5"></i><span>Matches</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i><span>Reports</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog w-5"></i><span>Settings</span>
                </a>
            </nav>
        </div>
        
        <!-- Profile Dropdown -->
        <div class="mt-auto p-6 border-t border-white/20">
            <div class="profile-dropdown">
                <div class="flex items-center space-x-3 cursor-pointer group">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=667eea&color=fff&rounded=true&size=40" class="w-10 h-10 rounded-full border-2 border-yellow-400 group-hover:scale-105 transition">
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-300">Administrator</p>
                    </div>
                    <i class="fas fa-chevron-up text-xs text-gray-400 transition-transform group-hover:rotate-180"></i>
                </div>
                
                <div class="profile-dropdown-menu">
                    <a href="{{ route('my-profile') }}" class="profile-dropdown-menu-item">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="profile-dropdown-menu-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="profile-dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="profile-dropdown-menu-item w-full">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 flex-1 fade-in">
        <div class="bg-white shadow-lg sticky top-0 z-10">
            <div class="flex justify-between items-center px-8 py-4">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm text-gray-600">Welcome back,</p>
                        <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>