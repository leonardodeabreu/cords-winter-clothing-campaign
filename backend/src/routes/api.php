<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('/auth/login', '\App\Api\Auth\Controllers\AuthController@login');
    $api->get('/auth/refresh-token', '\App\Api\Auth\Controllers\AuthController@refreshToken');

    $api->group(['prefix' => 'team'], function ($api) {
        $api->get('/', '\App\Api\Team\Controllers\TeamController@index');
        $api->get('/{id}', '\App\Api\Team\Controllers\TeamController@show')->where('id', '[0-9]+');
    });

    $api->group(['prefix' => 'player'], function ($api) {
        $api->get('/', '\App\Api\Players\Controllers\PlayerController@index');
        $api->get('/show', '\App\Api\Players\Controllers\PlayerController@show');
        $api->get('/import', '\App\Api\Players\Controllers\PlayerController@import');
    });

    $api->group(['prefix' => 'donation'], function ($api) {
        $api->get('/', '\App\Api\Donation\Controllers\DonationController@index');
        $api->get('/{id}', '\App\Api\Donation\Controllers\DonationController@show')->where('id', '[0-9]+');
        $api->get('/allKilos', '\App\Api\Donation\Controllers\DonationController@allKilos');
        $api->get('/byTeam', '\App\Api\Donation\Controllers\DonationController@byTeam');

    });

    $api->group(['middleware' => 'api.auth'], function ($api) {
        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->get('/auth/logout', '\App\Api\Auth\Controllers\AuthController@logout');
            $api->get('/auth/user-info/{token}', '\App\Api\Auth\Controllers\AuthController@getUserInfoByToken');

            $api->group(['prefix' => 'user'], function ($api) {
                $api->get('/', '\App\Api\User\Controllers\UserController@index');
                $api->get('/{id}', '\App\Api\User\Controllers\UserController@show')->where('id', '[0-9]+');
            });

            $api->group(['prefix' => 'team'], function ($api) {
                $api->put('/{id}', '\App\Api\Team\Controllers\TeamController@update')->where('id', '[0-9]+');
                $api->post('/', '\App\Api\Team\Controllers\TeamController@store');
                $api->delete('/{id}', '\App\Api\Team\Controllers\TeamController@destroy')->where('id', '[0-9]+');
            });

            $api->group(['prefix' => 'player'], function ($api) {
                $api->put('/{rfid}', '\App\Api\Players\Controllers\PlayerController@update');
                $api->post('/', '\App\Api\Players\Controllers\PlayerController@store');
                $api->delete('/{rfid}', '\App\Api\Players\Controllers\PlayerController@delete');
            });

            $api->group(['prefix' => 'donation'], function ($api) {
                $api->post('/', '\App\Api\Donation\Controllers\DonationController@store');

            });
        });
    });
});
