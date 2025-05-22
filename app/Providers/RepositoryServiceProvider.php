<?php

namespace App\Providers;

use App\Repositories\Product\ProductFavoriteRepository;
use App\Repositories\Product\ProductFavoriteRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            ProductFavoriteRepositoryInterface::class,
            ProductFavoriteRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
