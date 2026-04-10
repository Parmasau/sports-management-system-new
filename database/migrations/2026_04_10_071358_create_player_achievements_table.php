<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained('achievements')->onDelete('cascade');
            $table->date('earned_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_achievements');
    }
};