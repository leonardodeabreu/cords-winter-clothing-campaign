<?php

namespace App\Api\User\Providers;

use App\Api\User\Interfaces\UserRepositoryInterface;
use App\Api\User\Models\UserModel;
use App\Api\User\Observers\UserObserver;
use App\Api\User\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       UserModel::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
