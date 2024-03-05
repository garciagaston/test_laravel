<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $api
 * @property string $description
 * @property string $link
 * @property int $category_id
 * @property object $category
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class EntityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $category = $this->category;
        return [
            'id' => $this->id,
            'api' => $this->api,
            'description' => $this->description,
            'link' => $this->link,
            'category_id' => $this->category_id,
            'category' => optional($category)->id ? (new CategoryResource($category))->toArray(new Request()) : null,
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
            'deleted_at' => optional($this->deleted_at)->toDateTimeString(),
        ];
    }
}
