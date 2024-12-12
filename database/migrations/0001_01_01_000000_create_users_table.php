<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('profile_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->timestamps();
        });

        DB::table('profile_images')->insert([
            ['url' => 'https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg'],
            ['url' => 'https://i.pinimg.com/originals/38/1d/6e/381d6edab2cb8693e04e9e5923c20ec6.webp'],
            ['url' => 'https://img.freepik.com/premium-photo/realistic-cartoon-girl-with-red-hair-glasses-3d-model_899449-43894.jpg'],
            ['url' => 'https://img.freepik.com/fotos-premium/avatar-personaje-3d_113255-5365.jpg'],
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('profile_image_id')->default(1)->constrained('profile_images')->nullOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profile_image_id']);
            $table->dropColumn('profile_image_id');
        });

        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
