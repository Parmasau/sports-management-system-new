@extends('layouts.coach-app')
@section('title', 'Tactic Field - ' . $tactic->formation)
@section('content')
<div class="p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $tactic->formation }} Formation</h1>
                <p class="text-gray-600 mt-1">{{ $tactic->pressing_style }} | {{ $tactic->attacking_focus }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('coach.tactics') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
                <a href="{{ route('coach.tactics.edit', $tactic->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                    <i class="fas fa-edit mr-2"></i>Edit Tactic
                </a>
            </div>
        </div>
        
        <!-- Soccer Field -->
        <div class="mb-6">
            <x-soccer-field :formation="$tactic->formation" />
        </div>
        
        <!-- Tactic Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="border rounded-lg p-4">
                <h3 class="font-bold text-lg mb-2">Strategy</h3>
                <p class="text-gray-700">{{ $tactic->strategy ?? 'No strategy defined' }}</p>
            </div>
            <div class="border rounded-lg p-4">
                <h3 class="font-bold text-lg mb-2">Set Pieces</h3>
                <p class="text-gray-700">{{ $tactic->set_pieces ?: 'No set pieces defined' }}</p>
            </div>
        </div>
        
        <!-- Player Assignment -->
        <div class="mt-6 border rounded-lg p-4">
            <h3 class="font-bold text-lg mb-4">Player Positions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @php
                    $positionLabels = [
                        'GK' => 'Goalkeeper', 'LB' => 'Left Back', 'CB' => 'Center Back',
                        'CB2' => 'Center Back', 'RB' => 'Right Back', 'CDM' => 'CDM',
                        'CM' => 'Center Mid', 'CM2' => 'Center Mid', 'LW' => 'Left Wing',
                        'ST' => 'Striker', 'RW' => 'Right Wing', 'LM' => 'Left Mid',
                        'RM' => 'Right Mid', 'ST2' => 'Second Striker', 'CB3' => 'Center Back'
                    ];
                @endphp
                @foreach($tactic->getPositionMap() as $position => $index)
                <div class="bg-gray-100 rounded p-2 text-center">
                    <div class="font-semibold text-blue-600">{{ $position }}</div>
                    <div class="text-sm text-gray-600">{{ $positionLabels[$position] ?? $position }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection