<?php

namespace App\Providers;


use App\Base\Validations\BaseValidation;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new BaseValidation($translator, $data, $rules, $messages, $customAttributes);
        });
    }
}
