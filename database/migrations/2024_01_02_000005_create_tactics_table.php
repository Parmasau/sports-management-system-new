<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tactics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('formation');
            $table->text('strategy');
            $table->text('set_pieces')->nullable();
            $table->text('player_roles')->nullable();
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tactics');
    }
};