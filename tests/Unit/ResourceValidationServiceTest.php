<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ResourceValidationService;

class ResourceValidationServiceTest extends TestCase
{
    private ResourceValidationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ResourceValidationService();
    }

    /** @test */
    public function it_validates_allowed_resources()
    {
        $this->assertTrue($this->service->isAllowed('products'));
        $this->assertTrue($this->service->isAllowed('sellers'));
        $this->assertTrue($this->service->isAllowed('payment_methods'));
        $this->assertTrue($this->service->isAllowed('product_offers'));
        $this->assertTrue($this->service->isAllowed('questions'));
        $this->assertTrue($this->service->isAllowed('reviews'));
    }

    /** @test */
    public function it_rejects_non_allowed_resources()
    {
        $this->assertFalse($this->service->isAllowed('users'));
        $this->assertFalse($this->service->isAllowed('orders'));
        $this->assertFalse($this->service->isAllowed('non_existing'));
    }

    /** @test */
    public function it_handles_case_insensitive_validation_when_configured()
    {
        // Since case_sensitive is false in config, these should work
        $this->assertTrue($this->service->isAllowed('PRODUCTS'));
        $this->assertTrue($this->service->isAllowed('Products'));
        $this->assertTrue($this->service->isAllowed('pRoDuCtS'));
    }

    /** @test */
    public function it_returns_all_allowed_resources()
    {
        $allowedResources = $this->service->getAllowedResources();

        $expectedResources = [
            'products',
            'sellers',
            'payment_methods',
            'product_offers',
            'questions',
            'reviews'
        ];

        $this->assertEquals($expectedResources, $allowedResources);
        $this->assertCount(6, $allowedResources);
    }

    /** @test */
    public function it_can_add_new_resource()
    {
        $newResource = 'categories';

        $this->assertFalse($this->service->isAllowed($newResource));

        $this->service->addResource($newResource);

        $this->assertTrue($this->service->isAllowed($newResource));
        $this->assertContains($newResource, $this->service->getAllowedResources());
    }

    /** @test */
    public function it_does_not_add_duplicate_resources()
    {
        $existingResource = 'products';
        $initialCount = count($this->service->getAllowedResources());

        $this->service->addResource($existingResource);

        $this->assertEquals($initialCount, count($this->service->getAllowedResources()));
    }

    /** @test */
    public function it_can_remove_existing_resource()
    {
        $resourceToRemove = 'products';

        $this->assertTrue($this->service->isAllowed($resourceToRemove));

        $this->service->removeResource($resourceToRemove);

        $this->assertFalse($this->service->isAllowed($resourceToRemove));
        $this->assertNotContains($resourceToRemove, $this->service->getAllowedResources());
    }

    /** @test */
    public function it_handles_removing_non_existing_resource_gracefully()
    {
        $nonExistingResource = 'non_existing_resource';
        $initialCount = count($this->service->getAllowedResources());

        $this->service->removeResource($nonExistingResource);

        $this->assertEquals($initialCount, count($this->service->getAllowedResources()));
    }

    /** @test */
    public function it_can_add_and_remove_multiple_resources()
    {
        $newResources = ['categories', 'brands', 'attributes'];

        // Add multiple resources
        foreach ($newResources as $resource) {
            $this->service->addResource($resource);
        }

        // Verify they were added
        foreach ($newResources as $resource) {
            $this->assertTrue($this->service->isAllowed($resource));
        }

        // Remove them
        foreach ($newResources as $resource) {
            $this->service->removeResource($resource);
        }

        // Verify they were removed
        foreach ($newResources as $resource) {
            $this->assertFalse($this->service->isAllowed($resource));
        }
    }

    /** @test */
    public function it_preserves_original_resources_after_modifications()
    {
        $originalResources = $this->service->getAllowedResources();

        // Add and remove some resources
        $this->service->addResource('test_resource');
        $this->service->removeResource('products');
        $this->service->addResource('another_test');

        // Remove the test resources and add back the original
        $this->service->removeResource('test_resource');
        $this->service->removeResource('another_test');
        $this->service->addResource('products');

        $finalResources = $this->service->getAllowedResources();

        // Should have all original resources
        foreach ($originalResources as $resource) {
            $this->assertContains($resource, $finalResources);
        }
    }
}
