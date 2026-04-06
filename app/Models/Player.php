<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'position', 'jersey_number', 'matches', 'goals', 'assists', 'rating'];

    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    public function latestHealth()
    {
        return $this->hasOne(HealthRecord::class)->latestOfMany();
    }
}
