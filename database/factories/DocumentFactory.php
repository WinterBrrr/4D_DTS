<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        $types = ['Policy','Guide','Report'];
        $departments = ['HR','IT','Finance'];
        $statuses = ['Pending','In Review','Completed'];
        return [
            'code' => 'DOC'.fake()->numberBetween(100,999),
            'title' => fake()->sentence(3),
            'type' => fake()->randomElement($types),
            'handler' => fake()->name(),
            'department' => fake()->randomElement($departments),
            'status' => fake()->randomElement($statuses),
            'expected_completion_at' => fake()->dateTimeBetween('+1 week','+3 months')->format('Y-m-d'),
        ];
    }
}
