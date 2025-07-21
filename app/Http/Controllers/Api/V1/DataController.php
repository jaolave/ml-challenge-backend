<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\JsonDataService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    // Whitelist of allowed resources to prevent unwanted access.
    private array $allowedResources = [
        'products',
        'sellers',
        'payment_methods',
        'product_offers',
        'questions',
        'reviews',
    ];

    public function __construct(protected JsonDataService $dataService)
    {
        // We inject the service in the constructor so it's available in all methods.
    }

    /**
     * Shows a list of a resource.
     * GET /api/v1/{resource}
     */
    public function index(string $resource): JsonResponse
    {
        if (!in_array($resource, $this->allowedResources)) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $data = $this->dataService->getAll($resource);

        return response()->json($data);
    }

    /**
     * Shows a single item of a resource by its ID.
     * GET /api/v1/{resource}/{id}
     */
    public function show(string $resource, int $id): JsonResponse
    {
        if (!in_array($resource, $this->allowedResources)) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $item = $this->dataService->findById($resource, $id);

        if (!$item) {
            return response()->json(['message' => 'Item not found in this resource'], 404);
        }

        return response()->json($item);
    }
}
