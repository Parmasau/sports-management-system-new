<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerMatchStat extends Model
{
    use HasFactory;

    protected $table = 'player_match_stats';

    protected $fillable = [
        'player_id',
        'match_id',
        'goals',
        'assists',
        'minutes_played',
        'rating',
        'man_of_match'
    ];

    protected $casts = [
        'man_of_match' => 'boolean'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function match()
    {
        return $this->belongsTo(MatchModel::class);
    }
}