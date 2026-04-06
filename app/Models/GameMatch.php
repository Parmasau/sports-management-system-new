<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    protected $table = 'matches';
    protected $fillable = ['home_team', 'away_team', 'match_date', 'venue', 'home_score', 'away_score', 'status'];
}
