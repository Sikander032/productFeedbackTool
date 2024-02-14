<?php

namespace Database\Factories;

use App\Models\FeedbackCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackCategory>
 */
class FeedbackCategoryFactory extends Factory
{
    protected $model = FeedbackCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true), // A random name for the category
        ];
    }
}
