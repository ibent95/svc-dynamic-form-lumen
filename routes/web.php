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
    ['prefix' => '/api/v1'], function () use ($router) {

        $router->get('/', 'V1\MainQueryController@index');

        $router->get('/key', function () {
            return \Illuminate\Support\Str::random(32);
        });

        $router->group(['prefix' => '/publications'], function () use ($router) {

            $router->get('/', 'V1\PublicationQueryController@index');

        });

        $router->group(['prefix' => '/configurations'], function () use ($router) {

            $router->get('/publication-form', 'V1\Configurations\PublicationFormQueryController@index');
            $router->get('/publication-forms', 'V1\Configurations\PublicationFormQueryController@getAll');
            $router->get('/publication-forms/{uuid}', 'V1\Configurations\PublicationFormQueryController@detail');
            $router->get('/publication-forms/publication-form-versions/{uuid}', 'V1\Configurations\PublicationFormQueryController@getAllByFormVersionUuid');

            $router->get('/publication-form-version', 'V1\Configurations\PublicationFormVersionQueryController@index');
            $router->get('/publication-form-versions', 'V1\Configurations\PublicationFormVersionQueryController@getAll');
            $router->get('/publication-form-versions/{uuid}', 'V1\Configurations\PublicationFormVersionQueryController@detail');
            $router->get('/publication-form-versions/{uuid}/publication-forms', 'V1\Configurations\PublicationFormVersionQueryController@getFormsByUuid');
            $router->post('/publication-form-versions', 'V1\Configurations\PublicationFormVersionCommandController@save');
            $router->put('/publication-form-versions', 'V1\Configurations\PublicationFormVersionCommandController@save');
            $router->post('/publication-form-versions/{uuid}/disable', 'V1\Configurations\PublicationFormVersionCommandController@disable');

        });

    }
);