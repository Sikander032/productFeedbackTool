<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\User;
use App\Models\UserComment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create 20 users
        User::factory(20)->create();

        // Create 40 feedback categories
        FeedbackCategory::factory(40)->create()->each(function ($category) {
            // For each category, create feedbacks
            Feedback::factory(5)->create(['category_id' => $category->id])
                ->each(function ($feedback) {
                    // For each feedback, assign a user and create a comment
                    $user = User::inRandomOrder()->first();
                    UserComment::factory(5)->create([
                        'feedback_id' => $feedback->id,
                        'user_id' => $user->id,
                    ]);
                });
        });
    }
}
