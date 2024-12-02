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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('poster_path')->nullable();
            $table->string('name')->nullable();
            $table->string('overview')->nullable();
            $table->date('air_date')->nullable();
            $table->boolean('top')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('genre_id')->nullable();

            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
        });

        Schema::dropIfExists('series');
    }
};
