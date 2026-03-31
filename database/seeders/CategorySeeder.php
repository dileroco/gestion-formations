<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $preset = [
            ['name_fr' => 'Marketing Digital', 'name_en' => 'Digital Marketing'],
            ['name_fr' => 'Développement Web', 'name_en' => 'Web Development'],
            ['name_fr' => 'Data & IA', 'name_en' => 'Data & AI'],
            ['name_fr' => 'Design & UX', 'name_en' => 'Design & UX'],
            ['name_fr' => 'Management', 'name_en' => 'Management'],
        ];

        foreach ($preset as $data) {
            Category::firstOrCreate($data);
        }

        Category::factory(5)->create();
    }
}
