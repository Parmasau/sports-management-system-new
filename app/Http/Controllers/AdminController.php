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
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalAdmins', 'totalCoaches', 'totalPlayers',
            'recentUsers', 'recentPlayers', 'totalTeams', 'totalTrainings',
            'activeTactics', 'totalGoals', 'recentLogins'
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