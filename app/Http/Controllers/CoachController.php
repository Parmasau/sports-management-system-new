<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Team;
use App\Models\TrainingSession;
use App\Models\Tactic;
use App\Models\Achievement;
use App\Models\MatchModel;
use App\Models\PlayerMatchStat;
use App\Models\HealthRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class CoachController extends Controller
{
    // ==================== DASHBOARD ====================
    public function dashboard()
    {
        $totalPlayers = Player::count();
        $activePlayers = Player::where('status', 'active')->count();
        $totalGoals = Player::sum('goals');
        $topScorer = Player::orderBy('goals', 'desc')->first();
        $recentPlayers = Player::latest()->take(5)->get();
        
        $upcomingTrainings = TrainingSession::where('status', 'scheduled')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        $activeTactics = Tactic::where('is_active', true)->count();
        $formations = Tactic::where('is_active', true)->get();
        
        $totalMatches = Player::sum('matches');
        $winRate = $totalMatches > 0 ? round(($totalGoals / ($totalMatches * 3)) * 100) : 0;
        
        $recentActivities = collect();
        
        foreach($recentPlayers->take(3) as $player) {
            $recentActivities->push((object)[
                'type' => 'player',
                'message' => "New player {$player->name} added",
                'time' => $player->created_at ? $player->created_at->diffForHumans() : 'Recently',
                'icon' => 'user-plus'
            ]);
        }
        
        foreach($upcomingTrainings->take(2) as $training) {
            $recentActivities->push((object)[
                'type' => 'training',
                'message' => "Training session scheduled for {$training->day}",
                'time' => $training->created_at ? $training->created_at->diffForHumans() : 'Recently',
                'icon' => 'calendar-alt'
            ]);
        }
        
        return view('coach.dashboard', compact(
            'totalPlayers', 'activePlayers', 'totalGoals', 'topScorer', 
            'recentPlayers', 'upcomingTrainings', 'activeTactics', 
            'formations', 'winRate', 'recentActivities'
        ));
    }

    // ==================== PLAYER MANAGEMENT ====================
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

        return redirect()->route('coach.players')->with('success', 'Player added successfully!');
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

    // ==================== TRAINING MANAGEMENT ====================
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

    // ==================== TACTICS MANAGEMENT ====================
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
            'set_pieces' => $request->set_pieces ?: '',
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
            'set_pieces' => $request->set_pieces ?: '',
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

    // ==================== HEALTH MANAGEMENT ====================
    public function healthOverview()
    {
        $players = Player::with('latestHealthRecord')->get();
        $injuredPlayers = Player::whereHas('latestHealthRecord', function($query) {
            $query->where('injury_status', '!=', 'none');
        })->count();
        $totalPlayers = Player::count();
        $avgFitness = HealthRecord::avg('fitness_level_score') ?? 0;
        
        return view('coach.health-overview', compact('players', 'injuredPlayers', 'totalPlayers', 'avgFitness'));
    }

    public function playerHealth($id)
    {
        $player = Player::findOrFail($id);
        $healthRecords = HealthRecord::where('player_id', $player->id)
            ->orderBy('record_date', 'desc')
            ->paginate(10);
        $latestHealth = HealthRecord::where('player_id', $player->id)
            ->orderBy('record_date', 'desc')
            ->first();
        return view('coach.player-health', compact('player', 'healthRecords', 'latestHealth'));
    }

    public function storeHealth(Request $request, $id)
    {
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

        $fitnessScore = ['poor' => 1, 'average' => 2, 'good' => 3, 'excellent' => 4][$request->fitness_level] ?? 2;

        HealthRecord::create([
            'player_id' => $id,
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
            'fitness_level_score' => $fitnessScore,
            'medical_notes' => $request->medical_notes,
            'created_by' => Auth::user()->name
        ]);

        return redirect()->route('coach.players.health', $id)->with('success', 'Health record added successfully!');
    }

    public function editHealth($playerId, $healthId)
    {
        $player = Player::findOrFail($playerId);
        $healthRecord = HealthRecord::findOrFail($healthId);
        return view('coach.edit-health', compact('player', 'healthRecord'));
    }

    public function updateHealth(Request $request, $playerId, $healthId)
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

        $fitnessScore = ['poor' => 1, 'average' => 2, 'good' => 3, 'excellent' => 4][$request->fitness_level] ?? 2;

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
            'fitness_level_score' => $fitnessScore,
            'medical_notes' => $request->medical_notes,
        ]);

        return redirect()->route('coach.players.health', $playerId)->with('success', 'Health record updated successfully!');
    }

    public function destroyHealth($playerId, $healthId)
    {
        $healthRecord = HealthRecord::findOrFail($healthId);
        $healthRecord->delete();
        return redirect()->route('coach.players.health', $playerId)->with('success', 'Health record deleted successfully!');
    }

    // ==================== ACHIEVEMENT MANAGEMENT ====================
    public function achievements()
    {
        $achievements = Achievement::orderBy('points', 'desc')->get();
        return view('coach.achievements', compact('achievements'));
    }

    public function createAchievement()
    {
        return view('coach.create-achievement');
    }

    public function storeAchievement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'type' => 'required|in:individual,team,season',
            'points' => 'required|integer|min:0',
            'badge_color' => 'required|string'
        ]);

        Achievement::create($request->all());

        return redirect()->route('coach.achievements')->with('success', 'Achievement created successfully!');
    }

    public function editAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);
        return view('coach.edit-achievement', compact('achievement'));
    }

    public function updateAchievement(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:50',
            'type' => 'required|in:individual,team,season',
            'points' => 'required|integer|min:0',
            'badge_color' => 'required|string'
        ]);

        $achievement->update($request->all());

        return redirect()->route('coach.achievements')->with('success', 'Achievement updated successfully!');
    }

    public function destroyAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        return redirect()->route('coach.achievements')->with('success', 'Achievement deleted successfully!');
    }

    public function playerAchievements($id)
    {
        $player = Player::findOrFail($id);
        $achievements = Achievement::all();
        $playerAchievements = $player->achievements()->withPivot('earned_date', 'notes')->get();
        
        return view('coach.player-achievements', compact('player', 'achievements', 'playerAchievements'));
    }

    public function assignAchievement(Request $request, $id)
    {
        $request->validate([
            'achievement_id' => 'required|exists:achievements,id',
            'earned_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $player = Player::findOrFail($id);
        
        // Check if player already has this achievement
        if ($player->achievements()->where('achievement_id', $request->achievement_id)->exists()) {
            return redirect()->back()->with('error', 'Player already has this achievement!');
        }

        $player->achievements()->attach($request->achievement_id, [
            'earned_date' => $request->earned_date,
            'notes' => $request->notes
        ]);

        // Update player points if needed
        $achievement = Achievement::find($request->achievement_id);
        
        return redirect()->route('coach.players.achievements', $id)->with('success', 'Achievement assigned successfully!');
    }

    public function removeAchievement($playerId, $achievementId)
    {
        $player = Player::findOrFail($playerId);
        $player->achievements()->detach($achievementId);
        
        return redirect()->route('coach.players.achievements', $playerId)->with('success', 'Achievement removed successfully!');
    }

    public function updatePlayerAchievement(Request $request, $playerId, $achievementId)
    {
        $request->validate([
            'earned_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $player = Player::findOrFail($playerId);
        
        // Update the pivot table directly
        $player->achievements()->updateExistingPivot($achievementId, [
            'earned_date' => $request->earned_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('coach.players.achievements', $playerId)->with('success', 'Achievement updated successfully!');
    }
// ==================== MATCH MANAGEMENT ====================
public function matches()
{
    $matches = MatchModel::with('team')->orderBy('match_date', 'desc')->get();
    return view('coach.matches', compact('matches'));
}

public function createMatch()
{
    $teams = Team::all();
    return view('coach.create-match', compact('teams'));
}

public function storeMatch(Request $request)
{
    $request->validate([
        'opponent' => 'required|string|max:255',
        'match_date' => 'required|date',
        'match_time' => 'required',
        'location' => 'required|string',
        'type' => 'required|in:home,away',
        'team_id' => 'required|exists:teams,id'
    ]);

    MatchModel::create($request->all());

    return redirect()->route('coach.matches')->with('success', 'Match scheduled successfully!');
}

public function editMatch($id)
{
    $match = MatchModel::findOrFail($id);
    $teams = Team::all();
    return view('coach.edit-match', compact('match', 'teams'));
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

    $match->update([
        'opponent' => $request->opponent,
        'match_date' => $request->match_date,
        'match_time' => $request->match_time,
        'location' => $request->location,
        'type' => $request->type,
        'team_score' => $request->team_score,
        'opponent_score' => $request->opponent_score,
        'result' => $request->result,
        'status' => $request->status,
        'team_id' => $request->team_id
    ]);

    return redirect()->route('coach.matches')->with('success', 'Match updated successfully!');
}

public function destroyMatch($id)
{
    $match = MatchModel::findOrFail($id);
    $match->delete();
    return redirect()->route('coach.matches')->with('success', 'Match deleted successfully!');
}

public function matchStats($id)
{
    $match = MatchModel::findOrFail($id);
    $players = Player::where('status', 'active')->get();
    $matchStats = \App\Models\PlayerMatchStat::where('match_id', $id)->get()->keyBy('player_id');
    
    return view('coach.match-stats', compact('match', 'players', 'matchStats'));
}

public function storeMatchStats(Request $request, $id)
{
    foreach ($request->stats as $playerId => $stats) {
        \App\Models\PlayerMatchStat::updateOrCreate(
            ['player_id' => $playerId, 'match_id' => $id],
            [
                'goals' => $stats['goals'] ?? 0,
                'assists' => $stats['assists'] ?? 0,
                'minutes_played' => $stats['minutes_played'] ?? 0,
                'rating' => $stats['rating'] ?? 0,
                'man_of_match' => isset($stats['man_of_match']) && $stats['man_of_match'] == 'on'
            ]
        );
        
        // Update player's total stats
        $player = Player::find($playerId);
        if ($player) {
            $player->goals += $stats['goals'] ?? 0;
            $player->assists += $stats['assists'] ?? 0;
            $player->matches += 1;
            $player->rating = ($player->rating + ($stats['rating'] ?? 0)) / 2;
            $player->save();
        }
    }
    
    // Update match score and result
    $match = MatchModel::find($id);
    $match->status = 'completed';
    $match->save();
    
    return redirect()->route('coach.matches')->with('success', 'Match statistics updated successfully!');
}

public function updateMatchStats(Request $request, $matchId, $playerId)
{
    $stat = \App\Models\PlayerMatchStat::where('match_id', $matchId)
        ->where('player_id', $playerId)
        ->first();
    
    if ($stat) {
        $stat->update($request->only(['goals', 'assists', 'minutes_played', 'rating', 'man_of_match']));
    }
    
    return response()->json(['success' => true]);
}
}
