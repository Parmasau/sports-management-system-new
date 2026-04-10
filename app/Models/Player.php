<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';
    
    protected $fillable = [
        'name',
        'email',
        'image',
        'position',
        'jersey_number',
        'goals',
        'assists',
        'matches',
        'rating',
        'status',
        'team_id',
        'user_id'
    ];

    protected $casts = [
        'goals' => 'integer',
        'assists' => 'integer',
        'matches' => 'integer',
        'rating' => 'decimal:1',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function matchStats()
    {
        return $this->hasMany(PlayerMatchStat::class);
    }

    public function matches()
    {
        return $this->belongsToMany(MatchModel::class, 'player_match_stats')
                    ->withPivot('goals', 'assists', 'minutes_played', 'rating', 'man_of_match')
                    ->withTimestamps();
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'player_achievements')
                    ->withPivot('earned_date')
                    ->withTimestamps();
    }
    
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=667eea&color=fff&rounded=true&size=100';
    }
    
    public function isProfileComplete()
    {
        return $this->position && $this->position != 'Not Assigned' && $this->jersey_number > 0;
    }
}