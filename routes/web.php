<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here you can register all of the routes for your application.
| It's simple. Just tell Lumen the URIs it should respond to,
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/stock/metrics', 'StockController@metrics');

    $router->group(['middleware' => 'AuthenticateAdmin'], function () use ($router) {
        $router->post('/users/collaborators', 'UserController@store');
        $router->delete('/users/collaborators/{uuid}', 'UserController@destroy');
        $router->delete('/products/{uuid}', 'ProductController@destroy');
        $router->post('/products', 'ProductController@store');
        $router->post('/providers', 'ProviderController@store');
        $router->put('/providers/{uuid}', 'ProviderController@update');
        $router->delete('/providers/{uuid}', 'ProviderController@destroy');
        $router->get('/providers/export', 'ProviderController@export'); 
        $router->get('/products/export/category/{category_id}', 'ProductController@export');
        $router->post('/categories', 'CategoryController@store');
        $router->put('/categories/{uuid}', 'CategoryController@update');
        $router->delete('/categories/{uuid}', 'CategoryController@destroy');
    });

    $router->put('/users/{uuid}/edit', 'UserController@update');
    $router->get('/users/collaborators', 'UserController@index');
    $router->get('/products', 'ProductController@index');
    $router->get('/products/{uuid}', 'ProductController@show');
    $router->put('/products/{uuid}', 'ProductController@update');
    $router->put('/products/{uuid}/quantity', 'ProductController@updateQuantity');
    $router->get('/providers', 'ProviderController@index');
    $router->get('/providers/{uuid}', 'ProviderController@show');
    $router->get('/categories', 'CategoryController@index');
    $router->get('/categories/{uuid}', 'CategoryController@show');
});
