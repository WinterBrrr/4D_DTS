<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Document;
use App\Models\ActivityLog;
use App\Models\User;

class QuickStatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_quick_stats_based_on_filters()
    {
        // Create test data
        $user = User::factory()->create([
            'email' => 'handler@example.com',
            'role' => 'admin', // Assign admin role
        ]);
        $this->actingAs($user);

        // Set session values for middleware
        session(['logged_in' => true, 'user_role' => 'admin']);

        Document::factory()->create([
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(2),
            'status' => 'completed',
            'department' => 'CIT',
            'user_id' => $user->id, // Added user_id
        ]);

        Document::factory()->create([
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(6),
            'status' => 'pending',
            'department' => 'CE',
            'user_id' => $user->id, // Added user_id
        ]);

        ActivityLog::factory()->create([
            'created_at' => now()->subDays(1),
            'user_id' => $user->id,
        ]);

        // Apply filters
        $response = $this->get(route('admin.reports', [
            'date_range' => '7',
            'department_filter' => 'CIT',
        ]));

        // Assert quick stats
        $response->assertStatus(200);
        $response->assertSee('Total Documents');
        $response->assertSee('Avg Process Time');
        $response->assertSee('This Month');
        $response->assertSee('Active Users');

        // Assert filtered data
        $response->assertSee('1', false); // Total Documents
        $response->assertSee('0 days', false); // Avg Process Time
        $response->assertSee('0%', false); // This Month
        $response->assertSee('1', false); // Active Users
    }
}