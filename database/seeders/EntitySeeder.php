<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        $count = (int) $this->command->ask('How many entities do you want to create?', 50);
        Entity::factory($count)->create()->each(function ($entity) {
            $message = "Entity #{$entity->id} created.";
            Log::info($message);
            $this->command->info($message);
        });
    }
}
