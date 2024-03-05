<?php

namespace App\Console\Commands;

use App\Http\Services\EntitiesService;
use Illuminate\Console\Command;

class EntitiesImport extends Command
{
    // php artisan entities:import
    protected $signature = 'entities:import';

    protected $description = 'Run this command to import entities';

    public function handle()
    {
        try {
            EntitiesService::importEntities($this);
            $this->info('Entries fetched and saved successfully.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
