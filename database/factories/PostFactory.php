<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $titleEn = fake()->unique()->sentence(4);
        $titleFr = fake()->unique()->sentence(4);

        return [
            'category_id' => Category::factory(),
            'author_id' => User::factory(),
            'title_fr' => rtrim($titleFr, '.'),
            'title_en' => rtrim($titleEn, '.'),
            'content_fr' => fake()->paragraphs(3, true),
            'content_en' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(PostStatus::cases())->value,
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-6 months', '+1 month'),
            'seo_title' => fake()->optional()->sentence(5),
            'meta_description' => fake()->optional()->text(140),
        ];
    }
}
