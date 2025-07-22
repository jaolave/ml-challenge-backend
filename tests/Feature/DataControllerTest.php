<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class DataControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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
    public function it_can_get_all_products()
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertNotNull($data);
        $this->assertIsArray($data);
    }

    /** @test */
    public function it_can_get_all_sellers()
    {
        $response = $this->getJson('/api/v1/sellers');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertNotNull($data);
        $this->assertIsArray($data);
    }

    /** @test */
    public function it_can_get_all_payment_methods()
    {
        $response = $this->getJson('/api/v1/payment_methods');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertNotNull($data);
    }

    /** @test */
    public function it_can_get_all_product_offers()
    {
        $response = $this->getJson('/api/v1/product_offers');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_get_all_questions()
    {
        $response = $this->getJson('/api/v1/questions');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_get_all_reviews()
    {
        $response = $this->getJson('/api/v1/reviews');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_404_for_non_allowed_resource()
    {
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Resource not found'
                ]);
    }

    /** @test */
    public function it_returns_404_for_completely_unknown_resource()
    {
        $response = $this->getJson('/api/v1/unknown_resource');

        $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Resource not found'
                ]);
    }

    /** @test */
    public function it_can_get_specific_product_by_id()
    {
        $response = $this->getJson('/api/v1/products/1');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'id',
                    'title'
                ])
                ->assertJson([
                    'id' => 1
                ]);
    }

    /** @test */
    public function it_can_get_specific_payment_method_by_key()
    {
        $response = $this->getJson('/api/v1/payment_methods/1');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertNotNull($data);
    }

    /** @test */
    public function it_returns_404_for_non_existing_item_id()
    {
        $response = $this->getJson('/api/v1/products/999999');

        $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Item not found in this resource'
                ]);
    }

    /** @test */
    public function it_returns_404_for_item_in_non_allowed_resource()
    {
        $response = $this->getJson('/api/v1/users/1');

        $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Resource not found'
                ]);
    }

    /** @test */
    public function it_handles_case_insensitive_resource_names()
    {
        $response = $this->getJson('/api/v1/PRODUCTS');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_get_seller_by_id()
    {
        $response = $this->getJson('/api/v1/sellers/1');

        $response->assertStatus(200);

        $data = $response->json();
        $this->assertNotNull($data);
        $this->assertArrayHasKey('name', $data);
    }

    /** @test */
    public function it_handles_different_data_formats_correctly()
    {
        // Test object format (products, sellers, etc.)
        $productsResponse = $this->getJson('/api/v1/products');
        $productsResponse->assertStatus(200);

        // Test object format (payment_methods)
        $paymentMethodsResponse = $this->getJson('/api/v1/payment_methods');
        $paymentMethodsResponse->assertStatus(200);

        // Both should return valid JSON data
        $this->assertNotNull($productsResponse->json());
        $this->assertNotNull($paymentMethodsResponse->json());
    }

    /** @test */
    public function it_validates_resource_parameter_format()
    {
        // Test with invalid characters (should not match route)
        $response = $this->getJson('/api/v1/products-with-dashes');

        // This should return 404 because the route pattern doesn't allow dashes
        $response->assertStatus(404);
    }

    /** @test */
    public function it_validates_id_parameter_as_numeric()
    {
        // Test with a valid numeric ID
        $response = $this->getJson('/api/v1/products/1');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_all_allowed_resources()
    {
        $allowedResources = ['products', 'sellers', 'payment_methods', 'product_offers', 'questions', 'reviews'];

        foreach ($allowedResources as $resource) {
            $response = $this->getJson("/api/v1/{$resource}");
            $response->assertStatus(200, "Failed to access resource: {$resource}");
        }
    }

    /** @test */
    public function it_handles_string_ids_correctly()
    {
        // Test with string ID (should work with products)
        $response = $this->getJson('/api/v1/products/1');
        $response->assertStatus(200);

        // Test with non-existing string ID
        $response = $this->getJson('/api/v1/products/999');
        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_consistent_json_structure()
    {
        // Test that all resources return consistent JSON responses
        $response = $this->getJson('/api/v1/products');
        $response->assertStatus(200)
                ->assertHeader('Content-Type', 'application/json');

        $response = $this->getJson('/api/v1/sellers');
        $response->assertStatus(200)
                ->assertHeader('Content-Type', 'application/json');
    }
}
