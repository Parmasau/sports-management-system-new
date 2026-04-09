<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $table = 'training_sessions';
    
    protected $fillable = [
        'day',
        'time',
        'type',
        'location',
        'status'
    ];
    
    protected $casts = [
        'status' => 'string'
    ];
    
    // Scope for upcoming trainings
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')->orderBy('created_at', 'desc');
    }
    
    // Scope for completed trainings
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}