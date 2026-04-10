<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerAchievement extends Model
{
    use HasFactory;

    protected $table = 'player_achievements';

    protected $fillable = [
        'player_id',
        'achievement_id',
        'earned_date'
    ];

    protected $casts = [
        'earned_date' => 'date'
    ];
}
