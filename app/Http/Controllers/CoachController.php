<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\TrainingSession;
use App\Models\Lineup;
use App\Models\HealthRecord;
use App\Models\Tactic;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('dashboards.coach');
    }

    // ── Players ──────────────────────────────────────────────
    public function players()
    {
        return view('coach.players', ['players' => Player::latest()->get()]);
    }

    public function storePlayer(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'position'      => 'required|string|max:50',
            'jersey_number' => 'required|integer',
        ]);
        Player::create($request->only('name', 'position', 'jersey_number', 'matches', 'goals', 'assists', 'rating'));
        return back()->with('success', 'Player added.');
    }

    public function updatePlayer(Request $request, Player $player)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'position'      => 'required|string|max:50',
            'jersey_number' => 'required|integer',
        ]);
        $player->update($request->only('name', 'position', 'jersey_number', 'matches', 'goals', 'assists', 'rating'));
        return back()->with('success', 'Player updated.');
    }

    public function destroyPlayer(Player $player)
    {
        $player->delete();
        return back()->with('success', 'Player removed.');
    }

    // ── Training ─────────────────────────────────────────────
    public function training()
    {
        return view('coach.training', ['sessions' => TrainingSession::latest()->get()]);
    }

    public function storeTraining(Request $request)
    {
        $request->validate([
            'day'      => 'required|string',
            'time'     => 'required',
            'type'     => 'required|string',
            'location' => 'required|string',
            'status'   => 'required|in:scheduled,pending,completed,cancelled',
        ]);
        TrainingSession::create($request->only('day', 'time', 'type', 'location', 'status'));
        return back()->with('success', 'Session added.');
    }

    public function updateTraining(Request $request, TrainingSession $training)
    {
        $request->validate([
            'day'      => 'required|string',
            'time'     => 'required',
            'type'     => 'required|string',
            'location' => 'required|string',
            'status'   => 'required|in:scheduled,pending,completed,cancelled',
        ]);
        $training->update($request->only('day', 'time', 'type', 'location', 'status'));
        return back()->with('success', 'Session updated.');
    }

    public function destroyTraining(TrainingSession $training)
    {
        $training->delete();
        return back()->with('success', 'Session removed.');
    }

    // ── Stats ─────────────────────────────────────────────────
    public function stats()
    {
        return view('coach.stats', ['players' => Player::orderByDesc('goals')->get()]);
    }

    // ── Tactics ───────────────────────────────────────────────
    public function tactics()
    {
        return view('coach.tactics', ['tactics' => Tactic::latest()->get()]);
    }

    public function storeTactic(Request $request)
    {
        $request->validate([
            'formation'      => 'required|string',
            'pressing_style' => 'required|string',
            'attacking_focus'=> 'required|string',
            'set_pieces'     => 'required|string',
        ]);
        Tactic::create($request->only('formation', 'pressing_style', 'attacking_focus', 'set_pieces') + ['is_active' => false]);
        return back()->with('success', 'Tactic added.');
    }

    public function updateTactic(Request $request, Tactic $tactic)
    {
        $request->validate([
            'formation'      => 'required|string',
            'pressing_style' => 'required|string',
            'attacking_focus'=> 'required|string',
            'set_pieces'     => 'required|string',
        ]);
        $tactic->update($request->only('formation', 'pressing_style', 'attacking_focus', 'set_pieces'));
        return back()->with('success', 'Tactic updated.');
    }

    public function activateTactic(Tactic $tactic)
    {
        Tactic::query()->update(['is_active' => false]);
        $tactic->update(['is_active' => true]);
        return back()->with('success', 'Tactic set as active.');
    }

    public function destroyTactic(Tactic $tactic)
    {
        $tactic->delete();
        return back()->with('success', 'Tactic removed.');
    }

    // ── Lineup ────────────────────────────────────────────────
    public function lineup()
    {
        $players = Player::orderBy('position')->get();
        $playerData = $players->map(function ($p) {
            return [
                'id'        => $p->id,
                'name'      => $p->name,
                'shortName' => strlen($p->name) > 10 ? substr($p->name, 0, 9).'.' : $p->name,
                'position'  => $p->position,
                'jersey'    => $p->jersey_number,
                'goals'     => $p->goals,
            ];
        })->values();

        return view('coach.lineup', [
            'lineups'    => Lineup::latest()->get(),
            'players'    => $players,
            'playerData' => $playerData,
        ]);
    }

    public function storeLineup(Request $request)
    {
        $request->validate([
            'match_name'  => 'required|string',
            'formation'   => 'required|string',
            'starting_xi' => 'required|array|min:11|max:11',
            'substitutes' => 'nullable|array',
        ]);
        Lineup::create([
            'match_name'  => $request->match_name,
            'formation'   => $request->formation,
            'starting_xi' => $request->starting_xi,
            'substitutes' => $request->substitutes ?? [],
        ]);
        return back()->with('success', 'Lineup saved.');
    }

    public function destroyLineup(Lineup $lineup)
    {
        $lineup->delete();
        return back()->with('success', 'Lineup removed.');
    }

    // ── Health ────────────────────────────────────────────────
    public function health()
    {
        return view('coach.health', [
            'records' => HealthRecord::with('player')->latest()->get(),
            'players' => Player::orderBy('name')->get(),
        ]);
    }

    public function storeHealth(Request $request)
    {
        $request->validate([
            'player_id'        => 'required|exists:players,id',
            'note'             => 'required|string',
            'status'           => 'required|in:fit,injured,observation,recovering',
            'since'            => 'nullable|date',
            'estimated_return' => 'nullable|date',
        ]);
        HealthRecord::create($request->only('player_id', 'note', 'status', 'since', 'estimated_return'));
        return back()->with('success', 'Health record added.');
    }

    public function updateHealth(Request $request, HealthRecord $health)
    {
        $request->validate([
            'note'             => 'required|string',
            'status'           => 'required|in:fit,injured,observation,recovering',
            'since'            => 'nullable|date',
            'estimated_return' => 'nullable|date',
        ]);
        $health->update($request->only('note', 'status', 'since', 'estimated_return'));
        return back()->with('success', 'Record updated.');
    }

    public function destroyHealth(HealthRecord $health)
    {
        $health->delete();
        return back()->with('success', 'Record removed.');
    }
}
