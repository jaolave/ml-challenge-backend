<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class JsonDataService
{
    /**
     * Gets all records from a JSON resource.
     *
     * @param string $resourceName The name of the JSON file (without extension).
     * @return \Illuminate\Support\Collection|null
     */
    public function getAll(string $resourceName)
    {
        return $this->getDataFromFile($resourceName);
    }

    /**
     * Finds a record by its ID in a JSON resource.
     *
     * @param string $resourceName
     * @param int|string $id
     * @return object|null
     */
    public function findById(string $resourceName, $id)
    {
        $data = $this->getDataFromFile($resourceName);

        if (!$data) {
            return null;
        }

        // Check if the data is an object with numeric keys (like payment_methods)
        // In this case, the ID is the object key
        if ($data->has($id)) {
            return $data->get($id);
        }

        // If we don't find it by key, we try to search by 'id' property (array format)
        // The '==' is intentional to allow flexible comparison (e.g., '1' == 1).
        return $data->firstWhere('id', '==', $id);
    }

    /**
     * Private method to read, decode and cache file data.
     *
     * @param string $resourceName
     * @return \Illuminate\Support\Collection|null
     */
    private function getDataFromFile(string $resourceName)
    {
        $path = storage_path("app/data/{$resourceName}.json");

        // Good practice! Use cache to avoid reading the file on every request.
        // The cache will be invalidated and reloaded every 60 minutes or if the file is not in cache.
        return Cache::remember("json_data_{$resourceName}", 3600, function () use ($path) {
            if (!File::exists($path)) {
                return null;
            }

            try {
                $json = File::get($path);
                return collect(json_decode($json)); // We return a Laravel Collection
            } catch (FileNotFoundException $e) {
                return null;
            }
        });
    }
}
