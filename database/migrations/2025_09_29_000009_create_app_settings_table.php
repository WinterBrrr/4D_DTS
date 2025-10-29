<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('app_settings')->insert([
            ['key' => 'two_factor_required', 'value' => 'true', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'sms_notifications', 'value' => 'false', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'daily_summary_reports', 'value' => 'true', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
