<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';
    
    protected $fillable = [
        'name',
        'email',
        'image',
        'position',
        'jersey_number',
        'goals',
        'assists',
        'matches',
        'rating',
        'status',
        'team_id'
    ];

    protected $casts = [
        'goals' => 'integer',
        'assists' => 'integer',
        'matches' => 'integer',
        'rating' => 'decimal:1',
        'is_active' => 'boolean'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=667eea&color=fff&rounded=true&size=100';
    }
}