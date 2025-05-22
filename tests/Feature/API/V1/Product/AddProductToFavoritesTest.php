<?php

namespace Feature\API\V1\Product;

use App\Exceptions\Product\FailedAddProductToFavoritesException;
use App\Models\Product\Product;
use App\Models\User;
use App\Repositories\Product\ProductFavoriteRepositoryInterface;
use App\Services\Product\Actions\AddProductToFavoritesAction;
use App\Services\Product\DTO\AddProductToFavoritesDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Mockery;
use Tests\TestCase;

class AddProductToFavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function visitRoute(array $payload = []): TestResponse
    {
        return $this->postJson('/api/v1/products/favorites', $payload);
    }

    public function test_valid_request_passes(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->visitRoute([
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_validation_fails_for_nonexistent_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->visitRoute([
            'product_id' => 999999,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_validation_fails_for_missing_product_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->visitRoute();

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_validation_fails_for_non_integer_product_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->visitRoute([
            'product_id' => 'not-an-int',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_valid_request_adds_product_to_favorites(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->visitRoute([
                'product_id' => $product->id,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('product_favorite', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $listResponse = $this
            ->actingAs($user)
            ->getJson('/api/v1/products');

        $listResponse->assertOk();

        $listResponse->assertJsonFragment([
            'id' => $product->id,
            'is_favorite' => true,
        ]);
    }

    public function test_failed_add_product_to_favorites_throws_exception(): void
    {
        $repository = Mockery::mock(ProductFavoriteRepositoryInterface::class);
        $repository->shouldReceive('add')
            ->once()
            ->andThrow(new \Exception('DB error'));

        $action = new AddProductToFavoritesAction($repository);

        $dto = new AddProductToFavoritesDTO(
            userId: 1,
            productId: 10
        );

        $this->expectException(FailedAddProductToFavoritesException::class);

        $action->run($dto);
    }
}
