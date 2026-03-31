<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Formation;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::query()->first();

        if (! $category) {
            $category = Category::factory()->create();
        }

        $preset = [
            [
                'title_fr' => 'Marketing Digital Avancé',
                'title_en' => 'Advanced Digital Marketing',
                'short_description_fr' => 'Maîtriser les leviers clés du marketing digital.',
                'short_description_en' => 'Master the key levers of digital marketing.',
                'description_fr' => 'Programme complet couvrant SEO, Ads, contenu et analytics.',
                'description_en' => 'Complete program covering SEO, Ads, content, and analytics.',
                'level' => 'intermediate',
                'price' => 2200,
            ],
            [
                'title_fr' => 'Laravel Professionnel',
                'title_en' => 'Professional Laravel',
                'short_description_fr' => 'Construire des applications robustes avec Laravel.',
                'short_description_en' => 'Build robust applications with Laravel.',
                'description_fr' => 'De l’architecture aux déploiements.',
                'description_en' => 'From architecture to deployment.',
                'level' => 'advanced',
                'price' => 3200,
            ],
        ];

        foreach ($preset as $data) {
            Formation::firstOrCreate(
                ['title_fr' => $data['title_fr']],
                array_merge($data, [
                    'category_id' => $category->id,
                    'title_en' => $data['title_en'],
                    'short_description_fr' => $data['short_description_fr'],
                    'short_description_en' => $data['short_description_en'],
                    'description_fr' => $data['description_fr'],
                    'description_en' => $data['description_en'],
                    'duration' => 20,
                    'status' => 'published',
                    'published_at' => now()->subDays(7),
                    'seo_title_fr' => $data['title_fr'],
                    'seo_title_en' => $data['title_en'],
                ])
            );
        }

        Formation::factory(8)->create([
            'category_id' => $category->id,
        ]);
    }
}
