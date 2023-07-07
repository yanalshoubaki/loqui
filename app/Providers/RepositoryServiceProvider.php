<?php

namespace App\Providers;

use App\Interfaces\UserFollowerRepositoryInterface;
use App\Interfaces\UserFollowingRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserFollowerRepository;
use App\Repositories\UserFollowingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserFollowingRepositoryInterface::class, UserFollowingRepository::class);
        $this->app->bind(UserFollowerRepositoryInterface::class, UserFollowerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
