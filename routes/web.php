<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page Route
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Dashboard Route with Role-based Redirection
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    $role = $user->role ?? 'player';
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'coach') {
        return redirect()->route('coach.dashboard');
    } else {
        return redirect()->route('player.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// Player Routes
Route::middleware(['auth'])->prefix('player')->name('player.')->group(function () {
    Route::get('/dashboard', [PlayerController::class, 'dashboard'])->name('dashboard');
    Route::get('/matches', [PlayerController::class, 'matches'])->name('matches');
    Route::get('/statistics', [PlayerController::class, 'statistics'])->name('statistics');
    Route::get('/team', [PlayerController::class, 'team'])->name('team');
    Route::get('/achievements', [PlayerController::class, 'achievements'])->name('achievements');
    Route::get('/profile', [PlayerController::class, 'profile'])->name('profile');
});

// Coach Routes
Route::middleware(['auth'])->prefix('coach')->name('coach.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [CoachController::class, 'dashboard'])->name('dashboard');
    
    // Player Management
    Route::get('/players', [CoachController::class, 'players'])->name('players');
    Route::get('/players/create', [CoachController::class, 'createPlayer'])->name('players.create');
    Route::post('/players', [CoachController::class, 'storePlayer'])->name('players.store');
    Route::get('/players/{id}/edit', [CoachController::class, 'editPlayer'])->name('players.edit');
    Route::put('/players/{id}', [CoachController::class, 'updatePlayer'])->name('players.update');
    Route::delete('/players/{id}', [CoachController::class, 'destroyPlayer'])->name('players.destroy');
    
    // Player Statistics
    Route::get('/stats', [CoachController::class, 'stats'])->name('stats');
    Route::put('/stats/{id}', [CoachController::class, 'updatePlayerStats'])->name('stats.update');
    
    // Training Management
    Route::get('/training', [CoachController::class, 'training'])->name('training');
    Route::get('/training/create', [CoachController::class, 'createTraining'])->name('training.create');
    Route::post('/training', [CoachController::class, 'storeTraining'])->name('training.store');
    Route::get('/training/{id}/edit', [CoachController::class, 'editTraining'])->name('training.edit');
    Route::put('/training/{id}', [CoachController::class, 'updateTraining'])->name('training.update');
    Route::delete('/training/{id}', [CoachController::class, 'destroyTraining'])->name('training.destroy');
    
    // Tactics Management
    Route::get('/tactics/{id}/show', [CoachController::class, 'showTactic'])->name('tactics.show');
    Route::get('/tactics', [CoachController::class, 'tactics'])->name('tactics');
    Route::get('/tactics/create', [CoachController::class, 'createTactic'])->name('tactics.create');
    Route::post('/tactics', [CoachController::class, 'storeTactic'])->name('tactics.store');
    Route::get('/tactics/{id}/edit', [CoachController::class, 'editTactic'])->name('tactics.edit');
    Route::put('/tactics/{id}', [CoachController::class, 'updateTactic'])->name('tactics.update');
    Route::delete('/tactics/{id}', [CoachController::class, 'destroyTactic'])->name('tactics.destroy');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/teams', [AdminController::class, 'teams'])->name('teams');
    Route::post('/teams', [AdminController::class, 'storeTeam'])->name('teams.store');
    Route::delete('/teams/{id}', [AdminController::class, 'destroyTeam'])->name('teams.destroy');
    Route::get('/matches', [AdminController::class, 'matches'])->name('matches');
    Route::post('/matches', [AdminController::class, 'storeMatch'])->name('matches.store');
    Route::delete('/matches/{id}', [AdminController::class, 'destroyMatch'])->name('matches.destroy');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Profile Routes (Fixed)
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// Simple profile route for all users (alternative)
Route::middleware(['auth'])->get('/my-profile', function () {
    return view('profile.simple', ['user' => Auth::user()]);
})->name('my-profile');

// API routes for live data updates
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/dashboard-stats', function () {
        return response()->json([
            'totalPlayers' => App\Models\Player::count(),
            'activePlayers' => App\Models\Player::where('status', 'active')->count(),
            'totalGoals' => App\Models\Player::sum('goals'),
            'activeTactics' => App\Models\Tactic::where('is_active', true)->count(),
            'totalTrainings' => App\Models\TrainingSession::count(),
            'recentPlayers' => App\Models\Player::latest()->take(5)->get()->map(function($player) {
                return [
                    'id' => $player->id,
                    'name' => $player->name,
                    'position' => $player->position,
                    'goals' => $player->goals,
                    'image' => $player->image ? asset('storage/' . $player->image) : null
                ];
            })
        ]);
    });
    
    Route::get('/player-stats/{id}', function ($id) {
        $player = App\Models\Player::find($id);
        if ($player) {
            return response()->json([
                'goals' => $player->goals,
                'assists' => $player->assists,
                'matches' => $player->matches,
                'rating' => $player->rating
            ]);
        }
        return response()->json(['error' => 'Player not found'], 404);
    });
});

// Include authentication routes
require __DIR__.'/auth.php';