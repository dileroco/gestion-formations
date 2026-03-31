<?php

namespace Database\Factories;

use App\Enums\SessionMode;
use App\Models\Formation;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainingSession>
 */
class TrainingSessionFactory extends Factory
{
    protected $model = TrainingSession::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('now', '+3 months');
        $end = (clone $start)->modify('+' . fake()->numberBetween(1, 10) . ' days');

        return [
            'formation_id' => Formation::factory(),
            'trainer_id' => User::factory(),
            'start_date' => $start,
            'end_date' => $end,
            'capacity' => fake()->numberBetween(10, 30),
            'mode' => fake()->randomElement(SessionMode::cases())->value,
            'city' => fake()->optional(0.7)->city(),
            'meeting_link' => fake()->optional(0.6)->url(),
            'status' => fake()->randomElement(['scheduled', 'completed', 'cancelled']),
        ];
    }
}
