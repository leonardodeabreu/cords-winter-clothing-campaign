<?php

namespace App\Api\Auth\Providers;

use App\Api\Auth\Services\AuthRoleService;
use Illuminate\Support\ServiceProvider;

class AuthRoleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return void
     */
    public function provides()
    {
        //return ['auth_role'];
    }
}
