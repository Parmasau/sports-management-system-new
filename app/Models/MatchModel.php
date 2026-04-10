<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;

    protected $table = 'matches';
    
    protected $fillable = [
        'opponent',
        'match_date',
        'match_time',
        'location',
        'type',
        'team_score',
        'opponent_score',
        'result',
        'team_id',
        'notes',
        'status'
    ];

    protected $casts = [
        'match_date' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function playerStats()
    {
        return $this->hasMany(PlayerMatchStat::class);
    }
}