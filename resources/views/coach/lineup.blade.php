@extends('layouts.coach-app')
@section('title', 'Line Up')
@section('content')
<div class="p-6" x-data="lineupBuilder()" x-init="init()">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ── LEFT: Player Roster ──────────────────────────────── --}}
        <div class="xl:col-span-1 space-y-4">

            {{-- Formation & Match --}}
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="font-bold text-gray-700 mb-3">⚙️ Setup</h3>
                <input x-model="matchName" placeholder="Match name (e.g. vs Blue Eagles)"
                    class="w-full border rounded-lg px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                <select x-model="formation" @change="resetSlots()"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="4-3-3">4-3-3</option>
                    <option value="4-4-2">4-4-2</option>
                    <option value="3-5-2">3-5-2</option>
                    <option value="4-2-3-1">4-2-3-1</option>
                    <option value="5-3-2">5-3-2</option>
                </select>
            </div>

            {{-- Player Pool --}}
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-700">👥 Players</h3>
                    <span class="text-xs text-gray-400" x-text="`${availablePlayers().length} available`"></span>
                </div>

                @if($players->isEmpty())
                    <p class="text-gray-400 text-sm text-center py-4">No players added yet.<br>
                        <a href="{{ route('coach.players') }}" class="text-green-600 underline">Add players first</a>
                    </p>
                @else
                    {{-- Position filter --}}
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach(['All','Goalkeeper','Defender','Midfielder','Forward'] as $f)
                        <button @click="posFilter = '{{ $f }}'"
                            :class="posFilter === '{{ $f }}' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600'"
                            class="text-xs px-2 py-1 rounded-full transition">{{ $f }}</button>
                        @endforeach
                    </div>

                    <div class="space-y-1 max-h-96 overflow-y-auto pr-1">
                        @foreach($players as $player)
                        <div x-show="(posFilter === 'All' || posFilter === '{{ $player->position }}') && !isAssigned({{ $player->id }})"
                            @click="selectPlayer({{ $player->id }})"
                            :class="selectedPlayer?.id === {{ $player->id }} ? 'ring-2 ring-green-500 bg-green-50' : 'bg-gray-50 hover:bg-gray-100'"
                            class="flex items-center justify-between px-3 py-2 rounded-lg cursor-pointer transition">
                            <div class="flex items-center space-x-2">
                                <span class="w-7 h-7 rounded-full bg-green-600 text-white text-xs font-bold flex items-center justify-center">#{{ $player->jersey_number }}</span>
                                <div>
                                    <div class="text-sm font-semibold leading-tight">{{ $player->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $player->position }}</div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">{{ $player->goals }}G</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Substitutes bench --}}
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="font-bold text-gray-700 mb-3">🔄 Substitutes Bench</h3>
                <div class="space-y-1 min-h-12">
                    <template x-for="sub in substitutes" :key="sub.id">
                        <div class="flex items-center justify-between bg-yellow-50 border border-yellow-200 px-3 py-2 rounded-lg">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-full bg-yellow-500 text-white text-xs font-bold flex items-center justify-center" x-text="`#${sub.jersey}`"></span>
                                <span class="text-sm font-medium" x-text="sub.name"></span>
                            </div>
                            <button @click="removeSub(sub.id)" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                        </div>
                    </template>
                    <p x-show="substitutes.length === 0" class="text-gray-400 text-xs text-center py-2">Click a player then "Add as Sub"</p>
                </div>
                <button x-show="selectedPlayer && !isAssigned(selectedPlayer.id)"
                    @click="addSub()"
                    class="mt-2 w-full bg-yellow-400 hover:bg-yellow-500 text-white text-sm py-2 rounded-lg transition">
                    + Add <span x-text="selectedPlayer?.name"></span> as Sub
                </button>
            </div>

            {{-- Save button --}}
            <form method="POST" action="{{ route('coach.lineup.store') }}" @submit.prevent="submitLineup($el)">
                @csrf
                <input type="hidden" name="match_name" :value="matchName">
                <input type="hidden" name="formation" :value="formation">
                <template x-for="(slot, i) in filledSlots()" :key="i">
                    <input type="hidden" :name="`starting_xi[]`" :value="slot">
                </template>
                <template x-for="(sub, i) in substitutes" :key="i">
                    <input type="hidden" :name="`substitutes[]`" :value="`${sub.name} #${sub.jersey}`">
                </template>
                <button type="submit"
                    :disabled="filledSlots().length < 11 || !matchName"
                    :class="filledSlots().length === 11 && matchName ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-300 cursor-not-allowed'"
                    class="w-full text-white font-semibold py-3 rounded-xl transition">
                    💾 Save Lineup
                    <span x-text="`(${filledSlots().length}/11)`" class="text-sm opacity-75"></span>
                </button>
            </form>
        </div>

        {{-- ── RIGHT: Football Pitch ────────────────────────────── --}}
        <div class="xl:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-700">🏟️ Pitch — <span x-text="formation" class="text-green-600"></span></h3>
                    <button @click="resetSlots()" class="text-xs text-red-400 hover:text-red-600">Clear All</button>
                </div>

                {{-- Pitch --}}
                <div class="relative w-full rounded-xl overflow-hidden" style="background: #2d8a4e; aspect-ratio: 3/4; max-height: 620px;">

                    {{-- Pitch markings --}}
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 300 400" preserveAspectRatio="none">
                        <rect x="1" y="1" width="298" height="398" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        <line x1="1" y1="200" x2="299" y2="200" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <circle cx="150" cy="200" r="40" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <circle cx="150" cy="200" r="3" fill="rgba(255,255,255,0.6)"/>
                        {{-- Top penalty box --}}
                        <rect x="75" y="1" width="150" height="60" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <rect x="110" y="1" width="80" height="25" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <circle cx="150" cy="55" r="3" fill="rgba(255,255,255,0.6)"/>
                        {{-- Bottom penalty box --}}
                        <rect x="75" y="339" width="150" height="60" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <rect x="110" y="374" width="80" height="25" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <circle cx="150" cy="345" r="3" fill="rgba(255,255,255,0.6)"/>
                        {{-- Corner arcs --}}
                        <path d="M1,1 Q8,1 8,8" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <path d="M299,1 Q292,1 292,8" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <path d="M1,399 Q8,399 8,392" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <path d="M299,399 Q292,399 292,392" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                    </svg>

                    {{-- Position slots --}}
                    <template x-for="(slot, idx) in slots" :key="idx">
                        <div class="absolute transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center"
                            :style="`left: ${slot.x}%; top: ${slot.y}%`">

                            {{-- Filled slot --}}
                            <template x-if="slot.player">
                                <div class="flex flex-col items-center cursor-pointer group" @click="removeFromSlot(idx)">
                                    <div class="w-10 h-10 rounded-full border-2 border-white shadow-lg flex items-center justify-center text-white font-bold text-sm relative"
                                        :class="posColor(slot.label)">
                                        <span x-text="`#${slot.player.jersey}`"></span>
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full hidden group-hover:flex items-center justify-center text-white text-xs">✕</div>
                                    </div>
                                    <div class="mt-1 bg-black/60 text-white text-xs px-1.5 py-0.5 rounded whitespace-nowrap max-w-20 truncate" x-text="slot.player.shortName"></div>
                                    <div class="text-white/70 text-xs" x-text="slot.label"></div>
                                </div>
                            </template>

                            {{-- Empty slot --}}
                            <template x-if="!slot.player">
                                <div class="flex flex-col items-center cursor-pointer" @click="assignToSlot(idx)">
                                    <div class="w-10 h-10 rounded-full border-2 border-dashed border-white/60 flex items-center justify-center text-white/60 hover:border-white hover:bg-white/10 transition"
                                        :class="selectedPlayer ? 'animate-pulse border-white' : ''">
                                        <span class="text-lg">+</span>
                                    </div>
                                    <div class="mt-1 text-white/60 text-xs" x-text="slot.label"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Saved Lineups --}}
            <div class="bg-white rounded-xl shadow-sm p-4">
                <h3 class="font-bold text-gray-700 mb-3">📋 Saved Lineups</h3>
                @forelse($lineups as $lineup)
                <div class="bg-gray-50 rounded-lg px-4 py-3 mb-2">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="font-semibold">{{ $lineup->match_name }}
                                <span class="text-xs text-gray-400 ml-2">{{ $lineup->formation }}</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach($lineup->starting_xi as $entry)
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full">{{ $entry }}</span>
                                @endforeach
                            </div>
                            @if(count($lineup->substitutes))
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach($lineup->substitutes as $sub)
                                    <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-0.5 rounded-full">SUB: {{ $sub }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('coach.lineup.destroy', $lineup) }}" onsubmit="return confirm('Delete?')" class="ml-3">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-4">No lineups saved yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
const PLAYERS = @json($playerData);

const FORMATIONS = {
    '4-3-3': [
        {label:'GK',  x:50, y:92},
        {label:'RB',  x:82, y:75}, {label:'CB',  x:62, y:75}, {label:'CB',  x:38, y:75}, {label:'LB',  x:18, y:75},
        {label:'CM',  x:75, y:55}, {label:'CM',  x:50, y:52}, {label:'CM',  x:25, y:55},
        {label:'RW',  x:80, y:30}, {label:'ST',  x:50, y:25}, {label:'LW',  x:20, y:30},
    ],
    '4-4-2': [
        {label:'GK',  x:50, y:92},
        {label:'RB',  x:82, y:75}, {label:'CB',  x:62, y:75}, {label:'CB',  x:38, y:75}, {label:'LB',  x:18, y:75},
        {label:'RM',  x:82, y:52}, {label:'CM',  x:62, y:52}, {label:'CM',  x:38, y:52}, {label:'LM',  x:18, y:52},
        {label:'ST',  x:65, y:25}, {label:'ST',  x:35, y:25},
    ],
    '3-5-2': [
        {label:'GK',  x:50, y:92},
        {label:'CB',  x:70, y:75}, {label:'CB',  x:50, y:75}, {label:'CB',  x:30, y:75},
        {label:'RM',  x:88, y:55}, {label:'CM',  x:68, y:52}, {label:'CM',  x:50, y:50}, {label:'CM',  x:32, y:52}, {label:'LM',  x:12, y:55},
        {label:'ST',  x:65, y:25}, {label:'ST',  x:35, y:25},
    ],
    '4-2-3-1': [
        {label:'GK',  x:50, y:92},
        {label:'RB',  x:82, y:75}, {label:'CB',  x:62, y:75}, {label:'CB',  x:38, y:75}, {label:'LB',  x:18, y:75},
        {label:'DM',  x:65, y:60}, {label:'DM',  x:35, y:60},
        {label:'RAM', x:78, y:40}, {label:'CAM', x:50, y:38}, {label:'LAM', x:22, y:40},
        {label:'ST',  x:50, y:20},
    ],
    '5-3-2': [
        {label:'GK',  x:50, y:92},
        {label:'RWB', x:88, y:72}, {label:'CB',  x:70, y:76}, {label:'CB',  x:50, y:78}, {label:'CB',  x:30, y:76}, {label:'LWB', x:12, y:72},
        {label:'CM',  x:70, y:52}, {label:'CM',  x:50, y:50}, {label:'CM',  x:30, y:52},
        {label:'ST',  x:65, y:25}, {label:'ST',  x:35, y:25},
    ],
};

function lineupBuilder() {
    return {
        formation: '4-3-3',
        matchName: '',
        slots: [],
        selectedPlayer: null,
        substitutes: [],
        posFilter: 'All',

        init() { this.resetSlots(); },

        resetSlots() {
            const template = FORMATIONS[this.formation] || FORMATIONS['4-3-3'];
            this.slots = template.map(s => ({ ...s, player: null }));
            this.selectedPlayer = null;
        },

        selectPlayer(id) {
            const p = PLAYERS.find(p => p.id === id);
            this.selectedPlayer = (this.selectedPlayer?.id === id) ? null : p;
        },

        isAssigned(id) {
            return this.slots.some(s => s.player?.id === id) || this.substitutes.some(s => s.id === id);
        },

        availablePlayers() {
            return PLAYERS.filter(p => !this.isAssigned(p.id));
        },

        assignToSlot(idx) {
            if (!this.selectedPlayer) return;
            if (this.isAssigned(this.selectedPlayer.id)) return;
            this.slots[idx].player = this.selectedPlayer;
            this.selectedPlayer = null;
        },

        removeFromSlot(idx) {
            this.slots[idx].player = null;
        },

        addSub() {
            if (!this.selectedPlayer || this.isAssigned(this.selectedPlayer.id)) return;
            this.substitutes.push(this.selectedPlayer);
            this.selectedPlayer = null;
        },

        removeSub(id) {
            this.substitutes = this.substitutes.filter(s => s.id !== id);
        },

        filledSlots() {
            return this.slots.filter(s => s.player).map(s => `${s.label}: ${s.player.name} #${s.player.jersey}`);
        },

        posColor(label) {
            if (label === 'GK') return 'bg-yellow-500';
            if (['CB','RB','LB','RWB','LWB'].includes(label)) return 'bg-blue-600';
            if (['CM','DM','RM','LM','RAM','LAM','CAM'].includes(label)) return 'bg-green-700';
            return 'bg-red-600';
        },

        submitLineup(form) {
            if (this.filledSlots().length < 11) { alert('Please fill all 11 positions.'); return; }
            if (!this.matchName) { alert('Please enter a match name.'); return; }
            form.submit();
        },
    };
}
</script>
@endsection
