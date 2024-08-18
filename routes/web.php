<?php

/**
 * Router
 * 
 * @var \Laravel\Lumen\Routing\Router $router
 */

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
$router->group(
    ['prefix' => '/public/api/v1'], function () use ($router) {

        $router->get('/', 'V1\MainQueryController@index');

        $router->get(
            '/key', function () {
                return \Illuminate\Support\Str::random(32);
            }
        );

        $router->group(
            ['prefix' => '/publications'], function () use ($router) {

                $router->get('/', 'V1\PublicationQueryController@index');

            }
        );

    }
);