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
        Schema::create('episodes', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('poster_path')->nullable();
            $table->string('name')->nullable();
            $table->string('overview')->nullable();
            $table->integer('runtime')->nullable();
            $table->integer('episode_number');
            $table->integer('season_number');
            $table->timestamps();

            $table->unsignedInteger('season_id');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
