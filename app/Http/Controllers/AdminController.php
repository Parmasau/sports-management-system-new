<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;
use App\Models\Team;
use App\Models\MatchModel;
use App\Models\TrainingSession;
use App\Models\Tactic;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{public function dashboard()
{
    $totalUsers = User::count();
    $totalAdmins = User::where('role', 'admin')->count();
    $totalCoaches = User::where('role', 'coach')->count();
    $totalPlayers = User::where('role', 'player')->count();
    $recentUsers = User::latest()->take(5)->get();
    $recentPlayers = Player::latest()->take(5)->get();
    $totalTeams = Team::count();
    $totalTrainings = TrainingSession::count();
    $activeTactics = Tactic::where('is_active', true)->count();
    $totalGoals = Player::sum('goals');
    $recentLogins = User::where('updated_at', '>=', now()->subDays(7))->count();
    
    // Get upcoming matches
    $upcomingMatches = MatchModel::where('match_date', '>=', now())
        ->where('status', 'scheduled')
        ->orderBy('match_date', 'asc')
        ->take(5)
        ->get();
    
    return view('admin.dashboard', compact(
        'totalUsers', 'totalAdmins', 'totalCoaches', 'totalPlayers',
        'recentUsers', 'recentPlayers', 'totalTeams', 'totalTrainings',
        'activeTactics', 'totalGoals', 'recentLogins', 'upcomingMatches'
    ));
}
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function teams()
    {
        $teams = Team::all();
        return view('admin.teams', compact('teams'));
    }

    public function storeTeam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'stadium' => 'required|string|max:255',
        ]);

        Team::create($request->all());
        return redirect()->route('admin.teams')->with('success', 'Team added successfully!');
    }

    public function destroyTeam($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('admin.teams')->with('success', 'Team deleted successfully!');
    }

    public function matches()
    {
        $matches = MatchModel::with('team')->orderBy('match_date', 'desc')->get();
        return view('admin.matches', compact('matches'));
    }

    public function storeMatch(Request $request)
    {
        $request->validate([
            'opponent' => 'required|string|max:255',
            'match_date' => 'required|date',
            'match_time' => 'required',
            'location' => 'required|string',
            'type' => 'required|in:home,away',
            'team_id' => 'required|exists:teams,id',
        ]);

        MatchModel::create($request->all());
        return redirect()->route('admin.matches')->with('success', 'Match scheduled successfully!');
    }

    public function destroyMatch($id)
    {
        $match = MatchModel::findOrFail($id);
        $match->delete();
        return redirect()->route('admin.matches')->with('success', 'Match deleted successfully!');
    }

    public function reports()
    {
        $totalUsers = User::count();
        $totalPlayers = Player::count();
        $totalGoals = Player::sum('goals');
        $totalTrainings = TrainingSession::count();
        $totalTeams = Team::count();
        $totalMatches = MatchModel::count();
        
        return view('admin.reports', compact('totalUsers', 'totalPlayers', 'totalGoals', 'totalTrainings', 'totalTeams', 'totalMatches'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
// ==================== PLAYER MANAGEMENT (Full CRUD for Admin) ====================
public function players()
{
    $players = Player::with('team')->orderBy('created_at', 'desc')->get();
    return view('admin.players', compact('players'));
}

public function createPlayer()
{
    $teams = Team::all();
    return view('admin.create-player', compact('teams'));
}

public function storePlayer(Request $request)
{
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

    $user = \App\Models\User::where('email', $request->email)->first();
    
    Player::create([
        'name' => $request->name,
        'email' => $request->email,
        'user_id' => $user ? $user->id : null,
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

    return redirect()->route('admin.players')->with('success', 'Player added successfully!');
}

public function editPlayer($id)
{
    $player = Player::findOrFail($id);
    $teams = Team::all();
    return view('admin.edit-player', compact('player', 'teams'));
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

    return redirect()->route('admin.players')->with('success', 'Player updated successfully!');
}

public function destroyPlayer($id)
{
    $player = Player::findOrFail($id);
    if ($player->image) {
        Storage::disk('public')->delete($player->image);
    }
    $player->delete();
    return redirect()->route('admin.players')->with('success', 'Player deleted successfully!');
}

// Player Health for Admin
public function playerHealth($id)
{
    $player = Player::findOrFail($id);
    $healthRecords = $player->healthRecords()->paginate(10);
    $latestHealth = $player->latestHealthRecord;
    return view('admin.player-health', compact('player', 'healthRecords', 'latestHealth'));
}
}