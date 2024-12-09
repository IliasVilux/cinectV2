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
        Schema::create('films', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('poster_path')->nullable();
            $table->string('name')->nullable();
            $table->string('overview')->nullable();
            $table->boolean('top')->default(false);
            $table->date('release_date')->nullable();
            $table->timestamps();
            $table->string('genre_id')->nullable();

            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('films', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
        });

        Schema::dropIfExists('films');
    }
};
