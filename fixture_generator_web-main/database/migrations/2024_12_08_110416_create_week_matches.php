<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('week_matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('season_id')->nullable()->constrained('seasons')->onDelete('cascade');
            $table->foreignId('week_id')->nullable()->constrained('season_weeks')->onDelete('cascade');
            $table->foreignId('home_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->integer('home_score')->nullable()->default(-1);
            $table->integer('away_score')->nullable()->default(-1);
            $table->enum('status', ['pending', 'completed'])->nullable();
            $table->dateTime('match_datetime')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_matches');
    }
};
