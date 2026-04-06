<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page Route
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Dashboard Route with Role-based Redirection
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isCoach()) {
        return redirect()->route('coach.dashboard');
    } else {
        return redirect()->route('player.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/teams', [AdminController::class, 'teams'])->name('teams');
    Route::post('/teams', [AdminController::class, 'storeTeam'])->name('teams.store');
    Route::put('/teams/{team}', [AdminController::class, 'updateTeam'])->name('teams.update');
    Route::delete('/teams/{team}', [AdminController::class, 'destroyTeam'])->name('teams.destroy');

    Route::get('/matches', [AdminController::class, 'matches'])->name('matches');
    Route::post('/matches', [AdminController::class, 'storeMatch'])->name('matches.store');
    Route::put('/matches/{match}', [AdminController::class, 'updateMatch'])->name('matches.update');
    Route::delete('/matches/{match}', [AdminController::class, 'destroyMatch'])->name('matches.destroy');

    Route::get('/health', [AdminController::class, 'health'])->name('health');
    Route::post('/health', [AdminController::class, 'storeHealth'])->name('health.store');
    Route::put('/health/{health}', [AdminController::class, 'updateHealth'])->name('health.update');
    Route::delete('/health/{health}', [AdminController::class, 'destroyHealth'])->name('health.destroy');

    Route::get('/lineups', [AdminController::class, 'lineups'])->name('lineups');
    Route::post('/lineups', [AdminController::class, 'storeLineup'])->name('lineups.store');
    Route::delete('/lineups/{lineup}', [AdminController::class, 'destroyLineup'])->name('lineups.destroy');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// Coach Routes
Route::middleware('auth')->prefix('coach')->name('coach.')->group(function () {
    Route::get('/dashboard', [CoachController::class, 'dashboard'])->name('dashboard');

    Route::get('/players', [CoachController::class, 'players'])->name('players');
    Route::post('/players', [CoachController::class, 'storePlayer'])->name('players.store');
    Route::put('/players/{player}', [CoachController::class, 'updatePlayer'])->name('players.update');
    Route::delete('/players/{player}', [CoachController::class, 'destroyPlayer'])->name('players.destroy');

    Route::get('/training', [CoachController::class, 'training'])->name('training');
    Route::post('/training', [CoachController::class, 'storeTraining'])->name('training.store');
    Route::put('/training/{training}', [CoachController::class, 'updateTraining'])->name('training.update');
    Route::delete('/training/{training}', [CoachController::class, 'destroyTraining'])->name('training.destroy');

    Route::get('/stats', [CoachController::class, 'stats'])->name('stats');

    Route::get('/tactics', [CoachController::class, 'tactics'])->name('tactics');
    Route::post('/tactics', [CoachController::class, 'storeTactic'])->name('tactics.store');
    Route::put('/tactics/{tactic}', [CoachController::class, 'updateTactic'])->name('tactics.update');
    Route::patch('/tactics/{tactic}/activate', [CoachController::class, 'activateTactic'])->name('tactics.activate');
    Route::delete('/tactics/{tactic}', [CoachController::class, 'destroyTactic'])->name('tactics.destroy');

    Route::get('/lineup', [CoachController::class, 'lineup'])->name('lineup');
    Route::post('/lineup', [CoachController::class, 'storeLineup'])->name('lineup.store');
    Route::delete('/lineup/{lineup}', [CoachController::class, 'destroyLineup'])->name('lineup.destroy');

    Route::get('/health', [CoachController::class, 'health'])->name('health');
    Route::post('/health', [CoachController::class, 'storeHealth'])->name('health.store');
    Route::put('/health/{health}', [CoachController::class, 'updateHealth'])->name('health.update');
    Route::delete('/health/{health}', [CoachController::class, 'destroyHealth'])->name('health.destroy');
});

// Player Routes
Route::middleware('auth')->prefix('player')->name('player.')->group(function () {
    Route::get('/dashboard', [PlayerController::class, 'dashboard'])->name('dashboard');
    Route::get('/matches', [PlayerController::class, 'matches'])->name('matches');
    Route::get('/statistics', [PlayerController::class, 'statistics'])->name('statistics');
    Route::get('/team', [PlayerController::class, 'team'])->name('team');
    Route::get('/achievements', [PlayerController::class, 'achievements'])->name('achievements');
    Route::get('/profile', [PlayerController::class, 'profile'])->name('profile');
});

// Include authentication routes (login, register, etc.)
require __DIR__.'/auth.php';
