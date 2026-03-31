<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'Formateur');
        })->get();

        if ($trainers->isEmpty()) {
            $trainers = User::factory(3)->create();
        }

        $formations = Formation::query()->take(5)->get();

        if ($formations->isEmpty()) {
            $formations = Formation::factory(3)->create();
        }

        foreach ($formations as $formation) {
            TrainingSession::factory(2)->create([
                'formation_id' => $formation->id,
                'trainer_id' => $trainers->random()->id,
            ]);
        }
    }
}
