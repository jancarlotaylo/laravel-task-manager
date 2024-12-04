<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'content' => $this->faker->optional()->paragraph(),
            // Always set to To-Do to avoid future inconsistencies or unexpected behaviors
            'status' => TaskStatus::TO_DO->value,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
