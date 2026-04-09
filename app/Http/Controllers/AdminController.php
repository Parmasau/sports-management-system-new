<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;
use App\Models\Team;
use App\Models\TrainingSession;
use App\Models\Tactic;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get real data from database
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCoaches = User::where('role', 'coach')->count();
        $totalPlayers = User::where('role', 'player')->count();
        $recentUsers = User::latest()->take(5)->get();
        $recentPlayers = Player::latest()->take(5)->get();
        
        // Additional stats
        $totalTeams = Team::count();
        $totalTrainings = TrainingSession::count();
        $activeTactics = Tactic::where('is_active', true)->count();
        $totalGoals = Player::sum('goals');
        
        // System health
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

    public function teams()
    {
        $teams = Team::all();
        return view('admin.teams', compact('teams'));
    }

    public function matches()
    {
        return view('admin.matches');
    }

    public function reports()
    {
        $totalUsers = User::count();
        $totalPlayers = Player::count();
        $totalGoals = Player::sum('goals');
        $totalTrainings = TrainingSession::count();
        
        return view('admin.reports', compact('totalUsers', 'totalPlayers', 'totalGoals', 'totalTrainings'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}