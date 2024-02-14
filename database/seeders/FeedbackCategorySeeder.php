<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('feedback_categories')->insert([
            ['name' => 'Bug Report'],
            ['name' => 'Feature Request'],
            ['name' => 'Improvement'],
        ]);
    }
}
