<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    protected $fillable = ['player_id', 'note', 'since', 'estimated_return', 'status'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
