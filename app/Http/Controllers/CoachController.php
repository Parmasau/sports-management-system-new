<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Team;
use App\Models\TrainingSession;
use App\Models\Tactic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class CoachController extends Controller
{
    // ==================== DASHBOARD ====================
    public function dashboard()
{
    // Get real data from database
    $totalPlayers = Player::count();
    $activePlayers = Player::where('status', 'active')->count();
    $totalGoals = Player::sum('goals');
    $topScorer = Player::orderBy('goals', 'desc')->first();
    $recentPlayers = Player::latest()->take(5)->get();
    
    // Get training sessions from database
    $upcomingTrainings = TrainingSession::where('status', 'scheduled')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
    
    // Get tactics from database
    $activeTactics = Tactic::where('is_active', true)->count();
    $formations = Tactic::where('is_active', true)->get();
    
    // Calculate team performance
    $totalMatches = Player::sum('matches');
    $winRate = $totalMatches > 0 ? round(($totalGoals / ($totalMatches * 3)) * 100) : 0;
    
    // Get recent activities
    $recentActivities = collect();
    
    // Add recent players to activities
    foreach($recentPlayers->take(3) as $player) {
        $recentActivities->push((object)[
            'type' => 'player',
            'message' => "New player {$player->name} added",
            'time' => $player->created_at->diffForHumans(),
            'icon' => 'user-plus'
        ]);
    }
    
    // Add recent trainings to activities
    foreach($upcomingTrainings->take(2) as $training) {
        $recentActivities->push((object)[
            'type' => 'training',
            'message' => "Training session scheduled for {$training->day}",
            'time' => $training->created_at->diffForHumans(),
            'icon' => 'calendar-alt'
        ]);
    }
    
    return view('coach.dashboard', compact(
        'totalPlayers', 'activePlayers', 'totalGoals', 'topScorer', 
        'recentPlayers', 'upcomingTrainings', 'activeTactics', 
        'formations', 'winRate', 'recentActivities'
    ));
}
    // ==================== PLAYER MANAGEMENT (CRUD) ====================
    public function players()
    {
        $players = Player::orderBy('created_at', 'desc')->get();
        return view('coach.players', compact('players'));
    }

    public function createPlayer()
    {
        $teams = Team::all();
        return view('coach.create-player', compact('teams'));
    }

   public function storePlayer(Request $request)
{
    // Log the incoming request for debugging
    \Log::info('Store player request:', $request->all());
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:players',
        'position' => 'required|string',
        'jersey_number' => 'required|integer|unique:players',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'team_id' => 'nullable|exists:teams,id'
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('players', 'public');
    }

    try {
        $player = Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imagePath,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'team_id' => $request->team_id,
            'status' => 'active',
            'goals' => 0,
            'assists' => 0,
            'matches' => 0,
            'rating' => 0
        ]);
        
        \Log::info('Player created successfully:', ['id' => $player->id]);
        
        return redirect()->route('coach.players')->with('success', 'Player added successfully!');
        
    } catch (\Exception $e) {
        \Log::error('Error creating player: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to add player: ' . $e->getMessage());
    }
}
    public function editPlayer($id)
    {
        $player = Player::findOrFail($id);
        $teams = Team::all();
        return view('coach.edit-player', compact('player', 'teams'));
    }

    public function updatePlayer(Request $request, $id)
    {
        $player = Player::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:players,email,'.$id,
            'position' => 'required|string',
            'jersey_number' => 'required|integer|unique:players,jersey_number,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'goals' => 'integer|min:0',
            'assists' => 'integer|min:0',
            'matches' => 'integer|min:0',
            'rating' => 'numeric|min:0|max:10',
            'status' => 'required|in:active,injured,suspended',
            'team_id' => 'nullable|exists:teams,id'
        ]);

        if ($request->hasFile('image')) {
            if ($player->image) {
                Storage::disk('public')->delete($player->image);
            }
            $imagePath = $request->file('image')->store('players', 'public');
            $player->image = $imagePath;
        }

        $player->update($request->except('image'));

        return redirect()->route('coach.players')->with('success', 'Player updated successfully!');
    }

    public function destroyPlayer($id)
    {
        $player = Player::findOrFail($id);
        if ($player->image) {
            Storage::disk('public')->delete($player->image);
        }
        $player->delete();
        return redirect()->route('coach.players')->with('success', 'Player deleted successfully!');
    }

    // ==================== PLAYER STATISTICS ====================
    public function stats()
    {
        $players = Player::orderBy('goals', 'desc')->get();
        $topScorer = Player::orderBy('goals', 'desc')->first();
        $topAssist = Player::orderBy('assists', 'desc')->first();
        $bestRating = Player::orderBy('rating', 'desc')->first();
        $mostMatches = Player::orderBy('matches', 'desc')->first();
        
        return view('coach.stats', compact('players', 'topScorer', 'topAssist', 'bestRating', 'mostMatches'));
    }

    public function updatePlayerStats(Request $request, $id)
    {
        $player = Player::findOrFail($id);
        
        $request->validate([
            'goals' => 'integer|min:0',
            'assists' => 'integer|min:0',
            'matches' => 'integer|min:0',
            'rating' => 'numeric|min:0|max:10'
        ]);
        
        $player->update($request->only(['goals', 'assists', 'matches', 'rating']));
        
        return redirect()->route('coach.stats')->with('success', 'Player statistics updated!');
    }

    // ==================== TRAINING MANAGEMENT (CRUD) ====================
    public function training()
    {
        $trainings = TrainingSession::orderBy('created_at', 'desc')->get();
        return view('coach.training', compact('trainings'));
    }

    public function createTraining()
    {
        return view('coach.create-training');
    }

    public function storeTraining(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'time' => 'required|string',
            'type' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled'
        ]);

        TrainingSession::create($request->all());

        return redirect()->route('coach.training')->with('success', 'Training session created successfully!');
    }

    public function editTraining($id)
    {
        $training = TrainingSession::findOrFail($id);
        return view('coach.edit-training', compact('training'));
    }

    public function updateTraining(Request $request, $id)
    {
        $training = TrainingSession::findOrFail($id);
        
        $request->validate([
            'day' => 'required|string',
            'time' => 'required|string',
            'type' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled'
        ]);

        $training->update($request->all());

        return redirect()->route('coach.training')->with('success', 'Training session updated successfully!');
    }

    public function destroyTraining($id)
    {
        $training = TrainingSession::findOrFail($id);
        $training->delete();
        return redirect()->route('coach.training')->with('success', 'Training session deleted successfully!');
    }

    // ==================== TACTICS MANAGEMENT (CRUD) ====================
    public function showTactic($id)
{
    $tactic = Tactic::findOrFail($id);
    return view('coach.show-tactic', compact('tactic'));
}
    public function tactics()
    {
        $tactics = Tactic::orderBy('created_at', 'desc')->get();
        return view('coach.tactics', compact('tactics'));
    }

    public function createTactic()
    {
        return view('coach.create-tactic');
    }

    public function storeTactic(Request $request)
    {
        $request->validate([
            'formation' => 'required|string',
            'pressing_style' => 'required|string',
            'attacking_focus' => 'required|string',
            'set_pieces' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Tactic::create([
            'formation' => $request->formation,
            'pressing_style' => $request->pressing_style,
            'attacking_focus' => $request->attacking_focus,
            'set_pieces' => $request->set_pieces ?: '', // If null, use empty string
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('coach.tactics')->with('success', 'Tactic created successfully!');
    }

    public function editTactic($id)
    {
        $tactic = Tactic::findOrFail($id);
        return view('coach.edit-tactic', compact('tactic'));
    }

    public function updateTactic(Request $request, $id)
    {
        $tactic = Tactic::findOrFail($id);
        
        $request->validate([
            'formation' => 'required|string',
            'pressing_style' => 'required|string',
            'attacking_focus' => 'required|string',
            'set_pieces' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $tactic->update([
            'formation' => $request->formation,
            'pressing_style' => $request->pressing_style,
            'attacking_focus' => $request->attacking_focus,
            'set_pieces' => $request->set_pieces ?: '', // If null, use empty string
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('coach.tactics')->with('success', 'Tactic updated successfully!');
    }

    public function destroyTactic($id)
    {
        $tactic = Tactic::findOrFail($id);
        $tactic->delete();
        return redirect()->route('coach.tactics')->with('success', 'Tactic deleted successfully!');
    }
}