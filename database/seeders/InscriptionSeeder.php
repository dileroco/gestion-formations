<?php

namespace Database\Seeders;

use App\Models\Inscription;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class InscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $participants = User::query()->take(10)->get();

        if ($participants->isEmpty()) {
            $participants = User::factory(10)->create();
        }

        $sessions = TrainingSession::query()->take(10)->get();

        if ($sessions->isEmpty()) {
            $sessions = TrainingSession::factory(5)->create();
        }

        foreach ($sessions as $session) {
            $sessionParticipants = $participants->random(min(3, $participants->count()));

            foreach ($sessionParticipants as $participant) {
                Inscription::firstOrCreate(
                    [
                        'user_id' => $participant->id,
                        'session_id' => $session->id,
                    ],
                    [
                        'reference' => strtoupper(fake()->bothify('INS-####??')),
                        'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
                        'note' => fake()->optional()->sentence(),
                    ]
                );
            }
        }
    }
}
