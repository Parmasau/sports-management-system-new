<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $table = 'health_records';

    protected $fillable = [
        'player_id',
        'record_date',
        'weight',
        'height',
        'bmi',
        'heart_rate',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'injury_status',
        'injury_details',
        'fitness_level',
        'fitness_level_score',
        'medical_notes',
        'created_by'
    ];

    protected $casts = [
        'record_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}