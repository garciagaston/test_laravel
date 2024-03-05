<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

final class EntitiesService
{
    const IMPORTED_CATEGORIES = ['Animals', 'Security'];

    public static function importEntities(Command $command)
    {
        $response = Http::get(config('entities.importUrl'))->throw();
        $entries = $response->json()['entries'];
        foreach ($entries as $entry) {
            if (in_array($entry['Category'], self::IMPORTED_CATEGORIES)) {
                Entity::create([
                    'api' => $entry['API'],
                    'description' => $entry['Description'],
                    'link' => $entry['Link'],
                    'category_id' => Category::firstOrCreate(['category' => $entry['Category']])->id,
                ]);
                $command->line('Imported '.$entry['API'].' from '.$entry['Category'].' category');
            }
        }
    }
}
