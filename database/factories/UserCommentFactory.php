<?php

namespace Database\Factories;

use App\Models\UserComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserComment>
 */
class UserCommentFactory extends Factory
{
    protected $model = UserComment::class;

    public function definition()
    {
        return [
            'comment' => $this->faker->sentence(),
            // 'user_id' and 'feedback_id' will be assigned when creating records
        ];
    }
}
