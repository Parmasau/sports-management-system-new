<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Player;
use App\Models\Tactic;
use App\Models\Team;

class PlayerController extends Controller
{
    public function dashboard()
    {
        // Get current player from database
        $player = Player::where('email', Auth::user()->email)->first();
        
        if (!$player) {
            // Create player record if doesn't exist
            $player = Player::create([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'position' => 'Player',
                'jersey_number' => 0,
                'goals' => 0,
                'assists' => 0,
                'matches' => 0,
                'rating' => 0,
                'status' => 'active'
            ]);
        }
        
        // Get active tactic from database
        $activeTactic = Tactic::where('is_active', true)->first();
        
        // Get teammates from same team
        $teammates = collect();
        if ($player->team_id) {
            $teammates = Player::where('team_id', $player->team_id)
                ->where('id', '!=', $player->id)
                ->get();
        }
        
        // Get team information
        $team = null;
        if ($player->team_id) {
            $team = Team::find($player->team_id);
        }
        
        // Get player statistics
        $stats = [
            'matches' => $player->matches ?? 0,
            'goals' => $player->goals ?? 0,
            'assists' => $player->assists ?? 0,
            'rating' => $player->rating ?? 0,
            'position' => $player->position ?? 'Not Assigned',
            'jersey' => $player->jersey_number ?? 'N/A'
        ];
        
        return view('player.dashboard', compact('player', 'activeTactic', 'teammates', 'team', 'stats'));
    }

    public function matches()
    {
        $player = Player::where('email', Auth::user()->email)->first();
        return view('player.matches', compact('player'));
    }

    public function statistics()
    {
        $player = Player::where('email', Auth::user()->email)->first();
        return view('player.statistics', compact('player'));
    }

    public function team()
    {
        $player = Player::where('email', Auth::user()->email)->first();
        $teammates = collect();
        $team = null;
        
        if ($player && $player->team_id) {
            $team = Team::find($player->team_id);
            $teammates = Player::where('team_id', $player->team_id)
                ->where('id', '!=', $player->id)
                ->get();
        }
        
        return view('player.team', compact('player', 'teammates', 'team'));
    }

    public function achievements()
    {
        $player = Player::where('email', Auth::user()->email)->first();
        return view('player.achievements', compact('player'));
    }

    public function profile()
    {
        $player = Player::where('email', Auth::user()->email)->first();
        if (!$player) {
            $player = new Player();
            $player->name = Auth::user()->name;
            $player->email = Auth::user()->email;
        }
        return view('player.profile', compact('player'));
    }
}