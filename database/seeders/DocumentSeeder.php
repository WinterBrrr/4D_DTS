<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Policy', 'Procedures(SOP)', 'Guidelines', 'Manuals', 'Report', 'Plans', 'Memo', 'Others'
        ];
        $departments = [
            'CIT', 'COE', 'COM', 'CAS', 'ICJE', 'COT', 'CE', 'ADMIN'
        ];
        $statuses = [
            'pending', 'reviewing', 'approved', 'rejected'
        ];
        foreach (range(1, 10) as $i) {
            Document::create([
                'code' => 'DOC_' . $i,
                'title' => 'Sample Document ' . $i,
                'type' => $types[array_rand($types)],
                'department' => $departments[array_rand($departments)],
                'handler' => 'User_' . $i,
                'status' => $statuses[($i - 1) % count($statuses)],
                'expected_completion_at' => now()->addDays(rand(1, 30)),
            ]);
        }
    }
}
