<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sports Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-sports {
            background-image: url('https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=1200&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .glass { backdrop-filter: blur(12px); background: rgba(0,0,0,0.55); }
        input:-webkit-autofill { -webkit-box-shadow: 0 0 0 30px #1e1e2e inset !important; -webkit-text-fill-color: #fff !important; }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Left: Background Image Panel -->
    <div class="hidden lg:flex lg:w-1/2 bg-sports relative">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/80 to-indigo-900/70"></div>
        <div class="relative z-10 flex flex-col justify-center items-center text-white p-16 text-center">
            <div class="text-6xl mb-6">⚽</div>
            <h1 class="text-4xl font-extrabold mb-4 leading-tight">Sports Management<br>System</h1>
            <p class="text-lg text-purple-200 mb-8">Manage teams, players, matches and performance — all in one place.</p>
            <div class="grid grid-cols-3 gap-6 w-full max-w-sm">
                <div class="bg-white/10 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold">50+</div>
                    <div class="text-xs text-purple-200 mt-1">Players</div>
                </div>
                <div class="bg-white/10 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold">12</div>
                    <div class="text-xs text-purple-200 mt-1">Teams</div>
                </div>
                <div class="bg-white/10 rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold">200+</div>
                    <div class="text-xs text-purple-200 mt-1">Matches</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-950 px-8 py-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="text-4xl mb-3">🏆</div>
                <h2 class="text-3xl font-extrabold text-white">Welcome back</h2>
                <p class="text-gray-400 mt-2">Sign in to your account</p>
            </div>

            @if(session('status'))
                <div class="mb-4 bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-500"
                            placeholder="you@example.com">
                    </div>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="password" name="password" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-500"
                            placeholder="••••••••">
                    </div>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-600 bg-gray-800 text-purple-500 focus:ring-purple-500">
                        <span class="text-sm text-gray-400">Remember me</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-purple-300">Forgot password?</a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-lg shadow-purple-900/40">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>

                <p class="text-center text-gray-400 text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-medium">Create one</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
