<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(), // This will create a new User for each Feedback
            'category_id' => FeedbackCategory::inRandomOrder()->first()->id ?? FeedbackCategory::factory(), // This will use an existing category or create a new one if none exists
        ];
    }
}
