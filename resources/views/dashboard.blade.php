<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <div class="text-center mb-8">
                        <div class="text-6xl mb-4">⚽</div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to Sports Management System</h1>
                        <p class="text-gray-600">Manage your sports activities efficiently</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white p-6 rounded-lg shadow-lg">
                            <div class="text-2xl mb-2">🏆</div>
                            <h3 class="text-xl font-semibold">Teams</h3>
                            <p>Manage your teams</p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-400 to-pink-500 text-white p-6 rounded-lg shadow-lg">
                            <div class="text-2xl mb-2">📅</div>
                            <h3 class="text-xl font-semibold">Matches</h3>
                            <p>Schedule and track matches</p>
                        </div>
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-6 rounded-lg shadow-lg">
                            <div class="text-2xl mb-2">📊</div>
                            <h3 class="text-xl font-semibold">Statistics</h3>
                            <p>View performance stats</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
