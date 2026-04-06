<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=1600&auto=format&fit=crop');
            background-size: cover;
            background-position: center top;
        }
        .section-bg {
            background-image: url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=1600&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp 0.7s ease-out forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.25s; opacity: 0; }
        .delay-3 { animation-delay: 0.4s; opacity: 0; }
        .delay-4 { animation-delay: 0.55s; opacity: 0; }
    </style>
</head>
<body class="bg-gray-950 text-white">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-950/80 backdrop-blur-md border-b border-white/10" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2">
                <span class="text-2xl">⚽</span>
                <span class="text-xl font-extrabold bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">SportsMS</span>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-gray-300 hover:text-white text-sm transition">Features</a>
                <a href="#roles" class="text-gray-300 hover:text-white text-sm transition">Roles</a>
                <a href="#stats" class="text-gray-300 hover:text-white text-sm transition">Stats</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Get Started</a>
                @endauth
            </div>
            <!-- Mobile menu button -->
            <button @click="open = !open" class="md:hidden text-gray-300 hover:text-white">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <!-- Mobile menu -->
        <div x-show="open" x-transition class="md:hidden bg-gray-900 border-t border-white/10 px-6 py-4 space-y-3">
            <a href="#features" class="block text-gray-300 hover:text-white text-sm">Features</a>
            <a href="#roles" class="block text-gray-300 hover:text-white text-sm">Roles</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="block text-purple-400 font-semibold text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white text-sm">Login</a>
                <a href="{{ route('register') }}" class="block text-purple-400 font-semibold text-sm">Get Started</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg relative min-h-screen flex items-center">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-950/85 to-gray-950/40"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-32">
            <div class="max-w-2xl">
                <div class="inline-flex items-center space-x-2 bg-purple-500/20 border border-purple-500/30 rounded-full px-4 py-1.5 mb-6 fade-up delay-1">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-sm text-purple-300 font-medium">Now Live — Season 2024/25</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 fade-up delay-2">
                    The Ultimate<br>
                    <span class="bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">Sports Management</span><br>
                    Platform
                </h1>
                <p class="text-lg text-gray-300 mb-10 leading-relaxed fade-up delay-3">
                    Manage players, coaches, matches, lineups, health records and performance stats — all from one powerful dashboard.
                </p>
                <div class="flex flex-wrap gap-4 fade-up delay-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition shadow-xl shadow-purple-900/40">
                            <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition shadow-xl shadow-purple-900/40">
                            <i class="fas fa-rocket mr-2"></i>Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg transition backdrop-blur-sm">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-gray-400 animate-bounce">
            <i class="fas fa-chevron-down text-xl"></i>
        </div>
    </section>

    <!-- Stats Bar -->
    <section id="stats" class="bg-gradient-to-r from-purple-900/50 to-indigo-900/50 border-y border-white/10 py-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-extrabold text-white">500+</div>
                <div class="text-gray-400 text-sm mt-1">Registered Players</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-white">40+</div>
                <div class="text-gray-400 text-sm mt-1">Active Teams</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-white">1,200+</div>
                <div class="text-gray-400 text-sm mt-1">Matches Played</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-white">98%</div>
                <div class="text-gray-400 text-sm mt-1">Satisfaction Rate</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gray-950">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold mb-4">Everything You Need</h2>
                <p class="text-gray-400 text-lg max-w-xl mx-auto">A complete toolkit for managing every aspect of your sports organization.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                    ['🏆', 'Team Management', 'Create and manage multiple teams, assign players, track wins and losses all in one place.', 'from-yellow-500/20 to-orange-500/20', 'border-yellow-500/30'],
                    ['⚽', 'Match Scheduling', 'Schedule fixtures, record scores, manage home and away games with ease.', 'from-green-500/20 to-teal-500/20', 'border-green-500/30'],
                    ['📊', 'Player Statistics', 'Track goals, assists, ratings, and full performance history for every player.', 'from-blue-500/20 to-cyan-500/20', 'border-blue-500/30'],
                    ['🏥', 'Health Records', 'Monitor player fitness, injuries, recovery status and estimated return dates.', 'from-red-500/20 to-pink-500/20', 'border-red-500/30'],
                    ['📋', 'Lineup Builder', 'Build match lineups, pick formations, assign starting XI and substitutes.', 'from-purple-500/20 to-indigo-500/20', 'border-purple-500/30'],
                    ['🎯', 'Tactics Board', 'Define pressing styles, attacking focus, set piece strategies and formations.', 'from-indigo-500/20 to-violet-500/20', 'border-indigo-500/30'],
                ] as [$icon, $title, $desc, $gradient, $border])
                <div class="bg-gradient-to-br {{ $gradient }} border {{ $border }} rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl mb-4">{{ $icon }}</div>
                    <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="section-bg relative py-24">
        <div class="absolute inset-0 bg-gray-950/90"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold mb-4">Built for Every Role</h2>
                <p class="text-gray-400 text-lg">Tailored dashboards and tools for admins, coaches, and players.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-8 text-center hover:border-purple-500/50 transition">
                    <div class="text-5xl mb-4">👑</div>
                    <h3 class="text-2xl font-bold mb-3 text-purple-400">Admin</h3>
                    <ul class="text-gray-400 text-sm space-y-2 text-left">
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-purple-400 w-4"></i><span>Manage all users & roles</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-purple-400 w-4"></i><span>Oversee all teams & matches</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-purple-400 w-4"></i><span>Generate system reports</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-purple-400 w-4"></i><span>Configure system settings</span></li>
                    </ul>
                </div>
                <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-8 text-center hover:border-green-500/50 transition">
                    <div class="text-5xl mb-4">🏋️</div>
                    <h3 class="text-2xl font-bold mb-3 text-green-400">Coach</h3>
                    <ul class="text-gray-400 text-sm space-y-2 text-left">
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-green-400 w-4"></i><span>Add & manage players</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-green-400 w-4"></i><span>Build match lineups</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-green-400 w-4"></i><span>Schedule training sessions</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-green-400 w-4"></i><span>Monitor player health</span></li>
                    </ul>
                </div>
                <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-8 text-center hover:border-blue-500/50 transition">
                    <div class="text-5xl mb-4">⚽</div>
                    <h3 class="text-2xl font-bold mb-3 text-blue-400">Player</h3>
                    <ul class="text-gray-400 text-sm space-y-2 text-left">
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-blue-400 w-4"></i><span>View personal stats</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-blue-400 w-4"></i><span>Check upcoming matches</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-blue-400 w-4"></i><span>View team & achievements</span></li>
                        <li class="flex items-center space-x-2"><i class="fas fa-check text-blue-400 w-4"></i><span>Manage your profile</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-purple-900/40 to-indigo-900/40 border-y border-white/10">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <div class="text-5xl mb-6">🚀</div>
            <h2 class="text-4xl font-extrabold mb-4">Ready to Get Started?</h2>
            <p class="text-gray-400 text-lg mb-10">Join hundreds of teams already using SportsMS to manage their sports operations.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-10 py-4 rounded-xl font-semibold text-lg transition shadow-xl shadow-purple-900/40 inline-block">
                    Go to Dashboard <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-10 py-4 rounded-xl font-semibold text-lg transition shadow-xl shadow-purple-900/40 inline-block">
                    Create Free Account <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-950 border-t border-white/10 py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center space-x-2">
                <span class="text-2xl">⚽</span>
                <span class="font-bold text-lg bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">SportsMS</span>
            </div>
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Sports Management System. All rights reserved.</p>
            <div class="flex space-x-4 text-gray-500 text-sm">
                <a href="{{ route('login') }}" class="hover:text-white transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-white transition">Register</a>
            </div>
        </div>
    </footer>

</body>
</html>
