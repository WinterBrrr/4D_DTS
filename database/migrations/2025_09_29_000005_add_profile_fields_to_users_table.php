<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable()->after('name');
            $table->string('identity')->nullable()->after('nickname'); // Teacher, Student
            $table->unsignedTinyInteger('age')->nullable()->after('email_verified_at');
            $table->string('occupation')->nullable()->after('age');
            $table->string('nationality')->nullable()->after('occupation');
            $table->string('contact_number')->nullable()->after('nationality');
            $table->string('address')->nullable()->after('contact_number');
            $table->string('gender', 20)->nullable()->after('address');
            $table->string('profile_photo_path')->nullable()->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nickname','identity','age','occupation','nationality','contact_number','address','gender','profile_photo_path'
            ]);
        });
    }
};
