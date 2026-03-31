<?php

namespace Database\Factories;

use App\Enums\FormationStatus;
use App\Models\Category;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Formation>
 */
class FormationFactory extends Factory
{
    protected $model = Formation::class;

    public function definition(): array
    {
        $titleEn = fake()->unique()->sentence(3);
        $titleFr = fake()->unique()->sentence(3);

        return [
            'category_id' => Category::factory(),
            'title_fr' => rtrim($titleFr, '.'),
            'title_en' => rtrim($titleEn, '.'),
            'short_description_fr' => fake()->text(120),
            'short_description_en' => fake()->text(120),
            'description_fr' => fake()->paragraphs(4, true),
            'description_en' => fake()->paragraphs(4, true),
            'image' => null,
            'price' => fake()->randomFloat(2, 500, 4500),
            'duration' => fake()->numberBetween(1, 60),
            'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'status' => fake()->randomElement(FormationStatus::cases())->value,
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-6 months', '+1 month'),
            'seo_title_fr' => fake()->optional()->sentence(4),
            'seo_title_en' => fake()->optional()->sentence(4),
            'meta_description_fr' => fake()->optional()->text(140),
            'meta_description_en' => fake()->optional()->text(140),
        ];
    }
}
