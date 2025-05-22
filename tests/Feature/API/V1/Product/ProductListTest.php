<?php

namespace Feature\API\V1\Product;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function visitRoute(array $params = []): TestResponse
    {
       return $this->getJson('/api/v1/products?' . http_build_query($params));
    }

    public function test_guest_can_view_product_list_without_private_fields(): void
    {
        Product::factory()
            ->count(3)
            ->create();

        $response = $this->visitRoute();

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'category',
                        'image_url',
                        'images',
                        'images' => [
                            '*' => [
                                'id',
                                'url',
                                'is_main',
                            ],
                        ],
                    ],
                ],
            ]);

        $response->assertDontSee('is_favorite');
    }

    public function test_auth_user_can_view_product_list_with_private_fields(): void
    {
        $user = User::factory()->create();
        Product::factory()
            ->count(3)
            ->create();

        $this->actingAs($user);

        $response = $this->visitRoute();

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'category',
                        'image_url',
                        'images' => [
                            '*' => [
                                'id',
                                'url',
                                'is_main',
                            ],
                        ],
                        'is_favorite',
                    ],
                ],
            ]);
    }

    public function test_product_list_returns_correct_field_values(): void
    {
        $product = Product::factory()
            ->withImages(4)
            ->withCategories(1)
            ->create();

        $response = $this->visitRoute();

        $response->assertOk();

        $productInList = $response->json('data')[0];

        $this->assertIsInt($productInList['id']);
        $this->assertIsString($productInList['name']);
        $this->assertIsString($productInList['description']);
        $this->assertTrue(is_null($productInList['category']) || is_string($productInList['category']));
        $this->assertTrue(is_null($productInList['image_url']) || filter_var($productInList['image_url'], FILTER_VALIDATE_URL) !== false);
        $this->assertIsArray($productInList['images']);

        $this->assertEquals(count($productInList['images']), count($product->images));
    }

    public function test_product_list_can_be_sorted_by_name_asc(): void
    {
        Product::factory()
            ->create(['name' => 'Zebra']);

        Product::factory()
            ->create(['name' => 'Apple']);

        $response = $this->visitRoute([
            'sort'   => 'name',
            'order'  => 'asc',
        ]);

        $response->assertOk();

        $names = collect($response->json('data'))->pluck('name')->all();
        $this->assertEquals(['Apple', 'Zebra'], $names);
    }

    public function test_product_list_can_be_sorted_by_name_desc(): void
    {
        Product::factory()->create(['name' => 'Zebra']);
        Product::factory()->create(['name' => 'Apple']);

        $response = $this->visitRoute([
            'sort'   => 'name',
            'order'  => 'desc',
        ]);

        $response->assertOk();

        $names = collect($response->json('data'))->pluck('name')->all();
        $this->assertEquals(['Zebra', 'Apple'], $names);
    }

    public function test_product_list_can_be_filtered_by_category_slug(): void
    {
        $product1 = Product::factory()
            ->hasAttached(
                Category::factory()->create(['slug' => 'category-1'])
            )
            ->create();

         Product::factory()
            ->hasAttached(
                Category::factory()->create(['slug' => 'category-2'])
            )
            ->create();


        $response = $this->visitRoute(['category' => 'category-1']);

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $this->assertEquals($product1->id, $response->json('data.0.id'));
    }

    public function test_product_list_can_be_searched_by_name(): void
    {
        Product::factory()->create(['name' => 'Galaxy Watch']);
        Product::factory()->create(['name' => 'iPhone']);

        $response = $this->visitRoute(['query' => 'galaxy']);

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $this->assertEquals('Galaxy Watch', $response->json('data.0.name'));
    }
}
