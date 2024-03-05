<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $count = (int) $this->command->ask('How many categories do you want to create?', 10);
        Category::factory($count)->create()->each(function ($category) {
            $message = "Category #{$category->id} created.";
            Log::info($message);
            $this->command->info($message);
        });
    }
}
