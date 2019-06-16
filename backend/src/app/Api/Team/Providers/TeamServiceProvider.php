<?php

namespace App\Api\Team\Providers;

use App\Api\Team\Interfaces\TeamRepositoryInterface;
use App\Api\Team\Models\TeamModel;
use App\Api\Team\Repositories\TeamRepository;
use App\Api\Team\Observers\TeamObserver;
use Illuminate\Support\ServiceProvider;

class TeamServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        TeamModel::observe(TeamObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TeamRepositoryInterface::class,
            TeamRepository::class
        );
    }
}
