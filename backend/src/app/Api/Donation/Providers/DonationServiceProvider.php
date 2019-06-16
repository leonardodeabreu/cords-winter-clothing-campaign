<?php

namespace App\Api\Donation\Providers;

use App\Api\Donation\Interfaces\DonationRepositoryInterface;
use App\Api\Donation\Models\DonationModel;
use App\Api\Donation\Observers\DonationObserver;
use App\Api\Donation\Repositories\DonationRepository;
use Illuminate\Support\ServiceProvider;

class DonationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       DonationModel::observe(DonationObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            DonationRepositoryInterface::class,
            DonationRepository::class
        );
    }
}
