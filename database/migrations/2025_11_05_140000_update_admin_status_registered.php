<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Set all admin users to status 'registered'
        DB::table('users')->where('role', 'admin')->update(['status' => 'registered']);
    }

    public function down(): void
    {
        // Optionally revert admin users to 'pending' (not recommended, but for rollback completeness)
        DB::table('users')->where('role', 'admin')->update(['status' => 'pending']);
    }
};
