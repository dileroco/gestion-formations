<?php

namespace Database\Factories;

use App\Enums\InscriptionStatus;
use App\Models\Inscription;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Inscription>
 */
class InscriptionFactory extends Factory
{
    protected $model = Inscription::class;

    public function definition(): array
    {
        $status = fake()->randomElement(InscriptionStatus::cases())->value;

        return [
            'user_id' => User::factory(),
            'session_id' => TrainingSession::factory(),
            'reference' => Str::upper(Str::random(10)),
            'status' => $status,
            'note' => fake()->optional()->sentence(),
            'confirmed_at' => $status === InscriptionStatus::Confirmed->value
                ? fake()->dateTimeBetween('-2 months', 'now')
                : null,
            'cancelled_at' => $status === InscriptionStatus::Cancelled->value
                ? fake()->dateTimeBetween('-2 months', 'now')
                : null,
        ];
    }
}
