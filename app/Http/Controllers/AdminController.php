<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\GameMatch;
use App\Models\Player;
use App\Models\HealthRecord;
use App\Models\Lineup;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function adminOnly()
    {
        if (Auth::user()->role !== 'admin') abort(403);
    }

    // ── Dashboard ─────────────────────────────────────────────
    public function dashboard()
    {
        $this->adminOnly();
        return view('dashboards.admin', [
            'totalUsers'   => User::count(),
            'totalAdmins'  => User::where('role', 'admin')->count(),
            'totalCoaches' => User::where('role', 'coach')->count(),
            'totalPlayers' => User::where('role', 'player')->count(),
            'recentUsers'  => User::latest()->take(5)->get(),
            'totalTeams'   => Team::count(),
            'totalMatches' => GameMatch::count(),
            'upcomingMatches' => GameMatch::where('status', 'scheduled')->orderBy('match_date')->take(3)->get(),
        ]);
    }

    // ── Users ─────────────────────────────────────────────────
    public function users()
    {
        $this->adminOnly();
        return view('admin.users', ['users' => User::latest()->get()]);
    }

    public function storeUser(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,coach,player',
            'password' => 'required|min:8',
        ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success', 'User created.');
    }

    public function updateUser(Request $request, User $user)
    {
        $this->adminOnly();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,coach,player',
        ]);
        $user->update($request->only('name', 'email', 'role'));
        return back()->with('success', 'User updated.');
    }

    public function destroyUser(User $user)
    {
        $this->adminOnly();
        if ($user->id === Auth::id()) return back()->with('error', 'Cannot delete yourself.');
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // ── Teams ─────────────────────────────────────────────────
    public function teams()
    {
        $this->adminOnly();
        return view('admin.teams', ['teams' => Team::latest()->get()]);
    }

    public function storeTeam(Request $request)
    {
        $this->adminOnly();
        $request->validate(['name' => 'required|string|max:100', 'coach' => 'nullable|string']);
        Team::create($request->only('name', 'badge_color', 'coach', 'wins', 'losses', 'draws'));
        return back()->with('success', 'Team created.');
    }

    public function updateTeam(Request $request, Team $team)
    {
        $this->adminOnly();
        $request->validate(['name' => 'required|string|max:100']);
        $team->update($request->only('name', 'badge_color', 'coach', 'wins', 'losses', 'draws'));
        return back()->with('success', 'Team updated.');
    }

    public function destroyTeam(Team $team)
    {
        $this->adminOnly();
        $team->delete();
        return back()->with('success', 'Team deleted.');
    }

    // ── Matches ───────────────────────────────────────────────
    public function matches()
    {
        $this->adminOnly();
        return view('admin.matches', [
            'matches' => GameMatch::orderByDesc('match_date')->get(),
            'teams'   => Team::orderBy('name')->get(),
        ]);
    }

    public function storeMatch(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            'home_team'  => 'required|string',
            'away_team'  => 'required|string',
            'match_date' => 'required|date',
            'venue'      => 'nullable|string',
        ]);
        GameMatch::create($request->only('home_team', 'away_team', 'match_date', 'venue', 'status'));
        return back()->with('success', 'Match scheduled.');
    }

    public function updateMatch(Request $request, GameMatch $match)
    {
        $this->adminOnly();
        $request->validate([
            'home_team'  => 'required|string',
            'away_team'  => 'required|string',
            'match_date' => 'required|date',
        ]);
        $match->update($request->only('home_team', 'away_team', 'match_date', 'venue', 'home_score', 'away_score', 'status'));
        return back()->with('success', 'Match updated.');
    }

    public function destroyMatch(GameMatch $match)
    {
        $this->adminOnly();
        $match->delete();
        return back()->with('success', 'Match deleted.');
    }

    // ── Health Records ────────────────────────────────────────
    public function health()
    {
        $this->adminOnly();
        return view('admin.health', [
            'records' => HealthRecord::with('player')->latest()->get(),
            'players' => Player::orderBy('name')->get(),
        ]);
    }

    public function storeHealth(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'note'      => 'required|string',
            'status'    => 'required|in:fit,injured,observation,recovering',
        ]);
        HealthRecord::create($request->only('player_id', 'note', 'status', 'since', 'estimated_return'));
        return back()->with('success', 'Health record added.');
    }

    public function updateHealth(Request $request, HealthRecord $health)
    {
        $this->adminOnly();
        $request->validate(['note' => 'required|string', 'status' => 'required|in:fit,injured,observation,recovering']);
        $health->update($request->only('note', 'status', 'since', 'estimated_return'));
        return back()->with('success', 'Record updated.');
    }

    public function destroyHealth(HealthRecord $health)
    {
        $this->adminOnly();
        $health->delete();
        return back()->with('success', 'Record deleted.');
    }

    // ── Lineups ───────────────────────────────────────────────
    public function lineups()
    {
        $this->adminOnly();
        return view('admin.lineups', [
            'lineups' => Lineup::latest()->get(),
            'players' => Player::orderBy('position')->get(),
        ]);
    }

    public function storeLineup(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            'match_name'  => 'required|string',
            'formation'   => 'required|string',
            'starting_xi' => 'required|array|size:11',
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
        $this->adminOnly();
        $lineup->delete();
        return back()->with('success', 'Lineup deleted.');
    }

    // ── Reports ───────────────────────────────────────────────
    public function reports()
    {
        $this->adminOnly();
        return view('admin.reports', [
            'totalUsers'    => User::count(),
            'totalPlayers'  => Player::count(),
            'totalTeams'    => Team::count(),
            'totalMatches'  => GameMatch::count(),
            'injuredCount'  => HealthRecord::where('status', 'injured')->count(),
            'topScorers'    => Player::orderByDesc('goals')->take(5)->get(),
            'recentMatches' => GameMatch::orderByDesc('match_date')->take(5)->get(),
        ]);
    }

    // ── Settings ──────────────────────────────────────────────
    public function settings()
    {
        $this->adminOnly();
        return view('admin.settings');
    }
}
