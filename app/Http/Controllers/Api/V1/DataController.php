<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\JsonDataService;
use App\Services\ResourceValidationService;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    public function __construct(
        protected JsonDataService $dataService,
        protected ResourceValidationService $resourceValidator
    ) {
        // We inject the services in the constructor so they're available in all methods.
    }

    /**
     * Shows a list of a resource.
     * GET /api/v1/{resource}
     */
    public function index(string $resource): JsonResponse
    {
        if (!$this->resourceValidator->isAllowed($resource)) {
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
        if (!$this->resourceValidator->isAllowed($resource)) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $item = $this->dataService->findById($resource, $id);

        if (!$item) {
            return response()->json(['message' => 'Item not found in this resource'], 404);
        }

        return response()->json($item);
    }
}
