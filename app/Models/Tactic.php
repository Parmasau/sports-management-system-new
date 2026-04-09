<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tactic extends Model
{
    use HasFactory;

    protected $table = 'tactics';
    
    protected $fillable = [
        'formation',
        'pressing_style',
        'attacking_focus',
        'set_pieces',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    protected $attributes = [
        'set_pieces' => '',
    ];
    
    // Get only active tactic
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    // Get formation map for player positioning
    public function getPositionMap()
    {
        $maps = [
            '4-3-3' => [
                'GK' => 'Goalkeeper',
                'LB' => 'Left Back',
                'CB' => 'Center Back',
                'CB2' => 'Center Back',
                'RB' => 'Right Back',
                'CDM' => 'CDM',
                'CM' => 'Center Mid',
                'CM2' => 'Center Mid',
                'LW' => 'Left Wing',
                'ST' => 'Striker',
                'RW' => 'Right Wing'
            ],
            '4-4-2' => [
                'GK' => 'Goalkeeper',
                'LB' => 'Left Back',
                'CB' => 'Center Back',
                'CB2' => 'Center Back',
                'RB' => 'Right Back',
                'LM' => 'Left Mid',
                'CM' => 'Center Mid',
                'CM2' => 'Center Mid',
                'RM' => 'Right Mid',
                'ST' => 'Striker',
                'ST2' => 'Striker'
            ],
            '3-5-2' => [
                'GK' => 'Goalkeeper',
                'CB' => 'Center Back',
                'CB2' => 'Center Back',
                'CB3' => 'Center Back',
                'CDM' => 'CDM',
                'LM' => 'Left Mid',
                'CM' => 'Center Mid',
                'CM2' => 'Center Mid',
                'RM' => 'Right Mid',
                'ST' => 'Striker',
                'ST2' => 'Striker'
            ]
        ];
        
        return $maps[$this->formation] ?? $maps['4-3-3'];
    }
}