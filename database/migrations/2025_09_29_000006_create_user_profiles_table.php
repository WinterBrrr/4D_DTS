<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nickname')->nullable();
            $table->string('identity')->nullable(); // Teacher | Student
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('occupation')->nullable();
            $table->string('nationality')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
