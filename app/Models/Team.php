<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'badge_color', 'coach', 'wins', 'losses', 'draws'];
}
