<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'type',
        'points'
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_achievements')
                    ->withPivot('earned_date')
                    ->withTimestamps();
    }
}