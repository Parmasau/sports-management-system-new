@extends('layouts.coach-app')
@section('title', 'Player Stats')
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-bold mb-6">📊 Player Statistics</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-3 font-semibold text-gray-700">Player</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Position</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Matches</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Goals</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Assists</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">John Doe</td>
                        <td class="px-4 py-3 text-gray-600">Forward</td>
                        <td class="px-4 py-3">24</td>
                        <td class="px-4 py-3 text-green-600 font-semibold">18</td>
                        <td class="px-4 py-3">7</td>
                        <td class="px-4 py-3">8.2</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">Jane Smith</td>
                        <td class="px-4 py-3 text-gray-600">Midfielder</td>
                        <td class="px-4 py-3">20</td>
                        <td class="px-4 py-3 text-green-600 font-semibold">5</td>
                        <td class="px-4 py-3">12</td>
                        <td class="px-4 py-3">7.8</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">Mike Johnson</td>
                        <td class="px-4 py-3 text-gray-600">Defender</td>
                        <td class="px-4 py-3">22</td>
                        <td class="px-4 py-3 text-green-600 font-semibold">2</td>
                        <td class="px-4 py-3">3</td>
                        <td class="px-4 py-3">7.5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
