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
        'earned_date',
        'notes'
    ];

    protected $casts = [
        'earned_date' => 'date'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}