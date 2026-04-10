<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('opponent');
            $table->date('match_date');
            $table->time('match_time');
            $table->string('location');
            $table->enum('type', ['home', 'away']);
            $table->integer('team_score')->default(0);
            $table->integer('opponent_score')->default(0);
            $table->enum('result', ['win', 'loss', 'draw', 'pending'])->default('pending');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};