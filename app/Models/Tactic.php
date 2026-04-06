<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tactic extends Model
{
    protected $fillable = ['formation', 'pressing_style', 'attacking_focus', 'set_pieces', 'is_active'];
}
