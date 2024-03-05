<?php

namespace App\Http\Controllers;

use App\Http\Resources\EntityResource;
use App\Models\Category;
use App\Models\Entity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EntityController extends Controller
{
    public function index(Category $category): AnonymousResourceCollection|JsonResponse
    {
        try {
            $paginatedData = Entity::where('category_id', $category->id)->paginate(50);

            return EntityResource::collection($paginatedData)->additional(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
