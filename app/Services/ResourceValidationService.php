<?php

namespace App\Services;

class ResourceValidationService
{
    private array $allowedResources;

    public function __construct()
    {
        $this->allowedResources = config('resources.allowed', []);
    }

    /**
     * Check if a resource is allowed.
     *
     * @param string $resource
     * @return bool
     */
    public function isAllowed(string $resource): bool
    {
        $caseSensitive = config('resources.validation.case_sensitive', false);

        if (!$caseSensitive) {
            $resource = strtolower($resource);
            $allowedResources = array_map('strtolower', $this->allowedResources);
            return in_array($resource, $allowedResources);
        }

        return in_array($resource, $this->allowedResources);
    }

    /**
     * Get all allowed resources.
     *
     * @return array
     */
    public function getAllowedResources(): array
    {
        return $this->allowedResources;
    }

    /**
     * Add a new allowed resource.
     *
     * @param string $resource
     * @return void
     */
    public function addResource(string $resource): void
    {
        if (!$this->isAllowed($resource)) {
            $this->allowedResources[] = $resource;
        }
    }

    /**
     * Remove a resource from allowed list.
     *
     * @param string $resource
     * @return void
     */
    public function removeResource(string $resource): void
    {
        $this->allowedResources = array_filter(
            $this->allowedResources,
            fn($item) => $item !== $resource
        );
    }
}
