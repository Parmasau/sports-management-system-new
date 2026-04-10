<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Player;
use App\Models\Tactic;
use App\Models\Team;
use App\Models\MatchModel;
use App\Models\PlayerMatchStat;
use App\Models\Achievement;

class PlayerController extends Controller
{
    public function dashboard()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        if (!$player) {
            $player = Player::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'position' => 'Not Assigned',
                'jersey_number' => 0,
                'goals' => 0,
                'assists' => 0,
                'matches' => 0,
                'rating' => 0,
                'status' => 'active',
                'image' => null
            ]);
        }
        
        $isProfileComplete = $player->position !== 'Not Assigned' && $player->jersey_number > 0;
        $activeTactic = Tactic::where('is_active', true)->first();
        
        $teammates = collect();
        $team = null;
        if ($player->team_id) {
            $team = Team::find($player->team_id);
            $teammates = Player::where('team_id', $player->team_id)
                ->where('id', '!=', $player->id)
                ->where('status', 'active')
                ->get();
        }
        
        $stats = [
            'matches' => $player->matches ?? 0,
            'goals' => $player->goals ?? 0,
            'assists' => $player->assists ?? 0,
            'rating' => $player->rating ?? 0,
            'position' => $player->position ?? 'Not Assigned',
            'jersey' => $player->jersey_number ?? 'N/A'
        ];
        
        $recentActivities = [];
        
        if (!$isProfileComplete) {
            $recentActivities[] = [
                'type' => 'info',
                'message' => 'Your profile is being set up by the coach. Check back soon!',
                'icon' => 'user-clock'
            ];
        } else {
            if ($player->matches > 0) {
                $recentActivities[] = [
                    'type' => 'success',
                    'message' => "You've played {$player->matches} matches this season!",
                    'icon' => 'futbol'
                ];
            }
            if ($player->goals > 0) {
                $recentActivities[] = [
                    'type' => 'success',
                    'message' => "Congratulations on scoring {$player->goals} goals!",
                    'icon' => 'goal-net'
                ];
            }
        }
        
        return view('player.dashboard', compact('player', 'activeTactic', 'teammates', 'team', 'stats', 'isProfileComplete', 'recentActivities'));
    }

    public function matches()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        if (!$player) {
            $player = Player::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'position' => 'Not Assigned',
                'jersey_number' => 0,
                'goals' => 0,
                'assists' => 0,
                'matches' => 0,
                'rating' => 0,
                'status' => 'active',
                'image' => null
            ]);
        }
        
        $upcomingMatches = collect();
        $pastMatches = collect();
        
        if ($player->team_id) {
            $upcomingMatches = MatchModel::where('team_id', $player->team_id)
                ->where('match_date', '>=', now())
                ->where('status', 'scheduled')
                ->orderBy('match_date', 'asc')
                ->get();
                
            $pastMatches = MatchModel::where('team_id', $player->team_id)
                ->where('match_date', '<', now())
                ->orWhere('status', 'completed')
                ->orderBy('match_date', 'desc')
                ->take(5)
                ->get();
        }
        
        foreach($pastMatches as $match) {
            $playerStat = PlayerMatchStat::where('player_id', $player->id)
                ->where('match_id', $match->id)
                ->first();
            $match->player_goals = $playerStat ? $playerStat->goals : 0;
            $match->player_assists = $playerStat ? $playerStat->assists : 0;
            $match->player_rating = $playerStat ? $playerStat->rating : 0;
        }
        
        return view('player.matches', compact('player', 'upcomingMatches', 'pastMatches'));
    }

    public function statistics()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        if (!$player) {
            $player = Player::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'position' => 'Not Assigned',
                'jersey_number' => 0,
                'goals' => 0,
                'assists' => 0,
                'matches' => 0,
                'rating' => 0,
                'status' => 'active',
                'image' => null
            ]);
        }
        
        return view('player.statistics', compact('player'));
    }

    public function team()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        $teammates = collect();
        $team = null;
        $teamStats = null;
        
        if ($player && $player->team_id) {
            $team = Team::find($player->team_id);
            $teammates = Player::where('team_id', $player->team_id)
                ->where('id', '!=', $player->id)
                ->where('status', 'active')
                ->orderBy('jersey_number', 'asc')
                ->get();
            
            $totalGoals = Player::where('team_id', $player->team_id)->sum('goals');
            $totalMatches = MatchModel::where('team_id', $player->team_id)->count();
            $wins = MatchModel::where('team_id', $player->team_id)->where('result', 'win')->count();
            $losses = MatchModel::where('team_id', $player->team_id)->where('result', 'loss')->count();
            $draws = MatchModel::where('team_id', $player->team_id)->where('result', 'draw')->count();
            
            $teamStats = [
                'total_goals' => $totalGoals,
                'total_matches' => $totalMatches,
                'wins' => $wins,
                'losses' => $losses,
                'draws' => $draws,
                'win_rate' => $totalMatches > 0 ? round(($wins / $totalMatches) * 100) : 0
            ];
        }
        
        return view('player.team', compact('player', 'teammates', 'team', 'teamStats'));
    }

    public function achievements()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        if (!$player) {
            $player = Player::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'position' => 'Not Assigned',
                'jersey_number' => 0,
                'goals' => 0,
                'assists' => 0,
                'matches' => 0,
                'rating' => 0,
                'status' => 'active',
                'image' => null
            ]);
        }
        
        $earnedAchievements = $player->achievements()->orderBy('earned_date', 'desc')->get();
        $allAchievements = Achievement::all();
        $earnedIds = $earnedAchievements->pluck('id')->toArray();
        $availableAchievements = Achievement::whereNotIn('id', $earnedIds)->get();
        
        $progress = [
            'goal_milestones' => $this->calculateGoalMilestones($player->goals),
            'match_milestones' => $this->calculateMatchMilestones($player->matches),
            'rating_milestones' => $this->calculateRatingMilestones($player->rating),
        ];
        
        return view('player.achievements', compact('player', 'earnedAchievements', 'availableAchievements', 'progress'));
    }

    public function profile()
    {
        $player = Player::where('user_id', Auth::id())->first();
        
        if (!$player) {
            $player = new Player();
            $player->name = Auth::user()->name;
            $player->email = Auth::user()->email;
            $player->position = 'Not Assigned';
            $player->jersey_number = 0;
            $player->status = 'active';
        }
        
        return view('player.profile', compact('player'));
    }

    private function calculateGoalMilestones($goals)
    {
        $milestones = [5, 10, 25, 50, 100];
        $nextMilestone = null;
        foreach($milestones as $milestone) {
            if ($goals < $milestone) {
                $nextMilestone = $milestone;
                break;
            }
        }
        
        return [
            'current' => $goals,
            'next' => $nextMilestone,
            'progress' => $nextMilestone ? min(100, round(($goals / $nextMilestone) * 100)) : 100
        ];
    }

    private function calculateMatchMilestones($matches)
    {
        $milestones = [10, 25, 50, 100, 200];
        $nextMilestone = null;
        foreach($milestones as $milestone) {
            if ($matches < $milestone) {
                $nextMilestone = $milestone;
                break;
            }
        }
        
        return [
            'current' => $matches,
            'next' => $nextMilestone,
            'progress' => $nextMilestone ? min(100, round(($matches / $nextMilestone) * 100)) : 100
        ];
    }

    private function calculateRatingMilestones($rating)
    {
        return [
            'current' => $rating,
            'next' => 8.5,
            'progress' => min(100, round(($rating / 8.5) * 100))
        ];
    }
}