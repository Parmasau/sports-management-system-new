<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('position');
            $table->integer('jersey_number');
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('matches_played')->default(0);
            $table->decimal('rating', 3, 1)->default(0);
            $table->enum('status', ['active', 'injured', 'suspended'])->default('active');
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};