<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
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
    Route::get('/health', [PlayerController::class, 'health'])->name('health');
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
    Route::get('/tactics', [CoachController::class, 'tactics'])->name('tactics');
    Route::get('/tactics/create', [CoachController::class, 'createTactic'])->name('tactics.create');
    Route::post('/tactics', [CoachController::class, 'storeTactic'])->name('tactics.store');
    Route::get('/tactics/{id}/edit', [CoachController::class, 'editTactic'])->name('tactics.edit');
    Route::put('/tactics/{id}', [CoachController::class, 'updateTactic'])->name('tactics.update');
    Route::delete('/tactics/{id}', [CoachController::class, 'destroyTactic'])->name('tactics.destroy');
    Route::get('/tactics/{id}/show', [CoachController::class, 'showTactic'])->name('tactics.show');
    
    // Health Management
    Route::get('/health', [CoachController::class, 'healthOverview'])->name('health.overview');
    Route::get('/players/{id}/health', [CoachController::class, 'playerHealth'])->name('players.health');
    Route::post('/players/{id}/health', [CoachController::class, 'storeHealth'])->name('players.health.store');
    Route::get('/players/{playerId}/health/{healthId}/edit', [CoachController::class, 'editHealth'])->name('players.health.edit');
    Route::put('/players/{playerId}/health/{healthId}', [CoachController::class, 'updateHealth'])->name('players.health.update');
    Route::delete('/players/{playerId}/health/{healthId}', [CoachController::class, 'destroyHealth'])->name('players.health.destroy');
    
    // Achievement Management
    Route::get('/achievements', [CoachController::class, 'achievements'])->name('achievements');
    Route::get('/achievements/create', [CoachController::class, 'createAchievement'])->name('achievements.create');
    Route::post('/achievements', [CoachController::class, 'storeAchievement'])->name('achievements.store');
    Route::get('/achievements/{id}/edit', [CoachController::class, 'editAchievement'])->name('achievements.edit');
    Route::put('/achievements/{id}', [CoachController::class, 'updateAchievement'])->name('achievements.update');
    Route::delete('/achievements/{id}', [CoachController::class, 'destroyAchievement'])->name('achievements.destroy');
    
    // Match Management
    Route::get('/matches', [CoachController::class, 'matches'])->name('matches');
    Route::get('/matches/create', [CoachController::class, 'createMatch'])->name('matches.create');
    Route::post('/matches', [CoachController::class, 'storeMatch'])->name('matches.store');
    Route::get('/matches/{id}/edit', [CoachController::class, 'editMatch'])->name('matches.edit');
    Route::put('/matches/{id}', [CoachController::class, 'updateMatch'])->name('matches.update');
    Route::delete('/matches/{id}', [CoachController::class, 'destroyMatch'])->name('matches.destroy');

    // Player Match Stats
    Route::get('/matches/{id}/stats', [CoachController::class, 'matchStats'])->name('matches.stats');
    Route::post('/matches/{id}/stats', [CoachController::class, 'storeMatchStats'])->name('matches.stats.store');
    Route::put('/matches/{matchId}/stats/{playerId}', [CoachController::class, 'updateMatchStats'])->name('matches.stats.update');
    
    // Assign Achievements to Players
    Route::get('/players/{id}/achievements', [CoachController::class, 'playerAchievements'])->name('players.achievements');
    Route::post('/players/{id}/achievements', [CoachController::class, 'assignAchievement'])->name('players.achievements.assign');
    Route::put('/players/{playerId}/achievements/{achievementId}/update', [CoachController::class, 'updatePlayerAchievement'])->name('players.achievements.update');
    Route::delete('/players/{playerId}/achievements/{achievementId}', [CoachController::class, 'removeAchievement'])->name('players.achievements.remove');
});

// Chat Routes
Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/conversation/{userId}', [ChatController::class, 'conversation'])->name('conversation');
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('send');
    Route::get('/unread-count', [ChatController::class, 'getUnreadCount'])->name('unread-count');
    Route::post('/mark-read/{messageId}', [ChatController::class, 'markAsRead'])->name('mark-read');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{id}/role', [AdminController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Teams Management
    Route::get('/teams', [AdminController::class, 'teams'])->name('teams');
    Route::post('/teams', [AdminController::class, 'storeTeam'])->name('teams.store');
    Route::get('/teams/{id}/edit', [AdminController::class, 'editTeam'])->name('teams.edit');
    Route::put('/teams/{id}', [AdminController::class, 'updateTeam'])->name('teams.update');
    Route::delete('/teams/{id}', [AdminController::class, 'destroyTeam'])->name('teams.destroy');
    
    // Matches Management
    Route::get('/matches', [AdminController::class, 'matches'])->name('matches');
    Route::post('/matches', [AdminController::class, 'storeMatch'])->name('matches.store');
    Route::get('/matches/{id}/edit', [AdminController::class, 'editMatch'])->name('matches.edit');
    Route::put('/matches/{id}', [AdminController::class, 'updateMatch'])->name('matches.update');
    Route::delete('/matches/{id}', [AdminController::class, 'destroyMatch'])->name('matches.destroy');
    
    // Player Management
    Route::get('/players', [AdminController::class, 'players'])->name('players');
    Route::get('/players/create', [AdminController::class, 'createPlayer'])->name('players.create');
    Route::post('/players', [AdminController::class, 'storePlayer'])->name('players.store');
    Route::get('/players/{id}/edit', [AdminController::class, 'editPlayer'])->name('players.edit');
    Route::put('/players/{id}', [AdminController::class, 'updatePlayer'])->name('players.update');
    Route::delete('/players/{id}', [AdminController::class, 'destroyPlayer'])->name('players.destroy');
    
    // Player Health Management
    Route::get('/players/{id}/health', [AdminController::class, 'playerHealth'])->name('players.health');
    Route::get('/players/{playerId}/health/{healthId}/edit', [AdminController::class, 'editPlayerHealth'])->name('players.health.edit');
    Route::put('/players/{playerId}/health/{healthId}', [AdminController::class, 'updatePlayerHealth'])->name('players.health.update');
    Route::delete('/players/{playerId}/health/{healthId}', [AdminController::class, 'deletePlayerHealth'])->name('players.health.delete');
    
    // Reports and Settings
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Simple profile route for all users
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