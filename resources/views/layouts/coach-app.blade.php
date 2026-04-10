<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coach Dashboard') - Sports Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: url('https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=2070&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: -1;
        }
        .sidebar { 
            background: linear-gradient(180deg, rgba(15, 32, 39, 0.95) 0%, rgba(32, 58, 67, 0.95) 100%);
            backdrop-filter: blur(10px);
        }
        .sidebar-item { 
            transition: all 0.3s; 
            border-left: 3px solid transparent; 
        }
        .sidebar-item:hover, .sidebar-item.active { 
            background: rgba(255,255,255,0.15); 
            border-left-color: #ffd700; 
            transform: translateX(5px); 
        }
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        .fade-in { animation: fadeIn 0.5s ease-out; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255,215,0,0.5);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255,215,0,0.8);
        }
    </style>
</head>
<body class="flex">
    <!-- Sidebar -->
    <div class="sidebar w-64 min-h-screen fixed left-0 top-0 text-white flex flex-col z-20">
        <div class="p-6">
            <div class="flex items-center space-x-2 mb-8">
                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                    <i class="fas fa-whistle text-2xl text-gray-800"></i>
                </div>
                <span class="text-xl font-bold">SportsMS Coach</span>
            </div>
            
            <!-- Navigation Links -->
            <nav class="space-y-2 flex-1">
                <a href="{{ route('coach.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('coach.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('coach.players') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('coach.players*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5"></i><span>Manage Players</span>
                </a>
                <a href="{{ route('coach.training') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('coach.training*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-5"></i><span>Training</span>
                </a>
                <a href="{{ route('coach.stats') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('coach.stats*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-5"></i><span>Player Stats</span>
                </a>
                <a href="{{ route('coach.tactics') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('coach.tactics*') ? 'active' : '' }}">
                    <i class="fas fa-futbol w-5"></i><span>Tactics</span>
                </a>
            </nav>
        </div>
        
        <!-- Profile and Logout at Bottom -->
        <div class="mt-auto p-6 border-t border-white/20">
            <div class="flex items-center space-x-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=ffd700&color=1e3c72&rounded=true&size=40" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-300">Coach</p>
                </div>
            </div>
            <a href="{{ route('my-profile') }}" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg mb-2">
    <i class="fas fa-user-circle w-5"></i><span>My Profile</span>
</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item flex items-center space-x-3 px-4 py-2 rounded-lg w-full text-left hover:bg-red-600/20">
                    <i class="fas fa-sign-out-alt w-5"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 flex-1 fade-in p-6">
        @yield('content')
    </div>
</body>
</html>