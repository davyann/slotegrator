<?php

namespace Feature\API\V1\Product;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProductFavoriteListTest  extends TestCase
{
    use RefreshDatabase;

    public function visitRoute(array $params = []): TestResponse
    {
        return $this->getJson('/api/v1/products/favorites?' . http_build_query($params));
    }

    public function test_only_favorite_products_are_returned(): void
    {
        $user = User::factory()
            ->hasAttached(Product::factory()->count(2), [], 'favoriteProducts')
            ->create();

        $nonFavoriteProduct = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->visitRoute();

        $response->assertOk();
        $data = $response->json('data');

        $this->assertCount(2, $data);

        // Проверим, что non-favorite не попал в выборку
        $this->assertFalse(collect($data)->pluck('id')->contains($nonFavoriteProduct->id));
    }

    public function test_product_favorite_list_returns_correct_field_values(): void
    {
        $product = Product::factory()->create();

        $user = User::factory()
            ->hasAttached($product, [], 'favoriteProducts')
            ->create();

        $this->actingAs($user);

        $response = $this->visitRoute();

        $response->assertOk();

        $productInList = $response->json('data')[0];

        $this->assertIsInt($productInList['id']);
        $this->assertIsString($productInList['name']);
        $this->assertIsString($productInList['description']);
        $this->assertTrue($productInList['is_favorite']);
        $this->assertTrue(is_null($productInList['category']) || is_string($productInList['category']));
        $this->assertTrue(is_null($productInList['image_url']) || filter_var($productInList['image_url'], FILTER_VALIDATE_URL) !== false);
        $this->assertIsArray($productInList['images']);

        $this->assertEquals(count($productInList['images']), count($product->images));
    }

    public function test_product_list_can_be_sorted_by_name_asc(): void
    {
        $product1 = Product::factory()
            ->create(['name' => 'Zebra']);

       $product2 =  Product::factory()
            ->create(['name' => 'Apple']);

        $user = User::factory()
            ->hasAttached([$product1, $product2], [], 'favoriteProducts')
            ->create();

        $this->actingAs($user);

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
        $product1 = Product::factory()
            ->create(['name' => 'Zebra']);

        $product2 =  Product::factory()
            ->create(['name' => 'Apple']);

        $user = User::factory()
            ->hasAttached([$product1, $product2], [], 'favoriteProducts')
            ->create();

        $this->actingAs($user);

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

       $product2 =  Product::factory()
            ->hasAttached(
                Category::factory()->create(['slug' => 'category-2'])
            )
            ->create();

        $user = User::factory()
            ->hasAttached([$product1, $product2], [], 'favoriteProducts')
            ->create();

        $this->actingAs($user);


        $response = $this->visitRoute(['category' => 'category-1']);

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $this->assertEquals($product1->id, $response->json('data.0.id'));
    }

    public function test_product_list_can_be_searched_by_name(): void
    {
        $product1 = Product::factory()->create(['name' => 'Galaxy Watch']);
        $product2 = Product::factory()->create(['name' => 'iPhone']);

        $user = User::factory()
            ->hasAttached([$product1, $product2], [], 'favoriteProducts')
            ->create();

        $this->actingAs($user);

        $response = $this->visitRoute(['query' => 'galaxy']);

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $this->assertEquals('Galaxy Watch', $response->json('data.0.name'));
    }
}
