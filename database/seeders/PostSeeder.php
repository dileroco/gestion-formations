<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $authors = User::query()->take(5)->get();

        if ($authors->isEmpty()) {
            $authors = User::factory(3)->create();
        }

        Post::factory(10)->create([
            'author_id' => $authors->random()->id,
        ]);
    }
}
