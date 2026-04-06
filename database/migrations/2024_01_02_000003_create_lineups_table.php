<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lineups', function (Blueprint $table) {
            $table->id();
            $table->string('match_name');
            $table->string('formation');
            $table->json('starting_xi');
            $table->json('substitutes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lineups');
    }
};
