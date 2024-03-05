<?php

namespace Tests\Unit\COMMANDS;

use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class ImportEntitiesCommantTest extends TestCase
{
    const IMPORTED_CATEGORIES = ['Animals', 'Security'];

    private $count = 10;

    private $entities = [];

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('entities.importUrl', $this->faker->url());
        foreach (range(1, $this->count) as $i) {
            $this->entities[] = [
                'API' => preg_replace('/\.$/', '', $this->faker->sentence(2)),
                'Description' => $this->faker->text(250),
                'Auth' => "apiKey{$i}",
                'HTTPS' => $this->faker->boolean(),
                'Cors' => $this->faker->boolean() ? 'yes' : 'no',
                'Link' => $this->faker->url(),
                'Category' => $this->faker->randomElement(['Animals', 'Security', 'Anime', 'Anti-Malware']),
            ];
        }
    }

    public function testImportEntitiesSuccess(): void
    {
        Http::fake([
            config('entities.importUrl').'*' => Http::response([
                'count' => $this->count,
                'entries' => $this->entities,
            ], Response::HTTP_OK),
            '*' => Http::response(['result' => []], Response::HTTP_CONFLICT),
        ]);
        $this->assertEquals(Entity::count(), 0, 'no entities');
        $this->artisan('entities:import')
            ->expectsOutput('Entries fetched and saved successfully.')
            ->assertSuccessful();
        $importedEntities = array_filter($this->entities, function ($entity) {
            return in_array($entity['Category'], self::IMPORTED_CATEGORIES);
        });
        $this->assertNotEquals(Entity::count(), 0, 'Entity not empty');
        $this->assertEquals(Entity::count(), count($importedEntities), 'imported entities');
    }

    public function testImportEntitiesFailed(): void
    {
        Http::fake([
            config('entities.importUrl').'*' => Http::response([], Response::HTTP_CONFLICT),
            '*' => Http::response(['result' => []], Response::HTTP_CONFLICT),
        ]);
        $this->assertEquals(Entity::count(), 0, 'no entities');
        $this->artisan('entities:import')
            ->doesntExpectOutput('Entries fetched and saved successfully.')
            ->assertExitCode(Command::FAILURE);
        $this->assertEquals(Entity::count(), 0, 'Entity empty');
    }
}
