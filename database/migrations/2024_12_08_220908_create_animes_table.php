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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('trailer_link')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('name')->nullable();
            $table->string('overview')->nullable();
            $table->boolean('top')->default(false);
            $table->timestamps();
            $table->integer('number_of_episodes')->nullable();
            $table->unsignedBigInteger('genre_id')->nullable();

            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
