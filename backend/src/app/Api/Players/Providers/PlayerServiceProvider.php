<?php

namespace App\Api\Players\Providers;

use App\Api\Players\Interfaces\PlayerRepositoryInterface;
use App\Api\Players\Models\PlayerModel;
use App\Api\Players\Repositories\PlayerRepository;
use App\Api\Players\Observers\PlayerObserver;
use Illuminate\Support\ServiceProvider;

class PlayerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        PlayerModel::observe(PlayerObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PlayerRepositoryInterface::class,
            PlayerRepository::class
        );
    }
}
