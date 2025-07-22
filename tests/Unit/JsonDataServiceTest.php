<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\JsonDataService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JsonDataServiceTest extends TestCase
{
    private JsonDataService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new JsonDataService();

        // Clear cache before each test
        Cache::flush();
    }

    protected function tearDown(): void
    {
        // Clear cache after each test
        Cache::flush();
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_all_records_from_existing_resource()
    {
        $result = $this->service->getAll('products');

        $this->assertNotNull($result);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }

    /** @test */
    public function it_returns_null_for_non_existing_resource()
    {
        $result = $this->service->getAll('non_existing_resource');

        $this->assertNull($result);
    }

    /** @test */
    public function it_can_find_record_by_id_in_object_format()
    {
        // Using products which uses object keys as IDs
        $result = $this->service->findById('products', '1');

        $this->assertNotNull($result);
        $this->assertEquals(1, $result->id);
    }

    /** @test */
    public function it_can_find_record_by_key_in_payment_methods()
    {
        // Using payment_methods which uses object keys as IDs
        $result = $this->service->findById('payment_methods', '1');

        $this->assertNotNull($result);
    }

    /** @test */
    public function it_returns_null_when_id_not_found()
    {
        $result = $this->service->findById('products', 'NON_EXISTING_ID');

        $this->assertNull($result);
    }

    /** @test */
    public function it_returns_null_when_finding_by_id_in_non_existing_resource()
    {
        $result = $this->service->findById('non_existing_resource', 'some_id');

        $this->assertNull($result);
    }

    /** @test */
    public function it_uses_cache_for_file_data()
    {
        // First call should cache the data
        $result1 = $this->service->getAll('products');

        // Verify cache was set
        $this->assertTrue(Cache::has('json_data_products'));

        // Second call should use cached data
        $result2 = $this->service->getAll('products');

        $this->assertEquals($result1, $result2);
    }

    /** @test */
    public function it_handles_flexible_id_comparison()
    {
        // Test that string '1' matches integer 1
        $result1 = $this->service->findById('products', '1');
        $result2 = $this->service->findById('products', 1);

        $this->assertNotNull($result1);
        $this->assertNotNull($result2);
        $this->assertEquals($result1, $result2);
    }

    /** @test */
    public function it_can_get_all_payment_methods()
    {
        $result = $this->service->getAll('payment_methods');

        $this->assertNotNull($result);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
    }

    /** @test */
    public function it_can_get_all_sellers()
    {
        $result = $this->service->getAll('sellers');

        $this->assertNotNull($result);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
    }

    /** @test */
    public function it_handles_different_resource_types()
    {
        // Test all available resources
        $resources = ['products', 'sellers', 'payment_methods', 'product_offers', 'questions', 'reviews'];

        foreach ($resources as $resource) {
            $result = $this->service->getAll($resource);
            $this->assertNotNull($result, "Failed to get data for resource: {$resource}");
            $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        }
    }
}
