<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $nameEn = fake()->unique()->words(2, true);
        $nameFr = fake()->unique()->words(2, true);

        return [
            'name_en' => ucfirst($nameEn),
            'name_fr' => ucfirst($nameFr),
        ];
    }
}
