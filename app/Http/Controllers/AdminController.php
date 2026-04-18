<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;
use App\Models\Team;
use App\Models\MatchModel;
use App\Models\TrainingSession;
use App\Models\Tactic;
use App\Models\HealthRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
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

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'User role updated successfully!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    // ==================== TEAMS MANAGEMENT ====================
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

    public function editTeam($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.edit-team', compact('team'));
    }

    public function updateTeam(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'stadium' => 'required|string|max:255',
        ]);

        $team->update($request->all());
        return redirect()->route('admin.teams')->with('success', 'Team updated successfully!');
    }

    public function destroyTeam($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route('admin.teams')->with('success', 'Team deleted successfully!');
    }

    // ==================== MATCHES MANAGEMENT ====================
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

    public function editMatch($id)
    {
        $match = MatchModel::findOrFail($id);
        $teams = Team::all();
        return view('admin.edit-match', compact('match', 'teams'));
    }

    public function updateMatch(Request $request, $id)
    {
        $match = MatchModel::findOrFail($id);
        
        $request->validate([
            'opponent' => 'required|string|max:255',
            'match_date' => 'required|date',
            'match_time' => 'required',
            'location' => 'required|string',
            'type' => 'required|in:home,away',
            'team_score' => 'integer|min:0',
            'opponent_score' => 'integer|min:0',
            'result' => 'required|in:win,loss,draw,pending',
            'status' => 'required|in:scheduled,completed,cancelled',
            'team_id' => 'required|exists:teams,id'
        ]);

        $match->update($request->all());
        return redirect()->route('admin.matches')->with('success', 'Match updated successfully!');
    }

    public function destroyMatch($id)
    {
        $match = MatchModel::findOrFail($id);
        $match->delete();
        return redirect()->route('admin.matches')->with('success', 'Match deleted successfully!');
    }

    // ==================== PLAYER MANAGEMENT ====================
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

        $user = User::where('email', $request->email)->first();
        
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

    // ==================== HEALTH MANAGEMENT ====================
    public function playerHealth($id)
    {
        $player = Player::findOrFail($id);
        $healthRecords = HealthRecord::where('player_id', $player->id)
            ->orderBy('record_date', 'desc')
            ->paginate(10);
        $latestHealth = HealthRecord::where('player_id', $player->id)
            ->orderBy('record_date', 'desc')
            ->first();
        return view('admin.player-health', compact('player', 'healthRecords', 'latestHealth'));
    }

    public function editPlayerHealth($playerId, $healthId)
    {
        $player = Player::findOrFail($playerId);
        $healthRecord = HealthRecord::findOrFail($healthId);
        return view('admin.edit-health', compact('player', 'healthRecord'));
    }

    public function updatePlayerHealth(Request $request, $playerId, $healthId)
    {
        $healthRecord = HealthRecord::findOrFail($healthId);
        
        $request->validate([
            'record_date' => 'required|date',
            'weight' => 'nullable|numeric|min:20|max:200',
            'height' => 'nullable|numeric|min:100|max:250',
            'heart_rate' => 'nullable|integer|min:30|max:200',
            'blood_pressure_systolic' => 'nullable|integer|min:70|max:250',
            'blood_pressure_diastolic' => 'nullable|integer|min:40|max:150',
            'injury_status' => 'required|in:none,minor,moderate,severe,recovering',
            'injury_details' => 'nullable|string',
            'fitness_level' => 'required|in:poor,average,good,excellent',
            'medical_notes' => 'nullable|string'
        ]);

        $bmi = null;
        if ($request->weight && $request->height) {
            $heightInMeters = $request->height / 100;
            $bmi = round($request->weight / ($heightInMeters * $heightInMeters), 2);
        }

        $healthRecord->update([
            'record_date' => $request->record_date,
            'weight' => $request->weight,
            'height' => $request->height,
            'bmi' => $bmi,
            'heart_rate' => $request->heart_rate,
            'blood_pressure_systolic' => $request->blood_pressure_systolic,
            'blood_pressure_diastolic' => $request->blood_pressure_diastolic,
            'injury_status' => $request->injury_status,
            'injury_details' => $request->injury_details,
            'fitness_level' => $request->fitness_level,
            'medical_notes' => $request->medical_notes,
        ]);

        return redirect()->route('admin.players.health', $playerId)->with('success', 'Health record updated successfully!');
    }

    public function deletePlayerHealth($playerId, $healthId)
    {
        $healthRecord = HealthRecord::findOrFail($healthId);
        $healthRecord->delete();
        return redirect()->route('admin.players.health', $playerId)->with('success', 'Health record deleted successfully!');
    }

    // ==================== REPORTS & SETTINGS ====================
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