<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('players')) {
            Schema::create('players', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('image')->nullable();
                $table->string('position')->default('Not Assigned');
                $table->integer('jersey_number')->default(0);
                $table->integer('goals')->default(0);
                $table->integer('assists')->default(0);
                $table->integer('matches')->default(0);
                $table->decimal('rating', 3, 1)->default(0);
                $table->enum('status', ['active', 'injured', 'suspended'])->default('active');
                $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
                $table->timestamps();
            });
            echo "Players table created successfully!\n";
        } else {
            echo "Players table already exists.\n";
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};

