<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => '/api'], function () use ($router) {

    $router->group(['prefix' => '/v1'], function () use ($router) {

        $router->get('/', function () use ($router) {
            $appVersion = $router->app->version();
            return response()->json([
                'message' => 'Welcome to Dynamic Form service with ' . $appVersion,
                'date' => date('Y-m-d'),
            ], 200);
        });

        $router->get('/key', function () {
            return \Illuminate\Support\Str::random(32);
        });

    });

});