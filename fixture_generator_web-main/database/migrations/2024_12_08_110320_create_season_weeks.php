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
        Schema::create('season_weeks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('season_id')->nullable()->constrained('seasons')->onDelete('cascade');
            $table->integer('week')->nullable();
            $table->date('week_date')->nullable();
            $table->enum('period', [1,2])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_weeks');
    }
};
