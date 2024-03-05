<?php

namespace Tests\Unit\API;

use App\Http\Resources\EntityResource;
use App\Models\Category;
use App\Models\Entity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class EntitiesApiTest extends TestCase
{
    public function testIndexSuccess(): void
    {
        $count = 50;
        Category::factory()->count(2)->create();
        Entity::factory()->count($count)->create();
        $category = Category::inRandomOrder()->firstOrFail();
        $response = $this->get("/api/{$category->id}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'success' => true,
            'data' => EntityResource::collection($category->entities)->toArray(new Request()),
        ]);
    }

    public function testIndexFailed(): void
    {
        $count = 50;
        Category::factory()->count(2)->create();
        Entity::factory()->count($count)->create();
        $this->expectException(ModelNotFoundException::class);
        $response = $this->get('/api/'.$this->faker->randomNumber());
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'success' => false,
        ]);
    }
}
