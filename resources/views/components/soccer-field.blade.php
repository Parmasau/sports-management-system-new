@props(['formation' => '4-3-3', 'activePlayerId' => null, 'players' => []])

@php
// Define positions based on formation
$positions = [];
$formationMap = [
    '4-3-3' => [
        'GK' => ['x' => 50, 'y' => 85, 'label' => 'Goalkeeper'],
        'LB' => ['x' => 20, 'y' => 60, 'label' => 'Left Back'],
        'CB' => ['x' => 35, 'y' => 65, 'label' => 'Center Back'],
        'CB2' => ['x' => 65, 'y' => 65, 'label' => 'Center Back'],
        'RB' => ['x' => 80, 'y' => 60, 'label' => 'Right Back'],
        'CDM' => ['x' => 50, 'y' => 50, 'label' => 'CDM'],
        'CM' => ['x' => 35, 'y' => 40, 'label' => 'CM'],
        'CM2' => ['x' => 65, 'y' => 40, 'label' => 'CM'],
        'LW' => ['x' => 15, 'y' => 25, 'label' => 'Left Wing'],
        'ST' => ['x' => 50, 'y' => 20, 'label' => 'Striker'],
        'RW' => ['x' => 85, 'y' => 25, 'label' => 'Right Wing']
    ],
    '4-4-2' => [
        'GK' => ['x' => 50, 'y' => 85, 'label' => 'Goalkeeper'],
        'LB' => ['x' => 20, 'y' => 65, 'label' => 'Left Back'],
        'CB' => ['x' => 35, 'y' => 70, 'label' => 'Center Back'],
        'CB2' => ['x' => 65, 'y' => 70, 'label' => 'Center Back'],
        'RB' => ['x' => 80, 'y' => 65, 'label' => 'Right Back'],
        'LM' => ['x' => 20, 'y' => 45, 'label' => 'Left Mid'],
        'CM' => ['x' => 40, 'y' => 50, 'label' => 'CM'],
        'CM2' => ['x' => 60, 'y' => 50, 'label' => 'CM'],
        'RM' => ['x' => 80, 'y' => 45, 'label' => 'Right Mid'],
        'ST' => ['x' => 35, 'y' => 25, 'label' => 'Striker'],
        'ST2' => ['x' => 65, 'y' => 25, 'label' => 'Striker']
    ],
    '3-5-2' => [
        'GK' => ['x' => 50, 'y' => 85, 'label' => 'Goalkeeper'],
        'CB' => ['x' => 30, 'y' => 70, 'label' => 'Center Back'],
        'CB2' => ['x' => 50, 'y' => 72, 'label' => 'Center Back'],
        'CB3' => ['x' => 70, 'y' => 70, 'label' => 'Center Back'],
        'CDM' => ['x' => 50, 'y' => 58, 'label' => 'CDM'],
        'LM' => ['x' => 15, 'y' => 45, 'label' => 'Left Mid'],
        'CM' => ['x' => 40, 'y' => 48, 'label' => 'CM'],
        'CM2' => ['x' => 60, 'y' => 48, 'label' => 'CM'],
        'RM' => ['x' => 85, 'y' => 45, 'label' => 'Right Mid'],
        'ST' => ['x' => 35, 'y' => 25, 'label' => 'Striker'],
        'ST2' => ['x' => 65, 'y' => 25, 'label' => 'Striker']
    ]
];

$currentFormation = $formationMap[$formation] ?? $formationMap['4-3-3'];
@endphp

<div class="relative bg-green-800 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #1a5d1a 0%, #0d3d0d 100%); min-height: 600px;">
    <!-- Field Lines -->
    <div class="absolute inset-0 border-4 border-white/30 rounded-lg"></div>
    
    <!-- Center Circle -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 rounded-full border-2 border-white/30"></div>
    
    <!-- Center Line -->
    <div class="absolute top-0 left-1/2 w-0.5 h-full bg-white/30 transform -translate-x-1/2"></div>
    
    <!-- Penalty Areas -->
    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-44 h-28 border-2 border-white/30 rounded-lg" style="margin-bottom: -2px;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-44 h-28 border-2 border-white/30 rounded-lg" style="margin-top: -2px;"></div>
    
    <!-- Goal Areas -->
    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-28 h-12 border-2 border-white/30" style="margin-bottom: -2px;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-28 h-12 border-2 border-white/30" style="margin-top: -2px;"></div>
    
    <!-- Players -->
    @foreach($currentFormation as $position => $coords)
        @php
            $playerAtPosition = null;
            if(isset($players[$position])) {
                $playerAtPosition = $players[$position];
            }
            $isCurrentPlayer = $activePlayerId && $playerAtPosition && $playerAtPosition['id'] == $activePlayerId;
        @endphp
        
        <div class="absolute transform -translate-x-1/2 -translate-y-1/2 transition-all duration-300 hover:scale-110" 
             style="left: {{ $coords['x'] }}%; top: {{ $coords['y'] }}%;">
            <div class="relative group cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg 
                    {{ $isCurrentPlayer ? 'ring-4 ring-yellow-400 scale-110' : '' }}">
                    @if($playerAtPosition && $playerAtPosition['image'])
                        <img src="{{ asset('storage/' . $playerAtPosition['image']) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <span class="text-white font-bold text-xs">{{ substr($position, 0, 2) }}</span>
                    @endif
                </div>
                @if($playerAtPosition)
                    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap bg-black/80 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                        {{ $playerAtPosition['name'] }}
                        @if($isCurrentPlayer)
                            <span class="text-yellow-400 ml-1">(You)</span>
                        @endif
                    </div>
                @else
                    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap bg-black/80 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                        {{ $coords['label'] }}
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    
    <!-- Position Labels (visible on hover) -->
    <div class="absolute bottom-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
        Formation: {{ $formation }}
    </div>
</div>
