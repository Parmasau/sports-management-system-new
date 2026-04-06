<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    protected $fillable = ['match_name', 'formation', 'starting_xi', 'substitutes'];
    protected $casts = ['starting_xi' => 'array', 'substitutes' => 'array'];
}
