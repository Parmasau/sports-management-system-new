<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sports Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-sports {
            background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        input:-webkit-autofill { -webkit-box-shadow: 0 0 0 30px #1e1e2e inset !important; -webkit-text-fill-color: #fff !important; }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Left: Background Image Panel -->
    <div class="hidden lg:flex lg:w-1/2 bg-sports relative">
        <div class="absolute inset-0 bg-gradient-to-br from-green-900/80 to-teal-900/70"></div>
        <div class="relative z-10 flex flex-col justify-center items-center text-white p-16 text-center">
            <div class="text-6xl mb-6">🏅</div>
            <h1 class="text-4xl font-extrabold mb-4 leading-tight">Join the<br>Winning Team</h1>
            <p class="text-lg text-green-200 mb-10">Create your account and start managing your sports journey today.</p>
            <div class="space-y-4 w-full max-w-xs">
                <div class="flex items-center space-x-3 bg-white/10 rounded-xl px-5 py-3">
                    <i class="fas fa-users text-green-300 text-xl w-6"></i>
                    <span class="text-sm">Manage players & teams</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/10 rounded-xl px-5 py-3">
                    <i class="fas fa-chart-line text-green-300 text-xl w-6"></i>
                    <span class="text-sm">Track performance & stats</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/10 rounded-xl px-5 py-3">
                    <i class="fas fa-calendar-alt text-green-300 text-xl w-6"></i>
                    <span class="text-sm">Schedule matches & training</span>
                </div>
                <div class="flex items-center space-x-3 bg-white/10 rounded-xl px-5 py-3">
                    <i class="fas fa-heartbeat text-green-300 text-xl w-6"></i>
                    <span class="text-sm">Monitor player health</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-950 px-8 py-12 overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="text-4xl mb-3">⚽</div>
                <h2 class="text-3xl font-extrabold text-white">Create Account</h2>
                <p class="text-gray-400 mt-2">Fill in your details to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-500"
                            placeholder="John Doe">
                    </div>
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-500"
                            placeholder="you@example.com">
                    </div>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Register as</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['player' => ['⚽','Player'], 'coach' => ['🏋️','Coach'], 'admin' => ['👑','Admin']] as $value => [$icon, $label])
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="{{ $value }}" {{ old('role', 'player') === $value ? 'checked' : '' }} class="sr-only peer">
                            <div class="flex flex-col items-center justify-center py-3 rounded-lg border-2 border-gray-700 bg-gray-800 peer-checked:border-green-500 peer-checked:bg-green-500/10 transition-all hover:border-gray-500">
                                <span class="text-xl">{{ $icon }}</span>
                                <span class="text-xs font-medium text-gray-300 mt-1">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="password" name="password" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-500"
                            placeholder="Min. 8 characters">
                    </div>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-500"
                            placeholder="Repeat password">
                    </div>
                    @error('password_confirmation')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-semibold py-3 rounded-lg transition-all duration-200 shadow-lg shadow-green-900/40 mt-2">
                    <i class="fas fa-user-plus mr-2"></i>Create Account
                </button>

                <p class="text-center text-gray-400 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-medium">Sign in</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
